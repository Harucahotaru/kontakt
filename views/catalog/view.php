<?php

use app\controllers\CatalogController;
use app\helpers\WordsHelper;
use app\models\Brands;
use app\models\Products;
use app\models\Reviews;
use app\widgets\ParentProducts;
use app\widgets\ViewedProducts;
use kartik\rating\StarRating;

/** @var  Products $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
CatalogController::setViewedProductsCookie($model->id);

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
            <?= WordsHelper::declinationAfterNumber($model->getReviewsCount(), array('отзыв', 'отзыва', 'отзывов'))?>
        </a>
        <div class="col-lg-3 align-self-center">Артикул: <?= $model->article; ?>
        </div>
    </div>
    <div class="row py-3">
        <div class="col-lg-5">
            <section class="slider">
                <div class="container" style="height: 100%;">
                    <div class="slider__flex">
                        <div class="slider__col">
                            <div class="slider__prev" style="color: black"><i class="fa-solid fa-chevron-up"></i></div>
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
                            <div class="slider__next" style="color: black"><i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="slider__images">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php foreach ($model->getThumbnailsPath() as $key => $image): ?>
                                        <!-- Большой слайд -->
                                        <div class="swiper-slide">
                                            <div class="slider__image slider-image-view"><img src="<?= $image ?>"
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
            <script type="module" src="/js/swiper.js"></script>
            <script type="module" src="/js/product-view-slider.js"></script>
        </div>
        <div class="col-lg-7">
            <div class="pb-2 <?= ($model->brand_id) ?? 'catalog-view-display-none' ?>">
                <b>Производитель: </b>
                <a href="/catalog/brand/<?=$model->brand_id?>" class="products-manufacturer">
                    <?= ($model->brand_id) ? Brands::getBrandById($model->brand_id)->name : 'Не найдено' ?>
                </a>
            </div>
            <!--            <div class="py-4" style="overflow: hidden; width: 100%">-->
            <!--                <div class="product-view-cost-item product-view-additional -->
            <?php //($model->on_sale == 0)
            //                    ? 'product-view-cost-large'
            //                    : 'product-view-cost-small product-view-cost-through'
            //                ?><!--"> --><?php //$model->cost; ?><!-- </div>-->
            <!--                <div class="product-view-cost-item --><?php //($model->on_sale == 1)
            //                    ? 'product-view-cost-large product-view-cost-on-sale'
            //                    : 'product-view-hide'
            //                ?><!--"> --><?php //$model->sale; ?><!-- </div>-->
            <!--                <div class="product-view-cost-item product-view-cost-small product-view-additional-->
            <!--                --><?php //($model->on_sale == 1) ? 'product-view-text-on-sale' : '' ?><!--"> Руб-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <form class="input-group search-group py-2" style="width: 280px">-->
            <!--                <input type="number" class="form-control" id="add_to_card" name="add_to_card"-->
            <!--                       aria-describedby="basic-addon2" value="1" min="0" step="1">-->
            <!--                <div class="input-group-append input-button menu-btn-input">-->
            <!--                    <button type="submit" class="btn btn-dark">-->
            <!--                        <b>Добавить в корзину</b>-->
            <!--                        <i class="fas fa-cart-plus"></i>-->
            <!--                    </button>-->
            <!--                </div>-->
            <!--            </form>-->
            <div class="py-3">
                <b>Описание товара: </b>
                <div class="row">
                    <div class="col-lg-8">
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