<?php

declare(strict_types = 1);

namespace app\helpers;

use Yii;
use yii\base\InvalidCallException;
use yii\web\Cookie;

class CookieHelper
{
    /**
     * @param int $value
     * @param string $name
     * @param int $time срок жизни
     * @param array $oldValues
     *
     * @return bool
     */
    public static function setCookie(int $value, string $name, int $time = 86400, array $oldValues = []): bool
    {
        $cookieValue = empty($oldValues) ? array($value) : array_merge(array($value), $oldValues);

        try {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => $name,
                'value' => $cookieValue,
                'expire' => time() + $time, // 10 часов
            ]));
        } catch (InvalidCallException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $cookieName
     *
     * @return Cookie|null
     */
    public static function getCookie(string $cookieName): ?Cookie
    {
        return Yii::$app->request->cookies[$cookieName];
    }

    /**
     * Проверяет есть ли в массиве значений переданный $newValue
     *
     * @param array $cookieValues
     * @param int $newValue
     *
     * @return bool
     */
    public static function checkCookieValueRepeat(array $cookieValues, int $newValue)
    {
        return in_array($newValue, $cookieValues);
    }
}