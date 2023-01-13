<?php
/** @var \app\models\Reviews $model * */

use kartik\rating\StarRating;

?>
<div class="review-card m-3">
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
                <div class="row">
                    <div class="col-lg-8">
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
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <a data-pjax=0 href="/reviews/delete/<?=$model->id?>" class="btn btn-warning" role="button">Удалить отзыв</a>
                            <a data-pjax=0 href="/reviews/accept/<?=$model->id?>" class="btn btn-warning" role="button">Одобрит отзыв</a>
                        </div>
                        <div class="py-2">
                            <ul>
                                <li class="py-1">
                                    Id пользователя: <?=$model->user_id?>
                                </li>
                                <li class="py-1">
                                    Видимость: <?=$model->visible?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
