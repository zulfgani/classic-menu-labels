<?php
/**
 * ClassicMenuLabels Customizer Class
 *
 * @package  cml
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ClassicMenuLabels_Customizer' ) ) :

	/**
	 * The ClassicMenuLabels Customizer class
	 */
	class ClassicMenuLabels_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
		}

		/**
		 * Returns an array of the desired default ClassicMenuLabels Options
		 *
		 * @return array
		 */
		public function get_cml_default_setting_values() {
			return apply_filters(
				'cml_setting_default_values', $args = array(
					'cml_text_color'			=> 'ffffff',
					'cml_background_color'		=> '13aff0',
					'cml_menu_location_name'	=> 'primary',
				)
			);
		}

		/**
		 * Adds a value to each ClassicMenuLabels setting if one isn't already present.
		 *
		 * @uses get_cml_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( $this->get_cml_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value Theme modification value.
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_cml_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter cml_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_cml_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( $this->get_cml_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since  1.0.0
		 */
		public function customize_register( $wp_customize ) {
			
			$wp_customize->add_panel( 'cml_options_panel', array(
				'title' => __( 'Classic Menu Labels Options', 'classic-menu-labels' ),
				'description' => __( 'Holds all our Classic Menu Labels settings', 'classic-menu-labels' ), // Include html tags such as <p>.
				'priority' => 10, // Mixed with top-level-section hierarchy.
			) );
			
			/**
			 * Add the Menu Location dropdown section
			 */
			$wp_customize->add_section(
				'cml_menu_location_selector', array(
					'title'    => __( 'Manu Locations', 'classic-menu-labels' ),
					'panel' => 'cml_options_panel',
					'priority' => 10,
				)
			);
			
			/**
			 * Add the Colors section
			 */
			$wp_customize->add_section(
				'cml_label_colors', array(
					'title'    => __( 'Manu Label Colors', 'classic-menu-labels' ),
					'panel' => 'cml_options_panel',
					'priority' => 50,
				)
			);

			/**
			 * Label background color
			 */
			$wp_customize->add_setting(
				'cml_background_color', array(
					'default'           => apply_filters( 'cml_background_color', '' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'cml_background_color', array(
						'label'    => __( 'Background color', 'classic-menu-labels' ),
						'section'  => 'cml_label_colors',
						'settings' => 'cml_background_color',
						'priority' => 10,
					)
				)
			);

			/**
			 * Label Text Color
			 */
			$wp_customize->add_setting(
				'cml_text_color', array(
					'default'           => apply_filters( 'cml_text_color', '#ffffff' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize, 'cml_text_color', array(
						'label'    => __( 'Text color', 'classic-menu-labels' ),
						'section'  => 'cml_label_colors',
						'settings' => 'cml_text_color',
						'priority' => 20,
					)
				)
			);
			
			/* Experimental Select Box */
			$wp_customize->add_setting( 'cml_menu_location_name', array(
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => apply_filters( 'cml_default_menu_location', 'primary' ),
			) );

			$wp_customize->add_control( 'cml_menu_location_name', array(
				'type' => 'text',
				'section' => 'cml_menu_location_selector', // Add a default or your own section
				'settings' => 'cml_menu_location_name',
				'label' => __( 'Menu Location' ),
				'description' => __( 'Please type in the menu location to apply labels to i.e. primary, secondary, menu-1.' ),
			) );

		}

		/**
		 * Get all of the ClassicMenuLabels theme mods.
		 *
		 * @return array $cml_theme_mods The ClassicMenuLabels Theme Mods.
		 */
		public function get_cml_theme_mods() {
			$cml_theme_mods = array(
				'cml_background_color'     => get_theme_mod( 'cml_background_color' ),
				'cml_text_color'           => get_theme_mod( 'cml_text_color' ),
			);

			return apply_filters( 'cml_theme_mods', $cml_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_cml_theme_mods()
		 * @return array $css the css
		 */
		public function get_css() {
			$cml_theme_mods = $this->get_cml_theme_mods();

			$css = '
			.menu-description,
			body.generik .menu-description,
			body.featherlite .menu-description,
			body.commerce.featherlite .menu-description {
				background-color: ' . $cml_theme_mods['cml_background_color'] . ';
				color: ' . $cml_theme_mods['cml_text_color'] . ';
			}

			.menu-description::after,
			body.commerce.featherlite .menu-description::after,
			body span.menu-description::after,
			body.featherlite span.menu-description::after,
			body.generik span.menu-description::after {
				border-top-color: ' . $cml_theme_mods['cml_background_color'] . ';
			}';

			return apply_filters( 'cml_customizer_css', $css );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function add_customizer_css() {
			wp_add_inline_style( 'classic-menu-labels-frontend', $this->get_css() );
		}

	}

endif;

return new ClassicMenuLabels_Customizer();
