<?php

namespace app\widgets;

use app\assets\widget\ProductsListAsset;
use app\models\Products;
use yii\base\Widget;

class ProductsList extends Widget
{
    public ?int $categoryId = null;

    public ?int $maxPagination = null;

    public ?string $searchString = null;

    public function init()
    {
        parent::init();
        ProductsListAsset::register($this->view);
    }

    public function run()
    {
        $products = Products::getProductsByCategory($this->categoryId);
        return $this->render('products-list/index', [
            'categoryId' => $this->categoryId,
            'products'  => $products,
            'pagination' => $this->maxPagination,
            'searchString' => $this->searchString,
        ]);
    }
}