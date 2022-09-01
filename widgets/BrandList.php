<?php

namespace app\widgets;

use app\assets\widget\BrandListAsset;
use yii\base\Widget;

class BrandList extends Widget
{
    public $options = [];
    public $brands = [];
    public $title = '';
    
    public function init()
    {
        parent::init();
        BrandListAsset::register($this->view);
    }
    
    public function run()
    {
        if ($this->brands){
            return $this->render('brand-list/index', [
                'brands'  => $this->brands,
                'title' => $this->title
            ]);
        } else {
            return false;
        }
    }
}