<?php
$bigSliderPosts = \App\Posts::getItems([
        'to_home'        => 1,
        'posts_per_page' => 6,
        'category__in'   => [2]
    ]
);
?>

<div class="swiper slider big-post">
    <div class="swiper-wrapper">
        <?php foreach ($bigSliderPosts['items'] as $item): ?>
            <div class="swiper-slide">
                <div class="slide-big-post" style="background-image:url('<?= $item['image_slider'] ?>')">
                    <a href="<?= $item['link'] ?>" class="title"><?= $item['title'] ?></a>
                    <div class="bg"></div>
                    <div class="bottom">
                        <div class="pre-icon md clock-white margin5" data-load-times="<?= $item['ID'] ?>"></div>
                        <div class="pre-icon md eye-white margin5 ml-5" data-load-views="<?= $item['ID'] ?>"><?= $item['views'] ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
