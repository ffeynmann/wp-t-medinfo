<?php

namespace App;

class PostTypesTaxonomies {

    public static function init()
    {
        self::register();
    }

    public static function register()
    {
        register_post_type("company",
            [
                'labels'          => [
                    'name'          => __( 'Предприятия' ),
                    'singular_name' => __( 'Предприятия' ),
                    'add_new'       => __( 'Добавить предприятие' ),
                    'add_new_item'  => __( 'Новое предприятие' ),
                    'edit_item'     => __( 'Редактировать предприятие' ),
                    'show_ui'       => true
                ],
                'capability_type' => 'post',
                'public'          => true,
                'has_archive'     => 'companies',
                'hierarchical'    => false,
                'menu_position'   => 5,
                "rewrite"         => [
                    "slug"         => "companies",
                    "with_front"   => true,
                    "hierarchical" => true
                ],
                'supports'        => [ "title", "editor", "excerpt", "custom-fields", "thumbnail", "revisions", "author" ]
            ]
        );

        register_post_type("doctor",
            [
                'labels'          => [
                    'name'          => __( 'Врачи' ),
                    'singular_name' => __( 'Врачи' ),
                    'add_new'       => __( 'Добавить врача' ),
                    'add_new_item'  => __( 'Новый врач' ),
                    'edit_item'     => __( 'Редактировать врача' ),
                    'show_ui'       => true
                ],
                'capability_type' => 'post',
                'public'          => true,
                'has_archive'     => 'doctors',
                'hierarchical'    => false,
                'menu_position'   => 5,
                "rewrite"         => [
                    "slug"         => "doctors",
                    "with_front"   => true,
                    "hierarchical" => true
                ],
                'supports'        => [ "title", "editor", "excerpt", "custom-fields", "thumbnail", "revisions", "author" ]
            ]
        );

        register_post_type("knp",
            [
                'labels'          => [
                    'name'          => __( 'КНП' ),
                    'singular_name' => __( 'Предприятия' ),
                    'add_new'       => __( 'Добавить кнп' ),
                    'add_new_item'  => __( 'Новое кнп' ),
                    'edit_item'     => __( 'Редактировать кнп' ),
                    'show_ui'       => true
                ],
                'capability_type' => 'post',
                'public'          => true,
                'has_archive'     => 'kps',
                'hierarchical'    => false,
                'menu_position'   => 6,
                "rewrite"         => [
                    "slug"         => "knps",
                    "with_front"   => true,
                    "hierarchical" => true
                ],
                'supports'        => [ "title", "editor", "excerpt", "custom-fields", "thumbnail", "revisions", "author" ]
            ]
        );


        register_taxonomy(
            'area', 'company', [
                'label'             => __('Районы', 'def'),
                'labels'            => [
                    'add_new_item' => __('Добавить'),
                ],
                'hierarchical'      => true,
                'show_admin_column' => true,
                "rewrite"           => [
                    "slug" => "areas",
                ],
            ]
        );

        register_taxonomy(
            'type', ['company', 'knp'], [
                'label'             => __('Направление', 'def'),
                'labels'            => [
                    'add_new_item' => __('Добавить'),
                ],
                'hierarchical'      => true,
                'show_admin_column' => true,
                "rewrite"           => [
                    "slug" => "types",
                ],
            ]
        );

        register_taxonomy(
            'department', 'company', [
                'label'             => __('Отделение', 'def'),
                'labels'            => [
                    'add_new_item' => __('Добавить'),
                ],
                'hierarchical'      => true,
                'show_admin_column' => true,
                "rewrite"           => [
                    "slug" => "departments",
                ],
            ]
        );

        register_taxonomy(
            'city', ['company', 'knp'], [
                'label'             => __('Город', 'def'),
                'labels'            => [
                    'add_new_item' => __('Добавить'),
                ],
                'hierarchical'      => true,
                'show_admin_column' => true,
                "rewrite"           => [
                    "slug" => "cities",
                ],
            ]
        );
    }
}