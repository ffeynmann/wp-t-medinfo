<?php global
$app, $post;

$postData = \App\Posts::toWeb($post);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>

<div class="container mt-7 mb-7 stattya" data-visit-post="<?= $postData['ID'] ?>">
    <div class="inner">
        <div class="text-center">
            <span class="flag"><?= __('Полезные статьи', 'def') ?></span>
        </div>
        <h1 class="text-center mt-5"><?= get_the_title() ?></h1>
        <div class="info mt-3">
            <span class="pre-icon sm clock margin5" data-load-times="<?= $postData['ID'] ?>"></span>
            <span class="pre-icon sm eye ml-3 margin5" data-load-views="<?= $postData['ID'] ?>"><?= $postData['views'] ?></span>
        </div>
        <?php if(!empty($postData['image_slider'])): ?>
            <div class="image mt-2" style="background-image: url('<?= $postData['image_slider'] ?>')"></div>
        <?php endif; ?>
        <div class="stattya-content text-justify mt-5 mb-5"><?= apply_filters('the_content', $post->post_content) ?></div>
        <div class="bottom mt-5">
            <?php get_template_part('templates/parts/author'); ?>
            <div class="social"></div>
        </div>
        <div class="divider mt-3 mb-5"></div>

        <div class="vue-inst">
            <comments data-post="<?= $post->ID?>" data-type="comment"></comments>
        </div>
    </div>
</div>

<div class="vue-inst">
    <modal size="sm" name="modalFormComment">
        <form-comment data-post="<?= $post->ID ?>"></form-comment>
    </modal>
</div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

