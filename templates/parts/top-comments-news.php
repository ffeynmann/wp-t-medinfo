<?php
$rollNews = \App\Posts::getItems([
        'posts_per_page' => 5,
        'post__in'       => \App\Posts::topNews(),
        'category__in'   => [2]
    ]
);
?>
<?php if($rollNews['items']): ?>
<div class="roll-news">
    <h2 class="size-h2 pre-icon lg fire-2"><?= __('Сейчас обсуждают', 'def') ?></h2>
    <div class="items-wrapper" data-config="<?= htmlentities(json_encode($rollNews)) ?>">
        <div class="inner">
            <roll-news v-for="item in config.items" :item="item" :key="item.ID"></roll-news>
        </div>
    </div>
</div>
<?php endif ?>