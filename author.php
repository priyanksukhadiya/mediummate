<?php
/**
 * The template for displaying author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header();

$author = get_queried_object();
$author_id = $author->ID;
$post_count = count_user_posts($author_id);
$author_bio = get_the_author_meta('description', $author_id);
$website = get_the_author_meta('user_url', $author_id);
?>

<div class="mm-hero-header mm-page-hero mm-author-cover">
    <div class="row post-top-meta authorpage justify-content-md-center justify-content-lg-center">
        <div class="col-md-6 text-center">
            <h1><?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?></h1>
            
            <?php if ($website) : ?>
                <i class="fa fa-globe"></i>&nbsp; 
                <a target="_blank" href="<?php echo esc_url($website); ?>">
                    <?php echo esc_html($website); ?>
                </a>
                <span class="bull">•</span>
            <?php endif; ?>
            
            <?php
            printf(
                /* translators: %d: number of posts */
                esc_html(_n('%d post', '%d posts', $post_count, 'mediummate')),
                $post_count
            );
            ?>
            
            <?php if ($author_bio) : ?>
                <span class="author-description text-white mt-3 mb-3 d-block">
                    <?php echo wp_kses_post($author_bio); ?>
                </span>
            <?php endif; ?>
            
            <?php
            // Get custom social media links from user meta
            $social_links = array(
                'twitter'   => array('icon' => 'fab fa-twitter', 'title' => 'Follow on Twitter'),
                'facebook'  => array('icon' => 'fab fa-facebook', 'title' => 'Follow on Facebook'),
                'instagram' => array('icon' => 'fab fa-instagram', 'title' => 'Follow on Instagram'),
                'linkedin'  => array('icon' => 'fab fa-linkedin', 'title' => 'Connect on LinkedIn'),
                'youtube'   => array('icon' => 'fab fa-youtube', 'title' => 'Subscribe on YouTube'),
                'github'    => array('icon' => 'fab fa-github', 'title' => 'Follow on GitHub')
            );

            $has_social_links = false;
            foreach ($social_links as $network => $data) {
                if (get_the_author_meta($network, $author_id)) {
                    $has_social_links = true;
                    break;
                }
            }
            ?>
            
            <?php if ($has_social_links) : ?>
                <p class="d-block">
                    <?php foreach ($social_links as $network => $data) : 
                        $url = get_the_author_meta($network, $author_id);
                        if ($url) :
                    ?>
                        <a target="_blank" href="<?php echo esc_url($url); ?>" rel="noopener noreferrer" title="<?php echo esc_attr($data['title']); ?>">
                            <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                        </a>
                        &nbsp;
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                    
                    <a target="_blank" href="<?php echo esc_url(get_author_feed_link($author_id)); ?>" title="RSS Feed">
                        <i class="fa fa-rss"></i>
                    </a>
                    &nbsp;
                    
                    <a href="mailto:<?php echo esc_attr(get_the_author_meta('user_email', $author_id)); ?>" title="Email">
                        <i class="fa fa-send-o"></i>
                    </a>
                    &nbsp;
                </p>
            <?php endif; ?>
            
            <p class="margbotneg100">
                <?php echo mediummate_get_author_avatar($author_id, 96); ?>
            </p>
        </div>
    </div>
</div>

<br><br>

<div class="container">
    <?php if (have_posts()) : ?>
        <div class="row mm-posts-grid h-100">
            <?php
            /* Start the Loop */
            while (have_posts()) :
                the_post();
                ?>
                <div class="col-md-6 col-lg-4 grid-item">
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-block">
                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <span class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></span>
                            
                            <div class="mm-post-meta">
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
                                        <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read Story', 'mediummate'); ?>">
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
            endwhile;
            ?>
        </div>

        <!-- Pagination -->
        <div class="mm-pagination">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&laquo;', 'mediummate'),
                'next_text' => __('&raquo;', 'mediummate'),
                'screen_reader_text' => __('Posts navigation', 'mediummate'),
            ));
            ?>
        </div>

    <?php else : ?>
        <div class="row">
            <div class="col-md-12">
                <?php get_template_part('template-parts/content', 'none'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer();
