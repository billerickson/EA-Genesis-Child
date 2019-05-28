<?php
/**
 * Instant Page
 * @see https://instant.page
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Add the Instant Page script to the footer.
 */
function be_enqueue_instant_page() {

	// Don't load script if AMP
	if( function_exists( 'ea_is_amp' ) && ea_is_amp() )
		return;

	wp_enqueue_script( 'instantpage', get_stylesheet_directory_uri() . '/assets/js/instantpage.min.js', null, '1.2.2', true );
}
add_action( 'wp_enqueue_scripts', 'be_enqueue_instant_page' );


/**
 * Change the script type from text/javascript to module.
 *
 * The instant page script requires the type to be module but WordPress does not
 * allow an elegant way to do this. So we have to resort to checking every
 * script and only changing the ones we need.
 *
 * @param [string] $tag The script tag to check.
 * @param [string] $handle The script handle.
 * @param [string] $src The script source.
 * @return void
 */
function be_instant_page_script_type( $tag, $handle, $src ) {

	if ( 'instantpage' === $handle ) {
		$tag = str_replace( 'text/javascript', 'module', $tag );
	}

	return $tag;

}
add_filter( 'script_loader_tag', 'be_instant_page_script_type', 10, 3 );
