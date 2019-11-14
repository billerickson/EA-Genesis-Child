<?php
/**
 * Category Landing Page
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Category Landing Page
 * If you would like to use this as a standalone plugin: https://github.com/billerickson/Category-Landing-Page/
 */
 class Category_Landing_Page {

 	/**
 	 * Instance of the class.
 	 * @var object
 	 */
 	private static $instance;

 	/**
 	 * Supported taxonomies
 	 * @var array
 	 */
 	public $supported_taxonomies;

	/**
	 * Post type
	 * @var string
	 */
	public $post_type = 'be_landing_page';

 	/**
 	 * Class Instance.
 	 * @return Category_Landing_Page
 	 */
 	public static function instance() {
 		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Category_Landing_Page ) ) {
 			self::$instance = new Category_Landing_Page();

			add_action( 'init', [ self::$instance, 'supported_taxonomies' ], 4 );
 			add_action( 'init', [ self::$instance, 'register_cpt' ], 12 );
			add_action('acf/init', [ self::$instance, 'register_metabox' ] );
 			add_action( 'admin_bar_menu', [ self::$instance, 'admin_bar_link_front' ], 90 );
			add_action( 'admin_bar_menu', [ self::$instance, 'admin_bar_link_back' ], 90 );
			add_action( 'genesis_before_while', [ self::$instance, 'show' ] );
 		}
 		return self::$instance;
 	}

	/**
	 * Supported Taxonomies
	 *
	 */
	function supported_taxonomies() {
		$this->supported_taxonomies = apply_filters( 'category_landing_page_taxonomies', [ 'category' ] );
	}

 	/**
 	 * Register the custom post type
 	 *
 	 */
 	function register_cpt() {

 		$labels = array(
 			'name'               => 'Landing Pages',
 			'singular_name'      => 'Landing Page',
 			'add_new'            => 'Add New',
 			'add_new_item'       => 'Add New Landing Page',
 			'edit_item'          => 'Edit Landing Page',
 			'new_item'           => 'New Landing Page',
 			'view_item'          => 'View Landing Page',
 			'search_items'       => 'Search Landing Pages',
 			'not_found'          => 'No Landing Pages found',
 			'not_found_in_trash' => 'No Landing Pages found in Trash',
 			'parent_item_colon'  => 'Parent Landing Page:',
 			'menu_name'          => 'Landing Pages',
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
 			'rewrite'             => false,
 			'menu_icon'           => 'dashicons-welcome-widgets-menus',
 		);

 		register_post_type( $this->post_type, $args );
 	}

	/**
	 * Register metabox
	 *
	 */
	function register_metabox() {

		$taxonomies = $tax_fields = [];
		foreach( $this->supported_taxonomies as $i => $tax_slug ) {
			$tax = get_taxonomy( $tax_slug );
			$taxonomies[ $tax_slug ] = $tax->labels->singular_name;

			$tax_fields[] = [
				'key'					=> 'field_10' . $i,
				'label'					=> $tax->labels->name,
				'name'					=> 'be_connected_' . $tax_slug,
				'type'					=> 'taxonomy',
				'taxonomy'				=> $tax_slug,
				'field_type'			=> 'select',
				'conditional_logic'		=> [
					[
						[
							'field'		=> 'field_5da8747adb0bf',
							'operator'	=> '==',
							'value'		=> $tax_slug,
						]
					]
				]
			];
		}

		$taxonomy_select_field = [[
			'key'		=> 'field_5da8747adb0bf',
			'label'		=> 'Taxonomy',
			'name'		=> 'be_connected_taxonomy',
			'type'		=> 'select',
			'choices'	=> $taxonomies,
		]];

		$settings = [
			'title' => 'Appears On',
			'fields' => array_merge( $taxonomy_select_field, $tax_fields ),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => $this->post_type,
					),
				),
			),
			'position' => 'side',
			'active' => true,
		];

		acf_add_local_field_group( $settings );
	}


 	/**
 	 * Show landing page
 	 *
 	 */
 	function show( $location = '' ) {
 		if( ! $location )
 			$location = $this->get_landing_id();

		if( empty( $location ) || get_query_var( 'paged' ) )
			return;

 		$args = [ 'post_type' => $this->post_type, 'posts_per_page' => 1 ];
 		if( is_int( $location ) )
 			$args['p'] = intval( $location );
 		else
 			$args['name'] = sanitize_key( $location );

 		$loop = new WP_Query( $args );

 		if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
 			echo '<div class="block-area block-area-' . sanitize_key( get_the_title() ) . '">';
 				the_content();
 			echo '</div>';
 		endwhile; endif; wp_reset_postdata();
 	}

 	/**
 	 * Get taxonomy
 	 *
 	 */
 	function get_taxonomy() {
 		$taxonomy = is_category() ? 'category' : ( is_tag() ? 'post_tag' : get_query_var( 'taxonomy' ) );
 		if( in_array( $taxonomy, $this->supported_taxonomies ) )
 			return $taxonomy;
 		else
 			return false;
 	}

 	/**
 	 * Get Landing Page ID
 	 *
 	 */
 	function get_landing_id() {
 		$taxonomy = $this->get_taxonomy();
 		if( empty( $taxonomy ) || ! is_archive() )
 			return false;

 		$meta_key = 'be_connected_' . str_replace( '-', '_', $taxonomy );

 		$loop = new WP_Query( array(
 			'post_type' => $this->post_type,
 			'posts_per_page' => 1,
 			'fields' => 'ids',
 			'no_found_rows' => true,
 			'update_post_term_cache' => false,
 			'update_post_meta_cache' => false,
 			'meta_query' => array(
 				array(
 					'key' => $meta_key,
 					'value' => get_queried_object_id(),
 				)
 			)
 		));

 		if( empty( $loop->posts ) )
 			return false;
 		else
 			return $loop->posts[0];

 	}

	/**
	 * Get term link
	 *
	 */
	function get_term_link( $archive_id = false ) {

		if( empty( $archive_id ) )
			return false;

		$taxonomy = get_post_meta( $archive_id, 'be_connected_taxonomy', true );
		$term = get_post_meta( $archive_id, 'be_connected_' . $taxonomy, true );

		if( empty( $term ) )
			return false;

		$term = get_term_by( 'term_id', $term, $taxonomy );
		return get_term_link( $term, $taxonomy );
	}

 	/**
 	 * Admin Bar Link, Frontend
 	 *
 	 */
 	 function admin_bar_link_front( $wp_admin_bar ) {
 		 $taxonomy = $this->get_taxonomy();
 		 if( ! $taxonomy )
 		 	return;

 		if( ! ( is_user_logged_in() && current_user_can( 'manage_categories' ) ) )
 			return;

 		$archive_id = $this->get_landing_id();
 		if( !empty( $archive_id ) ) {
 			$wp_admin_bar->add_node( array(
 				'id' => 'category_landing_page',
 				'title' => 'Edit Landing Page',
 				'href'  => get_edit_post_link( $archive_id ),
 			) );

 		} else {
 			$wp_admin_bar->add_node( array(
 				'id' => 'category_landing_page',
 				'title' => 'Add Landing Page',
 				'href'  => admin_url( 'post-new.php?post_type=' . $this->post_type )
 			) );
 		}
 	 }

	 /**
  	 * Admin Bar Link, Backend
  	 *
  	 */
  	 function admin_bar_link_back( $wp_admin_bar ) {
		if( ! is_admin() )
			return;

		$screen = get_current_screen();
		if( empty( $screen->id ) || $this->post_type !== $screen->id )
			return;

		$archive_id = !empty( $_GET['post'] ) ? intval( $_GET['post'] ) : false;
		if( ! $archive_id )
			return;

		$term_link = $this->get_term_link( $archive_id );
		if( empty( $term_link ) )
			return;

		$wp_admin_bar->add_node( array(
			'id'	=> 'category_landing_page',
			'title'	=> 'View Landing Page',
			'href'	=> $term_link,
		));
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
 function category_landing_page() {
 	return Category_Landing_Page::instance();
 }
 category_landing_page();
