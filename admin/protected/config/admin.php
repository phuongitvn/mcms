<?php
/**
 * Created by PhpStorm.
 * User: phuongnv
 * Date: 3/17/2015
 * Time: 8:43 PM
 */
return CMap::mergeArray(
    require_once SITE_PATH.DS.'common'.DS.'config'.DS.'common.php',
    array(
        'basePath'=>dirname(__FILE__).DS.'..',
        'name'=>'Admin Control Panel',
        'theme'=>'default',
        'defaultController'=>'site',
        'language'=>'en',
        'preload'=>array('log'),
        'import'=>array(
            'application.components.*',
            'application.models.*',
            'application.widgets.CActiveForm',
            'application.widgets.CHtml',
            'application.widgets._base.*',
        ),
        'modules'=>array(
            'genre',
            'articles',
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password'=>'111',
                'generatorPaths' => array(
                    'ext.giix-core', // giix generators
                ),
                'ipFilters'=>array('127.0.0.1','::1'),
            ),
        ),
        'components'=>array(
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
            ),
            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'site/error',
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
    )
);