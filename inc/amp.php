<?php
/**
 * AMP functionality
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Is AMP?
 * Conditional tag
 */
function ea_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * AMP Class
 *
 */
function ea_amp_class( $default, $active, $variable ) {
	$output = '';
	if( ea_is_amp() ) {
		$output .= ' [class]="' . $variable . ' ? \'' . $default . ' ' . $active . '\' : \'' . $default . '\'"';
	}
	$output .= ' class="' . $default . '"';
	return $output;
}

/**
 * AMP Toggle
 *
 */
function ea_amp_toggle( $variable ) {
	return ea_is_amp() ? ' on="tap:AMP.setState({' . $variable . ': !' . $variable . '})"' : '';
}

/**
 * AMP Nav Dropdown
 *
 */
function ea_amp_nav_dropdown( $theme_location = false, $depth = 0 ) {

	$key = 'nav';
	if( !empty( $theme_location ) )
		$key .= ucwords( $theme_location );

	global $submenu_index;
	$submenu_index++;
	$key .= 'SubmenuExpanded' . $submenu_index;

	if( 1 < $depth )
		$key .= 'Depth' . $depth;

	return ea_amp_toggle( $key ) . ea_amp_class( 'submenu-expand', 'expanded', $key );
}

/**
 * AMP class on Genesis Nav Menu
 *
 */
function ea_amp_nav_primary_attr( $attr ) {
	if( ea_is_amp() )
		$attr['[class]'] = "mobileMenuActive ? 'nav-primary active' : 'nav-primary'";
	return $attr;
}
add_filter( 'genesis_attr_nav-primary', 'ea_amp_nav_primary_attr', 20 );
