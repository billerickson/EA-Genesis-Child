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
 * Clean Nav Menu Classes
 *
 */
function ea_clean_nav_menu_classes( $classes ) {

	if( ! is_array( $classes ) )
		return $classes;

	$allowed_classes = array(
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
	);

	return array_intersect( $classes, $allowed_classes );
}
add_filter( 'post_class', 'ea_clean_post_classes', 5 );
