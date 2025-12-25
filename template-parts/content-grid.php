<?php
/**
 * Template part for displaying posts in grid layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card h-100'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="card-img-top">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="card-body d-flex flex-column">
        <header class="entry-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title card-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title card-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
        </header><!-- .entry-header -->

        <div class="entry-content card-text">
            <?php
            echo esc_html(wp_trim_words(get_the_excerpt(), 15, '...'));
            ?>
        </div><!-- .entry-content -->

        <div class="entry-meta mt-auto">
            <div class="author-meta">
                <span class="post-author">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?>
                    </a>
                </span>
                <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
                <span class="dot"></span>
                <span class="reading-time"><?php echo esc_html(mediummate_reading_time()); ?> min read</span>
            </div>
        </div><!-- .entry-meta -->
    </div>
</article><!-- #post-<?php the_ID(); ?> -->