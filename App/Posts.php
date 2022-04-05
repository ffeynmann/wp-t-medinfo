<?php

namespace App;

class Posts {

    public static $metaViews = 'views';
    public static $metaViewsDetailed = 'views_detailed';

    public static function init()
    {
        add_filter( 'use_default_gallery_style', '__return_false' );


//        add_action('wp', function(){
//            global $post;
//            $post && Posts::visitPost($post->ID);
//        });

//        add_action('save_post', function($postID, $post, $update){
//            do_action('wp_ajax_wpfc_delete_cache');
//        }, 99, 3);
    }

    public static function ogImage()
    {
        if($post = get_post()) {
            ?>
            <meta property="og:image" content="<?= get_the_post_thumbnail_url($post, 'large') ?>">
            <?php
        }
    }

    public static function loadViews($ids = [])
    {
        $views = [];

        foreach ($ids as $id) {
            $views[] = [
                'ID' => $id,
                'views' => Posts::visits($id)
            ];
        }

        return $views;
    }

    public static function loadTimes($ids = [])
    {
        $times = [];

        foreach ($ids as $id) {
            $post = get_post($id);

            $times[] = [
                'ID'   => $id,
                'time' => Posts::humanDate($post)
            ];
        }

        return $times;
    }

    public static function getItems($args = [])
    {
        $args = array_merge([
            'post_type'        => 'post',
            'paged'            => 1,
            'posts_per_page'   => 12,
            's'                => '',
            'items'            => [],
            'category__in'     => [],
            'post__not_in'     => [],
            'post__in'         => [],
            'cats'             => [],
            'city_id'          => '',
            'cities'           => [],
            'department_id'    => '',
            'departments'      => [],
            'subdepartment_id' => '',
            'subdepartments'   => [],
            'tag_id'           => '',
            'clear_items'      => 0,
            'orderby'          => 'post_date',
            'order'            => 'desc'
        ], $args);

        !empty($args['number']) && $args['posts_per_page'] = $args['number'];
        $args['departments']    = [];
        $args['subdepartments'] = [];
        $args['tax_query']      = [];
        $args['meta_query']     = [];

        if (!empty($args['to_home'])) {
            $args['meta_query'][] = [
                'key'   => 'to_home',
                'value' => 1,
            ];
        }

        $taxQueryDepartment = Posts::buildArgsTaxQuery('department', [$args['subdepartment_id'] ?: $args['department_id']]);
        $taxQueryTag        = Posts::buildArgsTaxQuery('post_tag', [$args['tag_id']]);
        $taxQueryCity       = Posts::buildArgsTaxQuery('city', [$args['city_id']]);

        $taxQueryTag && $args['tax_query'][] = $taxQueryTag;

        $idsForDepartments = $args;
        $idsForCities      = $args;

        $idsForDepartments['posts_per_page'] = -1;
        $idsForDepartments['fields']         = 'ids';
        $taxQueryCity && $idsForDepartments['tax_query'][] = $taxQueryCity;
        $idsForDepartments = get_posts($idsForDepartments);


        $idsForCities['posts_per_page'] = -1;
        $idsForCities['fields']         = 'ids';
        $taxQueryDepartment && $idsForCities['tax_query'][] = $taxQueryDepartment;
        $idsForCities = get_posts($idsForCities);


        !empty($args['remove_pagination']) && $args['pages'] = 1;

        $args['post_type'] === 'post'    && $args['cats'] = Posts::allNewsCats();
        $args['post_type'] === 'company' && $args['departments'] = Company::allDepartments($idsForDepartments);
        $args['post_type'] === 'company' && $args['cities'] = Company::allCities($idsForCities);
        $args['post_type'] === 'knp'     && $args['cities'] = Company::allCities($idsForCities);


        if(!empty($args['department_id'])) {
            $allSubDepartments = Company::allSubDepartments($idsForDepartments);
            $args['subdepartments'] = !empty($allSubDepartments[$args['department_id']]) ? $allSubDepartments[$args['department_id']] : [];
            $args['subdepartments'] = array_values($args['subdepartments']);
        }

        $taxQueryCity       && $args['tax_query'][] = $taxQueryCity;
        $taxQueryDepartment && $args['tax_query'][] = $taxQueryDepartment;

        if (in_array($args['post_type'], ['company', 'doctor', 'knp']) && empty($args['no-order'])) {
            $args['meta_key'] = 'rating';
            $args['orderby']  = [
                'meta_value' => 'desc',
                'post_date'  => 'desc'
            ];
        }

        $query = new \WP_Query($args);

        foreach ($query->posts as &$post) {
            $post = Posts::toWeb($post);
        }

        $args['clear_items'] && $args['items'] = [];

        $args['items'] = array_merge($args['items'], $query->posts);
        $args['pages'] = $query->max_num_pages;

        $args['clear_items'] = 0;

        return $args;
    }

