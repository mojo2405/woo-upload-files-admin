<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       myapp.co.il
 * @since      1.0.0
 *
 * @package    Es_Woo_Upload_Files
 * @subpackage Es_Woo_Upload_Files/admin/partials
 */

global $post;

$order = new WC_Order(get_the_ID());
$images = get_post_meta( get_the_ID(), '_es_uploaded_files', true );

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div>

    <!-- Loader -->
    <div class="loadersmall" hidden></div>

    <form>
        <div class = "col-md-6 upload-form">
            <div class= "upload-response"></div>
            <div class = "form-group">
                <label><?php _e('Select Files:'); ?></label>
                <input type = "file" name = "files[]" accept = "image/*" class = "files-data form-control" multiple id="es_input_files"/>
            </div>
            <div class = "form-group">
                <input type = "button" value = "<?php _e('Upload'); ?>" class = "button button-primary btn-upload" disabled id="es_submit_files"/>
            </div>
        </div>
    </form>
    <div id= "es_images" >
        <?php if ( $images && count($images) > 0 ) : foreach ( $images as $image ){  ?>
            <div>
                <a class="es-delete-img" href="#" title="<?php _e('Delete File'); ?>"><i class="fa fa-close fa-2x"></i></a>
                <a href="<?php echo $image['url'] ?>" target="_blank">
                    <img src="<?php echo $image['url'] ?>" height="50%" width="50%"/>
                </a>
            </div>
        <?php  } endif; ?>
    </div>


</div>

<script type="text/javascript">

    // When the Delete button is clicked...
    jQuery('body').on('click', '.es-delete-img', function(e){
        e.preventDefault;
        jQuery(".loadersmall").show();
        var fd = new FormData();
        var file_data = jQuery(this).next()[0].href; // The <input type="file" /> field
        fd.append('file', file_data);

        // our AJAX identifier
        fd.append('action', 'delete_file');

        // Remove this code if you do not want to associate your uploads to the current page.
        fd.append('post_id', <?php echo $post->ID; ?>);

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                //$('.upload-response').html(response); // Append Server Response
                e.srcElement.parentNode.parentNode.innerHTML = '';
                //location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                alert(thrownError);
            }
        }).done(function( data ) {
            jQuery(".loadersmall").hide();

        });
    });

    // When the Upload button is clicked...
    jQuery('body').on('click', '.upload-form .btn-upload', function(e){
        e.preventDefault;
        jQuery(".loadersmall").show();
        var fd = new FormData();
        var files_data = jQuery('.upload-form .files-data'); // The <input type="file" /> field

        // Loop through each data and create an array file[] containing our files data.
        jQuery.each(jQuery(files_data), function(i, obj) {
            jQuery.each(obj.files,function(j,file){
                fd.append('files[' + j + ']', file);
            })
        });

        // our AJAX identifier
        fd.append('action', 'store_files');

        // Remove this code if you do not want to associate your uploads to the current page.
        fd.append('post_id', <?php echo $post->ID; ?>);

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                //$('.upload-response').html(response); // Append Server Response
                jQuery('.upload-response').html('<?php _e('Upload finised. refreshing...'); ?>');
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                alert(thrownError);
            }
        }).done(function( data ) {
            jQuery(".loadersmall").hide();

        });
    });




</script>