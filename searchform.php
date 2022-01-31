<?php
/**
 * Search form
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>

<form role="search" method="get" class="max-w-lg w-full lg:max-w-xs" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <!-- Heroicon name: solid/search -->
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <input id="search" class="search-field block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search" type="search" value="<?php echo get_search_query(); ?>" name="search" title="Search" />
    </div>
    <!-- <button type="submit" class="search-submit"> -->
        <?php 
            // echo ea_icon( array( 'icon' => 'search', 'title' => 'Submit' ) );
        ?>
    <!-- </button> -->
</form>