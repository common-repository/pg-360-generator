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
 * These file handle AJAX for Gallery page Edit , Delete and color / light control
 */

var brightness = 100,
    contrast = 100,
    grayscale = 0,
    saturate = 100,
    sepia = 0,
    opacity = 100,
    XArray = [],
    YArray = [];

(function($) {
    $(function() {

        /**
         * Color Manipulation 
         * Color Filters + Color Slider
         */

        for (let i = 0; i < pg360IdArray.length; i++) {

            //Set Current values (pass from database)
            $('div .brightness' + pg360IdArray[i]).append('<label><strong>Brightness <u style="color:orangered">' + 100 + '%</u></strong></label>');

            $('div .contrast' + pg360IdArray[i]).append('<label><strong>Contrast <u style="color:orangered">' + 100 + '%</u></strong></label>');

            $('div .grayscale' + pg360IdArray[i]).append('<label><strong>Grayscale <u style="color:orangered">' + 0 + '%</u></strong></label>');

            $('div .saturate' + pg360IdArray[i]).append('<label><strong>Saturate <u style="color:orangered">' + 100 + '%</u></strong></label>');

            $('div .sepia' + pg360IdArray[i]).append('<label><strong>Sepia <u style="color:orangered">' + 0 + '%</u></strong></label>');

            $('div .opacity' + pg360IdArray[i]).append('<label><strong>Opacity <u style="color:orangered">' + 100 + '%</u></strong></label>');

            // Set Stored Slider Values
            $('#brightness' + pg360IdArray[i]).slider({ min: 0, max: 200, value: 100, });
            $('#contrast' + pg360IdArray[i]).slider({ min: 0, max: 200, value: 100, });
            $('#grayscale' + pg360IdArray[i]).slider({ min: 0, max: 100, value: 0, });
            $('#saturate' + pg360IdArray[i]).slider({ min: 0, max: 200, value: 100, });
            $('#sepia' + pg360IdArray[i]).slider({ min: 0, max: 100, value: 0, });
            $('#opacity' + pg360IdArray[i]).slider({ min: 0, max: 100, value: 100, });

            /**
             * " Restore Default " Button
             */
            $('#pg360_restore_btn' + pg360IdArray[i]).on('click', function() {
                $('#set2' + pg360IdArray[i]).val('default');
                $("#brightness" + pg360IdArray[i]).slider('value', 100);
                $("#contrast" + pg360IdArray[i]).slider('value', 100);
                $("#grayscale" + pg360IdArray[i]).slider('value', 0);
                $("#saturate" + pg360IdArray[i]).slider('value', 100);
                $("#sepia" + pg360IdArray[i]).slider('value', 0);
                $("#opacity" + pg360IdArray[i]).slider('value', 100);
                $('.pg360_example_img ').removeClass('ClassColorFilter_BW ClassColorFilter_PGfilter1 ClassColorFilter_PGfilter2 ClassColorFilter_PGfilter3 ClassColorFilter_PGfilter4 ClassColorFilter_PGfilter5 ClassColorFilter_PGfilter6');
            });
        }


        /**-----------------------------------------------
         *                  Edit in Gallery
        --------------------------------------------------*/
        // Tabs to display inside edit thickbox js
        for (let i = 0; i < pg360IdArray.length; i++) {
            $("#pg360_tabs" + pg360IdArray[i]).tabs({ active: '#pg360_tabs-1' + pg360IdArray[i] });
        }

        $(".pg360_edit").on('click', function() {

            pg360EditClickedID = $(this).parent('div').prop('id');

            $('#pg360_form' + pg360EditClickedID).on('submit', function() {

                $.ajax({
                    url: pg360Project.edit,
                    type: "post",
                    action: 'pg360_project_edit',
                    success: function(data) {
                        tb_remove();
                        location.reload();
                    },
                    error: function() {
                        alert('Something Wrong...! contact ProdGraphy.com')
                    },

                });
            });
        });

        // Cancel Button

        $('.pg360_edit_cancel').on('click', function() {
            self.parent.tb_remove();
        });

        /** 
         * Delete in Gallery
         */
        $(".pg360_delete").on('click', function() {
                var pg360DelClickedID = $(this).parent('div').prop('id');
                pg360DelClickedID = pg360DelClickedID.substring(12, );
                if (window.confirm('You are going to delete this Project permanently') == true) {
                    $('#' + pg360DelClickedID).parent('div').hide();
                    $.ajax({
                        beforeSend: function() {
                            $(".loader").show();
                        },
                        url: pg360Project.delete,
                        type: "post",
                        data: {
                            pg360DelClickedID: pg360DelClickedID,
                            action: 'pg360_project_delete'
                        },
                        success: function() {
                            $('#' + pg360DelClickedID).parent('div').hide();
                            $('.loader').hide();
                        },

                    });
                }

            })
            /**???????????????????
             * Disable related control when disable interactive 360
             * doesn't work why?
             */
        $('#pg360_interactive').on('click', function() {
            if ($('#pg360_interactive').is(':checked')) {
                $('.interaction').prop("disabled", false);
                $('.interaction_class').css({ "color": "black" });
            } else {
                $('.interaction').prop('disabled', true);
                $('.interaction_class').css({ "color": "gray" });
            }
        })

        /******************************
         * ShortCode insertion thickbox
         ******************************/

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