<?php
class FeedModel extends BaseFeedModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function processThumb($imgsrc,$_id,$isUrl=true)
    {
        $_id = empty($_id)?$this->_id:$_id;
        $storage = Yii::app()->params['feed_path'];
        $temp = Yii::app()->params['temp'];
        $fileInfo = explode('.',$imgsrc);
        $fileType = $fileInfo[count($fileInfo)-1];
        $fileName = 'tmp_'.$_id.".".$fileType;
        $tmpFile = $temp.DS.$fileName;
        if($isUrl){
            $res_get_file = FileRemote::getFromUrl($imgsrc,$tmpFile);
        }else{
            $fileSystem = new Filesystem();
            $res_get_file = $fileSystem->copy($imgsrc,$tmpFile);

        }
        if (file_exists($tmpFile)) {
            $fileDest = StorageHelper::generalStoragePath($_id,$fileType,$storage);
            /*$fileSystem = new Filesystem();
            $copy = $fileSystem->copy($tmpFile,$fileDest);*/

            $width = Yii::app()->params['profile_image']['thumb']['width'];
            $height = Yii::app()->params['profile_image']['thumb']['height'];
            $resizeObj = new ResizeImage($tmpFile);
            $rs = $resizeObj->resizeImage($width, $height, 0);
            $res = $resizeObj->saveImage($fileDest, 100);
            if($resizeObj){
                $feed = self::model()->findByPk(new MongoId($_id));
                $fileDest = str_replace($storage,'',$fileDest);
                $feed->thumb = $fileDest;
                $res = $feed->save();
                return $res;
            }
        }else{
            throw new Exception("create file temp error!", 7);
        }
    }
    public function getAvatarUrl($img){
        if(empty($img)){
            return SITE_ADMIN_URL.'/images/default.png';
        }
        $urlFile = str_replace(DS,'/',$img);
        return Yii::app()->params['cdn_url'].$urlFile;
    }
}