<?php
/**
 * Wide Layout
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Add wide layout
genesis_register_layout( 'wide-content', [ 'label' => __( 'Wide Content', 'grownandflown2020' ), ] );

// Remove sidebar for wide layout
add_action( 'genesis_meta', function() {
	$layout = genesis_site_layout();
	if( 'wide-content' === $layout ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	}
});

/**
 * Gutenberg layout style
 *
 */
function ea_gutenberg_layout_style() {
	wp_enqueue_script( 'ea-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'ea_gutenberg_layout_style' );

/**
 * Gutenberg layout class
 * @link https://www.billerickson.net/change-gutenberg-content-width-to-match-layout/
 *
 * @param string $classes
 * @return string
 */
function ea_gutenberg_layout_class( $classes ) {
	$screen = get_current_screen();
	if( ! $screen->is_block_editor() )
		return $classes;

	$layout = false;
	$post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : false;

	// Get post-specific layout
	if( $post_id )
		$layout = genesis_get_custom_field( '_genesis_layout', $post_id );

	// If no post-specific layout, use site-wide default
	elseif( empty( $layout ) )
		$layout = genesis_get_option( 'site_layout' );

	$classes .= ' ' . $layout . ' ';
	return $classes;
}
add_filter( 'admin_body_class', 'ea_gutenberg_layout_class' );
