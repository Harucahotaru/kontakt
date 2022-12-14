<?php

namespace app\controllers;

use app\classes\AccessControl;
use app\classes\ParseExcel;
use app\models\ControllerRules;
use app\models\Pages;
use app\models\PagesContent;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    private ?Pages $page;
    private array  $content = [];

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
        $this->page = Pages::find()->where(['url' => Yii::$app->request->pathInfo])->one();
        if (!empty($this->page) && !empty($this->page->content) ) {
            $this->content = $this->page->content;
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
//        $a = new ParseExcel();
//        $a->parse();
        return $this->render('index', ['time' => date('H:i:s')]);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        return $this->render('contact', ['content' => $this->content]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about', ['content' => $this->content]);
    }
}
