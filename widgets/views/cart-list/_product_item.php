<?php

/** @var Products $model */

use app\models\Products;
use yii\widgets\Pjax;

?>
<div class="product-card my-3 p-0">
<!--    --><?php //Pjax::begin(['enablePushState' => false]) ?>

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
            </div>
            <div class="col-lg-2 align-self-center">
                <div class="row justify-content-center">
                    <div class="col-lg-auto small-product-card-button-main">
                        <button class="bg-warning small-product-card-button">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="col-lg-3 p-0">
                        <input type="text" class="form-control" value="1" aria-describedby="basic-addon1">
                    </div>
                    <div class="col-lg-auto">
                        <button class="bg-warning small-product-card-button">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--    --><?php //Pjax::end() ?>
</div>