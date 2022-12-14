<?php

use app\controllers\CatalogController;
use app\models\Products;
use app\widgets\ParentProducts;

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
        <!--        <svg width="0" height="0" viewBox="0 0 32 32">-->
        <!--            <defs>-->
        <!--                <mask id="half">-->
        <!--                    <rect x="0" y="0" width="32" height="32" fill="white"/>-->
        <!--                    <rect x="50%" y="0" width="32" height="32" fill="grey"/>-->
        <!--                </mask>-->
        <!--                <symbol viewBox="0 0 32 32" id="star">-->
        <!--                    <path d="M31.547 12a.848.848 0 00-.677-.577l-9.427-1.376-4.224-8.532a.847.847 0 00-1.516 0l-4.218 8.534-9.427 1.355a.847.847 0 00-.467 1.467l6.823 6.664-1.612 9.375a.847.847 0 001.23.893l8.428-4.434 8.432 4.432a.847.847 0 001.229-.894l-1.615-9.373 6.822-6.665a.845.845 0 00.214-.869z"/>-->
        <!--                </symbol>-->
        <!--            </defs>-->
        <!--        </svg>-->
        <!--        <div class="col-lg-2">-->
        <!--            <p class="c-rate" style="position: relative; margin: 0;">-->
        <!--                <svg class="c-icon" width="20" height="20" viewBox="0 0 10 10">-->
        <!--                    <use xlink:href="#star" mask="url(#half)"></use>-->
        <!--                </svg>-->
        <!--                <svg class="c-icon" width="20" height="20" viewBox="0 0 10 10">-->
        <!--                    <use xlink:href="#star" mask="url(#half)"></use>-->
        <!--                </svg>-->
        <!--                <svg class="c-icon" width="20" height="20" viewBox="0 0 10 10">-->
        <!--                    <use xlink:href="#star" mask="url(#half)"></use>-->
        <!--                </svg>-->
        <!--                <svg class="c-icon" width="20" height="20" viewBox="0 0 10 10">-->
        <!--                    <use xlink:href="#star" mask="url(#half)"></use>-->
        <!--                </svg>-->
        <!--                <svg class="c-icon" width="20" height="20" viewBox="0 0 32 32">-->
        <!--                    <use xlink:href="#star" mask="url(#half)"></use>-->
        <!--                </svg>-->
        <!--            </p>-->
        <!--        </div>-->
        <!--                <a href="#" class="col-lg-1 products-manufacturer">23 отзыва</a>-->
        <div class="col-lg-3">Артикул: <?= $model->article; ?></div>
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
                                                                                              data-bs-target="<?='#Modal_' . $key ?>"/>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php foreach ($model->getImagesPath() as $key => $image): ?>
                                <!-- Модальное окно -->
                                <div class="modal fade" id="<?='Modal_' . $key ?>" tabindex="-1"
                                     aria-labelledby="<?='Modal_' . $key , 'label'?>" aria-hidden="true">
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
                <a href="#" class="products-manufacturer">
                    <?= ($model->brand_id) ? \app\models\Brands::getBrandById($model->brand_id)->name : 'Не найдено' ?>
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
<div class="container-grey <?= (!is_array($model->parent_id)) ? 'catalog-view-display-none' : '' ?>">
    <div class="container py-4">
        <h2>Вместе с этим вы можете приобрести</h2>
        <?= (is_array($model->parent_id)) ? ParentProducts::widget(['parentIds' => $model->parent_id]) : '' ?>
    </div>
</div>
<?php $cookieProducts = CatalogController::getViewedProductsIds($model->id); ?>
<div class="container-grey <?= (empty($cookieProducts)) ? 'catalog-view-display-none' : '' ?>">
    <div class="container py-4">
        <h2>Вы недавно смотрели</h2>
        <?= !empty($cookieProducts) ? ParentProducts::widget(['parentIds' => $cookieProducts]) : '' ?>
    </div>
</div>