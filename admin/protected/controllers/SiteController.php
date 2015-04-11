<?php
class SiteController extends AdminController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}