<?php
/**
 * Shared Counts
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Production URL
 * @author Bill Erickson
 * @link https://sharedcountsplugin.com/2019/03/27/use-production-url-when-in-development-or-staging/
 *
 * @param string $url (optional), URL to convert to production.
 * @return string $url, converted to production. Uses home_url() if no url provided
 *
 */
function ea_production_url( $url = false ) {
	$production = false; // put production URL here

	if( !empty( $production_url ) ) {
		$url = $url ? esc_url( $url ) : home_url();
		$url = str_replace( home_url(), $production, $url );
	}

	return esc_url( $url );
}

/**
 * Use Production URL for Share Count API
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/use-production-url-in-shared-counts/
 *
 * @param array $params, API parameters used when fetching share counts
 * @return array
 */
function ea_production_url_share_count_api( $params ) {
	$params['url'] = ea_production_url( $params['url'] );
	return $params;
}
add_filter( 'shared_counts_api_params', 'ea_production_url_share_count_api' );

/**
 * Use Production URL for Share Count link
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/use-production-url-in-shared-counts/
 *
 * @param array $link, elements of the link
 * @return array
 */
function ea_production_url_share_count_link( $link ) {
	$exclude = array( 'print', 'email' );
	if( ! in_array( $link['type'], $exclude ) )
		$link['link'] = ea_production_url( $link['link'] );
	return $link;
}
add_filter( 'shared_counts_link', 'ea_production_url_share_count_link' );
