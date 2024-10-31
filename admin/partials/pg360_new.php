<?php
/**
 *
 * @link              http://ProdGraphy.com
 * @since             1.0.0
 * @package           pg360
 *
 * @wordpress-plugin
 * Plugin Name:       360° Generator
 * Plugin URI:        http://prodgraphy.com
 * Version:           1.5.0
*/

/*
 * Ajax handle media 
 * Upload Media- Delete Media/Database record - Update Database
 */ 
$pg360Param = array(
    // Dropzone Handle
    'upload'=>admin_url( 'admin-ajax.php?action=pg360_handle_dropped_media' ),
    'delete'=>admin_url( 'admin-ajax.php?action=pg360_handle_deleted_media' ),
    // Project default values handle
    'update'=>admin_url( 'admin-ajax.php?action=pg360_handle_project' ),
);

// Localize script in this file:
wp_localize_script('pg360_handle_media','pg360Param', $pg360Param);

?>
<h1 style="text-align:center;color:#0085ba;">Create New 360° / Image</h1>
<?php
/**
 * Upload Files by Dropzone js
 */
?>
<div id="pg360Dz">
    <div id="my-awesome-dropzone" enctype="multipart/form-data" name="file" type="file">  
        <div class="fallback">    			
            <div id="pg360-media-uploader" class="dropzone">
            </div>
        </div>
        <button  class="button button-primary" id="pg360_next">Save to Gallery</button>
    </div>
</div>