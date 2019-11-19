<?php
/**
 * Archive
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full Width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 * Blog Archive Body Class
 *
 */
function ea_blog_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'ea_blog_archive_body_class' );

// Move breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_archive_title_descriptions', 'genesis_do_breadcrumbs', 8 );

// Remove description on paginated archives
if( get_query_var( 'paged' ) ) {
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_intro_text', 12, 3 );
}

genesis();
