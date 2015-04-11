<?php
return CMap::mergeArray(
	require_once dirname(__FILE__).'/local.php',
	require_once dirname(__FILE__).'/params.php',
	array(
		'import'=>array(
				'common.components.*',
				'common.models._base.*',
				'common.models.*',
                'common.models.mongo.*',
				'common.extensions.mongodb.*',
                'common.vendors.utilities.*',
                'common.helpers.*'
		),
	)
);
