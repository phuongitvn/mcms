<?php
class AvatarHelper {

	public static function processAvatar($id, $source, $type = "blog") {

		$fileSystem = new Filesystem();
		$alowSize = Yii::app()->params['imageSize']["$type"];
		$maxSize = max($alowSize);
		$folderMax = "s0";
		$pathDir = Yii::app()->params[$type.'_path'];
		foreach ($alowSize as $folder => $size) {
			// Create folder by ID
			$avatarPath = self::getAvatarPath($id, $folder, true, $pathDir);
			$fileSystem->mkdirs($avatarPath);
			@chmod($avatarPath, 0777);

			// Get link file by ID
			$savePath[$folder] = self::getAvatarPath($id, $folder, false, $pathDir);
			if ($size == $maxSize) {
				$folderMax = $folder;
			}
		}

		// Delete file if exists
		if (file_exists($savePath[$folder])) {
			$fileSystem->remove($savePath);
		}

		if (file_exists($source)) {
			list($width, $height) = getimagesize($source);
			$imgCrop = new ImageCrop($source, 0, 0, $width, $height);

			// aspect ratio for image size
			$aspectRatioW = $aspectRatioH = 1;

			foreach ($savePath as $k => $v) {
				$desWidth = $alowSize[$k];
				$desHeight = round($alowSize[$k] * intval($aspectRatioH) / intval($aspectRatioW));
				if (file_exists($v) && is_file($v)) {
					@unlink($v);
				}

				if ($k == $folderMax) {
					$imgCrop->resizeRatio($v, $desWidth, $desHeight, 100);
				} else {
					$imgCrop->resizeCrop($v, $desWidth, $desHeight, 100);
				}
			}
			//remove file source
			$fileSystem->remove($source);
		}
	}

	public static function getAvatar($type, $id, $size = null) {
		$src = Common::storageSolutionEncode($id) . $id . ".jpg";
		$dir = "s0";
		$alowSize = Yii::app()->params['imageSize'];

		if(is_numeric($size)){
			foreach ($alowSize as $folder => $s) {
				$dir = $folder;
				if ($s >= $size)
					break;
			}
		}else{
			$dir = $size;
		}


		if ($type == "video") {
			$dir = "img/" . $dir;
			$configName = "videoImageUrl";
		} else {
			$configName = $type . "Url";
		}
		return Yii::app()->params['storage'][$configName] . "/" . $dir . "/" . $src;
	}

	public static function getAvatarJs() {
		$rs = 'var avatarPrefixUrl={};';

		foreach (Yii::app()->params['storage'] as $type => $prefix) {
			if (!strpos($type, 'Dir')){
				$rs.='avatarPrefixUrl["' . $type . '"]="' . $prefix . '";';
			}
		}
		$rs.='function avatarObject(type,id){
                    if(type === "video"){
                        type = "videoImage";
                    }
    	            var result="",level= 0;
    	    		while(true){
    	                var shift   = 13*level;
    	                var layerName  = shift<=32?id >> shift:0;
    	        		if(layerName == 0) break;
    	                result = layerName+"/"+result;
    	                level++;
    	    		}
                    return avatarPrefixUrl[type+"Url"]+(type=="videoImage" ? "/img/s3/" : "s3/") + result+id + ".jpg";
        	}';
		return $rs;
	}
	public static function getAvatarPath($id,$size=150,$isFolder = false, $pathDir='')
	{
		if(!isset($id)) $id = 0;
		if($isFolder){
			$savePath = StorageHelper::storageSolutionEncode($id);
		}else{
			$savePath = StorageHelper::storageSolutionEncode($id).$id.".jpg";
		}
		$savePath = StorageHelper::storageSolutionEncode($id).$id.".jpg";
		$path = $pathDir.DS.$size.DS.$savePath;
		return $path;
	}
	
	public static function getAvatarUrl($id=null, $size="s1", $type="blog")
	{
		$pathUrl = Yii::app()->params[$type."_url"];
		if(!isset($id)) $id = 0;
		return $pathUrl.'/'.$size.'/'.$id.'/'.$id.".jpg?v=".time();
	}
	public static  function getSavedName($itemId, $itemPerDir = 1024) {
		$dir1 = floor($itemId / ($itemPerDir * $itemPerDir * $itemPerDir));
		$dir2 = floor(($itemId - $dir1 * $itemPerDir * $itemPerDir * $itemPerDir) / ($itemPerDir * $itemPerDir));
		$temp = floor($itemId / ($itemPerDir * $itemPerDir));
		$dir3 = floor(($itemId - $temp * $itemPerDir * $itemPerDir) / $itemPerDir);
		$path = $dir1 . "/" . $dir2 . "/" . $dir3;
		return $path;
	}
}