<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
$this->title = $name . ' <' . $exception->getCode() . '>';
?>
<div class="site-error container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger" style="font-size: 17px">
        <?= nl2br(Html::encode($exception->getMessage())) ?>
    </div>

</div>
