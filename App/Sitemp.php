<?php

namespace App;

class Sitemp {
    public static function init()
    {
        add_filter('wp', '\\App\Sitemp::sitemapTemplate');
    }

    public static function sitemapTemplate()
    {
        global $wp;

        if (stripos($wp->request, 'sitemap.xml') !== false &&
            $template = locate_template('templates/sitemap.php')
        ) {
            include_once $template;
            die();
        }
    }

    public static function sitemapData()
    {
        $url = [];

        $pages     = get_posts(['post_type' => 'page', 'posts_per_page' => -1]);
        $posts     = get_posts(['post_type' => 'post', 'posts_per_page' => -1]);
        $companies = get_posts(['post_type' => 'company', 'posts_per_page' => -1]);
        $knps      = get_posts(['post_type' => 'knp', 'posts_per_page' => -1]);
        $doctors   = get_posts(['post_type' => 'doctor', 'posts_per_page' => -1]);

        $tags     = get_terms(['taxonomy' => 'post_tag']);
        $tagLinks = array_map('get_term_link', $tags);

        $posts = array_merge($pages, $posts, $companies, $knps, $doctors);
        $links = array_map('get_permalink', $posts);
        $links = array_merge($links, $tagLinks);

        foreach ($links as $priority1Link) {
            $url[] = [
                'url'     => $priority1Link,
            ];
        }

        return $url;
    }
}