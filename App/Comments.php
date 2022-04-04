<?php

namespace App;

class Comments {
    public static $metaLikes     = 'likes';
    public static $metaDislikes  = 'dislikes';
    public static $metaStars     = 'stars';
    public static $metaTMPublish = 'publish_tm';

    public static function init()
    {
        add_filter( 'admin_comment_types_dropdown', function($commentTypes){
            $commentTypes['review'] = 'Отзыв';
            return $commentTypes;
        }, 10, 1);

        add_action('wp_insert_comment', function($commentID, $comment){
            Company::updateRating($comment->comment_post_ID);
        },99, 2);

        add_action('deleted_comment', function($commentID, $comment){
            Company::updateRating($comment->comment_post_ID);
        }, 99, 2);

        add_action('edit_comment', function($commentID, $comment){
            Company::updateRating($comment->comment_post_ID);
        }, 99, 2);

        add_action('wp_set_comment_status', function($commentID, $status){
            $comment = get_comment($commentID);
            Company::updateRating($comment->comment_post_ID);
        }, 99, 2);

        add_action('add_meta_boxes', function(){
            \add_meta_box('comment-publish', 'TM Публикация', '\\App\Comments::metaBoxPublish', 'comment', 'normal');
        });

        add_action('init', function(){
            if(isset($_GET['unpublished'])) {
                Helper::dump(Comments::publishUnpublishedComments());
            }
        });

        self::addAdminCommentTypesColumn();
        self::addAdminRatingColumn();
    }

    public static function metaBoxPublish($comment, $a)
    {
        get_template_part('templates/admin-comment-publish');
    }

    public static function tmPublishStatus($id = '')
    {
        $publishDate = get_comment_meta($id, Comments::$metaTMPublish, 1);

        if($publishDate) {
            $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $publishDate, Helper::timezoneUTC());
            $dateObj->setTimezone(Helper::timezoneUA());
            $publishDate = $dateObj->format('Y-m-d H:i:s');
        }

