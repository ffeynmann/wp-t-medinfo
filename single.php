<?php global
$app, $post;

$postData = \App\Posts::toWeb($post);

if(has_term(3, 'category')) {
    get_template_part('stattya');
    die();
}


$readMoreData = \App\Posts::getItems([
    'posts_per_page'    => 4,
    'paged'             => 1,
    'post_type'         => 'post',
    'category__in'      => [2],
    'remove_pagination' => 1,
    'post__not_in'      => [$post->ID]
]);
$a = 9;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
    <?php get_template_part('head'); ?>
<body <?php body_class() ?>>
    <?php get_header() ?>

    <div class="container mt-5 mb-8">
        <div class="columns-2 m-l">
            <div class="full">
                <div class="post" data-visit-post="<?= $postData['ID'] ?>">
                    <h1><?= get_the_title() ?></h1>
                    <div class="info mt-4">
                        <div class="only-d tags">
                            <?php foreach($postData['tags'] as $tag): ?>
                                <a href="<?= $tag['link'] ?>" class="tag" style="background-color: <?= $tag['color'] ?>"><?= $tag['title'] ?></a>
                            <?php endforeach; ?>
                            <?php if(!empty($postData['top'])): ?>
                                <span class="pre-icon md fire"><?= __('ТОП новость', 'def') ?></span>
                            <?php endif ?>
                        </div>
                        <div class="right">
                            <div class="pre-icon sm clock margin5" data-load-times="<?= $postData['ID'] ?>"></div>
                            <div class="pre-icon sm eye ml-3 margin5" data-load-views="<?= $postData['ID'] ?>"><?= $postData['views'] ?></div>
                        </div>
                    </div>
                    <?php if(!empty($postData['image_slider'])): ?>
                        <div class="image mt-2" style="background-image: url('<?= $postData['image_slider'] ?>')">
                            <?php if(!empty($postData['top'])): ?>
                                <span class="pre-icon lg fire only-m"></span>
                            <?php endif ?>
                            <div class="image-tags only-m">
                                <?php foreach($postData['tags'] as $tag): ?>
                                    <span class="tag" style="background-color: <?= $tag['color'] ?>"><?= $tag['title'] ?></span>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    <?php endif; ?>
                    <div class="content text-justify mt-5"><?= apply_filters('the_content', $post->post_content) ?></div>
                    <div class="bottom mt-5">
                        <?php get_template_part('templates/parts/author'); ?>
                        <div class="social"></div>
                    </div>
                </div>
                <div class="divider mt-3 mb-5"></div>

                <div class="vue-inst">
                    <comments data-post="<?= $post->ID?>" data-type="comment"></comments>
                </div>
            </div>
            <div class="min only-d">
                <div class="vue-inst">
                    <x567 data-src="<?= htmlentities(json_encode(\App\Base::bannersSquare())) ?>"></x567>
                </div>
                <?php get_template_part('templates/parts/top-comments-news'); ?>
<!--                <div class="vue-inst">-->
<!--                    <x567 data-src="--><?//= htmlentities(json_encode(\App\Base::bannersSquare())) ?><!--"></x567>-->
<!--                </div>-->
            </div>
        </div>
        <div class="grid items-wrapper cols4 mt-3" data-config="<?= htmlentities(json_encode($readMoreData)) ?>">
            <div class="size-h1"><?= __('Читайте также', 'def') ?></div>
            <div class="inner mt-4">
                <template v-for="(item,index) in config.items">
                    <thumb-news :item="item" :key="item.ID"></thumb-news>
                </template>
            </div>
        </div>
    </div>

    <div class="vue-inst">
        <modal size="sm" name="modalFormComment">
            <form-comment data-post="<?= $post->ID ?>" data-symbols-limit="2000"></form-comment>
        </modal>
    </div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

