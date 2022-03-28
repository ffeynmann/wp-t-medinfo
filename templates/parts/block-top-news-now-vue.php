<?php
global $app;
$sliderTopNews = \App\Posts::getItems([
        'posts_per_page' => 12,
        'category__in'   => [2]
    ]
);
?>
<div class="swiper slider top-news">
    <div class="swiper-wrapper items-wrapper">
        <?php foreach ($sliderTopNews['items'] as $item): ?>
            <div class="swiper-slide">
                <a href="<?= $item['link'] ?>" class="item thumb-news">
                    <div class="inner">
                        <div class="image" style="background-image: url('<?= $item['image'] ?>')">
                            <div class="tags">
                                <?php foreach ($item['tags'] as $tag): ?>
                                    <span class="tag" style="background-color: <?= $tag['color'] ?>"><?= $tag['title'] ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="info">
                            <div class="title" ><?= $item['title'] ?></div>
                            <div class="date-views">
                                <div class="pre-icon sm clock margin5"><?= $item['date'] ?></div>
                                <div class="pre-icon sm eye margin5"><?= $item['views'] ?></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>