        return $publishDate;
    }

    public static function ajaxTMPublish($id = '')
    {
        $comment = get_comment($id);

        if($comment && $commentPost = get_post($comment->comment_post_ID)) {
            return [
                'publish' => Comments::tmPublish($comment->comment_ID),
                'comment' => $comment,
                'post'    => $commentPost
            ];
        } else {
            return [
                'error' => 'Комментарий или компания не найдены'
            ];
        }
    }

    public static function tmPublish($id)
    {
        $comment = get_comment($id);

        if($comment && $commentPost = get_post($comment->comment_post_ID)) {
            $stars              = get_comment_meta($comment->comment_ID, Comments::$metaStars, 1);
            $commentCommentPost = Comments::toWeb($comment);
            $commentPost        = Posts::toWeb($commentPost);
        } else {
            return [
                'error' => 'Комментарий или компания не найдены'
            ];
        }

        $starsText = '';
        for($i = 1; $i <= $stars; $i++) {
            $starsText .= '⭐️';
        }

        $titleForTag = str_replace([' ', '-', '№'], '', mb_strtolower($commentPost['title']));
        $titleForTag = str_replace(['.', ','], '_', mb_strtolower($titleForTag));

        $textPart1 = sprintf("%s\n%s\n#%s",
            $starsText,
            $commentPost['title'],
            $titleForTag
        );

        $textPart3 = '';

        if(!empty($commentPost['locations']) &&
            count($commentPost['locations']) === 1 &&
            !empty($commentPost['locations'][0]['address'])
        ) {
            $textPart3 = sprintf("\n<a href='%s'>%s</a>",
                'https://www.google.com/maps/place/' . $commentPost['city'] . ' ' . $commentPost['locations'][0]['address'],
                $commentPost['city'] . ', ' . $commentPost['locations'][0]['address']
            );
        }

        $textPart4 = '';

        foreach ($commentPost['companies'] as $company) {
            $textPart4 .= sprintf("\n%s", $company['title']);
        }

        foreach ($commentPost['knps'] as $knp) {
            $textPart4 .= sprintf("\n%s", $knp['title']);
        }

        $textPart5 = sprintf("\n%s:\n- %s",
            $commentCommentPost['name'],
            $commentCommentPost['text']
        );

        $text = $textPart1 . $textPart3 . $textPart4 . $textPart5;

        $dateGMT = date('Y-m-d H:i:s');

        update_comment_meta($comment->comment_ID, Comments::$metaTMPublish, $dateGMT);

        Bot::sendText(Bot::$tmChannellGroup, $text);

        return [];
    }

    public static function publishUnpublishedComments()
    {
        $response      = [];
        $dateStartView = '2021-11-03 00:00:00';
        $dateObj       = new \DateTime('now', Helper::timezoneUA());
        $dateObj->modify('-2 hours');

//        return [$dateStartView, $dateObj->format('Y-m-d H:i:s')];

        $comments = Comments::getItems([
            'type'           => 'review',
            'number'         => 1000,
            'per_page'       => 1000,
            'post_id'        => false,
            'comment_parent' => 0,
            'date_query'     => [
                ['after' => $dateStartView],
                ['before' => $dateObj->format('Y-m-d H:i:s')]
            ],
            'meta_query'     => [
                [
                    'key'     => Comments::$metaTMPublish,
                    'compare' => 'NOT EXISTS'
                ]
            ]
        ]);

        foreach ($comments['items'] as $item) {
//            $response[] = $item;
            $response[] = Comments::tmPublish($item['id']);
        }

        return $response;
    }

    public static function getItems($config)
    {
        $config = (array)$config;

        $config = array_merge([
            'status'        => '1',
            'type'          => '',
            'post_id'       => 99999,
            'number'        => get_option('comments_per_page'),
            'per_page'      => get_option('comments_per_page'),
            'total'         => 0,
            'total_all'     => 0,
            'items'         => [],
            'hierarchical'  => 'threaded'
        ], $config);

        $config['total']     = count(get_comments(array_merge($config, ['fields' => 'ids', 'offset' => 0, 'number' => ''])));
        $config['total_all'] = get_comment_count($config['post_id'])['approved'];
        $config['items']     = array_values(get_comments($config));

        foreach ($config['items'] as &$comment) {
            $comment = Comments::toWeb($comment);
        }

        return $config;
    }

    public static function toWeb($raw, $parent = false)
    {
        $childs = $raw->get_children() ?: [];

        foreach ($childs as &$child) {
            $child = Comments::toWeb($child, $raw);
        }

        $commentPost = get_post($raw->comment_post_ID);
        $commentPost && $commentPost = Posts::toWeb($commentPost);

        return [
            'id'            => $raw->comment_ID,
            'post_title'    => get_the_title($raw->comment_post_ID),
            'post_link'     => get_permalink($raw->comment_post_ID),
            'name'          => $raw->comment_author,
            'date'          => Comments::humanDate($raw),
            'text'          => $raw->comment_content,
            'type'          => $raw->comment_type,
            'likes'         => count(get_comment_meta($raw->comment_ID, Comments::$metaLikes, 1) ?: []),
            'user_like'     => Comments::userPuttedLike($raw->comment_ID),
            'dislikes'      => count(get_comment_meta($raw->comment_ID, Comments::$metaDislikes, 1) ?: []),
            'user_dislike'  => Comments::userPuttedDisLike($raw->comment_ID),
            'reply_to_id'   => $parent ? $parent->comment_ID : '',
            'reply_to_name' => $parent ? $parent->comment_author : '',
            'stars'         => get_comment_meta($raw->comment_ID, Comments::$metaStars, 1),
            'sub'           => array_values($childs),
            'comment_post' => $commentPost
        ];
    }

    public static function humanDate($comment)
    {
        $U = mysql2date( 'U', $comment->comment_date_gmt);

        if((time() - $U) > DAY_IN_SECONDS) {
            return get_comment_date('', $comment);
        } else {
            return sprintf(__('%s назад', 'def'), human_time_diff($U));
        }
    }

    public static function newComment($form)
    {
        $comment = [
            'comment_author_email' => $form['email'],
            'comment_author'       => $form['name'],
            'comment_content'      => html_entity_decode($form['text']),
            'comment_parent'       => $form['parent'],
            'comment_post_ID'      => $form['post'],
        ];

        $commentId = Comments::insertComment($comment, '');

        $text = sprintf("%s\nИмя: %s, Email: %s\n%s",
            'Новый комментарий',
            $form['name'],
            $form['email'],
            Base::$siteUrl . '/wp-admin/comment.php?action=editcomment&c=' . $commentId
        );

        Bot::sendText(null, $text);

        return ['form' => $form, 'comment' => $comment];
    }

    public static function newReview($form, $commentType = 'review')
    {
        $comment = [
            'comment_author_email' => $form['email'],
            'comment_author'       => $form['name'],
            'comment_content'      => html_entity_decode($form['text']),
            'comment_post_ID'      => $form['post'],
        ];

        $commentId = Comments::insertComment($comment, $commentType);
        update_comment_meta($commentId, Comments::$metaStars, $form['stars']);

        $text = sprintf("%s\nИмя: %s, Email: %s\n%s",
            'Новый отзыв',
            $form['name'],
            $form['email'],
            Base::$siteUrl . '/wp-admin/comment.php?action=editcomment&c=' . $commentId
        );

        Company::updateRating($comment['comment_post_ID']);

        Bot::sendText(null, $text);

        return ['form' => $form, 'comment' => $commentId];
    }

    public static function insertComment($args , $type = '') {
//        $args['comment_approved'] = 0;
        $args['comment_agent']     = $_SERVER['HTTP_USER_AGENT'];
        $args['comment_author_IP'] = $_SERVER['REMOTE_ADDR'];
        $args['comment_type']      = $type;

        return wp_insert_comment($args);
    }

    public static function like($commentID)
    {
        $userKey = sprintf('%s-%s', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

        $likes    = get_comment_meta($commentID, Comments::$metaLikes, 1) ?: [];
        $dislikes = get_comment_meta($commentID, Comments::$metaDislikes, 1) ?: [];

        if(in_array($userKey, $likes)) {
            $likes = array_diff($likes, [$userKey]);
        } else {
            $likes[] = $userKey;
        }

        $dislikes = array_diff($dislikes, [$userKey]);

        update_comment_meta($commentID, Comments::$metaLikes, $likes);
        update_comment_meta($commentID, Comments::$metaDislikes, $dislikes);

        return [];
    }

    public static function dislike($commentID)
    {
        $userKey = sprintf('%s-%s', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

        $likes    = get_comment_meta($commentID, Comments::$metaLikes, 1) ?: [];
        $dislikes = get_comment_meta($commentID, Comments::$metaDislikes, 1) ?: [];

        if(in_array($userKey, $dislikes)) {
            $dislikes = array_diff($dislikes, [$userKey]);
        } else {
            $dislikes[] = $userKey;
        }

        $likes = array_diff($likes, [$userKey]);

        update_comment_meta($commentID, Comments::$metaLikes, $likes);
        update_comment_meta($commentID, Comments::$metaDislikes, $dislikes);

        return [];
    }

    public static function userPuttedLike($commentID)
    {
        $userKey = sprintf('%s-%s', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        $likes    = get_comment_meta($commentID, Comments::$metaLikes, 1) ?: [];

        return in_array($userKey, $likes);
    }

    public static function userPuttedDisLike($commentID)
    {
        $userKey = sprintf('%s-%s', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        $likes    = get_comment_meta($commentID, Comments::$metaDislikes, 1) ?: [];

        return in_array($userKey, $likes);
    }

    public static function addAdminCommentTypesColumn()
    {
        add_filter( 'manage_edit-comments_columns', function($columns){
            $column = ['comment_type' => 'Тип'];
            return array_slice($columns, 0, 3) + $column + array_slice($columns, 3, 10);
        } );

        add_filter('manage_comments_custom_column', function($column, $comment_ID){

            if($column == 'comment_type') {
                switch(get_comment_type($comment_ID)) {
                    case 'review':
                        echo 'Отзыв';
                        break;
                    default:
                        echo 'Комментарий';
                }
            }
        }, 10, 2);
    }

    public static function addAdminRatingColumn()
    {
        add_filter( 'manage_edit-comments_columns', function($columns){
            $column = ['stars' => 'Оценка'];
            return array_slice($columns, 0, 4) + $column + array_slice($columns, 4, 10);
        } );

        add_filter('manage_comments_custom_column', function($column, $comment_ID){
            if($column == 'stars') {
                echo get_comment_meta($comment_ID, self::$metaStars,1 );
            }
        }, 10, 2);
    }
}