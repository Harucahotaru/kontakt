<?php

namespace app\controllers;

use app\classes\AccessControl;
use app\models\ControllerRules;
use app\models\Pages;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    private Pages $page;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => ControllerRules::getControllerRules(Yii::$app->controller->id),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function beforeAction($action)
    {
        if (!($this->page = Pages::find()->where(['url' => Yii::$app->request->pathInfo])->one())) {
            $this->page = new Pages();
        }

        return parent::beforeAction($action);
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about', ['content' => $this->page->pagesContent[0]->content]);
    }
}
