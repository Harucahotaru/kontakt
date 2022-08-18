<?php

use Imagine\Image\Box;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\imagine\Image;
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
//Эту фигню перенести в создание превью для новости конмадой $news->addThumbnail();
//$news - модель новостей. addThumbnail метод создающий превью. Путь содержится в свойстве класса модели. Размер можно
//задавать но он забит по умолчанию в свойстве класса как и качество. Оригинал картинки берется из загруженной тобой
//$originalFilePath =  yii::$app->basePath.'\web\upload\images\news\simple.jpg';
//$thumbFilePath = yii::$app->basePath.'\web\upload\images\news\simple3.jpg';
//(Image::getImagine()
//    ->open($originalFilePath))
//	->thumbnail(new Box(1000, 1000))
//    ->save($thumbFilePath,['quality' => 50]);
$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
]; ?>
<?php $form = ActiveForm::begin(); ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#main" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Общие настройки
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#list" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Настройки плитки
            </button>
        </li>
    </ul>
    <div class="tab-content mb-5" id="myTabContent">
        <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="home-tab">
            <?php
            echo '<label class="control-label">Теги</label>';
            echo Select2::widget([
                'name' => 'color_2',
                'value' => [], // initial value
                'data' => [],
                'maintainOrder' => true,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            ]);
            // Usage without model
            echo '<label class="control-label">Содержимое новости</label>';
            echo Summernote::widget([
                'name' => 'comments',
                'value' => '<b>Some Initial Value.</b>',
                // other widget settings
            ]);
            ?>
        </div>

        <div class="tab-pane fade mb-5" id="list" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
                <div class="col-lg-12">
                    <label class="control-label">Загрузите фоновое изображение</label>
                    <?php
                    echo FileInput::widget([
                        'name' => 'attachment_3',
                        'pluginOptions' => [
                            'showUpload' => false,]
                    ]);
                    ?>
                    <label class="control-label">Выберите цвет заголовка</label>
                    <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c"
                           title="Choose your color">
                    <label class="control-label">Выберите цвет описания</label>
                    <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c"
                           title="Choose your color">
                    <label class="control-label">Выберите цвет фона текста</label>
                    <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c"
                           title="Choose your color">
                    <label class="control-label">Выберите позицию</label>
                    <br>
                    <input type="radio" class="btn-check" name="options-outlined" id="success-outlined"
                           autocomplete="off" checked>
                    <label class="btn btn-outline-success" for="success-outlined">Вверху</label>

                    <input type="radio" class="btn-check" name="options-outlined" id="warning-outlined"
                           autocomplete="off">
                    <label class="btn btn-outline-warning m-2" for="warning-outlined">Внизу</label>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>