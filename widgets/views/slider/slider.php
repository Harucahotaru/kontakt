<?php
$slides = \app\models\Slider::getMainSlides();
?>
<div id="carouselIndicator" class="carousel slide carousel-fade main-slider" data-bs-ride="true">
    <div class="carousel-indicators">
        <?php foreach ($slides as $slideNum=>$slide): ?>
            <button type="button" data-bs-target="#carouselIndicator" data-bs-slide-to="<?= $slideNum ?>" <?=($slideNum == 0) ? 'class = "active"' : ''?>
                    aria-current="true" aria-label="Slide <?= $slideNum ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($slides as $slideNum=>$slide): ?>
        <?php /** @var $slide \app\models\Slider **/?>
            <div class="carousel-item <?=($slideNum == 0) ? 'active' : ''?>">
                <div class="carousel-image" style="background: top/cover url('<?=$slide?>'); "></div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicator"
            data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicator"
            data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>