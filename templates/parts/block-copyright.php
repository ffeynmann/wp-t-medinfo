<div class="copyright">
    <div class="text-1">
        <?= sprintf(__('Copyright ©%s  - Medinfo. Медицинские новости Запорожья - Все права защищены', 'def'), date('Y')) ?>
    </div>
    <?php if(\App\Base::$currentUrl . '/' != \App\Base::$options['rules_copy']): ?>
        <a href="<?= \App\Base::$options['rules_copy'] ?>" class="text-2"><?= __('Правила копирования материалов', 'def') ?></a>
    <?php else: ?>
        <span class="text-2"><?= __('Правила копирования материалов', 'def') ?></span>
    <?php endif; ?>

    <?php if(\App\Base::$currentUrl . '/' != \App\Base::$options['rules_conf']): ?>
        <a href="<?= \App\Base::$options['rules_conf'] ?>" class="text-3"><?= __('Политика конфиденциальности', 'def') ?></a>
    <?php else: ?>
        <span class="text-3"><?= __('Политика конфиденциальности', 'def') ?></span>
    <?php endif; ?>

    <?php if(\App\Base::$currentUrl . '/' != \App\Base::$options['cooperation']): ?>
        <a href="<?= \App\Base::$options['cooperation'] ?>" class="text-4"><?= __('Сотрудничество', 'def') ?></a>
    <?php else: ?>
        <span class="text-4"><?= __('Сотрудничество', 'def') ?></span>
    <?php endif; ?>
</div>