<?php

namespace app\controllers;

use app\models\ControllerRules;
use app\models\News;
use Yii;
use app\classes\AccessControl;
use yii\web\Controller;

class NewsController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => ControllerRules::getControllerRules(Yii::$app->controller->id),
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionCategories($category = null){
        return $this->render('index');
    }
    public function actionDetailNews($category, $urlnews){
        $model = News::find()->where(['url_name' => $urlnews])->one();
        return $this->render('detail',['model' => $model]);
    }
}
