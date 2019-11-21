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
 * Use Archive Loop
 *
 */
function ea_use_archive_loop() {

	if( ! is_singular() && ! is_404() ) {
		add_action( 'genesis_loop', 'ea_archive_loop' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}
add_action( 'template_redirect', 'ea_use_archive_loop', 20 );

/**
 * Archive Loop
 * Uses template partials
 */
function ea_archive_loop() {

	if ( have_posts() ) {

		do_action( 'genesis_before_while' );

		while ( have_posts() ) {

			the_post();
			do_action( 'genesis_before_entry' );

			// Template part
			$partial = apply_filters( 'ea_loop_partial', 'archive' );
			$context = apply_filters( 'ea_loop_partial_context', is_search() ? 'search' : get_post_type() );
			get_template_part( 'partials/' . $partial, $context );

			do_action( 'genesis_after_entry' );

		}

		do_action( 'genesis_after_endwhile' );

	} else {

		do_action( 'genesis_loop_else' );

	}
}

/**
 * Remove entry-title if h1 block used
 * @link https://www.billerickson.net/building-a-header-block-in-wordpress/
 */
function be_remove_entry_title() {

	if( ! ( is_singular() && function_exists( 'parse_blocks' ) ) )
		return;

	global $post;
	$blocks = parse_blocks( $post->post_content );
	$has_h1 = be_has_h1_block( $blocks );

	if( $has_h1 ) {
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_do_breadcrumbs', 8 );
		remove_action( 'genesis_entry_header', 'ea_entry_category', 8 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'ea_entry_author', 12 );
		remove_action( 'genesis_entry_header', 'ea_entry_header_share', 13 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	}
}
add_action( 'genesis_before_entry', 'be_remove_entry_title' );

/**
 * Recursively searches content for h1 blocks.
 *
 * @link https://www.billerickson.net/building-a-header-block-in-wordpress/
 *
 * @param array $blocks
 * @return bool
 */
function be_has_h1_block( $blocks = array() ) {
	foreach ( $blocks as $block ) {

		if( ! isset( $block['blockName'] ) )
			continue;

		// Custom header block
		if( 'acf/header' === $block['blockName'] ) {
			return true;

		// Heading block
		} elseif( 'core/heading' === $block['blockName'] && isset( $block['attrs']['level'] ) && 1 === $block['attrs']['level'] ) {
			return true;

		// Scan inner blocks for headings
		} elseif( isset( $block['innerBlocks'] ) && !empty( $block['innerBlocks'] ) ) {
			$inner_h1 = be_has_h1_block( $block['innerBlocks'] );
			if( $inner_h1 )
				return true;
		}
	}

	return false;
}
