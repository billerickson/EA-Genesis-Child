<?php
/**
 * Post Listing block
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

$classes = ['post-listing-block'];
if( !empty( $block['className'] ) )
    $classes = array_merge( $classes, explode( ' ', $block['className'] ) );
if( !empty( $block['align'] ) )
    $classes[] = 'align' . $block['align'];

$anchor = '';
if( !empty( $block['anchor'] ) )
	$anchor = ' id="' . sanitize_title( $block['anchor'] ) . '"';

$settings = [
	'layout' => get_field( 'post_listing_layout' ),
	'orderby' => get_field( 'orderby' ),
	'category' => get_field( 'category' )
];

if( !empty( $settings['layout'] ) )
	$classes[] = $settings['layout'];

$loop = new WP_Query( ea_post_listing_args( $settings ) );
if( ! $loop->have_posts() )
	return;

echo '<section class="' . join( ' ', $classes ) . '"' . $anchor . '>';
	$title = get_field( 'title' );
	if( !empty( $title ) )
		echo '<header><h2>' . esc_html( $title ) . '</h2></header>';
	while( $loop->have_posts() ): $loop->the_post();
		$partial = ea_post_listing_partial( $settings['layout'], $loop->current_post );
		get_template_part( 'partials/archive', $partial );
	endwhile;
	wp_reset_postdata();
	ea_post_listing_footer( $block );
echo '</section>';
