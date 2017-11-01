<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://webcontrol.co.il
 * @since             1.0.0
 * @package           Easy_Accessibility
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Accessibility
 * Plugin URI:        http://webcontrol.co.il
 * Description:       This plugin help to make wordpress sites accessible to disabled people
 * Version:           1.0.0
 * Author:            Ram Segev
 * Author URI:        http://webcontrol.co.il
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-accessibility
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-easy-accessibility-activator.php
 */
function activate_easy_accessibility() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-accessibility-activator.php';
	Easy_Accessibility_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-easy-accessibility-deactivator.php
 */
function deactivate_easy_accessibility() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-easy-accessibility-deactivator.php';
	Easy_Accessibility_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easy_accessibility' );
register_deactivation_hook( __FILE__, 'deactivate_easy_accessibility' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-accessibility.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_accessibility() {

	$plugin = new Easy_Accessibility();
	$plugin->run();

}
run_easy_accessibility();
