<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              myapp.co.il
 * @since             1.0.0
 * @package           Es_Woo_Upload_Files
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Upload Files To Order
 * Plugin URI:        myapp.co.il
 * Description:       Upload any file to an existing order.
 * Version:           1.1.0
 * Author:            Eitan Shaked
 * Author URI:        myapp.co.il
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       es-woo-upload-files
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-es-woo-upload-files-activator.php
 */
function activate_es_woo_upload_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-es-woo-upload-files-activator.php';
	Es_Woo_Upload_Files_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-es-woo-upload-files-deactivator.php
 */
function deactivate_es_woo_upload_files() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-es-woo-upload-files-deactivator.php';
	Es_Woo_Upload_Files_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_es_woo_upload_files' );
register_deactivation_hook( __FILE__, 'deactivate_es_woo_upload_files' );

/**
 * The core plugin class that is used to define internationalization,
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-es-woo-upload-files.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_es_woo_upload_files() {

	$plugin = new Es_Woo_Upload_Files();
	$plugin->run();

}
run_es_woo_upload_files();
