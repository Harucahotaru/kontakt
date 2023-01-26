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

    <?= Html::beginForm('/admin/products/mass-delete', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success mx-2']) ?>
        <?= Html::submitButton('Удалить выбранные товары', ['class' => 'btn btn-danger mx-2']); ?>
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
                'filter' => array(0 => "Не активен", 1 => "Активен"),
                'value' => function ($data) {
                    return ($data->on_sale === 0) ? 'Не активен' : 'Активен';
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

    <?= Html::endForm(); ?>

    <?php Pjax::end() ?>

</div>
