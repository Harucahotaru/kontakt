<?php

use app\models\Products;
use app\models\ProductsCategories;
use app\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
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

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success mr-2']) ?>

        <button class="btn btn-primary mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample" id="openButton">
            Массовые действия
        </button>

        <?= Html::Label('Отображать по: '); ?>
        <?= Html::dropDownList('paginationSize', User::getUserPagination(), Products::paginationList(), [
            'class' => 'pagination-input',
            'id' => 'pagination'
        ]); ?>

    </p>

    <div class="collapse" id="collapseExample">
        <div class="card card-body">

            <?= Html::Label('Тип действия'); ?>
            <?= Html::dropDownList('actionType', null, Products::actionList(), [
                'class' => 'action-type-dropdown actionInput my-2',
                'prompt' => 'Выберите тип действия... ',
                'id' => 'cat'
            ]); ?>

            <div style="width: 400px" id="subDiv">
                <?= Html::Label('Тип действия', 'sub-cat-2', ['class' => 'sub-label']); ?>
                <?= DepDrop::widget([
                    'name' => 'value',
                    'options' => ['id' => 'sub-cat-2', 'class' => 'action-type-dropdown my-2'],
                    'pluginOptions' => [
                        'depends' => ['cat'],
                        'placeholder' => 'Выберите значение',
                        'url' => Url::to(['/admin/products/get-list'])
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                ]); ?>
            </div>
            <div class="text-validation-error">

            </div>
            <p>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success mt-3', 'id' => 'subButton']); ?>
            </p>

        </div>
    </div>

    <?php Pjax::begin(['id' => 'products']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{summary}\n{pager}\n{items}\n{pager}",
        'pager' => [
            'prevPageLabel' => '<i class="fa-solid fa-chevron-left"></i>',
            'nextPageLabel' => '<i class="fa-solid fa-chevron-right"></i>',
            'maxButtonCount' => 10,
            'options' => [
                'class' => 'pagination list-products-pagination pt-2'
            ],
            'activePageCssClass' => 'list-products-pagination-active',
            'disabledPageCssClass' => 'list-products-pagination-disable',
            'prevPageCssClass' => 'list-products-pagination-prev',
            'nextPageCssClass' => 'list-products-pagination-next',
        ],
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
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'active',
                    'data' => array(0 => "Не активен", 1 => "Активен"),
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

    <?php Pjax::end() ?>

</div>
