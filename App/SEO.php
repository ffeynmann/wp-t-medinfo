<?php


namespace App;

class SEO {
    private $main;
    public $sitePosftfix;
    public $qObj;


    public function __construct(Main &$main)
    {
        $this->main = $main;

        add_action('wp', function(){
            $this->sitePosftfix = get_option('blogname');
            $this->qObj         = get_queried_object();
        });
    }

    public function title($withPostfix = true, $onlyPostFix = false)
    {
        $string    = '';
        $queryType = $this->queryType();

        switch ($queryType) {
            case 'post':
                $string = $this->postTitle($this->qObj);
                break;
            case 'term':
                $string = $this->termTitle($this->qObj);
                break;
        }

        is_front_page() && $onlyPostFix = true;

        if($onlyPostFix) {
            return $this->sitePosftfix;
        }

        if(!$withPostfix) {
            return $string;
        }

        return $string ? sprintf('%s - %s', $string, $this->sitePosftfix) : $this->sitePosftfix;
    }

    public function description()
    {
        $string    = '';
        $queryType = $this->queryType();

        switch ($queryType) {
            case 'post':
                $string = $this->postDescription($this->qObj);
                break;
            case 'term':
                $string = $this->termDescription($this->qObj);
                break;
        }

        return $string ? sprintf('%s - %s', $string, $this->sitePosftfix) : $this->sitePosftfix;
    }

    public function image()
    {
        $image = $this->main->url . 'assets/images/logo.png';

        return $image;
    }

    public function queryType()
    {
        $type = '';
        $this->qObj instanceof \WP_Post && $type = 'post';
        $this->qObj instanceof \WP_Term && $type = 'term';

        return $type;
    }

    public function postTitle($post)
    {
        $title     = $post->post_title;
        $seo_title = get_field('title', $post->ID);

        return $seo_title ?: $title;
    }

    public function termTitle($term)
    {
        $title     = $term->name;
        $seo_title = get_field('title', $term->taxonomy . '_' . $term->term_id);

        return $seo_title ?: $title;
    }

    public function postDescription($post)
    {
        $content         = wp_trim_words(apply_filters('the_content', $post->post_content));
        $seo_description = get_field('description', $post->ID);

        return $seo_description ?: $content;
    }

    public function termDescription($term)
    {
        $content         = $term->descriptiom;
        $seo_description = get_field('description', $term->taxonomy . '_' . $term->term_id);

        return $seo_description ?: $content;
    }
}