<?php

use app\models\Products;
use app\models\UserBasket;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $userId */

/* @var $activeForm */

$cartPrice = (new app\models\Products)->prepareNumberForDisplay(UserBasket::getCartPrice(Yii::$app->user->id))
?>
<?php Pjax::begin([
    'timeout' => 10000,
    'id' => 'cart_pjax_container'
]); ?>
<div class="card-all-cost">Общая стоимость:
    <?= !empty($cartPrice) ? "$cartPrice руб" : ''?>
</div>
<?= ListView::widget([
    'dataProvider' => Products::getCartProductsProvider($userId),
    'itemView'     => '_product_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row',
        'data-pjax' => true
    ],
    'layout'       => "{pager}\n{items}\n",
    'emptyText' => 'Здесь пока нету товаров...',
    'pager' => [
        'prevPageLabel' => '<i class="fa-solid fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fa-solid fa-chevron-right"></i>',
        'maxButtonCount' => 5,
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