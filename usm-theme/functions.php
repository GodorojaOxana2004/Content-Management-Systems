<?php

if (!defined('ABSPATH')) {
    exit; 
}

function usm_theme_enqueue_assets() {
    wp_enqueue_style(
        'usm-theme-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    wp_enqueue_style(
        'usm-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_script(
        'usm-theme-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        [],
        '1.0.0',
        true 
    );
}
add_action('wp_enqueue_scripts', 'usm_theme_enqueue_assets');

function usm_theme_setup() {
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => esc_html__('Главное меню', 'usm-theme'),
        'footer'  => esc_html__('Меню в подвале', 'usm-theme'),
    ]);

    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

     add_theme_support('custom-header');

     add_theme_support('custom-background', [
        'default-color' => 'f5f5f5',
    ]);

 
    add_theme_support('post-formats', ['aside', 'quote', 'link', 'image', 'video']);
}
add_action('after_setup_theme', 'usm_theme_setup');

function usm_theme_widgets_init() {
    register_sidebar([
        'name'          => esc_html__('Основная боковая панель', 'usm-theme'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Добавьте виджеты сюда.', 'usm-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => esc_html__('Подвал — Колонка 1', 'usm-theme'),
        'id'            => 'footer-1',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'usm_theme_widgets_init');

function usm_theme_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'usm_theme_excerpt_length');

function usm_theme_excerpt_more($more) {
    return '&hellip; <a class="read-more" href="' . get_permalink() . '">Читать далее</a>';
}
add_filter('excerpt_more', 'usm_theme_excerpt_more');

function usm_theme_active_nav_class($classes, $item) {
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'usm_theme_active_nav_class', 10, 2);
