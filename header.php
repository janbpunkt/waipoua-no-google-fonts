<?php
/**
 * The themes Header file.
 *
 * Displays all of the <head> section and everything up till </header>
 *
 * @package Waipoua
 * @since Waipoua 1.0
 */
?><!DOCTYPE html>
<!--[if lte IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	$options = get_option('waipoua_theme_options');
	if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<?php
	$options = get_option('waipoua_theme_options');
	if( $options['custom_apple_icon'] != '' ) : ?>
<link rel="apple-touch-icon" href="<?php echo $options['custom_apple_icon']; ?>" />
<?php endif  ?>

<!-- HTML5 enabling script for older IE -->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php
	wp_enqueue_script('jquery');
	if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
	wp_head();
?>

</head>

<body <?php body_class(); ?>>

	<div id="site-nav-wrap" class="clearfix">
		<div id="site-nav-container">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<a href="<?php echo home_url( '/' ); ?>" id="home-btn"><?php _e('Home', 'waipoua') ?></a>
			<?php endif; ?>
			<a href="#nav-mobile" id="mobile-menu-btn"><?php _e('Menu', 'waipoua') ?></a>
			<nav id="site-nav">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				<?php get_search_form(); ?>
			</nav><!-- end #site-nav -->
		</div><!-- end #site-nav-container -->
	</div><!-- end #site-nav-wrap -->

	<div id="wrap" class="clearfix">
		<header id="header">
			<div id="branding">
				<div id="site-title">
					<?php $options = get_option('waipoua_theme_options');
						if( $options['custom_logo'] != '' ) : ?>
						<a href="<?php echo home_url( '/' ); ?>" class="logo"><img src="<?php echo $options['custom_logo']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
					<?php else: ?>
						<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php endif  ?>
				</div><!-- end #site-title -->

				<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
					<div class="header-widget-area">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</div><!-- end .header-widget-area -->
				<?php endif; ?>
			</div><!-- end #branding -->
		</header><!-- end #header -->
