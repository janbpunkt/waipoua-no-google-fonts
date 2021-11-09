<?php
/**
 * The Sidebar containing the widget areas.
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */
?>

	<div id="sidebar" class="widget-area">

		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		<?php endif; // end sidebar widget area ?>

	</div><!-- #sidebar .widget-area -->