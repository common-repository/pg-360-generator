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
 * Setting page color picker and restore default
 */

jQuery(document).ready(function($) {

    /**
     * Color Picker for setting page
     */
    $('.pg360_color').wpColorPicker();

    /**
     * Restore Deafult setting in setting page 
     * delete all related options
     */
    $('#pg360_setting_restore_default').on('click', function() {

        if (window.confirm('Are you Sure ?! you gonna loose all your setting customization') == true) {

            $.ajax({
                action: 'pg360_restore_default_settings',
                url: pg360SettingRestore.restore,
                type: 'post',
            })
        }
    })
});