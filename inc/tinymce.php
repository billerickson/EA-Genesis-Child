<?php
/**
 * TinyMCE
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

 /**
  * Add "Styles" drop-down to TinyMCE
  *
  * @since 1.0.0
  * @param array $buttons
  * @return array
  */
 function ea_mce_editor_buttons( $buttons ) {
 	array_unshift( $buttons, 'styleselect' );
 	return $buttons;
 }
 add_filter( 'mce_buttons_2', 'ea_mce_editor_buttons' );

 /**
  * Add styles/classes to the TinyMCE "Formats" drop-down
  *
  * @since 1.0.0
  * @param array $settings
  * @return array
  */
 function ea_mce_before_init( $settings ) {

 	$style_formats = array(
 		array(
 			'title'    => 'Button',
 			'selector' => 'a',
 			'classes'  => 'button',
 		),
		array(
			'title'    => 'Large Paragraph',
			'selector' => 'p',
			'classes'  => 'large',
		),
		array(
			'title'    => 'Small Paragraph',
			'selector' => 'p',
			'classes'  => 'small',
		),
		array(
			'title'    => 'Extra Margin Paragraph',
			'selector' => 'p',
			'classes'  => 'extra-margin',
		)
 	);
 	$settings['style_formats'] = json_encode( $style_formats );
 	return $settings;
 }
 add_filter( 'tiny_mce_before_init', 'ea_mce_before_init' );
