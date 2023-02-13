<?php

use app\models\User;
use kartik\typeahead\Typeahead;

$user = new User();
?>
<div class="row menu-item-small">
    <div class="col-lg-3"></div>
    <div class="col-lg-5 ps-1 align-self-center">
        <div class="row">
            <div class="col-lg-10" style="padding-right: 0">
                <?= Typeahead::widget([
                    'name' => 'search',
                    'options' => ['placeholder' => 'Я ищу ...'],
                    'pluginOptions' => ['highlight' => true],
                    'scrollable' => true,
                    'pluginEvents' => [
                        "typeahead:select" => 'function(event, response) { location.href=response.url }',
                    ],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'minLength' => 3,
                            'remote' => [
                                'url' => '/site/search-products' . '?string=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ],
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'minLength' => 3,
                            'remote' => [
                                'url' => '/brands/search' . '?string=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ],
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'minLength' => 3,
                            'remote' => [
                                'url' => '/site/search-categories' . '?string=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]
                    ]
                ]); ?>
            </div>
            <div class="col-lg-2" style="padding-left: 0">
                <button type="button" class="btn btn-dark" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-1 align-self-center">
        <?php if ($user->canUser(User::CAN_USE_CART)): ?>
        <a class="fa-stack menu-icon" href="<?= Yii::$app->user->isGuest ? '/user/login' : '#/user/cart' ?>"
           style="vertical-align: top;">
            <i class="fa-regular fa-circle fa-stack-2x"></i>
            <i class="fa-solid fa-cart-shopping fa-stack-1x"></i>
        </a>
        <?php endif; ?>
        <a class="fa-stack menu-icon" href="<?= Yii::$app->user->isGuest ? '/user/login' : '/user/profile' ?>"
           style="vertical-align: top;">
            <i class="fa-regular fa-circle fa-stack-2x"></i>
            <i class="fa-solid fa-user fa-stack-1x"></i>
        </a>
    </div>
    <div class="col-lg-1 pt-2 "><b><?= (Yii::$app->user->isGuest) ? "Гость" : Yii::$app->user->identity->username ?></b>
    </div>
    <div class="col-lg-2 align-self-end">
    </div>
</div>