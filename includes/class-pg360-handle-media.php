<?php
/**
 * The file Handles dropped and deleted images with wordpress ajax
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 * 
 * @package    pg360
 * @subpackage pg360/includes
 */

class pg360_handle_media{
    
    protected $project_variable; 
    
    public function pg360_handle_dropped_media() {
        
        status_header(200);      //Set HTTP status header.   
        global $wpdb;//enter DB
        $pg360_table2Name = $wpdb->prefix .'pg360_images_details'; 
        $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
        
        $upload_dir = wp_upload_dir();        
        $upload_url = $upload_dir['url'] . '/';
        $upload_base=$upload_dir['basedir'] . '/';
        $upload_base_url=content_url($upload_base);
        $num_files = count($_FILES['file']['tmp_name']);

        $newupload = 0;

        if (!empty($_FILES) ) {
            $files = $_FILES;
            
            foreach($files as $file) {
                $newfile = array (
                        'name' => $file['name'],
                        'type' => $file['type'],
                        'tmp_name' => $file['tmp_name'],
                        'error' => $file['error'],
                        'size' => $file['size'],
                );

                $_FILES = array('upload'=>$newfile);
                foreach($_FILES as $filepg360 => $array) {                    
                    $newupload = media_handle_upload( $filepg360, 0 );
                    
                    if($newupload){

                        $req= $wpdb->get_var(
                            "SELECT ID FROM $pg360_table1Name WHERE ID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
                        );// variable contain project ID to make relation with project images
                        
                        $pg360_guid= $wpdb->get_var(
                            "SELECT guid FROM wp_posts WHERE ID =$newupload"
                        );// variable contain guid from wp_posts table
        
                        $fileinfo=getimagesize($pg360_guid);//get image width-height and type
                        
                        $wpdb->insert(
                            $pg360_table2Name,
                            array( 
                                'ProjectID'=>$req,                        
                                'ImageURL' =>$pg360_guid,
                                'Width'=>$fileinfo[0],
                                'Height'=>$fileinfo[1],
                            )
                        );
        
                    }
                    
                }                
            }
        }
        //number of image per 360 update
        $NOL= $wpdb->get_var(
            "SELECT NoOfLayer FROM $pg360_table1Name WHERE ID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
        );// variable contain project number of vertical layer
        $NP360= count($wpdb->get_results(
            "SELECT ProjectID FROM $pg360_table2Name WHERE projectID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
        ),0);// variable contain image count for current project

        $wpdb->update(
            $pg360_table1Name,
            array(
                'NoPerLayer'=>($NP360/$NOL),
            ),
            array(
            'ID'=>$req
            )
        );  
        wp_die();
    }
        
    public function pg360_handle_project() {
        
        /**
         * Set Default project settings values
         */
        global $wpdb;//enter DB
        $pg360_table2Name = $wpdb->prefix .'pg360_images_details'; 
        $pg360_table1Name = $wpdb->prefix .'pg360_project_details';
        
        $ProjectName=get_option('pg360_project_name','Project');
        $PN='"'.$ProjectName.'"';
        
        $pn_query=$wpdb->query(
            " SELECT * FROM $pg360_table1Name WHERE ProjectName= $PN "
        );
        if ($pn_query){
            $pg360_LastProjectID=$wpdb->get_var(
                "SELECT ID FROM $pg360_table1Name WHERE ID =  (SELECT MAX(ID) FROM $pg360_table1Name)"
            );//variable contain last constructed project ID
            $ProjectName=$ProjectName.$pg360_LastProjectID;
        }else{
            $ProjectName=get_option('pg360_project_name','Project');            
        }
        if(get_option('pg360_display_mouse_hint',true)==true){
            $hint=get_option('pg360_mouse_hint','Powered By ProdGraphy.com');
        }else{
            $hint='Powered By <span style="color:orangered">Prod</span>Graphy.com';
        }

        $wpdb->insert( $pg360_table1Name, 
            array( 
                'ProjectName'       => $ProjectName, //handle repeated name
                'CreationTime'      => current_time('mysql'),
                'ShortCode'         => 'prodgraphy-'.$ProjectName ,                               
                'ProjectWidth'      => get_option('pg360_image_width',100),
                'ProjectHeight'     => get_option('pg360_image_height',100),
                'NoOfLayer'         => get_option('pg360_no_of_vertical_layer',1),
                'Speed'             => get_option('pg360_rotation_speed',50),
                'CursorShape'       => 'hand',
                'ColorFilter'       => 'default',
                'DisplayControlBtn' => get_option('pg360_control_button',1),
                'Interactive'       => get_option('pg360_interactive',1),
                'Orientable'        => get_option('pg360_responsive',1),
                'ClickFree'         => get_option('pg360_click_free',false),
                'CW'                => get_option('pg360_inverse',1),
                'wheelable'         => get_option('pg360_wheelable',1),
                'Shy'               => get_option('pg360_shy',false),
                'Preloader'         => get_option('pg360_loadingbar_width',2),
                '360Type'           => get_option('pg360_type360','loops'),
            )
        );    
        wp_die();
    }
            
    //The following function will take care of the uploading the image and saving as an attachment in the WordPress library.


    public function pg360_handle_deleted_media(){

        if( isset($_REQUEST['media_id']) ){
            $post_id = absint( $_REQUEST['media_id'] );

            global $wpdb;//enter DB
            $pg360_table2Name = $wpdb->prefix .'pg360_images_details'; 

            $post_URL=$wpdb->get_var(
                "SELECT guid FROM 'wp_posts' WHERE ID = $post_id"
            );

            $wpdb->query(
                'DELETE FROM $pg360_table2Name WHERE imageURI=$post_URL'
            );

            $status = wp_delete_attachment($post_id, true);
            
            if( $status )
                echo json_encode(array('status' => 'OK'));
            else
                echo json_encode(array('status' => 'FAILED'));
        }
        wp_die();
    }        
}