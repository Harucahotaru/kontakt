<?php

/** @var array $previewExcel */

/** @var Products $model */

/** @var array $parsedExcel */

use app\classes\ParseExcel;
use app\models\Products;

?>

    <table class="table table-dark table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <?php foreach ($previewExcel[1] as $colKey => $col): ?>
                <th class="text-center" scope="col"><?= $colKey ?></th>
            <?php endforeach ?>
        </tr>
        </thead>
        <?php foreach ($previewExcel as $rowKey => $row): ?>
            <tr>
                <th scope="row"><?= $rowKey ?></th>
                <?php foreach ($row as $cellKey => $cell): ?>
                    <td><?= $cell ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </table>
<?= $this->render('@app/views/admin/import-excel/_form', [
    'model' => $model,
    'parsedExcel' => $parsedExcel,
    'headers' => ParseExcel::getExcelHeaderForCorrelate($previewExcel),
]); ?>