<?php global $app, $post;
$qObj = get_queried_object();
$qObj instanceof WP_Term && $post = $qObj;
?>
<?php if(!is_front_page()): ?>
<div class="breadcrumbs">
    <div class="container inner">
        <a href="javascript:history.back()" class="link-back font-color-1 pre-icon md arrow-back-color"><?= __('Вернуться назад', 'def') ?></a>
        <?php if($post && !empty($post->post_title)): ?>
            <span class="post-name only-d pre-icon md line-vertical no-margin"><?php the_title() ?></span>
        <?php endif; ?>
    </div>
</div>
<?php endif ?>