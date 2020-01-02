<?php
$theme = wp_get_theme();
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function classic_menu_labels_body_classes( $classes ) {	
	global $theme;
	
	if ( 'Susty' == $theme->name || 'susty' == $theme->template ) {
		$classes[] = 'menu-labels-for-susty';
	}
	
	return $classes;
}
add_filter( 'body_class', 'classic_menu_labels_body_classes' );


/**
 * Get Customizer css.
 *
 * @see get_cml_theme_mods()
 * @return array $css the css
 */
function cml_susty_labels_css() {
	
	$css = '
	.menu-labels-for-susty .menu-description {
		top: 22px;
		margin: 0 46px;
	}
	body.admin-bar.menu-labels-for-susty .menu-description {
		top: 56px;
	}';

	return apply_filters( 'cml_susty_menu_labels_css', $css );
}

/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.0.0
 * @return void
 */
function cml_supported_theme_css() {
	global $theme;
	if ( 'Susty' == $theme->name || 'susty' == $theme->template ) {
		wp_add_inline_style( 'classic-menu-labels-frontend', cml_susty_labels_css() );
	}
}
add_action( 'wp_enqueue_scripts', 'cml_supported_theme_css', 130 );
