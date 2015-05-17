<?php
return array(
	'params'=>array(
        'storage'       =>'E:\source\storage\\',
        'temp'          =>'E:\source\storage\tmp\\',
        'feed_path'     =>'E:\source\storage\feed\\',
        'cdn_url'      =>'http://localhost:1111',
		'site_url'		=>	SITE_URL,
		'site_path'		=>	SITE_PATH,
		'storage_path'	=>	SITE_PATH.DS.'storage',
		'storage_url'	=>	SITE_URL.'/storage',
		'gallery_path'	=>	SITE_PATH.DS.'storage'.DS.'gallery',
		'gallery_url'	=>	SITE_URL.'/storage/gallery',
		'shop_path'		=>	SITE_PATH.DS.'storage'.DS.'productimages',
		'shop_url'		=>	SITE_URL.'/storage/productimages',
		'files_path'	=> 	SITE_PATH.DS.'storage'.DS.'files',
		'files_url'		=>	SITE_URL.'/storage/files',
		'news_path'		=> 	SITE_PATH.DS.'storage'.DS.'news',
		'news_url'		=>	SITE_URL.'/storage/news',
		'blog_path'		=> 	SITE_PATH.DS.'storage'.DS.'blog',
		'blog_url'		=>	SITE_URL.'/storage/blog',
        'profile_image'=>array(
            'thumb'=>array('width'=>150,'height'=>100)
        ),
		'images_available'=>array(
			'full'=>array(
				'width'=>600,
				'height'=>450
			),
			'thumb'=>array(
				'width'=>180,
				'height'=>120
			),
			'type'=>array(
				'image/png'=>'png',
				'image/gif'=>'gif',
				'image/jpg'=>'jpg',
				'image/jpeg'=>'jpg'
			)
		),
		'shop'=> array(
			'images'=> array(
				's'=>array(
						'width'=>130,
						'height'=>130
				),
				'l'=>array(
						'width'=>300,
						'height'=>550
				),
				'm'=>array(
						'width'=>500,
						'height'=>550
				),
			),
			'category_thumb_width'=>835,
			'category_thumb_height'=>271,
		),
		'tmp_upload'=>SITE_PATH.DS.'storage'.DS.'tmp'.DS,
		'imageSize'=>array(
				'news'=>array('s0'=>620,'s1'=>200),
				'blog'=>array('s0'=>600,'s1'=>220),
				),
		'adminEmail'	=>	'phuong.nguyen.itvn@gmail.com',
	),
);
