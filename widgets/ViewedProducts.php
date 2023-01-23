<?php

namespace app\widgets;

use app\assets\widget\ParentProductsAsset;
use app\models\Products;
use yii\base\Widget;

class ViewedProducts extends Widget
{
    public $parentIds = [];

    public function init()
    {
        parent::init();
        ParentProductsAsset::register($this->view);
    }

    public function run()
    {
        $products = Products::getParentProducts($this->parentIds);
        return $this->render('viewed-products/index', [
            'products'  => $products,
            'parentIds' => $this->parentIds
        ]);
    }
}