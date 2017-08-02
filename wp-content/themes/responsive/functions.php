<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * WARNING: Please do not edit this file in any way
 *
 * load the theme function files
 */

$template_directory = get_template_directory();

//require( $template_directory . '/core/includes/functions-feedback.php' );
require( $template_directory . '/core/includes/functions.php' );
require( $template_directory . '/core/includes/functions-update.php' );
require( $template_directory . '/core/includes/functions-about.php' );
require( $template_directory . '/core/includes/functions-sidebar.php' );
require( $template_directory . '/core/includes/functions-install.php' );
require( $template_directory . '/core/includes/functions-admin.php' );
require( $template_directory . '/core/includes/functions-extras.php' );
require( $template_directory . '/core/includes/functions-extentions.php' );
require( $template_directory . '/core/includes/theme-options/theme-options.php' );
require( $template_directory . '/core/includes/functions-feedback.php' );
require( $template_directory . '/core/includes/post-custom-meta.php' );
require( $template_directory . '/core/includes/tha-theme-hooks.php' );
require( $template_directory . '/core/includes/hooks.php' );
require( $template_directory . '/core/includes/version.php' );
require( $template_directory . '/core/includes/upsell/theme-upsell.php' );
require( $template_directory . '/core/includes/customizer.php' );

// Return value of the supplied responsive free theme option.
function responsive_free_get_option( $option, $default = false ) {
	global $responsive_options;

	// If the option is set then return it's value, otherwise return false.
	if ( isset( $responsive_options[$option] ) ) {
		return $responsive_options[$option];
	}

	return $default;
}
function responsive_free_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'responsive_free_setup' );

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function responsive_free_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'responsive_free_render_title' );
endif;


function responsiveedit_customize_register( $wp_customize ){
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-name a'
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[home_headline]', array(
			'selector' => '.featured-title',
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[home_subheadline]', array(
			'selector' => '.featured-subtitle',
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[cta_text]', array(
			'selector' => '.call-to-action',
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[banner_image]', array(
			'selector' => '#featured',
	) );
$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[testimonial_title]', array(
		'selector' => '.section_title',
) );
	$wp_customize->selective_refresh->add_partial( 'nav_menu_locations[top]', array(
			'selector' => '.main-nav',
	) );

	$wp_customize->selective_refresh->add_partial( 'sidebars_widgets[home-widget-1]', array(
			'selector' => '#home_widget_1',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'sidebars_widgets[home-widget-2]', array(
			'selector' => '#home_widget_2',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'sidebars_widgets[home-widget-3]', array(
			'selector' => '#home_widget_3',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[featured_content]', array(
			'selector' => '#featured-image',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[home_content_area]', array(
			'selector' => '#featured-content p',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'responsive_theme_options[copyright_textbox]', array(
			'selector' => '.copyright',
			 
	) );
	$wp_customize->selective_refresh->add_partial( 'header_image', array(
			'selector' => '#logo',
			 
	) );

}
add_action( 'customize_register', 'responsiveedit_customize_register' );
add_theme_support( 'customize-selective-refresh-widgets' );

if( !function_exists('responsive_page_featured_image') ) :

	function responsive_page_featured_image() {
					// check if the page has a Post Thumbnail assigned to it.
					$responsive_options = responsive_get_options();
					if ( has_post_thumbnail() && 1 == $responsive_options['featured_images'] ) { ?>
						<div class="featured-image">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'responsive' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<?php	the_post_thumbnail(); ?>
							</a>
						</div>
					<?php }  
	}

endif;