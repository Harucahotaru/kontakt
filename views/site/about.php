<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= $this->title ?></h1>
    <div class="row">
        <?php foreach (scandir(Yii::$app->basePath . '/public_html/upload/images/about') as $img): ?>
            <?php if ($img !== '.' && $img != '..'): ?>
                <div class="col-lg-2" data-bs-toggle="modal" data-bs-target="#id<?=str_replace('.','',$img)?>"
                     style="height: 150px; background: top/cover url('/upload/images/about/<?= $img ?>'); border: 3px white solid">

                    <!-- Modal -->
                    <div class="modal fade" id="id<?=str_replace('.','',$img)?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $img ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="/upload/images/about/<?= $img ?>" style="width: 100%">
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?= $content ?>
</div>
