<?php
/**
 * Display Posts
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Template Parts with Display Posts Shortcode
 * @author Bill Erickson
 * @see https://www.billerickson.net/template-parts-with-display-posts-shortcode
 *
 * @param string $output, current output of post
 * @param array $original_atts, original attributes passed to shortcode
 * @return string $output
 */
function ea_dps_template_part( $output, $original_atts ) {

	// Return early if our "layout" attribute is not specified
	if( empty( $original_atts['layout'] ) )
		return $output;

	ob_start();
	$partial = 'archive' === $original_atts['layout'] ? null : esc_attr( $original_atts['layout'] );
	get_template_part( 'partials/archive', $partial );
	$new_output = ob_get_clean();
	if( !empty( $new_output ) )
		$output = $new_output;
	return $output;
}
add_action( 'display_posts_shortcode_output', 'ea_dps_template_part', 10, 2 );

/**
 * Display Posts Wrapper
 *
 */
function ea_dps_wrapper_open( $markup, $atts ) {
	if( empty( $atts['layout'] ) )
		return $markup;

	$wrapper = 'div';
	$class = 'layout-' . $atts['layout'];

	return '<' . $wrapper . ' class="display-posts-listing ' . $class . '">';
}
add_filter( 'display_posts_shortcode_wrapper_open', 'ea_dps_wrapper_open', 10, 2 );

/**
 * Display Posts, wrapper close
 *
 */
function ea_dps_wrapper_close( $markup, $atts ) {
	if( empty( $atts['layout'] ) )
		return $markup;

	return '</div>';
}
add_filter( 'display_posts_shortcode_wrapper_close', 'ea_dps_wrapper_close', 10, 2 );
