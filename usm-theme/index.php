<?php get_header(); ?>

<?php if (have_posts()) : ?>

    <?php if (is_home() && !is_front_page()) : ?>
        <header class="archive-header">
            <h1 class="archive-title"><?php single_post_title(); ?></h1>
        </header>
    <?php endif; ?>

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?>>

            <header class="entry-header">
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="entry-meta">
                    <span class="posted-on">
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="author">
                        — <?php the_author(); ?>
                    </span>
                    <?php if (has_category()) : ?>
                        | Категория: <?php the_category(', '); ?>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <a href="<?php the_permalink(); ?>" class="read-more">
                    Читать далее &rarr;
                </a>
            </footer>

        </article>

    <?php endwhile; ?>

    <nav class="pagination" aria-label="Навигация по страницам">
        <?php
        the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&laquo; Назад',
            'next_text' => 'Вперёд &raquo;',
        ]);
        ?>
    </nav>

<?php else : ?>

    <div class="no-results">
        <h2>Записи не найдены</h2>
        <p>Попробуйте изменить параметры поиска или перейдите на <a href="<?php echo esc_url(home_url('/')); ?>">главную страницу</a>.</p>
    </div>

<?php endif; ?>

<?php get_footer(); ?>
