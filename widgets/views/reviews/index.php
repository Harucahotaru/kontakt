<?php

use app\models\Reviews;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $type */
/* @var $entityId */
?>

<?php Pjax::begin([
    'timeout' => 1000
]); ?>
<?= ListView::widget([
    'dataProvider' => Reviews::getReviewsProvider($type, $entityId),
    'itemView'     => '_review_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row'
    ],
    'emptyText' => 'Здесь пока нет отзывов, но вы можете быть первыми',
    'layout'       => "{pager}\n{items}\n",
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
Pjax::end();
?>
