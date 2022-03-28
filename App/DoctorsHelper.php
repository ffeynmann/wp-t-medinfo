<?php


namespace App;


class DoctorsHelper
{
    public static function init()
    {

        add_filter('template_include', '\\App\DoctorsHelper::existKnigaIds');
        add_filter('template_include', '\\App\DoctorsHelper::seed');

        add_action('add_meta_boxes', function(){
            add_meta_box('kniga_info', 'Данные с книги', '\\App\DoctorsHelper::doctorKnigaMetaBox', 'doctor', 'side','low');
        });
    }

    public static function doctorKnigaMetaBox($post)
    {
        echo sprintf("ID: %s<br />%s<br />%s",
            get_post_meta($post->ID, 'kniga_id', 1),
            get_post_meta($post->ID, 'kniga_hts', 1),
            get_post_meta($post->ID, 'kniga_specializations', 1)
        );
    }

    public static function existKnigaIds($template)
    {
        global $wp, $wpdb;

        if(stripos($wp->request, 'exist_kniga_doctor_ids') !== false) {
            $ids = $wpdb->get_col("select meta_value from wp_postmeta where meta_key = 'kniga_id'");

            Helper::dump($ids);
            die();
        }

        return $template;
    }

    public static function seed($template)
    {
        global $wp;

        if(stripos($wp->request, 'seed_doctors') !== false) {
            $response = [
                'inserted' => [],
                'orig'     => [],
            ];

            if($data = json_decode(file_get_contents('php://input'))) {

                if(!empty($data->doctors)) {
                    $response['orig'] = $data->doctors;

                    foreach ($data->doctors as $doctor) {
                        $ID = wp_insert_post([
                            'post_type'   => 'doctor',
                            'post_title'  => $doctor->fio,
                            'post_status' => 'publish'
                        ]);

                        update_post_meta($ID, 'kniga_id', $doctor->id);
                        update_post_meta($ID, 'kniga_hts', $doctor->hts);
                        update_post_meta($ID, 'kniga_specializations', $doctor->specializations);

                        $response['inserted'][] = $ID;
                    }
                }
            }

            Helper::dump($response);
            die();
        }

        return $template;
    }

    public static function positionInRating($ID = null)
    {
        global $wpdb;

        static $ratings;

        if(is_null($ratings)) {
            $ratings = $wpdb->get_results("select p.ID, pm.meta_value from $wpdb->posts as `p` 
                join $wpdb->postmeta as `pm` on `pm`.`post_id` = `p`.`ID` 
                    and `pm`.`meta_key` = 'rating' and `pm`.`meta_value` > 0 
                where `post_type` = 'doctor' order by `pm`.`meta_value` desc limit 10");
        }

        $onlyID = array_column($ratings, 'ID');

        if(in_array($ID, $onlyID)) {
            return array_search($ID, array_column($ratings, 'ID')) + 1;
        } else {
            return '';
        }
    }
}