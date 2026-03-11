<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <title>
        <?php
        if (is_front_page()) {
            bloginfo('name');
            echo ' — ';
            bloginfo('description');
        } elseif (is_single() || is_page()) {
            the_title();
            echo ' | ';
            bloginfo('name');
        } elseif (is_archive()) {
            echo get_the_archive_title() . ' | ';
            bloginfo('name');
        } else {
            bloginfo('name');
        }
        ?>
    </title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="site-wrapper">
        <div class="site-branding">
            <p class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </p>
            <?php
            $description = get_bloginfo('description');
            if ($description) : ?>
                <p class="site-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </div>
    </div>
</header>

<nav class="main-navigation" aria-label="<?php esc_attr_e('Главное меню', 'usm-theme'); ?>">
    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => '',
        'container'      => false,
        'fallback_cb'    => function() {
            echo '<ul><li><a href="' . esc_url(home_url('/')) . '">Главная</a></li></ul>';
        },
    ]);
    ?>
</nav>

<div class="site-wrapper">
    <div class="content-area">
        <main class="main-content" id="main" role="main">
