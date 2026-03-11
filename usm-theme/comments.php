<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            if ($count === '1') {
                printf('1 комментарий к «%s»', get_the_title());
            } else {
                printf('%1$s комментариев к «%2$s»', $count, get_the_title());
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 42,
                'callback'    => function($comment, $args, $depth) {
                    ?>
                    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-body'); ?>>
                        <div class="comment-author">
                            <?php echo get_avatar($comment, 42); ?>
                            <cite class="fn"><?php comment_author_link(); ?></cite>
                        </div>
                        <div class="comment-metadata">
                            <a href="<?php echo esc_url(get_comment_link($comment)); ?>">
                                <?php echo get_comment_date(); ?> в <?php echo get_comment_time(); ?>
                            </a>
                            <?php edit_comment_link('Редактировать', ' &mdash; ', ''); ?>
                        </div>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <p class="comment-awaiting-moderation">
                                Ваш комментарий ожидает проверки.
                            </p>
                        <?php endif; ?>
                        <div class="comment-content">
                            <?php comment_text(); ?>
                        </div>
                        <?php
                        comment_reply_link(array_merge($args, [
                            'add_below' => 'comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                        ]));
                        ?>
                    </li>
                    <?php
                },
            ]);
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments">Комментарии закрыты.</p>
    <?php endif; ?>

    <?php
    comment_form([
        'title_reply'          => 'Оставить комментарий',
        'title_reply_to'       => 'Ответить %s',
        'cancel_reply_link'    => 'Отмена',
        'label_submit'         => 'Отправить',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">Комментарий <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
    ]);
    ?>

</div>
