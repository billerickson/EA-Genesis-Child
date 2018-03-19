<?php
/**
 * Functions
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/*
BEFORE MODIFYING THIS THEME:
Please read the instructions here (private repo): https://github.com/billerickson/EA-Starter/wiki
Devs, contact me if you need access
*/

/**
 * Set up the content width value based on the theme's design.
 *
 */
if ( ! isset( $content_width ) )
    $content_width = 1024;

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

	// Includes
	include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );
    include_once( get_stylesheet_directory() . '/inc/tinymce.php' );
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );
	include_once( get_stylesheet_directory() . '/inc/navigation.php' );

	// Editor Styles
	add_editor_style( 'assets/css/editor-style.css' );

	// Image Sizes
	add_theme_support( 'align-wide' );
	// add_image_size( 'ea_featured', 400, 100, true );


}
add_action( 'genesis_setup', 'ea_child_theme_setup', 15 );

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
add_filter( 'comment_form_defaults', 'ea_comment_text' );

/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function ea_global_enqueues() {

	// javascript
	wp_enqueue_script( 'ea-global', get_stylesheet_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/global-min.js' ), true );

	// css
    wp_dequeue_style( 'child-theme' );
	wp_enqueue_style( 'ea-fonts', ea_theme_fonts_url() );
    wp_enqueue_style( 'ea-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), CHILD_THEME_VERSION );

	// Move jQuery to footer
	if( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'ea_global_enqueues' );

/**
 * Gutenberg scripts and styles
 *
 */
function ea_gutenberg_scripts() {
	wp_enqueue_style( 'ea-fonts', ea_theme_fonts_url() );
	wp_enqueue_style( 'ea', get_stylesheet_directory_uri() . '/assets/css/gutenberg.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/gutenberg.css' ) );
}
add_action( 'enqueue_block_editor_assets', 'ea_gutenberg_scripts' );


/**
 * Theme Fonts URL
 *
 */
function ea_theme_fonts_url() {
	$font_families = apply_filters( 'ea_theme_fonts', array( 'Source+Sans+Pro:400,400i,700,700i' ) );
	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);
	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	return esc_url_raw( $fonts_url );
}

/**
 * Blog Template
 *
 */
function ea_blog_template( $template ) {
	if( is_home() || is_search() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'ea_blog_template' );
