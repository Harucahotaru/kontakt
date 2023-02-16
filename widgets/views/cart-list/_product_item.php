<?php

/** @var Products $model */

use app\models\Products;
use app\models\User;
use yii\helpers\Html;

$user = new User()
?>
<div class="product-card my-3 p-0">
    <div class="small-product-card p-3">
        <div class="row">
            <div class="col-lg-2">
                <img class="small-product-card-img" src="<?= $model->getMainImagePath() ?>">
            </div>
            <div class="col-lg-5">
                <a data-pjax=0 href="/catalog/view/<?= $model->id ?>">
                    <div class="small-product-card-title"><?= $model->name ?></div>
                </a>
                <div class="small-product-card-truncate-text py-2"><?= $model->description ?></div>
                <div class="pt-3">
                    <?php if ($user->canUser(User::CAN_VIEW_COST)): ?>
                        <?php if (!empty($model->currency)): ?>
                            <div class="col-lg-12 card-price <?php echo ($model->on_sale == 0 || empty($model->sale)) ? '' : 'card-price-on-sale'; ?>">
                                <?php if ($model->on_sale == 1 && !empty($model->sale)): ?>
                                    <s class="card-price-past"><?= $model->displayCurrency() ?> Руб</s>
                                <?php endif ?>
                                <?= ($model->on_sale == 1 && !empty($model->sale)) ? $model->displaySale() : $model->displayCurrency() ?>
                                Руб
                            </div>
                        <?php endif ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-2 align-self-center">
                <div class="row justify-content-center">
                    <div class="col-lg-auto small-product-card-button-main">
                        <?= Html::beginForm('/user/add-to-cart-one', 'POST', ['id' => "add_to_card_form_plus_$model->id", 'data-pjax' => true]) ?>
                        <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'user_id_input']) ?>
                        <?= Html::hiddenInput('product_id', $model->id, ['id' => 'product_id_input']) ?>
                        <?= Html::hiddenInput('number', -1, ['id' => 'number']) ?>
                        <?= Html::submitButton('<i class="fa-solid fa-minus"></i>', ['class' => 'bg-warning small-product-card-button']) ?>
                        <?= Html::endForm() ?>
                    </div>
                    <div class="col-lg-3 p-0">
                        <?= Html::beginForm('/user/add-to-cart-some', 'POST', ['id' => "add_to_card_form_$model->id", 'data-pjax' => true]) ?>
                        <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'user_id_input']) ?>
                        <?= Html::hiddenInput('product_id', $model->id, ['id' => 'product_id_input']) ?>
                        <?= Html::input('text', 'number', $model->getCartNumber(), [
                                'class' => 'form-control number_count', 'placeholder' => $model->id]) ?>
                        <?= Html::endForm() ?>
                    </div>
                    <div class="col-lg-auto">
                        <?= Html::beginForm('/user/add-to-cart-one', 'POST', ['id' => "add_to_card_form_minus_$model->id", 'data-pjax' => true]) ?>
                        <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'user_id_input']) ?>
                        <?= Html::hiddenInput('product_id', $model->id, ['id' => 'product_id_input']) ?>
                        <?= Html::hiddenInput('number', 1, ['id' => 'number']) ?>
                        <?= Html::submitButton('<i class="fa-solid fa-plus"></i>', ['class' => 'bg-warning small-product-card-button']) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>