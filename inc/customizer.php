<?php
/**
 * mediummate Theme Customizer Helper Functions
 *
 * @package mediummate
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if we're in customizer context before defining custom controls
 */
function mediummate_customizer_init() {
    /**
     * Custom Category Control for Customizer
     */
    if (class_exists('WP_Customize_Control')) {
        class WP_Customize_Category_Control extends WP_Customize_Control {
            public $type = 'category_dropdown';

            public function render_content() {
                $categories = get_categories(array('hide_empty' => false));
                if (!empty($categories)) {
                    ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                        <?php if (!empty($this->description)) : ?>
                            <span class="description customize-control-description"><?php echo $this->description; ?></span>
                        <?php endif; ?>
                        <select <?php $this->link(); ?>>
                            <option value=""><?php _e('Select Category', 'mediummate'); ?></option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($this->value(), $category->term_id); ?>>
                                    <?php echo esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <?php
                }
            }
        }

        /**
         * Custom Toggle Control for Customizer
         */
        class WP_Customize_Toggle_Control extends WP_Customize_Control {
            public $type = 'toggle';

            public function enqueue() {
                wp_enqueue_script('customizer-toggle-control', get_template_directory_uri() . '/inc/js/customizer-toggle.js', array('jquery'), '1.0', true);
                wp_enqueue_style('customizer-toggle-control', get_template_directory_uri() . '/inc/css/customizer-toggle.css', array(), '1.0');
            }

            public function render_content() {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php if (!empty($this->description)) : ?>
                        <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php endif; ?>
                    <div class="toggle-switch">
                        <input type="checkbox" id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); checked($this->value()); ?> />
                        <label for="<?php echo $this->id; ?>" class="toggle-label">
                            <span class="toggle-inner"></span>
                            <span class="toggle-switch-handle"></span>
                        </label>
                    </div>
                </label>
                <?php
            }
        }

        /**
         * Multiple Select Control for Customizer
         */
        class WP_Customize_Multiple_Select_Control extends WP_Customize_Control {
            public $type = 'multiple_select';

            public function render_content() {
                if (empty($this->choices)) {
                    return;
                }
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php if (!empty($this->description)) : ?>
                        <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php endif; ?>
                    <select multiple="multiple" <?php $this->link(); ?>>
                        <?php
                        foreach ($this->choices as $value => $label) {
                            $selected = (in_array($value, (array) $this->value())) ? selected(1, 1, false) : '';
                            echo '<option value="' . esc_attr($value) . '"' . $selected . '>' . $label . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <?php
            }
        }

        /**
         * Range Slider Control for Customizer
         */
        class WP_Customize_Range_Control extends WP_Customize_Control {
            public $type = 'range';

            public function enqueue() {
                wp_enqueue_script('customizer-range-control', get_template_directory_uri() . '/inc/js/customizer-range.js', array('jquery'), '1.0', true);
            }

            public function render_content() {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php if (!empty($this->description)) : ?>
                        <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php endif; ?>
                    <div class="range-slider">
                        <input type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr($this->value()); ?>" <?php $this->link(); ?> />
                        <span class="range-value"><?php echo esc_html($this->value()); ?></span>
                    </div>
                </label>
                <?php
            }
        }
    }
}
add_action('customize_register', 'mediummate_customizer_init');

/**
 * Get social media links for display
 */
