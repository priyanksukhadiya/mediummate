<?php
/**
 * mediummate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mediummate
 */

if ( ! defined( 'MEDIUMMATE_VERSION' ) ) {
    define( 'MEDIUMMATE_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mediummate_setup() {
    /*
     * Make theme available for translation.
     */
    load_theme_textdomain( 'mediummate', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for Custom Logo.
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add theme support for Custom Header.
    add_theme_support(
        'custom-header',
        array(
            'default-image'      => '',
            'width'              => 1920,
            'height'             => 400,
            'flex-width'         => true,
            'flex-height'        => true,
            'uploads'            => true,
            'header-text'        => false,
        )
    );

    // Add theme support for Custom Background.
    add_theme_support(
        'custom-background',
        array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )
    );

    // Add support for wide alignment in Gutenberg.
    add_theme_support( 'align-wide' );

    // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add editor styles.
    add_editor_style( 'assets/css/editor-style.css' );

    // Register nav menus
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'mediummate' ),
            'footer'  => esc_html__( 'Footer Menu', 'mediummate' ),
        )
    );
}
add_action( 'after_setup_theme', 'mediummate_setup' );

/**
 * Set the content width in pixels
 */
function mediummate_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'mediummate_content_width', 1140 );
}
add_action( 'after_setup_theme', 'mediummate_content_width', 0 );

/**
 * Register widget area.
 */
function mediummate_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'mediummate' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'mediummate' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'mediummate_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mediummate_scripts() {
    // Styles
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), MEDIUMMATE_VERSION );
    wp_enqueue_style( 'mediummate-style', get_stylesheet_uri(), array(), time() );
    wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v6.3.0/css/all.css', array(), '6.3.0' );
    wp_enqueue_style( 'mediummate-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), MEDIUMMATE_VERSION );

    // Scripts
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), MEDIUMMATE_VERSION, true );
    wp_enqueue_script( 'mediummate-main', get_template_directory_uri() . '/assets/js/mediummate-scripts.js', array('jquery'), MEDIUMMATE_VERSION, true );

    // Back to top button script
    if (get_theme_mod('back_to_top_enable', true)) {
        $back_to_top_script = '
            jQuery(document).ready(function($) {
                // Back to top button functionality
                $(window).scroll(function() {
                    if ($(this).scrollTop() > 300) {
                        $("#back-to-top").show();
                    } else {
                        $("#back-to-top").hide();
                    }
                });
                
                $("#back-to-top").click(function(e) {
                    e.preventDefault();
                    $("html, body").animate({scrollTop: 0}, 600);
                    return false;
                });
            });
        ';
        wp_add_inline_script( 'mediummate-main', $back_to_top_script );
    }

    // Add alertbar scroll script for single posts
    if ( is_singular() ) {
        $alertbar_script = '
            jQuery(document).ready(function($) {
                $(document).scroll(function() {
                    var y = $(this).scrollTop();
                    if (y > 280) {
                        $(".alertbar").fadeIn();
                    } else {
                        $(".alertbar").fadeOut();
                    }
                });
            });
        ';
        wp_add_inline_script( 'mediummate-main', $alertbar_script );
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mediummate_scripts' );

/**
 * Calculate reading time for posts
 *
 * @return int Reading time in minutes
 */
function mediummate_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Assuming 200 words per minute reading speed
    
    return max(1, $reading_time); // Minimum 1 minute reading time
}


/**
 * Include customizer helper functions
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-starter-content.php';

/**
 * Include Bootstrap Navwalker
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Footer Navigation Walker
 */
class Footer_Nav_Walker extends Walker_Nav_Menu {
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        // No sub-menus in footer
    }

    /**
     * Ends the list after the elements are added.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        // No sub-menus in footer
    }

    /**
     * Starts the element output.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'list-inline-item';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= isset($args->link_after) ? $args->link_after : '';
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output.
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}

/**
 * Custom Multi-Category Select Control for Customizer
 */
if (class_exists('WP_Customize_Control')) {
    class MediumMate_Multiple_Category_Control extends WP_Customize_Control {
        public $type = 'multiple-category';

        public function render_content() {
            $categories = get_categories(array(
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));

            $selected = $this->value();
            if (!is_array($selected)) {
                $selected = array();
            }
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
                <select multiple="multiple" <?php $this->link(); ?> style="height: 150px; width: 100%;">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->term_id); ?>" <?php echo in_array($category->term_id, $selected) ? 'selected="selected"' : ''; ?>>
                            <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description" style="margin-top: 5px;"><?php _e('Hold Ctrl/Cmd to select multiple categories.', 'mediummate'); ?></p>
            </label>
            <?php
        }
    }
}

/**
 * Sanitize multiple categories
 */
function mediummate_sanitize_multiple_categories($input) {
    if (empty($input)) {
        return array();
    }
    if (is_array($input)) {
        return array_map('absint', $input);
    }
    return array(absint($input));
}

/**
 * Customizer additions.
 */
