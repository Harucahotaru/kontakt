<?php

/** @var Products $model */

/** @var array $headers */

/** @var array $parsedExcel */

use app\classes\ParseExcel;
use app\models\Products;
use kartik\select2\Select2;
use yii\helpers\Html;

?>

<?= Html::beginForm('/admin/import-excel/product-preview', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?php foreach ($model->ActiveFields as $value => $name): ?>
    <div class="py-1">
        <?= Html::activeLabel($model, $value); ?>
        <?= Select2::widget([
            'name' => 'kv_1',
            'model' => $model,
            'value' => $headers[ParseExcel::HEADER_NOT_STATE_KEY],
            'attribute' => $value,
            'data' => $headers,
            'pluginOptions' => [
                'maximumInputLength' => 1,
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
<?php endforeach ?>
<div class="py-1">
    <?= Html::Label('С какой строки начинаются товары'); ?>
    <?= Html::input('text', 'offset', null, ['class' => 'form-control']); ?>
</div>
<?= Html::hiddenInput('parsedExcel', json_encode($parsedExcel)); ?>
<?= Html::submitButton('Предосмотр товара', ['class' => 'btn btn-warning my-3']); ?>
<?= Html::endForm() ?>

