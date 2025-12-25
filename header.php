<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mediummate
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header class="navbar-light bg-white <?php echo esc_attr( get_theme_mod('header_sticky_enable', true) ? 'fixed-top' : '' ); ?> mm-header-nav nav-down site-header">
        <div class="container">
            <!-- Begin Logo -->
            <div class="row justify-content-center align-items-center brandrow">
                <div class="col-lg-4 col-md-4 col-xs-12 hidden-xs-down customarea">
                    <?php if (get_theme_mod('header_social_enable', true)) : ?>
                        <?php 
                        // Twitter Follow Button
                        if (get_theme_mod('header_twitter_follow_enable', true) && get_theme_mod('social_twitter_url')) : 
                        ?>
                            <a class="btn follow" href="<?php echo esc_url(get_theme_mod('social_twitter_url')); ?>" target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i> <?php echo esc_html(get_theme_mod('header_twitter_follow_text', 'Follow')); ?>
                            </a>
                        <?php endif; ?>

                        <?php
                        // Display other social icons
                        $social_networks = array(
                            'youtube'   => 'fab fa-youtube',
                            'facebook'  => 'fab fa-facebook',
                            'instagram' => 'fab fa-instagram',
                            'linkedin'  => 'fab fa-linkedin',
                            'github'    => 'fab fa-github'
                        );

                        foreach ($social_networks as $network => $icon) :
                            $url = get_theme_mod('social_' . $network . '_url');
                            if ($url) :
                        ?>
                                <a target="_blank" href="<?php echo esc_url($url); ?>" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($network)); ?>">
                                    <i class="<?php echo esc_attr($icon); ?> social"></i>
                                </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12 text-center logoarea">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-branding">
                            <?php the_custom_logo(); ?>
                            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php echo esc_html(get_bloginfo('name')); ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php echo esc_html(get_bloginfo('name')); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-md-4 mr-auto col-xs-12 text-right searcharea">
                    <?php if (get_theme_mod('header_search_enable', true)) : ?>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Logo -->

            <div class="navarea">
                <nav class="navbar navbar-toggleable-sm">
                    <button 
                        class="navbar-toggler collapsed navbar-toggler-right" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#bs4navbar" 
                        aria-controls="bs4navbar" 
                        aria-expanded="false" 
                        aria-label="<?php esc_attr_e('Toggle navigation', 'mediummate'); ?>"
                    >
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-close-icon">X</span>
                    </button>
                    <div id="bs4navbar" class="collapse navbar-collapse">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'menu-top-menu', 
                            'menu_class'     => 'navbar-nav col-md-12 justify-content-center',
                            'container'      => false,
                            'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'walker'         => new WP_Bootstrap_Navwalker(),
                        ));
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div id="content" class="site-content"> 