<?php
class CrawlDataFactory
{
	//
	public static function makeDataCrawl($site, $config=array())
	{
		switch ($site)
		{
            case 'cnet':
                Yii::import('application.components.crawl.Cnet');
                $data = new Cnet($config);
                break;
            case 'HW':
                Yii::import('application.components.crawl.HW');
                $data = new HW($config);
                break;
			default:
				$data = NULL;
				break;
		}
		return $data;
	}
}