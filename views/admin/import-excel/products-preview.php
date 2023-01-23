<?php

/** @var $parsedExcel */

/** @var $previewProducts */

/** @var $productsExample */

use app\models\Products;
use yii\helpers\Html;

$this->title = 'Импорт товаров';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/admin/import-excel'];
$this->params['breadcrumbs'][] = 'Предосмотр товара';
?>
<div class="container">
    <?php /** @var Products $previewProduct */ ?>
    <?php foreach ($previewProducts as $previewProduct): ?>
    <div class="py-3">
        <h4>Превью товара: </h4>
        <?php foreach ($previewProduct->attributes as $attributeKey => $attribute): ?>
            <div>
                <b><?=$attributeKey?>: </b>
                <?=$attribute?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <?= Html::beginForm('/admin/import-excel/products-save', 'fetch', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::hiddenInput('parsedExcel', json_encode($parsedExcel)); ?>
    <?= Html::hiddenInput('productsExample', json_encode($productsExample)); ?>
    <div>
        <b>Проверьте, правильно ли заполнены поля товара, шаблон будет применен ко всему импорту!</b>
    </div>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3']); ?>
    <?= Html::endForm() ?>
    <div>
        <div>Если форма заполнена неправильно:</div>
        <a href="/admin/import-excel" class="btn btn-danger my-3" role="button">Вернуться к загрузке файла</a>
    </div>
</div>
