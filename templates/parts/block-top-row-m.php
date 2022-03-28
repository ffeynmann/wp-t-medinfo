<div class="only-m-m header-wrapper-m" :class="{menu_open: menu_open}">
    <div class="container top-row-wrapper-m">
        <div class="top-row-m" :class="{search_focused: search_focused}">
            <div class="menu-toggle" @click="menu_open = !menu_open"></div>
            <a href="<?= \App\Base::$siteUrl ?>" class="logo">
                <img width="160px" alt="logo" src="<?= \App\Base::$url ?>dist/images/logo.png?2">
            </a>
            <div class="search-clickable" @click="search_focused = 1"></div>
            <form class="search-wrapper-m" action="<?= \App\Base::$siteUrl ?>">
                <input type="search" name="s"
                    value="<?= get_search_query() ?>"
                       placeholder="<?= __('Что ищете?', 'def') ?>"
                    >
                <div class="cancel" @click="close_search"></div>
                <button type="submit"></button>
            </form>
        </div>
    </div>
    <div class="menu_mobile">
        <div class="languages">
            <span class="pre-icon md lang active"><?= \App\Language::$currentHumanFull ?></span>
            <a href="<?= \App\Language::$anotherLink ?>" class="pre-icon md lang"><?= \App\Language::$anotherHumanFull ?></a>

        </div>
        <nav class="nav-m">
            <div class="inner">
                <?php foreach (\App\Base::$menu as $item): ?>
                    <a href="<?= $item->url ?>" class="pre-icon menu-sprite md <?= implode(' ', $item->classes) ?>">
                        <?= $item->title ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
        <div class="phone-mail">
            <a href="tel:<?= \App\Base::$options['phone'] ?>" class="phone pre-icon tel-color md"><?= \App\Base::$options['phone'] ?></a>
            <a href="mailto:medinfo@gmail.com" class="pre-icon mail md"><?= \App\Base::$options['e_mail'] ?></a>
        </div>
        <div class="social">
            <a href="<?= \App\Base::$options['link_fb'] ?>" target="_blank" class="pre-icon fb lg"></a>
            <a href="<?= \App\Base::$options['link_tm'] ?>" target="_blank" class="pre-icon tm lg"></a>
<!--            <a href="--><?//= $app->options['link_vb'] ?><!--" target="_blank" class="pre-icon vb lg"></a>-->
        </div>

    </div>
</div>