<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    include_once SITE_PATH.'/common/config/common.php',
    array(
	'basePath'=>dirname(__FILE__).DS.'..',
	'name'=>'Health Care Tips',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to use a MySQL database
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                '<_c:\w+>/<url_key_cat1:[a-zA-Z0-9-]+>/<url_key:[a-zA-Z0-9-]+>,<id:\w+>' => '<_c>/view',
                '<_c:\w+>/<url_key:[a-zA-Z0-9-]+>,<id:\w+>' => '<_c>/view',
                '<_c:\w+>/<url_key:[a-zA-Z0-9-]+>' => '<_c>/index',
                '<_c:\w+>/<_a:\w+>/<id:\w+>' => '<_c>/<_a>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
			),
            'urlSuffix'		=>	'.html',
            'showScriptName'=>false,
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
));