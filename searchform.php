<?php
/**
 * Template for displaying search forms
 *
 * @package MediumMate
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'mediummate' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'mediummate' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'mediummate' ); ?>">
        <i class="fa fa-search"></i>
    </button>
</form>
