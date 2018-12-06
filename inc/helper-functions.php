<?php
/**
 * Helper Functions
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Duplicate 'the_content' filters
global $wp_embed;
add_filter( 'ea_the_content', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'ea_the_content', array( $wp_embed, 'autoembed'     ), 8 );
add_filter( 'ea_the_content', 'wptexturize'        );
add_filter( 'ea_the_content', 'convert_chars'      );
add_filter( 'ea_the_content', 'wpautop'            );
add_filter( 'ea_the_content', 'shortcode_unautop'  );
add_filter( 'ea_the_content', 'do_shortcode'       );

/**
 * Get the first term attached to post
 *
 * @param string $taxonomy
 * @param string/int $field, pass false to return object
 * @param int $post_id
 * @return string/object
 */
function ea_first_term( $taxonomy = 'category', $field = false, $post_id = false ) {

	$post_id = $post_id ? $post_id : get_the_ID();
	$term = false;

	// Use WP SEO Primary Term
	// from https://github.com/Yoast/wordpress-seo/issues/4038
	if( class_exists( 'WPSEO_Primary_Term' ) ) {
		$term = get_term( ( new WPSEO_Primary_Term( $taxonomy,  $post_id ) )->get_primary_term(), $taxonomy );
	}

	// Fallback on term with highest post count
	if( ! $term || is_wp_error( $term ) ) {

		$terms = get_the_terms( $post_id, $taxonomy );

		if( empty( $terms ) || is_wp_error( $terms ) )
			return false;

		// If there's only one term, use that
		if( 1 == count( $terms ) ) {
			$term = array_shift( $terms );

		// If there's more than one...
		} else {

			// Sort by term order if available
			// @uses WP Term Order plugin
			if( isset( $terms[0]->order ) ) {
				$list = array();
				foreach( $terms as $term )
					$list[$term->order] = $term;
				ksort( $list, SORT_NUMERIC );

			// Or sort by post count
			} else {
				$list = array();
				foreach( $terms as $term )
					$list[$term->count] = $term;
				ksort( $list, SORT_NUMERIC );
				$list = array_reverse( $list );
			}

			$term = array_shift( $list );
		}
	}

	// Output
	if( $field && isset( $term->$field ) )
		return $term->$field;

	else
		return $term;
}

/**
 * Conditional CSS Classes
 *
 * @param string $base_classes, classes always applied
 * @param string $optional_class, additional class applied if $conditional is true
 * @param bool $conditional, whether to add $optional_class or not
 * @return string $classes
 */
function ea_class( $base_classes, $optional_class, $conditional ) {
	return $conditional ? $base_classes . ' ' . $optional_class : $base_classes;
}

/**
 *  Background Image Style
 *
 * @param int $image_id
 * @return string $output
 */
function ea_bg_image_style( $image_id = false, $image_size = 'full' ) {
	if( !empty( $image_id ) )
		return ' style="background-image: url(' . wp_get_attachment_image_url( $image_id, $image_size ) . ');"';
}

/**
 * Get Icon
 *
 */
function ea_icon( $slug = '', $directory = '' ) {
	$directory = !empty( $directory ) ? esc_attr( $directory ) : 'utility';
	$path = get_stylesheet_directory() . '/assets/icons/' . $directory . '/';
	if( 'images' == $directory )
		$path = get_stylesheet_directory() . '/assets/images/';

	$icon_path =  $path . $slug . '.svg';
	if( file_exists( $icon_path ) )
		return file_get_contents( $icon_path );
}

/**
 * Theme Icons
 *
 */
function ea_get_theme_icons( $directory = 'category' ) {
	$icons = get_option( 'ea_theme_icons_' . $directory );
	$version = get_option( 'ea_theme_icons_' . $directory . '_version' );
	if( empty( $icons ) || ( defined( 'WP_LOCAL_DEV' ) && WP_LOCAL_DEV ) || ( defined( 'CHILD_THEME_VERSION' ) && version_compare( CHILD_THEME_VERSION, $version ) ) ) {
		$icons = scandir( get_stylesheet_directory() . '/assets/icons/' . $directory );
		$icons = array_diff( $icons, array( '..', '.' ) );
		$icons = array_values( $icons );
		if( empty( $icons ) )
			return $icons;
		// remove the .svg
		foreach( $icons as $i => $icon ) {
			$icons[ $i ] = substr( $icon, 0, -4 );
		}
		update_option( 'ea_theme_icons_' . $directory, $icons );
		if( defined( 'CHILD_THEME_VERSION' ) )
			update_option( 'ea_theme_icons_' . $directory . '_version', CHILD_THEME_VERSION );
	}
	return $icons;
}
