<?php

use app\models\Products;
use yii\widgets\ListView;

?>
<h2 class="py-3">Каталог товаров</h2>
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
