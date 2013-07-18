<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2013, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

/**
 * Theme setup.
 * 
 * Attach all of the site-wide functions to the correct hooks and filters. All 
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function ea_child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Remove Unused Genesis Features
	include_once( get_stylesheet_directory() . '/inc/functions/genesis-cleanup.php' );

	// Editor Styles
	add_editor_style( 'css/editor-style.css' );

	// Theme Supports
	add_theme_support( 'genesis-html5'                 );
	add_theme_support( 'genesis-responsive-viewport'   );
	add_theme_support( 'genesis-footer-widgets',     3 );
	add_theme_support( 'genesis-structural-wraps', array( 'header', 'menu-primary', 'menu-secondary', 'site-inner', 'footer-widgets', 'footer' ) );
	// add_theme_support(
	// 	'genesis-menus',
	// 	array(
	// 		'primary'   => __( 'Primary Navigation Menu', 'ea_genesis_child' ),
	// 		'secondary' => __( 'Secondary Navigation Menu', 'ea_genesis_child' ),
	// 	)
	// );

	// Image Sizes
	// add_image_size( 'ea_featured', 400, 100, true );

	// Sidebars
	// genesis_register_sidebar(
	// 	array(
	// 		'id'          => 'blog-sidebar',
	// 		'name'        => __( 'Blog Sidebar', 'ea_genesis_child' ),
	// 		'description' => __( '', 'ea_genesis_child' ),
	// 	)
	// );

	// Don't update theme
	add_filter( 'http_request_args', 'ea_dont_update_theme', 5, 2 );

}
add_action( 'genesis_setup', 'ea_child_theme_setup', 15 );

// ** Backend Functions ** //

/**
 * Don't Update Theme.
 *
 * If there is a theme in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @author Mark Jaquith
 * @link   http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
function ea_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

// ** Frontend Functions ** //
