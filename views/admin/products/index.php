<?php

use app\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format'    => 'html',
                'value'     => function ($data) {
                    return Html::img($data->imgPath, ['style' => 'max-width: 100px']);
                }
            ],
            'id',
            'name',
            'cost',
            [
                'format'    => 'html',
                'attribute' => 'on_sale',
                'filter'    => array(0 => "Скидка выключена", 1 => "Скидка активна"),
                'value'     => function ($data) {
                    return ($data->on_sale === 0) ? 'Скидка выключена' : 'Скидка активна';
                },
            ],
            'sale',
//            'category_id',
//            'parent_id',
            [
                'format'    => 'html',
                'attribute' => 'active',
                'filter'    =>array(0 => "Товар не активен", 1 => "Товар активен"),
                'value'     => function ($data) {
                    return ($data->on_sale === 0) ? 'Товар не активен' : 'Товар активен';
                }
            ],
            [
                'attribute' => 'date_m',
                'format' => ['datetime', 'php:d.m.Y H:i:s']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Products $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
