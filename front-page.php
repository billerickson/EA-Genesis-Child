<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove post title area
remove_action( 'genesis_entry_header', 'genesis_do_post_title'                 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open',  5  );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

/**
 * Use h1 for site title
 *
 */
function ea_front_page_h1( $title, $inside, $wrap ){
	$wrap = 'h1';
	$title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
	$title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';
	return $title;
}
add_filter( 'genesis_seo_title', 'ea_front_page_h1', 10, 3 );

genesis();
