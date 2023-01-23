<?php

namespace app\widgets;

use app\assets\widget\CartListAsset;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class ProductCart extends Widget
{
    public ?int $userId = null;


    public function init()
    {
        parent::init();
        CartListAsset::register($this->view);
    }

    public function run()
    {
        return $this->render('cart-list/index', [
            'userId' => $this->userId,
        ]);
    }
}