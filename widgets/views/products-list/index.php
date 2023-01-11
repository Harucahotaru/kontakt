<?php

use app\models\Products;
use app\models\ProductsCategories;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $pagination */
/* @var $categoryId */
/* @var ProductsCategories $category */
$category = !empty($categoryId) ? ProductsCategories::getById($categoryId) : null;
?>
<h2 class="py-3"><?= !empty($category) ? $category->name : 'Каталог' ?></h2>
<?php //Pjax::begin([
//    'timeout' => 1000
//]); ?>
<?= ListView::widget([
    'dataProvider' => ($categoryId === null)
        ? Products::getAllProductsProvider($pagination)
        : Products::getProductsByCategoryProvider($pagination, $categoryId),
    'itemView'     => '_products_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row'
    ],
    'layout'       => "{pager}\n{items}\n",
    'emptyText' => 'В этой категории пока нет товаров, извините',
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
//Pjax::end();
?>
