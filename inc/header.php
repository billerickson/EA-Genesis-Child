<?php
/**
 * Site Header
 *
 * @package      CBGenesisChild
 * @author       Chillybin
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Add attribute and classnames in <header> tag
 */
// add_filter( 'genesis_attr_site-header', 'cb_add_attrs_site_header' );
function cb_add_attrs_site_header( $attributes ) {
 
    $attributes['class'] = 'site-header bg-white shadow';
    $attributes['x-data'] = '{mobileMenuOpen: false}';
    $attributes['@click.outside'] = 'mobileMenuOpen = false';

    return $attributes;
}

/**
 * Tailwindcss configuration
 */
add_action( 'wp_head', 'cb_tailwind_config' );
function cb_tailwind_config(){
?>
	<script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'avenirnext-bold': "'Avenir Next Bold'",
                        'avenirnext-demi': "'Avenir Next Demi'",
                        'avenirnext-medium': "'Avenir Next Medium'",
                        'avenirnext-regular': "'Avenir Next Regular'",
                    },
                    fontSize: {
                        sm: ['.875rem', '1rem'],
                    },
                    colors: {
                        'cbneutral-300': '#1A2258',
                        'cbblue-100': '#F0F6FF',
                        'cblavender-100': '#faf6ff',
                        'cblavender-300': '#844be3'
                    }
                }                
            }
        }
    </script>
<?php
}

/**
 * Add Custom Font to Tailwindcss
 */
function cb_add_custom_font() {
	?>
    <style type="text/tailwindcss">
			@layer base {
				@font-face {
					font-family: 'Avenir Next Bold';
					src: url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Bold.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Bold.woff") format("woff");
				}
				@font-face {
					font-family: 'Avenir Next Demi';
					src: url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Demi.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Demi.woff") format("woff");
				}
				@font-face {
					font-family: 'Avenir Next Medium';
					src: url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Medium.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Medium.woff") format("woff");
				}
				@font-face {
					font-family: 'Avenir Next Regular';
					src: url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Regular.woff2") format("woff2"), url("<?php echo get_stylesheet_directory_uri(); ?>/fonts/AvenirNextLTPro-Regular.woff") format("woff");
				}
			}
		</style>
    <?php
}
add_action('wp_head', 'cb_add_custom_font');

/**
 * Add Avenirnext font in body class
 *
 */
function cb_avenirnext_font_body_class( $classes ) {
	if( is_singular() )
		$classes[] = 'font-avenirnext-medium';
	return $classes;
}
add_filter( 'body_class', 'cb_avenirnext_font_body_class' );