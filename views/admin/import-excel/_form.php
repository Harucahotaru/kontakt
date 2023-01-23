<?php

/** @var Products $model */

/** @var array $headers */

/** @var array $parsedExcel */

use app\models\Products;
use yii\helpers\Html;

?>

<?= Html::beginForm('/admin/import-excel/product-preview', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?php foreach ($model->ActiveFields as $value => $name): ?>
    <div class="py-1">
        <?= Html::activeLabel($model, $value); ?>
        <?= Html::activeDropDownList($model, $value, $headers, ['class' => 'form-control']); ?>
    </div>
<?php endforeach ?>
<div class="py-1">
    <?= Html::Label('С какой строки начинаются товары'); ?>
    <?= Html::input('text', 'offset', null, ['class' => 'form-control']); ?>
</div>
<?= Html::hiddenInput('parsedExcel', json_encode($parsedExcel)); ?>
<?= Html::submitButton('Предосмотр товара', ['class' => 'btn btn-warning my-3']); ?>
<?= Html::endForm() ?>

