<?php

use app\models\Products;
use app\models\ProductsCategories;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data Products */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['id' => 'products']) ?>

<!--    --><?php //Html::beginForm('/admin/products/mass-change', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success mr-2']) ?>

<!--        <button class="btn btn-primary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"-->
<!--                aria-expanded="false" aria-controls="collapseExample">-->
<!--            Массовые действия-->
<!--        </button>-->

    <div class="collapse" id="collapseExample">
        <div class="card card-body">

            <?= Html::Label('Тип действия'); ?>
            <?= Html::dropDownList('actionType', null, Products::actionList(), [
                'class' => 'action-type-dropdown actionInput',
            ]); ?>

            <?= Html::Label('Новое значение'); ?>
            <?= Html::dropDownList('value', null, [], ['class' => 'action-type-dropdown valueInput']); ?>

            <p>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success mt-3']); ?>
            </p>

        </div>
    </div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => CheckboxColumn::class,
                'checkboxOptions' => function ($model) {
                    return ['value' => $model->id];
                },
            ],
            [
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img($data->getMainImagePath(), ['style' => 'max-width: 100px']);
                }
            ],
            'id',
            'name',
            'article',
            'currency',
            [
                'format' => 'html',
                'attribute' => 'on_sale',
                'filter' => array(0 => "Не активна", 1 => "Активна"),
                'value' => function ($data) {
                    return ($data->on_sale === 0) ? 'Не активна' : 'Активна';
                },
            ],
            'sale',
            [
                'format' => 'html',
                'attribute' => 'category_id',
                'filter' => ProductsCategories::getAllCategoriesList(),
                'value' => function ($data) {
                    /** @var Products $data */
                    return !empty($data->category_id) ? ProductsCategories::getById($data->category_id)->name : '';
                },
            ],
            [
                'format' => 'html',
                'attribute' => 'active',
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'active',
                    'data' => array(0 => "Не активен", 1 => "Активен"),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value' => function ($data) {
                    return ($data->active === 0) ? 'Не активен' : 'Активен';
                }
            ],
            [
                'attribute' => 'date_m',
                'format' => ['datetime', 'php:d.m.y H:i']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Products $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

<!--    --><?php //Html::endForm(); ?>

    <?php Pjax::end() ?>

</div>
