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
class pg360_generator{

    public $pg360_postInsert = false;
    public $pg360_edit_inside_thickbox=true;

    public function pg360_generate_code(){
        
        //loader circle to be displayed when deleting project
        echo '<div class="loader"></div>';
        
        /**
         * Localize scripts to activate Ajax
         */
        $pg360Project = array(
            'edit'              => admin_url('admin-ajax.php?action=pg360_project_edit'),
            'delete'            => admin_url('admin-ajax.php?action=pg360_project_delete'),

        );
        wp_localize_script('pg360_gallery', 'pg360Project', $pg360Project);

        global $wpdb;
        //Database Tables:
        $pg360_table1Name = $wpdb->prefix . 'pg360_project_details';
        $pg360_table2Name = $wpdb->prefix . 'pg360_images_details';

        $pg360_projectNo = $wpdb->query(
            "SELECT ID FROM $pg360_table1Name"
        );//Number of project to display
        
        $pg360IdArray=$wpdb->get_results(
            "SELECT ID FROM $pg360_table1Name",
            ARRAY_N
        );//array contain all projects ID 
        
        wp_localize_script('pg360_gallery', 'pg360IdArray', $pg360IdArray);
    
        add_thickbox();

        /** 
         * Generator for loop 
         * generate all 360 exist in database
        */
        for ($i = 0; $i <$pg360_projectNo; $i++) {
            
            $pg360_ProjectID[$i] = $wpdb->get_var(
                "SELECT ID FROM $pg360_table1Name",
                0,
                $i
            );//get project ID

            $pg360_ProjectImages[$i] = $wpdb->get_results(
                "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
            );// array contain last project all URl 
            
            /**
             * ensure not empty project created without any photo inside
             */
            if (count($pg360_ProjectImages[$i],0)!==0){

                $pg360_ProjectName[$i] = sanitize_text_field($wpdb->get_var(
                    "SELECT ProjectName FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                ));//get Project Name

                $pg360_ProjectWidth[$i] = $wpdb->get_var(
                    "SELECT ProjectWidth FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"            
                );//get Project width

                $pg360_ProjectHeight[$i] = $wpdb->get_var(
                    "SELECT ProjectHeight FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get Project height

                $pg360_NoOfLayer[$i] = $wpdb->get_var(
                    "SELECT NoOfLayer FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//number of layer

                $pg360_CursorShape[$i] = $wpdb->get_var(
                    "SELECT CursorShape FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project CursorShape

                $pg360_Speed[$i] = $wpdb->get_var(
                    "SELECT Speed FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project Speed

                $pg360_CW[$i] = $wpdb->get_var(
                    "SELECT CW FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//inverse direction
                $pg360_wheelable[$i] = $wpdb->get_var(
                    "SELECT wheelable FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//interact with mouse wheel

                $pg360_Preloader[$i] = $wpdb->get_var(
                    "SELECT Preloader FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Preloader thickness
                
                $pg360_Interactive[$i] = $wpdb->get_var(
                    "SELECT Interactive FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Interactive

                $pg360_DCB[$i] = $wpdb->get_var(
                    "SELECT DisplayControlBtn FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Display control button option

                $ImgColorFilter[$i]=$wpdb->get_var(
                    "SELECT ColorFilter FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project color filter
                
                if ($ImgColorFilter[$i]=='BW'){
                    $ClassColorFilter[$i]='ClassColorFilter_BW';
                }elseif($ImgColorFilter[$i]=='PGfilter1'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter1';
                }elseif($ImgColorFilter[$i]=='PGfilter2'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter2';
                }elseif($ImgColorFilter[$i]=='PGfilter3'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter3';
                }elseif($ImgColorFilter[$i]=='PGfilter4'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter4';
                }elseif($ImgColorFilter[$i]=='PGfilter5'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter5';
                }elseif($ImgColorFilter[$i]=='PGfilter6'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter6';
                }else{
                    $ClassColorFilter[$i]="";
                }
                $pg360_Orientable[$i] = $wpdb->get_var(
                    "SELECT Orientable FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Orientable
                
                $pg360_ClickFree[$i] = $wpdb->get_var(
                    "SELECT ClickFree FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project ClickFree
                
                $pg360_Shy[$i] = $wpdb->get_var(
                    "SELECT Shy FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project Shy
                
                $pg360_saleText[$i]=sanitize_text_field($wpdb->get_var(
                    "SELECT saleText FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                ));//Project sale text
                
                $pg360_overlay[$i]=$wpdb->get_var(
                    "SELECT overlay FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project overlay (true /false)

                if ($pg360_overlay[$i]==true){
                    $overlayDivClass="overlayDivClass";
                    $overlayImgClass="overlayImgClass";
                        
                }else{
                    $overlayDivClass="";
                    $overlayImgClass="";
                }
                
                $pg360_overlayText[$i]=sanitize_text_field($wpdb->get_var(
                    "SELECT overlayText FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                ));//Project overlay text            

                $pg360_display_360Hint[$i]=$wpdb->get_var(
                    "SELECT Display360Hint FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//display 360 hint (true/false)
                $pg360_360Hint[$i]=sanitize_text_field($wpdb->get_var(
                    "SELECT 360Hint FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                ));//Project 360 hint text
                

                $pg360_360Type[$i]=$wpdb->get_var(
                    "SELECT 360Type FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project Loop (true / false)
                
                //loop and non-loop type 
                if ($pg360_360Type[$i]=='loops'){
                    $pg360_loops=true;
                }else{
                    $pg360_loops=false;
                }
                
                $pg360_ProjectImagesWidth[$i] = $wpdb->get_results(
                    "SELECT Width FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
                );// array contain project width   
                
                $pg360_ProjectImagesHeight[$i] = $wpdb->get_results(
                    "SELECT Height FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
                );// array contain project height  
                
                /*-------------------------------------
                *      Generate Gallery Page
                ----------------------------------------*/
                // Style of Color Control
                echo '<style>';
                echo '.reel-preloader{background:'.get_option('pg360_preloader_color','#ff4500').' !important;}';
                echo '.pg360_watermark{transform: rotate(-'.get_option('pg360_watermark_angle',0).'deg);color:'.get_option('pg360_watermark_color','#696969').';opacity:'.get_option('pg360_watermark_opacity',0.7).';}';
                
                /**
                 * Style Sale Color
                 */
                echo '.onsale {background:'.get_option('pg360_sale_color','#6ec5d5').'}';
                echo '.onsale-section:after {border-top: 6px solid'. get_option('pg360_sale_color','#6ec5d5').'}';
                echo '.onsale-section {'.get_option('pg360_sale_align','left').':15px;}';
                echo'</style>';
                ?>
                <div class="pg360 <?php echo $class_DRC ?> product" id="pg360_parent<?php echo $pg360_ProjectID[$i];?>">
                    <div class="pg360_pack product-image <?php echo $overlayDivClass ?>" id="<?php echo $pg360_ProjectName[$i]; ?>"> 
                        <?php 
                        /**
                         * 360 Hint
                         */
                            $hint360Class='hint360Class';
                            echo '<div class="hint360">';
                                echo '<div class="hint_360text" style="background-color:'.get_option('pg360_360Hint_background_color','#000000').';color:'.get_option('pg360_360Hint_color','#ffffff').';
                                "><span class="dashicons dashicons-image-rotate"></span>Drag to Rotate </div>';
                            echo '</div>';

                        /**
                         * Check if Panorama (one image)
                         * Panorama code here
                         */
                        if (count($pg360_ProjectImages[$i], 0)==1){
                            $data_image='data-image='.$pg360_ProjectImages[$i][0]->ImageURL;
                            $data_frames='data-frames="'.round($pg360_ProjectImagesWidth[$i][0]->Width).'"';
                            $data_stitched='data-stitched='.$pg360_ProjectImagesWidth[$i][0]->Width;
                            $data_speed='data-speed='.$pg360_Speed[$i]/100;
                        }else{
                            /**
                             * Multi images 360
                             */
                            $data_frames='data-frames='.((count($pg360_ProjectImages[$i], 0))/$pg360_NoOfLayer[$i]);
                            $data_stitched='';
                            $data_image='data-images=';
                            $data_speed='data-speed='.$pg360_Speed[$i]/100;

                            for ($j = 0; $j < count($pg360_ProjectImages[$i], 0); $j++) {
                                if ($j < (count($pg360_ProjectImages[$i], 0) - 1)) {
                                    $data_image.=$pg360_ProjectImages[$i][$j]->ImageURL . ',';
                                }else{
                                    $data_image.=$pg360_ProjectImages[$i][$j]->ImageURL;
                                } 
                            }
                        }
                        ?>
                        <img 
                            src             ='<?php echo $pg360_ProjectImages[$i][0]->ImageURL; ?>'
                            width           ='<?php echo $pg360_ProjectWidth[$i]/100 * $pg360_ProjectImagesWidth[$i][0]->Width; ?>'
                            height          ='<?php echo $pg360_ProjectHeight[$i] /100 * $pg360_ProjectImagesHeight[$i][0]->Height; ?>'
                            alt             ='Error Code PG360-404 :Can not find image to Display'
                            class           ='reel  <?php echo $ClassColorFilter[$i] .' ' .$overlayImgClass .' '.$hint360Class;?> '
                            id              ='<?php echo 'pg360_'.$pg360_ProjectID[$i].$pg360_ProjectName[$i];?>'
                            <?php echo $data_image . ' '; ?>
                            <?php echo $data_frames.' '; ?>
                            data-rows       ='<?php echo ($pg360_NoOfLayer[$i] ); ?>'
                            data-cw         ='<?php echo $pg360_CW[$i]; ?>'
                            <?php echo $data_speed.' ';?>
                            data-cursor     ='<?php echo $pg360_CursorShape[$i]; ?>'
                            data-shy        ='<?php echo $pg360_Shy[$i]; ?>'
                            data-clickfree  ='<?php echo $pg360_ClickFree[$i]; ?>'
                            data-suffix     =''
                            data-wheelable  ='<?php echo $pg360_wheelable[$i]; ?>'
                            data-draggable  ='<?php echo $pg360_Interactive[$i]; ?>'
                            data-orientable ='<?php echo $pg360_Orientable[$i]; ?>'
                            data-preloader  ='<?php echo $pg360_Preloader[$i]; ?>'
                            data-hint       ='<?php echo $pg360_Hint[$i]; ?>'
                            data-loops      ='<?php echo $pg360_loops; ?>'
                            <?php echo $data_stitched;?>
                        > 
                        <?php
                        /**
                         * WaterMark
                         */
                        ?>
                        <div class="pg360_watermark" id="<?php echo 'pg360_watermark'. $pg360_ProjectID[$i]; ?>">
                            <font class="<?php echo get_option('pg360_watermark_position','center') ?>" style='font-size: <?php echo (get_option('pg360_watermark_size',50)*3 . "%" )?> '>
                                <?php
                                    echo '<span style="color :grey;">Powered By <span style="color:orangered"> Prod</span>Graphy.com</span>';               
                                ?>
                            </font> 
                        </div>

                        <?php
                        
                        /**
                         *  Control Buttons Play-Pause-Full Screen
                         */
                        if ($pg360_DCB[$i]==TRUE){                    
                        ?>
                            <div class="pg360_control">
                                <div  id='pg360_control' class="<?php echo 'pg360_'.$pg360_ProjectID[$i].$pg360_ProjectName[$i];?>">
                                
                                    <button  class="pg360_btn_previous pg360_control_btn" style="color:<?php echo  get_option( 'pg360_ctl_btn_color', '#696969' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#FFFFFF');?>; ">
                                        <span class="dashicons dashicons-arrow-left pg360_btn"></span>       
                                    </button>

                                    <button  class="pg360_btn_play pg360_control_btn" style="color:<?php echo  get_option( 'pg360_ctl_btn_color', '#696969' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#FFFFFF');?>; ">
                                        <span class='dashicons dashicons-controls-play pg360_btn'></span> 
                                    </button>
                                    
                                    <button  class="pg360_btn_pause pg360_control_btn" style=" color:<?php echo  get_option( 'pg360_ctl_btn_color', '#696969' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#FFFFFF');  ?>;">
                                        <span class='dashicons dashicons-controls-pause pg360_btn'></span> 
                                    </button>
                                    
                                    <button  class="pg360_btn_fullscreen pg360_control_btn" style="color:<?php echo  get_option( 'pg360_ctl_btn_color', '#696969' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#FFFFFF');  ?>;">
                                        +<span class='dashicons dashicons-search pg360_btn'></span> 
                                    </button>
                                    
                                    <button  class="pg360_btn_next pg360_control_btn" style="color:<?php echo  get_option( 'pg360_ctl_btn_color', '#696969' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#FFFFFF');?>; ">
                                        <span class="dashicons dashicons-arrow-right pg360_btn"></span>       
                                    </button>
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                    </div>
                    <?php
                    /**
                     * Display Project Name inside gallery page only
                     */
                    ?>
                    <div class="pg360_name">
                        <strong><?php echo $pg360_ProjectName[$i] ?></strong>
                    </div>

                    <?php
                    /**
                     * Select checkbox to insert 360 into post or page
                     */
                    if ($this->pg360_postInsert == true) {
                        ?>
                        <form name="chkbx_result" action="">
                            <input type="checkbox" name="<?php echo $pg360_ProjectName[$i]; ?>" class="pg360_insert_chkbx" value="<?php echo $pg360_ProjectName[$i]; ?>"> 
                            <strong>Select</strong>
                        </form>
                    <?php
                    } 
                    if ($this->pg360_edit_inside_thickbox==true){
                        /**
                         * Edit Options ThickBox
                         */
                        ?>
                        <div class="edit_Parent" id="<?php echo $pg360_ProjectID[$i];?>">
                            <span class="dashicons dashicons-edit pg360_edit"></span>
                            <a href="#TB_inline?width=753&height=532&inlineId=<?php echo 'pg360-thickbox-edit'.$pg360_ProjectID[$i];?>" class="thickbox pg360_edit" name="<strong style='color:orangered'>Edit 360° / Image</strong>">
                            Edit Options
                            </a>
                            <br/>                     
                            <div id="<?php echo 'pg360-thickbox-edit'.$pg360_ProjectID[$i];?>" style="display:none;">
                                <?php 
                                /**
                                 * Thickbox content for Edit Options
                                 */ 
                                ?>  
                                <iframe name="pg360fake" class="pg360fake"></iframe>
                                <div class="pg360_edit_div">
                                    <form method="post" class="pg360_form"  target="pg360fake" action="admin-ajax.php?action=pg360_project_edit" name="<?php echo 'pg360_form'.$pg360_ProjectID[$i];?>" id="<?php echo 'pg360_form'.$pg360_ProjectID[$i];?>">
                            
                                        <input type="hidden" name='ToEditID' value='<?php echo $pg360_ProjectID[$i];?>'>

                                        <div id="<?php echo 'pg360_tabs'.$pg360_ProjectID[$i];?>" >
                                            <ul>
                                                <li><a href="<?php echo '#pg360_tabs-1'.$pg360_ProjectID[$i];?>"><strong> General </strong> </a></li>
                                                <li><a href="<?php echo '#pg360_tabs-2'.$pg360_ProjectID[$i];?>"><strong> Color / Light Control</strong> </a></li>
                                                <li><a href="<?php echo '#pg360_tabs-3'.$pg360_ProjectID[$i];?>"><strong> 360 Options </strong></a></li>
                                                <li><a href="<?php echo '#pg360_tabs-4'.$pg360_ProjectID[$i];?>"><strong> E-Commerce Options </strong></a></li>
                                            </ul>
                                            <?php
                                            /**
                                             * 1st Tab
                                             * Image & Color Options
                                             */
                                            ?>
                                            <div id="<?php echo 'pg360_tabs-1'.$pg360_ProjectID[$i];?>" >
                                        
                                                <div class="pg360-field">
                                                    <label for="ProjectName" class="input_label_tab1">    
                                                        <strong>360° Name <span style="color:darkred">*</span></strong>
                                                    </label>
                                                    <input class="pg360_text_input" type="text" name="ProjectName" placeholder="360&deg; Project Name" pattern="[A-Za-z0-9]{1,15}" title="Invalid input, only accept letters and/or numbers with maximum length 15 character" value="<?php echo $pg360_ProjectName[$i]; ?>" Required>
                                                    <p class="description" id="all-content-desc">(Accept letters And/Or numbers without any spaces and maximum length 15 character)</p>
                                                </div>

                                                <div class="pg360-field ">
                                                    <label for="Height" class="input_label_tab1">
                                                        <strong>Image Height %</strong> 
                                                    </label>                        
                                                    <input class="user_input" type="number" name="Height" value="<?php echo $pg360_ProjectHeight[$i]; ?>" min="10" max="100" step="1">
                                                </div>
                                            
                                                <div class="pg360-field ">
                                                    <label for="Width" class="input_label_tab1">
                                                        <strong>Image Width %</strong>                
                                                    </label>                        
                                                    <input class="user_input" type="number" name="Width" value="<?php echo $pg360_ProjectWidth[$i]; ?>" min="10" max="100" step="1">
                                                </div>

                                                <div class="pg360-field ">
                                                    <label for="CursorShape" class="input_label_tab1">
                                                        <strong>Cursor Shape</strong>
                                                    </label>                        
                                                    <select name="CursorShape" class="user_input" id="set1">
                                                        <?php
                                                        if ($pg360_CursorShape[$i]=='default'){
                                                            echo "<option value='default' selected>Default</option>";
                                                        }else{
                                                            echo "<option value='default' >Default</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]=='hand'){
                                                            echo "<option value='hand' selected>Hand</option>";
                                                        }else{
                                                            echo "<option value='hand'>Hand</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]=='none'){
                                                            echo "<option value='none' selected>Hide Cursor</option>";
                                                        }else{
                                                            echo "<option value='none' >Hide Cursor</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]=='alias'){
                                                            echo "<option value='alias' selected>Alias</option>";
                                                        }else{
                                                            echo "<option value='alias' >Alias</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]=='col-resize'){
                                                            echo "<option value='col-resize' selected>Horizontal arrows</option>";
                                                        }else{
                                                            echo "<option value='col-resize' >Horizontal arrows</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]=='row-resize'){
                                                            echo "<option value='row-resize'  selected>Vertical arrows</option>";
                                                        }else{
                                                            echo "<option value='row-resize' >Vertical arrows</option>";
                                                        };
                                                        if ($pg360_CursorShape[$i]==''){
                                                            echo "<option value='' selected>Rotated Arrow</option>";
                                                        }else{
                                                            echo "<option value=''>Rotated Arrow</option>";
                                                        };
                                                                                    
                                                        ?>
                                                    </select>   
                                                </div>
              
                                                <div class="pg360-field pg360_disabled">
                                                    <?php
                                                    if ($pg360_DisableRightClick[$i]==TRUE){
                                                        echo '<input class="user_input " type="checkbox" name="DisableRightClick" value="1" checked>';
                                                    }else{
                                                        echo '<input class="user_input " type="checkbox" name="DisableRightClick" value="1" disabled>';
                                                    }
                                                    ?>                        
                                                    <label for="DisableRightClick" class="input_label_tab1 " disabled>
                                                        <strong>Disable Right Click</strong>
                                                    </label> 
                                                    <p class="description" id="all-content-desc">Available Only With Premium Plugin</p>
                        
                                                </div>
                                    
                                                <div class="pg360-field pg360_disabled">
                                                <?php
                                                    if ($pg360_display_Hint[$i]==true){
                                                        echo '<input type="checkbox" class="" id="display_Hint" name="display_Hint" value="1" checked disabled>';
                                                    }else{
                                                        echo '<input type="checkbox" class="" id="display_Hint" name="display_Hint" value="1" disabled>';
                                                    }                        
                                                    ?>                
                                                
                                                    <label for="<?php echo 'pg360_hint_chkbox'.$pg360_ProjectID[$i]; ?>" class="input_label_tab1 " >
                                                        <strong>Mouse Hint</strong>
                                                    </label>

                                                    <input id="<?php echo 'pg360_hint_chkbox'.$pg360_ProjectID[$i]; ?>"  type="text" name="pg360_hint_input" value="<?php echo $pg360_Hint[$i];?>" maxlength="25" class="pg360_text_input " disabled> 
                                                    <p class="description" id="all-content-desc">Appear while Mouse Hover (over 360 / images)-Available Only With Premium Plugin</p>
                                                </div>

                                                <div class="pg360-field pg360_disabled">
                                                    <?php
                                                    if ($pg360_display_360Hint[$i]==true){
                                                        echo '<input type="checkbox" id="display_360Hint" name="display_360Hint" value="1" checked disabled>';
                                                    }else{
                                                        echo '<input type="checkbox" id="display_360Hint" name="display_360Hint" value="1" disabled>';
                                                    }                        
                                                    ?>                
                                                    <label for="<?php echo 'pg360_360hint_chkbox'.$pg360_ProjectID[$i]; ?>" class="input_label_tab1" >
                                                        <strong>360 Hint</strong>
                                                    </label>

                                                    <input id="<?php echo 'pg360_360hint_chkbox'.$pg360_ProjectID[$i]; ?>"  type="text" name="pg360_360hint_input" value="<?php echo $pg360_360Hint[$i];?>" maxlength="25" class="pg360_text_input" disabled> 
                                                    <p class="description" id="all-content-desc">To declare this is responsive 360 move it-Available Only With Premium Plugin</p>
                                                </div>    
                                            </div>
                                    
                                            <?php
                                            /**
                                             * 2nd Tab
                                             * Color Filter and Color Control
                                             */
                                            ?>
                                            <div id="<?php echo 'pg360_tabs-2'.$pg360_ProjectID[$i];?>" >
                                            
                                                <div class=" pg360_color_control">
                                               
                                                    <div class="pg360_example">
                                                        <a style="margin-left:40px;margin-top: 20px;" class="button button-secondary pg360_restore_btn" id="<?php echo 'pg360_restore_btn'.$pg360_ProjectID[$i];?>"><strong>Restore Default</strong></a>
                                                        <div class="pg360_example_img <?php echo $ClassColorFilter[$i]; ?>">
                                                            <img src="<?php echo $pg360_ProjectImages[$i][0]->ImageURL; ?>" alt="can't find example photo"  width="200px" height="auto">
                                                        </div>
                                                        <h3 class="example_img_text">Preview</h3>
                                                    </div>
                                                
                                                    <div class="pg360_slider">
                                                        <div class="pg360-field">
                                                            <label for="ColorFilter" class="">
                                                                <strong>Color Filter</strong>        
                                                            </label>
                                                            <select name="ColorFilter" class="pg360_text_input" id="<?php echo 'set2'.$pg360_ProjectID[$i];?>">   
                                                                <?php
                                                                if ($ImgColorFilter[$i]=='default'){
                                                                    echo "<option value='default' selected> Default</option>";
                                                                }else{
                                                                    echo "<option value='default' > Default</option>";
                                                                }
                                                                
                                                                if ($ImgColorFilter[$i]=='BW'){
                                                                    echo "<option value='BW' selected> Black and white</option>";
                                                                }else{
                                                                    echo "<option value='BW' > Black and white</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter1'){
                                                                    echo "<option value='PGfilter1' selected>Old</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter1' >Old</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter2'){
                                                                    echo "<option value='PGfilter2' selected>Saturated</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter2' >Saturated</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter3'){
                                                                    echo "<option value='PGfilter3' selected>Pinky</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter3' >Pinky</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter4'){
                                                                    echo "<option value='PGfilter4' selected>Greeny</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter4' >Greeny</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter5'){
                                                                    echo "<option value='PGfilter5' selected>Graduated</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter5' >Graduated</option>";
                                                                }
                                                                if($ImgColorFilter[$i]=='PGfilter6'){
                                                                    echo "<option value='PGfilter6' selected>Contrasted</option>";
                                                                }else{
                                                                    echo "<option value='PGfilter6' >Contrasted</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <p class="description" id="all-content-desc">Choose Color Preset to use over your 360 / Images (Check Preview )</p>
                                                        </div>
                                                        <span class="pg360_disabled">Available Only With Premium Plugin</span>
                                                        <div class="pg360_disabled <?php echo 'brightness'.$pg360_ProjectID[$i];?>" >
                                                            <div id="<?php echo 'brightness'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_brightness'.$pg360_ProjectID[$i];?>" name="brightness" disabled>
                                                        </div>

                                                        <div class="pg360_disabled <?php echo 'contrast'.$pg360_ProjectID[$i]; ?>">
                                                            <div id="<?php echo 'contrast'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_contrast'.$pg360_ProjectID[$i];?>" name="contrast" disabled>
                                                        </div>
                                                    
                                                        <div class=" pg360_disabled <?php echo 'grayscale'.$pg360_ProjectID[$i]; ?>">
                                                            <div id="<?php echo 'grayscale'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_grayscale'.$pg360_ProjectID[$i];?>" name="grayscale" disabled>
                                                        </div>
                                                    
                                                        <div class="pg360_disabled <?php echo 'saturate'.$pg360_ProjectID[$i]; ?>">
                                                            <div id="<?php echo 'saturate'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_saturate'.$pg360_ProjectID[$i];?>" name="saturate" disabled>
                                                        </div>
                                                
                                                        <div class="pg360_disabled <?php echo 'sepia'.$pg360_ProjectID[$i]; ?>">
                                                            <div id="<?php echo 'sepia'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_sepia'.$pg360_ProjectID[$i];?>" name="sepia" disabled >
                                                        </div>
                                                    
                                                        <div class="pg360_disabled <?php echo 'opacity'.$pg360_ProjectID[$i]; ?>">
                                                            <div id="<?php echo 'opacity'.$pg360_ProjectID[$i]; ?>"></div>
                                                            <input type="hidden" id="<?php echo 'pg360_opacity'.$pg360_ProjectID[$i];?>" name="opacity" disabled>
                                                        </div>
                                                    </div><?php //slider ?>
                                                </div>  <?php //color control ?>    
                                            </div><?php // Tab 2 ?>
                                    
                                            <?php
                                            /**
                                             * 3rd Tab
                                             * 360 Options
                                             */
                                            ?>
                                            <div id="<?php echo 'pg360_tabs-3'.$pg360_ProjectID[$i];?>">
                                                <div class="tab3_option_wrap">
                                                    <div class="pg360-row-one">
                                                        <div class="pg360-field">
                                                            <label for="type_360" class="type360">
                                                                <strong style="color:#0073aa">360 Type</strong>
                                                            </label>                         
                                                            <select name="type_360" class="user_input_tab3">   
                                                                <?php
                                                                if ($pg360_360Type[$i]=='loops'){
                                                                    echo "<option value='loops' selected> Loop 360</option>";
                                                                    echo "<option value='non-loop' > non Loop 360</option>";
                                                                }else{
                                                                    echo "<option value='loops' > Loop 360</option>";
                                                                    echo "<option value='non-loop' selected> non Loop 360</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                                                                    
                                                        <div class="pg360-field ">
                                                            <label for="NoOfLayer" class="input_label_tab3">
                                                                <strong style="color:#0073aa">No. of Vertical Layer</strong> 
                                                            </label>                        
                                                            <input class="user_input" type="number" name="NoOfLayer" value="<?php echo ($pg360_NoOfLayer[$i] ); ?>" min="1">
                                                            <p class="description" id="all-content-desc">More layer->more tendency to be 3D</p>
                                                        </div> 

                                                        <div class="pg360-field ">
                                                            <label for="Speed" class="input_label_tab3">
                                                                <strong>Rotation Speed *</strong> 
                                                            </label>                        
                                                            <input class="user_input" type="number" name="Speed" value="<?php echo ($pg360_Speed[$i]); ?>" min="0" max="100" step="1">
                                                            <p class="description" id="all-content-desc">Range 0 (No motion at all) to 100 (max. speed)</p>
                                                        </div>

                                                        <div class="pg360-field ">
                                                            <label for="Preloader" class="input_label_tab3">
                                                                <strong>Loading Bar height</strong>  
                                                            </label>                   
                                                            <input class="user_input" type="number" name="Preloader" value="<?php echo $pg360_Preloader[$i]; ?>" min="1" max="10" step="1">
                                                            <p class="description" id="all-content-desc">In Pixel</p>
                                                        </div>
                                                        
                                                        <div class="pg360-field">
                                                            <label for="wheelable" class="input_label_tab3">
                                                                <strong>Interactive with Mouse wheel</strong>
                                                            </label>                         
                                                            <?php
                                                            if ($pg360_wheelable[$i]==TRUE){
                                                                echo '<input class="user_input" id="pg360_wheelable" type="checkbox" name="wheelable" value="1" id="inv" checked>';
                                                            }else{
                                                                echo '<input class="user_input" id="pg360_wheelable" type="checkbox" name="wheelable" value="1" id="inv" >';
                                                            }
                                                            ?>
                                                        </div>

                                                    </div> <?php // Row one ?>

                                                    <div class="pg360-row-two">
                                                    
                                                        <div class="pg360-field">
                                                            <label for="CW" class="input_label_tab3">
                                                                <strong style="color:#0073aa">Inverse Direction</strong>
                                                            </label>                         
                                                            <?php
                                                            if ($pg360_CW[$i]==TRUE){
                                                                echo '<input class="user_input" id="pg360_CW" type="checkbox" name="CW" value="1" id="inv" checked>';
                                                            }else{
                                                                echo '<input class="user_input" id="pg360_CW" type="checkbox" name="CW" value="1" id="inv" >';
                                                            }
                                                            ?>                                          <p class="description" id="all-content-desc">Use to adjust rotation with drag direction</p>
                                                        </div>

                                                        <div class="pg360-field">
                                                            <label for="Draggable" class="input_label_tab3 interaction_class">
                                                                <strong>Interactive</strong>
                                                            </label> 
                                                            <?php                        
                                                            if ($pg360_Interactive[$i]==TRUE){
                                                                echo '<input class="user_input" id="pg360_interactive" type="checkbox" name="Draggable" value="1" checked>';
                                                            }else{
                                                                echo '<input class="user_input" id="pg360_interactive" type="checkbox" name="Draggable" value="1" >';
                                                            }
                                                            ?>
                                                            <p class="description" id="all-content-desc">Responsive with mouse / touch</p>
                                                        </div>

                                                        <div class="pg360-field">
                                                            <label for="Orientable" class="input_label_tab3 interaction_class">
                                                                <strong>Full compatible </strong>
                                                            </label>                         
                                                            <?php
                                                            if ($pg360_Orientable[$i]==TRUE){
                                                                echo '<input class="user_input interaction" id="pg360_orientable" type="checkbox" name="Orientable" value="1" checked>';
                                                            }else{
                                                                echo '<input class="user_input interaction" id="pg360_orientable" type="checkbox" name="Orientable" value="1" >';
                                                            }
                                                            ?>   
                                                            <p class="description" id="all-content-desc">Compatible with Gyroscope devices like Mobile-Tablets ...</p>
                                                        </div>

                                                        <div class="pg360-field">
                                                            <label for="ClickFree" class="input_label_tab3 interaction_class">
                                                                <strong>Mouse Hover to Spin</strong>
                                                            </label>                         
                                                            <?php
                                                            if ($pg360_ClickFree[$i]==TRUE){
                                                                echo '<input class="user_input interaction" id="pg360_clickfree" type="checkbox" name="ClickFree" value="1" checked>';
                                                            }else{
                                                                echo '<input class="user_input interaction" id="pg360_clickfree" type="checkbox" name="ClickFree" value="1">';
                                                            }
                                                            ?>
                                                            <p class="description" id="all-content-desc">interactive with mouse hover </p>
                                                        </div>

                                                        <div class="pg360-field">
                                                            <label for="DisplayControlBtn" class="input_label_tab3">
                                                                <strong>Display Control Button</strong>
                                                            </label>  
                                                            <?php                       
                                                            if ($pg360_DCB[$i]==TRUE){
                                                                echo '<input class="user_input" type="checkbox" name="DisplayControlBtn" value="1" checked>';
                                                            }else{
                                                                echo '<input class="user_input" type="checkbox" name="DisplayControlBtn" value="1">';
                                                            }
                                                            ?>
                                                            <p class="description" id="all-content-desc">(Step back-Play-Pause-Zoom-Step forward)</p>
                                                        </div>

                                                        <div class="pg360-field">
                                                            <label for="Shy" class="input_label_tab3">
                                                                <strong>Click to initialize 360</strong>
                                                            </label>                         
                                                            <?php
                                                            if ($pg360_Shy[$i]==TRUE){
                                                                echo '<input class="user_input" id="pg360_shy" type="checkbox" name="Shy" value="1" id="sh" checked>';
                                                            }else{
                                                                echo '<input class="user_input" id="pg360_shy" type="checkbox" name="Shy" value="1" id="sh" >';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div><?php //row 2 ?>      
                                                </div><?php //tab 3 option wrap  ?> 
                                            </div><?php //tab 3 ?>
                                    
                                            <?php
                                            /**
                                             * 4th Tab
                                             * e-commerce options
                                             */
                                            ?>
                                            <div id="<?php echo 'pg360_tabs-4'.$pg360_ProjectID[$i];?>" >
                                                
                                                <div class="pg360-field pg360_disabled">
                                                    <label for="saleText" class="input_label sale">
                                                        Product Sale / Note
                                                    </label>                         
                                                    <input class="user_input" id="saleText" type="text" name="saleText" value="<?php echo $pg360_saleText[$i]; ?>" disabled>
                                                    <p class="description" id="all-content-desc">Put Product Sale / Note text here (Not more than 15 character ) </p>
                                                    <span class="pg360_disabled">Available Only With Premium Plugin</span>
                                                </div>
                                        
                                                <div class="pg360-field  pg360_disabled">
                                                    <?php
                                                    if($pg360_overlay[$i]==true){
                                                        echo '<input class="user_input" type="checkbox" name="overlay" value="true" checked disabled>';
                                                    }else{
                                                        echo '<input class="user_input" type="checkbox" value="true" name="overlay" disabled>';
                                                    }
                                                    ?>
                                                    <label for="sale" class="input_label sale">
                                                        Overlay Text
                                                    </label>
                                                    <input class="user_input" id="overlayText" type="text" name="overlayText" value="<?php echo $pg360_overlayText[$i]; ?>" disabled><p class="description" id="all-content-desc"> Text to be displayed on overlay</p>
                                                    <span class="pg360_disabled">Available Only With Premium Plugin</span>    
                                                </div>

                                            </div><?php //TAB # 4 ?>
                                        </div> <?php //Tabs ?>
                                        <div class="pg360_edit_buttons">
                                            <?php 
                                            submit_button( 'Save Changes', 'primary', ('pg360_form'.$pg360_ProjectID[$i]), false);
                                            ?>
                                        </div>
                                    </form> 
                                </div>  
                            </div>
                        </div><?php //Edit THICK BOX Parent Div?>
                        
                        <?php
                        /**
                         * Add Annotation 
                         */
                        ?>
                        <div class="pg360_tooltip">
                            <span class="pg360_tooltiptext">Available Only With Premium Plugin</span>
                            <div class="pg360_disabled ">
                                <span class="dashicons dashicons-plus-alt pg360_disabled"></span>
                                <a  class=" pg360_annotation pg360_disabled" >Add / Delete HotSpot</a>
                            </div>
                        </div>

                        <span class="dashicons dashicons-trash pg360_delete"></span>
                        <a href="#" class="pg360_delete" id="permanently_del<?php $pg360_ProjectID[$i];?>">Permanently Delete </a>
                    <?php 
                    } 
                    ?>
                
                </div>    
            <?php 
            /**
             * Else it will be empty project
             * Delete empty projects
             */
            }else{
                $wpdb->query($wpdb->prepare("DELETE FROM $pg360_table1Name WHERE `ID` =%s",$pg360_ProjectID[$i])); 
                $pg360_projectNo=$pg360_projectNo-1; 
            }
        };  // For Loop generate gallery
    }       //public function
};          //class