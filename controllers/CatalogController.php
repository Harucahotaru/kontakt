<?php

namespace app\controllers;

use app\models\Products;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionView(int $id): ?string
    {
        try {
            $product = Products::getProductById($id);
        } catch (Exception $e) {
            Yii::$app->session->addFlash('success', $e->getMessage());
            return $this->render('index');
        }

        return $this->render('view', [
            'model' => $product,
        ]);
    }
}