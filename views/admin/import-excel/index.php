<?php

/** @var  ActiveForm $actionForm */

/** @var  $formname */

use app\assets\AppAsset;
use app\assets\ImportExcelAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

AppAsset::register($this);
ImportExcelAsset::register($this);

$this->title = 'Импорт товаров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?= Html::beginForm([$actionForm], 'post', ['data-pjax' => '', 'class' => "$formname", 'enctype' => 'multipart/form-data']); ?>
    <?= Html::input('file', 'excel', '', ['class' => 'form-control file-input my-3']) ?>
    <?= Html::endForm() ?>
    <div class="excel-preview"></div>
</div>