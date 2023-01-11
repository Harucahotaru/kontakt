<?php

namespace app\controllers;

use app\models\Reviews;
use Yii;
use yii\web\Controller;

class ProductsReviewsController extends Controller
{
    private const CREATE_ERROR = 'Не удалось сохранить отзыв';
    private const CATALOG_URL = 'catalog/view/';

    public function actionCreate()
    {
        $model = new Reviews();
        $model->type = Reviews::REVIEW_TYPE_PRODUCTS;
        $model->accepted = Reviews::REVIEW_STATUS_CLOSED;
        if ($this->request->isPost) {
            if (!($model->load($this->request->post()) && $model->save())) {
                Yii::$app->session->addFlash('error', self::CREATE_ERROR);
            }
        }

        return $this->redirect([self::CATALOG_URL . $model->entity_id]);
    }
}