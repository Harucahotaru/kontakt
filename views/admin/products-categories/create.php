<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductsCategories $model */

$this->title = 'Создать категорию товаров';
$this->params['breadcrumbs'][] = ['label' => 'Категории товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-categories-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
