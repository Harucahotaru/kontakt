<?php

/** @var Products $model * */

use app\models\Products;
use app\models\User;
use app\models\UserBasket;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$user = new User()
?>
<div class="product-card my-3">
    <a data-pjax=0 href="/catalog/view/<?= $model->id ?>">
        <div class="<?= empty($model->getThumbnailsPath()) ? 'no-image-product' : '' ?>">
            <section class="swiper-container swiper1 pt-3">
                <div class="swiper-wrapper">
                    <?php foreach ($model->getThumbnailsPath() as $image): ?>
                        <div class="swiper-slide" style="height: 250px">
                            <img style="width: 100%" src="<?= $image ?>"/>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination swiper-pagination-white"></div>
            </section>
            <script type="module" src="/js/swiper.js"></script>
            <script type="module" src="/js/product-list-slider.js"></script>
        </div>
        <div class="product-card-body">
            <h5 class="product-card-title"><?= $model->name ?></h5>
            <div class="product-card-description"><?= $model->description ?></div>
            <div class="row py-3">
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
            <div class="row">
                <a data-pjax=0 href="/catalog/view/<?= $model->id ?>" class="col-lg-9 ">
                    <div class="bg-warning product-card-button product-card-button-bottom">На страницу товара</div>
                </a>
                <?php if (Yii::$app->request->url !== Yii::$app->homeUrl): ?>
                    <?php if ($user->canUser(User::CAN_USE_CART)): ?>
                        <div class="col-lg-3 <?= Yii::$app->user->isGuest ? 'catalog-view-display-none' : '' ?>">

                            <?php Pjax::begin(['enablePushState' => false, 'id' => "product $model->id"]) ?>

                            <?php $form = ActiveForm::begin(['id' => 'test-form', 'action' => '/catalog/add-to-cart', 'options' => ['data-pjax' => true]]); ?>

                            <?php $cardModel = new UserBasket() ?>

                            <?= $form->field($cardModel, 'products_ids')->hiddenInput(['value' => json_encode([$model->id => ['id' => $model->id, 'number' => 1]])])->label(false) ?>

                            <?= $form->field($cardModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

                            <button type="submit"
                                    class="product-card-button product-card-button-add bg-warning add-button"
                                    id="add_<?= $model->id ?>">
                                <span class="fas fa-cart-plus"></span>
                            </button>
                            <?php ActiveForm::end(); ?>

                            <?php Pjax::end() ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <script>
                    $(".add-button").click(function () {
                        console.log(1)
                        $(this).animate({
                            "top": "-=5px"
                        }, 200).animate({
                            "top": "+=5px"
                        }, 200)
                    });
                </script>
            </div>
        </div>
    </a>
</div>
