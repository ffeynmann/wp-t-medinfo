<?php global
$app, $post;

$paged = get_query_var('paged') ?: 1;

$postsData = \App\Posts::getItems([
        'posts_per_page' => 20,
        'category__in'   => [$post->term_id],
        'paged'          => $paged
    ]
);

$allNewsCats = \App\Posts::allNewsCats();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>

<div class="container mt-5 mb-5 ">

    <div style="display: none">
        <?php \App\Posts::fakeDiv($postsData) ?>
    </div>
    <div class="grid items-wrapper cols4 mt-3" data-config="<?= htmlentities(json_encode($postsData)) ?>">
        <h1 class="mb-4">
            <?= $post->name ?>
            <span v-if="busy" class="loader"></span>
        </h1>
        <filter-tax-d :value="config.tag_id" v-model="config.tag_id"
                      class="only-d"
                      all="<?= __('Все новости', 'def') ?>"
                      :items="config.cats"
        ></filter-tax-d>

        <filter-tax-m :value="config.tag_id" v-model="config.tag_id"
                      class="only-m"
                      add_class="news"
                      text="<?= __('Выберите рубрику', 'def') ?>"
                      all="<?= __('Все новости', 'def') ?>"
                      :items="config.cats"
        ></filter-tax-m>
        <div class="inner mt-3">
            <template v-for="(item,index) in config.items">
                <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                      v-if="index != 0 && index % 8 === 0"
                ></x567>
                <transition name="fade" mode="out-in" appear>
                    <thumb-news :item="item" :key="item.ID"></thumb-news>
                </transition>

            </template>
        </div>
        <button-more :config="config"></button-more>
        <div style="display: none"><?php \App\Posts::fakePagination($postsData, \App\Helper::urlRemovePage(\App\Base::$currentUrl)) ?> </div>
    </div>
</div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>


