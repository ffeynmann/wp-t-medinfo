<?php
$sliderTopNews = \App\Posts::getItems([
        'post_per_page' => 12,
        'post__in'      => \App\Posts::topNews(),
        'category__in'  => [2]
    ]
);
?>
<?php if($sliderTopNews['items']): ?>
<div class="block-top-news">
    <div class="top">
        <span class="pre-icon lg fire-2 size-h1"><?= __('ТОП новости', 'def') ?></span>
        <div class="only-d">
            <span data-prev class="pre-icon xl arrow-round-left no-margin hoverable"></span>
            <span data-next class="pre-icon xl arrow-round-right no-margin hoverable ml-3"></span>
        </div>
    </div>
    <div class="swiper slider top-news mt-6">
        <div class="swiper-wrapper items-wrapper" data-config="<?= htmlentities(json_encode($sliderTopNews)) ?>">
            <div class="swiper-slide" v-for="(item,index) in config.items">
                <thumb-news :item="item" :key="item.ID"></thumb-news>
            </div>
        </div>
        <div class="bottom only-m">
            <span data-prev class="pre-icon xxxl arrow-round-left no-margin hoverable mr-3"></span>
            <div class="swiper-pagination"></div>
            <span data-next class="pre-icon xxxl arrow-round-right no-margin hoverable ml-3"></span>
        </div>
    </div>
</div>
<?php endif ?>
