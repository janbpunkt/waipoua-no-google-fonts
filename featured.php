<?php
/**
 * Displaying featured posts in extra column on the blogs front page
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */


?>

	<?php
		/**
		* Begin the featured posts section.
		*
		* See if we have any sticky posts and use them to create our featured posts.
		* We limit the featured posts at ten.
		*/
		$sticky = get_option( 'sticky_posts' );

		// Proceed only if sticky posts exist.
		if ( ! empty( $sticky ) ) :

		$featured_args = array(
			'post__in' => $sticky,
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'no_found_rows' => true,
		);

		// The Featured Posts query.
		$featured = new WP_Query( $featured_args );

		// Proceed only if published posts exist
		if ( $featured->have_posts() ) :
		?>

		<div id="featuredposts">
			<h3 class="featured-title"><?php
					$options = get_option('waipoua_theme_options');
					if($options['featured_headline'] != '' ){
						echo stripslashes($options['featured_headline']);
					} else { ?>
				<?php _e(' Featured Posts', 'waipoua') ?>
				<?php } ?></h3>

		<?php
			// Let's roll.
			while ( $featured->have_posts() ) : $featured->the_post(); ?>

				<?php get_template_part( 'content', 'featured' ); ?>

		<?php endwhile;	?>

		</div><!-- end #featuredposts -->
	<?php endif; // end check for published posts. ?>
	<?php endif; // end check for sticky posts. ?>