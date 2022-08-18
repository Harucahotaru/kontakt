<?php
/**
 * @var string $userName
 * @var string $link
 */

use yii\helpers\Html;

?>

<div class="password-reset">
    <p>Hello <?= Html::encode($userName) ?>,</p>
    <p>Follow the link below to reset your password:</p>
    <p><?= Html::a(Html::encode($link), $link) ?></p>
</div>