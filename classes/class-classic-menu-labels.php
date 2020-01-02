<?php

defined( 'ABSPATH' ) || exit;

class ClassicMenuLabels {

	/**
	 * Path to the plugin directory
	 *
	 * @param string
	 */
	static $plugin_dir;

	/**
	 * URL to the plugin
	 *
	 * @param string
	 */
	static $plugin_url;

	// Add actions and filters to this method.
	public function __construct() {
		
		$this->add_actions();
		
		$this->add_filters();		
		
	}
	
	/**
	 * Load the plugin textdomain for localistion
	 *
	 * @since 0.1.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'classic-menu-labels', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	// A function that returns a string of custom text.
	public function classic_menu_labels_header_menu_desc($item_output, $item, $depth, $args) {
		
		$menu_name = esc_html( get_theme_mod( 'cml_menu_location_name' ) );

		if ( $menu_name === $args->theme_location && $item->description )
			$item_output = str_replace('</a>', '<span class="menu-description">' . $item->description . '</span></a>', $item_output);

		return $item_output;
		
	}
	
	public function enqueue_frontend_assets() {
		$min = SCRIPT_DEBUG ? '' : 'min.';
		wp_enqueue_style( 
			'classic-menu-labels-frontend', 
			CML_ASSETS_STYLES . 'frontend.css', 
			[], 
			CML_VERSION
		);
	}
	
	protected function add_actions() {
		
		add_action( 'init', array( $this, 'load_textdomain' ) );
		
		//add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
		
		//add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_control_assets' ] );
		//add_action( 'customize_preview_init', [ $this, 'enqueue_preview_assets' ] );
	}
	
	protected function add_filters() {
		add_filter( 'walker_nav_menu_start_el', [$this, 'classic_menu_labels_header_menu_desc'], 10, 4 );
	}

}

new ClassicMenuLabels;
