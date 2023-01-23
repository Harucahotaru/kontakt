<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_basket".
 *
 * @property int $id Id
 * @property int $user_id Id пользователя
 * @property string $products_ids Id товаров
 * @property string|null $date_c Дата создания
 * @property string|null $date_m Дата изменения
 */
class UserBasket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_basket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'products_ids'], 'required'],
            [['user_id'], 'integer'],
            [['products_ids', 'date_c', 'date_m'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id' => 'Id пользователя',
            'products_ids' => 'Id товаров',
            'date_c' => 'Дата создания',
            'date_m' => 'Дата изменения',
        ];
    }

    public static function getByUser($userId)
    {
        return self::find()->where(['user_id' => $userId])->one();
    }

    public function createNewCart(int $userId, string $product): UserBasket
    {
        $this->user_id = $userId;
        $this->products_ids = $product;
        $this->save();

        return $this;
    }

    public function updateCart(array $products): UserBasket
    {
        $this->products_ids = json_encode($products);
        $this->save();

        return $this;
    }

    public function addToCart(array $product): UserBasket
    {
        $cart = json_decode($this->products_ids, true);
        $cart = $cart + $product;
        $this->products_ids = json_encode($cart);
        $this->save();

        return $this;
    }

    public static function getCartPrice($userId): int
    {
        $cartPrice = 0;

        $cart = self::getByUser($userId);
        if (empty($cart)) {
            return $cartPrice;
        }

        $cartProducts = json_decode($cart->products_ids, true);
        $products = Products::getProductByIds(array_keys($cartProducts));

        foreach ($cartProducts as $cartProduct) {
            /** @var Products $product */
           foreach ($products as $product) {
               if ($product->id === $cartProduct['id']) {
                   if (!empty($product->sale) && $product->on_sale) {
                       $cartPrice += ($product->sale * $cartProduct['number']);
                   } else {
                       $cartPrice += ($product->cost * $cartProduct['number']);
                   }
               }
           }
        }

        return $cartPrice;
    }
}
