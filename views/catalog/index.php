<?php

use app\models\Brands;
use app\models\Products;
use app\models\ProductsCategories;
use app\widgets\ProductsList;
use yii\bootstrap5\Html;

/* @var $this yii\web\View */

/* @var $model ProductsCategories */

/* @var $searchString */

/* @var $systemCategory */

/* @var $sort */

$url = '/catalog' . '/' . $systemCategory . (!empty($model)) ?? $model->id;
$urlPattern = "/catalog";
$this->params['breadcrumbs'] = isset($model)
    ? array_reverse($model->breadCrumbs)
    : [['label' => 'Каталог', 'url' => '/catalog']];
?>
<div class="container-grey">
    <div class="container-catalog p-5">
        <div class="row">
            <div class="col-lg-2" style="font-size: 17px">
                <?= Html::beginForm($url, 'get') ?>
                <div class="py-3">
                    <b class="py-1">Сортировать по:</b>
                    <?= Html::radioList('sort_type', $sort['sort_type'], Products::sortList(), [
                        'id' => 'productsSortDropdown'
                    ]) ?>
                </div>
                <div class="py-3">
                    <?php echo Html::checkboxList('in_stock', $sort['in_stock'], [1 => 'Есть в наличии']) ?>
                </div>
                <div class="py-3">
                    <b class="py-1">Цена:</b>
                    <div class="py-2">
                        <?= Html::input('number', 'cost_from', $sort['cost']['from'], ['placeholder' => 'От ', 'class' => 'form-control']) ?>
                    </div>
                    <div class="py-2">
                        <?= Html::input('number', 'cost_to', $sort['cost']['to'], ['placeholder' => 'До', 'class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="py-3">
                    <b class="py-3">Производители:</b>
                    <div class="brands-input-scroll">
                        <?= Html::checkboxList('brand', $sort['brand'], Brands::getBrandNamesList(), [
                            'id' => 'productsSortDropdown'
                        ]) ?>
                    </div>
                </div>
                <div>
                    <?= Html::a('Отчистить фильтр', $url, ['type' => 'button', 'class' => 'btn btn-secondary w-100 my-2']) ?>
                </div>
                <div>
                    <?= Html::submitButton('Показать', ['class' => 'btn btn-warning w-100 my-2   ']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
            <div class="col-lg-10">
                <?= ProductsList::widget(
                    [
                        'categoryId' => isset($model) ? $model->id : null,
                        'searchString' => isset($searchString) ? $searchString : null,
                        'systemCategory' => isset($systemCategory) ? $systemCategory : null,
                        'sort' => $sort,
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>