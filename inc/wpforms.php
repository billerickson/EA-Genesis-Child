<?php
/**
 * WPForms
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * WPForms submit button, match Gutenberg button block
 * @see https://www.billerickson.net/code/wpforms-submit-button-match-gutenberg-block/
 */
function be_wpforms_match_button_block( $form_data ) {
	$form_data['settings']['submit_class'] .= ' wp-block-button__link';
	return $form_data;
}
add_filter( 'wpforms_frontend_form_data', 'be_wpforms_match_button_block' );
