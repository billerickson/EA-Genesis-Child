<?php
/**
 * Navigation
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Don't let Genesis load menus
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/**
 * Mobile Menu
 *
 */
function ea_site_header() {
	// echo ea_mobile_menu_toggle();
	// echo ea_search_toggle();

	echo '<nav' . ea_amp_class( 'nav-menu bg-white border-b border-[#EAEBF0] font-avenirnext-demi', 'active', 'menuActive' ) . ' x-data="{mobileMenuOpen: false}" @click.outside="mobileMenuOpen = false" role="navigation">';
		echo '<div class="mx-auto px-4 sm:px-6 lg:px-8">';
            echo '<div class="flex justify-between h-16">';
                echo '<div class="flex px-2 lg:px-0">';

                    do_action( 'cb_genesis_site_title' );

                    if( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'hidden lg:ml-6 lg:flex lg:space-x-8', 'container_class' => 'nav-primary flex', 'walker' => new Primary_Walker_Nav_Menu() ) );
                    }

                echo '</div>';

                echo cb_register_menu();
                echo cb_mobile_menu_toggle();
                
            echo '</div>';
		echo '</div>';
	echo '</nav>';

    echo '<nav' . ea_amp_class( 'nav-menu bg-white border-b border-[#EAEBF0]', 'active', 'menuActive' ) . ' x-data="{mobileMenuOpen: false}" @click.outside="mobileMenuOpen = false" role="navigation">';
		echo '<div class="mx-auto px-4 sm:px-6 lg:px-8">';
            echo '<div class="flex justify-between h-16">';
                echo '<div class="flex px-2 lg:px-0">';

                    do_action( 'cb_genesis_site_title' );

                    if( has_nav_menu( 'secondary' ) ) {
                        wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'menu_class' => 'hidden lg:ml-6 lg:flex lg:space-x-8', 'container_class' => 'nav-secondary flex', 'walker' => new Secondary_Walker_Nav_Menu() ) );
                    }
                echo '</div>';
                // Search bar
                echo '<div' . ea_amp_class( 'header-search flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end', 'active', 'searchActive' ) . '>' . get_search_form( array( 'echo' => false ) ) . '</div>';
            echo '</div>';
		echo '</div>';
	echo '</nav>';
}
add_action( 'genesis_header', 'ea_site_header', 11 );
 
/**
 * Primary Menu Custom walker class.
 * 
 */
class Primary_Walker_Nav_Menu extends Walker_Nav_Menu {
 
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            ( $display_depth == 1 ? 'relative grid gap-6 bg-white px-5 py-6 sm:gap-1 sm:p-2 lg:grid-cols-2' : '' ),
            'menu-depth-' . $display_depth,
        );
        $class_names = implode( ' ', $classes );

        $wrapper_class_1 = 'absolute z-10 left-0 transform -translate-x-8 mt-16 px-2 w-screen max-w-lg sm:px-0';
        $wrapper_class_2 = 'rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden';
 
        // Build HTML for output.
        $output .= ( $depth == 0 ? "\n" . $indent . '<div class="' . $wrapper_class_1 . '" x-show="flyoutMenuOpen" @click.outside="flyoutMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"><div class="' . $wrapper_class_2 . '"><ul class="' . $class_names . '">' . "\n"  : "\n" . $indent . '<ul class="' . $class_names . '">' . "\n");
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= ($depth == 0 ? "$indent</ul></div></div>\n" : "$indent</ul>\n");
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item relative inline-flex' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );    
 
        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Add AlpineJS attributes
        $aj_attr_x_data = ( $depth == 0 ? '{ flyoutMenuOpen: false }' : '' );
        $aj_attr_mouseover = ( $depth == 0 ? 'flyoutMenuOpen = false' : '' );
 
        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '" x-data="' . $aj_attr_x_data . '" @click.outside="' . $aj_attr_mouseover . '">';
 
        // Depth-link classes a&&b
        $depth_link_classes = array(
            ( $depth == 0 ? 'main-menu-link inline-flex items-center px-1 pt-1 border-b-4 text-sm' : 'sub-menu-link' ),
            ( $depth == 1 && $item->post_name == 'residential-for-sale' ? '-ml-0.5 -mr-0.5 pt-2 pb-2 pl-4 pr-4 text-xs text-blue-600 leading-9' : '' ),
            ( $depth == 1 && $item->post_name == 'commercial-for-sale' ? '-ml-0.5 -mr-0.5 pt-2 pb-2 pl-4 pr-4 text-xs text-cblavender-300 leading-9' : '' ),
            ( $depth == 2 && $item->menu_item_parent == 37 ? '-m-0.5 p-4 block rounded-md hover:bg-cbblue-100 text-cbspacecadet-300 hover:text-blue-600 text-sm' : '' ),
            ( $depth == 2 && $item->menu_item_parent == 44 ? '-m-0.5 p-4 block rounded-md hover:bg-cblavender-100 text-cbspacecadet-300 hover:text-cblavender-300 text-sm' : '' ),
        );
        $depth_link_class_names = esc_attr( implode( ' ', $depth_link_classes ) );
        
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . $depth_link_class_names . '"';
        $attributes .= ( $depth == 0 ? ' @click="flyoutMenuOpen = !flyoutMenuOpen" :class="flyoutMenuOpen ? \'border-blue-600 text-blue-600\' : \'border-transparent text-cbspacecadet-300 hover:border-blue-600 hover:text-blue-600\'"' : '');
 
        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
   
