<?php global
$post;

$postData = \App\Posts::toWeb($post);

//$app->helper->dump(get_post_meta('photo', $post->ID));
//\App\Helper::dump($postData);

$args = [
    'posts_per_page'    => 2,
    'post_type'         => 'knp',
    'remove_pagination' => 1,
    'post__not_in'      => [$post->ID]
];

$readMoreData = \App\Posts::getItems($args);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
    <?php get_template_part('head'); ?>
<body <?php body_class() ?>>
    <?php get_header() ?>

    <div class="container mb-5 company">
        <div class="vue-company" data-locations="<?= htmlentities(json_encode($postData['locations'])) ?>">
            <div class="top">
                <h1><?php the_title() ?></h1>
            </div>
            <?php if(!empty($postData['company_type'])): ?>
                <div class="subtitle"><?= $postData['company_type'] ?></div>
            <?php endif ?>
            <div class="middle mt-5">
                <div class="left">
                    <div class="image-wrapper">
                        <img class="image" src="<?= $postData['photo'] ?>">
                    </div>
                    <span class="stars-wrapper">
                        <?= __('Средняя оценка', 'def') ?>:
                            <span class="vue-inst d-inline-block m564">
                                <stars m_class="md ml-2" level="<?= $postData['rating'] ?>" v-model="test"></stars>
                            </span>
                        </span>
                    <div class="pre-icon md tel w-100 mt-4">
                        <div>
                            <?php foreach ($postData['phones'] as $index => $phone): ?>
                                <a style="white-space:nowrap" href="tel:<?= $phone['number'] ?>"><?= $phone['number'] ?></a><?php if($index < (count($postData['phones']) - 1)): ?><span>,&nbsp;</span><?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if(!empty($postData['site'])): ?>
                        <div class="pre-icon md globe w-100">
                            <a href="<?= $postData['site'] ?>"
                               rel="nofollow"
                               target="_blank">
                                <?= $postData['site'] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <template v-if="locations && locations.length">
                        <div class="pre-icon md location w-100"
                             v-if="locations.length == 1"
                             v-html="location.address"></div>
                        <company-locations :value="location" :locations="locations" v-if="locations.length > 1" v-model="location"></company-locations>
                    </template>

                </div>
                <div class="right">
                    <?php if(!empty($postData['content'])): ?>
                        <div class="content text-justify"><?= $postData['content'] ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="map mt-5" v-if="location.map" v-html="location.map"></div>
<!--            <div class="mt-4">-->
<!--                --><?php //get_template_part('templates/parts/author'); ?>
<!--            </div>-->
        </div>

        <div class="vue-inst mt-6">
            <comments data-post="<?= $post->ID?>" data-type="review"></comments>
        </div>
        <div class="vue-inst mt-10">
            <form-review data-post="<?= $post->ID ?>" data-symbols-limit="1000"></form-review>
        </div>
    </div>

    <div class="container">
        <div class="grid items-wrapper cols2 mt-8 mb-8" data-config="<?= htmlentities(json_encode($readMoreData)) ?>">
            <div class="size-h1 text-center"><?= __('Смотрите также', 'def') ?></div>
            <div class="inner mt-4">
                <template v-for="(item,index) in config.items">
                    <thumb-company :item="item" :key="item.ID"></thumb-company>
                </template>
            </div>
        </div>
    </div>


<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

