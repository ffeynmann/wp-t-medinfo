<?php

namespace App;

use Faker\Factory;

class Base
{
    public static $version             = '05040845';
    public static $url                 = null;
    public static $options             = [];
    public static $menu                = null;
    public static $siteUrl             = null;
    public static $searchResults       = [];
    public static $currentUrl          = null;
    public static $idsCommentsDisabled = [21207, 21437, 21440];

    public static function init()
    {
        self::$siteUrl = get_bloginfo('url', 'display');
        self::setUrl();


        if(isset($_GET['test'])) {



            $faker = Factory::create('ru_RU');

            $samples = [];

            for($i = 0; $i < 15; $i++) {
//                $samples[] = $faker->;
            }

            Helper::dump($samples);

//            header('H')


            include_once __DIR__ . '/Person.php';
            die();
//            Helper::dump([1,2,3]);
        }

//        self::$version = rand(0, 1000000);

        Ajax::init();
        Posts::init();
        Company::init();
        Comments::init();
        Language::init();
        Posts::init();
        PostTypesTaxonomies::init();
        FacebookX::init();
        Sitemp::init();
        DoctorsHelper::init();

        add_action('wp', function(){
            global $wp;
            Base::$currentUrl = home_url( $wp->request );
        });

        add_action('wp', '\\App\Helper::debug');

        Base::$options = [
            'phone'          => get_field('phone', 'options'),
            'e_mail'         => get_field('e_mail', 'options'),
            'rules_comments' => get_field('rules_comments', 'options'),
            'rules_copy'     => get_field('rules_copy', 'options'),
            'rules_conf'     => get_field('rules_conf', 'options'),
            'cooperation'    => get_field('cooperation', 'options'),
            'link_fb'        => get_field('link_fb', 'options'),
            'link_tm'        => get_field('link_tm', 'options'),
            'link_vb'        => get_field('link_vb', 'options'),
        ];

        add_filter('the_title', '\\App\Helper::replaceUaQuotesToRussian', 9999, 1);
        add_filter('the_content', '\\App\Helper::replaceUaQuotesToRussian', 9999, 1);

        add_action('wp', function(){
            Base::$menu = wp_get_nav_menu_items('main');
        });

        add_filter('wp_get_nav_menu_items', '\\App\Base::menuClasses', 10, 3);
        add_action('admin_enqueue_scripts', '\\App\Base::includeAdminAssets');
        add_action('wp_enqueue_scripts', '\\App\Base::includeFrontAssets');

        add_filter('relevanssi_hits_filter', function ($hits) {
            Base::$searchResults = array_merge([999999], wp_list_pluck($hits[0], 'ID'));

            return $hits;
        });

        add_filter('relevanssi_content_to_index', function ($content, $post) {
            $addSearch   = [];
            $departments = Company::departments($post->ID);

            foreach ($departments as $department) {
                $addSearch[] = get_field('search', sprintf('%s_%s', 'department', $department['id']));
            }

            $addSearch[] = $post->post_title;

            $departments = wp_list_pluck($departments, 'title');
            $departments = array_merge($departments, $addSearch);

            $content .= " " . implode(' ', $departments);
            return $content;
        }, 10, 2);

        //на архивной странице вордпресс в глобальную переменную post
        //закидует первый пост из архива и тут закидуется обект term
        add_action('wp', function () {
            global $post;
            $qObj = get_queried_object();
            if ($qObj instanceof \WP_Term &&
                in_array($qObj->taxonomy, ['category', 'post_tag', 'department'])
            ) {
                $post = $qObj;
            }
        });

        add_filter('cron_schedules', function($schedules){
            $schedules['monthly'] = [
                'interval' => MONTH_IN_SECONDS,
                'display'  => __( 'Каждый меясц' ),
            ];

            return $schedules;
        }, 99, 1);

        //        isset($_GET['transfer']) && $this->transfer();
//        isset($_GET['remove_post_attachments']) && self::removePostAttachments();
//        isset($_GET['inserted_posts']) && self::removeInsertedPostsAndAttachments();

        add_action('init', function () {
//            isset($_GET['transform_images']) && $this->transformImagesToAcf();
//            isset($_GET['add_zp_to_companies']) && $this->citiesAddZp();
        });

    }

    public static function setUrl()
    {
        if (substr_count(plugin_dir_url(__FILE__), "wp-content") > 1) {
            Base::$url = trailingslashit(get_bloginfo("stylesheet_directory"));
        } else {
            Base::$url = plugin_dir_url(__FILE__);
        }
    }

    public static function includeAdminAssets()
    {
        wp_enqueue_style('css-admin', Base::$url . 'dist/build/admin.css', [], Base::$version);
        wp_enqueue_script('admin.bundle', Base::$url . 'dist/build/admin.bundle.js', [], Base::$version, true);

        wp_localize_script('admin.bundle', 'vars', [
            'url'  => Base::$siteUrl,
            'ajax' => admin_url("admin-ajax.php")
        ]);
    }