/**
 * Secondary Menu Custom walker class.
 * 
 */
class Secondary_Walker_Nav_Menu extends Walker_Nav_Menu {
 
    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Depth-dependent classes.
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ( $display_depth == 1 ? 'relative grid gap-6 bg-white px-5 py-6 sm:gap-1 sm:p-2' : '' ),
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
            'menu-depth-' . $display_depth,
        );
        $class_names = implode( ' ', $classes );

        $wrapper_class_1 = 'absolute z-10 left-4 transform -translate-x-8 mt-16 px-2 w-screen max-w-max sm:px-0';
        $wrapper_class_2 = 'rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden';
 
        // Build HTML for output.
        $output .= ( $depth == 0 ? "\n" . $indent . '<div class="' . $wrapper_class_1 . '" x-show="flyoutMenuOpen" @click.outside="flyoutMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"><div class="' . $wrapper_class_2 . '"><ul class="' . $class_names . '">' . "\n"  : "\n" . $indent . '<ul class="' . $class_names . '">' . "\n");
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= ($depth == 0 ? "$indent</ul></div></div>\n" : "$indent</ul>\n");
    }
 
    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
 
        // Depth-dependent classes.
        $depth_classes = array(
            ( $depth == 0 ? 'main-menu-item relative inline-flex' : 'sub-menu-item' ),
            ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );    
 
        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Add AlpineJS attributes
        $aj_attr_x_data = ( $depth == 0 ? '{ flyoutMenuOpen: false }' : '' );
        $aj_attr_mouseover = ( $depth == 0 ? 'flyoutMenuOpen = false' : '' );
 
        // Build HTML.
        $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '" x-data="' . $aj_attr_x_data . '" @click.outside="' . $aj_attr_mouseover . '">';
 
        // Depth-link classes a&&b
        $depth_link_classes = array(
            ( $depth == 0 ? 'main-menu-link inline-flex items-center px-1 pt-1 border-b-4 text-sm' : 'sub-menu-link -m-0.5 p-4 block rounded-md hover:bg-cbblue-100 text-cbspacecadet-300 hover:text-blue-600 text-sm' ),
            ( $depth == 1 && $item->post_name == 'residential-for-sale' ? '-ml-0.5 -mr-0.5 pt-2 pb-2 pl-4 pr-4 text-xs text-blue-600 leading-9' : '' ),
            ( $depth == 1 && $item->post_name == 'commercial-for-sale' ? '-ml-0.5 -mr-0.5 pt-2 pb-2 pl-4 pr-4 text-xs text-cblavender-300 leading-9' : '' ),
            ( $depth == 2 && $item->menu_item_parent == 37 ? '-m-0.5 p-4 block rounded-md hover:bg-cbblue-100 text-cbspacecadet-300 hover:text-blue-600 text-sm' : '' ),
            ( $depth == 2 && $item->menu_item_parent == 44 ? '-m-0.5 p-4 block rounded-md hover:bg-cblavender-100 text-cbspacecadet-300 hover:text-cblavender-300 text-sm' : '' ),
        );
        $depth_link_class_names = esc_attr( implode( ' ', $depth_link_classes ) );
        
        // Link attributes.
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . $depth_link_class_names . '"';
        $attributes .= ( $depth == 0 ? ' @click="flyoutMenuOpen = !flyoutMenuOpen" :class="flyoutMenuOpen ? \'border-blue-600 text-blue-600\' : \'border-transparent text-cbspacecadet-300 hover:border-blue-600 hover:text-blue-600\'"' : '');
 
        // Build HTML output and pass through the proper filter.
        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}
