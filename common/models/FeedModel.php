<?php
class FeedModel extends BaseFeedModel
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function processThumb($imgsrc,$_id)
    {
        $_id = empty($_id)?$this->_id:$_id;
        $storage = Yii::app()->params['feed_path'];
        $temp = Yii::app()->params['temp'];
        $fileInfo = explode('.',$imgsrc);
        $fileType = $fileInfo[count($fileInfo)-1];
        $fileName = 'tmp_'.$_id.".".$fileType;
        $tmpFile = $temp.DS.$fileName;

        $res_get_file = FileRemote::getFromUrl($imgsrc,$tmpFile);
        if ($res_get_file && file_exists($tmpFile)) {
            $fileDest = StorageHelper::generalStoragePath($_id,$fileType,$storage);
            $fileSystem = new Filesystem();
            $copy = $fileSystem->copy($tmpFile,$fileDest);
            if($copy){
                $feed = self::model()->findByPk(new MongoId($_id));
                $fileDest = str_replace($storage,'',$fileDest);
                $feed->thumb = $fileDest;
                $res = $feed->save();
                return $res;
            }
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