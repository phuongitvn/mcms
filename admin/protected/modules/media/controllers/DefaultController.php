<?php

class DefaultController extends BackendApplicationController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}