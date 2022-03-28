<div class="footer-bottom-row-wrapper">
    <div class="container only-m-d ">
        <div class="top-row-d">
            <div class="phone-mail xb4">
                <a href="tel:<?= \App\Base::$options['phone'] ?>" class="phone pre-icon tel-color md"><?= \App\Base::$options['phone'] ?></a>
                <a href="mailto:medinfo@gmail.com" class="pre-icon mail md"><?= \App\Base::$options['e_mail'] ?></a>
            </div>
            <a href="<?= \App\Base::$siteUrl ?>" class="logo">
                <img width="215px" alt="logo" src="<?= \App\Base::$url ?>assets/images/logo.png">
            </a>
            <div class="xb6">
                <a href="#" class="button mr-4 hs-2 ws-3" data-request-call><?= __('Обратная связь','def') ?></a>
                <div class="social">
                    <a href="<?= \App\Base::$options['link_fb'] ?>" target="_blank" class="pre-icon fb lg"></a>
                    <a href="<?= \App\Base::$options['link_tm'] ?>" target="_blank" class="pre-icon tm lg"></a>
<!--                    <a href="--><?//= $app->options['link_vb'] ?><!--" target="_blank" class="pre-icon vb lg"></a>-->
                </div>
            </div>
        </div>
    </div>
</div>