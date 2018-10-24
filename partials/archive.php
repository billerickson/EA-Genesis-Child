<?php
/**
 * Archive partial
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

echo '<article class="post-summary">';

	echo '<a class="entry-image-link" href="' . get_permalink() . '" tabindex="-1" aria-hidden="true">' . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</a>';

	echo '<header class="entry-header">';
		echo '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
	echo '</header>';

	echo '<div class="entry-content">';
		the_excerpt();
		echo '<p><a class="read-more" href="' . get_permalink() . '" tabindex="-1" aria-hidden="true">Read More<span class="screen-reader-text"> of ' . get_the_title() . '</span></a></p>';
	echo '</div>';

echo '</article>';
