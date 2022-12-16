<?php

namespace app\widgets;

use app\assets\widget\SliderAsset;
use app\models\Products;
use yii\base\Widget;

class ProductsSlider extends Widget
{
    public $options = [];
    public $slides = [];
    public Products $products;

    public function init()
    {
        parent::init();
        SliderAsset::register($this->view);
    }

    public function run()
    {
        $slides[] = $this->products->getImgPath();
        return $this->render('slider/productSlider', ['slides' => $slides]);

    }
}