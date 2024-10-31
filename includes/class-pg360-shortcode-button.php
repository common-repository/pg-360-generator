<?php
/**
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 *
 * @package    pg360
 * @subpackage pg360/includes
 *
 * this class handle media button
 */
 
class pg360_gallery_shortcode_button{
    protected $pg360_ShortCode;
    protected $pg360_ShortCodes;
    protected $pg360_SelectedProject;

    public function __construct(){

        global $wpdb;
        //extract data from DB:
        $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
        $pg360_table2Name = $wpdb->prefix .'pg360_images_details';

        //check table exist (to prevent activate plugin error)
        if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table1Name'") == $pg360_table1Name) {
            
            $this->pg360_ShortCodes=$wpdb->get_results(
                "SELECT ShortCode FROM $pg360_table1Name"
            );// array contain  short codes
        
            for ($i=0; $i <count($this->pg360_ShortCodes,0) ; $i++) { 
                
                $this->pg360_ShortCode=$this->pg360_ShortCodes[$i]->ShortCode;
                add_shortcode($this->pg360_ShortCode,array($this,'pg360_shortcode_generator'));
            };         
        }
    }
    
    /** 
     * Short Code Generator
     * this function to return what shorcode represent
    */
    public function pg360_shortcode_generator($atts,$content=NULL,$tag){        
        
        $tag="'".$tag."'";
        global $wpdb;
        
        /**
         * extract data from DB:
        */
        $pg360_table1Name = $wpdb->prefix .'pg360_project_details';

        $pg360_ProjectName=$wpdb->get_var(
            "SELECT ProjectName FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project name
        
        $pg360_ProjectWidth = $wpdb->get_var(
            "SELECT ProjectWidth FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get Project width
        
        $pg360_ProjectHeight = $wpdb->get_var(
            "SELECT ProjectHeight FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get Project height

        $pg360_NoOfLayer=$wpdb->get_var(
            "SELECT NoOfLayer FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//number of layer
        
        $pg360_CursorShape=$wpdb->get_var(
            "SELECT CursorShape FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project CursorShape
        
        $pg360_Speed=$wpdb->get_var(
            "SELECT Speed FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project Speed
        
        $pg360_CW=$wpdb->get_var(
            "SELECT CW FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//inverse direction
        
        $pg360_Preloader=$wpdb->get_var(
            "SELECT Preloader FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Preloader
                
        $pg360_Interactive=$wpdb->get_var(
            "SELECT Interactive FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Interactive
        
        $pg360_Orientable=$wpdb->get_var(
            "SELECT Orientable FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Orientable
        
        $pg360_ClickFree=$wpdb->get_var(
            "SELECT ClickFree FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project ClickFree
        
        $pg360_DisableRightClick=$wpdb->get_var(
            "SELECT DisableRightClick FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project DisableRightClick
        
        $pg360_Shy=$wpdb->get_var(
            "SELECT Shy FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project Shy
        $pg360_ProjectID=$wpdb->get_var(
            "SELECT ID FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project id
        
        $pg360_wheelable = $wpdb->get_var(
            "SELECT wheelable FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//interact with mouse wheel
        
        
        $ImgColorFilter=$wpdb->get_var(
            "SELECT ColorFilter FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project color filter
        
            if ($ImgColorFilter=='BW'){
                $ClassColorFilter='ClassColorFilter_BW';
            }elseif($ImgColorFilter=='PGfilter1'){
                $ClassColorFilter='ClassColorFilter_PGfilter1';
            }elseif($ImgColorFilter=='PGfilter2'){
                $ClassColorFilter='ClassColorFilter_PGfilter2';
            }elseif($ImgColorFilter=='PGfilter3'){
                $ClassColorFilter='ClassColorFilter_PGfilter3';
            }elseif($ImgColorFilter=='PGfilter4'){
                $ClassColorFilter='ClassColorFilter_PGfilter4';
            }elseif($ImgColorFilter=='PGfilter5'){
                $ClassColorFilter='ClassColorFilter_PGfilter5';
            }elseif($ImgColorFilter=='PGfilter6'){
                $ClassColorFilter='ClassColorFilter_PGfilter6';
            }else{
                $ClassColorFilter="";
            }

        $pg360_DCB=$wpdb->get_var(
            "SELECT DisplayControlBtn FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Display Control Btn
        
        $pg360_360Type=$wpdb->get_var(
            "SELECT 360Type FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project Loop (true / false)
        
        //loop and non-loop type 
        if ($pg360_360Type=='loops'){
            $pg360_loops=true;
        }else{
            $pg360_loops=false;
        }

        /** 
         * From Image Table:
        */

        $pg360_table2Name = $wpdb->prefix .'pg360_images_details';
        
        $pg360_ProjectImages=$wpdb->get_results(
            "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI 
        
        $pg360_ProjectImagesWidth=$wpdb->get_results(
            "SELECT Width FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI    

        $pg360_ProjectImagesHeight=$wpdb->get_results(
            "SELECT Height FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI    
        

        /**
         * Check if Panorama (one image)
         * Panorama code here
         */
        if (count($pg360_ProjectImages, 0)==1){
            $data_image='data-image="'.$pg360_ProjectImages[0]->ImageURL.'" ';
            $data_frames='data-frames="'.round($pg360_ProjectImagesWidth[0]->Width).'" ';
            $data_stitched='data-stitched="'.$pg360_ProjectImagesWidth[0]->Width.'" ';
            $data_speed='data-speed="'.$pg360_Speed/100 .'" ';
            $data_width='data-width="'.$pg360_ProjectWidth/100*$pg360_ProjectImagesWidth[0]->Width.'px" ';
            $data_height='data-height="'.$pg360_ProjectHeight/100*$pg360_ProjectImagesHeight[0]->Height.'px" ';
        }else{
            /**
             * Multi images 360
             */
            $data_frames='data-frames="'.((count($pg360_ProjectImages, 0))/$pg360_NoOfLayer).'" ';
            $data_stitched='';
            $data_image='data-images="';
            $data_speed='data-speed="'.$pg360_Speed/100 .'" ';
            $data_width=' data-width="'.$pg360_ProjectWidth.'% " ';
            $data_height=' data-height="'.$pg360_ProjectHeight.'% " ';

            for ($j = 0; $j < count($pg360_ProjectImages, 0); $j++) {
                if ($j < (count($pg360_ProjectImages, 0) - 1)) {
                    $data_image.=$pg360_ProjectImages[$j]->ImageURL . ',';
                }else{
                    $data_image.=$pg360_ProjectImages[$j]->ImageURL.'" ';
                } 
            }
        }


        /**
         * Returned HTML :
        */   
        $content='<style>';
            $content.= '.reel-preloader{background:'.get_option('pg360_preloader_color','#ff4500').' !important;}';
            $content.= '.pg360_watermark{transform: rotate(-'.get_option('pg360_watermark_angle',0).'deg);color:'.get_option('pg360_watermark_color','#696969').';opacity:'.get_option('pg360_watermark_opacity',0.7).';}';
            /**
             * Style Sale Color
             */
            $content.= '.onsale {background:'.get_option('pg360_sale_color','#6ec5d5').'}';
            $content.= '.onsale-section:after {border-top: 6px solid'. get_option('pg360_sale_color','#6ec5d5').'}';
            $content.= '.onsale-section {'.get_option('pg360_sale_align','left').':15px;}';
        $content.='</style>';

        $content.= '<div class="pg360  product" id="pg360_parent'.$pg360_ProjectID.'"> ';
            $content.='<div class="pg360_pack product-image '.$overlayDivClass.'" id="'.$pg360_ProjectName.'">'; 
                
                /**
                 * 360 Hint Code
                 */
                    
                    $hint360Class='hint360Class';
                    $content.='<div class="hint360">';
                        $content.= '<div class="hint_360text" style="background-color:'.get_option('pg360_360Hint_background_color','#000000').';color:'.get_option('pg360_360Hint_color','#ffffff').';
                        "><span class="dashicons dashicons-image-rotate"></span> Drag to Rotate</div>';
                    $content.='</div>';

                /**
                 * 360 generate here
                 */
                $content.= '<img src="' . $pg360_ProjectImages[0]->ImageURL.'" ';
                    $content.= $data_width;
                    $content.= $data_height;
                    $content.= 'alt="Error Code PG360-404 :Can not find image to Display" ';
                    $content.= "class='reel ". $ClassColorFilter." ".$overlayImgClass." ".$hint360Class."' ";
                    $content.= "id='"."pg360_".$pg360_ProjectID. $pg360_ProjectName."' ";
                    $content.= $data_image;
                    $content.= $data_frames;
                    $content.= "data-rows='".($pg360_NoOfLayer)."' ";
                    $content.= "data-cw='".$pg360_CW."' ";
                    $content.= $data_speed;
                    $content.= "data-wheelable  ='". $pg360_wheelable."' ";
                    $content.= "data-cursor='".$pg360_CursorShape."' ";
                    $content.= "data-shy='" .$pg360_Shy."' ";
                    $content.= "data-clickfree='".$pg360_ClickFree."' ";
                    $content.= "data-suffix=' ' ";
                    $content.= "data-draggable='". $pg360_Interactive."' ";
                    // $content.= "data-orientable='".$pg360_Orientable."' ";
                    $content.= "data-preloader='".$pg360_Preloader."' ";
                    $content.= "data-hint='".$pg360_Hint."' ";
                    $content.= "data-loops='". $pg360_loops."' ";
                    $content.= $data_stitched;
                $content.= ">";

                /**
                 * WaterMark code
                 * code location dependent (see jquery)
                 */
                $content.= "<div class='pg360_watermark' id='pg360_watermark".$pg360_ProjectID."'>";
                    $content.="<font class=".get_option('pg360_watermark_position','center')." style='font-size:".get_option('pg360_watermark_size',50)*3 . "%'>";
                        if (get_option( 'pg360_watermark' )==''){
                            $content.="<span class='pg360_wmClass' style='color :grey;'>Powered By <span style='color:orangered'>Prod</span>Graphy.com</span>";
                        }else{
                            $content.= (get_option( 'pg360_watermark' ));     
                        }
                    $content.="</font>"; 
                $content.="</div>";//water mark                
            $content.= " </div>";//pg360_pack
        $content.= " </div>";//pg360_parent

        return ($content);
    }
    
    //Use action media_buttons
    public function pg360_button() {
        ?>
        <a href="#TB_inline?width=753&height=532&inlineId=pg360TB_content" class="button button-secondary thickbox" type="button" id="pg360-add" class="button" data-editor="content" name="Select 360° to Insert">
            <span class="dashicons dashicons-images-alt2" style="padding-top: 2px;">
            </span> 
            PG Add <span style=" font-weight:bold;">360°</span>
        </a>
        <?php
        add_thickbox();
        $this->pg360_inside_thickbox(); 
    }

    public function pg360_inside_thickbox(){
        global $wpdb;           /* z-index: 1; */

        $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
        $pg360_table2Name = $wpdb->prefix .'pg360_images_details';
        
        $pg360_ProjectNames=$wpdb->get_results(
            "SELECT ProjectName FROM $pg360_table1Name"
        );// array contain  project name

        for ($i=0; $i <count($pg360_ProjectNames,0) ; $i++) { 
            $pg360_ProjectName[$i]=$wpdb->get_var(
                "SELECT ProjectName FROM $pg360_table1Name",
                0,
                $i
            );
            if (isset($_POST[$pg360_ProjectName[$i]])){
                echo $pg360_ProjectName[$i];
            }
        };           
        ?>
        <!-- what inside the thickbox -->
        <div id="pg360TB_content" style="display:none">

            <div class="pg360_mainContent">
                <?php
                    $pg360_genrator=new pg360_generator();
                    $pg360_genrator->pg360_postInsert=true;
                    $pg360_genrator->pg360_edit_inside_thickbox=false;
                    $pg360_genrator->pg360_generate_code();
                ?>
            </div>

            <div class="pg360_bottom_toolBar">
                <div class="pg360_insert_control">
                    <input class="button button-primary " id="pg360Insert" type="submit" name="submit" value="Insert" form="chkbx_result"></input>
                    <button class="button button-primary " id="pg360Cancel">Cancel</button>            
                </div>
            </div>
        </div>

        <?php
    }

    /**
     * to use with action wp_enqueue_media
     */
    public function pg360_enqueue_shortcode_scripts(){
        
        /**
         * Styles into media button and thickbox
         */
        wp_enqueue_style( 'pg360_shortcode', plugins_url('pg-360-generator/admin/css/pg360_shortcode.css'), array(), '1', 'all' );
        wp_enqueue_style( 'pg360_gallery', plugins_url('pg-360-generator/admin/css/pg360_gallery.css'), array(), '1', 'all' );
        
        /**
         * Script into media button and thickbox
         */
        wp_enqueue_script('pg360_zoom',plugins_url('pg-360-generator/admin/js/zoom.js'), array(),'',true);

        wp_enqueue_script( 'media_button', plugins_url('pg-360-generator/admin/js/pg360_shortcode.js'), array('jquery','thickbox'),'1.0' ,true );
                    
        // load jquery v 1.9.1 in non conflict mode 
        wp_register_script( 'jquery191', plugins_url('pg-360-generator/admin/js/jquery191.js'), array(),'' ,true );
        wp_add_inline_script( 'jquery191', 'var jQuery191 = $.noConflict(true);' );

        wp_enqueue_script( 'pg360_reel', plugins_url('pg-360-generator/admin/js/jquery.reel-bundle.js'), array('jquery191','jquery'),'' ,true );

    }
} 