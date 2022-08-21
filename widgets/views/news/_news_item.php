<?php

/** @var \app\models\News $model * */
?>
<div class="news-list-container col-lg-4">
    <a href="<?= $model->fullUrl ?>">
        <div class="news-list-item">
            <div class="news-list-thumbar" style="background: top/cover url('<?= $model->thumbarPath ?>');"></div>
            <div class="news-list-text p-3">
                <h3 class="news-list-title"><?= $model->name ?></h3>
                <div class="news-list-desc">
                    <?= $model->name ?>
                </div>
            </div>
        </div>
    </a>
</div>