<?php
/**
 * Template Name: Authors List
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header();
?>

<div class="container">
    
    <div class="section-title"> 
        <h2>
            <span><?php echo esc_html(get_theme_mod('authors_list_title', 'Authors')); ?></span>
        </h2> 
    </div>

    <article id="post-<?php the_ID(); ?>" <?php post_class('page type-page'); ?>>                    
        <div class="entry-content">
            <?php 
            $description = get_theme_mod('authors_list_description', '');
            if ($description) : 
                echo '<p class="text-center">' . wp_kses_post($description) . '</p>';
            endif; 
            ?>
        </div>
    </article>
    
    <div class="row mm-posts-grid mm-authors-grid">
        <?php
        // Get all users with published posts
        $authors = get_users(array(
            'capability' => 'edit_posts',
            'orderby' => 'post_count',
            'order' => 'DESC',
            'has_published_posts' => true,
        ));
        
        $bio_length = get_theme_mod('authors_bio_length', 20);

        if (!empty($authors)) :
            foreach ($authors as $author) :
                $author_id = $author->ID;
                $post_count = count_user_posts($author_id);
                $author_url = get_author_posts_url($author_id);
                $author_bio = get_the_author_meta('description', $author_id);
                $website = get_the_author_meta('user_url', $author_id);
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card post author text-center mt-5 mb-2">
                        <div class="card-block">
                            <a href="<?php echo esc_url($author_url); ?>">
                                <?php echo mediummate_get_author_avatar($author_id, 90); ?>
                            </a>
                            <h2 class="card-title">
                                <a href="<?php echo esc_url($author_url); ?>" class="contributor-link">
                                    <?php echo esc_html($author->display_name); ?><br>
                                    <small><?php echo esc_html(sprintf(_n('%d post', '%d posts', $post_count, 'mediummate'), $post_count)); ?></small>
                                </a>
                            </h2>
                            <?php if ($author_bio) : ?>
                                <span class="card-text d-block">
                                    <?php echo wp_kses_post(wp_trim_words($author_bio, $bio_length)); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($website) : ?>
                                <span class="card-text d-block mt-1">
                                    <a target="_blank" href="<?php echo esc_url($website); ?>">
                                        <?php echo esc_html($website); ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                            <div class="profile-icons mt-3">
                                <ul class="social-links">
                                    <li>
                                        <a target="_blank" href="<?php echo esc_url(get_author_feed_link($author_id)); ?>" title="RSS Feed">
                                            <i class="fa fa-rss"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mailto:<?php echo esc_attr(get_the_author_meta('user_email', $author_id)); ?>" title="Email">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    </li>
                                    <?php
                                    // Use individual author's social media links from user meta
                                    $social_networks = array(
                                        'twitter'   => array('icon' => 'fab fa-twitter', 'title' => 'Follow on Twitter'),
                                        'facebook'  => array('icon' => 'fab fa-facebook', 'title' => 'Follow on Facebook'),
                                        'instagram' => array('icon' => 'fab fa-instagram', 'title' => 'Follow on Instagram'),
                                        'linkedin'  => array('icon' => 'fab fa-linkedin', 'title' => 'Connect on LinkedIn'),
                                        'youtube'   => array('icon' => 'fab fa-youtube', 'title' => 'Subscribe on YouTube'),
                                        'github'    => array('icon' => 'fab fa-github', 'title' => 'Follow on GitHub')
                                    );

                                    foreach ($social_networks as $network => $data) :
                                        $url = get_the_author_meta($network, $author_id);
                                        if ($url) :
                                    ?>
                                        <li>
                                            <a target="_blank" href="<?php echo esc_url($url); ?>" rel="noopener noreferrer" title="<?php echo esc_attr($data['title']); ?>">
                                                <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                                            </a>
                                        </li>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        else :
            ?>
            <div class="col-md-12">
                <p class="text-center"><?php esc_html_e('No authors found.', 'mediummate'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer();
