<?php

use app\assets\ImportExcelAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;

\app\assets\AppAsset::register($this);
ImportExcelAsset::register($this);
?>
<div class="container">

    <?= Html::beginForm([$actionForm], 'post', ['data-pjax' => '', 'class' => "$formname", 'enctype' => 'multipart/form-data']); ?>
    <?= Html::input('file', 'excel', '', ['class' => 'form-control file-input']) ?>
    <div class="excel-preview"></div>
    <?= Html::endForm() ?>
</div>