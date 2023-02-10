<?php

use app\controllers\CatalogController;
use app\exceptions\ProductException;
use app\models\Products;
use app\models\ProductsCategories;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $pagination */

/* @var $categoryId */

/* @var $searchString */

/* @var $systemCategory */

/* @var $brandId */

/* @var $sort */

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
        $query = Products::getProductsBySearchProvider($searchString);
    } elseif (!empty($categoryId)) {
        $query = Products::getProductsByCategoryProvider($categoryId);
    } elseif (!empty($systemCategory)) {
        $query = Products::getProductsBySystemCategoryProvider($systemCategory);
    } elseif (!empty($brandId)) {
        $query = Products::getProductsByBrandProvider($brandId);
    } else {
        $query = Products::getAllProductsProvider();
    }

    if (!empty($sort)) {
        $query = Products::addSortToQuery($query, $sort);
    }

//    var_dump($query->createCommand()->rawSql);exit();

} catch (ProductException $e) {
    throw new ProductException('Не удалось найти товар');
}

if (empty($pagination)) {
    $pagination = Products::BASE_PAGINATION;
}

$provider = new ActiveDataProvider([
    'query' => $query,

    'pagination' => [
        'pageSize' => $pagination,
    ],
    'sort' => [
        'defaultOrder' => [
            'date_c' => SORT_DESC,
        ]
    ],
]);
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
