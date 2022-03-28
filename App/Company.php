<?php

namespace App;

class Company {
    public static $metaRating = 'rating';
    public static $cronTaskRatings = 'companies-update-rating';

    public static function init()
    {
        add_action('wp', function(){
            if(isset($_GET['ratings_manual'])) {
                Helper::dump(Company::setRatings());
            }
        });

        add_action('save_post_company', function($postID, $post, $update){
            Company::updateRating($postID);
        }, 99, 3);

        if(!wp_next_scheduled(Company::$cronTaskRatings)) {
            wp_schedule_event(time() + 1, 'daily', Company::$cronTaskRatings);
//            wp_schedule_event(time() + 1, 'monthly', Company::$cronTaskRatings);
        }

        add_action('companies-update-rating', '\\App\Company::setRatings');
    }

    public static function getRating($companyId)
    {
        global $wpdb;
        $days = 365;

        $sql = $wpdb->prepare(" SELECT `meta_value` from $wpdb->commentmeta as `cm`
                INNER JOIN $wpdb->comments as `c` on `c`.`comment_ID` = `cm`.`comment_id`
                WHERE `c`.`comment_post_ID` = '%s' 
                    AND `cm`.`meta_key` = 'stars'
                    AND `c`.`comment_approved` = '1'
                    AND `c`.`comment_date` > DATE_SUB(NOW(), INTERVAL {$days} DAY)
            ", $companyId);

        $stars = array_map('intval', $wpdb->get_col($sql));

        return $stars ? round(array_sum($stars) / count($stars) ,1) : 0;
    }

    public static function setRatings()
    {
        $ratings = [];
        $companies = Posts::getItems(['post_type' => 'company', 'posts_per_page' => -1, 'no-order' => 1]);

        foreach ($companies['items'] as $company) {
            $ratings[$company['ID']] = [
                'title'  => $company['title'],
                'rating' => Company::updateRating($company['ID'])
            ];
        }

        $companies = Posts::getItems(['post_type' => 'knp', 'posts_per_page' => -1, 'no-order' => 1]);

        foreach ($companies['items'] as $company) {
            $ratings[$company['ID']] = [
                'title'  => $company['title'],
                'rating' => Company::updateRating($company['ID'])
            ];
        }

        $companies = Posts::getItems(['post_type' => 'doctor', 'posts_per_page' => -1, 'no-order' => 1]);

        foreach ($companies['items'] as $company) {
            $ratings[$company['ID']] = [
                'title'  => $company['title'],
                'rating' => Company::updateRating($company['ID'])
            ];
        }

        update_option('last_set_ratings', date('Y-m-d H:i:s'));

        return $ratings;
    }

    public static function updateRating($companyId = '')
    {
        $rating = Company::getRating($companyId);
        update_post_meta($companyId, Company::$metaRating, $rating);

        return $rating;
    }

    public static function companyCity($post_id)
    {
        $terms = wp_get_object_terms([$post_id], ['city']);

        return $terms ? $terms[0]->name : '';
    }

    public static function companyType($post_id)
    {
        $terms = wp_get_object_terms([$post_id], ['type']);

        return $terms ? $terms[0]->name : '';
    }

    public static function departments($post_id)
    {
        $terms = [];

        foreach (wp_get_object_terms([$post_id], ['department']) as $term) {
            $terms[] = [
                'id'    => $term->term_id,
                'link'  => get_term_link($term),
                'title' => $term->name
            ];
        }

        return array_values($terms);
    }


    public static function allDepartments($objectIds = [])
    {
        static $terms;

        if(is_null($terms)) {
            $args = ['taxonomy' => 'department', 'parent' => 0];
            $objectIds && $args['object_ids'] = $objectIds;
            $terms = get_terms($args);
        }

        return array_values($terms);
    }

    public static function allCities($objectIds = [])
    {
        static $terms;

        if(is_null($terms)) {
            $args = ['taxonomy' => 'city', 'parent' => 0, 'include' => '1638'];
            $objectIds && $args['object_ids'] = $objectIds;
            $terms0 = get_terms($args);

            $args = ['taxonomy' => 'city', 'parent' => 0, 'exclude' => 1638];
            $objectIds && $args['object_ids'] = $objectIds;
            $terms1 = get_terms($args);

            $terms = array_merge($terms0, $terms1);
        }

        return array_values($terms);
    }

    public static function allSubDepartments($objectIds = [])
    {
        $childs = [];

        foreach (Company::allDepartments($objectIds) as $term) {
            $args = ['taxonomy' => 'department', 'parent' => $term->term_id];
            $objectIds && $args['object_ids'] = $objectIds;
            $tmp = get_terms($args);
            $tmp && $childs[$term->term_id] = $tmp;
        }

        return $childs;
    }

}