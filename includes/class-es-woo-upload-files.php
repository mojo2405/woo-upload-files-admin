<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across the admin area.
 *
 * @link       myapp.co.il
 * @since      1.0.0
 *
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/includes
 * @author     Eitan Shaked <eitan.shak@gmail.com>
 */
class Es_Woo_Upload_Files {
	
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Es_Woo_Upload_Files_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct () {
		if ( defined ( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'es-woo-upload-files';
		
		$this->load_dependencies ();
		$this->set_locale ();
		$this->define_admin_hooks ();
		
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Es_Woo_Upload_Files_Loader. Orchestrates the hooks of the plugin.
	 * - Es_Woo_Upload_Files_i18n. Defines internationalization functionality.
	 * - Es_Woo_Upload_Files_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies () {
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path ( dirname ( __FILE__ ) ) . 'includes/class-es-woo-upload-files-loader.php';
		
		
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path ( dirname ( __FILE__ ) ) . 'includes/class-es-woo-upload-files-i18n.php';
		
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path ( dirname ( __FILE__ ) ) . 'admin/class-es-woo-upload-files-admin.php';
		
		
		$this->loader = new Es_Woo_Upload_Files_Loader();
		
	}
	
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Es_Woo_Upload_Files_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale () {
		
		$plugin_i18n = new Es_Woo_Upload_Files_i18n();
		
		$this->loader->add_action ( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
		
	}
	
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks () {
		
		$plugin_admin = new Es_Woo_Upload_Files_Admin( $this->get_plugin_name (), $this->get_version () );
		
		$this->loader->add_action ( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action ( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// File handling
		$this->loader->add_action ( 'wp_ajax_store_files', $plugin_admin, 'es_store_files' );
		$this->loader->add_action ( 'wp_ajax_delete_file', $plugin_admin, 'es_delete_file' );
		
		// UI
		$this->loader->add_action ( 'add_meta_boxes', $plugin_admin, 'es_meta_box_add' );
		
		
	}
	
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run () {
		$this->loader->run ();
	}
	
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name () {
		return $this->plugin_name;
	}
	
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Es_Woo_Upload_Files_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader () {
		return $this->loader;
	}
	
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version () {
		return $this->version;
	}
	
}
