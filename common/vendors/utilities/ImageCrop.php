<?php
class ImageCrop
{
	var $_imgOrig;
	var $_imgFinal;
	var $_showDebug;
	var $_fileName;
	var $_uploadedFilename;
	var $_minWidth;
	var $_minHeight;
	var $_cropX;
	var $_cropY;
	var $_cropWidth;
	var $_cropHeight;

	// initialize  an instance of class ImageCrop
	function ImageCrop($fileName,$cropX,$cropY,$cropWidth,$cropHeight,$debug = false)
	{
		$this->_showDebug = ($debug ? true : false);
		$this->_fileName=$fileName;
		$this->_cropX = $cropX;
		$this->_cropY = $cropY;
		$this->_cropWidth = $cropWidth;
		$this->_cropHeight = $cropHeight;
		/*$this->_minWidth=$minWidth;
		 $this->_minHeight=$minHeight;*/
	}

	// Load an image from a file name
	// return true if success, otherwise false

	function loadImage()
	{
		#echo $this->_fileName."gewgas"; exit;
		// test exits file

		/*$start = gettimeofday();
		 while (!file_exists(trim($this->_fileName)))
		 {
		 $stop = gettimeofday();
		 if ( 1000000 * ($stop['sec'] - $start['sec']) + $stop['usec'] - $start['usec'] > 500000)
		 break;  // wait a moment
		 }*/
		if (!@file_exists($this->_fileName))
		{		 
			$this->_debug('loadImage', "The supplied file name ".$this->_fileName." does not point to a readable file.");
			return false;
		}

        
		$ext  = strtolower($this->_getExtension($this->_uploadedFilename?$this->_uploadedFilename:$this->_fileName));
		$func = "imagecreatefrom$ext";

		if (!@function_exists($func))
		{
			$this->_debug('loadImage', "That file cannot be loaded with the function '$func'.");
			return false;
		}
		
		//$this->_imgOrig = @$func($this->_fileName);

		// convert source to jpeg
        $image_size = getimagesize($this->_fileName);
        $new_width = $image_size[0];
        $new_height = $image_size[1];

        $tmp = imagecreatetruecolor($image_size[0],$image_size[1]);
        $image = @$func($this->_fileName);
        $newFileJpg = "/tmp/".time().".jpg";

        @imagecopyresampled($tmp,$image,0,0,0,0,$new_width,$new_height,$image_size[0],$image_size[1]);
        //imagejpeg($tmp,$this->_fileName.".jpg",100);
        imagejpeg($tmp,$newFileJpg,100);
        // Free up memory
        imagedestroy($tmp);

        $this->_imgOrig = imagecreatefromjpeg($newFileJpg);
        @unlink($newFileJpg);
		
		
		if ($this->_imgOrig == null)
		{
			$this->_debug('loadImage', 'The image could not be loaded.');
			return false;
		}

		return true;
	}

	// save the final image to file
	function saveImage($filename, $quality = 100)
	{
		//imagejpeg('',$filename,$quality);

		if ($this->_imgFinal == null)
		{
			$alert = 'There is no processed image to save.';
			$this->_debug('saveImage', $alert);
			return $alert;
		}

		$ext = strtolower($this->_getExtension($filename));
		$func = "image$ext";
		//$func = "imagejpeg";

		if (!@function_exists($func))
		{
			$alert = "That file cannot be saved with the function '$func'.";
			$this->_debug('saveImage', $alert);
			return $alert;
		}
		
		$saved = false;
		$saved = $func($this->_imgFinal, $filename, $quality);
		
		if ($saved == false)
		{
			$alert = "Could not save the output file '$filename' as a $ext.";
			$this->_debug('saveImage', $alert);
			return $alert;
		}
		return 'crop success';
	}


	// show imge to the screen
	function showImage($type = 'png', $quality = 100)
	{
		if ($this->_imgFinal == null)
		{
			$this->_debug('showImage', 'There is no processed image to show.');
			return false;
		}

		if ($type == 'png')
		{
			echo @header("Content-Type: image/png");
			echo @ImagePNG($this->_imgFinal);
			return true;
		}
		else if ($type == 'jpg' || $type == 'jpeg')
		{
			echo @header("Content-Type: image/jpeg");
			echo @ImageJPEG($this->_imgFinal, '', $quality);
			return true;
		}
		else if($type == 'gif')
		{
			echo @header("Content-Type: image/gif");
			echo @Imagegif($this->_imgFinal);
			return true;
		}
		else
		{
			$this->_debug('showImage', "Could not show the output file as a $type.");
			return false;
		}
	}



	// crop from resource image to final image with the size is arguments
	/* function cropImage($x1,$y1,$width,$height)
	 {
	 $this->_imgFinal = @imagecreatetruecolor($width, $height) or die("Cannot Initialize new GD image stream");
	 imagecopy($this->_imgFinal,$this->_imgOrig, 0, 0, $x1, $y1, $width, $height);
	 if ($this->_imgFinal == null)
	 {
	 $this->_debug('CropImage', 'The image could not be cropped.');
	 return false;
	 }
	 // resize image to size(150,150);
	 if($width !=$this->_minWidth || $height !=$this->_minHeight)
	 {
	 $tmpImage= @imagecreatetruecolor($this->_minWidth,$this->_minHeight);
	 //imagecopyresized($tmpImage, $this->_imgFinal, 0, 0, 0, 0, $this->_minWidth, $this->_minHeight, $width, $height);
	 imagecopyresampled($tmpImage, $this->_imgFinal, 0, 0, 0, 0, $this->_minWidth, $this->_minHeight, $width, $height);
	 $this->_imgFinal= @imagecreatetruecolor($this->_minWidth,$this->_minHeight);
	 imagecopy($this->_imgFinal,$tmpImage,0,0, 0, 0, $this->_minWidth, $this->_minHeight);
	 imagedestroy($tmpImage);
	 }
	 return true;
	 }*/

