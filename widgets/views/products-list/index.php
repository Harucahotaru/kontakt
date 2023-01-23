<?php

use app\exceptions\ProductException;
use app\models\Products;
use app\models\ProductsCategories;
use yii\widgets\ListView;

/* @var $pagination */

/* @var $categoryId */

/* @var $searchString */

/* @var $systemCategory */

/* @var $brandId */

/* @var ProductsCategories $category */

$category = !empty($categoryId) ? ProductsCategories::getById($categoryId) : null;
?>
<h2 class="py-3"><?= !empty($category) ? $category->name : 'Каталог' ?></h2>

<?php
try {
    if (!empty($searchString)) {
        $provider = Products::getProductsBySearchProvider($searchString, $pagination);
    } elseif (!empty($categoryId)) {
        $provider = Products::getProductsByCategoryProvider($pagination, $categoryId);
    } elseif (!empty($systemCategory)) {
        $provider = Products::getProductsBySystemCategoryProvider($systemCategory, $pagination);
    } elseif (!empty($brandId)) {
        $provider = Products::getProductsByBrandProvider($brandId, $pagination);
    } else {
        $provider = Products::getAllProductsProvider($pagination);
    }
} catch (ProductException $e) {
    throw new ProductException('Не удалось найти товар');
}
?>
<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_products_item',
    'itemOptions' => [
        'tag' => false,
    ],
    'options' => [
        'class' => 'row'
    ],
    'layout' => "{pager}\n{items}\n",
    'emptyText' => 'Мы не смогли найти тут товары ...',
    'pager' => [
        'prevPageLabel' => '<i class="fa-solid fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fa-solid fa-chevron-right"></i>',
        'maxButtonCount' => 10,
        'options' => [
            'class' => 'pagination parent-products-pagination pt-4'
        ],
        'activePageCssClass' => 'parent-products-pagination-active',
        'disabledPageCssClass' => 'parent-products-pagination-disable',
        'prevPageCssClass' => 'parent-products-pagination-prev',
        'nextPageCssClass' => 'parent-products-pagination-next',
    ],
]);
?>
