<?php
/**
 * Functions
 *
 * @package      BE_Genesis_Child
 * @since        1.0.0
 * @link         https://github.com/billerickson/BE-Genesis-Child
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

/**
 * Theme Setup
 * @since 1.0.0
 *
 * This setup function attaches all of the site-wide functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 */

add_action('genesis_setup','child_theme_setup', 15);
function child_theme_setup() {
	
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );
	
	// Remove Unused Genesis Features
	include_once( get_stylesheet_directory() . '/inc/functions/genesis-cleanup.php' );
	
	// Editor Styles
	add_editor_style( 'inc/css/editor-style.css' );
	
	// Theme Supports
	add_theme_support( 'genesis-html5' );
	add_theme_support( 'genesis-responsive-viewport' );
	add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );
	add_theme_support( 'genesis-menus', array( 
		'primary' => 'Primary Navigation Menu',
		'mobile' => 'Mobile Menu' 
	) );
	//add_theme_support( 'genesis-footer-widgets', 4 );

	// Image Sizes
	// add_image_size( 'be_featured', 400, 100, true );

	// Sidebars
	//genesis_register_sidebar( array( 'name' => 'Blog Sidebar', 'id' => 'blog-sidebar' ) );
		
	// Don't update theme
	add_filter( 'http_request_args', 'be_dont_update_theme', 5, 2 );
		
	// ** Frontend **		
	
	// Remove Edit link
	add_filter( 'genesis_edit_post_link', '__return_false' );
	
}

// ** Backend Functions ** //



/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name, 
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */

function be_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

// ** Frontend Functions ** //
