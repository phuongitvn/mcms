<?php
class SiteController extends AdminController
{
    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionUpload()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder=Yii::app()->params['temp'];// folder for uploaded files
        $allowedExtensions = array("jpg");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
        $fileName=$result['filename'];//GETTING FILE NAME

        echo $return;// it's array
    }
}