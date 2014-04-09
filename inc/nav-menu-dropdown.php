<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

if( !class_exists( 'Walker_Nav_Menu_Dropdown' ) ) { 

	class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu {
		function start_lvl( &$output, $depth ){
			$indent = str_repeat( "\t", $depth ); // don't output children opening tag (`<ul>`)
		}
	
		function end_lvl( &$output, $depth ){
			$indent = str_repeat( "\t", $depth ); // don't output children closing tag
		}
	
		/**
		* Start the element output.
		*
		* @param  string $output Passed by reference. Used to append additional content.
		* @param  object $item   Menu item data object.
		* @param  int $depth     Depth of menu item. May be used for padding.
		* @param  array $args    Additional strings.
		* @return void
		*/
		function start_el( &$output, $item, $depth, $args ) {
	 		$url = '#' !== $item->url ? $item->url : '';
			$selected = isset( $item->classes ) && is_array( $item->classes ) ? selected( in_array( 'current-menu-item', $item->classes ), true, false ) : '';
			$output .= '<option value="' . $url . '" ' . $selected . '>' . $item->title; 		
		}	
	
		function end_el (&$output, $item, $depth ){
			$output .= "</option>\n"; // replace closing </li> with the option tag
		}
	}

}


/**
 * Example of Usage
 *
 */
function be_sample_mobile_menu() {
	if( !class_exists( 'Walker_Nav_Menu_Dropdown' ) )
		return;
		
	wp_nav_menu( array(
		'theme_location' => 'mobile',
		'depth'          => 1,
		'walker'         => new Walker_Nav_Menu_Dropdown(),
		'items_wrap'     => '<div class="mobile-menu"><form><select onchange="if (this.value) window.location.href=this.value"><option value="">Go To&hellip;</option>%3$s</select></form></div>',
	) );	
}
//add_action( 'genesis_before_header', 'be_sample_mobile_menu' ); 
