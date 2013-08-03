<?php
/**
 * EA Genesis Child.
 *
 * @package      EAGenesisChild
 * @since        1.0.0
 * @copyright    Copyright (c) 2013, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove unused page layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Remove unused secondary sidebar
unregister_sidebar( 'sidebar-alt' );

/**
 * Removes Unused Genesis user settings
 *
 * @since 1.0.0
 */
function ea_remove_user_profile_fields() {
	remove_action( 'show_user_profile', 'genesis_user_options_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
	remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
	remove_action( 'show_user_profile', 'genesis_user_seo_fields'     );
	remove_action( 'edit_user_profile', 'genesis_user_seo_fields'     );
	remove_action( 'show_user_profile', 'genesis_user_layout_fields'  );
	remove_action( 'edit_user_profile', 'genesis_user_layout_fields'  );
}
add_action( 'admin_init', 'ea_remove_user_profile_fields' );

remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );
/**
 * Re-prioritise Genesis SEO metabox from high to default.
 *
 * Copied and amended from /lib/admin/inpost-metaboxes.php, version 2.0.0.
 *
 * @since 1.0.0
 */
function ea_add_inpost_seo_box() {

	if ( genesis_detect_seo_plugins() )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-seo' ) )
			add_meta_box( 'genesis_inpost_seo_box', __( 'Theme SEO Settings', 'genesis' ), 'genesis_inpost_seo_box', $type, 'normal', 'default' );
	}

}
add_action( 'admin_menu', 'ea_add_inpost_seo_box' );

remove_action( 'admin_menu', 'genesis_add_inpost_layout_box' );
/**
 * Re-prioritise layout metabox from high to default.
 *
 * Copied and amended from /lib/admin/inpost-metaboxes.php, version 2.0.0.
 *
 * @since 1.0.0
 */
function ea_add_inpost_layout_box() {

	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) )
		return;

	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) )
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'default' );
	}

}
add_action( 'admin_menu', 'ea_add_inpost_layout_box' );

/**
 * Remove Genesis widgets.
 *
 * @since 1.0.0
 */
function ea_remove_genesis_widgets() {
    unregister_widget( 'Genesis_Featured_Page' );
    unregister_widget( 'Genesis_Featured_Post' );
    unregister_widget( 'Genesis_User_Profile_Widget' );
}
add_action( 'widgets_init', 'ea_remove_genesis_widgets', 20 );

/**
 * Remove Genesis theme settings metaboxes.
 *
 * @since 1.0.0
 * @param string $_genesis_theme_settings_pagehook
 */
function ea_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	//remove_meta_box( 'genesis-theme-settings-feeds',      $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-header',     $_genesis_theme_settings_pagehook, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav',        $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-comments',   $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-posts',      $_genesis_theme_settings_pagehook, 'main' );
	remove_meta_box( 'genesis-theme-settings-blogpage',   $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-scripts',    $_genesis_theme_settings_pagehook, 'main' );
}
add_action( 'genesis_theme_settings_metaboxes', 'ea_remove_genesis_metaboxes' );
