<?php

namespace app\widgets;

use yii\base\Widget;

class HelpersWidget extends Widget
{
    public string $url = '/';

    public function run()
    {
        return $this->render('helpers-widget/index', [
            'url' => $this->url,
        ]);
    }
}