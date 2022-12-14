<?php

/** @var \app\models\Products $model * */
?>
<div class="product-card my-3">
    <img src="<?=$model->getImgPath()?>" class="card-img-top pt-3 product-card-image">
    <div class="product-card-body">
        <h5 class="product-card-title"><?=$model->name?></h5>
        <div class="product-card-description"><?=$model->description?></div>
        <div class="row py-3 row">
<!--            <div class="col-lg-6 card-price --><?php //($model->on_sale == 0) ? '': 'card-price-on-sale'; ?><!--">-->
<!--                <s class="card-price-past">--><?php //$model->sale?><!--</s>-->
<!--                --><?php //$model->cost?>
<!--                <i class="fas fa-ruble-sign card-price-icon"></i>-->
<!--            </div>-->
            <div class="card-basket col-lg-6">
<!--                <div>-->
<!--                    <div class="input-group">-->
<!--                        <button type="button"-->
<!--                                class="product-card-button product-card-button-add bg-warning btn-number"-->
<!--                                disabled="disabled"-->
<!--                                data-type="minus" data-field="quant[1]">-->
<!--                            <span class="fa fa-minus"></span>-->
<!--                        </button>-->
<!--                        <input type="text" name="quant[1]" class="product-card-form input-number" value="1" min="1"-->
<!--                               max="10">-->
<!--                        <button type="button"-->
<!--                                class="product-card-button product-card-button-add bg-warning btn-number"-->
<!--                                data-type="plus"-->
<!--                                data-field="quant[1]">-->
<!--                            <span class="fa fa-plus"></span>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
        <div class="row">
<!--            <a href="#" class="col-lg-9 ">-->
<!--                <div class="bg-warning product-card-button product-card-button-bottom">На страницу товара</div>-->
<!---->
<!--            </a>-->
<!--            <div class="col-lg-3">-->
<!--                <button type="submit" class="product-card-button product-card-button-add bg-warning"-->
<!--                        data-field="quant[1]">-->
<!--                    <span class="fas fa-cart-plus"></span>-->
<!--                </button>-->
<!--            </div>-->
        </div>
    </div>
</div>