/**
 * Nav Extras
 *
 */
function ea_nav_extras( $menu, $args ) {

	if( 'primary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . ea_search_toggle() . '</li>';
	}

	if( 'secondary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . get_search_form( false ) . '</li>';
	}

	return $menu;
}
// add_filter( 'wp_nav_menu_items', 'ea_nav_extras', 10, 2 );

/**
 * Search toggle
 *
 */
function ea_search_toggle() {
	$output = '<button' . ea_amp_class( 'search-toggle', 'active', 'searchActive' ) . ea_amp_toggle( 'searchActive', array( 'menuActive', 'mobileFollow' ) ) . '>';
		$output .= ea_icon( array( 'icon' => 'search', 'size' => 24, 'class' => 'open' ) );
		$output .= ea_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Search</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Mobile menu toggle
 *
 */
function cb_mobile_menu_toggle() {
    // Hamburger Menu
    $output = '<div class="-mr-2 flex items-center lg:hidden">';
        $output .= '<button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">';
            $output .= '<span class="sr-only">Open main menu</span>';
            // Mobile menu icon
            $output .= '<svg :class="mobileMenuOpen ? \'hidden\': \'block\'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">';
                $output .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            $output .= '</svg>';
            // Mobile X icon
            $output .= '<svg :class="mobileMenuOpen ? \'block\': \'hidden\'" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">';
                $output .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            $output .= '</svg>';
        $output .= '</button>';
    $output .= '</div>';
	return $output;
}

/**
 * Signup Login Menu
 * 
 */
function cb_register_menu(){
    $output = '<div class="hidden flex-1 lg:flex items-center justify-end lg:ml-6">';
        $output .= '<a href="#" class="whitespace-nowrap text-sm text-cbspacecadet-300 hover:text-blue-600">Sign up</a>';
        $output .= '<a href="#" class="ml-2 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 text-sm text-cbspacecadet-300 hover:text-blue-600">Log in</a>';
    $output .= '</div>';
    return $output;
}

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function ea_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = ea_icon( array( 'icon' => 'navigate-down', 'size' => 8, 'title' => 'Submenu Dropdown' ) );

		$output .= sprintf(
			'<button' . ea_amp_nav_dropdown( $args->theme_location, $depth ) . ' tabindex="-1">%s</button>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'ea_nav_add_dropdown_icons', 10, 4 );

// Move site title in nav-menu
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
add_action( 'cb_genesis_site_title', 'genesis_seo_site_title' );

/**
 * Add Site Description to Title 
 *
 */
function be_desc_in_title( $title, $inside, $wrap ) {

    $wrap   = 'div';
	$inside = '<a href="' . home_url() . '">' . get_bloginfo( 'name' ) . ' <img class="block h-8 w-auto" src="//www.99.co/spa-assets/web-icons/logo.png" alt="99.co property website singapore"></img></a>';
	
	//* Build the title
	$title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-title', ['class' => 'site-title flex-shrink-0 flex items-center'] ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
	$title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';
	return $title;	
}
add_filter( 'genesis_seo_title', 'be_desc_in_title', 10, 3 );