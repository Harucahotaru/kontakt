<?php
/** var @var Brands $brand */

use app\models\Brands;
use app\widgets\ProductsList;

//var_dump($brand->imgPath);exit();
?>
<div class="container-grey">
    <div class="container py-4">
        <h1 class="py-3">Производитель: <?= $brand->name ?></h1>
        <div class="row">
            <div class="col-lg-5">
                <img class="catalog-brand-img" src="<?= $brand->getImgPath() ?>">
            </div>
            <div class="col-lg-5">
                <h4>Немного о бренде: </h4>
                <div class="catalog-brand-description"><?= $brand->description ?></div>
            </div>
        </div>
        <?= ProductsList::widget(
            [
                'brandId' => $brand->id,
            ]
        ) ?>
    </div>
</div>