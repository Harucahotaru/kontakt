<?php

namespace app\controllers;

use app\classes\RecommendedProducts;
use app\helpers\CookieHelper;
use app\models\Brands;
use app\models\Products;
use app\models\ProductsCategories;
use app\models\UserBasket;
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
    public const SYSTEM_CATEGORIES_LABELS = [
        'new-products' => 'Новинки',
        'sale' => 'Товары по акции',
        'handshake' => 'Подобрано специально для вас',
    ];

    /**
     * @param $mainCategory
     * @param $subCategory
     * @param $subCategory2
     *
     * @return string
     */
    public function actionIndex($mainCategory = null, $subCategory = null, $subCategory2 = null): string
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
            'sort' => $this->formCatalogSort(),
        ]);
    }

    /**
     * @return array
     */
    public function formCatalogSort(): array
    {
        return [
            'sort_type' => Yii::$app->request->get('sort_type'),
            'in_stock' => (bool)Yii::$app->request->get('in_stock'),
            'cost' => [
                'from' => Yii::$app->request->get('cost_from'),
                'to' => Yii::$app->request->get('cost_to'),
            ],
            'brand' => Yii::$app->request->get('brand'),
        ];
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

    public function actionBrand($brandId): \yii\web\Response
    {
        return $this->redirect("/catalog?&brand%5B%5D=$brandId");
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

    /**
     * @param string $categoryName
     *
     * @return bool
     */
    private function isSystemCategories(string $categoryName): bool
    {
        return in_array($categoryName, self::SYSTEM_CATEGORIES);
    }

    /**
     * @param string $systemCategory
     *
     * @return string
     */
    public static function getLabelBySystemCategory(string $systemCategory): string
    {
        return self::SYSTEM_CATEGORIES_LABELS[$systemCategory];
    }

    /**
     * @return string
     */
    public function actionAddToCart(): string
    {
        if ($this->request->isPost) {
            $newProduct = $this->request->post('UserBasket');

            $this->addProductToCart($newProduct);
        }

        return $this->actionIndex();
    }

    /**
     * @return string
     */
    public function actionAddToCartByView(): string
    {
        if ($this->request->isPost) {
            $newProduct['products_ids'] = json_encode([$this->request->post('product_id') => [
                'id' => (int)$this->request->post('product_id'),
                'number' => $this->request->post('number')
            ]]);
            $newProduct['user_id'] =  $this->request->post('user_id');

            $this->addProductToCart($newProduct);
        }

        return json_encode(['status' => 'success']);
    }

    /**
     * @param array $newProduct
     *
     * @return bool
     */
    public static function addProductToCart(array $newProduct): bool
    {
        $cart = UserBasket::getByUser($newProduct['user_id']);

        if (empty($cart)) {
            $cart = new UserBasket();
            $cart->createNewCart($newProduct['user_id'], $newProduct['products_ids']);
        } elseif ($cart instanceof UserBasket) {
            $addProduct = json_decode($newProduct['products_ids'], true);
            $products = json_decode($cart->products_ids, true);
            if (array_key_exists(key($addProduct), $products)) {
                $products[key($addProduct)]['number'] += $addProduct[key($addProduct)]['number'];
                $cart->updateCart($products);
            } else {
                $cart->addToCart($addProduct);
            }
        }

        return true;
    }
}