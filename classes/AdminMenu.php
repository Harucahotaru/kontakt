<?php

namespace app\classes;

use app\models\AuthAssignment;
use app\models\AuthItem;
use Yii;

class AdminMenu
{
    public const ADMIN_TILES = [
        'users' => [
            'title' => 'Пользователи',
            'url' => '/user',
            'icon' => '<i class="fa-solid fa-user fa-4x"></i>'
        ],
        'slider' => [
            'title' => 'Слайдер',
            'url' => '/admin/slider',
            'icon' => '<i class="fa-regular fa-images fa-4x"></i>'
        ],
        'news' => [
            'title' => 'Новости',
            'url' => '/admin/news',
            'icon' => '<i class="fa-solid fa-newspaper fa-4x"></i>'
        ],
        'pages' => [
            'title' => 'Контент страниц',
            'url' => '/admin/pages',
            'icon' => '<i class="fa-regular fa-file-word fa-4x"></i>'
        ],
        'products' => [
            'title' => 'Товары',
            'url' => '/admin/products',
            'icon' => '<i class="fa-solid fa-basket-shopping fa-4x"></i>'
        ],
        'import' => [
            'title' => 'Импорт товаров',
            'url' => '/admin/import-excel',
            'icon' => '<i class="fa-solid fa-file-import fa-4x"></i>'
        ],
        'categories' => [
            'title' => 'Категории товаров',
            'url' => '/admin/products-categories',
            'icon' => ' <i class="fa-solid fa-list fa-4x"></i>'
        ],
        'brands' => [
            'title' => 'Производители',
            'url' => '/brands',
            'icon' => ' <i class="fa-solid fa-industry fa-4x"></i>'
        ],
        'reviews' => [
            'title' => 'Отзывы',
            'url' => '/reviews',
            'icon' => '<i class="fa-solid fa-users-line fa-4x"></i>'
        ],
        'rules' => [
            'title' => 'Управление доступом',
            'url' => '/controller-rules',
            'icon' => '<i class="fa-solid fa-pen-ruler fa-4x"></i>'
        ],
    ];

    public function getMainUserRole(): AuthAssignment
    {
        $userRoles = AuthAssignment::find()->where(['user_id' => Yii::$app->user->id])->all();
        if (count($userRoles) === 1) {
            return $userRoles[0];
        }
        /** @var AuthAssignment $role */
        foreach ($userRoles as $roleKey => $role) {
           if ($role->item_name === 'admin') {
               return $role;
           }
        }

        return $userRoles[0];
    }

    /**
     * @return array|false
     */
    public function getUserMenuTiles()
    {
        $menuTiles = [];

        $userRole = $this->getMainUserRole();
        $authItem = AuthItem::findOne(['name' => $userRole->item_name]);


        if (!empty($authItem->admin_tiles)) {
            if ($authItem->name === 'admin') {
                return self::ADMIN_TILES;
            }
            $tilesNames =  json_decode($authItem->admin_tiles);
            foreach ($tilesNames as $tileName) {
                if (isset(self::ADMIN_TILES[$tileName])) {
                    $menuTiles[$tileName] = self::ADMIN_TILES[$tileName];
                }
            }

            return $menuTiles;
        }

        return false;
    }
}