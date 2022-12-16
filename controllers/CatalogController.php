<?php

namespace app\controllers;

use app\models\Products;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => Products::getProductById($id),
        ]);
    }
}