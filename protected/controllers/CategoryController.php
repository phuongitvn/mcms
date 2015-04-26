<?php
class CategoryController extends Controller
{
    public $layout='2column';
    public function actionIndex()
    {
        $this->render('index');
    }
}