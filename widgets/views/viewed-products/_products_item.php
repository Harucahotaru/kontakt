<?php
/** @var \app\models\Products $model * */
?>
<div class="product-card my-3">
    <a data-pjax=0 href="/catalog/view/<?= $model->id ?>">
        <section class="swiper-container swiper2 pt-3">
            <div class="swiper-wrapper">
                <?php foreach ($model->getThumbnailsPath() as $image): ?>
                    <div class="swiper-slide" style="height: 250px">
                        <img style="width: 100%" src="<?= $image ?>" alt=""/>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination swiper2 swiper-pagination-white"></div>
        </section>
        <div class="product-card-body">
            <h5 class="product-card-title"><?= $model->name ?></h5>
            <div class="product-card-description"><?= $model->description ?></div>
            <div class="row py-3 row">
                <div class="card-basket col-lg-6">
                </div>
            </div>
        </div>
    </a>
</div>