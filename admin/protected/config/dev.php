<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/admin.php'),
    array(
        'import'=>array(
            'common.extensions.yiidebugtb.*', //our extension
        ),
        'components'=>array(
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning, trace',
                    ),
                    array( // configuration for the toolbar
                        'class'=>'XWebDebugRouter',
                        'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                        'levels'=>'error, warning, trace, profile, info',
                        'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                    ),
                ),
            ),
        ),
    )
);
