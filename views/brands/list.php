<?php

/** @var $brands */

use app\models\Brands;

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1>Производители наших товаров</h1>
    <div>
        <?php /** @var Brands $brand */ ?>
        <?php foreach ($brands as $brand): ?>
            <div class="card my-4" style="width: 100%;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="manufacturer-image-box">
                                <?php if (!empty($brand->imgPath)): ?>
                                    <img src="<?= $brand->imgPath ?>" style="width: 100%">
                                <?php endif ?>
                                <?php if (empty($brand->imgPath)): ?>
                                    <div class="no-image-manufacturer"></div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="card-title"><?= $brand->name ?></h5>
                            <p class="card-text"><?= $brand->description ?></p>
                            <a href="/catalog/brand/<?= $brand->id ?>" class="card-link products-manufacturer">Искать производителя в каталоге...</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
