<?php
class SearchController extends Controller
{
    public $layout='2column';
    public function actionIndex()
    {
        $keyword = Yii::app()->request->getParam('keyword','');
        $page = Yii::app()->request->getParam('page',1);
        // Find all records witch have first name starring on a, b and c, case insensitive search
        $keyRegexPattern = self::formatKeywordsPatternSearch($keyword);
        if(empty($keyRegexPattern)){
            $data=null;
        }else {
            $regexObj = new MongoRegex($keyRegexPattern);
            $c = array(
                'conditions'=>array(
                    'status'=>array('==' => 1),
                    'title' => array('==' => $regexObj)
                ),
            );
            $total = WebArticlesModel::model()->count($c);
            $pager = new CPagination($total);
            $itemOnPaging = 5;
            $pager->pageSize = 10;
            $curr_page = $pager->getCurrentPage();

            $limit = $pager->getLimit();
            $offset = $pager->getOffset();

            $c = array(
                'conditions' => array(
                    'status' => array('==' => 1),
                    'title' => array('==' => $regexObj)
                ),
                'limit' => $limit,
                'offset' => $offset
            );
            $data = WebArticlesModel::model()->findAll($c);

        }
        $this->render('index', compact('data','pager','itemOnPaging','keyword','limit'));
    }
    public static function formatKeywordsPatternSearch($keyword)
    {
        $keyFilter = preg_replace('/[^\da-z\ ]/i', '', $keyword);
        $keyRegexPattern = explode(' ',$keyFilter);
        $keyArr = array();
        foreach($keyRegexPattern as $key){
            if(strlen($key)>4){
                $keyArr[]=$key;
            }
        }
        $keyArr = array_unique($keyArr);
        if(count($keyArr)>0) {
            $keyArr = implode('|', $keyArr);
            $regexPattern = '/(' . $keyArr . ')/i';
        }else{
            $regexPattern='';
        }
        return $regexPattern;
    }
}