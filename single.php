<?php
/**
 * Single Post
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Entry category in header
add_action( 'genesis_entry_header', 'ea_entry_category', 8 );
add_action( 'genesis_entry_header', 'ea_entry_author', 12 );
add_action( 'genesis_entry_header', 'ea_entry_header_share', 13 );

/**
 * Entry header share
 *
 */
function ea_entry_header_share() {
	do_action( 'ea_entry_header_share' );
}

/**
 * After Entry
 *
 */
function ea_single_after_entry() {
	echo '<div class="after-entry">';

	// Breadcrumbs
	genesis_do_breadcrumbs();

	// Publish date
	echo '<p class="publish-date">Published on ' . get_the_date( 'F j, Y' ) . '</p>';

	// Sharing
	do_action( 'ea_entry_footer_share' );

	// Author Box
	genesis_do_author_box_single();

	// Newsletter signup
	$form_id = get_option( 'options_ea_newsletter_form' );
	if( $form_id && function_exists( 'wpforms_display' ) )
		wpforms_display( $form_id, true, true );

	// Related Posts
	$loop = new WP_Query( [
		'posts_per_page'	=> 3,
		'post__not_in'		=> [ get_the_ID() ],
		'category_name'		=> ea_first_term( 'category', 'slug' ),
	] );
	if( $loop->have_posts() ):
		echo '<section class="post-listing-block layout3">';
		echo '<header><h2>Other articles you may like</h2></header>';
		while( $loop->have_posts() ):
			$loop->the_post();
			get_template_part( 'partials/archive' );
		endwhile;
		echo '</section>';
		wp_reset_postdata();
	endif;
	echo '</div>';
}
add_action( 'genesis_after_entry', 'ea_single_after_entry', 8 );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

genesis();
