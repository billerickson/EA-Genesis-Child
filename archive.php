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
 * Blog Archive Body Class
 *
 */
function ea_blog_archive_body_class( $classes ) {
	$classes[] = 'blog-archive';
	return $classes;
}
add_filter( 'body_class', 'ea_blog_archive_body_class' );

genesis();