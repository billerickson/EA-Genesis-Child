<?php
/**
 * Genesis Changes
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Theme Supports
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'header', 'menu-secondary', 'site-inner', 'footer-widgets', 'footer' ) );
add_theme_support( 'genesis-menus', array( 'primary' => 'Primary Navigation Menu', 'secondary' => 'Secondary Navigation Menu' ) );
add_theme_support( 'genesis-footer-widgets', 3 );

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
	//	'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
		'screen-reader-text',
	)
);

// h1 on home
add_filter( 'genesis_site_title_wrap', function( $wrap ) { return is_front_page() ? 'h1' : $wrap; } );

// Remove admin bar styling
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

// Don't enqueue child theme stylesheet
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove Genesis Favicon (use site icon instead)
remove_action( 'wp_head', 'genesis_load_favicon' );

// Remove Header Description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Remove post info and meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove unused sidebars
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );

/**
 * Remove Genesis Templates
 *
 */
function ea_remove_genesis_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'ea_remove_genesis_templates' );

/**
 * Custom search form
 *
 */
function ea_search_form() {
	ob_start();
	get_template_part( 'searchform' );
	return ob_get_clean();
}
add_filter( 'genesis_search_form', 'ea_search_form' );

/**
 * Disable customizer theme settings
 *
 */
function ea_disable_customizer_theme_settings( $config ) {
	$remove = [ 'genesis_header', 'genesis_single', 'genesis_archives', 'genesis_footer' ];
	foreach( $remove as $item ) {
		unset( $config['genesis']['sections'][ $item ] );
	}
	return $config;
}
add_filter( 'genesis_customizer_theme_settings_config', 'ea_disable_customizer_theme_settings' );
