<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="card-img-top">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="card-body">
        <header class="entry-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title card-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title card-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;

            if ('post' === get_post_type()) : ?>
                <div class="post-top-meta">
                    <div class="author-thumb">
                        <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
                    </div>
                    <div class="author-description">
                        <?php
                        printf(
                            /* translators: %s: Author name */
                            esc_html__('Written by %s', 'mediummate'),
                            '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                        );
                        ?>
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <?php if (! is_single()) : ?>
                            <span class="readingtime">
                                <?php
                                $content = get_post_field('post_content', get_the_ID());
                                $word_count = str_word_count(strip_tags($content));
                                $reading_time = ceil($word_count / 200); // Assuming 200 words per minute
                                printf(
                                    /* translators: %d: Reading time in minutes */
                                    esc_html__('%d min read', 'mediummate'),
                                    $reading_time
                                );
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </header>

        <div class="entry-content">
            <?php
            if (is_single()) {
                the_content(
                    sprintf(
                        /* translators: %s: Post title */
                        esc_html__('Continue reading %s', 'mediummate'),
                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                    )
                );
            } else {
                the_excerpt();
            }

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'mediummate'),
                'after'  => '</div>',
            ));
            ?>
        </div>

        <footer class="entry-footer">
            <?php
            $categories_list = get_the_category_list(esc_html__(', ', 'mediummate'));
            if ($categories_list) {
                printf('<span class="cat-links"><i class="fas fa-folder"></i> ' . esc_html__('Posted in %1$s', 'mediummate') . '</span>', $categories_list);
            }

            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'mediummate'));
            if ($tags_list) {
                printf('<span class="tags-links"><i class="fas fa-tags"></i> ' . esc_html__('Tagged %1$s', 'mediummate') . '</span>', $tags_list);
            }
            ?>
        </footer>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->