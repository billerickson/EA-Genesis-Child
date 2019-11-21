<?php
/**
 * Post Listing
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Post Listing Layouts
 *
 */
function ea_post_listing_layouts() {
	$layouts = [
		'layout4' => [
			'label'				=> '4 Columns',
			'posts_per_page'	=> 4,
			'partial'			=> 'tertiary',
		],
		'layout3' => [
			'label'				=> '3 Columns',
			'posts_per_page'	=> 3,
			'partial'			=> 'primary',
		],
		'layout2x2' => [
			'label'				=> '2x2 Columns',
			'posts_per_page'	=> 4,
			'partial'			=> 'secondary',
		],
/*
		'layout1x3' => [
			'label'				=> '1 Feature, 3 Teasers',
			'posts_per_page'	=> 4,
			'partial'			=> 'secondary',
			'partial_override'	=> [
				0 => 'feature',
			]
		]
*/		
	];
	return $layouts;
}

/**
 * Post Listing Taxonomies
 *
 */
function ea_post_listing_taxonomies() {
	$taxonomies = [
		[
			'tax'		=> 'category',
			'field'		=> 'category',
		],
	];
	return $taxonomies;
}

/**
 * Post Listing Args
 *
 */
function ea_post_listing_args( $settings = [] ) {
	$args = [
		'posts_per_page'	=> 4,
		'post_status'		=> 'publish',
	];

	$layouts = ea_post_listing_layouts();

	if( !empty( $settings['layout'] ) && array_key_exists( $settings['layout'], $layouts ) )
		$args['posts_per_page'] = $layouts[ $settings['layout'] ]['posts_per_page'];

	if( !empty( $settings['orderby'] ) && 'popular' === $settings['orderby'] ) {

		// Order by comment count
		$args['orderby'] = 'comment_count';

		/*
		// Order by share count
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'shared_counts_total';
		*/

		/*
		// Limit by post date
		$args['date_query'] = array(
			array(
				'after' => '-3 months',
			)
		);
		*/
	}

	$taxonomies = ea_post_listing_taxonomies();
	foreach( $taxonomies as $taxonomy ) {
		if( !empty( $settings[ $taxonomy['field'] ] ) ) {
			$terms = $settings[ $taxonomy['field'] ];
			if( ! is_array( $terms ) )
				$terms = array( $terms );

			$tax_args = [
				'taxonomy'	=> $taxonomy['tax'],
				'field'		=> 'term_id',
				'terms'		=> $terms,
				'include_children' => true,
			];
			if( 1 < count( $tax_args['terms'] ) ) {
				$tax_args['operator'] = 'AND';
				$tax_args['include_children'] = false;
			}
			$args['tax_query'][] = $tax_args;
		}
	}

	return $args;
}

/**
 * Post Listing Footer
 *
 */
function ea_post_listing_footer( $block = [] ) {
	$more_link = $has_tax = false;
	$taxonomies = ea_post_listing_taxonomies();
	foreach( $taxonomies as $taxonomy ) {
		if( !empty( $block['data'][ $taxonomy['field'] ] ) ) {
			$has_tax = true;
			$terms = $block['data'][ $taxonomy['field'] ];
			if( ! is_array( $terms ) )
				$terms = array( $terms );
			if( 1 < count( $terms ) )
				return false;
			$term = get_term_by( 'id', $terms[0], $taxonomy['tax'] );
			if( empty( $term ) || is_wp_error( $term ) || !empty( $more_link ) )
				return false;
			$more_link = '<a href="' . get_term_link( $term, $taxonomy['tax'] ) . '">More ' . $term->name . '</a>';
		}
	}

	if( ! $has_tax )
		$more_link = '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">More Articles</a>';

	if( !empty( $more_link ) )
		echo '<footer>' . $more_link . '</footer>';
}

/**
 * Post Listing Partial
 *
 */
function ea_post_listing_partial( $layout = false, $current_post = 0 ) {
	$partial = false;

	if( ! $layout )
		return $partial;

	$layouts = ea_post_listing_layouts();
	if( empty( $layouts[ $layout ] ) )
		return $partial;

	// Post specific partial
	if( !empty( $layouts[ $layout ]['partial_override'] ) && !empty( $layouts[ $layout ]['partial_override'][ $current_post ] ) )
		$partial = $layouts[ $layout ]['partial_override'][ $current_post ];

	// Layout specific partial
	if( empty( $partial ) )
		$partial = $layouts[ $layout ]['partial'];

	return $partial;
}
