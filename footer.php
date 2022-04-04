
</div>
<div class="vue-modals" style="display: none">
    <modal size="sm" name="call">
        <form-call></form-call>
    </modal>
    <modal size="sm" name="thankyou">
        <div class="size-h1 mt-6 text-center"><?= __('Спасибо', 'def') ?>!</div>
        <div class="text-center mt-6"><?= __('Ваша заявка принята и уже обрабатывается нашими специалистами, оставайтесь пожалуйста на связи', 'def') ?></div>
        <div class="button w-100 mt-4" @click="close"><?= __('Вернуться на сайт', 'def') ?></div>
    </modal>
    <modal size="sm" name="thankreview">
        <div class="size-h1 mt-6 text-center"><?= __('Спасибо за Ваш отзыв', 'def') ?>!</div>
        <div class="button w-100 mt-4" @click="close"><?= __('Вернуться на сайт', 'def') ?></div>
    </modal>
    <modal size="sm" name="message"></modal>
</div>
<footer>
    <div class="scrolltotop"></div>
    <?php get_template_part('templates/parts/block-bottom-row-d'); ?>
    <?php get_template_part('templates/parts/block-bottom-row-m'); ?>
    <?php get_template_part('templates/parts/block-nav-d'); ?>

    <div class="departments-footer only-d">
        <div class="inner">
            <?php foreach (\App\Company::allDepartments() as $department):
                $departmentLink = get_term_link($department);
                ?>

                <?php if($departmentLink != \App\Base::$currentUrl . '/'): ?>
                    <div class="mt-1">
                        <a href="<?= $departmentLink ?>" class="pre-icon md department-sprite <?= $department->slug ?>"><?= $department->name ?></a>
                    </div>
                <?php else: ?>
                    <div class="mt-1">
                        <span class="pre-icon md department-sprite <?= $department->slug ?>"><?= $department->name ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php get_template_part('templates/parts/block-copyright'); ?>
</footer>


