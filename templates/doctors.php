<?php
/*
Template Name: Врачи
*/
?>
<?php global
$post;

$qObj = get_queried_object();

$args = [
    'posts_per_page' => 12,
    'post_type'      => 'doctor'
];

$lastCompaniesData = \App\Posts::getItems($args);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>

<div class="container mt-5 mb-5 doctors">
    <div class="grid items-wrapper cols3 mt-3" data-config="<?= htmlentities(json_encode($lastCompaniesData)) ?>">

        <div class="size-h1 text-center"><?= __('Врачи', 'def') ?></div>
        <div class="doctors-search-wrapper mt-6">
            <div class="pre-icon search-gray md ml-4"></div>
            <input type="text" v-model="s" placeholder="<?= __('Поиск врача по фамилии', 'def') ?>">
            <div class="button hs-2"><?= __('Поиск', 'def') ?></div>
        </div>

        <div class="text-center mt-8">
            <h1 class="size-h2">
                <?= get_the_title() ?>
                <span v-if="busy" class="loader"></span>
            </h1>
            <div class="font-color-2"><?php the_content() ?></div>
        </div>
        <div class="inner mt-4">
            <template v-for="(item,index) in config.items">
                <transition name="fade" mode="out-in" appear>
                    <thumb-doctor :item="item" :key="item.ID"></thumb-doctor>
                </transition>
            </template>
        </div>
        <div class="size-h2 text-center mt-6 d-none" :class="{'d-block': !config.items.length}"><?= __('Врачей не найдено', 'def') ?></div>
    </div>
</div>
<div class="bg-color-light-gray mt-8 mb-6">
    <div class="container pt-10 pb-10">
        <div class="text-center">
            <div class="size-h1"><?= __('Последние отзывы о врачах', 'def') ?></div>
            <div class="font-color-2"><?php the_content() ?></div>
        </div>
        <div class="vue-inst">
            <doctor-reviews data-post="" data-type="comment"></doctor-reviews>
        </div>
    </div>
</div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>


