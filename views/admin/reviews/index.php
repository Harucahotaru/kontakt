<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var  $reviewType */
/** @var  $dataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="container">
        <div class="row py-4">
            <div class="col-lg-2">
                <a href="/reviews/products" class="btn btn-warning" role="button">Отзывы на товары</a>
            </div>
            <div class="col-lg-2">
                <a href="/reviews/news" class="btn btn-warning" role="button">Отзывы на новости</a>
            </div>
        </div>
    </div>
    <div class="container-grey">
        <div class="container">
<!--            --><?php //Pjax::begin([
//                'timeout' => 10000
//            ]); ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView'     => '_review_item',
                'itemOptions'  => [
                    'tag' => false,
                ],
                'options'      => [
                    'class' => 'row',
                    'data-pjax' => true
                ],
                'layout'       => "{pager}\n{items}\n",
                'emptyText' => 'Здесь пока нету отзывов на одобрение',
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
//            Pjax::end();
            ?>
        </div>
    </div>
</div>