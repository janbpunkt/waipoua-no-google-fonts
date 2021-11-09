<?php
/**
 * The template used for displaying page content.
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- end .entry-header -->
	
	<div class="entry-content clearfix">
		<?php the_content(); ?>
	</div><!-- end .entry-content -->

	<footer class="entry-meta">
		<ul>
			<?php // Include Share-Btns
				$options = get_option('waipoua_theme_options');
				if( $options['share-pages'] ) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>
			<li class="entry-edit"><?php edit_post_link(__( 'Edit Post &rarr;', 'waipoua') ); ?></li>
		</ul>
	</footer><!-- end .entry-meta -->

</article><!-- end post-<?php the_ID(); ?> -->