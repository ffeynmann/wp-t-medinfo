<?php global
$post;

$postData = \App\Posts::toWeb($post);

//\App\Helper::dump(\App\DoctorsHelper::positionInRating($postData['ID']));



?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php body_class() ?>>
    <?php get_template_part('head'); ?>
<body <?php body_class() ?>>
    <?php get_header() ?>

    <div class="container mb-5 doctor mb-8">
        <div class="top-row mt-8">
            <div class="image-block">
                <?php if(!empty($postData['position'])): ?>
                    <div class="position" data-position="<?= $postData['position'] ?>"></div>
                <?php endif ?>
                <div class="image" style="background-image: url(<?= $postData['image'] ?>)"></div>
                <div class="info">
                    <span class="size-h5 font-color-2"><?= __('Рейтинг', 'def') ?></span> <span class="pre-icon sm ml-1 star-full"></span>
                    <span class="size-h2"><?= $postData['rating'] ?></span>
                    <span class="ml-5 size-h5 font-color-2"><?= __('Отзывы', 'def') ?></span> <span class="pre-icon sm ml-1 discussion-2"></span>
                    <span class="size-h2"><?= $postData['rating_count'] ?></span>
                </div>
            </div>
            <div class="info-block">
                <h1><?= get_the_title() ?></h1>
                <div class="mt-4 size-h2 font-color-1"><?= $postData['specialization'] ?></div>

                <?php if(!empty($postData['companies'])): ?>
                    <div class="pre-icon menu-sprite menu-companies md mt-4 fixed"><?= __('Место работы', 'def') ?>:</div>
                    <?php foreach ($postData['companies'] as $company):
                        ?>
                        <div>
                            <a href="<?= $company['link'] ?>"><?= $company['title'] ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>

                <?php if(!empty($postData['knps'])): ?>
                    <div class="pre-icon menu-sprite menu-knp md mt-4 fixed"><?= __('Место работы', 'def') ?>:</div>
                    <?php foreach ($postData['knps'] as $knp):
                        ?>
                        <div>
                            <a href="<?= $knp['link'] ?>"><?= $knp['title'] ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>

                <div class="doc-button-review">
                    <div class="mt-5"><?= __('Поделитесь отзывами о приеме','def') ?>:</div>
                    <div class="button hs-2 mt-2 pre-icon md discussion-3"
                         data-open-doctor-review-form
                         data-title="<?=  get_the_title()  ?>"
                    ><?= __('Оставить отзыв о враче','def') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-color-light-gray mb-8 pt-10 pb-6">
        <div class="container">
            <div class="size-h1">
                <?= __('Проверенные отзывы о враче', 'def') ?>
            </div>
            <div class="vue-inst">
                <doctor-reviews data-post="<?= $post->ID?>"
                                data-empty-text="<?= __('Пока отзывов нет', 'def') ?>"
                ></doctor-reviews>
            </div>
        </div>
    </div>

    <div class="vue-inst">
        <modal size="sm" name="modalFormDoctorReview">
            <form-doctor-review data-post="<?= $post->ID ?>" data-symbols-limit="2000"></form-doctor-review>
        </modal>
    </div>

<?php get_footer() ?>
</body>
</html>
<?php
wp_footer();
?>

