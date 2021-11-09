<?php
/**
 * The main template file.
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */

get_header(); ?>

<div id="content-wrap">
	<div id="content">

	<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) :
				the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; // end of the loop. ?>
			<?php endif;
			?>

		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php waipoua_content_nav( 'nav-below' ); ?>
		<?php endif; ?>

	</div><!-- end #content -->

		<?php $options = get_option('waipoua_theme_options');
			if( $options['theme_layout'] == 'content-featured-sidebar' ) : ?>

				<?php get_template_part( 'featured'); ?>

		<?php endif  ?>

</div><!-- end #content-wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
