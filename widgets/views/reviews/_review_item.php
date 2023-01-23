<?php
/** @var \app\models\Reviews $model * */

use kartik\rating\StarRating;

?>
<div class="review-card m-3 <?= $model->checkAccessStatus() ? '' : 'catalog-view-display-none' ?>">
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-2 review-card-name  align-self-center"><?= $model->getUserName() ?></div>
                    <div class="col-lg-2 align-self-center" style="height: 46px">
                        <?= StarRating::widget([
                            'name' => 'review_rating_' . $model->id,
                            'value' => $model->rate,
                            'pluginOptions' => [
                                'displayOnly' => true,
                                'size' => 'sm',
                                'showCaption' => false,
                                'clearButton' => '',
                            ]
                        ]); ?>
                    </div>
                    <div class="col-lg-7"></div>
                    <div class="card-title col-lg-1 align-self-center justify-content-end"><?= $model->date_c ?></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="py-1">
                    <b class="review-card-category"> Срок использования:</b>
                    <?= $model->getExperience() ?>
                </div>
                <div class="py-1">
                    <?= $model->content ?>
                </div>
                <div class="py-1 <?= empty($model->benefits) ? 'catalog-view-display-none' : ''?>">
                    <div>
                        <span class="review-card-category"> Преимущества:</span>
                        <span> <?= $model->benefits ?></span>
                    </div>
                </div>
                <div class="py-1 <?= empty($model->benefits) ? 'catalog-view-display-none' : ''?>">
                    <b class="review-card-category"> Недостатки:</b>
                    <?= $model->limitations ?>
                </div>
            </li>
        </ul>
    </div>
</div>
