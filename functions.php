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
	include_once( get_stylesheet_directory() . '/inc/genesis-cleanup.php' );

	// Editor Styles
	add_editor_style( 'css/editor-style.css' );

	// Theme Supports
	add_theme_support( 'html5' );
	add_theme_support( 'genesis-responsive-viewport' );
	add_theme_support( 'genesis-footer-widgets', 3 );
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

	// Set comment area defaults
	add_filter( 'comment_form_defaults', 'ea_comment_text' );

	// Global enqueues
	add_action( 'wp_enqueue_scripts', 'ea_global_enqueues' );

	// Don't update theme
	add_filter( 'http_request_args', 'ea_dont_update_theme', 5, 2 );

}
add_action( 'genesis_setup', 'ea_child_theme_setup', 15 );

// ** Backend Functions ** //

/**
 * Change the comment area text
 *
 * @since  1.0.0
 * @param  array $args
 * @return array
 */
function ea_comment_text( $args ) {
	$args['title_reply']          = __( 'Leave A Reply', 'ea_genesis_child' );
	$args['label_submit']         = __( 'Post Comment',  'ea_genesis_child' );
	$args['comment_notes_before'] = '';
	$args['comment_notes_after']  = '';
	return $args;
}

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function ea_global_enqueues() {
	global $wp_styles;

	// javascript
	wp_enqueue_script( 'ea-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery' ), CHILD_THEME_VERSION, false );

	// css
	// wp_enqueue_style( 'ea-ie', CHILD_URL . '/css/ie.css' );
	// $wp_styles->add_data( 'ea-ie', 'conditional', 'lt IE 9'  );
}

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
