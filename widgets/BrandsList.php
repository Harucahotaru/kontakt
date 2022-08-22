<?php

namespace app\widgets;

use app\assets\widget\NewsListAsset;
use app\models\News;
use yii\base\Widget;

class BrandsList extends Widget
{
    public $options = [];
    public $title = '';
    
    public function init()
    {
        parent::init();
        NewsListAsset::register($this->view);
    }
    
    public function run()
    {
        $news = News::getLastNews();
        return $this->render('brands/index', [
            'news'  => $news,
            'title' => $this->title
        ]);
    }
}