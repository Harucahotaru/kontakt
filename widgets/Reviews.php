<?php

namespace app\widgets;

use app\assets\widget\ReviewsAsset;
use yii\base\Widget;

class Reviews extends Widget
{
    public ?int $type = null;
    public ?int $entityId = null;

    public function init()
    {
        parent::init();
        ReviewsAsset::register($this->view);
    }

    public function run()
    {
        return $this->render('reviews/index', ['type' => $this->type, 'entityId' => $this->entityId]);
    }
}