<?php global
$app, $post;



$lastNewsData = $app->posts->getItems([
        'per_page'          => 12,
        'page'              => 1,
        'type'              => 'post',
        'cats'              => [2],
        'remove_pagination' => 1
    ]
);

$lastPostsData = $app->posts->getItems([
        'per_page' => 8,
        'page'     => 1,
        'type'     => 'post',
        'cats'     => [3]
    ]
);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
    <?php get_header() ?>
    <div class="home-banner only-d"></div>
    <img class="home-banner only-m w-100" src="<?= $app->url ?>dist/images/home-banner-1-m.jpg">

    <div class="container mt-6 mb-8">
        <div class="columns-2 m-r">
            <div class="min only-d">
                <?php get_template_part('templates/parts/roll-news') ?>
                <div class="vue-inst">
                    <x567 data-src="<?= htmlentities(json_encode($app->bannersSqueare())) ?>"></x567>
                </div>
            </div>
            <div class="full">
                <?php get_template_part('templates/parts/slider-post-big') ?>
                <div class="mt-8"></div>
                <?php get_template_part('templates/parts/block-top-news') ?>

                <div>
                    <div class="top-header">
                        <h1><?= __('Последние новости', 'def') ?></h1>
                        <a href="#" class="button only-d">
                            <?= __('Все новости', 'def') ?>
                            <psan class="pre-icon md arrow-top-right-2 no-margin ml-2"></psan>
                        </a>
                    </div>
                    <div class="grid items-wrapper cols3 mt-5" data-config="<?= htmlentities(json_encode($lastNewsData)) ?>">
                        <div class="inner">
                            <template v-for="(item,index) in config.items">
                                <x567 m_class="in-row" data-src="<?= htmlentities(json_encode($app->bannersRow())) ?>"
                                      v-if="index != 0 && index % 6 === 0"
                                ></x567>
                                <thumb-news :item="item" :key="item.ID"></thumb-news>
                            </template>
                        </div>
                        <div class="text-center mt-5" v-if="config.page < config.pages">
                            <div class="button ws-4 pre-icon md reload"
                                 :class="{active: busy}"
                                 @click="more"><?= __('Показать еще', 'def') ?></div>
                        </div>
                    </div>
                    <div class="text-center only-m mt-4">
                        <a href="#" class="button">
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

