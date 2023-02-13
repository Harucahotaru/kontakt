<?php

use app\models\Helpers;

/** @var $url */

$helpers = Helpers::getByUrl($url);
?>
<?php /** @var Helpers $helper */ ?>
<?php if (!empty($helpers)): ?>
    <p>
        <?php foreach ($helpers as $helper): ?>
            <button class="btn btn-secondary mx-1" type="button" data-toggle="collapse"
                    data-target="#collapse<?= $helper->id ?>"
                    aria-expanded="false" aria-controls="collapseExample">
                <?= $helper->label ?>
            </button>
        <?php endforeach; ?>
    </p>
    <?php /** @var Helpers $helper */ ?>
    <?php foreach ($helpers as $helper): ?>
        <div class="collapse py-1" id="collapse<?= $helper->id ?>">
            <div class="card card-body">
                <?= $helper->content ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
