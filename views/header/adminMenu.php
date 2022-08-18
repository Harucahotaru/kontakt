<?php $tiles = app\models\AdminTile::getTiles();?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <?php foreach ($tiles as $tile): ?>
                <?php if(yii::$app->user->can($tile->access)): ?>
                <a class="nav-link active" aria-current="page" href="<?=$tile->url?>">
                    <div class="h5 row">
                        <div class="col-lg-2"><?=$tile->label?></div>
                        <div class="col-lg-10"><?=$tile->title?></div>
                    </div>
                </a>
                <?php endif; endforeach; ?>
            </li>
        </ul>
    </div>
</nav>