    public static function toWeb($post = null)
    {
        $image       = get_the_post_thumbnail_url($post, 'large');
        $imageSlider = get_field('image_slider', $post->ID);

        $data = [
            'ID'           => $post->ID,
            'link'         => get_permalink($post),
            'thumb'        => get_the_post_thumbnail_url($post, 'medium'),
            'image'        => $image,
            'image_slider' => $imageSlider ?: $image,
            'title'        => apply_filters('post_title', get_the_title($post)),
            'content'      => apply_filters('the_content', $post->post_content),
        ];

        $post->post_type == 'post'   && $data = array_merge($data, Posts::toWebPost($post));
        $post->post_type == 'doctor' && $data = array_merge($data, Posts::toWebDoctor($post));
        in_array($post->post_type, ['company', 'knp']) && $data = array_merge($data, Posts::toWebCompanyKnp($post));

        return $data;
    }

    public static function toWebPost($post)
    {
        $displayName     = get_the_author_meta('display_name', $post->post_author);
        $displayLocalize = get_field('display_name_' . Language::$current, 'user_' . $post->post_author);
        $displayLocalize && $displayName = $displayLocalize;

        return [
            'author'       => $displayName,
            'author_photo' => get_field('photo', 'user_' . $post->post_author),
            'date'         => '', //Posts::humanDate($post),
            'top'          => in_array($post->ID, self::topNews()) ? 1 : '',
            'views'        => '',
            'tags'         => Posts::tags($post->ID),
        ];
    }

    public static function toWebCompanyKnp($post)
    {
        $locations      = [
            [
                'address' => get_field('address', $post->ID),
                'map'     => get_field('map', $post->ID)
            ]
        ];

        $multiLocations = get_field('locations', $post->ID);
        $multiLocations && $locations = $multiLocations;

        $commentsCount = get_comment_count($post->ID)['approved'];

        return [
            'photo'         => get_field('photo', $post->ID),
            'ratings_count' => $commentsCount ?: '',
            'rating'        => Company::getRating($post->ID),
            'address'       => $locations[0]['address'],
            'locations'     => $locations,
            'phones'        => get_field('phones', $post->ID),
            'site'          => get_field('site', $post->ID),
            'map'           => $locations[0]['map'],
            'departments'   => Company::departments($post->ID),
            'city'          => Company::companyCity($post->ID),
            'company_type'  => Company::companyType($post->ID)
        ];
    }

    public static function toWebDoctor($post)
    {
        $gender       = get_field('gender', $post->ID);
        $image        = get_the_post_thumbnail_url($post, 'large');
        $noPhotoMan   = \App\Base::$url . 'dist/images/noPhoto-man.png';
        $noPhotoWoMan = \App\Base::$url . 'dist/images/noPhoto-woman.png';

        if (!$image) {
            $image = $noPhotoMan;
            $gender == 'female' && $image = $noPhotoWoMan;
        }

        $companies = get_field('cmpanies', $post->ID);
        $knps      = get_field('knps', $post->ID);

        $companies && $companies = array_map('\\App\Posts::toWeb', array_column($companies, 'company'));
        $knps && $knps = array_map('\\App\Posts::toWeb', array_column($knps, 'knp'));

        $types = [];
        $companies && $types = array_merge(array_merge($types, array_column($companies, 'company_type')));
        $knps && $types = array_merge(array_merge($types, array_column($knps, 'company_type')));
        $types = array_values(array_unique($types));

        return [
            'image'          => $image,
            'gender'         => $gender,
            'rating'         => Company::getRating($post->ID),
            'rating_count'   => get_comment_count($post->ID)['approved'],
            'position'       => DoctorsHelper::positionInRating($post->ID),
            'specialization' => get_field('specialization', $post->ID) ?: '',
            'companies'      => $companies,
            'knps'           => $knps,
            'types'          => $types
        ];
    }

