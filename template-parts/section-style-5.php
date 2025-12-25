<?php
/**
 * Template part for displaying posts in style 5
 */
?>
<div class="section-title listpostsbycats">
    <h2 class="d-flex justify-content-between align-items-center">
        <span><?php echo esc_html($args['category']->name); ?> &nbsp;</span>
        <a class="d-block morefromcategory" href="<?php echo esc_url(get_category_link($args['category']->term_id)); ?>">
            &nbsp; <i class="fa fa-angle-right"></i>
        </a>
    </h2>
</div>

<section class="featured-posts listpostsbycats post-style-5">
    <div class="row listfeaturedtag h-100">
        <?php
        $posts_query = new WP_Query([
            'category_name' => $args['category']->slug,
            'posts_per_page' => 9
        ]);

        if ($posts_query->have_posts()) :
            while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                <div class="col-md-4 mb-30">
                    <div class="card post_card_tall h-100" id="post-<?php the_ID(); ?>">
                        <div class="row h-100">
                            <div class="col-lg-5 wrapthumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a class="d-block h-100" href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-7">
                                <div class="card-block d-flex flex-column h-100">
                                    <h2 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <span class="card-text d-block"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></span>
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
                    </div>
                </div>
            <?php endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>
