<?php
/**
 * Social Links
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Social Links
 *
 */
function ea_social_links() {
	$socials = [
		'facebook'	=> [
			'key'	=> 'facebook_site',
			'label'	=> 'Facebook',
		],
		'twitter'	=> [
			'key'		=> 'twitter_site',
			'label'		=> 'Twitter',
			'prepend'	=> 'https://twitter.com/',
		],
		'pinterest'	=> [
			'key'	=> 'pinterest_url',
			'label'	=> 'Pinterest',
		],
		'instagram'	=> [
			'key'	=> 'instagram_url',
			'label'	=> 'Instagram',
		],
		'linkedin'	=> [
			'key'	=> 'linkedin_url',
			'label'	=> 'LinkedIn',
		]
	];

	$output = [];
	$seo_data = get_option( 'wpseo_social' );
	foreach( $socials as $social => $settings ) {
		$url = !empty( $seo_data[ $settings['key'] ] ) ? $seo_data[ $settings['key'] ] : false;
		if( !empty( $url ) && !empty( $settings['prepend'] ) )
			$url = $settings['prepend'] . $url;
		if( !empty( $url ) )
			$output[] = '<li><a href="' . esc_url_raw( $url ) . '" target="_blank" rel="noopener noreferrer">' . ea_icon( array( 'icon' => $social, 'group' => 'social', 'label' => $settings['label'] ) ) . '<span class="label">' . esc_html( $settings['label'] ) . '</span></a></li>';
	}

	if( !empty( $output ) )
		return '<ul class="social-links">' . join( PHP_EOL, $output ) . '</ul>';
}
add_shortcode( 'social_links', 'ea_social_links' );
