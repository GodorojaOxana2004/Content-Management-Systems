<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>

        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            the_content();
            wp_link_pages([
                'before' => '<div class="page-links">Страницы:',
                'after'  => '</div>',
            ]);
            ?>
        </div>

        <?php if (get_edit_post_link()) : ?>
            <footer class="entry-footer">
                <?php
                edit_post_link(
                    sprintf(
                        '<span class="screen-reader-text">%s</span>',
                        esc_html__('Редактировать страницу', 'usm-theme')
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
            </footer>
        <?php endif; ?>

    </article>

    <?php
    if (comments_open() || get_comments_number()) {
        comments_template();
    }
    ?>

<?php endwhile; ?>

<?php get_footer(); ?>
