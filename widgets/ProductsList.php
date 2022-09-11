<?php

namespace app\widgets;

use app\assets\widget\ProductsListAsset;
use app\models\Brands;
use yii\base\Widget;

class ProductsList extends Widget
{

    public function init()
    {
        parent::init();
        ProductsListAsset::register($this->view);
    }

    public function run()
    {
        return $this->render('products-list\index', [
        ]);
    }
}