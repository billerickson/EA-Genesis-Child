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
 * Mobile Menu Toggle
 *
 */
function ea_mobile_menu_toggle() {

	if( ! has_nav_menu( 'mobile' ) )
		return;
		
    echo '<div class="nav-mobile">';
	echo '<a class="mobile-menu-toggle" href="#">' . ea_icon( 'menu' ) . '</a>';
	echo '</div>';
}
add_action( 'genesis_header', 'ea_mobile_menu_toggle', 12 );

/**
 * Mobile Menu
 *
 */
function ea_mobile_menu() {
  if( has_nav_menu( 'mobile' ) ) {
    echo '<div id="sidr-mobile-menu" class="sidr right">';
      echo '<a class="sidr-menu-close" href="#">' . ea_icon( 'close' ) . '</a>';
      wp_nav_menu( array( 'theme_location' => 'mobile' ) );
    echo '</div>';
  }
}
add_action( 'wp_footer', 'ea_mobile_menu' );

/**
 * Archive Navigation
 *
 */
function ea_archive_navigation() {

	if( ! is_singular() )
		the_posts_navigation();

}
add_action( 'tha_content_while_after', 'ea_archive_navigation' );

/**
 * (disabled) Archive Paginated Navigation
 *
 */
function ea_archive_paginated_navigation() {

	if( is_singular() )
		return;

    global $wp_query;
    $big = 999999999; // need an unlikely integer

	$navigation = paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
		'prev_text' => ea_icon( 'angle-left' ),
		'next_text' => ea_icon( 'angle-right' ),
	) );

	if( $navigation ) {
    	echo '<nav class="navigation posts-navigation" role="navigation">';
        	echo '<h2 class="screen-reader-text">Posts navigation</h2>';
        	echo '<div class="nav-links">' . $navigation . '</div>';
		echo '</nav>';
	}

}
//add_action( 'tha_content_while_after', 'ea_archive_navigation' );
