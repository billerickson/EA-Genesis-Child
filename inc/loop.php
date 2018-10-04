<?php
/**
 * Loop
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Archive Loop
 * Uses template partials
 */
function ea_archive_loop() {

	// Use standard genesis loop on singular content
	if( is_singular() ) {
		genesis_do_loop();
		return;
	}

	if ( have_posts() ) {

		do_action( 'genesis_before_while' );

		while ( have_posts() ) {

			the_post();
			do_action( 'genesis_before_entry' );

			// Template part
			$partial = apply_filters( 'ea_loop_partial', is_singular() ? 'content' : 'archive' );
			$context = apply_filters( 'ea_loop_partial_context', is_search() ? 'search' : get_post_type() );
			get_template_part( 'partials/' . $partial, $context );

			do_action( 'genesis_after_entry' );

		}

		do_action( 'genesis_after_endwhile' );

	} else {

		do_action( 'genesis_loop_else' );

	}
}
add_action( 'genesis_loop', 'ea_archive_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );
