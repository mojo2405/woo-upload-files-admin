<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       myapp.co.il
 * @since      1.0.0
 *
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/admin
 * @author     Eitan Shaked <eitan.shak@gmail.com>
 */
class Es_Woo_Upload_Files_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


	}


	/**
	 * Add metabox to admin UI
	 *
	 * @since    1.0.0
	 */
    public function es_meta_box_add()
    {
        add_meta_box( 'es_upload_files', __('Upload Files'), array($this,'es_meta_box_cb'), 'shop_order', 'side', 'high' );
    }


	/**
	 * Callback for add metabox to admin UI
	 *
	 * @since    1.0.0
	 */

    public function es_meta_box_cb()
    {
        include_once( dirname( __FILE__ ) . '/partials/es-woo-upload-files-admin-display.php' );
    }


	/**
	 * Store files in the DB and in the FS
	 *
	 * @since    1.0.0
	 */

    public function es_store_files()
    {
        global $wp_filesystem;
        $uploaded_files = [];

        if(count($_FILES['files']['name']) > 0){
            // //Loop through each file
            for($i=0; $i<count($_FILES['files']['name']); $i++) {
                //Get the temp file path
                $tmpFilePath = $_FILES['files']['tmp_name'][$i];
                // echo "Handling File ".$tmpFilePath;
                $upload = wp_upload_bits( $_FILES['files']['name'][$i], null, file_get_contents( $_FILES['files']['tmp_name'][$i] ) );
                // print_r ($upload);
                $uploaded_files[] = $upload;
            }
        }

        $images = get_post_meta( $_POST['post_id'], '_es_uploaded_files', true );
        if ($images ){
            // Update post
            $res = update_post_meta( $_POST['post_id'], '_es_uploaded_files',  array_merge($images,$uploaded_files) );
        }else{
            // Create new key to post with new data
            $res = update_post_meta( $_POST['post_id'], '_es_uploaded_files',  $uploaded_files );
        }


        // Don't forget to stop execution afterward.
        wp_die();
    }


	/**
	 * Delete files phyisically and from the DB
	 *
	 * @since    1.0.0
	 */

    public function es_delete_file()
    {
        $index = -1;
        $images = get_post_meta( $_POST['post_id'], '_es_uploaded_files', true );

        for($i=0; $i<count($images); $i++) {
            if (urldecode($images[$i]['url']) === urldecode($_POST['file'])){
                unlink($images[$i]['file']);
                $index = $i;
                break;
            }
        }
        if ($index >= 0) {
            array_splice($images, $index, 1);
            $res = update_post_meta( $_POST['post_id'], '_es_uploaded_files',  $images );
        }

        if (count($images) == 0){
            delete_post_meta( $_POST['post_id'], '_es_uploaded_files');
        }

        wp_die();
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/es-woo-upload-files-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/es-woo-upload-files-admin.js', array( 'jquery' ), $this->version, false );

	}

}
