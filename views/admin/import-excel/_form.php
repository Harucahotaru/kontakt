<?php use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>


<?php foreach ($model->ActiveFields as $value => $name): ?>
    <?= Html::activeLabel($model, $value);?>
    <?= Html::activeDropDownList($model, $value, $headers,['class' => 'form-control']);?>
<?php endforeach ?>
<?= Html::submitButton(); ?>

