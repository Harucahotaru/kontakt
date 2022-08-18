<?php

namespace app\widgets;

use app\assets\widget\SliderAsset;
use app\models\Slider;
use yii\base\Widget;

class Slides extends Widget
{
    public $options = [];
    public $slides = [];

    public function init()
    {
        parent::init();
        SliderAsset::register($this->view);
    }

    public function run()
    {
        $slides = Slider::getMainSlides();
        return $this->render('slider', ['slides' =>$slides]);
//

    }
}