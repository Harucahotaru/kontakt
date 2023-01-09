<?php

namespace app\controllers;

use app\helpers\CookieHelper;
use app\models\Products;
use app\models\ProductsCategories;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class CatalogController extends Controller
{
    public const VIEWED_PRODUCTS_COOKIE = 'viewed_products';

    /**
     * @param $mainCategory
     * @param $subCategory
     * @param $subCategory2
     *
     * @return string
     */
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

    /**
     * @param int $productId
     *
     * @return string|null
     */
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

    /**
     * Сохраняет id товара для работы блока "просмотренные товары"
     *
     * @param int $productId
     *
     * @return bool
     */
    public static function setViewedProductsCookie(int $productId): bool
    {
        $cookieOldValue = self::getCookieValue();
        if (CookieHelper::checkCookieValueRepeat($cookieOldValue, $productId)) {
          return false;
        }
        CookieHelper::setCookie($productId, self::VIEWED_PRODUCTS_COOKIE, 36000, $cookieOldValue);

        return true;
    }

    /**
     * @return array|string
     */
    private static function getCookieValue()
    {
        $cookieProducts = CookieHelper::getCookie(self::VIEWED_PRODUCTS_COOKIE);

        return !empty($cookieProducts) ? $cookieProducts->value : [];
    }

    /**
     * Возвращает id товаров для блока "просмотренные ранее товары"
     *
     * @param int $productId
     * @return array
     */
    public static function getViewedProductsIds(int $productId): array
    {
        return array_diff(self::getCookieValue(), array($productId));
    }
}