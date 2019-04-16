<?php
/**
 * Disable Genesis Schema
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 */

class BE_Disable_Genesis_Schema {

	public function __construct() {

		$elements = array(
			'head',
			'body',
			'site-header',
			'site-title',
			'site-description',
			'breadcrumb',
			'breadcrumb-link-wrap',
			'breadcrumb-link-wrap-meta',
			'breadcrumb-link',
			'breadcrumb-link-text-wrap',
			'search-form',
			'search-form-meta',
			'search-form-input',
			'nav-primary',
			'nav-secondary',
			'nav-header',
			'nav-link-wrap',
			'nav-link',
			'entry',
			'entry-image',
			'entry-image-widget',
			'entry-image-grid-loop',
			'entry-author',
			'entry-author-link',
			'entry-author-name',
			'entry-time',
			'entry-modified-time',
			'entry-title',
			'entry-content',
			'comment',
			'comment-author',
			'comment-author-link',
			'comment-time',
			'comment-time-link',
			'comment-content',
			'author-box',
			'sidebar-primary',
			'sidebar-secondary',
			'site-footer',
		);

		foreach( $elements as $element ) {
			add_filter( 'genesis_attr_' . $element, array( $this, 'remove_schema_attributes' ), 20 );
		}
	}

	/**
	 * Remove schema attributes
	 *
	 */
	function remove_schema_attributes( $attr ) {
		$remove = array( 'itemprop', 'itemtype', 'itemscope' );
		foreach( $remove as $item ) {
			if( !empty( $attr[ $item ] ) )
				unset( $attr[ $item ] );
		}
		return $attr;
	}

}
new BE_Disable_Genesis_Schema();
