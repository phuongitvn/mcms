<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
include_once '../common/config/define.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');

// remove the following line when in production mode
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_DEBUG') or define('YII_DEBUG',true);

$config=dirname(__FILE__).'/protected/config/dev.php';
require_once($yii);
Yii::createWebApplication($config)->run();
