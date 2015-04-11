<?php
Yii::setPathOfAlias('root', SITE_PATH);
Yii::setPathOfAlias('common', SITE_PATH . DS . 'common');
Yii::setPathOfAlias('frontend', SITE_PATH . DS . 'protected');
Yii::setPathOfAlias('console', SITE_PATH . DS . 'console');
Yii::setPathOfAlias('admin', SITE_PATH . DS . 'admin');
//Yii::setPathOfAlias('system', dirname(dirname(dirname(__FILE__))) . DS . 'common'.DS.'libs'.DS.'framework');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return 
	array(
	// application components
	'components'=>array(
		'mongodb' => array(
			'class'            => 'EMongoDB',
			'connectionString' => 'mongodb://localhost',
			'dbName'           => 'howtofeed',
			'fsyncFlag'        => true,
			'safeFlag'         => true,
			'useCursor'        => false
		),
	),
);
