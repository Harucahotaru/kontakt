<?php

namespace app\widgets;

use app\assets\widget\ProductsListAsset;
use yii\base\Widget;

class ProductsList extends Widget
{
    public ?int $categoryId = null;

    public ?int $maxPagination = null;

    public ?string $searchString = null;

    public ?string $systemCategory = null;

    public ?int $brandId = null;

    public ?array $sort = null;

    public ?int $limitButtons = null;

    public string $layout = "{pager}\n{summary}\n{items}\n{pager}";

    public function init()
    {
        parent::init();
        ProductsListAsset::register($this->view);
    }

    public function run()
    {
        return $this->render('products-list/index', [
            'categoryId' => $this->categoryId,
            'pagination' => $this->maxPagination,
            'searchString' => $this->searchString,
            'systemCategory' => $this->systemCategory,
            'brandId' => $this->brandId,
            'sort' => $this->sort,
            'limitButtons' => $this->limitButtons,
            'layout' => $this->layout,
        ]);
    }
}