<?php if (Yii::$app->user->can('admin')): ?>
    <div class="offcanvas offcanvas-end" style="width: 150px" tabindex="-1" id="offcanvasExample"
         aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header text-center" style="display: block">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a href="/admin" class="badge bg-success ps-4 pe-4">Админка</a>
            </h5>
        </div>
        <div class="offcanvas-body">

            <div class="row mt-2 text-center">
                <a href="/admin/slider" data-bs-toggle="tooltip" data-bs-placement="left" title="Слайдер">
                    <i class="fa-regular fa-images fa-4x"></i>
                </a>
            </div>
<!--            <div class="row mt-2 text-center">-->
<!--                <a href="/admin/news" data-bs-toggle="tooltip" data-bs-placement="left" title="Новости">-->
<!--                    <i class="fa-solid fa-newspaper fa-4x"></i>-->
<!--                </a>-->
<!--            </div>-->
            <div class="row mt-2 text-center">
                <a href="/admin/pages" data-bs-toggle="tooltip" data-bs-placement="left" title="Контент страниц">
                    <i class="fa-regular fa-file-word fa-4x"></i>
                </a>
            </div>
<!--            <div class="row mt-2 text-center">-->
<!--                <a href="/admin/products" data-bs-toggle="tooltip" data-bs-placement="left" title="Продукты">-->
<!--                    <i class="fa-solid fa-tags fa-4x"></i>-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </div>
    <div class="position-fixed" style="right:10%; top:10%">
        <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
           aria-controls="offcanvasExample">
            <i class="fa-solid fa-gear"></i>
        </a>
    </div>
<?php endif; ?>