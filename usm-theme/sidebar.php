<aside class="sidebar" role="complementary" aria-label="Боковая панель">

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php else : ?>
        <div class="widget">
            <h3 class="widget-title">Последние записи</h3>
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page' => 5,
                'post_status'    => 'publish',
            ]);
            if ($recent_posts->have_posts()) :
            ?>
                <ul>
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                            <br>
                            <small><?php echo get_the_date(); ?></small>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>

        <div class="widget">
            <h3 class="widget-title">Категории</h3>
            <ul>
                <?php
                wp_list_categories([
                    'show_count' => true,
                    'title_li'   => '',
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                ]);
                ?>
            </ul>
        </div>

        <div class="widget">
            <h3 class="widget-title">Архив</h3>
            <ul>
                <?php wp_get_archives(['type' => 'monthly', 'show_post_count' => true]); ?>
            </ul>
        </div>

    <?php endif; ?>

</aside>
