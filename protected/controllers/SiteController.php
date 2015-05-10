<?php

class SiteController extends Controller
{
	public $layout='3column';

    public function actionTest()
    {
        $limit = 10;
        $offset = 0;
        $c = array(
            'conditions'=>array(
                'status'=>array('==' => 1),
                'updated_datetime'=>array('>=' => '2015-04-12 00:00:00','<='=>'2015-05-01 00:00:00'),
            ),
            'sort'=>array('updated_datetime'=>EMongoCriteria::SORT_ASC),
            'limit'=> $limit,
            'offset'=> $offset
        );
        $data = FeedModel::model()->findAll($c);
        foreach($data as $key => $value){
            echo $value->updated_datetime;
            echo '<br />';
        }
        echo '<pre>';print_r($data);
        exit;
    }
    public function actionIndex()
    {
        $c = array(
            'conditions'=>array(
                'status'=>array('==' => 1),
            ),
        );

        $total = WebArticlesModel::model()->count($c);
        $pager = new CPagination($total);
        $itemOnPaging = 5;
        $pager->pageSize = 10;
        $curr_page = $pager->getCurrentPage();

        $limit = $pager->getLimit();
        $offset = $pager->getOffset();

        $c = array(
            'conditions'=>array(
                'status'=>array('==' => 1),
            ),
            'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
            'limit'=> $limit,
            'offset'=> $offset
        );
        $data = FeedModel::model()->findAll($c);
        $this->render('index', compact('data','pager','itemOnPaging'));
    }
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
