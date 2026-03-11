<?php get_header(); ?>

<header class="archive-header">
    <?php the_archive_title('<h1 class="archive-title">', '</h1>'); ?>
    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
</header>

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('post-entry'); ?>>

            <header class="entry-header">
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <div class="entry-meta">
                    <?php echo get_the_date(); ?> — <?php the_author(); ?>
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

    <nav class="pagination">
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
        <p>Записи не найдены.</p>
    </div>

<?php endif; ?>

<?php get_footer(); ?>