function mediummate_customize_register($wp_customize) {
    
    // =========================================
    // HOMEPAGE SETTINGS PANEL
    // =========================================
    $wp_customize->add_panel('mediummate_homepage_panel', array(
        'title'       => __('MediumMate Homepage', 'mediummate'),
        'description' => __('Customize your homepage layout and content.', 'mediummate'),
        'priority'    => 20,
    ));

    // =========================================
    // FEATURED GRID SECTION
    // =========================================
    $wp_customize->add_section('mediummate_slider_section', array(
        'title'    => __('Featured Posts Grid', 'mediummate'),
        'panel'    => 'mediummate_homepage_panel',
        'priority' => 10,
    ));

    // Enable/Disable Featured Grid
    $wp_customize->add_setting('slider_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('slider_enable', array(
        'label'    => __('Enable Featured Posts Grid', 'mediummate'),
        'section'  => 'mediummate_slider_section',
        'type'     => 'checkbox',
    ));

    // Featured Posts Count
    $wp_customize->add_setting('slider_posts_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('slider_posts_count', array(
        'label'       => __('Number of Featured Posts', 'mediummate'),
        'description' => __('Select how many posts to display in the featured grid section.', 'mediummate'),
        'section'     => 'mediummate_slider_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
        ),
    ));

    // Featured Posts Category
    $wp_customize->add_setting('slider_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Category_Control($wp_customize, 'slider_category', array(
        'label'       => __('Featured Posts Category', 'mediummate'),
        'description' => __('Select a specific category for featured posts (leave empty for recent posts).', 'mediummate'),
        'section'     => 'mediummate_slider_section',
    )));

    // =========================================
    // FEATURED CATEGORIES SECTION
    // =========================================
    $wp_customize->add_section('mediummate_categories_section', array(
        'title'    => __('Featured Categories', 'mediummate'),
        'panel'    => 'mediummate_homepage_panel',
        'priority' => 20,
    ));

    // Enable/Disable Featured Categories
    $wp_customize->add_setting('featured_categories_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('featured_categories_enable', array(
        'label'    => __('Show Featured Categories', 'mediummate'),
        'section'  => 'mediummate_categories_section',
        'type'     => 'checkbox',
    ));

    // Number of Featured Categories
    $wp_customize->add_setting('featured_categories_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('featured_categories_count', array(
        'label'       => __('Number of Featured Categories', 'mediummate'),
        'description' => __('Only used when specific categories are not selected below.', 'mediummate'),
        'section'     => 'mediummate_categories_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8,
        ),
    ));

    // Select Specific Categories (Multi-select)
    $wp_customize->add_setting('featured_categories_list', array(
        'default'           => array(),
        'sanitize_callback' => 'mediummate_sanitize_multiple_categories',
    ));
    $wp_customize->add_control(new MediumMate_Multiple_Category_Control($wp_customize, 'featured_categories_list', array(
        'label'       => __('Select Featured Categories', 'mediummate'),
        'description' => __('Select specific categories to display. Leave empty to show top categories by post count.', 'mediummate'),
        'section'     => 'mediummate_categories_section',
    )));

    // =========================================
    // RECENT POSTS SECTION
    // =========================================
    $wp_customize->add_section('mediummate_recent_posts_section', array(
        'title'    => __('Recent Posts Section', 'mediummate'),
        'panel'    => 'mediummate_homepage_panel',
        'priority' => 30,
    ));

    // Recent Posts Title
    $wp_customize->add_setting('recent_posts_title', array(
        'default'           => 'Latest Stories',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('recent_posts_title', array(
        'label'    => __('Recent Posts Section Title', 'mediummate'),
        'section'  => 'mediummate_recent_posts_section',
        'type'     => 'text',
    ));

    // Recent Posts Count
    $wp_customize->add_setting('recent_posts_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('recent_posts_count', array(
        'label'       => __('Number of Recent Posts', 'mediummate'),
        'section'     => 'mediummate_recent_posts_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
        ),
    ));

    // =========================================
    // COLORS & STYLING PANEL
    // =========================================
    $wp_customize->add_panel('mediummate_styling_panel', array(
        'title'       => __('Colors & Styling', 'mediummate'),
        'description' => __('Customize colors, fonts, and styling options.', 'mediummate'),
        'priority'    => 25,
    ));

    // =========================================
    // COLORS SECTION
    // =========================================
    $wp_customize->add_section('mediummate_colors_section', array(
        'title'    => __('Theme Colors', 'mediummate'),
        'panel'    => 'mediummate_styling_panel',
        'priority' => 10,
    ));

    // Primary Color (for buttons, links, accents)
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#03a87c',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'       => __('Primary Accent Color', 'mediummate'),
        'description' => __('Used for buttons, links, and highlights', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Navigation Colors
    $wp_customize->add_setting('nav_text_color', array(
        'default'           => '#888888',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nav_text_color', array(
        'label'       => __('Navigation Text Color', 'mediummate'),
        'description' => __('Default navigation menu text color', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Navigation Hover Color
    $wp_customize->add_setting('nav_hover_color', array(
        'default'           => '#03a87c',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nav_hover_color', array(
        'label'       => __('Navigation Hover Color', 'mediummate'),
        'description' => __('Navigation menu hover and active state color', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Heading Colors
    $wp_customize->add_setting('heading_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'heading_color', array(
        'label'       => __('Heading Text Color', 'mediummate'),
        'description' => __('Color for H1, H2, H3, H4, H5, H6 headings', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Heading Hover Color
    $wp_customize->add_setting('heading_hover_color', array(
        'default'           => '#03a87c',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'heading_hover_color', array(
        'label'       => __('Heading Hover Color', 'mediummate'),
        'description' => __('Color for headings when hovered (for linked headings)', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Body Text Color
    $wp_customize->add_setting('body_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'body_text_color', array(
        'label'       => __('Body Text Color', 'mediummate'),
        'description' => __('Main content text color', 'mediummate'),
        'section'     => 'mediummate_colors_section',
    )));

    // Header Background Color
    $wp_customize->add_setting('header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg_color', array(
        'label'    => __('Header Background Color', 'mediummate'),
        'section'  => 'mediummate_colors_section',
    )));

    // =========================================
    // TYPOGRAPHY SECTION
    // =========================================
    $wp_customize->add_section('mediummate_typography_section', array(
        'title'    => __('Typography', 'mediummate'),
        'panel'    => 'mediummate_styling_panel',
        'priority' => 20,
    ));

    // Body Font Family
    $wp_customize->add_setting('body_font_family', array(
        'default'           => 'Rubik',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('body_font_family', array(
        'label'       => __('Body Font Family', 'mediummate'),
        'description' => __('Enter a Google Font name (e.g., "Open Sans", "Roboto").', 'mediummate'),
        'section'     => 'mediummate_typography_section',
        'type'        => 'text',
    ));

    // Heading Font Family
    $wp_customize->add_setting('heading_font_family', array(
        'default'           => 'Rubik',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('heading_font_family', array(
        'label'       => __('Heading Font Family', 'mediummate'),
        'description' => __('Enter a Google Font name for headings.', 'mediummate'),
        'section'     => 'mediummate_typography_section',
        'type'        => 'text',
    ));

    // Blog Content Font Family (for single post article content)
    $wp_customize->add_setting('blog_content_font_family', array(
        'default'           => 'Merriweather',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blog_content_font_family', array(
        'label'       => __('Blog Content Font Family', 'mediummate'),
        'description' => __('Enter a Google Font name for single blog post content (e.g., "Merriweather", "Georgia").', 'mediummate'),
        'section'     => 'mediummate_typography_section',
        'type'        => 'text',
    ));

    // =========================================
    // HEADER SETTINGS SECTION
    // =========================================
    $wp_customize->add_section('mediummate_header_section', array(
        'title'       => __('Header Settings', 'mediummate'),
        'description' => __('Customize your header layout and options.', 'mediummate'),
        'priority'    => 25,
    ));

    // Enable/Disable Search in Header
    $wp_customize->add_setting('header_search_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_search_enable', array(
        'label'       => __('Enable Search Box', 'mediummate'),
        'description' => __('Show/hide the search box in header.', 'mediummate'),
        'section'     => 'mediummate_header_section',
        'type'        => 'checkbox',
    ));

    // Search Placeholder Text
    $wp_customize->add_setting('header_search_placeholder', array(
        'default'           => 'Search...',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_search_placeholder', array(
        'label'    => __('Search Placeholder Text', 'mediummate'),
        'section'  => 'mediummate_header_section',
        'type'     => 'text',
    ));

    // Enable/Disable Social Icons in Header
    $wp_customize->add_setting('header_social_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_social_enable', array(
        'label'       => __('Show Social Icons in Header', 'mediummate'),
        'description' => __('Display social media icons in the header.', 'mediummate'),
        'section'     => 'mediummate_header_section',
        'type'        => 'checkbox',
    ));

    // Enable/Disable Twitter Follow Button
    $wp_customize->add_setting('header_twitter_follow_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_twitter_follow_enable', array(
        'label'       => __('Show Twitter Follow Button', 'mediummate'),
        'description' => __('Display Twitter follow button in header.', 'mediummate'),
        'section'     => 'mediummate_header_section',
        'type'        => 'checkbox',
    ));

    // Twitter Follow Button Text
    $wp_customize->add_setting('header_twitter_follow_text', array(
        'default'           => 'Follow',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_twitter_follow_text', array(
        'label'    => __('Twitter Follow Button Text', 'mediummate'),
        'section'  => 'mediummate_header_section',
        'type'     => 'text',
    ));

    // Sticky Header
    $wp_customize->add_setting('header_sticky_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('header_sticky_enable', array(
        'label'       => __('Enable Sticky Header', 'mediummate'),
        'description' => __('Make header fixed on scroll.', 'mediummate'),
        'section'     => 'mediummate_header_section',
        'type'        => 'checkbox',
    ));

    // =========================================
    // SOCIAL MEDIA SECTION
    // =========================================
    $wp_customize->add_section('mediummate_social_section', array(
        'title'       => __('Social Media Links', 'mediummate'),
        'description' => __('Add your social media profile URLs.', 'mediummate'),
        'priority'    => 30,
    ));

    // Twitter URL
    $wp_customize->add_setting('social_twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_twitter_url', array(
        'label'    => __('Twitter URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // Facebook URL
    $wp_customize->add_setting('social_facebook_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook_url', array(
        'label'    => __('Facebook URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // Instagram URL
    $wp_customize->add_setting('social_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_instagram_url', array(
        'label'    => __('Instagram URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // LinkedIn URL
    $wp_customize->add_setting('social_linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_linkedin_url', array(
        'label'    => __('LinkedIn URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // YouTube URL
    $wp_customize->add_setting('social_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_youtube_url', array(
        'label'    => __('YouTube URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // GitHub URL
    $wp_customize->add_setting('social_github_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_github_url', array(
        'label'    => __('GitHub URL', 'mediummate'),
        'section'  => 'mediummate_social_section',
        'type'     => 'url',
    ));

    // =========================================
    // SINGLE POST SETTINGS PANEL
    // =========================================
    $wp_customize->add_panel('mediummate_single_panel', array(
        'title'       => __('Single Post Settings', 'mediummate'),
        'description' => __('Customize single post page layout and features.', 'mediummate'),
        'priority'    => 30,
    ));

    // =========================================
    // SINGLE POST SECTION
    // =========================================
    $wp_customize->add_section('mediummate_single_section', array(
        'title'    => __('Single Post Layout', 'mediummate'),
        'panel'    => 'mediummate_single_panel',
        'priority' => 10,
    ));

    // Enable/Disable Related Posts
    $wp_customize->add_setting('single_related_posts_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_related_posts_enable', array(
        'label'    => __('Show Related Posts', 'mediummate'),
        'section'  => 'mediummate_single_section',
        'type'     => 'checkbox',
    ));

    // Related Posts Title
    $wp_customize->add_setting('single_related_posts_title', array(
        'default'           => 'Related Posts',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('single_related_posts_title', array(
        'label'    => __('Related Posts Title', 'mediummate'),
        'section'  => 'mediummate_single_section',
        'type'     => 'text',
    ));

    // Related Posts Count
    $wp_customize->add_setting('single_related_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('single_related_posts_count', array(
        'label'       => __('Number of Related Posts', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 6,
        ),
    ));

    // Enable/Disable Author Bio
    $wp_customize->add_setting('single_author_bio_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_author_bio_enable', array(
        'label'    => __('Show Author Bio Box', 'mediummate'),
        'section'  => 'mediummate_single_section',
        'type'     => 'checkbox',
    ));

    // Enable/Disable Comments
    $wp_customize->add_setting('single_comments_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_comments_enable', array(
        'label'    => __('Enable Comments', 'mediummate'),
        'section'  => 'mediummate_single_section',
        'type'     => 'checkbox',
    ));

    // Enable/Disable Clapping Feature
    $wp_customize->add_setting('single_clapping_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_clapping_enable', array(
        'label'       => __('Enable Clapping Feature', 'mediummate'),
        'description' => __('Show clap button on single posts (like Medium).', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'checkbox',
    ));

    // Enable/Disable Social Share
    $wp_customize->add_setting('single_share_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_share_enable', array(
        'label'       => __('Enable Social Share Buttons', 'mediummate'),
        'description' => __('Show share buttons in sidebar.', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'checkbox',
    ));

    // Enable/Disable Post Navigation
    $wp_customize->add_setting('single_post_navigation_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_post_navigation_enable', array(
        'label'       => __('Show Previous/Next Navigation', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'checkbox',
    ));

    // Enable/Disable Alert Bar
    $wp_customize->add_setting('single_alertbar_enable', array(
        'default'           => false,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('single_alertbar_enable', array(
        'label'       => __('Show Alert Bar (Newsletter)', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'checkbox',
    ));

    // Alert Bar Text
    $wp_customize->add_setting('single_alertbar_text', array(
        'default'           => 'Enjoy our content? Keep in touch for more',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('single_alertbar_text', array(
        'label'    => __('Alert Bar Text', 'mediummate'),
        'section'  => 'mediummate_single_section',
        'type'     => 'text',
    ));

    // Alert Bar Form Shortcode
    $wp_customize->add_setting('single_alertbar_form', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('single_alertbar_form', array(
        'label'       => __('Newsletter Form Shortcode', 'mediummate'),
        'description' => __('Paste your newsletter plugin shortcode (e.g., Mailchimp).', 'mediummate'),
        'section'     => 'mediummate_single_section',
        'type'        => 'text',
    ));

    // =========================================
    // AUTHOR PAGES PANEL
    // =========================================
    $wp_customize->add_panel('mediummate_author_panel', array(
        'title'       => __('Author Pages Settings', 'mediummate'),
        'description' => __('Customize author list and individual author pages.', 'mediummate'),
        'priority'    => 35,
    ));

    // =========================================
    // AUTHOR LIST PAGE SECTION
    // =========================================
    $wp_customize->add_section('mediummate_authors_list_section', array(
        'title'    => __('Authors List Page', 'mediummate'),
        'panel'    => 'mediummate_author_panel',
        'priority' => 10,
    ));

    // Authors List Title
    $wp_customize->add_setting('authors_list_title', array(
        'default'           => 'Our Authors',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('authors_list_title', array(
        'label'    => __('Authors Page Title', 'mediummate'),
        'section'  => 'mediummate_authors_list_section',
        'type'     => 'text',
    ));

    // Authors List Description
    $wp_customize->add_setting('authors_list_description', array(
        'default'           => 'Meet our talented team of writers and content creators.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('authors_list_description', array(
        'label'    => __('Authors Page Description', 'mediummate'),
        'section'  => 'mediummate_authors_list_section',
        'type'     => 'textarea',
    ));

    // Show Authors Bio Length
    $wp_customize->add_setting('authors_bio_length', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('authors_bio_length', array(
        'label'       => __('Bio Excerpt Length (words)', 'mediummate'),
        'section'     => 'mediummate_authors_list_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
        ),
    ));

    // =========================================
    // AUTHOR DETAIL PAGE SECTION
    // =========================================
    $wp_customize->add_section('mediummate_author_detail_section', array(
        'title'    => __('Author Detail Page', 'mediummate'),
        'panel'    => 'mediummate_author_panel',
        'priority' => 20,
    ));

    // =========================================
    // FOOTER SECTION
    // =========================================
    $wp_customize->add_section('mediummate_footer_section', array(
        'title'    => __('Footer Settings', 'mediummate'),
        'priority' => 40,
    ));

    // Enable/Disable Footer Menu
    $wp_customize->add_setting('footer_menu_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('footer_menu_enable', array(
        'label'       => __('Show Footer Menu', 'mediummate'),
        'description' => __('Display navigation menu in footer. Configure the menu in Appearance > Menus.', 'mediummate'),
        'section'     => 'mediummate_footer_section',
        'type'        => 'checkbox',
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '© 2023 MediumMate. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('footer_copyright', array(
        'label'    => __('Footer Copyright Text', 'mediummate'),
        'section'  => 'mediummate_footer_section',
        'type'     => 'textarea',
    ));

    // Enable/Disable Category Cloud
    $wp_customize->add_setting('category_cloud_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('category_cloud_enable', array(
        'label'    => __('Show Category Cloud in Footer', 'mediummate'),
        'section'  => 'mediummate_footer_section',
        'type'     => 'checkbox',
    ));

    // Category Cloud Title
    $wp_customize->add_setting('category_cloud_title', array(
        'default'           => 'Browse by Category',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('category_cloud_title', array(
        'label'    => __('Category Cloud Section Title', 'mediummate'),
        'section'  => 'mediummate_footer_section',
        'type'     => 'text',
    ));

    // Show Category Count
    $wp_customize->add_setting('category_cloud_show_count', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('category_cloud_show_count', array(
        'label'       => __('Show Post Count in Categories', 'mediummate'),
        'description' => __('Display the number of posts in each category.', 'mediummate'),
        'section'     => 'mediummate_footer_section',
        'type'        => 'checkbox',
    ));

    // Enable/Disable Back to Top Button
    $wp_customize->add_setting('back_to_top_enable', array(
        'default'           => true,
        'sanitize_callback' => 'mediummate_sanitize_checkbox',
    ));
    $wp_customize->add_control('back_to_top_enable', array(
        'label'       => __('Show Back to Top Button', 'mediummate'),
        'description' => __('Display a floating button to scroll back to top.', 'mediummate'),
        'section'     => 'mediummate_footer_section',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'mediummate_customize_register');

/**
 * Sanitize checkbox values
 */
function mediummate_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select values
 */
function mediummate_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Generate custom CSS from customizer settings
 */
function mediummate_customizer_css() {
    // Get color settings
    $primary_color = get_theme_mod('primary_color', '#03a87c');
    $nav_text_color = get_theme_mod('nav_text_color', '#888888');
    $nav_hover_color = get_theme_mod('nav_hover_color', '#03a87c');
    $heading_color = get_theme_mod('heading_color', '#000000');
    $heading_hover_color = get_theme_mod('heading_hover_color', '#03a87c');
    $body_text_color = get_theme_mod('body_text_color', '#333333');
    $header_bg_color = get_theme_mod('header_bg_color', '#ffffff');
    
    // Get typography settings
    $body_font = get_theme_mod('body_font_family', 'Rubik');
    $heading_font = get_theme_mod('heading_font_family', 'Rubik');
    $blog_content_font = get_theme_mod('blog_content_font_family', 'Merriweather');
    
    ?>
    <style type="text/css">
        /* Google Fonts */
        <?php if ($body_font !== 'Rubik' || $heading_font !== 'Rubik' || $blog_content_font !== 'Merriweather'): ?>
        @import url('https://fonts.googleapis.com/css2?family=<?php echo esc_attr(str_replace(' ', '+', $body_font)); ?>:wght@300;400;500;700&family=<?php echo esc_attr(str_replace(' ', '+', $heading_font)); ?>:wght@400;500;700;900&family=<?php echo esc_attr(str_replace(' ', '+', $blog_content_font)); ?>:wght@300;400;700&display=swap');
        <?php endif; ?>
        
        /* Body Text Color */
        body, p, .card-text, .post-content {
            color: <?php echo esc_attr($body_text_color); ?>;
            font-family: '<?php echo esc_attr($body_font); ?>';
        }
        
        /* Heading Colors */
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6,
        .card-title, .section-title h2, .post-title {
            color: <?php echo esc_attr($heading_color); ?>;
            font-family: '<?php echo esc_attr($heading_font); ?>';
        }
        
        /* Heading Hover Colors (for linked headings) */
        h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
        .card-title a:hover, .post-title a:hover {
            color: <?php echo esc_attr($heading_hover_color); ?>;
        }
        
        /* Blog Single Content Font */
        .single-post .article-post,
        .single-post .article-post p,
        .single-post .entry-content,
        .single-post .entry-content p {
            font-family: '<?php echo esc_attr($blog_content_font); ?>';
        }
        
        /* Navigation Colors */
        .navbar-nav .nav-link, .navbar-nav .nav-item .nav-link {
            color: <?php echo esc_attr($nav_text_color); ?> !important;
        }
        
        /* Navigation Hover & Active Colors */
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus,
        .navbar-nav .nav-item.active .nav-link,
        .navbar-nav .nav-link.active {
            color: <?php echo esc_attr($nav_hover_color); ?> !important;
        }
        
        /* Primary Color for Buttons and Links */
        .btn-primary, .badge-primary {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-color: <?php echo esc_attr($primary_color); ?>;
            opacity: 0.9;
        }
        
        /* Links in content */
        .post-content a, .card-text a, a.more-link {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .post-content a:hover, .card-text a:hover, a.more-link:hover {
            color: <?php echo esc_attr($primary_color); ?>;
            opacity: 0.8;
        }
        
        /* Follow Button and Social Icons */
        .btn.follow {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-color: <?php echo esc_attr($primary_color); ?>;
            color: #ffffff;
        }
        
        .btn.follow:hover {
            background-color: <?php echo esc_attr($primary_color); ?>;
            opacity: 0.9;
        }
        
        /* Header Background */
        .navbar-light, .mm-header-nav {
            background-color: <?php echo esc_attr($header_bg_color); ?>;
        }
        
        /* Meta Information Colors */
        .post-date, .readingtime, .author-meta {
            color: <?php echo esc_attr($nav_text_color); ?>;
        }
        
        .post-name a, .author-meta a {
            color: <?php echo esc_attr($heading_color); ?>;
        }
        
        .post-name a:hover, .author-meta a:hover {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        /* Category Links */
        .category-cloud .btn-outline-secondary {
            border-color: <?php echo esc_attr($primary_color); ?>;
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .category-cloud .btn-outline-secondary:hover {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-color: <?php echo esc_attr($primary_color); ?>;
            color: #ffffff;
        }
        
        .category-cloud .btn-outline-secondary .badge-secondary {
            background-color: <?php echo esc_attr($primary_color); ?>;
            color: #ffffff;
        }
        
        .category-cloud .btn-outline-secondary:hover .badge-secondary {
            background-color: #ffffff;
            color: <?php echo esc_attr($primary_color); ?>;
        }
        /* Pagination Colors */
        .pagination .page-link {
            color: <?php echo esc_attr($nav_text_color); ?>;
        }
        
        .pagination .page-link:hover,
        .pagination .active .page-link {
            background-color: <?php echo esc_attr($primary_color); ?>;
            border-color: <?php echo esc_attr($primary_color); ?>;
            color: #ffffff;
        }
        
        /* Social Links */
        .social-links li a:hover {
            background: <?php echo esc_attr($primary_color); ?>;
            color: #fff;
        }
        
        /* Author Pages Styling */
        .author-profile .author-name {
            color: <?php echo esc_attr($heading_color); ?>;
            margin: 20px 0 10px 0;
        }
        
        .author-description {
            color: <?php echo esc_attr($body_text_color); ?>;
            margin: 15px 0;
        }
        
        .author-meta {
            color: <?php echo esc_attr($nav_text_color); ?>;
            font-size: 14px;
        }
        
        .author-social-links {
            margin-top: 20px;
        }
        
        .author-social-links .social-link {
            display: inline-block;
            margin: 0 8px;
            width: 36px;
            height: 36px;
            text-align: center;
            line-height: 36px;
            background: #f8f9fa;
            border-radius: 50%;
            color: <?php echo esc_attr($nav_text_color); ?>;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .author-social-links .social-link:hover {
            background: <?php echo esc_attr($primary_color); ?>;
            color: #fff;
            transform: translateY(-2px);
        }
        
        /* Authors List Page */
        .author-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .author-card:hover {
            transform: translateY(-5px);
        }
        
        .author-card .author-img img {
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        
        .author-card:hover .author-img img {
            transform: scale(1.1);
        }
        
        .author-card .author-name a {
            color: <?php echo esc_attr($heading_color); ?>;
            text-decoration: none;
        }
        
        .author-card .author-name a:hover {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        .author-bio {
            color: <?php echo esc_attr($body_text_color); ?>;
            font-size: 14px;
        }
        
        /* Author Posts Layout */
        .author-posts-grid .row {
            margin: 0 -15px;
        }
        
        .author-posts-list .post {
            border-bottom: 1px solid #eee;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        
        .author-posts-list .post:last-child {
            border-bottom: none;
        }
        
        /* Single Post Related Posts */
        .related-posts-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }
        
        .related-posts-section .section-title h2 {
            color: <?php echo esc_attr($heading_color); ?>;
        }
        
        /* Footer Menu Styling */
        .footer-navigation {
            margin-bottom: 20px;
        }
        
        .footer-menu {
            text-align: center;
        }
        
        .footer-menu li {
            margin: 0 15px;
        }
        
        .footer-menu li a {
            color: <?php echo esc_attr($nav_text_color); ?>;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .footer-menu li a:hover {
            color: <?php echo esc_attr($primary_color); ?>;
        }
        
        @media (max-width: 768px) {
            .footer-menu li {
                margin: 5px 10px;
            }
            
            .footer-menu li a {
                font-size: 13px;
            }
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: <?php echo esc_attr($primary_color); ?>;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: none;
            z-index: 999;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .back-to-top:hover {
            background-color: <?php echo esc_attr($primary_color); ?>;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            color: #ffffff;
        }
        
        .back-to-top:focus {
            outline: 2px solid <?php echo esc_attr($primary_color); ?>;
            outline-offset: 2px;
        }
        
        @media (max-width: 768px) {
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 16px;
            }
        }
    </style>
    <?php
}
add_action('wp_head', 'mediummate_customizer_css');

/**
 * =========================================
 * CLAPPING FEATURE (Like Medium)
 * =========================================
 */

/**
 * Enqueue clapping feature scripts
 */
function mediummate_clapping_scripts() {
    if (is_singular('post') && get_theme_mod('single_clapping_enable', true)) {
        wp_enqueue_script(
            'mediummate-clapping',
            get_template_directory_uri() . '/assets/js/clapping.js',
            array('jquery'),
            MEDIUMMATE_VERSION,
            true
        );
        
        wp_localize_script('mediummate-clapping', 'mmClapping', array(
            'ajaxurl'  => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('mm_clap_nonce'),
            'post_id'  => get_the_ID(),
            'max_claps' => 50, // Maximum claps per user session
            'texts'    => array(
                'clap'     => __('Clap', 'mediummate'),
                'clapped'  => __('Clapped!', 'mediummate'),
                'already'  => __('Already applauded!', 'mediummate'),
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'mediummate_clapping_scripts');

/**
 * Handle AJAX clap request
 */
function mediummate_handle_clap() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mm_clap_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'mediummate')));
    }
    
    // Get post ID
    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    
    if (!$post_id || !get_post($post_id)) {
        wp_send_json_error(array('message' => __('Invalid post.', 'mediummate')));
    }
    
    // Get current claps count
    $current_claps = absint(get_post_meta($post_id, '_mm_claps_count', true));
    
    // Increment claps
    $new_claps = $current_claps + 1;
    update_post_meta($post_id, '_mm_claps_count', $new_claps);
    
    // Track user clap in session/cookie to prevent infinite clapping
    $user_clap_key = 'mm_clapped_' . $post_id;
    $user_claps = isset($_COOKIE[$user_clap_key]) ? absint($_COOKIE[$user_clap_key]) : 0;
    $user_claps++;
    
    // Send response
    wp_send_json_success(array(
        'claps'      => $new_claps,
        'user_claps' => $user_claps,
        'message'    => __('Thanks for the clap!', 'mediummate')
    ));
}
add_action('wp_ajax_mm_clap', 'mediummate_handle_clap');
add_action('wp_ajax_nopriv_mm_clap', 'mediummate_handle_clap');

/**
 * Get claps count for a post
 */
function mediummate_get_claps($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return absint(get_post_meta($post_id, '_mm_claps_count', true));
}

/**
 * Check if current user has already clapped on a post
 * Uses cookie to track - one clap per user per post
 */
function mm_user_has_clapped($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $cookie_name = 'mm_clapped_' . $post_id;
    return isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] === '1';
}

/**
 * =========================================
 * BLOCK STYLES AND PATTERNS
 * =========================================
 */

/**
 * Register custom block styles
 */
function mediummate_register_block_styles() {
    // Register a dark style for the code block
    register_block_style(
        'core/code',
        array(
            'name'  => 'mediummate-dark-code',
            'label' => __('Dark Code Box', 'mediummate'),
        )
    );

    // Register card style for group block
    register_block_style(
        'core/group',
        array(
            'name'  => 'mediummate-card',
            'label' => __('Card Style', 'mediummate'),
        )
    );
}
add_action('init', 'mediummate_register_block_styles');

/**
 * Register custom block patterns
 */
function mediummate_register_block_patterns() {
    register_block_pattern_category(
        'mediummate',
        array('label' => __('MediumMate', 'mediummate'))
    );

    register_block_pattern(
        'mediummate/code-box',
        array(
            'title'       => __('Code Box', 'mediummate'),
            'description' => __('A styled code box with title', 'mediummate'),
            'categories'  => array('mediummate'),
            'content'     => '<!-- wp:group {"className":"mm-code-box-wrapper"} -->
            <div class="wp-block-group mm-code-box-wrapper">
            <!-- wp:heading {"level":4} -->
            <h4 class="wp-block-heading">Code Example</h4>
            <!-- /wp:heading -->
            <!-- wp:code {"className":"is-style-mediummate-dark-code"} -->
            <pre class="wp-block-code is-style-mediummate-dark-code"><code>// Your code here</code></pre>
            <!-- /wp:code -->
            </div>
            <!-- /wp:group -->',
        )
    );
}
add_action('init', 'mediummate_register_block_patterns');

/**
 * =========================================
 * AUTHOR AVATAR CUSTOMIZER SETTINGS
 * =========================================
 */

/**
 * Get author avatar - checks customizer first, then fallback to gravatar
 */
function mediummate_get_author_avatar($user_id, $size = 96) {
    // Check if custom avatar is set in customizer
    $custom_avatar = get_theme_mod('author_avatar_' . $user_id, '');
    
    if (!empty($custom_avatar)) {
        return '<img src="' . esc_url($custom_avatar) . '" alt="' . esc_attr(get_the_author_meta('display_name', $user_id)) . '" class="avatar avatar-' . absint($size) . ' photo mm-custom-avatar" width="' . absint($size) . '" height="' . absint($size) . '" />';
    }
    
    // Fallback to WordPress default avatar
    return get_avatar($user_id, $size);
}

/**
 * Add author image settings to customizer
 */
function mediummate_author_avatar_customizer($wp_customize) {
    // Add section for author avatars
    $wp_customize->add_section('mediummate_author_avatars_section', array(
        'title'       => __('Author Avatars', 'mediummate'),
        'description' => __('Upload custom avatar images for each author. Leave empty to use Gravatar.', 'mediummate'),
        'panel'       => 'mediummate_author_panel',
        'priority'    => 30,
    ));
    
    // Get all users who can publish posts
    $authors = get_users(array(
        'capability' => 'edit_posts',
        'orderby'    => 'display_name',
        'order'      => 'ASC',
    ));
    
    foreach ($authors as $author) {
        // Add setting for this author's avatar
        $wp_customize->add_setting('author_avatar_' . $author->ID, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        // Add image control
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'author_avatar_' . $author->ID, array(
            'label'       => sprintf(__('Avatar for: %s', 'mediummate'), $author->display_name),
            'description' => sprintf(__('Current email: %s', 'mediummate'), $author->user_email),
            'section'     => 'mediummate_author_avatars_section',
        )));
    }
}
add_action('customize_register', 'mediummate_author_avatar_customizer', 20);

/**
 * Add custom social media fields to user profiles
 */
function mediummate_add_user_social_fields($user) {
    ?>
    <h3><?php _e('Social Media Links', 'mediummate'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="twitter"><?php _e('Twitter URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your Twitter profile URL.', 'mediummate'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="facebook"><?php _e('Facebook URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your Facebook profile URL.', 'mediummate'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="instagram"><?php _e('Instagram URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="instagram" id="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your Instagram profile URL.', 'mediummate'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="linkedin"><?php _e('LinkedIn URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your LinkedIn profile URL.', 'mediummate'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="youtube"><?php _e('YouTube URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="youtube" id="youtube" value="<?php echo esc_attr(get_the_author_meta('youtube', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your YouTube channel URL.', 'mediummate'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="github"><?php _e('GitHub URL', 'mediummate'); ?></label></th>
            <td>
                <input type="url" name="github" id="github" value="<?php echo esc_attr(get_the_author_meta('github', $user->ID)); ?>" class="regular-text" />
                <br><span class="description"><?php _e('Please enter your GitHub profile URL.', 'mediummate'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'mediummate_add_user_social_fields');
add_action('edit_user_profile', 'mediummate_add_user_social_fields');

/**
 * Save custom social media fields
 */
function mediummate_save_user_social_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    $social_fields = array('twitter', 'facebook', 'instagram', 'linkedin', 'youtube', 'github');
    
    foreach ($social_fields as $field) {
        if (isset($_POST[$field])) {
            update_user_meta($user_id, $field, esc_url_raw($_POST[$field]));
        }
    }
}
add_action('personal_options_update', 'mediummate_save_user_social_fields');
add_action('edit_user_profile_update', 'mediummate_save_user_social_fields');