function mediummate_get_social_links() {
    $social_links = array();
    
    $social_networks = array(
        'twitter'   => array(
            'url'   => get_theme_mod('social_twitter_url', ''),
            'icon'  => 'fab fa-twitter',
            'title' => __('Follow us on Twitter', 'mediummate')
        ),
        'facebook'  => array(
            'url'   => get_theme_mod('social_facebook_url', ''),
            'icon'  => 'fab fa-facebook',
            'title' => __('Follow us on Facebook', 'mediummate')
        ),
        'instagram' => array(
            'url'   => get_theme_mod('social_instagram_url', ''),
            'icon'  => 'fab fa-instagram',
            'title' => __('Follow us on Instagram', 'mediummate')
        ),
        'linkedin'  => array(
            'url'   => get_theme_mod('social_linkedin_url', ''),
            'icon'  => 'fab fa-linkedin',
            'title' => __('Connect with us on LinkedIn', 'mediummate')
        ),
        'youtube'   => array(
            'url'   => get_theme_mod('social_youtube_url', ''),
            'icon'  => 'fab fa-youtube',
            'title' => __('Subscribe to our YouTube channel', 'mediummate')
        ),
        'github'    => array(
            'url'   => get_theme_mod('social_github_url', ''),
            'icon'  => 'fab fa-github',
            'title' => __('Follow us on GitHub', 'mediummate')
        )
    );
    
    foreach ($social_networks as $network => $data) {
        if (!empty($data['url'])) {
            $social_links[$network] = $data;
        }
    }
    
    return $social_links;
}

/**
 * Display social media links
 */
function mediummate_social_links_display() {
    $social_links = mediummate_get_social_links();
    
    if (!empty($social_links)) {
        echo '<ul class="social-links">';
        foreach ($social_links as $network => $data) {
            printf(
                '<li><a href="%s" target="_blank" rel="noopener noreferrer" title="%s"><i class="%s"></i></a></li>',
                esc_url($data['url']),
                esc_attr($data['title']),
                esc_attr($data['icon'])
            );
        }
        echo '</ul>';
    }
}

/**
 * Get slider posts based on customizer settings
 */
function mediummate_get_slider_posts() {
    $slider_enable = get_theme_mod('slider_enable', true);
    
    if (!$slider_enable) {
        return false;
    }
    
    $posts_count = get_theme_mod('slider_posts_count', 4);
    $category_id = get_theme_mod('slider_category', '');
    
    $args = array(
        'posts_per_page' => absint($posts_count),
        'post_status'    => 'publish',
        'meta_key'       => '_thumbnail_id' // Only posts with featured images
    );
    
    if (!empty($category_id)) {
        $args['cat'] = absint($category_id);
    }
    
    return new WP_Query($args);
}

/**
 * Get featured categories for homepage
 */
function mediummate_get_featured_categories() {
    $enable_categories = get_theme_mod('featured_categories_enable', true);
    
    if (!$enable_categories) {
        return array();
    }
    
    // Check if specific categories are selected
    $selected_categories = get_theme_mod('featured_categories_list', array());
    
    if (!empty($selected_categories) && is_array($selected_categories)) {
        // Get only the selected categories
        return get_categories(array(
            'include'    => $selected_categories,
            'orderby'    => 'include', // Maintain the order they were selected
            'order'      => 'ASC',
            'hide_empty' => 0 // Show even if empty since user specifically selected them
        ));
    }
    
    // Fallback to top categories by count
    $categories_count = get_theme_mod('featured_categories_count', 4);
    
    return get_categories(array(
        'number'     => absint($categories_count),
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => 1
    ));
}

/**
 * Customizer live preview JavaScript
 */
function mediummate_customizer_preview_js() {
    wp_enqueue_script(
        'mediummate-customizer-preview',
        get_template_directory_uri() . '/inc/js/customizer-preview.js',
        array('customize-preview'),
        MEDIUMMATE_VERSION,
        true
    );
}
add_action('customize_preview_init', 'mediummate_customizer_preview_js');

/**
 * Get related posts for single post page
 */
function mediummate_get_related_posts($post_id = null, $limit = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    $enable_related = get_theme_mod('single_related_posts_enable', true);
    if (!$enable_related) {
        return false;
    }
    
    $limit = $limit ?: get_theme_mod('single_related_posts_count', 3);
    
    $categories = get_the_category($post_id);
    if (!$categories) {
        return false;
    }
    
    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }
    
    return new WP_Query(array(
        'category__in' => $category_ids,
        'post__not_in' => array($post_id),
        'posts_per_page' => absint($limit),
        'ignore_sticky_posts' => 1
    ));
}

