<?php
/**
 * Template Tags
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/


/**
 * Entry Category
 *
 */
function ea_entry_category() {
	$term = ea_first_term();
	if( !empty( $term ) && ! is_wp_error( $term ) )
		echo '<p class="entry-category"><a href="' . get_term_link( $term, 'category' ) . '">' . $term->name . '</a></p>';
}

/**
 * Post Summary Title
 *
 */
function ea_post_summary_title() {
	echo '<h2 class="post-summary__title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
}

/**
 * Post Summary Image
 *
 */
function ea_post_summary_image() {
	echo '<a class="post-summary__image" href="' . get_permalink() . '" tabindex="-1" aria-hidden="true">' . wp_get_attachment_image( ea_entry_image_id(), 'medium' ) . '</a>';
}

/**
 * Entry Image ID
 *
 */
function ea_entry_image_id() {
	return has_post_thumbnail() ? get_post_thumbnail_id() : get_option( 'options_ea_default_image' );
}
