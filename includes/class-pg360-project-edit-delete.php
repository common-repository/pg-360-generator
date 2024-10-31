<?php
/**
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 *
 * @package    pg360
 * @subpackage pg360/includes
 *
 * This class handle Edit/Delete Project in Gallery
 */
class pg360_project_edit_delete{

    /**
     * Edit 360 
    */  
    public function pg360_project_edit(){
        
        if ( ($_SERVER["REQUEST_METHOD"] == "POST") &&! empty($_POST) ){            

            $pg360_projectID_toEdit=$_POST['ToEditID'];//hidden input value pass 360 ID to edit
        
            // form DB Work
            global $wpdb;
            $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
            
            /**
             * collect Edited values:
            */

            if (isset($_POST['ProjectName'])){            
                
                //Check if project name exist or not:
                $pg360_name="'".sanitize_text_field($_POST['ProjectName'])."'";
                
                $pn_query=$wpdb->query(
                    "SELECT * FROM $pg360_table1Name WHERE ProjectName=$pg360_name AND ID <> $pg360_projectID_toEdit"
                );
    
                if ($pn_query){
                    $ProjectName=sanitize_text_field($_POST['ProjectName'].$pg360_projectID_toEdit);
                }else{
                    $ProjectName=sanitize_text_field($_POST['ProjectName']);
                } 
            }
            if (isset($_POST['Width'])):
                $Width=$_POST['Width'];
            endif;

            if (isset($_POST['Height'])):
                $Height=$_POST['Height'];
            endif;
            

            if (isset($_POST['NoOfLayer'])):
                $NoOfLayer=$_POST['NoOfLayer'];
            endif;
            
            if (isset($_POST['Speed'])):
                $Speed=$_POST['Speed'];
            endif;
            
            if(isset($_POST['CursorShape'])):
                $CursorShape=$_POST['CursorShape'];
            endif;
            
            if(isset($_POST['ColorFilter'])):
                $ColorFilter=$_POST['ColorFilter'];
            endif;

            if (isset ($_POST['Preloader'])):
                $Preloader=$_POST['Preloader'];
            endif;

            if (isset($_POST['Draggable'])){
                $Interactive=true;
            }else{
                $Interactive=false;
            }

            if (isset($_POST['Orientable'])){
                $Orientable=true;
            }else{
                $Orientable=false;
            }

            if (isset($_POST['ClickFree'])){
                $ClickFree=true;
            }else{
                $ClickFree=false;
            }

            if (isset($_POST['CW'])){
                $CW=true;
            }else{
                $CW=false;
            }

            if (isset($_POST['Shy'])){
                $Shy=true;
            }else{
                $Shy=false;
            }

            if (isset($_POST['wheelable'])){
                $wheelable=$_POST['wheelable'];
            }
            
            if (isset($_POST['type_360'])){
                $pg360Type=$_POST['type_360'];
            }else{
                $pg360Type=true;

            }
            $data=array(
                'ProjectName'       => $ProjectName,
                'ShortCode'         => ('prodgraphy-'.$ProjectName), 
                'CreationTime'      => current_time('mysql'),                 
                'ProjectWidth'      => $Width,
                'ProjectHeight'     => $Height,
                'NoOfLayer'         => $NoOfLayer,
                'CursorShape'       => $CursorShape,
                'ColorFilter'       => $ColorFilter,
                'Speed'             => $Speed,                
                'Preloader'         => $Preloader,
                'Interactive'       => $Interactive,                
                'Orientable'        => $Orientable,                
                'ClickFree'         => $ClickFree,                
                'CW'                => $CW,  
                'wheelable'         =>$wheelable,              
                'Shy'               => $Shy,  
                '360Type'           =>$pg360Type,              
            );
            $data=stripslashes_deep($data);
            
            $where=array(
                'ID'=>$pg360_projectID_toEdit,
            );

            $updated=$wpdb->update($pg360_table1Name,$data,$where);
        }
            wp_die();
    }
    
