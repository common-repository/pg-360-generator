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
 *  This file handle shortcode insertion in wp editor (what inside thickbox)  
 */

(function($) {
    $(function() {

        //Cancel Button Function
        $('#pg360Cancel').click(function() {
            tb_remove();
        })

        //Insert Button Function
        $('#pg360Insert').click(function() {

            var pg360SelectedProject = $('.pg360_insert_chkbx:checked').map(function() {
                return $(this).val();
            }).get();

            if (pg360SelectedProject == "") {} else {
                for (var i = 0; i < pg360SelectedProject.length; i++) {
                    window.parent.send_to_editor('[prodgraphy-' + pg360SelectedProject[i] + ']');
                }
                tb_remove();
            }
        });

        /**
         * Watermark style in center of image
         */
        watermarkArray = $('.pg360_watermark');
        watermarkFontClass = $('.pg360_watermark font').prop('className');
        for (let i = 0; i < watermarkArray.length; i++) {
            // watermarkArray[i].id.prev('div').height;
            var imgDivId = $('#' + watermarkArray[i].id).prev().prop('id');
            var imgDivHeight = $('#' + imgDivId).height();
            var imgDivwidth = $('#' + imgDivId).height();
            if (watermarkFontClass == 'center') {
                $('#' + watermarkArray[i].id).css({
                    'bottom': imgDivHeight / 2,
                })
            } else if (watermarkFontClass == 'top') {
                $('#' + watermarkArray[i].id).css({
                    'bottom': imgDivHeight,
                })

            } else if (watermarkFontClass == 'bottom') {
                $('#' + watermarkArray[i].id).css({
                    'bottom': '2.5em',
                })

            }
        }

    });
})(jQuery);