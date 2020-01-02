<?php

/**
 * -----------------------------------------------------------------------------
 * Plugin Name: Classic Menu Labels
 * Description: A tiny yet big feature for any theme: Add labels to your site navigation menu(s).
 * Version: 0.0.1
 * Author: CPEngineered
 * Author URI: https://cpengineered.com
 * Plugin URI: https://cpengineered.com/plugins/classic-menu-labels
 * Text Domain: classic-menu-labels
 * Domain Path: /languages
 * -----------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.txt.
 * -----------------------------------------------------------------------------
 * Copyright © 2019 - CPEngineered
 * -----------------------------------------------------------------------------
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'CML_VERSION', '0.0.1' );

define( 'CML__FILE__', __FILE__ );
define( 'CML_PLUGIN_BASE', plugin_basename( CML__FILE__ ) );
define( 'CML_URL', plugins_url( '/', CML__FILE__ ) );
define( 'CML_PATH', plugin_dir_path( CML__FILE__ ) );
define( 'CML_INC_PATH', CML_PATH . 'includes/' );
define( 'CML_CLASSES_PATH', CML_PATH . 'classes/' );
define( 'CML_ASSETS_URL', CML_URL . 'assets/' );
define( 'CML_ASSETS_STYLES', CML_ASSETS_URL . 'styles/' );
define( 'CML_ASSETS_SCRIPTS', CML_ASSETS_URL . 'scripts/' );

/* Include the plugin class */
include_once( CML_CLASSES_PATH . 'class-classic-menu-labels.php' );

/* Include the plugin customizer */
include_once( CML_CLASSES_PATH . 'class-classic-menu-labels-customizer.php' );
include_once( CML_INC_PATH . 'cml-supported-themes-functions.php' );

/* Include the updater class */
require_once( CML_CLASSES_PATH . 'class-plugin-updater.php' );

