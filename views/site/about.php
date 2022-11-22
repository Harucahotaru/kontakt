<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= $this->title ?></h1>
    <div class="row">
        <?php foreach (scandir(Yii::$app->basePath . '/web/upload/images/about') as $img): ?>
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
    <p>Электротехническая Компания «КОНТАКТ» основана в 2004 году. За годы работы мы набрались опыта и динамично
        развиваясь научились своевременно и качественно решать вопросы в комплектации заявок и поставок светотехнической
        продукции, электротехники, низковольтного и высоковольтного электрооборудования.</p>
    <p>Наша фирма работает честно и всегда открыта для взаимовыгодного сотрудничества. Предлагая лучшее соотношение цены
        и качества, мы дарим клиентам выгоду и удовольствие от покупок у нас. Это отмечают и ценят наши покупатели.
        Широкий ассортимент продукции и гибкая система скидок делают работу с Электротехнической Компанией «КОНТАКТ»
        особенно привлекательной. Информационная и техническая поддержка является бесплатным бонусом в нашей работе с
        нашими покупателями.</p>
    <p>Мы надеемся, что наш индивидуальный подход к каждому клиенту и достойное качество поставляемой продукции послужат
        успешному сотрудничеству с Электротехнической Компанией «КОНТАКТ» на долгие годы.</p>
</div>
