<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mediummate
 */

get_header();
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            while (have_posts()) :
                the_post();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-image">
                            <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'mediummate'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer();