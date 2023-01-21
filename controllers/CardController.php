<?php

namespace app\controllers;

use app\models\UserBasket;
use Yii;
use yii\web\Controller;

class CardController extends Controller
{
    /**
     * @return string
     */
    public function actionAddToCart(): string
    {
        if ($this->request->isPost) {
            $newProduct = $this->request->post('UserBasket');
            $cart = UserBasket::getByUser($newProduct['user_id']);

            if (empty($cart)) {
                $cart = new UserBasket();
                $cart->createNewCart($newProduct['user_id'], $newProduct['products_ids']);
            } elseif ($cart instanceof UserBasket) {
                $addProduct = json_decode($newProduct['products_ids'], true);
                $products = json_decode($cart->products_ids, true);

                if (array_key_exists(key($addProduct), $products)) {
                    $products[key($addProduct)]['number']++;
                    $cart->updateCart($products);
                } else {
                    $cart->addToCart($addProduct);
                }

            }
        }

        return  $this->render(Yii::$app->request->referrer);
    }
}