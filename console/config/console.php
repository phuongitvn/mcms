<?php
/**
 * Created by PhpStorm.
 * User: NGUYEN NGOC BAO AN
 * Date: 3/7/2015
 * Time: 2:24 PM
 */
include_once SITE_PATH.'/console/components/simple_html_dom.php';
return CMap::mergeArray(
	require_once SITE_PATH.DS.'common/config/common.php',
	array(
	    'basePath'=>dirname(__FILE__).DS.'..',
	    'name'=>'MCMS Console',
	    'import'=>array(
	        'console.components.*',
	    	'console.components.crawl._base.*',
	    	'console.components.crawl.*',
	    	'console.models.*',
            'common.vendors.utilities.*'
	    ),
	)
);