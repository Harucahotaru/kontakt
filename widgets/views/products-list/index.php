<?php

use app\models\Products;
use yii\widgets\ListView;

//$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//var_dump($url);exit;
?>
<h2 class="py-3">Кабели и растяжки</h2>
<?= ListView::widget([
    'dataProvider' => Products::getAllProductsProvider(),
    'itemView'     => '_products_item',
    'itemOptions'  => [
        'tag' => false,
    ],
    'options'      => [
        'class' => 'row'
    ],
    'layout'       => "{items}",
]);
?>
