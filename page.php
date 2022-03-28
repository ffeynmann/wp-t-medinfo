<?php global
$app, $post;

$postData = \App\Posts::toWeb($post);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
<?php get_template_part('head'); ?>
<body <?php body_class() ?>>
<?php get_header() ?>

<div class="container mt-7 mb-7 stattya">
    <div class="inner">
        <h1 class="text-center mt-5"><?= get_the_title() ?></h1>
        <?php if(!empty($postData['image'])): ?>
            <div class="image mt-2" style="background-image: url('<?= $postData['image'] ?>')"></div>
        <?php endif; ?>
        <div class="stattya-content mt-5 mb-5"><?= $postData['content'] ?></div>
        <div class="divider mt-3 mb-5"></div>
        <?php if(!in_array(get_the_ID(), \App\Base::$idsCommentsDisabled)): ?>
            <div class="vue-inst">
                <comments data-post="<?= $post->ID?>" data-type="comment"></comments>
            </div>
        <?php endif; ?>
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