    public static function buildArgsTaxQuery($taxonomy = '', $ids = [])
    {
        if(empty(array_filter($ids))) {
            return [];
        }

        return [
            'taxonomy'         => $taxonomy,
            'field'            => 'term_id',
            'terms'            => $ids,
            'include_children' => true
        ];
    }

    public static function topNews()
    {
        static $ids;

        if(is_null($ids)) {
            $daysToLook = 10;
            global $wpdb;

            $sql = "SELECT `comment_post_ID` from $wpdb->comments as `c` 
                WHERE `comment_date` > DATE_SUB(NOW(), INTERVAL $daysToLook DAY) 
                    AND `comment_approved` = 1
                GROUP BY `comment_post_ID` 
                ORDER BY count(`comment_ID`) DESC";

            $ids = array_merge([999999], array_filter($wpdb->get_col($sql)));

            $sqlManual = "SELECT `post_id` from $wpdb->postmeta WHERE `meta_key` = 'top' AND `meta_value` = '1'";

            $ids = array_merge($ids, array_filter($wpdb->get_col($sqlManual)));
        }

        return $ids;
    }

    public static function humanDate($post = '')
    {
        $U = get_post_time( 'U', 1, $post, true );

        if((time() - $U) > DAY_IN_SECONDS) {
            return get_the_date('', $post);
        } else {
            return sprintf(__('%s назад', 'def'), human_time_diff($U));
        }
    }

    public static function tags($post_id)
    {
        $terms = [];

        foreach (wp_get_object_terms([$post_id], ['post_tag']) as $term) {
            $terms[] = [
                'id'    => $term->term_id,
                'link'  => get_term_link($term),
                'title' => '#' . $term->name,
                'color' => Posts::tagColor($term->term_id)
            ];
        }

        return $terms;
    }


    public static function allNewsCats()
    {
        $terms = [
            get_term(113, 'post_tag'),
            get_term(80, 'post_tag'),
            get_term(87, 'post_tag')
        ];

        return $terms;
    }

    public static function tagColor($tagId = 0)
    {
        $mapColors = [
            0 => '#710200',
            1 => '#2e8af4',
            2 => '#EC9411',
            3 => '#17A862',
            4 => '#DC323D',
            5 => '#2962a3',
            6 => '#b24842'
        ];

        return $mapColors[$tagId % 7];
    }

    public static function visitPost($postId)
    {
        $userKey = md5(sprintf('%s-%s', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
        $date = date('Y-m-d H:i:s');
        $meta = get_post_meta($postId, Posts::$metaViews, 1) ?: [];

        if(!in_array($userKey, array_keys($meta))) {
            $meta[$userKey] = $date;
            update_post_meta($postId, Posts::$metaViews, $meta);
        }
    }

    public static function visits($postId)
    {
        return count(get_post_meta($postId, Posts::$metaViews, 1) ?: []) + intval(get_field('views_manual', $postId));
    }

    public static function fakeDiv($data)
    {
        foreach ($data['items'] as $item) {
            ?>
            <div itemscope itemtype="http://schema.org/NewsArticle">
                <h2 itemprop="headline"><?= $item['title'] ?></h2>
                <h3 itemprop="author" itemscope itemtype="https://schema.org/Person">
                    <span itemprop="name">Medinfo</span>
                    <span itemprop="url"><?= Base::$siteUrl ?></span>
                </h3>
                <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?= $item['link'] ?>"/>
                <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                    <img src="<?= $item['image'] ?>">
                    <meta itemprop="url" content="<?= $item['image'] ?>">
                </div>
                <a href="<?= $item['link'] ?>"></a>
            </div>
            <?php
        }
    }

    public static function fakePagination($data, $baseUrl = '')
    {
        for($i = 1; $i <= $data['pages']; $i++) {
            if($i == $data['paged']) {
                continue;
            }
            $url = sprintf('%s/page/%d', $baseUrl, $i);
            ?>
            <a href="<?= $url ?>"><?= $i ?></a>
            <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?= $url ?>"/>
            <?php
        }
    }


    public static function postsCannonical()
    {
        $qObj = get_queried_object();

        if ((
             $qObj instanceof \WP_Term || ($qObj instanceof \WP_Post && in_array($qObj->ID, [21194, 22466]))
            )
            && get_query_var('paged') > 1) {
            ?>
            <link rel="canonical" href="<?= Helper::urlRemovePage(Base::$currentUrl) ?>"/>.
            <?php
        }
    }


}