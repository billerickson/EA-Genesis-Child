<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

/**
 * Set up the content width value based on the theme's design.
 *
 */
if ( ! isset( $content_width ) )
    $content_width = 740; 

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

	// Genesis Specific Changes
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );
	
	// Helper Functions
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );

	// Editor Styles
	add_editor_style( 'css/editor-style.css' );

	// Image Sizes
	// add_image_size( 'ea_featured', 400, 100, true );

	// Dont update theme
	add_filter( 'http_request_args', 'ea_dont_update_theme', 5, 2 );

	// Set comment area defaults
	add_filter( 'comment_form_defaults', 'ea_comment_text' );

	// Global enqueues
	add_action( 'wp_enqueue_scripts', 'ea_global_enqueues' );
	
	// Blog Template
	add_filter( 'template_include', 'ea_blog_template' );
 	
}
add_action( 'genesis_setup', 'ea_child_theme_setup', 15 );

// ** Backend Functions ** //

/**
 * Dont Update the Theme
 *
 * If there is a theme in the repo with the same name, this prevents WP from prompting an update.
 *
 * @since  1.0.0
 * @author Bill Erickson
 * @link   http://www.billerickson.net/excluding-theme-from-updates
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Amended request arguments
 */
function ea_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) )
 		return $r; // Not a theme update request. Bail immediately.
 	$themes = json_decode( $r['body']['themes'] );
 	$child = get_option( 'stylesheet' );
	unset( $themes->themes->$child );
 	$r['body']['themes'] = json_encode( $themes );
 	return $r;
 }
 
 
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

	// javascript
	wp_enqueue_script( 'fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_enqueue_script( 'ea-global', get_stylesheet_directory_uri() . '/js/global.js', array( 'jquery', 'fitvids' ), '1.0', true );

	// css
	// global $wp_styles;
	// wp_enqueue_style( 'ea-ie', CHILD_URL . '/css/ie.css' );
	// $wp_styles->add_data( 'ea-ie', 'conditional', 'lt IE 9'  );
}

// ** Frontend Functions ** //

/**
 * Blog Template
 *
 */
function ea_blog_template( $template ) {
	if( is_home() || is_search() )
		$template = get_query_template( 'archive' );
	return $template;
}