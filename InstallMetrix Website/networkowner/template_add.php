<?
include 'z_header.php';


FB::log($_SERVER);

  

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    if ($_REQUEST[templ_name] == '') {
        $errmsg.='<li>Field "Template Name" should not be empty</li>';
    }    
    if ($_REQUEST[camp_description] == '') {
        $errmsg.='<li>Field "Application Description" should not be empty</li>';
    }

    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
        
        $strdesc =  $_REQUEST[camp_description];        
        $strdesc = str_replace("\\r\\n","",$strdesc);
        $strdesc = str_replace("\\","",$strdesc);
        $_REQUEST[camp_description] =  $strdesc;
    } 
    else 
    {       
    
        $image_path = $my_common_path . "interface/images/";
        $template_path =  $my_common_path . "interface/templates/";
        
        $sql = "INSERT INTO templates (name, camp_description) VALUES ('{$_REQUEST[templ_name]}', '{$_REQUEST[camp_description]}')";
        mysql_query($sql);
        //var_dump($sql);exit;
        $templ_id = mysql_insert_id();
        
        
        //$templ_id = RandomString();
        
        $image1 = "";        $image2 = "";        $image3 = "";
        $image4 = "";        $image6 = "";        $image7 = "";
        $image8 = "";        $image9 = "";        $image10 = "";
        $image11 = "";        $image12 = "";        $image13 = "";
        $image14 = "";        $image15 = "";        
        
        $interface_url = $common_path_url . "interface/";
        if (is_uploaded_file($_FILES["templ_image1"]["tmp_name"])) {               
            $image1 = $interface_url . "images/" . $templ_id . "_img1";
            move_uploaded_file($_FILES["templ_image1"]["tmp_name"], $image_path . $templ_id . "_img1"); 
        } 
        if (is_uploaded_file($_FILES["templ_image2"]["tmp_name"])) {       
            $image2 =  $interface_url . "images/" . $templ_id . "_img2";
            move_uploaded_file($_FILES["templ_image2"]["tmp_name"], $image_path . $templ_id . "_img2");            
        }
        if (is_uploaded_file($_FILES["templ_image3"]["tmp_name"])) {       
            $image3 = $interface_url . "images/" . $templ_id . "_img3";
            move_uploaded_file($_FILES["templ_image3"]["tmp_name"], $image_path . $templ_id . "_img3");            
        }
        if (is_uploaded_file($_FILES["templ_image4"]["tmp_name"])) {       
            $image4 = $interface_url . "images/" . $templ_id . "_img4";     
            move_uploaded_file($_FILES["templ_image4"]["tmp_name"], $image_path . $templ_id . "_img4");            
        }
        if (is_uploaded_file($_FILES["templ_image5"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img5";
            move_uploaded_file($_FILES["templ_image5"]["tmp_name"], $image_path . $templ_id . "_img5");            
        } 
        if (is_uploaded_file($_FILES["templ_image6"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img6";
            move_uploaded_file($_FILES["templ_image6"]["tmp_name"], $image_path . $templ_id . "_img6");            
        }
        if (is_uploaded_file($_FILES["templ_image7"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img7";
            move_uploaded_file($_FILES["templ_image7"]["tmp_name"], $image_path . $templ_id . "_img7");            
        }
        if (is_uploaded_file($_FILES["templ_image8"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img8";
            move_uploaded_file($_FILES["templ_image8"]["tmp_name"], $image_path . $templ_id . "_img8");            
        }
        if (is_uploaded_file($_FILES["templ_image9"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img9";
            move_uploaded_file($_FILES["templ_image9"]["tmp_name"], $image_path . $templ_id . "_img9");            
        }
        if (is_uploaded_file($_FILES["templ_image10"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img10";
            move_uploaded_file($_FILES["templ_image10"]["tmp_name"], $image_path . $templ_id . "_img10");            
        }
        if (is_uploaded_file($_FILES["templ_image11"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img11";
            move_uploaded_file($_FILES["templ_image11"]["tmp_name"], $image_path . $templ_id . "_img11");            
        }
        if (is_uploaded_file($_FILES["templ_image12"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img12";
            move_uploaded_file($_FILES["templ_image12"]["tmp_name"], $image_path . $templ_id . "_img12");            
        }
        if (is_uploaded_file($_FILES["templ_image13"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img13";
            move_uploaded_file($_FILES["templ_image13"]["tmp_name"], $image_path . $templ_id . "_img13");            
        }
        if (is_uploaded_file($_FILES["templ_image14"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img14";
            move_uploaded_file($_FILES["templ_image14"]["tmp_name"], $image_path . $templ_id . "_img14");            
        }
        if (is_uploaded_file($_FILES["templ_image15"]["tmp_name"])) {       
            $image5 = $interface_url . "images/" . $templ_id . "_img15";
            move_uploaded_file($_FILES["templ_image15"]["tmp_name"], $image_path . $templ_id . "_img15");            
        }
        
        if (!is_uploaded_file($_FILES["main_templ_html"]["tmp_name"])) {  
            $errmsg.='<li>Field "Main Template HTML file" should not be empty</li>';
            $usermessage = '<b>Please correct the following errors:</b><br><ul>';
            $usermessage .= $errmsg;
            $usermessage .= '</ul>';            
            
        }
        else if (!is_uploaded_file($_FILES["download_templ_html"]["tmp_name"])) {  
            $errmsg.='<li>Field "Download Template HTML file" should not be empty</li>';
            $usermessage = '<b>Please correct the following errors:</b><br><ul>';
            $usermessage .= $errmsg;
            $usermessage .= '</ul>';            
            
        }
        else if (!is_uploaded_file($_FILES["thank_templ_html"]["tmp_name"])) {  
            $errmsg.='<li>Field "Thank Template HTML file" should not be empty</li>';
            $usermessage = '<b>Please correct the following errors:</b><br><ul>';
            $usermessage .= $errmsg;
            $usermessage .= '</ul>';            
            
        }
        
        else
        {
            //check name
            $sql = "SELECT * FROM templates WHERE name='{$_REQUEST[templ_name]}'";
            $q = mysql_query($sql);
            $count_name = mysql_numrows($q);
            if($count_name>0)
            {
                $errmsg.='<li>The templates name is existed already. Please put another name.</li>';
                $usermessage = '<b>Please correct the following errors:</b><br><ul>';
                $usermessage .= $errmsg;
                $usermessage .= '</ul>';            
            }
            else
            {         
            
                //main template
                {
                $main_templ_path = $template_path . $_REQUEST[templ_name] . "-main-" . $templ_id . ".htm";
                
                $homepage = file_get_contents($_FILES["main_templ_html"]["tmp_name"]);
                $homepage = str_replace("@image1@", $image1, $homepage);
                $homepage = str_replace("@image2@", $image2 ,$homepage);
                $homepage = str_replace("@image3@", $image3, $homepage);
                $homepage = str_replace("@image4@", $image4, $homepage);
                $homepage = str_replace("@image5@", $image5, $homepage);
                $homepage = str_replace("@image6@", $image6, $homepage);
                $homepage = str_replace("@image7@", $image7, $homepage);
                $homepage = str_replace("@image8@", $image8, $homepage);
                $homepage = str_replace("@image9@", $image9, $homepage);
                $homepage = str_replace("@image10@", $image10, $homepage);
                $homepage = str_replace("@image11@", $image11, $homepage);
                $homepage = str_replace("@image12@", $image12, $homepage);
                $homepage = str_replace("@image13@", $image13, $homepage);
                $homepage = str_replace("@image14@", $image14, $homepage);
                $homepage = str_replace("@image15@", $image15, $homepage);
                            
                file_put_contents($main_templ_path, $homepage);
                }
                
                {
                $download_templ_path = $template_path . $_REQUEST[templ_name] . "-download-" . $templ_id . ".htm";
                
                $homepage = file_get_contents($_FILES["download_templ_html"]["tmp_name"]);
                $homepage = str_replace("@image1@", $image1, $homepage);
                $homepage = str_replace("@image2@", $image2 ,$homepage);
                $homepage = str_replace("@image3@", $image3, $homepage);
                $homepage = str_replace("@image4@", $image4, $homepage);
                $homepage = str_replace("@image5@", $image5, $homepage);
                $homepage = str_replace("@image6@", $image6, $homepage);
                $homepage = str_replace("@image7@", $image7, $homepage);
                $homepage = str_replace("@image8@", $image8, $homepage);
                $homepage = str_replace("@image9@", $image9, $homepage);
                $homepage = str_replace("@image10@", $image10, $homepage);
                $homepage = str_replace("@image11@", $image11, $homepage);
                $homepage = str_replace("@image12@", $image12, $homepage);
                $homepage = str_replace("@image13@", $image13, $homepage);
                $homepage = str_replace("@image14@", $image14, $homepage);
                $homepage = str_replace("@image15@", $image15, $homepage);
                            
                file_put_contents($download_templ_path, $homepage);
                }
                
                {
                $thank_templ_path = $template_path . $_REQUEST[templ_name] . "-thank-" . $templ_id . ".htm";
                
                $homepage = file_get_contents($_FILES["thank_templ_html"]["tmp_name"]);
                $homepage = str_replace("@image1@", $image1, $homepage);
                $homepage = str_replace("@image2@", $image2 ,$homepage);
                $homepage = str_replace("@image3@", $image3, $homepage);
                $homepage = str_replace("@image4@", $image4, $homepage);
                $homepage = str_replace("@image5@", $image5, $homepage);
                $homepage = str_replace("@image6@", $image6, $homepage);
                $homepage = str_replace("@image7@", $image7, $homepage);
                $homepage = str_replace("@image8@", $image8, $homepage);
                $homepage = str_replace("@image9@", $image9, $homepage);
                $homepage = str_replace("@image10@", $image10, $homepage);
                $homepage = str_replace("@image11@", $image11, $homepage);
                $homepage = str_replace("@image12@", $image12, $homepage);
                $homepage = str_replace("@image13@", $image13, $homepage);
                $homepage = str_replace("@image14@", $image14, $homepage);
                $homepage = str_replace("@image15@", $image15, $homepage);
                            
                file_put_contents($thank_templ_path, $homepage);
                }
                
                $sql =  "UPDATE templates SET  
                        maintemplate_filepath='{$main_templ_path}', 
                        downloadtemplate_filepath='{$download_templ_path}', 
                        thanktemplate_filepath='{$thank_templ_path}',          
                        img1='{$image1}', 
                        img2='{$image2}', 
                        img3='{$image3}', 
                        img4='{$image4}', 
                        img5='{$image5}', 
                        img6='{$image6}', 
                        img7='{$image7}', 
                        img8='{$image8}', 
                        img9='{$image9}', 
                        img10='{$image10}', 
                        img11='{$image11}', 
                        img12='{$image12}', 
                        img13='{$image13}', 
                        img14='{$image14}', 
                        img15='{$image15}'
                        WHERE id={$templ_id}
                     ";
                    
                //echo $sql; exit;
                    
                mysql_query($sql);          
            
                echo('<script language="JavaScript">window.location.href = "template_list.php"</script>');            
                break;
            }
        }
        
    }
}
?>


<div id="body">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER-->
                <!-- END STYLE CUSTOMIZER-->
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Add New Template
                    <small>create HTML template for installer manager interface</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New Template</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  General Template Settings</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="template_add.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Template Name</label>
                                    <div class="controls">
                                        <input type="text" id="templ_name" name="templ_name" value="<?= $_REQUEST[templ_name] ?>" class="span6 popovers"  />
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label" ><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application Description</label>
                                    <div class="controls">
                                        <textarea class="span6 editor popovers" rows="6" style="width: 700px;" id="camp_description" name="camp_description" data-trigger="hover" data-content='The description of the main application of the campign, which will be installed. This will be shown in your installer.'><?= $_REQUEST[camp_description] ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Image 1</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image1"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label">Image 2</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image2"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Image 3</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image3"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>                                  
                                
                                <div class="control-group">
                                    <label class="control-label">Image 4</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image4"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>      
                                
                                <div class="control-group">
                                    <label class="control-label">Image 5</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image5"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label">Image 6</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image6"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Image 7</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image7"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label">Image 8</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image8"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Image 9</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image9"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Image 10</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image10"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>  
                                
                                <div class="control-group">
                                    <label class="control-label">Image 11</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image11"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label">Image 12</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image12"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>  
                                
                                <div class="control-group">
                                    <label class="control-label">Image 13</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image13"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label">Image 14</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image14"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label">Image 15</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="templ_image15"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div>              
                                        
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Main Template HTML file</label>                                    
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="main_templ_html"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Download Template HTML file</label>                                    
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="download_templ_html"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Thank Template HTML file</label>                                    
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                  <div class="input-append">
                                                    <div class="uneditable-input span3">
                                                        <i class="icon-file fileupload-exists"></i> 
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-file">
                                                        <span class="fileupload-new">Select file</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file" class="default" name="thank_templ_html"/>
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                  </div>
                                        </div>                                         
                                    </div>
                                </div> 
                                


                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Template</a>
                                    <a href="dashboard.php" class="btn">Cancel</a>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>

        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>

<? include 'z_footer.php'; ?>
