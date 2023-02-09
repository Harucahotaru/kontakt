<?php

namespace app\controllers;

use app\classes\RecommendedProducts;
use app\helpers\CookieHelper;
use app\models\Brands;
use app\models\Products;
use app\models\ProductsCategories;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class CatalogController extends Controller
{
    public const VIEWED_PRODUCTS_COOKIE = 'viewed_products';

    public const SYSTEM_CATEGORIES = [
        'new-products',
        'sale',
        'handshake',
    ];

    /**
     * @param $mainCategory
     * @param $subCategory
     * @param $subCategory2
     *
     * @return string
     */
    public function actionIndex($mainCategory, $subCategory = null, $subCategory2 = null): string
    {
        $model = null;
        $systemCategory = null;

        $categoryList = array_diff([$mainCategory, $subCategory, $subCategory2], ['']);
        $categoryName = end($categoryList);

        if ($this->isSystemCategories($categoryName)) {
            $systemCategory = $categoryName;
        } elseif ($categoryName !== false) {
            $model = ProductsCategories::getByName($categoryName);
        }

        return $this->render('index', [
            'model' => $model,
            'systemCategory' => $systemCategory,
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
        if (!empty($product->category_id)) {
            RecommendedProducts::addNewCategory($product->category_id);
        }

        return $this->render('view', [
            'model' => $product,
        ]);
    }

    public function actionSearch(string $searchString = null): string
    {
        return $this->render('index', [
            'searchString' => $searchString,
        ]);
    }

    public function actionBrand($brandId): string
    {
        return $this->render('brand-view', [
            'brand' => Brands::getBrandById($brandId),
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

    private function isSystemCategories($categoryName): bool
    {
        return in_array($categoryName, self::SYSTEM_CATEGORIES);
    }
}