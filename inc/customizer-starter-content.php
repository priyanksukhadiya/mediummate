<?php
/**
 * mediummate Theme Customizer Starter Content
 *
 * @package mediummate
 */

/**
 * Register starter content for the customizer
 */
function mediummate_customizer_starter_content() {
    $starter_content = array(
        // Specify the theme_mods that are used
        'theme_mods' => array(
            // Homepage Settings
            'slider_enable'               => true,
            'slider_posts_count'          => 4,
            'featured_categories_enable'  => true,
            'featured_categories_count'   => 4,
            'recent_posts_title'          => 'Latest Stories',
            'recent_posts_count'          => 6,
            
            // Colors & Styling
            'primary_color'               => '#03a87c',
            'nav_text_color'              => '#888888',
            'nav_hover_color'             => '#03a87c',
            'heading_color'               => '#000000',
            'heading_hover_color'         => '#03a87c',
            'body_text_color'             => '#333333',
            'header_bg_color'             => '#ffffff',
            
            // Typography
            'body_font_family'            => 'Rubik',
            'heading_font_family'         => 'Rubik',
            
            // Single Post Settings
            'single_related_posts_enable' => true,
            'single_related_posts_title'  => 'Related Posts',
            'single_related_posts_count'  => 3,
            'single_author_bio_enable'    => true,
            'single_comments_enable'      => true,
            
            // Author Pages Settings
            'authors_list_title'          => 'Our Authors',
            'authors_list_description'    => 'Meet our talented team of writers and content creators.',
            'authors_bio_length'          => 20,
            'authors_per_row'             => 3,
            'author_social_links_enable'  => true,
            'author_posts_layout'         => 'grid',
            'author_posts_per_page'       => 6,
            'author_stats_enable'         => true,
            
            // Social Media (placeholder URLs)
            'social_twitter_url'          => '',
            'social_facebook_url'         => '',
            'social_instagram_url'        => '',
            'social_linkedin_url'         => '',
            'social_youtube_url'          => '',
            'social_github_url'           => '',
            
            // Footer
            'footer_copyright'            => '© ' . date('Y') . ' MediumMate. All rights reserved.',
            'category_cloud_enable'       => true,
        ),
    );
    
    add_theme_support('starter-content', $starter_content);
}
add_action('after_setup_theme', 'mediummate_customizer_starter_content');

/**
 * Add Customizer CSS for better styling
 */
function mediummate_customizer_additional_css() {
    ?>
    <style>
    /* Social Links Styling */
    .social-links {
        align-items: center;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .social-links li a {
        display: inline-block;
        width: 40px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        background: #f8f9fa;
        border-radius: 50%;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-links li a:hover {
        background: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
        color: #fff;
        transform: translateY(-2px);
    }
    
    /* Category Cloud Styling */
    .category-cloud .category-tags {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
    
    .category-cloud .btn-outline-secondary {
        border-color: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
        color: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
    }
    
    .category-cloud .btn-outline-secondary:hover {
        background-color: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
        border-color: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
    }
    
    /* Hero Slider Styling */
    .hero-slider {
        margin-bottom: 40px;
    }
    
    .hero-slider .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .hero-slider .card:hover {
        transform: translateY(-5px);
    }
    
    .hero-slider .card-title a {
        color: #333;
        text-decoration: none;
    }
    
    .hero-slider .card-title a:hover {
        color: <?php echo esc_attr(get_theme_mod('primary_color', '#03a87c')); ?>;
    }
    </style>
    <?php
}
add_action('wp_head', 'mediummate_customizer_additional_css');