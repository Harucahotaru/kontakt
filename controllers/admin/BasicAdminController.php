<?php

namespace app\controllers\admin;

use app\classes\AccessControl;
use app\models\ControllerRules;
use yii\web\Controller;

class BasicAdminController extends Controller
{
    public $layout = 'admin';

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => ControllerRules::getControllerRules('admin/'.Yii::$app->controller->id),
            ],
        ];
    }
}