    /**
     *  Delete 360 
    */
    public function pg360_project_delete(){
        
        if (isset($_POST['pg360DelClickedID'])) {
            $pg360_projectID_toDel=$_POST['pg360DelClickedID'];

            global $wpdb;
            $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
            $pg360_table2Name = $wpdb->prefix .'pg360_images_details'; 

            $pg360_ProjectImages=$wpdb->get_results(
                "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_projectID_toDel "
            );// array contain last project all URI 
            for ($i=0; $i < count($pg360_ProjectImages,0); $i++) { 
                $img_guid="'".$pg360_ProjectImages[$i]->ImageURL."'";
                $att_ID= $wpdb->get_var(
                    "SELECT ID FROM wp_posts WHERE guid=$img_guid" 
                );  
                wp_delete_attachment( $att_ID, true );        
            }
            $wpdb->query(
                "DELETE FROM $pg360_table1Name WHERE `ID` = $pg360_projectID_toDel"
            );  
        }
    }
    /**
     * Setting Restore Default 
     */
    public function pg360_restore_default_settings(){
        
        delete_option('pg360_project_name');
		delete_option('pg360_image_width');
		delete_option('pg360_image_height');
		delete_option('pg360_rotation_speed');
		delete_option('pg360_loadingbar_width');
		delete_option('pg360_no_of_vertical_layer');
		delete_option('pg360_interactive');
		delete_option('pg360_responsive');
		delete_option('pg360_click_free');
		delete_option('pg360_control_button');
		delete_option('pg360_inverse');
		delete_option('pg360_shy');		
		delete_option('pg360_DRC');
		delete_option('pg360_watermark_chkbox');
		delete_option('pg360_watermark');
		delete_option('pg360_watermark_color');
		delete_option('pg360_watermark_size');
		delete_option('pg360_watermark_angle');			
		delete_option('pg360_watermark_opacity');					
		delete_option('pg360_ctl_btn_color');
		delete_option('pg360_ctl_background_color');		
		delete_option('pg360_preloader_color');		
        delete_option('pg360_watermark_position');
        delete_option('pg360_sale_color');	
        delete_option('pg360_sale_align' );	
        delete_option('pg360_360Hint' );		
        delete_option('pg360_360Hint_color' );
        delete_option('pg360_360Hint_background_color' );		
        delete_option('pg360_type360' );
        delete_option('pg360_annotation_text_color');
        delete_option('pg360_annotation_icon_color');
        delete_option('pg360_annotation_text_size');
        delete_option('pg360_display_mouse_hint');
        delete_option('pg360_mouse_hint');
        delete_option('pg360_display_360Hint');
        delete_option('pg360_wheelable');
        delete_option('pg360_annotation_view');
        delete_option('pg360_annotation_background_color');
        delete_option('pg360_annotation_title_size');
		delete_option('pg360_annotation_title_color');

    }
    /**
     * Function Handle add new annotation
     */
    public function pg360_add_annotation(){
        
        if ( ($_SERVER["REQUEST_METHOD"] == "POST") &&! empty($_POST) ){            
            
            if(isset($_POST['ToAnnId'])){
                $ToAnnId=$_POST['ToAnnId'];
            }//from js

            if (isset($_POST['data_x'])){
                $Xo=$_POST['data_x'];
            }else{
                $Xo=0;
            }

            if(isset($_POST['data_xMax'])){
                $XoMax=$_POST['data_xMax'];
            }else{
                $XoMax=1;
            }

            if(isset($_POST['data_y'])){
                $Yo=$_POST['data_y'];
            }else{
                $Yo=0;
            }

            if(isset($_POST['data_yMax'])){
                $YoMax=$_POST['data_yMax'];
            }else{
                $YoMax=1;
            }


            if (isset($_POST['annotation_type'])){
                $annotation_type=$_POST['annotation_type'];
            }else{
                $annotation_type='hotSpot'; 
            }
            if (isset($_POST['annotation_text'])){
                $annotation_text=sanitize_text_field($_POST['annotation_text']);
            }else{
                $annotation_text='bad ya hema';
            }

            if (isset($_POST['annotation_url'])){
                $annotation_url=$_POST['annotation_url'];
                
                if($annotation_url==null){
                    $annotation_url='#';
                }
            }else{
                $annotation_url='#';
            }

            if (isset($_POST['XArray'])){
                $XArray=$_POST['XArray'];
            }else{
                $XArray=0;
            }

            if (isset($_POST['YArray'])){
                $YArray=$_POST['YArray'];
            }else{
                $YArray=0;
            }
            
            if (isset($_POST['annotation_title'])){
                $annotation_title=sanitize_text_field($_POST['annotation_title']);
            }else{
                $annotation_title='';
            }
            
            if (isset($_POST['annotation_view'])){
                $annotation_view=$_POST['annotation_view'];
            }else{
                $annotation_view=0;
            }
            
            if (isset($_POST['annotation_display'])){
                $annotation_display=$_POST['annotation_display'];
            }else{
                $annotation_display=1;
            }

            global $wpdb;
            $pg360_table3Name = $wpdb->prefix .'pg360_annotation_details';

            $wpdb->insert( $pg360_table3Name,
                array(
                    'Project360ID'  => $ToAnnId,
                    'AnnotationTitle'=> $annotation_title,
                    'AnnotationText'=> $annotation_text,
                    'AnnotationIcon'=> $annotation_type,
                    'AnnotationUrl' => $annotation_url,
                    'XoMax'         => $XoMax,
                    'YoMax'         => $YoMax,
                    'XArray'        => $XArray,
                    'YArray'        => $YArray,
                    'AnnotationView'=> $annotation_view,
                    'AnnotationDisplay'=>$annotation_display,
                )
            );
        }
        wp_die();
    }
    /**
     * function Handle delete annotation
     */
    public function pg360_delete_annotation(){
        if ( ($_SERVER["REQUEST_METHOD"] == "POST") &&! empty($_POST) ){            
            if (isset($_POST['AnnIdToDel'])){
                
                $AnnIdToDel=$_POST['AnnIdToDel'];
                global $wpdb;
                $pg360_table3Name = $wpdb->prefix .'pg360_annotation_details';
                $wpdb->query(
                    "DELETE FROM $pg360_table3Name WHERE `AnnotationID` = $AnnIdToDel"
                );  
    
            }
        }
    }

    /**
     * 
     */
    public function pg360_delete_all_annotation(){
        if(isset($_POST['projectIdToDelAllAnn'])){
            $projectIdToDelAllAnn=$_POST['projectIdToDelAllAnn'];
            global $wpdb;
            $pg360_table3Name = $wpdb->prefix .'pg360_annotation_details';
            $wpdb->query(
                "DELETE FROM $pg360_table3Name WHERE `Project360ID` = $projectIdToDelAllAnn"
            );  

        }   
    }
}
