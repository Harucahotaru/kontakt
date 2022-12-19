<?php

use app\widgets\ProductsList;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-grey">
    <div class="container py-4">
        <div class="row">
<!--            <div class="col-lg-2 align-self-center">-->
<!--                <select class="catalog-form-select">-->
<!--                    <option selected>Сортировать:</option>-->
<!--                    <option value="1">One</option>-->
<!--                    <option value="2">Two</option>-->
<!--                    <option value="3">Three</option>-->
<!--                </select>-->
<!--            </div>-->
    <!--            <div class="col-lg-2 align-self-center">-->
    <!--                <div class="row">-->
    <!--                    <div class="col-lg-8">-->
    <!--                        Есть в наличии-->
    <!--                    </div>-->
    <!--                    <div class="form-chec col-lg-2 align-self-center">-->
    <!--                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
        </div>
        <?= ProductsList::widget() ?>
    </div>
</div>

