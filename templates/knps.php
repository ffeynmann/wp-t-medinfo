<?php
/*
Template Name: КНП
*/
?>
<?php global
$post;


$qObj = get_queried_object();

$paged = get_query_var('paged') ?: 1;

$args = [
    'posts_per_page' => 8,
    'post_type'      => 'knp',
    'paged'          => $paged
];

$lastCompaniesData = \App\Posts::getItems($args);

//\App\Helper::dump($lastCompaniesData);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>
<?php $qObj instanceof WP_Term && $post = $qObj; ?>

<div class="container mt-5 mb-5 ">
    <div style="display: none">
        <?php \App\Posts::fakeDiv($lastCompaniesData) ?>
    </div>

    <div class="grid items-wrapper cols2 mt-3" data-config="<?= htmlentities(json_encode($lastCompaniesData)) ?>">
            <div class="c432 mb-4">
                <h1>
                    <?= $post instanceof WP_Post ? get_the_title() : $post->name ?>
                    <span v-if="busy" class="loader"></span>
                </h1>

                <filter-tax-m :value="config.city_id" v-model="config.city_id"
                              text="<?= __('Город', 'def') ?>"
                              add_class="cities"
                              all="<?= __('Все города', 'def') ?>"
                              :items="config.cities"></filter-tax-m>
            </div>
            <div class="inner mt-4">
                <template v-for="(item,index) in config.items">
                    <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                          v-if="index != 0 && index % 6 === 0"
                    ></x567>
                    <transition name="fade" mode="out-in" appear>
                        <thumb-company :item="item" :key="item.ID"></thumb-company>
                    </transition>
                </template>
            </div>
            <button-more :config="config"></button-more>
            <div style="display: none"><?php \App\Posts::fakePagination($lastCompaniesData, \App\Helper::urlRemovePage(\App\Base::$currentUrl)) ?> </div>
        </div>
</div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>


