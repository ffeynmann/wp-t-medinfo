<?php

namespace App;

class Ajax {
    public static function init()
    {
        add_action("wp_ajax_sub", '\\App\Ajax::ajax_in');
        add_action("wp_ajax_nopriv_sub", '\\App\Ajax::ajax_in');
    }

    public static function ajax_in()
    {
        $response = [];
        ob_start();

        switch ($_POST['route']) {
            case "comment_publish_status":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['id'])) {
                    $response['status'] = Comments::tmPublishStatus($post['id']);
                }
                break;
            case "comment_publish":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['id'])) {
                    $response = Comments::ajaxTMPublish($post['id']);
                }
                break;
            case "get_items":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['config'])) {
                    $response = Posts::getItems($post['config']);
//                    $response = Posts::getItems((array)json_decode(html_entity_decode($post['config'])));
                }

                break;
            case "form-call":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['form'])) {
                    $response = Base::newCallRequest($post['form']);
                }
                break;
            case "form-comment":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['form'])) {
                    $response = Comments::newComment($post['form']);
                }
                break;
            case "form-review":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['form'])) {
                    $response = Comments::newReview($post['form'], 'review');
                }
                break;
            case "form-doctor-review":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['form'])) {
                    $response = Comments::newReview($post['form'], 'review-doctor');
                }
                break;
            case "comments_get_items":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['config'])) {
                    $response = Comments::getItems($post['config']);
//                    $response = Comments::getItems(json_decode(html_entity_decode($post['config'])));
                }
                break;
            case "comment_like":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['comment_id'])) {
                    $response = Comments::like($post['comment_id']);
                }
                break;
            case "comment_dislike":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!empty($post['comment_id'])) {
                    $response = Comments::dislike($post['comment_id']);
                }
                break;
            case "load_views":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $response['views'] = Posts::loadViews($post['ids']);

                break;
            case "load_times":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $response['times'] = Posts::loadTimes($post['ids']);

                break;
            case "visit_post":
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                Posts::visitPost($post['id']);

                break;
        }

        ob_get_clean();
        die(json_encode($response));
    }
}