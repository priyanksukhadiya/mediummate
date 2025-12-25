<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header();
?>

<div class="container">
    <?php if (have_posts()) : ?>
        <?php if (!is_paged()) : ?>
            <!-- Featured Posts Grid Section -->
            <?php get_template_part('template-parts/section', 'featured-grid'); ?>

            <!-- Featured Categories Section -->
            <?php
            $featured_categories = mediummate_get_featured_categories();
            
            if (!empty($featured_categories)) {
                $styles = array('style-1', 'style-2', 'style-4', 'style-5');
                
                foreach ($featured_categories as $index => $category) {
                    $style = $styles[$index % count($styles)];
                    get_template_part('template-parts/section', $style, ['category' => $category]);
                }
            }
            ?>

        <?php endif; ?>

        <!-- BLOG POSTS ALL STORIES -->
        <section class="recent-posts">
            <!-- Latest Stories Section -->
            <div class="section-title">
                <h2><span><?php echo esc_html(get_theme_mod('recent_posts_title', 'Latest Stories')); ?></span></h2>
            </div>

            <!-- Recent Posts Grid -->
            <div class="row mm-posts-grid">
                <?php
                // Get recent posts for front page with customizer settings
                $posts_count = get_theme_mod('recent_posts_count', 6);
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                
                $recent_posts = new WP_Query([
                    'posts_per_page' => absint($posts_count),
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => 1,
                    'paged' => $paged
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
                    <?php endwhile;
                endif;
                ?>
            </div>

            <!-- Pagination -->
            <div class="mm-pagination">
                <span class="navigation">
                    <?php
                    // Use the custom query's max_num_pages for pagination
                    $current_page = max(1, $paged);
                    $max_pages = $recent_posts->max_num_pages;

                    if ($max_pages > 1) {
                        echo '<ul class="pagination">';
                        
                        // First page link
                        if ($current_page > 1) {
                            echo '<li><a href="' . esc_url(get_pagenum_link(1)) . '">First</a></li>';
                        } else {
                            echo '<li class="disabled"><span>First</span></li>';
                        }
                        
                        // Previous page link with <<
                        if ($current_page > 1) {
                            echo '<li><a href="' . esc_url(get_pagenum_link($current_page - 1)) . '"><i class="fa fa-angle-double-left"></i></a></li>';
                        } else {
                            echo '<li class="disabled"><span><i class="fa fa-angle-double-left"></i></span></li>';
                        }
                        
                        // Page numbers
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($max_pages, $current_page + 2);
                        
                        // Show first page if we're not starting from 1
                        if ($start_page > 1) {
                            echo '<li><a href="' . esc_url(get_pagenum_link(1)) . '">1</a></li>';
                            if ($start_page > 2) {
                                echo '<li class="disabled"><span>...</span></li>';
                            }
                        }
                        
                        // Show page numbers
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            if ($i == $current_page) {
                                echo '<li><a href="' . esc_url(get_pagenum_link($i)) . '" class="active">' . $i . '</a></li>';
                            } else {
                                echo '<li><a href="' . esc_url(get_pagenum_link($i)) . '">' . $i . '</a></li>';
                            }
                        }
                        
                        // Show last page if we're not ending at max
                        if ($end_page < $max_pages) {
                            if ($end_page < $max_pages - 1) {
                                echo '<li class="disabled"><span>...</span></li>';
                            }
                            echo '<li><a href="' . esc_url(get_pagenum_link($max_pages)) . '">' . $max_pages . '</a></li>';
                        }
                        
                        // Next page link with >>
                        if ($current_page < $max_pages) {
                            echo '<li><a href="' . esc_url(get_pagenum_link($current_page + 1)) . '"><i class="fa fa-angle-double-right"></i></a></li>';
                        } else {
                            echo '<li class="disabled"><span><i class="fa fa-angle-double-right"></i></span></li>';
                        }
                        
                        // Last page link
                        if ($current_page < $max_pages) {
                            echo '<li><a href="' . esc_url(get_pagenum_link($max_pages)) . '">Last</a></li>';
                        } else {
                            echo '<li class="disabled"><span>Last</span></li>';
                        }
                        
                        echo '</ul>';
                    }
                    wp_reset_postdata();
                    ?>
                </span>
            </div>
        </section>
    <?php else :
        get_template_part('template-parts/content', 'none');
    endif; ?>
</div>

<?php get_footer();
