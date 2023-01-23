<?php

use app\models\Products;
use app\models\Reviews;
use kartik\editors\Summernote;
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Products $model  */
?>

<?php $form = ActiveForm::begin(['action' => '/products-reviews/create']); ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Отзыв на товар: <?= $model->name ?></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <?php $reviewModel = new Reviews(); ?>
                        <div>
                            Общая оценка:
                            <?= $form->field($reviewModel, 'rate')->widget(StarRating::class, [
                                'id' => 'test',
                                'language' => 'ru',
                                'value' => 3,
                                'pluginOptions' => [
                                    'showCaption' => false,
                                    'clearButton' => '',
                                    'step' => 1,
                                ]
                            ])->label(false); ?>
                        </div>
                        <div class="py-1">Срок использования:</div>
                        <?= $form->field($reviewModel, 'experience')->dropDownList(Products::UseTermList(), [
                                'prompt' => 'Сколько вы использовали товар?',
                            ]
                        )->label(false) ?>
                        <div class="py-1">Преимущества:</div>
                        <?= $form->field($reviewModel, 'benefits')->widget(Summernote::class, [
                                'useKrajeeStyle' => true,
                                'useKrajeePresets' => true,
                                'language' => 'ru',
                                'enableFullScreen' => false,
                                'pluginOptions' => [
                                    'height' => 100,
                                    'allowClear' => true,
                                    'toolbarOptions' => false,
                                    'toolbar' => false,
                                ],
                            ]
                        )->label(false); ?>
                        <div class="py-1">Недостатки:</div>
                        <?= $form->field($reviewModel, 'limitations')->widget(Summernote::class, [
                                'useKrajeeStyle' => true,
                                'useKrajeePresets' => true,
                                'language' => 'ru',
                                'enableFullScreen' => false,
                                'pluginOptions' => [
                                    'height' => 100,
                                    'allowClear' => true,
                                    'toolbarOptions' => false,
                                    'toolbar' => false,
                                ],
                            ]
                        )->label(false); ?>
                        <div class="py-1">Опыт использования:</div>
                        <?= $form->field($reviewModel, 'content')->widget(Summernote::class, [
                                'useKrajeeStyle' => true,
                                'useKrajeePresets' => true,
                                'language' => 'ru',
                                'enableFullScreen' => false,
                                'pluginOptions' => [
                                    'height' => 100,
                                    'allowClear' => true,
                                    'toolbarOptions' => false,
                                    'toolbar' => false,
                                ],
                            ]
                        )->label(false); ?>
                        <?= $form->field($reviewModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>
                        <?= $form->field($reviewModel, 'entity_id')->hiddenInput(['value' => $model->id])->label(false); ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить отзыв', ['class' => 'btn btn-warning']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>