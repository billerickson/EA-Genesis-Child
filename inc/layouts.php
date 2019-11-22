<?php
/**
 * Layouts
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Unregister genesis layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content' );
//genesis_unregister_layout( 'content-sidebar' );

// Add new layouts
genesis_register_layout( 'content', [ 'label' => __( 'Content', 'ea_genesis_child' ), ] );

// Remove layout metabox
//remove_theme_support( 'genesis-inpost-layouts' );
remove_theme_support( 'genesis-archive-layouts' );

// Don't load default data into empty sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_sidebar', function() { dynamic_sidebar( 'sidebar' ); } );

// Add New Sidebars
// genesis_register_widget_area( array( 'id' => 'blog-sidebar', 'name' => 'Blog Sidebar' ) );


// Remove sidebar for content layout
add_action( 'genesis_meta', function() {
	$layout = genesis_site_layout();
	if( 'content' === $layout ) {
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
	}
});

/**
 * Editor layout style
 *
 */
function ea_editor_layout_style() {
	wp_enqueue_style( 'ea-editor-layout', get_stylesheet_directory_uri() . '/assets/css/editor-layout.css', [], filemtime( get_stylesheet_directory() . '/assets/css/editor-layout.css' ) );
}
add_action( 'enqueue_block_editor_assets', 'ea_editor_layout_style' );

/**
 * Editor layout class
 * @link https://www.billerickson.net/change-gutenberg-content-width-to-match-layout/
 *
 * @param string $classes
 * @return string
 */
function ea_editor_layout_class( $classes ) {
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
add_filter( 'admin_body_class', 'ea_editor_layout_class' );
