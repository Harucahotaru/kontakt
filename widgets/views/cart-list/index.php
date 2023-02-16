<?php

use app\models\Products;
use app\models\UserBasket;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

UserBasket::getCartCount(Yii::$app->user->id);
/* @var $userId */

/* @var $activeForm */

$cartPrice = (new app\models\Products)->prepareNumberForDisplay(UserBasket::getCartPrice(Yii::$app->user->id))
?>
<?php Pjax::begin([
    'timeout' => 10000,
    'id' => 'cart_pjax_container'
]); ?>
    <div class="row">
        <div class="col-lg-8">
            <?= ListView::widget([
                'dataProvider' => Products::getCartProductsProvider($userId),
                'itemView' => '_product_item',
                'itemOptions' => [
                    'tag' => false,
                ],
                'options' => [
                    'class' => 'row',
                    'data-pjax' => true
                ],
                'layout' => "{pager}\n{items}\n",
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
            ]); ?>
        </div>
        <div class="col-lg-4">
            <div class="cart-cost-box p-4 my-3">
                <div>
                    Товары, <?= UserBasket::getCartCount(Yii::$app->user->id) ?> шт.
                </div>
                <div class="row">
                    <b class="col-lg-5 cart-full-cost">Итого:</b>
                    <div class="col-lg-7">
                        <div class="card-all-cost"><?= !empty($cartPrice) ? "$cartPrice руб" : '' ?></div>
                    </div>
                </div>
                <div class="pt-4">
                    <?= Html::button('Оставить заявку', [
                        'class' => 'btn btn-warning w-100 cart-button-modal',
                        'data-toggle' => "modal",
                        'data-target' => "#cartModal",
                        'id' => 'cartModalButton'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cartFormModal" tabindex="-1" aria-labelledby="cartModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Оставить заявку</h5>
                </div>
                <div class="modal-body">
                    <?= Html::beginForm('/', 'POST') ?>
                    <div class="py-2">
                        <?= Html::label('Телефон') ?>
                        <?= Html::input('phone', 'phone', null, ['class' => 'form-control', 'placeholder' => "+7 (999) 999-99-99"]) ?>
                    </div>
                    <div class="py-2">
                        <?= Html::label('Почта') ?>
                        <?= Html::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => "name@example.com"]) ?>
                    </div>
                    <div class="py-2">
                        <?= Html::label('Комментарий к заказу') ?>
                        <?= Html::textarea('commentary', null, ['class' => 'form-control']) ?>
                    </div>
                    <div class="py-2">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning w-100', 'disabled' => 'disabled']) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cartModalButtonClose">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>