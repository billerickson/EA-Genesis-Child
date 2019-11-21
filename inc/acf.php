<?php
/**
 * ACF Customizations
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

class BE_ACF_Customizations {

	public function __construct() {

		// Only allow fields to be edited on development
		if ( ! defined( 'WP_LOCAL_DEV' ) || ! WP_LOCAL_DEV ) {
			add_filter( 'acf/settings/show_admin', '__return_false' );
		}

		// Register options page
		add_action( 'init', array( $this, 'register_options_page' ) );

		// Register Blocks
		add_action('acf/init', array( $this, 'register_blocks' ) );

		// Dynamic options
		add_filter( 'acf/load_field', array( $this, 'dynamic_layouts' ) );
	}

	/**
	 * Register Options Page
	 *
	 */
	function register_options_page() {
	    if ( function_exists( 'acf_add_options_page' ) ) {
	        acf_add_options_page( array(
	        	'title'      => __( 'Site Options', 'cgh2020' ),
	        	'capability' => 'manage_options',
	        ) );
	    }
	}

	/**
	 * Register Blocks
	 * @link https://www.billerickson.net/building-gutenberg-block-acf/#register-block
	 *
	 * Categories: common, formatting, layout, widgets, embed
	 * Dashicons: https://developer.wordpress.org/resource/dashicons/
	 * ACF Settings: https://www.advancedcustomfields.com/resources/acf_register_block/
	 */
	function register_blocks() {

		if( ! function_exists('acf_register_block_type') )
			return;

			acf_register_block_type(array(
				'name'				=> 'post-listing',
				'title'				=> __( 'Post Listing', 'ea_genesis_child' ),
				'mode'				=> 'auto',
				'render_template'	=> 'partials/blocks/post-listing.php',
				'category'			=> 'widgets',
				'icon'				=> 'feedback',
				'supports'			=> [ 'anchor' => true, 'align' => false ],
			));

	}

	/**
	 * Dynamic layouts
	 *
	 */
	function dynamic_layouts( $field ) {
		if( 'post_listing_layout' !== $field['name'] )
			return $field;

		$field['choices'] = [];
		$field['default'] = false;
		$layouts = ea_post_listing_layouts();
		foreach( $layouts as $key => $details ) {
			$field['choices'][ $key ] = $details['label'];

			// Set default to first layout
			if( false === $field['default'] )
				$field['default'] = $key;
		}

		return $field;
	}

}
new BE_ACF_Customizations();
