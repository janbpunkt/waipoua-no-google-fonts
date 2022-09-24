<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */

get_header(); ?>

	<div id="content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

		<nav id="nav-below" class="clearfix">
			<div class="nav-previous"><?php next_post_link( '%link', __( 'Next Post &rarr;', 'waipoua' ) ); ?></div>
			<div class="nav-next"><?php previous_post_link( '%link', __( '&larr; Previous Post', 'waipoua' ) ); ?></div>
		</nav><!-- #nav-below -->

	</div><!-- end #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>