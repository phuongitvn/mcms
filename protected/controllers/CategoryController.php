<?php
class CategoryController extends Controller
{
    public $layout='2column';
    public function actionIndex()
    {
        $url_key = Yii::app()->request->getParam('url_key');
        $c = array(
            'conditions'=>array(
                //'status'=>array('==' => "1"),
                'url_key'=>array('=='=>$url_key)
            ),
            'limit'=> 1,
        );
        $genre = GenreModel::model()->find($c);
        if(empty($genre)){
            throw new CHttpException(404);
        }
        $genreCode = $genre->code;
        $limit = 10;
        $offset = 0;
        $c = array(
            'conditions'=>array(
                //'status'=>array('==' => 1),
                'genre'=>array('=='=>$genreCode)
            ),
            'sort'=>array('_id'=>EMongoCriteria::SORT_DESC),
            'limit'=> $limit,
            'offset'=> $offset
        );
        $articles = FeedModel::model()->findAll($c);
        $this->render('index', compact('articles', 'genre'));
    }
}