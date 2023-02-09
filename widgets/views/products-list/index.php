<?php

use app\controllers\CatalogController;
use app\exceptions\ProductException;
use app\models\Products;
use app\models\ProductsCategories;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $pagination */

/* @var $categoryId */

/* @var $searchString */

/* @var $systemCategory */

/* @var $brandId */

/* @var ProductsCategories $category */

$category = !empty($categoryId) ? ProductsCategories::getById($categoryId) : null;

if (!empty($category)) {
    $label = $category->name;
} elseif (!empty($systemCategory)) {
    $label = CatalogController::getLabelBySystemCategory($systemCategory);
} else {
    $label = 'Каталог';
}
?>

<h2 class="py-3"><?= $label ?></h2>

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
<?php Pjax::begin([
    'timeout' => 1000
]); ?>
<?= ListView::widget([
    'dataProvider' => $provider,
    'itemView' => '_products_item',
    'itemOptions' => [
        'tag' => false,
    ],
    'options' => [
        'class' => 'row'
    ],
    'layout' => "{pager}\n{summary}\n{items}\n{pager}",
    'emptyText' => 'Мы не смогли найти тут товары ...',
    'pager' => [
        'prevPageLabel' => '<i class="fa-solid fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fa-solid fa-chevron-right"></i>',
        'maxButtonCount' => 30,
        'options' => [
            'class' => 'pagination parent-products-pagination pt-4'
        ],
        'activePageCssClass' => 'parent-products-pagination-active',
        'disabledPageCssClass' => 'parent-products-pagination-disable',
        'prevPageCssClass' => 'parent-products-pagination-prev',
        'nextPageCssClass' => 'parent-products-pagination-next',
    ],
]);
Pjax::end();
?>
