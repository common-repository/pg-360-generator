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
//This file for making settings page(main setting page) 
$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';

$pg360SettingRestore = array(
	'restore'=> admin_url('admin-ajax.php?action=pg360_restore_default_settings'),
);
wp_localize_script('pg360_setting', 'pg360SettingRestore', $pg360SettingRestore);

$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';// menu slug
$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $pg360_general_setting;  
?>
<div class="wrap">
    <div class="head">
		<h1><strong>
			<span style="color:#ff4500">Prod</span>Graphy 360&deg; General Settings
        </strong></h1>
	</div>
	<?php
	/**
	 * Setting page tabs
	 * WordPress class nav-tab-wrapper do work for you like below
	 */
	?>
	<h2 class="nav-tab-wrapper">  
		
		<a href="?page=<?php echo $pg360_general_setting;?>&tab=tab_one" class="nav-tab <?php echo $active_tab == 'tab_one' ? 'nav-tab-active' : ''; ?>">Default Options</a>  
		
		<a href="?page=<?php echo $pg360_general_setting;?>&tab=tab_two" class="nav-tab <?php echo $active_tab == 'tab_two' ? 'nav-tab-active' : ''; ?>">View Options</a>  
		
		<a href="?page=<?php echo $pg360_general_setting;?>&tab=tab_three" class="nav-tab <?php echo $active_tab == 'tab_three' ? 'nav-tab-active' : ''; ?>">HotSpot Options</a>  
		
		<a href="?page=<?php echo $pg360_general_setting;?>&tab=tab_four" class="nav-tab <?php echo $active_tab == 'tab_four' ? 'nav-tab-active' : ''; ?>">Other Options</a>  

	</h2> 

	<form method="POST" action="options.php" enctype="multipart/form-data" >
		
		<?php 
  
		/**
		 * Check Active tab to display appropriate options
		 */
		
		if ($active_tab == 'tab_one'){

			// Default Values
			settings_fields( 'pg360_default_settings' );
			do_settings_sections( $pg360_general_setting.'&tab=tab_one' );  //pass slug name of page + tab

		}else if($active_tab == 'tab_two'){ 
			// View Setting
			settings_fields( 'pg360_view_settings' );
			do_settings_sections( $pg360_general_setting.'&tab=tab_two' );

		}else if($active_tab == 'tab_three'){
			settings_fields( 'pg360_ann_settings' );
			do_settings_sections( $pg360_general_setting.'&tab=tab_four' );

		}else if($active_tab == 'tab_four'){			
			// E-commerce setting
			settings_fields( 'pg360_commerce_settings' );
			do_settings_sections( $pg360_general_setting.'&tab=tab_three' );

		}else{
			settings_fields( 'pg360_default_settings' );
			do_settings_sections( $pg360_general_setting.'&tab=tab_one' ); 

		}

		// do_settings_sections( $pg360_general_setting.'&tab=tab_one' );  //pass slug name of page
		echo '<button class="button button-secondary" id="pg360_setting_restore_default" disabled>Restore Default Settings</button>';
			
		echo '<button type="submit" name="submit" class="button button-primary" id="submit" value="Save Changes" disabled>Save Changes</button>';
		?>
	</form>
</div>