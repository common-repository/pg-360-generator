<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pg360
 * @subpackage Pg360/admin
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string        The ID of this plugin.
	 */
	private $pg360_generator;
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $pg360_version;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string           The name of this plugin.
	 * @param      string        The version of this plugin.
	 */
	public function __construct( $pg360_generator, $pg360_version ) {
		
		$this->pg360_generator = $pg360_generator;
		$this->pg360_version = $pg360_version;

	}
		
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function pg360_enqueue_styles($hook_suffix) {
		
		// Create new page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_new.php') {
						
			wp_enqueue_style('dropzone',plugin_dir_url( __FILE__ ) . 'css/pg360_dropzone.css',array(), $this->pg360_version, 'all' );
		
		}
		
		// Help page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_help.php') {
			wp_enqueue_style( 'ui_style', plugin_dir_url( __FILE__ ) . 'css/pg360_ui.css', array(), $this->pg360_version, 'all' );
			wp_enqueue_style( 'pg360_gallery', plugin_dir_url( __FILE__ ) . 'css/pg360_help.css', array(), $this->pg360_version, 'all' );
			
		}

		// Gallery page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_gallery.php') {
			
			wp_enqueue_style( 'pg360_gallery', plugin_dir_url( __FILE__ ) . 'css/pg360_gallery.css', array(), $this->pg360_version, 'all' );

			wp_enqueue_style( 'ui_style', plugin_dir_url( __FILE__ ) . 'css/pg360_ui.css', array(), $this->pg360_version, 'all' );

		}

		// Setting page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_setting.php') {

			wp_enqueue_style( 'pg360_setting', plugin_dir_url( __FILE__ ) . 'css/pg360_setting.css', array(), $this->pg360_version, 'all' );
			
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function pg360_enqueue_scripts($hook_suffix) {
		
		// create new page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_new.php') {
			
			wp_enqueue_script( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'js/pg360-admin.js', array( 'jquery' ), $this->pg360_version, true );
						
			wp_enqueue_script('pg360_dropzone',plugin_dir_url( __FILE__ ) . 'js/dropzone.min.js', array('jquery'),$this->pg360_version,true);
			
			wp_enqueue_script('pg360_handle_media',plugin_dir_url( __FILE__ ) . 'js/pg360_handle_media.js',array('jquery'),$this->pg360_version,true);
			
		}
		
		// help page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_help.php') {
			
		}

		// gallery page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_gallery.php') {

			wp_enqueue_script('jquery');
			wp_enqueue_script('pg360_gallery',plugin_dir_url( __FILE__ ) . 'js/pg360_gallery.js', array('jquery','jquery-ui-tabs','jquery-ui-slider','thickbox'),$this->pg360_version,true);
			// load jquery v 1.9.1 in non conflict mode 
			wp_register_script('jquery191',plugin_dir_url( __FILE__ ) . 'js/jquery191.js', array(),'',true);
			wp_add_inline_script( 'jquery191', 'var jQuery191 = $.noConflict(true);' );
	
			wp_enqueue_script('pg360_reel',plugin_dir_url( __FILE__ ) . 'js/jquery.reel-bundle.js', array('jquery','jquery191'),'',true);
			
			wp_enqueue_script('pg360_zoom',plugin_dir_url( __FILE__ ) . 'js/zoom.js', array(),'',true);
			
			wp_enqueue_script( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'js/pg360-admin.js', array( 'jquery'), $this->pg360_version, true );

		}

		// setting page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_setting.php') {
			wp_enqueue_script( 'pg360_setting', plugin_dir_url( __FILE__ ) . 'js/pg360_setting.js', array( 'jquery','wp-color-picker' ), $this->pg360_version, true );			
		}	
		
	}

	// Create Menu Pages    
	public function pg360_menu() {
		
		$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';
		$pg360_create_new='/pg-360-generator/admin/partials/pg360_new.php';
		$pg360_help='/pg-360-generator/admin/partials/pg360_help.php';
		$pg360_gallery='/pg-360-generator/admin/partials/pg360_gallery.php';

		add_menu_page('pg360_admin_menu','360° Generator','manage_options',$pg360_create_new,'',plugins_url('pg-360-generator/images/PG20.png'),10);

			add_submenu_page($pg360_create_new,'Add 360° ','Add 360°','manage_options',$pg360_create_new);
			
			add_submenu_page($pg360_create_new,'360° Gallery','360° Gallery','manage_options',$pg360_gallery);				

			add_submenu_page($pg360_create_new,'360° Settings','Settings','manage_options',$pg360_general_setting);		
			
			add_submenu_page($pg360_create_new,'360° help','Help/Feedback','manage_options',$pg360_help);	
	}

	/*--------------------------------------------------------------
	 *					Handle setting page :
	---------------------------------------------------------------*/
	public function pg360_main_setting(){
		$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';


		

		$arg=array(
			'class'	=>'pg360_setting',
		);
		/**---------------------------------------------------
		 * 					Setting Section
		------------------------------------------------------*/
		//project form default Setting Section
		add_settings_section('pg360_default_project_settings_section','Default Options for 360° / Images', 'pg360_default_project_settings_section_cb', $pg360_general_setting.'&tab=tab_one' );
		
		function pg360_default_project_settings_section_cb(){
			echo'<div class="pg360_disable_overlay" >';
				echo'<a href="http://www.prodgraphy.com" class="pg360_disable_overlay_text">Available Only With Premium Plugin</a>';
			echo'</div>';
			echo '<p>Modify this section to change the default 360° / Images Options for all future 360° / images in order to minimize edit each image /360° options, 
			 Remember that you can individually change every 360° / Images options from " Gallery " Page and <strong><span class="dashicons dashicons-edit pg360_edit"></span>Edit Options </strong>under each single 360° /image </p>';
		}
		
		//View Setting Section
		add_settings_section('pg360_view_settings_section','View  Settings', 'pg360_setting_section_cb', $pg360_general_setting.'&tab=tab_two' );
		
		function pg360_setting_section_cb(){
			echo'<div class="pg360_disable_overlay" >';
				echo'<a href="http://www.prodgraphy.com" class="pg360_disable_overlay_text">Available Only With Premium Plugin</a>';
			echo'</div>';

			echo '<p>this section include advanced setting to adjust your 360° as you like to see </p>';
		}
		
		//e-Commerce Setting Section
		add_settings_section('pg360_eCommerce_settings_section','E-Commerce Settings', 'pg360_eCommerce_settings_section_cb', $pg360_general_setting.'&tab=tab_three' );
		
		function pg360_eCommerce_settings_section_cb(){
			echo'<div class="pg360_disable_overlay" >';
				echo'<a href="http://www.prodgraphy.com" class="pg360_disable_overlay_text">Available Only With Premium Plugin</a>';
			echo'</div>';

			echo '<p>this section include advanced setting to adjust your e-commerce as you like to see in your website</p>';
		}
		//Annotation Section
		add_settings_section('pg360_annotation_settings_section','HotSpot Settings', 'pg360_annotation_settings_section_cb', $pg360_general_setting.'&tab=tab_four' );
		
		function pg360_annotation_settings_section_cb(){
			echo'<div class="pg360_disable_overlay" >';
				echo'<a href="http://www.prodgraphy.com" class="pg360_disable_overlay_text">Available Only With Premium Plugin</a>';
			echo'</div>';

			echo '<p>this section include advanced setting to adjust your HotSpot as you like to see in your website</p>';
		}

		/**---------------------------------------------------
		 * 					Setting Field
		------------------------------------------------------*/
		/**
		 * project form default Setting Section
		 */
		//Project Name
		add_settings_field('pg360_project_name','Default Project Name','pg360_project_name_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_project_name_cb(){
			echo '<input id="pg360_project_name" name="pg360_project_name"  type="text" placeholder="Default Project Name" value="'.get_option('pg360_project_name','Project').'" pattern="[A-Za-z0-9]{1,15}" title="Invalid input, only accept letters and/or numbers with no spaces and maximum length 15 character" Required disabled/><p class="description" id="all-content-desc">Type here default 360° / image name </p><p class="description" id="all-content-desc">(Only accept letters and/or numbers with no spaces and maximum length 15 character)</p>';
		}

		//Project width
		add_settings_field('pg360_image_width','Default Image Width %','pg360_image_width_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_image_width_cb(){
			echo '<input id="pg360_image_width" name="pg360_image_width"  type="number" placeholder="Image Width %" min="10" max="100" step="5" value="'.get_option('pg360_image_width',100).'" disabled/><p class="description" id="all-content-desc"> % from original width</p>';
		}

		//project height
		add_settings_field('pg360_image_height','Default Image height %','pg360_image_height_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_image_height_cb(){
			echo '<input id="pg360_image_height" name="pg360_image_height"  type="number" placeholder="Image height %" min="10" max="100" step="5" value="'.get_option('pg360_image_height',100).'" disabled/><p class="description" id="all-content-desc"> % from original height</p>';
		}
		// Rotation Speedget_option('pg360_type360','loops')
		add_settings_field('pg360_rotation_speed','Default Rotation Speed','pg360_rotation_speed_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_rotation_speed_cb(){
			echo '<input id="pg360_rotation_speed" name="pg360_rotation_speed"  type="number" min="0" max="1" step="0.1" value="'.get_option('pg360_rotation_speed',50).'" disabled/>';
		}

		//Loading bar width pixel
		add_settings_field('pg360_loadingbar_width','Default Loading bar thickness','pg360_loadingbar_width_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_loadingbar_width_cb(){
			echo '<input id="pg360_loadingbar_width" name="pg360_loadingbar_width"  type="number" min="1" max="10" step="1" value="'.get_option('pg360_loadingbar_width',2).'" disabled/>';
		}

		// NO of vertical layers
		add_settings_field('pg360_no_of_vertical_layer','Default number of vertical layer','pg360_no_of_vertical_layer_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_no_of_vertical_layer_cb(){
			echo '<input id="pg360_no_of_vertical_layer" name="pg360_no_of_vertical_layer"  type="number" min="1" max="15" step="1" value="'.get_option('pg360_no_of_vertical_layer',1).'" disabled/>';
		}
		
		// 360 Type
		add_settings_field('pg360_type360','360 Type','pg360_type360_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_type360_cb(){
			echo '<select name="type_360" disabled>' ; 
	
			if (get_option('pg360_type360','loops')=='loops'){
				echo "<option value='loops' selected> Loop 360</option>";
				echo "<option value='non-loop' > non Loop 360</option>";
			}else{
				echo "<option value='loops' > Loop 360</option>";
				echo "<option value='non-loop' selected > non Loop 360</option>";
			}
			echo '</select>' ; 
		}

		// Interactive
		add_settings_field('pg360_interactive','Interactive','pg360_interactive_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_interactive_cb(){
			if (get_option('pg360_interactive',1)==true){
				echo '<input id="pg360_interactive" name="pg360_interactive"  type="checkbox" value="'.get_option('pg360_interactive',1).'" checked disabled/><p class="description" id="all-content-desc">Default Interactive with user mouse drag/move or touch/move</p>';
			}else{
				echo '<input id="pg360_interactive" name="pg360_interactive"  type="checkbox" value="'.get_option('pg360_interactive',1).'" disabled/><p class="description" id="all-content-desc">Default Interactive with user mouse drag/move or touch/move</p>';
			}
		}

		// Responsive
		add_settings_field('pg360_responsive','Responsive ','pg360_responsive_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_responsive_cb(){
			if(get_option('pg360_responsive',1)==true){
				echo '<input id="pg360_responsive" name="pg360_responsive"  type="checkbox" value="'.get_option('pg360_responsive',1).'" checked disabled/><p class="description" id="all-content-desc">Default responsive / interactive with Gyroscopic devices like Mobile , tablet ,....</p>';
			}else{
				echo '<input id="pg360_responsive" name="pg360_responsive"  type="checkbox" value="'.get_option('pg360_responsive',1).'" disabled/><p class="description" id="all-content-desc">Default responsive with Gyroscopic devices like Mobile , tablet ,....</p>';
			}
		}

		// Click Free
		add_settings_field('pg360_click_free','Click Free','pg360_click_free_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_click_free_cb(){
			if (get_option('pg360_click_free',0)==true){
				echo '<input id="pg360_click_free" name="pg360_click_free"  type="checkbox" value="true" checked disabled/><p class="description" id="all-content-desc">responsive with mouse hover (user not have to click and drag)</p>';
			}else{
				echo '<input id="pg360_click_free" name="pg360_click_free"  type="checkbox" value="false" disabled/><p class="description" id="all-content-desc">responsive with mouse hover (user not have to click and drag)</p>';
			}
		}

		// Control Button display
		add_settings_field('pg360_control_button','Display Control Button','pg360_control_button_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_control_button_cb(){
			if(get_option('pg360_control_button',1)==true){
				echo '<input id="pg360_control_button" name="pg360_control_button"  type="checkbox" value="true" checked disabled/><p class="description" id="all-content-desc">Default display control button (play ,pause , zoom,...)</p>';	
			}else{
				echo '<input id="pg360_control_button" name="pg360_control_button"  type="checkbox" value="false" disabled/><p class="description" id="all-content-desc">Default display control button (play ,pause , zoom,...)</p>';
			}
		}
		// Shy
		add_settings_field('pg360_shy','Load /Rotate After Click','pg360_shy_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_shy_cb(){
			if(get_option('pg360_shy',0)==true){
				echo '<input id="pg360_shy" name="pg360_shy"  type="checkbox" value="true" checked disabled/><p class="description" id="all-content-desc">Make your 360° only load /rotate after user click on</p>';
			}else{
				echo '<input id="pg360_shy" name="pg360_shy"  type="checkbox" value="false" disabled/><p class="description" id="all-content-desc">Make your 360° only load /rotate after user click on</p>';
			}
		}

		// Inverse Rotation Direction
		add_settings_field('pg360_inverse','Inverse rotation Direction','pg360_inverse_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_inverse_cb(){
			if(get_option('pg360_inverse',1)==true){
				echo '<input id="pg360_inverse" name="pg360_inverse"  type="checkbox" value="true" checked disabled/><p class="description" id="all-content-desc">use to inverse the rotation direction</p>';
			}else{
				echo '<input id="pg360_inverse" name="pg360_inverse"  type="checkbox" value="false" disabled/>';
			}
		}

		// Wheelable
		add_settings_field('pg360_wheelable','Interact with Mouse Wheel','pg360_wheelable_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		
		function pg360_wheelable_cb(){
			if(get_option('pg360_wheelable',1)==true){
				echo '<input id="pg360_wheelable" name="pg360_wheelable"  type="checkbox" value="true" checked disabled/>';
			}else{
				echo '<input id="pg360_wheelable" name="pg360_wheelable"  type="checkbox" value="false" disabled/>';
			}
		}

		// Disable Right Click
		add_settings_field('pg360_DRC','Disable Right Click','pg360_DRC_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		function pg360_DRC_cb(){
			if(get_option('pg360_DRC',0)==true){
				echo '<input id="pg360_DRC" name="pg360_DRC"  type="checkbox" value="true" checked disabled/><p class="description" id="all-content-desc">Check to disable right click menu appear over your 360° / image</p>';

			}else{
				echo '<input id="pg360_DRC" name="pg360_DRC"  type="checkbox" value="false" disabled/><p class="description" id="all-content-desc">Check to disable right click menu appear over your 360° / image</p>';
			}
		}
		// Mouse Hint
		add_settings_field('pg360_mouse_hint','Display Mouse Hint','pg360_mouse_hint_cb',$pg360_general_setting.'&tab=tab_one','pg360_default_project_settings_section',$arg);
		
		function pg360_mouse_hint_cb(){	
			if (get_option('pg360_display_mouse_hint',true)==true){		
				echo '<input id="pg360_display_mouse_hint" name="pg360_display_mouse_hint"  type="checkbox" checked disabled/>';
			}else{
				echo '<input id="pg360_display_mouse_hint" name="pg360_display_mouse_hint"  type="checkbox" disabled/>';
			}
			
			echo '<input id="pg360_mouse_hint" name="pg360_mouse_hint"  type="text" placeholder="Mouse Hint Text" value="'.get_option('pg360_mouse_hint','Powered By ProdGraphy.com').'" disabled/>';
		 }
 		// 360 Hint
		 add_settings_field('pg360_360Hint','Display 360° Hint','pg360_360Hint_cb',$pg360_general_setting,'pg360_default_project_settings_section',$arg);
		
		 function pg360_360Hint_cb(){
			 if (get_option('pg360_display_360Hint',true)==true){		
				echo '<input id="pg360_display_360Hint" name="pg360_display_360Hint"  type="checkbox" checked  disabled/>';
			 }else{
				echo '<input id="pg360_display_360Hint" name="pg360_display_360Hint"  type="checkbox" disabled/>';
			 }
			 echo '<input id="pg360_360Hint" name="pg360_360Hint"  type="text" placeholder="Mouse Hint Text" value="'.get_option('pg360_360Hint','Drag to Rotate').'" disabled/>';
		  }
		 

		/**
		 * View settings
		 */
		
		 //360_Watermark
		add_settings_field('pg360_wm','Display Water Mark','pg360_setting_watermark_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_setting_watermark_cb(){	
			if (get_option('pg360_watermark_chkbox',true)==false){
				
				echo '<input id="pg360_watermark_chkbox" name="pg360_watermark_chkbox" type="checkbox"  value="1"disabled/>';
			}else{
				echo '<input id="pg360_watermark_chkbox" name="pg360_watermark_chkbox" type="checkbox" value="1" checked disabled/>';
			}	
			
			echo '<input id="pg360_watermark" name="pg360_watermark"  type="text" placeholder="Water Mark Text" value="'.get_option('pg360_watermark','Powered By ProdGraphy.com').'" disabled/>';
		}
		
		// Watermark Color
		add_settings_field('pg360_watermark_color','Watermark Color','pg360_watermark_color_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);

		function pg360_watermark_color_cb(){
			echo '<input id="pg360_watermark_color" name="pg360_watermark_color"  class="pg360_color"  value="'.get_option('pg360_watermark_color','#696969').'" disabled/>';
		}
		
		//watermark size
		add_settings_field('pg360_wm_size','Water Mark Size ','pg360_setting_watermark_size_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_setting_watermark_size_cb(){
			echo '<input id="pg360_watermark_size" name="pg360_watermark_size"  type="number" min="1" max="100" value="'.get_option('pg360_watermark_size',50).'" disabled/><p class="description" id="all-content-desc" >Watermark size % from image width)</p>';	
		}
		//watermark Position
		add_settings_field('pg360_wm_position','Water Mark Position ','pg360_setting_watermark_position_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);

		function pg360_setting_watermark_position_cb(){
			
			echo '<select id="pg360_watermark_position" name="pg360_watermark_position" disabled>';
				if (get_option('pg360_watermark_position','center')=='top'){
					echo '<option value="top" selected>Top</option>';
				}else{
					echo '<option value="top">Top</option>';
				}
				if (get_option('pg360_watermark_position','center')=='center'){
					echo '<option value="center" selected>Center</option>';
				}else{
					echo '<option value="center">Center</option>';
				}
				if (get_option('pg360_watermark_position','center')=='bottom'){
					echo '<option value="bottom" selected>Bottom</option>';
				}else{
					echo '<option value="bottom">Bottom</option>';
				}
		  	echo '</select>'; 
		  }
		
		//watermark Opacity
		add_settings_field('pg360_wm_opacity','Water Mark opacity','pg360_setting_watermark_opacity_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);

		function pg360_setting_watermark_opacity_cb(){
			echo '<input id="pg360_watermark_opacity" name="pg360_watermark_opacity"  type="number" min="0" max="1" step="0.1" value="'.get_option('pg360_watermark_opacity',0.5).'" disabled/><p class="description" id="all-content-desc" >Watermark Opacity value ( 0 : 1 )</p>';	
		}
		
		//watermark angel
		add_settings_field('pg360_wm_angle','Water Mark Angle (Degree)','pg360_setting_watermark_angle_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_setting_watermark_angle_cb(){
			echo '<input id="pg360_watermark_angle" name="pg360_watermark_angle"  type="number" min="0" max="180"  value="'.get_option('pg360_watermark_angle',0).'" disabled/>';	
		}

		//Control buttons color
		add_settings_field('pg360_ctl_btn_color','Control Button Color','pg360_setting_ctlcolor_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_setting_ctlcolor_cb(){
			
			echo '<input id="pg360_ctl_btn_color" class="pg360_color" name="pg360_ctl_btn_color" value="'.get_option('pg360_ctl_btn_color','#696969').'" disabled/>';
			
			//example show changes
			echo '<div class="pg360_setting_ctrlbtn ">';
				echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#696969" ) . '; background-color:'.get_option('pg360_ctl_background_color','#FFFFFF').';"'.'disabled>';
				echo '<span class="dashicons dashicons-arrow-left pg360_btn"></span>';
				echo '</button>';

				echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#696969" ) . '; background-color:'.get_option('pg360_ctl_background_color','#FFFFFF').';"'.'disabled>';
				echo '<span class="dashicons dashicons-controls-play pg360_btn"></span>';
				echo '</button>';
				
				echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#696969" ) . '; background-color:'.get_option('pg360_ctl_background_color','#FFFFFF').';"'.'disabled>';
				echo '<span class="dashicons dashicons-controls-pause pg360_btn"></span>';
				echo '</button>';

				echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#696969" ) . '; background-color:'.get_option('pg360_ctl_background_color','#FFFFFF').';"'.'disabled>';
				echo '+<span class="dashicons dashicons-search pg360_btn"></span>';
				echo '</button>';

				echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#696969" ) . '; background-color:'.get_option('pg360_ctl_background_color','#FFFFFF').';"'.'disabled>';
				echo '<span class="dashicons dashicons-arrow-right pg360_btn"></span>';
				echo '</button>';

			echo '</div>';
		}
		
		//Control Buttons Background Color
		add_settings_field('pg360_ctl_background_color','Control Button Background Color','pg360_setting_ctl_backcolor_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_setting_ctl_backcolor_cb(){
			echo '<input id="pg360_ctl_background_color" name="pg360_ctl_background_color" class="pg360_color" value="'.get_option('pg360_ctl_background_color','#FFFFFF').'" disabled/>';
		}
		
		// 360 Pre-loader Color
		add_settings_field('pg360_preloader_color','Pre-loader Color','pg360_preloader_color_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);
		
		function pg360_preloader_color_cb(){
			echo '<input id="pg360_preloader_color" name="pg360_preloader_color"  class="pg360_color"  value="'.get_option('pg360_preloader_color','#ff4500').'" disabled/>';
		}
		
		// 360 hint text color
		add_settings_field('pg360_360Hint_color','Text Color-360 Hint ','pg360_360Hint_color_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);

		function pg360_360Hint_color_cb(){
			echo '<input id="pg360_360Hint_color" name="pg360_360Hint_color"  class="pg360_color"  value="'.get_option('pg360_360Hint_color','#ffffff').'" disabled/>';
		}
		
		// 360 hint background color
		add_settings_field('pg360_360Hint_background_color','Background Color-360 Hint ','pg360_360Hint_background_color_cb',$pg360_general_setting.'&tab=tab_two','pg360_view_settings_section',$arg);

		function pg360_360Hint_background_color_cb(){
			echo '<input id="pg360_360Hint_background_color" name="pg360_360Hint_background_color"  class="pg360_color"  value="'.get_option('pg360_360Hint_background_color','#000000').'" disabled/>';
		}
		 
		/**
		 * e-Commerce settingpg360_annotation_background_color
		 */
		
		 //Sale Align
		add_settings_field('pg360_sale_align','Sale Align','pg360_sale_align_cb',$pg360_general_setting.'&tab=tab_three','pg360_eCommerce_settings_section',$arg);

		function pg360_sale_align_cb(){
			echo '<select id="pg360_sale_align" name="pg360_sale_align" disabled>';
				if (get_option('pg360_sale_align','left')=='right'){
					echo '<option value="right" selected>Right</option>';
				}else{
					echo '<option value="right">Right</option>';
				}
				if (get_option('pg360_sale_align','left')=='left'){
					echo '<option value="left" selected>Left</option>';
				}else{
					echo '<option value="left">Left</option>';
				}
				echo '</select>'; 
		}
		
		//Sale color
		add_settings_field('pg360_sale_color','Sale Color','pg360_sale_color_cb',$pg360_general_setting.'&tab=tab_three','pg360_eCommerce_settings_section',$arg);
		
		function pg360_sale_color_cb(){
			echo '<input id="pg360_sale_color" name="pg360_sale_color"  class="pg360_color"  value="'.get_option('pg360_sale_color','#6ec5d5').'" disabled/>';
		}

		/**
		 * Annotation Setting 
		 */
		
		 // annotation view
		add_settings_field('pg360_annotation_view','HotSpot Default View','pg360_annotation_view_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');

		function pg360_annotation_view_cb(){
			
			echo '<select name="pg360_annotation_view" disabled>' ; 
	
			if (get_option('pg360_annotation_view','')==''){
				echo "<option value='' selected> Latent</option>";
				echo "<option value='1' > Explicit</option>";
			}else{
				echo "<option value='' > Latent</option>";
				echo "<option value='1' selected> Explicit</option>";
			}
			echo '</select><p class="description" id="all-content-desc">Default HotSpot View option (Can change individually for each HotSpot during adding HotSpot)</p>' ;
		} 
		/**
		 * Annotation Display
		 * 0 click
		 * 1 hover
		 */
		add_settings_field('pg360_annotation_display','HotSpot Default Display on','pg360_annotation_display_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');

		function pg360_annotation_display_cb(){
			
			echo '<select name="pg360_annotation_display" disabled>' ; 
	
			if (get_option('pg360_annotation_display','')==''){
				echo '<option value="1" >Hover</option>';
				echo '<option value="" selected>Click</option>';
			}else{
				echo '<option value="1" selected>Hover</option>';
				echo '<option value="" >Click</option>';
			}
			echo '</select><p class="description" id="all-content-desc">Default HotSpot Display on hover or on click</p>' ;
		} 

		//icon color
		add_settings_field('pg360_annotation_icon_color','HotSpot Icon Color','pg360_annotation_icon_color_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section',$arg);

		function pg360_annotation_icon_color_cb(){
			echo '<input id="pg360_annotation_icon_color" name="pg360_annotation_icon_color"  class="pg360_color"  value="'.get_option('pg360_annotation_icon_color','orangered').'" disabled/>';
		}
				
		//annotation title size
		add_settings_field('pg360_annotation_title_size','HotSpot Title Size','pg360_annotation_title_size_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');
		function pg360_annotation_title_size_cb(){
			echo '<input id="pg360_annotation_title_size" name="pg360_annotation_title_size"  type="number" step="0.5" min="0.5" max="100" value="'.get_option('pg360_annotation_title_size',1).'" disabled/><p class="description" id="all-content-desc">only in case of " latent " HotSpot Type</p>';	
		}
		// Annotation Title Color 
		add_settings_field('pg360_annotation_title_color','HotSpot Title Color','pg360_annotation_title_color_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');

		function pg360_annotation_title_color_cb(){
			echo '<input id="pg360_annotation_title_color" name="pg360_annotation_title_color"  class="pg360_color"  value="'.get_option('pg360_annotation_title_color','white').'" disabled/>';
		}
		
		// Annotation text size
		add_settings_field('pg360_annotation_text_size','HotSpot Icon / Text Size','pg360_annotation_text_size_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');
		function pg360_annotation_text_size_cb(){
			echo '<input id="pg360_annotation_text_size" name="pg360_annotation_text_size"  type="number" step="0.5" min="0.5" max="100" value="'.get_option('pg360_annotation_text_size',1).'" disabled/><p class="description" id="all-content-desc">Relative to the font-size of the page (2 means 2 times the size of the current font) </p>';	
		}
		
		// Annotation Text Color 
		add_settings_field('pg360_annotation_text_color','HotSpot Text Color','pg360_annotation_text_color_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');
		
		function pg360_annotation_text_color_cb(){
			echo '<input id="pg360_annotation_text_color" name="pg360_annotation_text_color"  class="pg360_color"  value="'.get_option('pg360_annotation_text_color','orangered').'" disabled/>';
		}
		
		// Latent box background color
		add_settings_field('pg360_annotation_background_color','HotSpot Background Color','pg360_annotation_background_color_cb',$pg360_general_setting.'&tab=tab_four','pg360_annotation_settings_section');
		
		function pg360_annotation_background_color_cb(){
			echo '<input id="pg360_annotation_background_color" name="pg360_annotation_background_color"  class="pg360_color"  value="'.get_option('pg360_annotation_background_color','#000000').'" disabled/><p class="description" id="all-content-desc">in case of latent HotSpot option ( with opacity 0.7 )</p>';
		}

	}
}