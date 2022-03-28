<div class="container only-m-d header-wrapper-d" >
    <div class="top-row-d">
        <div class="phone-mail xb4">
            <a href="tel:<?= \App\Base::$options['phone'] ?>" class="phone pre-icon tel-color md"><?= \App\Base::$options['phone'] ?></a>
            <a href="mailto:medinfo@gmail.com" class="pre-icon mail md"><?= \App\Base::$options['e_mail'] ?></a>
        </div>
        <a href="<?= \App\Base::$siteUrl ?>" class="logo">
            <img width="215px" alt="logo" src="<?= \App\Base::$url ?>dist/images/logo.png?2">
        </a>
        <div class="xb6">
            <div class="search-wrapper-d" :class="{focused: search_focused}">
                <form class="inner" action="<?= \App\Base::$siteUrl ?>">
                    <input type="search" name="s"
                           value="<?= get_search_query() ?>"
                           placeholder="<?= __('Что ищете?', 'def') ?>"
                           @focus="search_focused = 1"
                           @blur="search_focused = 0"
                    >
                    <button type="submit"></button>
                </form>
            </div>
            <div class="social">
                <a href="<?= \App\Base::$options['link_fb'] ?>" target="_blank" rel="nofollow" class="pre-icon fb lg"></a>
                <a href="<?= \App\Base::$options['link_tm'] ?>" target="_blank" rel="nofollow" class="pre-icon tm lg"></a>
            </div>
            <div class="language-d">
                <div class="vis"><?= \App\Language::$currentHuman ?></div>
                <a href="<?= \App\Language::$anotherLink ?>" class="sub"><?= \App\Language::$anotherHuman ?></a>
            </div>
        </div>
    </div>
</div>