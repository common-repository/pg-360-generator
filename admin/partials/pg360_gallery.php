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
 * this file for gallery preview
 */
$pg360_gallery_title='<h1>360° - Images Gallery</h1> ';
$pg360_powered='<a href="'.esc_url( 'www.prodgraphy.com').'"><u>Powered By <span style="color:orangered">Prod</span>Graphy.com</u></a>';
echo $pg360_gallery_title;
echo $pg360_powered;
echo '<p>You can customize everything in " 360° / image " just click <span class="dashicons dashicons-edit pg360_edit"></span><u style="color:#0073aa;">Edit Options</u> under every 360°</p>' ;
$pg360_genrator=new pg360_generator();
$pg360_genrator->pg360_postInsert=false;
$pg360_genrator->pg360_generate_code(); 