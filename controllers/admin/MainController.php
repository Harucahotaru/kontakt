<?php

namespace app\controllers\admin;

use app\classes\AccessControl;
use app\models\ControllerRules;
use yii\web\Controller;

class MainController extends BasicAdminController
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}