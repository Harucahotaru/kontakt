<?php

use kartik\typeahead\Typeahead;

?>
<div class="row menu-item-small">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-5 ps-1 align-self-center">
        <div class="row">
            <div class="col-lg-11 p-0">
                <?= Typeahead::widget([
                    'name' => 'search',
                    'options' => ['placeholder' => 'Я ищу ...'],
                    'pluginOptions' => ['highlight' => true],
                    'scrollable' => true,
                    'pluginEvents' => [
                        "typeahead:select" => 'function(event, response) {
                 location.href=response.url
                }',
                    ],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'minLength' => 3,
                            'remote' => [
                                'url' => '/site/search' . '?string=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]
                    ]
                ]); ?>
                <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
                <script>
                    $('input').on('keypress', function (e) {
                        if (e.which == 13) {
                            location.href = '/catalog/search/' + this.value
                        }
                    });

                    // $('#search').on('click', function() {
                    //     console.log($(".tt-hint"))
                    //     // location.href = '/catalog/search/' + this.value;
                    // });
                </script>
            </div>
<!--            <div class="col-lg-2 p-0">-->
<!--                <div class="input-group-append input-button menu-btn-input">-->
<!--                    <button type="button" class="btn btn-dark" id="search">-->
<!--                        <i class="fas fa-search"></i>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
    <div class="col-lg-1 align-self-center">
        <a class="fa-stack menu-icon" href="#" style="vertical-align: top;">
            <i class="fa-regular fa-circle fa-stack-2x"></i>
            <i class="fa-solid fa-cart-shopping fa-stack-1x"></i>
        </a>
        <a class="fa-stack menu-icon" href="#" style="vertical-align: top;">
            <i class="fa-regular fa-circle fa-stack-2x"></i>
            <i class="fa-solid fa-user fa-stack-1x"></i>
        </a>
    </div>
    <div class="col-lg-1 pt-2 "><b><?= (Yii::$app->user->isGuest) ? "Гость" : Yii::$app->user->identity->username ?></b>
    </div>
    <div class="col-lg-2 align-self-end">
        <!--        Следите за нами-->
    </div>
</div>