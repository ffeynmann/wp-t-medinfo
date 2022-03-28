<div class="bottom-row-m only-m-m">
    <div class="left nav-footer-m size-h4">
        <?php foreach (\App\Base::$menu as $item): ?>
            <a href="<?= $item->url ?>" class="pre-icon menu-sprite md <?= implode(' ', $item->classes) ?>">
                <?= $item->title ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="right">
        <a href="tel:<?= \App\Base::$options['phone'] ?>" class="phone pre-icon tel-color md"><?= \App\Base::$options['phone'] ?></a>
        <a href="mailto:medinfo@gmail.com" class="pre-icon mail md"><?= \App\Base::$options['e_mail'] ?></a>
        <div class="social mt-3">
            <a href="<?= \App\Base::$options['link_fb'] ?>" target="_blank" class="pre-icon fb lg"></a>
            <a href="<?= \App\Base::$options['link_tm'] ?>" target="_blank" class="pre-icon tm lg"></a>
<!--            <a href="--><?//= $app->options['link_vb'] ?><!--" target="_blank" class="pre-icon vb lg"></a>-->
        </div>
        <a href="#" class="button mt-3 hs-2 w-100 no-padding" data-request-call><?= __('Обратная связь','def') ?></a>
    </div>
</div>