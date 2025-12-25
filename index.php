<?php
/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header(); ?>

<!-- Begin site-content -->
<div class="site-content">
    <div class="container">
        <!-- POSTS BY CATEGORIES -->
        <?php
          // Get featured categories
          $featured_categories = get_categories([
              'number' => 5, // Get 5 categories for different styles
              'orderby' => 'count',
              'order' => 'DESC',
              'hide_empty' => 1,
          ]);

          if (!empty($featured_categories)) {
              // Style 1 - First category
              if (isset($featured_categories[0])) {
                  get_template_part('template-parts/section', 'style-1', ['category' => $featured_categories[0]]);
              }

              // Style 2 - Second category
              if (isset($featured_categories[1])) {
                  get_template_part('template-parts/section', 'style-2', ['category' => $featured_categories[1]]);
              }

              // Style 4 - Third category
              if (isset($featured_categories[2])) {
                  get_template_part('template-parts/section', 'style-4', ['category' => $featured_categories[2]]);
              }

              // Style 5 - Fourth category
              if (isset($featured_categories[3])) {
                  get_template_part('template-parts/section', 'style-5', ['category' => $featured_categories[3]]);
              }

              // Style 2 - Second category
              if (isset($featured_categories[4])) {
                  get_template_part('template-parts/section', 'style-2', ['category' => $featured_categories[1]]);
              }
          }
        ?>

        <!-- BLOG POSTS ALL STORIES -->
        <section class="recent-posts">
            <div class="section-title">
                <h2><span><?php esc_html_e('All Stories', 'mediummate'); ?></span></h2>
            </div>
            
            <div class="row mm-posts-grid">
                <?php
                // Get all posts for recent stories
                $recent_posts = new WP_Query([
                    'posts_per_page' => 6,
                    'post_status' => 'publish'
                ]);

                if ($recent_posts->have_posts()):
                    while ($recent_posts->have_posts()):
                        $recent_posts->the_post(); ?>
                        <div class="col-md-6 col-lg-4 grid-item" id="post-<?php the_ID(); ?>">
                            <div class="card post postbox_default h-100">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="card-block d-flex flex-column">
                                    <h2 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <span class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></span>
                                    <div class="mm-post-meta mt-auto">
                                        <div class="mm-card-footer">
                                            <span class="meta-footer-thumb">
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
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
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>

            <!-- pagination -->
            <div class="mm-pagination">
                <span class="navigation">
                    <?php echo paginate_links([
                        'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                        'next_text' => '<i class="fa fa-angle-double-right"></i>',
                        'type' => 'list',
                    ]); ?>
                </span>
            </div>
        </section>
    </div>
</div><!-- /.site-content -->

<?php get_footer();
