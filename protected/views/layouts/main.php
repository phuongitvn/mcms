<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta name="MobileOptimized" content="100" />

    <link rel="canonical" href="<?php echo SITE_URL.Yii::app()->request->url;?>" />
    <meta name="robots" content="follow, index" />
	<title><?php echo CHtml::encode($this->pageTitle)." | ".Yii::app()->name; ?></title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:100,200,300,400,500,600,700,800,900|Oswald:100,200,300,400,500,600,700,800,900|Oswald:100,200,300,400,500,600,700,800,900&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese" type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <!--<script type="text/javascript" src="/js/core.js"></script>-->
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerMetaTag('Funny pics, GIFs, videos, memes, cute', 'title', NULL);
    $cs->registerMetaTag('You are looking at the Fan2Meme.com! Fan2Meme.com is the easiest way to have fun!', 'description', NULL);
    $cs->registerMetaTag('fan2meme,jokes,interesting,cool,fun collection, prank, admire,fun,humor,humour,just for fun.', 'keywords', NULL);

    ?>
</head>
<body class="mobile-screen">
<style>
    @media (min-width: 0px) and (max-width: 600px)  {
        .col-f{
            width: 100%;
        }
        .col-hide{
            display: none;
        }
    }
    @media only screen and (min-device-width: 320px) and (max-device-width: 568px){
        /* Styles */
        .mobile-screen .wrr-s{
            width: 100%
        }
        .mobile-screen .items-listview .video-item-list .col-66{
            width: 40%
        }
        .mobile-screen .items-listview .video-item-list .col-33{
            width: 58%
        }
        .col-f{
            width: 100%;
        }
        .col-hide{
            display: none;
        }
    }

</style>
<?php include_once("analyticstracking.php") ?>
	<div id="main">
        <div id="wrr-main">
            <header>
                <div id="banner-top">
                    <div class="wrr-banner-top">
                        <div id="logo">
                            <h1><a class="logoimg" href="/">Health Tips, Beauty, Love, Food care</a></h1>
                        </div>
                    </div>
                </div>
                <?php include_once("_menu_top.php") ?>
            </header>
            <?php
            if($this->breadcrumbs){
                $this->widget('application.widgets.MBreadcrumbs', array(
                    'links'=>$this->breadcrumbs,
                    'htmlOptions'=>array('class'=>'breadcrumbs','id'=>'breadcrumb'),
                ));
            }
            ?>
            <?php echo $content;?>
            <div id="footer">
                <div class="wrr-footer">
                    <div class="wr-ftl">Copyright &#169; 2015 Health2Tips</div>
                    <div class="wr-ftr">
                        <ul class="term op">
                            <li><a href="<?php echo Yii::app()->createUrl('/site/contact')?>">Contacts</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Term</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
