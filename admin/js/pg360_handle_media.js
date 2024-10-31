/**
 *
 * @link              http://ProdGraphy.com
 * @since             1.0.0
 * @package           pg360
 * @wordpress-plugin
 * Plugin Name:       360° Generator
 * Plugin URI:        http://prodgraphy.com
 * Version:           1.5.0
 * this file contain script for handling uploading media with js and drop zone js
 */

jQuery(document).ready(function($) {

    /**
     * 1st step
     * Project default value handling Ajax
     */

    // Disabling autoDiscover, otherwise Dropzone will try to attach twice.
    Dropzone.autoDiscover = false;

    $("#pg360-media-uploader").on("drop click", function() {
        $.ajax({
            url: pg360Param.update,
            type: 'post',
            action: 'pg360_handle_project',
            error: function() {
                alert('Some thing wrong contact at ProdGraphy.com');
            },
        });
    });
    /**
     * 2nd Step 
     * upload images
     */
    $("#pg360-media-uploader").dropzone({

        url: pg360Param.upload,
        acceptedFiles: 'image/*',
        success: function(file, response) {
            // $('.dz-success-mark').css({ 'text-color': 'red' });
            file.previewElement.classList.add("dz-success");
            file['attachment_id'] = response; // push the id for future reference
            var ids = $('#media-ids').val() + ',' + response;
            $('#media-ids').val(ids);
        },
        error: function(file, response) {
            file.previewElement.classList.add("dz-error");
        },
        //dropzone options
        parallelUploads: 1,
        addRemoveLinks: true,
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        dictDefaultMessage: "<a class='dzTxt'>Click or Drop Files Here to Upload<a></br><p style='color: darkred '> Arrange Image Files By Name Before Upload</p></br><button class='dzBtn'>Upload Files</button>",
        // Remove files when click remove
        removedfile: function(file) {
            var attachment_id = file.attachment_id;
            $.ajax({
                type: 'POST',
                url: pg360Param.delete,
                data: {
                    media_id: attachment_id,
                    action: 'pg360_handle_deleted_media',
                },
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    });

    /* 
     * 2nd Step
     * Ajax handle insert default values inside database
     */
    $('#pg360_next').on('click', function() {
        window.location.replace('admin.php?page=pg-360-generator%2Fadmin%2Fpartials%2Fpg360_gallery.php');
    });
});