<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>

        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <span><?php echo get_the_date(); ?></span>
                <span> — <?php the_author(); ?></span>
                <?php if (has_category()) : ?>
                    | Категория: <?php the_category(', '); ?>
                <?php endif; ?>
                <?php if (has_tag()) : ?>
                    | Теги: <?php the_tags('', ', ', ''); ?>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            the_content(
                sprintf(
                    '<span class="screen-reader-text">%1$s "%2$s"</span>',
                    esc_html__('Продолжить чтение', 'usm-theme'),
                    get_the_title()
                )
            );
            wp_link_pages([
                'before'      => '<div class="page-links">Страницы:',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ]);
            ?>
        </div>

        <footer class="entry-footer">
            <?php
            $tags_list = get_the_tag_list('', ', ');
            if ($tags_list) {
                printf('<span class="tags-links">Теги: %1$s</span>', $tags_list);
            }
            ?>
        </footer>

    </article>

    <nav class="post-navigation" aria-label="Навигация по записям">
        <div class="nav-previous">
            <?php previous_post_link('%link', '&larr; %title'); ?>
        </div>
        <div class="nav-next">
            <?php next_post_link('%link', '%title &rarr;'); ?>
        </div>
    </nav>

    <?php
    if (comments_open() || get_comments_number()) {
        comments_template();
    }
    ?>

<?php endwhile; ?>

<?php get_footer(); ?>
