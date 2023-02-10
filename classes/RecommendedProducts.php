<?php

namespace app\classes;

use Yii;

class RecommendedProducts
{

    public const RECOMMENDED_CATEGORIES_COOKIE = 'viewed_categories';

    /**
     * @param int $category_id
     *
     * @return void
     */
    public static function addNewCategory(int $category_id)
    {
        $oldCookie = Yii::$app->request->cookies->getValue(self::RECOMMENDED_CATEGORIES_COOKIE, '[]');
        if (is_string($oldCookie)) {
            $oldCookie = json_decode($oldCookie);
        }
        $newCookie = array_merge($oldCookie, array($category_id));

        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => self::RECOMMENDED_CATEGORIES_COOKIE,
            'value' => json_encode((count($newCookie) >= 4) ? array_slice($newCookie, 1) : $newCookie),
        ]));
    }

    /**
     * @return array
     */
    public static function getViewedCategories(): array
    {
        $cookie = Yii::$app->request->cookies->getValue(self::RECOMMENDED_CATEGORIES_COOKIE, '[]');

        if (is_string($cookie)) {
            $cookie = json_decode($cookie);
        }
        return $cookie;
    }
}