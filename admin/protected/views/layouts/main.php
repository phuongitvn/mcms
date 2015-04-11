<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    <link type="image/x-icon" rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" >
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.min.js');
    //$cs->registerCoreScript('jquery');
    $dir = Yii::getPathOfAlias('common').DS.'libs/bootstrap';
    $assets = Yii::app()->assetManager->publish($dir, false, -1, YII_DEBUG);
    $cs->registerScriptFile($assets.'/js/bootstrap.min.js');
    $cs->registerCssFile($assets.'/css/bootstrap.min.css');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/screen.css');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css');
    ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="mongo">
<?php echo $content;?>
</body>
</html>
