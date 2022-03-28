<?php
$rollNews = \App\Posts::getItems([
        'posts_per_page' => 6,
        'category__in'   => [2]
    ]
);
?>

<div class="roll-news">
    <h2 class="size-h2"><?= __('Лента новостей', 'def') ?></h2>
    <div class="items-wrapper" data-config="<?= htmlentities(json_encode($rollNews)) ?>">
        <div class="inner">
            <roll-news v-for="item in config.items" :item="item" :key="item.ID"></roll-news>
        </div>
    </div>

</div>