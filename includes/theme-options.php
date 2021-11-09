<?php
/**
 * Waipoua Theme Options
 *
 * @package WordPress
 * @subpackage Waipoua
 * @since Waipoua 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function waipoua_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'waipoua-theme-options', get_template_directory_uri() . '/includes/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'waipoua-theme-options', get_template_directory_uri() . '/includes/theme-options.js', array( 'farbtastic' ), '2011-04-28' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'waipoua_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our waipoua_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, waipoua_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function waipoua_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === waipoua_get_theme_options() )
		add_option( 'waipoua_theme_options', waipoua_get_default_theme_options() );

	register_setting(
		'waipoua_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'waipoua_theme_options', // Database option, see waipoua_get_theme_options()
		'waipoua_theme_options_validate' // The sanitization callback, see waipoua_theme_options_validate()
	);
}
add_action( 'admin_init', 'waipoua_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/*
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function waipoua_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'waipoua' ), // Name of page
		__( 'Theme Options', 'waipoua' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'waipoua_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns an array of layout options registered for Waipoua
/*-----------------------------------------------------------------------------------*/

function waipoua_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __( 'Posts + Sidebar', 'waipoua' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content-sidebar.png',
		),
		'content-featured-sidebar' => array(
			'value' => 'content-featured-sidebar',
			'label' => __( 'Posts + Sticky Posts Column + Sidebar', 'waipoua' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content-featured-sidebar.png',
		),
	);

	return apply_filters( 'waipoua_layouts', $layout_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Waipoua
/*-----------------------------------------------------------------------------------*/

function waipoua_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#F55243',
		'navibg_color'   => '#F55243',
		'theme_layout' => 'content-sidebar',
		'featured_headline' => '',
		'custom_logo' => '',
		'custom_footertext' => '',
		'custom_favicon' => '',
		'custom_apple_icon' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
	);

	return apply_filters( 'waipoua_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Waipoua
/*-----------------------------------------------------------------------------------*/

function waipoua_get_theme_options() {
	return get_option( 'waipoua_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Waipoua
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<h2><?php printf( __( '%s Theme Options', 'waipoua' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'waipoua_options' );
				$options = waipoua_get_theme_options();
				$default_options = waipoua_get_default_theme_options();
			?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Color', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'waipoua' ); ?></span></legend>
							 <input type="text" name="waipoua_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your custom link color (the default Link Color: %s). Do not forget to include the # before the color value.', 'waipoua' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Menu Background Color', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Menu Background Color', 'waipoua' ); ?></span></legend>
							 <input type="text" name="waipoua_theme_options[navibg_color]" value="<?php echo esc_attr( $options['navibg_color'] ); ?>" id="navibg-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'Choose your own custom main menu background color (default Background Color: %s).', 'waipoua' ), $default_options['navibg_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top" class="image-radio-option"><th scope="row"><?php _e( 'Blog Layout Option', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Blog Layout Option', 'waipoua' ); ?></span></legend>
						<?php
							foreach ( waipoua_layouts() as $layout ) {
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="waipoua_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
									<span>
										<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>"/>
										<?php echo $layout['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Sticky Posts Headline', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Sticky Posts Headline', 'waipoua' ); ?></span></legend>
							<input class="regular-text" type="text" name="waipoua_theme_options[featured_headline]" value="<?php esc_attr_e( $options['featured_headline'] ); ?>" />
						<br/><label class="description" for="waipoua_theme_options[featured_headline]"><?php _e('Customize the Sticky Posts headline on the blogs front page. Default is "Featured Posts" (for the Posts + Sticky Posts Column + Sidebar layout only).', 'waipoua'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'waipoua' ); ?></span></legend>
							<input class="regular-text" type="text" name="waipoua_theme_options[custom_logo]" value="<?php esc_attr_e( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="waipoua_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'waipoua'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'waipoua'); ?></a><?php _e('. Then copy your logo image file URL and insert the URL here.', 'waipoua'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'waipoua' ); ?></span></legend>
							<input class="regular-text" type="text" name="waipoua_theme_options[custom_favicon]" value="<?php esc_attr_e( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="waipoua_theme_options[custom_favicon]"><?php _e( 'Create a <strong>16x16px</strong> image and generate a .ico favicon using a favicon online generator. Now upload your favicon to your themes folder (via FTP) and enter your Favicon URL here (the URL path should be similar to: yourdomain.com/wp-content/themes/waipoua/favicon.ico).', 'waipoua' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Apple Touch Icon', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Apple Touch Icon', 'waipoua' ); ?></span></legend>
							<input class="regular-text" type="text" name="waipoua_theme_options[custom_apple_icon]" value="<?php esc_attr_e( $options['custom_apple_icon'] ); ?>" />
						<br/><label class="description" for="waipoua_theme_options[custom_apple_icon]"><?php _e('Create a <strong>128x128px png</strong> image for your webclip icon. Upload your image using the ', 'waipoua'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'waipoua'); ?></a><?php _e('. Now copy the image file URL and insert the URL here.', 'waipoua'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Text', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'waipoua' ); ?></span></legend>
							<textarea id="waipoua_theme_options[custom_footertext]" class="small-text" cols="120" rows="3" name="waipoua_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="waipoua_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text. Standard HTML is allowed.', 'waipoua' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for posts', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for posts', 'waipoua' ); ?></span></legend>
							<input id="waipoua_theme_options[share-posts]" name="waipoua_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="waipoua_theme_options[share-posts]"><?php _e( 'Check this box to include share buttons (for Twitter, Facebook, Google+) on your blogs front page and on single post pages.', 'waipoua' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for single post pages only', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for single post pages only', 'waipoua' ); ?></span></legend>
							<input id="waipoua_theme_options[share-singleposts]" name="waipoua_theme_options[share-singleposts]" type="checkbox" value="1" <?php checked( '1', $options['share-singleposts'] ); ?> />
							<label class="description" for="waipoua_theme_options[share-singleposts]"><?php _e( 'Check this box to include the share post buttons <strong>only</strong> on single post pages (below the post content).', 'waipoua' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for pages', 'waipoua' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for pages', 'waipoua' ); ?></span></legend>
							<input id="waipoua_theme_options[share-pages]" name="waipoua_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="waipoua_theme_options[share-pages]"><?php _e( 'Check this box to also include the share buttons on pages.', 'waipoua' ); ?></label>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function waipoua_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Main menu background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['navibg_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['navibg_color'] ) )
			$output['navibg_color'] = '#' . strtolower( ltrim( $input['navibg_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], waipoua_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// Text options must be safe text with no HTML tags
	$input['featured_headline'] = wp_filter_nohtml_kses( $input['featured_headline'] );
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );
	$input['custom_apple_icon'] = wp_filter_nohtml_kses( $input['custom_apple_icon'] );

	// checkbox values are either 0 or 1
	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );

	return $input;
}


/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function waipoua_print_link_color_style() {
	$options = waipoua_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = waipoua_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a, .entry-header h2.entry-title a:hover {color:<?php echo $link_color; ?>;}
.entry-meta a.share-btn {background:<?php echo $link_color; ?> url(<?php echo get_template_directory_uri(); ?>/images/standardicons.png) 7px -78px no-repeat;}
blockquote {border-left:6px solid <?php echo $link_color; ?>;}
input#submit, input.wpcf7-submit, .format-link .entry-content a.link, .flickr_badge_wrapper a img:hover, .jetpack_subscription_widget form#subscribe-blog input[type="submit"] {background:<?php echo $link_color; ?>;}
@media only screen and (-webkit-min-device-pixel-ratio: 2) {
.entry-meta a.share-btn {background:<?php echo $link_color; ?> url(<?php echo get_template_directory_uri(); ?>/images/x2/share-icon.png) 7px -78px no-repeat;}
}
</style>
<?php
}
add_action( 'wp_head', 'waipoua_print_link_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Main menu background color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function waipoua_print_navibg_color_style() {
	$options = waipoua_get_theme_options();
	$navibg_color = $options['navibg_color'];

	$default_options = waipoua_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['navibg_color'] == $navibg_color )
		return;
?>
<style type="text/css">
#site-nav-wrap {background:<?php echo $navibg_color; ?>;}
@media screen and (min-width: 1170px) {
#site-nav-container #s {background:<?php echo $navibg_color; ?> url(<?php echo get_template_directory_uri(); ?>/images/search-white.png) 10px 10px no-repeat;}
}
</style>
<?php
}
add_action( 'wp_head', 'waipoua_print_navibg_color_style' );


/*-----------------------------------------------------------------------------------*/
/* Adds Waipoua layout classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
function waipoua_layout_classes( $existing_classes ) {
	$options = waipoua_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar' ) ) )
		$classes = array( 'two-columns' );
	else
		$classes = array( 'three-columns' );

	$classes[] = $current_layout;

	$classes = apply_filters( 'waipoua_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'waipoua_layout_classes' );
