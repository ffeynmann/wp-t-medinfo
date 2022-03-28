<nav class="size-h4 only-m-d nav-d">
    <div class="container">
        <div class="inner">
            <?php foreach (\App\Base::$menu as $item): ?>
                <?php if(in_array('active', $item->classes)): ?>
                    <span  class="pre-icon menu-sprite md <?= implode(' ', $item->classes) ?>">
                        <?= $item->title ?>
                    </span>
                <?php else: ?>
                    <a href="<?= $item->url ?>" class="pre-icon menu-sprite md <?= implode(' ', $item->classes) ?>">
                        <?= $item->title ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</nav>