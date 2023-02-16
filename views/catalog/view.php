<?php

use app\controllers\CatalogController;
use app\helpers\WordsHelper;
use app\models\Brands;
use app\models\Products;
use app\models\Reviews;
use app\widgets\ParentProducts;
use app\widgets\ViewedProducts;
use kartik\rating\StarRating;
use yii\helpers\Html;

/** @var  Products $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
CatalogController::setViewedProductsCookie($model->id);

$value = json_encode([$model->id => ['id' => $model->id, 'number' => 1]]);

?>
<div class="container catalog-view-container">
    <div>
        <h1> <?= $model->name; ?> </h1>
    </div>

    <div class="row">
        <div class="col-lg-2 product-view-rate">
            <?= StarRating::widget([
                'name' => 'review_rating_' . $model->id,
                'value' => $model->getRate(),
                'pluginOptions' => [
                    'displayOnly' => true,
                    'size' => 'sm',
                    'showCaption' => false,
                    'clearButton' => '',
                    'step' => 0.1,
                ]
            ]); ?>
        </div>
        <a href="#reviews" class="col-lg-1 products-manufacturer align-self-center">
            <?= WordsHelper::declinationAfterNumber($model->getReviewsCount(), array('отзыв', 'отзыва', 'отзывов')) ?>
        </a>
        <div class="col-lg-3 align-self-center">Артикул: <?= $model->article; ?>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-lg-5">
            <div class="<?= empty($model->getThumbnailsPath()) ? 'no-image-product-view m-auto' : '' ?>">
                <div class="<?= empty($model->getThumbnailsPath()) ? 'product-view-hide' : '' ?>">
                    <section class="slider">
                        <div class="container" style="height: 100%;">
                            <div class="slider__flex">
                                <div class="slider__col">
                                    <div class="slider__prev" style="color: black"><i
                                                class="fa-solid fa-chevron-up"></i>
                                    </div>
                                    <div class="slider__thumbs">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <?php foreach ($model->getThumbnailsPath() as $image): ?>
                                                    <!-- Превью слайда-->
                                                    <div class="swiper-slide">
                                                        <div class="slider__image slider-image-view-prew"><img
                                                                    src="<?= $image ?>" alt=""/></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slider__next" style="color: black"><i
                                                class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="slider__images">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            <?php foreach ($model->getThumbnailsPath() as $key => $image): ?>
                                                <!-- Большой слайд -->
                                                <div class="swiper-slide">
                                                    <div class="slider__image slider-image-view"><img
                                                                src="<?= $image ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="<?= '#Modal_' . $key ?>"/>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <?php foreach ($model->getImagesPath() as $key => $image): ?>
                                        <!-- Модальное окно -->
                                        <div class="modal fade" id="<?= 'Modal_' . $key ?>" tabindex="-1"
                                             aria-labelledby="<?= 'Modal_' . $key, 'label' ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <img src="<?= $image ?>"
                                                             style="width: 100%">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                            Закрыть
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <script type="module" src="/js/swiper.js"></script>
            <script type="module" src="/js/product-view-slider.js"></script>
        </div>
        <div class="col-lg-7">
            <div class="pb-2 <?= ($model->brand_id) ?? 'catalog-view-display-none' ?>">
                <b>Производитель: </b>
                <a href="/catalog/brand/<?= $model->brand_id ?>" class="products-manufacturer">
                    <?= ($model->brand_id) ? Brands::getBrandById($model->brand_id)->name : 'Не найдено' ?>
                </a>
            </div>
            <div class="py-4" style="overflow: hidden; width: 100%">
                <div style="padding-top: 8px;" class="product-view-cost-item product-view-additional
            <?= ($model->on_sale == 0)
                    ? 'product-view-cost-large'
                    : 'product-view-cost-small product-view-cost-through'
                ?>"> <?= $model->displayCurrency(); ?> Руб</div>
                <div class="product-view-cost-item <?= ($model->on_sale == 1)
                    ? 'product-view-cost-large product-view-cost-on-sale'
                    : 'product-view-hide'
                ?>"> <?= $model->displaySale(); ?> </div>
                <div class="product-view-cost-item product-view-currency-small product-view-additional
                            <?= ($model->on_sale == 1) ? 'product-view-text-on-sale' : '' ?>"> Руб
                </div>
            </div>
            <?= Html::beginForm('/catalog/add-to-cart-by-view', 'POST', ['class' => 'input-group search-group py-2', 'style' => 'width: 280px', 'id' => 'add_to_card_form']) ?>
            <?= Html::input('number', 'number', 1, [
                'class' => 'form-control',
                'id' => 'addToCardNumberInput',
            ]) ?>
            <?= Html::hiddenInput('user_id', Yii::$app->user->id, ['id' => 'addToCardUserIdInput']) ?>
            <?= Html::hiddenInput('product_id', $model->id, ['id' => 'addToCardProductIdInput']) ?>
            <div class="input-group-append input-button menu-btn-input">
                <button type="submit" class="btn btn-dark" id="addToCartButton">
                    <b>Добавить в корзину</b>
                    <i class="fas fa-cart-plus"></i>
                </button>
            </div>
            <?= Html::endForm() ?>
            <script>
                $(document).ready(function () {
                    $("#add_to_card_form").submit(function (event) {
                        let addToCardInputProduct = $('#addToCardProductIdInput');
                        let addToCardInputNumber = $('#addToCardNumberInput');
                        let addToCardInputUser = $('#addToCardUserIdInput');
                        let inputData = new FormData;

                        inputData.append('number', addToCardInputNumber.val());
                        inputData.append('product_id', addToCardInputProduct.val());
                        inputData.append('user_id', addToCardInputUser.val());

                        $.ajax({
                            url: '/catalog/add-to-cart-by-view',
                            data: inputData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function (response) {
                            }
                        });

                        event.preventDefault();
                    });
                });
            </script>
            <div class="py-3">
                <b>Описание товара: </b>
                <div class="row">
                    <div class="col-lg-8"
                         style="overflow: hidden;display: -webkit-box;-webkit-line-clamp: 9;-webkit-box-orient: vertical;line-height: 1.3em;height: 11.9em;">
                        <?= $model->description ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- модуль подходящих товаров -->
<div class="container-grey <?= (!is_array($model->parent_id)) ? 'catalog-view-display-none' : '' ?>">
    <div class="container py-4">
        <div class="catalog-title-size py-2">Вместе с этим вы можете приобрести</div>
        <?= (is_array($model->parent_id)) ? ParentProducts::widget(['parentIds' => $model->parent_id]) : '' ?>
    </div>
</div>

<!-- модуль ранее просмотренных товаров -->
<?php $cookieProducts = CatalogController::getViewedProductsIds($model->id); ?>
<div class="container-grey <?= (empty($cookieProducts)) ? 'catalog-view-display-none' : '' ?>">
    <div class="container py-4">
        <div class="catalog-title-size py-2">Вы недавно смотрели</div>
        <?= !empty($cookieProducts) ? ViewedProducts::widget(['parentIds' => $cookieProducts]) : '' ?>
    </div>
</div>

<!-- модуль отзывов -->
<div class="container-grey">
    <a name="reviews"></a>
    <div class="container py-4">
        <div class="catalog-title-size py-2">Отзывы и оценки</div>
        <div class="p-2">
            <button type="button"
                    class="btn btn-warning  <?= Yii::$app->user->isGuest ? 'catalog-view-display-none' : '' ?>"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                Оставить свой отзыв
            </button>
            <!-- Modal -->
            <?= $this->render("@app/views/catalog/productReviewModal", ['model' => $model]) ?>
        </div>
        <div>
            <?= \app\widgets\Reviews::widget(['type' => Reviews::REVIEW_TYPE_PRODUCTS, 'entityId' => $model->id]) ?>
        </div>
    </div>
</div>