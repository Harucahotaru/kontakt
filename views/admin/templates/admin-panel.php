<?php

use app\classes\AdminMenu;
$adminPanel = new AdminMenu();
?>
<?php if (Yii::$app->user->isGuest): ?>
<?php if ($adminTiles = $adminPanel->getUserMenuTiles()): ?>
    <div class="offcanvas offcanvas-end" style="width: 150px" tabindex="-1" id="offcanvasExample"
         aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header text-center" style="display: block">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a href="#/admin" class="badge bg-success ps-4 pe-4">Админка</a>
            </h5>
        </div>
        <div class="offcanvas-body">
            <?php foreach ($adminTiles as $tile): ?>
                <div class="row mt-2 text-center">
                    <a href="<?= $tile['url'] ?>" data-bs-toggle="tooltip" data-bs-placement="left"
                       title="<?= $tile['title'] ?>">
                        <?= $tile['icon'] ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="position-fixed" style="right:10%; top:10%; z-index: 300">
        <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
           aria-controls="offcanvasExample">
            <i class="fa-solid fa-gear"></i>
        </a>
    </div>
<?php endif; ?>
<?php endif; ?>
