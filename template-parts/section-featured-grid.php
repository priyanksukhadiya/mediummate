<?php
/**
 * Template part for displaying featured posts grid
 *
 * @package mediummate
 */

// Check if featured grid is enabled
if (!get_theme_mod('slider_enable', true)) {
    return;
}

// Get featured posts settings
$posts_count = get_theme_mod('slider_posts_count', 4);
$category_id = get_theme_mod('slider_category', '');

// Ensure minimum of 1 post
$posts_count = max(1, absint($posts_count));

// Query args - Get posts with or without featured images
$args = array(
    'posts_per_page' => $posts_count,
    'post_status'    => 'publish',
    'ignore_sticky_posts' => 1,
);

if (!empty($category_id)) {
    $args['cat'] = absint($category_id);
}

$featured_query = new WP_Query($args);

if (!$featured_query->have_posts()) {
    return;
}

// Calculate layout
$total_posts = $featured_query->post_count;
$has_small_posts = $total_posts > 1;
?>

<section class="featured-posts-section">
    <div class="container">
        <div class="row mm-posts-grid listpostsbycats thiscatstyle1 post-style-1">
            <?php 
            $post_counter = 0;
            while ($featured_query->have_posts()) : 
                $featured_query->the_post();
                $post_counter++;
                
                if ($post_counter === 1) : 
                    // Large featured post (left side - 60% if has small posts, 100% if only one post)
                    $large_col_class = $has_small_posts ? 'col-md-12 col-lg-7' : 'col-md-12';
                    ?>
                    <div class="<?php echo esc_attr($large_col_class); ?> grid-item" id="post-<?php the_ID(); ?>">
                        <div class="card post poststyle1big h-100">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'poststyle1big-img')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-block d-flex flex-column">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                    <div class="mm-post-meta">
                                        <span class="post-name">
                                            <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>">
                                                <?php echo esc_html($categories[0]->name); ?>
                                            </a>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <h2 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <span class="card-text d-block"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></span>
                                <div class="mm-post-meta mt-auto">
                                    <div class="mm-card-footer">
                                        <span class="meta-footer-thumb">
                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 40); ?>
                                            </a>
                                        </span>
                                        <span class="author-meta">
                                            <span class="post-name">
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span><br/>
                                            <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
                                            <span class="dot"></span>
                                            <span class="readingtime"><?php echo esc_html(mediummate_reading_time()); ?> min read</span>
                                        </span>
                                        <span class="post-read-more">
                                            <a href="<?php the_permalink(); ?>" title="Read Story">
                                                <svg class="svgIcon-use" width="25" height="25" viewBox="0 0 25 25">
                                                    <path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($has_small_posts) : ?>
                    <div class="col-md-12 col-lg-5">
                        <div class="row h-100">
                    <?php endif; ?>
                <?php 
                else : 
                    // Smaller posts (right side - 40%)
                    ?>
                            <div class="col-md-6 col-lg-12 grid-item" id="post-<?php the_ID(); ?>">
                                <div class="card post h-100">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium', array('class' => 'poststyle1-img')); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-block d-flex flex-column">
                                        <h2 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="mm-post-meta mt-auto pt-0">
                                            <div class="mm-card-footer">
                                                <span class="meta-footer-thumb">
                                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                        <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 28); ?>
                                                    </a>
                                                </span>
                                                <span class="author-meta">
                                                    <span class="post-name">
                                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                            <?php the_author(); ?>
                                                        </a>
                                                    </span><br/>
                                                    <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
                                                    <span class="dot"></span>
                                                    <span class="readingtime"><?php echo esc_html(mediummate_reading_time()); ?> min read</span>
                                                </span>
                                                <span class="post-read-more">
                                                    <a href="<?php the_permalink(); ?>" title="Read Story">
                                                        <svg class="svgIcon-use" width="25" height="25" viewBox="0 0 25 25">
                                                            <path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php 
                endif;
            endwhile; 
            wp_reset_postdata();
            ?>
                    <?php if ($has_small_posts) : ?>
                        </div><!-- .row -->
                    </div><!-- .col-lg-5 -->
                    <?php endif; ?>
        </div><!-- .row.mm-posts-grid -->
    </div><!-- .container -->
</section><!-- .featured-posts-section -->


