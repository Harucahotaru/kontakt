<?php /** @var \app\models\Brands[] $brands * */ ?>
<div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-inner brand-list">
        <?php foreach ($brands as $key => $brand): ?>
            <?php if (($key % 6) === 0): ?>
                <div class="carousel-item <?php if($key===0):?>active<?php endif;?>">
                <div class="brand-list-container">
            <?php endif; ?>
            <?php if (($key % 3) === 0): ?>
                <div class="row">
            <?php endif; ?>
                <?= $this->render("_item",['brand' => $brand]) ?>
            <?php if (((($key + 1) % 3) === 0) || array_key_last($brands) === $key): ?>
                </div>
            <?php endif; ?>
            <?php if ((($key + 1) % 6) === 0 || array_key_last($brands) === $key): ?>
                </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>