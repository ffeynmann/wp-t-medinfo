<?php global
$app, $post;

$newsSearchData = \App\Posts::getItems([
        'post_per_page' => 8,
        'post__in'      => \App\Base::$searchResults,
        'category__in'  => [2],
    ]
);

$postsSearchData = \App\Posts::getItems([
        'posts_per_page' => 3,
        'post__in'       => \App\Base::$searchResults,
        'category__in'   => [3],
    ]
);

$companiesSearchData = \App\Posts::getItems([
        'post_type'     => 'company',
        'posts_per_page' => 6,
        'post__in'      => \App\Base::$searchResults,
    ]
);

?>
<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>" <?php body_class() ?>>
    <?php get_template_part('head'); ?>
    <body <?php body_class() ?>>
        <?php get_header() ?>

        <div class="container mt-5 mb-8">
            <div class="columns-2 m-l">
                <div class="full">
                    <h1><?= __('Поиск', 'def')?>: <?= get_search_query() ?></h1>
                    <?php if($companiesSearchData['items']): ?>
                        <h2 class="size-h1 mt-6"><?= __('Медицинские компании Запорожья', 'def')?></h2>
                        <div class="grid items-wrapper mt-3" data-config="<?= htmlentities(json_encode($companiesSearchData)) ?>">
                            <div class="inner mt-3">
                                <template v-for="(item,index) in config.items">
                                    <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                                          v-if="index != 0 && index % 4 === 0"
                                    ></x567>
                                    <thumb-company :item="item" :key="item.ID"></thumb-company>
                                </template>
                            </div>
                            <button-more :config="config"></button-more>                        </div>
                    <?php endif; ?>
                    <?php if($newsSearchData['items']): ?>
                    <h2 class="size-h1 mt-6"><?= __('Новости медицины Запорожья', 'def')?></h2>
                    <div class="grid items-wrapper cols3 mt-3" data-config="<?= htmlentities(json_encode($newsSearchData)) ?>">
                        <div class="inner mt-3">
                            <template v-for="(item,index) in config.items">
                                <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                                      v-if="index != 0 && index % 6 === 0"
                                ></x567>
                                <thumb-news :item="item" :key="item.ID"></thumb-news>
                            </template>
                        </div>
                        <button-more :config="config"></button-more>
                    </div>
                    <?php endif; ?>

                    <?php if($postsSearchData['items']): ?>
                        <h2 class="size-h1 mt-6"><?= __('Полезные статьи', 'def')?></h2>
                        <div class="grid items-wrapper cols1 mt-3" data-config="<?= htmlentities(json_encode($postsSearchData)) ?>">
                            <div class="inner mt-3">
                                <template v-for="(item,index) in config.items">
                                    <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                                          v-if="index != 0 && index % 3 === 0"
                                    ></x567>
                                    <thumb-post :item="item" :key="item.ID"></thumb-post>
                                </template>
                            </div>
                            <button-more :config="config"></button-more>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="min only-d">
                    <div class="vue-inst">
                        <x567 data-src="<?= htmlentities(json_encode(\App\Base::bannersSquare())) ?>"></x567>
                    </div>
                    <?php get_template_part('templates/parts/top-comments-news'); ?>
<!--                    <div class="vue-inst">-->
<!--                        <x567 data-src="--><?//= htmlentities(json_encode(\App\Base::bannersSquare())) ?><!--"></x567>-->
<!--                    </div>-->
                </div>
            </div>
        </div>

    <?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

