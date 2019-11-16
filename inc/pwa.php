<?php
/**
 * PWA
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

namespace Basic_Site_Caching;

// Customize the manifest
add_filter(
	'web_app_manifest',
	function( $manifest ) {
		//$manifest['short_name'] = 'Client Short Name';
		$manifest['display'] = 'standalone';
		return $manifest;
	}
);

// Enable network-first caching strategy for navigation requests (i.e. clicking around the site).
add_filter(
	'wp_service_worker_navigation_caching_strategy',
	function () {
		return \WP_Service_Worker_Caching_Routes::STRATEGY_NETWORK_FIRST;
	}
);
// Hold on to a certain number of navigated pages in the cache.
add_filter(
	'wp_service_worker_navigation_caching_strategy_args',
	function ( $args ) {
		$args['cacheName'] = 'pages';
		$args['plugins']['expiration']['maxEntries'] = 20;
		return $args;
	}
);
// Cache theme assets with runtime network-first caching strategy. This includes both the parent theme and child theme.
add_action(
	'wp_front_service_worker',
	function ( \WP_Service_Worker_Scripts $scripts ) {
		$theme_directory_uri_patterns = [
			preg_quote( trailingslashit( get_template_directory_uri() ), '/' ),
		];
		if ( get_template() !== get_stylesheet() ) {
			$theme_directory_uri_patterns[] = preg_quote( trailingslashit( get_stylesheet_directory_uri() ), '/' );
		}
		$scripts->caching_routes()->register(
			'^(' . implode( '|', $theme_directory_uri_patterns ) . ').*',
			array(
				'strategy'  => \WP_Service_Worker_Caching_Routes::STRATEGY_NETWORK_FIRST,
				'cacheName' => 'theme-assets',
				'plugins'   => array(
					'expiration' => array(
						'maxEntries' => 25, // Limit the cached entries to the number of files loaded over network, e.g. JS, CSS, and PNG.
					),
				),
			)
		);
	}
);
// Add caching for uploaded images.
add_action(
	'wp_front_service_worker',
	function ( \WP_Service_Worker_Scripts $scripts ) {
		$upload_dir = wp_get_upload_dir();
		$scripts->caching_routes()->register(
			'^(' . preg_quote( $upload_dir['baseurl'], '/' ) . ').*\.(png|gif|jpg|jpeg|svg|webp)(\?.*)?$',
			array(
				'strategy'  => \WP_Service_Worker_Caching_Routes::STRATEGY_CACHE_FIRST,
				'cacheName' => 'uploads',
				'plugins'   => array(
					'expiration' => array(
						'maxAgeSeconds' => MONTH_IN_SECONDS,
					),
				),
			)
		);
	}
);
