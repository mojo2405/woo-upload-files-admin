<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       myapp.co.il
 * @since      1.0.0
 *
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/includes
 * @author     Eitan Shaked <eitan.shak@gmail.com>
 */
class Es_Woo_Upload_Files_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'es-woo-upload-files',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
