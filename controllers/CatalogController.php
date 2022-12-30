<?php

namespace app\controllers;

use app\models\Products;
use app\models\ProductsCategories;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex($mainCategory, $subCategory = null, $subCategory2 = null)
    {
        $categoryList = array_diff([$mainCategory, $subCategory, $subCategory2], ['']);
        $categoryName = end($categoryList);
        if ($categoryName !== false) {
            $model = ProductsCategories::getByName($categoryName);
        } else {
            $model = null;
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionView(int $productId): ?string
    {
        try {
            $product = Products::getProductById($productId);
        } catch (Exception $e) {
            Yii::$app->session->addFlash('success', $e->getMessage());
            return $this->render('index', [
                'model' => null
            ]);
        }

        return $this->render('view', [
            'model' => $product,
        ]);
    }
}