	function cropImage($desFile, $desWidth, $desHeight, $quality)
	{
		$this->loadImage();
		$this->_imgFinal = @imagecreatetruecolor($this->_cropWidth, $this->_cropHeight) or die("Cannot Initialize new GD image stream");
		imagecopy($this->_imgFinal,$this->_imgOrig, 0, 0, $this->_cropX, $this->_cropY, $this->_cropWidth, $this->_cropHeight);
		if ($this->_imgFinal == null)
		{
			$alert = 'The image could not be cropped.';
			$this->_debug('CropImage', $alert);
			return $alert;
		}
		// resize image to size(150,150);
		if($desWidth != $this->_cropWidth || $desHeight !=$this->_cropHeight)
		{
			$tmpImage = @imagecreatetruecolor($desWidth, $desHeight);
			imagecopyresampled($tmpImage, $this->_imgFinal, 0, 0, 0, 0, $desWidth, $desHeight, $this->_cropWidth, $this->_cropHeight);
			$this->_imgFinal= @imagecreatetruecolor($desWidth, $desHeight);
			imagecopy($this->_imgFinal,$tmpImage,0,0, 0, 0, $desWidth, $desHeight);
			imagedestroy($tmpImage);
		}
		$result = $this->saveImage($desFile, $quality);
		return $result;
	}

	function resizeRatio($desFile, $desWidth, $desHeight, $quality=90)
	{
		$this->loadImage();
		if($desWidth < $this->_cropWidth || $desHeight < $this->_cropHeight){
	        $ratio=max($this->_cropWidth/$desWidth,$this->_cropHeight/$desHeight);
	        $destW = $this->_cropWidth/$ratio;
	        $destH = $this->_cropHeight/$ratio;                
	        $this->_imgFinal = @imagecreatetruecolor($destW,$destH);
	        imagecopyresampled($this->_imgFinal, $this->_imgOrig,0,0,0,0,$destW, $destH,$this->_cropWidth,$this->_cropHeight);
		} else {
			$this->_imgFinal =  $this->_imgOrig;
		}
		$result = $this->saveImage($desFile, $quality);
        return $result;
	}

	function resizeFix($desFile, $desWidth, $desHeight, $quality=90)
	{
		$this->loadImage();
		$this->_imgFinal = @imagecreatetruecolor($this->_cropWidth, $this->_cropHeight) or die("Cannot Initialize new GD image stream");
		imagecopy($this->_imgFinal,$this->_imgOrig, 0, 0, $this->_cropX, $this->_cropY, $this->_cropWidth, $this->_cropHeight);
		if ($this->_imgFinal == null)
		{
			$alert = 'The image could not be cropped.';
			$this->_debug('CropImage', $alert);
			return $alert;
		}
		// resize image to size(150,150);
		if($desWidth != $this->_cropWidth || $desHeight !=$this->_cropHeight)
		{
			$tmpImage = @imagecreatetruecolor($desWidth, $desHeight);
			imagecopyresampled($tmpImage, $this->_imgFinal, 0, 0, 0, 0, $desWidth, $desHeight, $this->_cropWidth, $this->_cropHeight);
			$this->_imgFinal= @imagecreatetruecolor($desWidth, $desHeight);
			imagecopy($this->_imgFinal,$tmpImage,0,0, 0, 0, $desWidth, $desHeight);
			imagedestroy($tmpImage);
		}
		$result = $this->saveImage($desFile, $quality);
		return $result;
	}

	function resizeCrop($desFile, $desWidth, $desHeight, $quality=90)
	{
		$this->loadImage();
		$ratio=min($this->_cropWidth/$desWidth,$this->_cropHeight/$desHeight);
		$srcW = $desWidth*$ratio;
		$srcH = $desHeight*$ratio;
		$srcX = ($this->_cropWidth-$srcW)/2; // Crop From top center
		//$srcY = ($this->_cropHeight-$srcH)/2; // Crop center center
		$srcY = min(($this->_cropHeight-$srcH)/2,0);
		$this->_imgFinal = @imagecreatetruecolor($desWidth, $desHeight);
       
		$res = imagecopyresampled($this->_imgFinal, $this->_imgOrig,0,0,$srcX,$srcY,$desWidth, $desHeight,$srcW,$srcH);
		$result = $this->saveImage($desFile, $quality);
		//$this->showImage(); exit("faf afgaga");
		return $result;
	}


	function _debug($function, $string)
	{
		if ($this->_showDebug)
		{
			echo "<p><strong style=\"color:#FF0000\">Error in function $function:</strong> $string</p>\n";
		}
	}

	function _getExtension($filename)
	{
		$ext  = @strtolower(@substr($filename, (@strrpos($filename, ".") ? @strrpos($filename, ".") + 1 : @strlen($filename)), @strlen($filename)));
		return ($ext == 'jpg') ? 'jpeg' : $ext;
	}

}
?>
