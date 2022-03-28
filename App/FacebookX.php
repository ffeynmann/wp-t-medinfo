<?php

namespace App;

use Facebook\Facebook;

class FacebookX {
    public static $appId            = '880063846027260';
    public static $secret           = 'd08d1dd9ab60242bb5fcec076338e6de';
    public static $accessToken      = 'EAAMgadTsDZCwBABZC3c4dFaBXQR4ui52r9korlHTN7RZAOI7iXsR8TW8bKBV9imnO3lDlJqW87Dm02JgN6ZBpwxv3Sk1gbZACJJiZCmHyBp42sS3McsMF0EWwFTFwyDtsuVeZBF6HOa7sXkWJGfjJwhwRAZAgFIOdXS3BCxEWPxG3DNcbSAHuq1oGpSydh5YLqdmOUALKDRO95vbpUvals7kllBXkPHo6uYjnZCytMyuwf8HVsjASJ6HS';
    public static $pageId           = '100119445832956';
    public static $metaKeyPublished = 'fb_publish';

    public static function init()
    {
        if(isset($_GET['fb-token-debug'])) {
            Helper::dump(FacebookX::debugToken(), 1);
        }

        if(isset($_GET['fb-test-post'])) {
            Helper::dump(FacebookX::postLink('http://test.medinfo.zp.ua/news/v-zaporozhe-vse-bolshe-detej-popadajut-s-kovidom-v-reanimaciju/'), 1);
        }

//        add_action('save_post', '\\App\FacebookX::savePost', 10, 3);
    }

    public static function savePost($postId, $post, $update)
    {
        $fbPublished = get_post_meta($post->ID, FacebookX::$metaKeyPublished, 1);
        $categories  = wp_list_pluck(wp_get_object_terms($post->ID, 'category'), 'term_id');

        if($post->post_type === 'post'
            && $post->post_status == 'publish'
            && empty($fbPublished)
            && in_array(2, $categories) //news category
        ) {
            $link = get_permalink($post);
//            $link = 'http://test.medinfo.zp.ua/news/v-zaporozhe-vse-bolshe-detej-popadajut-s-kovidom-v-reanimaciju/';
            update_post_meta($post->ID, FacebookX::$metaKeyPublished, FacebookX::postLink($link));
        }
    }

    public static function reNew()
    {
        include_once(__DIR__ . '/../facebook/autoload.php');

        $fb = new Facebook([
            'app_id'                => self::$appId,
            'app_secret'            => self::$secret,
            'default_graph_version' => 'v2.5'
        ]);

        $longLivedToken = $fb->getOAuth2Client()->getLongLivedAccessToken(self::$accessToken);
        update_option('fb_long_live', $longLivedToken);
        $fb->setDefaultAccessToken($longLivedToken);

        $response = $fb->sendRequest('GET', FacebookX::$pageId, ['fields' => 'access_token'])->getDecodedBody();
        update_option('fb_forever', $response['access_token']);

        return $response['access_token'];
    }

    public static function postLink($link = '')
    {
        include_once(__DIR__ . '/../facebook/autoload.php');

        $fb = new Facebook([
            'app_id'                => self::$appId,
            'app_secret'            => self::$secret,
            'default_graph_version' => 'v2.5'
        ]);

        $fb->setDefaultAccessToken(FacebookX::foreverToken());

        return $fb->sendRequest('POST', self::$pageId . '/feed', [
            'link' => $link,
//            'link' => 'http://test.medinfo.zp.ua/news/v-zaporozhe-vse-bolshe-detej-popadajut-s-kovidom-v-reanimaciju/'
        ]);
    }

    public static function foreverToken()
    {
        $token = get_option('fb_forever');
        !$token && $token = FacebookX::reNew();

        return $token;
    }

    public static function debugToken()
    {
        include_once(__DIR__ . '/../facebook/autoload.php');

        $fb = new Facebook([
            'app_id'                => self::$appId,
            'app_secret'            => self::$secret,
            'default_graph_version' => 'v2.5'
        ]);

        $fb->setDefaultAccessToken(FacebookX::foreverToken());

        return $fb->sendRequest('GET', '/debug_token', ['input_token' => FacebookX::foreverToken()]);
    }
}