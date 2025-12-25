<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mediummate
 */

get_header();
?>

<!-- Begin site-content -->
<div class="container">
    <?php while (have_posts()) : the_post(); ?>
    <div class="row">
        <!-- Sidebar Share/Clap Column -->
        <div class="col-md-2">
            <div class="share">
                <!-- Clapping Feature -->
                <?php if (get_theme_mod('single_clapping_enable', true)) : ?>
                <div class="sidebarapplause">
                    <span id="claps-count-<?php the_ID(); ?>" class="claps-count"><?php echo absint(get_post_meta(get_the_ID(), '_mm_claps_count', true)); ?></span>
                    <div id="mm-claps-applause-<?php the_ID(); ?>" class="mm-claps-applause<?php echo mm_user_has_clapped(get_the_ID()) ? ' has_clapped' : ''; ?>" data-post-id="<?php the_ID(); ?>">
                        <a class="claps-button" href="javascript:void(0);" data-id="<?php the_ID(); ?>"></a>
                        <?php wp_nonce_field('mm_clap_nonce', '_mm_clap_nonce'); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Share Section -->
                <?php if (get_theme_mod('single_share_enable', true)) : ?>
                <p class="sharecolour"><?php esc_html_e('Share', 'mediummate'); ?></p>
                <ul class="shareitnow">
                    <li>
                        <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" rel="noopener noreferrer">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" rel="noopener noreferrer">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </li>
                </ul>

                <div class="sep"></div>
                
                <!-- Comments Link -->
                <div class="hidden-xs-down">
                    <p><?php esc_html_e('Reply', 'mediummate'); ?></p>
                    <ul>
                        <li>
                            <a class="smoothscroll" href="#comments">
                                <?php echo get_comments_number(); ?><br>
                                <svg class="svgIcon-use" width="29" height="29" viewBox="0 0 29 29">
                                    <path d="M21.27 20.058c1.89-1.826 2.754-4.17 2.754-6.674C24.024 8.21 19.67 4 14.1 4 8.53 4 4 8.21 4 13.384c0 5.175 4.53 9.385 10.1 9.385 1.007 0 2-.14 2.95-.41.285.25.592.49.918.7 1.306.87 2.716 1.31 4.19 1.31.276-.01.494-.14.6-.36a.625.625 0 0 0-.052-.65c-.61-.84-1.042-1.71-1.282-2.58a5.417 5.417 0 0 1-.154-.75zm-3.85 1.324l-.083-.28-.388.12a9.72 9.72 0 0 1-2.85.424c-4.96 0-8.99-3.706-8.99-8.262 0-4.556 4.03-8.263 8.99-8.263 4.95 0 8.77 3.71 8.77 8.27 0 2.25-.75 4.35-2.5 5.92l-.24.21v.32c0 .07 0 .19.02.37.03.29.1.6.19.92.19.7.49 1.4.89 2.08-.93-.14-1.83-.49-2.67-1.06-.34-.22-.88-.48-1.16-.74z"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Content Column -->
        <div class="col-md-8 flex-first flex-md-unordered position-relative" id="post-<?php the_ID(); ?>">
            <div class="mm-hero-header">
                <!-- Author Box (Top - Desktop) -->
                <?php if (get_theme_mod('single_author_bio_enable', true)) : ?>
                <div class="row post-top-meta hidden-md-down">
                    <div>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 42); ?>
                        </a>
                    </div>
                    <div class="col-md-10 col-xs-12">
                        <a class="text-capitalize link-dark" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php the_author(); ?> <span class="btn follow"><?php esc_html_e('Follow', 'mediummate'); ?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <h1 class="posttitle"><?php the_title(); ?></h1>
                <p>
                    <span class="post-date"><time class="post-date"><?php echo esc_html(get_the_date()); ?></time></span>
                    <span class="dot"></span>
                    <span class="readingtime"><?php echo esc_html(mediummate_reading_time()); ?> <?php esc_html_e('min read', 'mediummate'); ?></span>
                </p>
            </div>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'featured-image img-fluid wp-post-image')); ?>
            <?php endif; ?>

            <!-- Article Content -->
            <article class="article-post">
                <?php the_content(); ?>
                <div class="clearfix mb-0"></div>
            </article>

            <div class="clearfix"></div>

            <!-- Author Box (Mobile) -->
            <?php if (get_theme_mod('single_author_bio_enable', true)) : ?>
            <div class="row post-top-meta hidden-lg-up">
                <div class="col-md-2 col-xs-4">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php echo mediummate_get_author_avatar(get_the_author_meta('ID'), 72); ?>
                    </a>
                </div>
                <div class="col-md-10 col-xs-8">
                    <a class="text-capitalize link-dark" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?> <span class="btn follow"><?php esc_html_e('Follow', 'mediummate'); ?></span>
                    </a>
                    
                </div>
            </div>
            <?php endif; ?>

            <!-- Post Categories/Tags -->
            <div class="after-post-tags">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) : ?>
                <ul class="post-categories">
                    <?php foreach ($categories as $category) : ?>
                    <li><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" rel="category tag"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <?php
                $tags = get_the_tags();
                if (!empty($tags)) : ?>
                <ul class="post-categories aretags">
                    <?php foreach ($tags as $tag) : ?>
                    <li><a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" rel="tag"><?php echo esc_html($tag->name); ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

            <!-- Previous/Next Post Navigation -->
            <?php if (get_theme_mod('single_post_navigation_enable', true)) : ?>
            <div class="row mb-5 prevnextlinks justify-content-center align-items-center">
                <div class="col-md-6 col-xs-12 rightborder pl-0">
                    <div class="thepostlink">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)) : ?>
                        « <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" rel="prev"><?php echo esc_html($prev_post->post_title); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 text-right pr-0">
                    <div class="thepostlink">
                        <?php
                        $next_post = get_next_post();
                        if (!empty($next_post)) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" rel="next"><?php echo esc_html($next_post->post_title); ?></a> »
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div class="hideshare"></div>

