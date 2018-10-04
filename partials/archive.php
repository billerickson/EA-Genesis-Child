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

	echo '<header class="entry-header">';
		echo '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
	echo '</header>';

	echo '<div class="entry-content">';
		the_excerpt();
	echo '</div>';

echo '</article>';
