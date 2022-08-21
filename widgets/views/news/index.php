<?php

use yii\widgets\ListView;

/**@var string $title Заголовок виджета новостей **/
?>
<h2><?= $title ?></h2>
<?= ListView::widget([
    'dataProvider' => \app\models\News::getLastNewsProvider(),
    'itemView'     => '_news_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row'
    ],
    'layout'       => "{items}",
]);
?>

