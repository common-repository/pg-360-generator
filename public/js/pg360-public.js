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
(function($) {
    $(function() {

        //ensure that 360 is responsive with any screen size
        $('.reel').css({ 'height': 'auto' });
        //

        /**
         * Watermark style in center of image
         */
        watermarkArray = $('.pg360_watermark');
        watermarkFontClass = $('.pg360_watermark font').prop('className');
        for (let i = 0; i < watermarkArray.length; i++) {
            // watermarkArray[i].id.prev('div').height;
            var imgDivId = $('#' + watermarkArray[i].id).prev().prop('id');
            var imgDivHeight = $('#' + imgDivId).height();
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
})(jQuery)