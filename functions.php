<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

/*
BEFORE MODIFYING THIS THEME:
Please read the instructions here: https://github.com/billerickson/EA-Genesis-Child/blob/master/README.md
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

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

	// WordPress Cleanup
	include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );

	// Genesis Specific Changes
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );

	// Helper Functions
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );

	// Editor Styles
	add_editor_style( 'assets/css/editor-style.css' );

	// Image Sizes
	// add_image_size( 'ea_featured', 400, 100, true );

	// Dont update theme
	add_filter( 'http_request_args', 'ea_dont_update_theme', 5, 2 );

	// Set comment area defaults
	add_filter( 'comment_form_defaults', 'ea_comment_text' );

	// Global enqueues
	add_action( 'wp_enqueue_scripts', 'ea_global_enqueues' );

	// Extra TinyMCE Styles
	add_filter( 'mce_buttons_2', 'ea_mce_editor_buttons' );
	add_filter( 'tiny_mce_before_init', 'ea_mce_before_init' );

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
	wp_enqueue_script( 'ea-global', get_stylesheet_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), '1.0', true );

	// css
    wp_enqueue_style( 'ea-style', get_stylesheet_directory_uri() . '/assets/css/main.css' );
    wp_dequeue_style( 'child-theme' );
}

/**
 * Add "Styles" drop-down to TinyMCE
 *
 * @since 1.0.0
 * @param array $buttons
 * @return array
 */
function ea_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/**
 * Add styles/classes to the TinyMCE "Formats" drop-down
 *
 * @since 1.0.0
 * @param array $settings
 * @return array
 */
function ea_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title'    => 'Button',
			'selector' => 'a',
			'classes'  => 'button',
		),
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
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

/**
 * Mobile Menu Toggle
 *
 */
function ea_mobile_menu_toggle() {
	echo '<a class="mobile-menu-toggle" href="#"><i class="icon-menu"></i><i class="icon-close"></i></a>';
}
add_action( 'genesis_header', 'ea_mobile_menu_toggle', 12 );
