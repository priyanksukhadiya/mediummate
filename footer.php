<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mediummate
 */
?>

    </div><!-- #content -->

    <!-- Category Cloud Section -->
    <?php if (get_theme_mod('category_cloud_enable', true)) : ?>
        <section class="category-cloud bg-light py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="mb-4"><?php echo esc_html(get_theme_mod('category_cloud_title', 'Browse by Category')); ?></h3>
                        <?php
                        $show_count = get_theme_mod('category_cloud_show_count', true);
                        $categories = get_categories(array('hide_empty' => 1));
                        if ($categories) {
                            echo '<div class="category-tags">';
                            foreach ($categories as $category) {
                                if ($show_count) {
                                    printf(
                                        '<a href="%s" class="btn btn-outline-secondary btn-sm mr-2 mb-2">%s <span class="badge badge-secondary">%d</span></a>',
                                        esc_url(get_category_link($category->term_id)),
                                        esc_html($category->name),
                                        absint($category->count)
                                    );
                                } else {
                                    printf(
                                        '<a href="%s" class="btn btn-outline-secondary btn-sm mr-2 mb-2">%s</a>',
                                        esc_url(get_category_link($category->term_id)),
                                        esc_html($category->name)
                                    );
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <footer class="footer">
        <div class="container">
            <?php if (mediummate_get_social_links()) : ?>
                <div class="row justify-content-center mb-4">
                    <div class="col-auto">
                        <h4 class="text-center mb-3"><?php esc_html_e('Follow Us', 'mediummate'); ?></h4>
                        <?php mediummate_social_links_display(); ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Footer Menu -->
            <?php if (get_theme_mod('footer_menu_enable', true) && has_nav_menu('footer')) : ?>
                <div class="row justify-content-center mb-4 footer-nav-row">
                    <div class="col-auto">
                        <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Menu', 'mediummate'); ?>">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'menu_class'     => 'footer-menu list-inline mb-0',
                                'container'      => false,
                                'depth'          => 1,
                                'link_before'    => '<span class="menu-link-text">',
                                'link_after'     => '</span>',
                                'fallback_cb'    => false,
                                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'walker'         => new Footer_Nav_Walker(),
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6 col-sm-12 text-center text-lg-left">
                    <p class="footer-copyright"><?php 
                        echo wp_kses_post(get_theme_mod('footer_copyright', '© ' . date('Y') . ' MediumMate. All rights reserved.'));
                    ?></p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-lg-right">
                    <p><?php
                        /* translators: %1$s: Theme name, %2$s: Theme author website */
                        printf(
                            esc_html__('Theme: %1$s by %2$s', 'mediummate'),
                            'MediumMate',
                            '<a href="' . esc_url('https://profiles.wordpress.org/priyanksukhadiya/') . '">Priyank Sukhadiya</a>'
                        );
                    ?></p>
                </div>
            </div>
            
            <!-- Back to Top Button -->
            <?php if (get_theme_mod('back_to_top_enable', true)) : ?>
                <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'mediummate'); ?>" title="<?php esc_attr_e('Back to top', 'mediummate'); ?>">
                    <i class="fa fa-angle-up" aria-hidden="true"></i>
                </button>
            <?php endif; ?>
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>