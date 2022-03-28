<?php global
$app, $post;
// $post == $WP_Term

$paged = get_query_var('paged') ?: 1;

$postsData = \App\Posts::getItems([
    'posts_per_page' => 20,
    'category__in'   => [$post->term_id],
    'paged'          => $paged
]);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>

<div class="container mt-5 mb-5 ">

    <h1><?= $post->name ?></h1>
    <div style="display: none">
        <?php \App\Posts::fakeDiv($postsData) ?>
    </div>

    <div class="grid items-wrapper cols2 mt-3" data-config="<?= htmlentities(json_encode($postsData)) ?>">
        <div class="inner">
            <template v-for="(item,index) in config.items">
                <transition name="fade" mode="out-in" appear>
                    <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                          v-if="index != 0 && index % 6 === 0"
                    ></x567>
                </transition>
                <transition name="fade" mode="out-in" appear>
                    <thumb-post :item="item" :key="item.ID"></thumb-post>
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


