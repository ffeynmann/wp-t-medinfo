<?php
/*
Template Name: Главная
*/
?>

<?php global $post;

$lastNewsData = \App\Posts::getItems([
        'to_home'           => 1,
        'posts_per_page'    => 12,
        'category__in'      => [2],
        'remove_pagination' => 1
    ]
);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
    <?php get_header() ?>
    <div class="home-banner only-d" style="background-image:url('<?= \App\Base::$url ?>dist/images/home-banner-1-d-<?= \App\Language::$current ?>.jpg')"></div>
    <img class="home-banner only-m w-100" src="<?= \App\Base::$url ?>dist/images/home-banner-1-m-<?= \App\Language::$current ?>.jpg">

    <div class="container mt-6 mb-8">
        <div class="columns-2 m-r">
            <div class="min only-d">
                <?php get_template_part('templates/parts/roll-news') ?>
                <div class="vue-inst">
                    <x567 data-src="<?= htmlentities(json_encode(\App\Base::bannersSquare())) ?>"></x567>
                </div>
            </div>
            <div class="full">
                <?php get_template_part('templates/parts/slider-post-big') ?>
                <div class="mt-8"></div>
                <?php get_template_part('templates/parts/block-top-news') ?>

                <div>
                    <div class="top-header">
                        <h1><?= __('Последние новости', 'def') ?></h1>
                        <a href="<?= get_term_link(2, 'category') ?>" class="button only-d">
                            <?= __('Все новости', 'def') ?>
                            <psan class="pre-icon md arrow-top-right-2 no-margin ml-2"></psan>
                        </a>
                    </div>
                    <div style="display: none">
                        <?php \App\Posts::fakeDiv($lastNewsData) ?>
                    </div>
                    <div class="grid items-wrapper cols3 mt-5" data-config="<?= htmlentities(json_encode($lastNewsData)) ?>">
                        <div class="inner">
                            <template v-for="(item,index) in config.items">
                                <x567 m_class="in-row" data-src="<?= htmlentities(json_encode(\App\Base::bannersRow())) ?>"
                                      v-if="index != 0 && index % 6 === 0"
                                ></x567>
                                <thumb-news :item="item" :key="item.ID"></thumb-news>
                            </template>
                        </div>
                        <button-more :config="config"></button-more>
                    </div>
                    <div class="text-center only-m mt-4">
                        <a href="<?= get_term_link(2, 'category') ?>" class="button">
                            <?= __('Все новости', 'def') ?>
                            <span class="pre-icon md arrow-top-right-2 no-margin ml-2"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

