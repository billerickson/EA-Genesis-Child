<?php
/**
 * EA Starter
 *
 * @package      EAStarter
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

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
 add_filter( 'http_request_args', 'ea_dont_update_theme', 5, 2 );

/**
 * Dequeue jQuery Migrate
 *
 */
function ea_dequeue_jquery_migrate( &$scripts ){
	if( !is_admin() ) {
		$scripts->remove( 'jquery');
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'ea_dequeue_jquery_migrate' );

/**
 * Clean Nav Menu Classes
 *
 */
function ea_clean_nav_menu_classes( $classes ) {

	if( ! is_array( $classes ) )
		return $classes;

	$allowed_classes = array(
		'home',
		'menu-item',
		'current-menu-item',
		'current-menu-ancestor',
		'menu-item-has-children',
	);

	return array_intersect( $classes, $allowed_classes );
}
add_filter( 'nav_menu_css_class', 'ea_clean_nav_menu_classes', 5 );

/**
 * Clean Post Classes
 *
 */
function ea_clean_post_classes( $classes ) {

	if( ! is_array( $classes ) )
		return $classes;

    $allowed_classes = array(
  		'hentry',
  		'type-' . get_post_type(),
      'one-half',
      'one-third',
      'two-thirds',
      'one-fourth',
      'two-fourths',
      'three-fourths',
      'one-fifth',
      'two-fifths',
      'three-fifths',
      'four-fifths',
   	);

	return array_intersect( $classes, $allowed_classes );
}
add_filter( 'post_class', 'ea_clean_post_classes', 5 );

/**
 * Excerpt More
 *
 */
function ea_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'ea_excerpt_more' );
