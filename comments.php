<?php
/**
 * The template for displaying comments
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'mediummate'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'mediummate')),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'mediummate'); ?></p>
        <?php
        endif;

    endif; // Check for have_comments().

    $commenter = wp_get_current_commenter();
    comment_form(array(
        'class_submit'  => 'submit',
        'label_submit'  => __('Post Comment', 'mediummate'),
        'title_reply'   => __('Leave a Reply', 'mediummate'),
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__('Write a response...', 'mediummate') . '" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
        'fields'        => array(
            'author' => '<div class="row"><p class="comment-form-author col-md-4"><input id="author" name="author" type="text" placeholder="' . esc_attr__('Name', 'mediummate') . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" aria-required="true"></p>',
            'email'  => '<p class="comment-form-email col-md-4"><input id="email" name="email" type="email" placeholder="' . esc_attr__('E-mail address', 'mediummate') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-required="true"></p>',
            'url'    => '<p class="comment-form-url col-md-4"><input id="url" name="url" type="url" placeholder="' . esc_attr__('Website Link', 'mediummate') . '" value="' . esc_attr($commenter['comment_author_url']) . '" size="30"></p></div>',
        ),
    ));
    ?>
</div><!-- #comments -->