<?php
/**
 * Block Area
 * CPT for block-based widget areas, until WP core adds block support to widget areas
 * @link https://www.billerickson.net/wordpress-gutenberg-block-widget-areas/
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

class EA_Block_Area {

	/**
	 * Instance of the class.
	 * @var object
	 */
	private static $instance;

	/**
	 * Class Instance.
	 * @return EA_Block_Area
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof EA_Block_Area ) ) {
			self::$instance = new EA_Block_Area();

			// Actions
			add_action( 'init',              array( self::$instance, 'register_cpt'      )    );
			add_action( 'template_redirect', array( self::$instance, 'redirect_single'   )    );
		}
		return self::$instance;
	}

	/**
	 * Register the custom post type
	 *
	 */
	function register_cpt() {

		$labels = array(
			'name'               => 'Block Areas',
			'singular_name'      => 'Block Area',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Block Area',
			'edit_item'          => 'Edit Block Area',
			'new_item'           => 'New Block Area',
			'view_item'          => 'View Block Area',
			'search_items'       => 'Search Block Areas',
			'not_found'          => 'No Block Areas found',
			'not_found_in_trash' => 'No Block Areas found in Trash',
			'parent_item_colon'  => 'Parent Block Area:',
			'menu_name'          => 'Block Areas',
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'revisions' ),
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'	      => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => 'block-area', 'with_front' => false ),
			'menu_icon'           => 'dashicons-schedule',
		);

		register_post_type( 'block_area', $args );

	}

	/**
	 * Redirect single block areas
	 *
	 */
	function redirect_single() {
		if( is_singular( 'block_area' ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}

	/**
	 * Show block area
	 *
	 */
	function show( $location = '', $has_wrap = false ) {
		if( ! $location )
			return;

		$location = sanitize_key( $location );

		$loop = new WP_Query( array(
			'post_type'		=> 'block_area',
			'name'    		=> $location,
			'posts_per_page'	=> 1,
		));

		if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
			echo '<div class="block-area block-area-' . $location . '">';
			if( $has_wrap )
				echo '<div class="wrap">';
			the_content();
			if( $has_wrap )
				echo '</div>';
			echo '</div>';
		endwhile; endif; wp_reset_postdata();
	}
}

/**
 * The function provides access to the class methods.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return object
 */
function ea_block_area() {
	return EA_Block_Area::instance();
}
ea_block_area();
