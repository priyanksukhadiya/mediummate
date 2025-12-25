<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title display-4">', '</h1>'); ?>

                    <div class="post-top-meta">
                        <div class="author-thumb">
                            <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 64); ?>
                        </div>
                        <div class="author-description">
                            <?php
                            printf(
                                /* translators: %s: Author name */
                                esc_html__('Written by %s', 'mediummate'),
                                '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                            );
                            ?>
                            <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
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
                        </div>
                    </div>
                </header>

                <div class="entry-content article-post">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'mediummate'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <footer class="entry-footer">
                    <div class="post-categories">
                        <?php
                        $categories_list = get_the_category_list(esc_html__(', ', 'mediummate'));
                        if ($categories_list) {
                            printf('<span class="cat-links"><i class="fas fa-folder"></i> ' . esc_html__('Posted in %1$s', 'mediummate') . '</span>', $categories_list);
                        }
                        ?>
                    </div>

                    <div class="post-tags">
                        <?php
                        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'mediummate'));
                        if ($tags_list) {
                            printf('<span class="tags-links"><i class="fas fa-tags"></i> ' . esc_html__('Tagged %1$s', 'mediummate') . '</span>', $tags_list);
                        }
                        ?>
                    </div>

                    <?php
                    // Author box
                    $author_bio = get_the_author_meta('description');
                    if ($author_bio) : ?>
                        <div class="author-box">
                            <div class="row">
                                <div class="col-md-2 mb-4 mb-md-0">
                                    <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 90); ?>
                                </div>
                                <div class="col-md-10">
                                    <h5><?php echo esc_html(get_the_author()); ?></h5>
                                    <p><?php echo wp_kses_post($author_bio); ?></p>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="btn btn-simple btn-sm">
                                        <?php
                                        printf(
                                            /* translators: %s: Author name */
                                            esc_html__('View all posts by %s', 'mediummate'),
                                            esc_html(get_the_author())
                                        );
                                        ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Navigation
                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'mediummate') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'mediummate') . '</span> <span class="nav-title">%title</span>',
                        )
                    );
                    ?>
                </footer>
            </div><!-- .col-md-12 -->
        </div><!-- .row -->
    </div><!-- .container -->
</article><!-- #post-<?php the_ID(); ?> -->