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
 * Shortcut function for get_post_meta();
 *
 * @since 1.2.0
 * @param string $key
 * @param int $id
 * @param boolean $echo
 * @param string $prepend
 * @param string $append
 * @param string $escape
 * @return string
 */
function ea_cf( $key = '', $id = '', $echo = false, $prepend = false, $append = false, $escape = false ) {
	$id    = ( empty( $id ) ? get_the_ID() : $id );
	$value = get_post_meta( $id, $key, true );
	if( $escape )
		$value = call_user_func( $escape, $value );
	if( $value && $prepend )
		$value = $prepend . $value;
	if( $value && $append )
		$value .= $append;
		
	if ( $echo ) {
		echo $value;
	} else {
		return $value;
	}
}

/**
 * Get the first term attached to post
 *
 * @param string $taxonomy
 * @param string/int $field, pass false to return object
 * @param int $post_id
 * @return string/object
 */
function ea_first_term( $taxonomy = 'category', $field = 'name', $post_id = false ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$terms = get_the_terms( $post_id, $taxonomy );
	if( empty( $terms ) || is_wp_error( $terms ) )
		return false;
	
	// Sort by post count
	$list = array();	
	foreach( $terms as $term )
		$list[$term->count] = $term;
	ksort( $list, SORT_NUMERIC );
	
	// Grab first in array
	$list = array_reverse( $list );
	$term = array_shift( $list );
		
	if( $field && isset( $term->$field ) )
		return $term->$field;
	
	else
		return $term;
}

/**
 * Conditional CSS Classes
 *
 * @param string $base_classes, classes applied always applied
 * @param string $optional_class, additional class applied if $conditional is true
 * @param bool $conditional, whether to add $optional_class or not
 * @return string $classes
 */
function ea_class( $base_classes, $optional_class, $conditional ) {
	return $conditional ? $base_classes . ' ' . $optional_class : $base_classes;
}

/**
 * Column Classes
 *
 * @param int $type, number from 2-6
 * @param int $count, current count in the loop
 */
function ea_column_class( $type, $count ) {
	$classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
	if( isset( $classes[$type] ) )
		return ea_class( $classes[$type], 'first', 0 == $count % $type );
}