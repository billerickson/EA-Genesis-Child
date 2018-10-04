<?php
/**
 * Navigation
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Primary Nav in Header
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

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
