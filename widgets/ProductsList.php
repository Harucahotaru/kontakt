<?php

namespace app\widgets;

use app\assets\widget\ProductsListAsset;
use app\models\Products;
use yii\base\Widget;

class ProductsList extends Widget
{
    public ?int $maxPagination = null;

    public function init()
    {
        parent::init();
        ProductsListAsset::register($this->view);
    }

    public function run()
    {
        $category = 1;
        $products = Products::getProductsByCategory($category);
        return $this->render('products-list/index', [
            'products'  => $products,
            'pagination' => $this->maxPagination,
        ]);
    }
}