/**
 * Get authors list with customizer settings
 */
function mediummate_get_authors_list() {
    return get_users(array(
        'has_published_posts' => array('post'),
        'orderby' => 'post_count',
        'order' => 'DESC'
    ));
}

/**
 * Get column class for authors layout
 */
function mediummate_get_authors_column_class() {
    $per_row = get_theme_mod('authors_per_row', 3);
    
    switch ($per_row) {
        case 2:
            return 'col-md-6';
        case 4:
            return 'col-md-6 col-lg-3';
        default:
            return 'col-md-6 col-lg-4';
    }
}

/**
 * Check if author bio should be shown on single posts
 */
function mediummate_show_author_bio() {
    return get_theme_mod('single_author_bio_enable', true);
}

/**
 * Check if comments should be shown on single posts
 */
function mediummate_show_comments() {
    return get_theme_mod('single_comments_enable', true);
}

/**
 * Get author social links
 */
function mediummate_get_author_social_links($author_id) {
    $enable_social = get_theme_mod('author_social_links_enable', true);
    
    if (!$enable_social) {
        return array();
    }
    
    $social_links = array();
    
    $social_networks = array(
        'twitter' => array(
            'url' => get_the_author_meta('twitter', $author_id),
            'icon' => 'fab fa-twitter',
            'title' => __('Twitter', 'mediummate')
        ),
        'facebook' => array(
            'url' => get_the_author_meta('facebook', $author_id),
            'icon' => 'fab fa-facebook',
            'title' => __('Facebook', 'mediummate')
        ),
        'website' => array(
            'url' => get_the_author_meta('url', $author_id),
            'icon' => 'fas fa-globe',
            'title' => __('Website', 'mediummate')
        ),
        'linkedin' => array(
            'url' => get_the_author_meta('linkedin', $author_id),
            'icon' => 'fab fa-linkedin',
            'title' => __('LinkedIn', 'mediummate')
        ),
        'instagram' => array(
            'url' => get_the_author_meta('instagram', $author_id),
            'icon' => 'fab fa-instagram',
            'title' => __('Instagram', 'mediummate')
        )
    );
    
    foreach ($social_networks as $network => $data) {
        if (!empty($data['url'])) {
            $social_links[$network] = $data;
        }
    }
    
    return $social_links;
}

/**
 * Display author social links
 */
function mediummate_display_author_social_links($author_id) {
    $social_links = mediummate_get_author_social_links($author_id);
    
    if (!empty($social_links)) {
        echo '<div class="author-social-links">';
        foreach ($social_links as $network => $data) {
            printf(
                '<a href="%s" target="_blank" rel="noopener noreferrer" title="%s" class="social-link"><i class="%s"></i></a>',
                esc_url($data['url']),
                esc_attr($data['title']),
                esc_attr($data['icon'])
            );
        }
        echo '</div>';
    }
}

/**
 * Get author posts layout class
 */
function mediummate_get_author_posts_layout_class() {
    $layout = get_theme_mod('author_posts_layout', 'grid');
    return $layout === 'list' ? 'author-posts-list' : 'author-posts-grid';
}

/**
 * Enqueue customizer controls JavaScript and CSS
 */
function mediummate_customizer_controls_js() {
    wp_enqueue_script(
        'mediummate-customizer-controls',
        get_template_directory_uri() . '/inc/js/customizer-controls.js',
        array('jquery', 'customize-controls'),
        MEDIUMMATE_VERSION,
        true
    );
    
    wp_enqueue_style(
        'mediummate-customizer-controls',
        get_template_directory_uri() . '/inc/css/customizer-controls.css',
        array(),
        MEDIUMMATE_VERSION
    );
}
add_action('customize_controls_enqueue_scripts', 'mediummate_customizer_controls_js');