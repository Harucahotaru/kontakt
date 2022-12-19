<?php

use app\models\Products;
use yii\widgets\ListView;

/* @var $pagination */
?>
<h2 class="py-3">Каталог товаров</h2>
<?= ListView::widget([
    'dataProvider' => Products::getAllProductsProvider($pagination),
    'itemView'     => '_products_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row'
    ],
    'layout'       => "{items}",
    'emptyText' => 'В этой категории пока нет товаров, извините',
]);
?>