<!-- Related Posts Section -->
<?php if (get_theme_mod('single_related_posts_enable', true)) : 
    $categories = get_the_category();
    if (!empty($categories)) :
        $related_args = array(
            'category__in'   => wp_list_pluck($categories, 'term_id'),
            'post__not_in'   => array(get_the_ID()),
            'posts_per_page' => get_theme_mod('single_related_posts_count', 3),
            'orderby'        => 'rand',
        );
        $related_query = new WP_Query($related_args);
        
        if ($related_query->have_posts()) : ?>
<div class="graybg">
    <div class="container">
        <div class="row justify-content-center mm-posts-grid listrelated">
            <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
            <div class="col-md-4 mb-30">
                <div class="card post h-100">
                    <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large', array('class' => 'poststyle1-img')); ?>
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
                                    <span class="post-name"><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></span><br>
                                    <span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
                                    <span class="dot"></span>
                                    <span class="readingtime"><?php echo esc_html(mediummate_reading_time()); ?> <?php esc_html_e('min read', 'mediummate'); ?></span>
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
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
        
        <!-- Comments Section -->
        <?php if (get_theme_mod('single_comments_enable', true) && (comments_open() || get_comments_number())) : ?>
        <div class="clearfix"></div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php comments_template(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<!-- Newsletter/Alert Bar - Shows on scroll -->
<div class="alertbar">
    <div class="container text-center">
        <?php echo wp_kses_post(get_theme_mod('single_alertbar_text', __('Enjoy our content? Keep in touch for more', 'mediummate'))); ?> &nbsp;
        <?php if (get_theme_mod('single_alertbar_form', '')) : ?>
            <?php echo do_shortcode(get_theme_mod('single_alertbar_form', '')); ?>
        <?php else : ?>
        <form class="mm-subscribe-form" action="#" method="post">
            <input type="email" name="EMAIL" placeholder="<?php esc_attr_e('Email address', 'mediummate'); ?>" required>
            <input type="submit" value="<?php esc_attr_e('Subscribe', 'mediummate'); ?>">
        </form>
        <?php endif; ?>
    </div>
</div>

<!-- /.site-content -->

<?php get_footer();
