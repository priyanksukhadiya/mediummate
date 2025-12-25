<?php
/**
 * The template for displaying category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header();
?>

<div class="container">
    <section class="recent-posts">
        <div class="section-title">
            <h2>
                <span><?php single_cat_title(); ?></span>
            </h2>
            <?php 
                $category_description = category_description();
                if (!empty($category_description)) {
                    echo '<div class="category-description">' . wp_kses_post($category_description) . '</div>';
                }
            ?>
        </div>

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
                ?>
            </div>

            <!-- Pagination -->
            <!-- Pagination -->
            <div class="mm-pagination">
                <span class="navigation">
                    <?php
                    global $wp_query;
                    $current_page = max(1, get_query_var('paged'));
                    $max_pages = $wp_query->max_num_pages;

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
                    ?>
                </span>
            </div>

        <?php else : ?>
            <div class="row">
                <div class="col-md-12">
                    <?php get_template_part('template-parts/content', 'none'); ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php get_footer();