    public static function includeFrontAssets()
    {
        wp_enqueue_style('css-user', Base::$url . 'dist/build/public.css', [], Base::$version);
        wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', [], Base::$version, true);
        wp_enqueue_script('public.bundle', Base::$url . 'dist/build/public.bundle.js', [], Base::$version, true);

        wp_localize_script('public.bundle', 'vars', [
            'url'     => Base::$siteUrl,
            'ajax'    => admin_url("admin-ajax.php"),
            'link_tm' => self::$options['link_tm'],
            'r_key'   => Captcha::$keyPublic,
            'i18n'    => [
                'doctor'             => __('Доктор', 'def'),
                'comments'           => __('Комментарии', 'def'),
                'review'             => __('Отзыв', 'def'),
                'reviews'            => __('Отзывы', 'def'),
                'rating'             => __('Рейтинг', 'def'),
                'collapse'           => __('Свернуть', 'def'),
                'expand'             => __('Показать все', 'def'),
                'answer'             => __('Ответить', 'def'),
                'leave_review'       => __('Поделитесь мнением', 'def'),
                'leave_review2'      => __('Оставить отзыв', 'def'),
                'leave_comment'      => __('Оставить комментарий', 'def'),
                'leave_review_about' => __('Оставить отзыв о', 'def'),
                'review_discuss_tm'  => __('Все опубликованные отзывы можно обсудить в нашем телеграм-канале', 'def'),
                'button_more'        => __('Показать еще', 'def'),
                'rating365'          => __("Рейтинг формируется исходя из оценок за последние 365 дней", 'def'),
                'placeholder_name'   => __('Ваше имя, фамилия', 'def'),
                'placeholder_phone'  => __('Контактный телефон', 'def'),
                'placeholder_review' => __('Ваш отзыв', 'def'),
                'stars'              => __('Оценка', 'def'),
                'your_stars'         => __('Ваша оценка', 'def'),
                'make_call'          => __('Заказать звонок', 'def'),
                'form_call_text'     => sprintf(__('Нажимая кнопку «Заказать звонок», вы соглашаетесь на %s и даете согласие на обработку своих персональных данных.', 'def'),
                    '<a target="_blank" href="' . \App\Base::$options['rules_conf'] . '"><u>' . __('политику конфиденциальности', 'def')),
                'leave_comment_text' => sprintf(__('Нажимая кнопку «Оставить комментарий», вы принимаете %s и даете согласие на обработку своих персональных данных.', 'def'),
                    '<a target="_blank" href="' . \App\Base::$options['rules_comments'] . '"><u>' . __('Правила размещения комментариев', 'def') . '</u></a>'
                ),
                'leave_review_text'  => sprintf(__('Нажимая кнопку «Оставить отзыв», вы принимаете %s и даете согласие на обработку своих персональных данных.', 'def'),
                    '<a target="_blank" href="' . \App\Base::$options['rules_comments'] . '"><u>' . __('Правила размещения комментариев', 'def') . '</u></a>'
                )
            ]
        ]);
    }

    public static function bannersRow()
    {
        static $banners;
        is_null($banners) && $banners = get_field('banners_row', 'options');

        return $banners;
    }

    public static function bannersSquare()
    {
        static $banners;
        is_null($banners) && $banners = get_field('banners_square', 'options');

        return $banners;
    }

    public static function menuClasses($items, $menu, $args)
    {
        global $post, $wp_query;

        $newsMenuItemId = 21203;

        $activeMenuIds = [];

        _wp_menu_item_classes_by_context($items);

        foreach ($items as &$item) {
            in_array($item->ID, $activeMenuIds) && $item->classes[] = 'current-menu-item';
            in_array('current-menu-item', $item->classes) && $item->classes[] = 'active';
        }


        return $items;
    }

    public static function newCallRequest($form)
    {
        $text = sprintf("Имя: %s, Телефон: %s", $form['name'], $form['phone']);
        Bot::sendText(null, $text);

        return [];
    }

    public static function transfer()
    {
        global $wpdb;

        $sql = "select * from dle_post where full_story LIKE '<!--TBegin%' and alt_name not in (
    select meta_value from wp_postmeta where meta_key = 'alt_name'
    ) order by `date` desc LIMIT 500 ";

