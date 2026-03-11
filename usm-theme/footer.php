        </main>

        <?php if (is_active_sidebar('sidebar-1') || !is_page()) : ?>
            <?php get_sidebar(); ?>
        <?php endif; ?>

    </div>
</div>

<footer class="site-footer">
    <div class="site-wrapper">
        <p>
            &copy; <?php echo date('Y'); ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php bloginfo('name'); ?>
            </a>
            — Разработано в рамках лабораторной работы №3 по дисциплине Web CMS.
        </p>
        <p>
            <?php
            printf(
                'Работает на <a href="%s">WordPress</a>.',
                esc_url(__('https://wordpress.org/', 'usm-theme'))
            );
            ?>
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