        $raw = $wpdb->get_results($sql);
//
        foreach ($raw as $post) {
//            $this->transferOne($post);
        }
    }

    public static function mb_ucfirst($text)
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    public static function removePostAttachments()
    {
        $reservedAttachIds = [];
        $attachmentsIds    = [];

        $companies = get_posts([
            'post_type'      => 'company',
            'posts_per_page' => -1,
        ]);

        foreach ($companies as $company) {
            $reservedAttachIds[] = get_post_thumbnail_id($company);
        }

        $attachments = get_posts([
            'post_type'      => 'attachment',
            'posts_per_page' => -1
        ]);

        foreach ($attachments as $attachment) {
            $attachmentsIds[] = $attachment->ID;
        }

        foreach ($attachmentsIds as $attachmentId) {
            if (in_array($attachmentId, $reservedAttachIds)) {
                continue;
            }

            wp_delete_attachment($attachmentId);
        }

        Helper::dump([
            'count_res' => count($reservedAttachIds),
            'count_att' => count($attachmentsIds),
            //            'reserved' => $reservedAttachIds
        ]);

    }

    public static function removeInsertedPostsAndAttachments()
    {
        $limit = 5000;

        $posts = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            //            'category__in'   => [2, 3]
        ]);

        $toDelete = [
            'posts'       => [],
            'attachments' => []
        ];

        foreach ($posts as $index => $post) {
            if ($index++ >= $limit) {
                continue;
            }

            $toDelete['posts'][]       = $post->ID;
            $toDelete['attachments'][] = get_post_thumbnail_id($post);
        }

        foreach ($toDelete['attachments'] as $attachmentId) {
            wp_delete_attachment($attachmentId, 1);
        }

        foreach ($toDelete['posts'] as $postId) {
            wp_delete_post($postId, 1);
        }


        Helper::dump([
            'posts'  => count($posts),
            'delete' => $toDelete
        ]);
    }

    public function transferOne($p)
    {
        $attachId = false;

        $postImageUrl = Base::detectPostContentImage($p->full_story);
        $postImageUrl && $attachId = Base::GenerateAttachmentImageId($postImageUrl);

        $post = [
            'post_date'    => $p->date,
            'post_title'   => $p->title,
            'post_content' => Base::transformPostContent($p->full_story),
            'post_name'    => sprintf('%s-%s.html', $p->id, $p->alt_name),
            'post_status'  => 'publish'
        ];

        //2 - новости
        //3 - полезные статьи

        if ($post_id = wp_insert_post($post)) {
            wp_set_object_terms($post_id, intval($p->category), 'category');

            $tags = array_map('\App\Main::mb_ucfirst', array_filter(array_map('trim', explode(',', $p->tags))));
            $tags && wp_set_object_terms($post_id, $tags, 'post_tag');
            $attachId && set_post_thumbnail($post_id, $attachId);

            update_post_meta($post_id, 'alt_name', $p->alt_name);
            update_post_meta($post_id, 'descr', $p->descr);
            update_post_meta($post_id, 'keywords', $p->keywords);
        }
    }

    public static function detectPostContentImage($content = '')
    {
        preg_match('/(?:http.*?uploads.*?)(?:jpg|jpeg|gif|png)/m', $content, $matches);

        return $matches ? $matches[0] : false;
    }

    public static function GenerateAttachmentImageId($image_url)
    {
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename   = basename($image_url);
        if (wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment  = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => sanitize_file_name($filename),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        $attach_id   = wp_insert_attachment($attachment, $file);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        $res1        = wp_update_attachment_metadata($attach_id, $attach_data);
//        $res2        = set_post_thumbnail($post_id, $attach_id);

        return $attach_id;
    }

    public static function transformPostContent($content = '')
    {
        return preg_replace('/<!--TBegin.*<!--TEnd-->/mu', '', $content);
    }

    public function transformImagesToAcf()
    {
        $processed = [];
        $companies = Posts::getItems(['post_type' => 'company', 'per_page' => 500]);

        foreach ($companies['items'] as $item) {
//            if(!empty(get_field('photo', $item['ID']))) {
//                continue;
//            }

            //_field field_6172be70ab9fe
            //_field field_6172be2aac607
//            $processed[] = get_field_object('photo', $item['ID']);
//
            $thumbId  = get_post_thumbnail_id($item['ID']);
            $newValue = sprintf('<!--:ua-->%d<!--:--><!--:ru-->%d<!--:-->', $thumbId, $thumbId);


            $processed[$item['ID']] = [
                update_post_meta($item['ID'], 'photo', $newValue),
                update_post_meta($item['ID'], '_photo', 'field_6172be2aac607')
            ];
        }

        Helper::dump($processed);
    }

    public function citiesAddZp()
    {
        $processed = [];
        $companies = Posts::getItems(['post_type' => 'company', 'per_page' => 500]);

        foreach ($companies['items'] as $item) {
            $processed[$item['ID']] = wp_set_object_terms($item['ID'], [1638], 'city');
        }

        Helper::dump($processed);
    }
}