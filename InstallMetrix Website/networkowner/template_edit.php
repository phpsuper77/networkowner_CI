<?
include 'z_header.php';


FB::log($_SERVER);


$id=$_REQUEST[tid]; 

  
if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    if($_REQUEST[mode] == "edit_template")
    {
        if ($_REQUEST[name] == '') {
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
            
            $image1 = $_REQUEST[img1];  $image2 = $_REQUEST[img2];  $image3 = $_REQUEST[img3];  $image4 = $_REQUEST[img4];  $image5 = $_REQUEST[img5];  
            $image6 = $_REQUEST[img6];  $image7 = $_REQUEST[img7];  $image8 = $_REQUEST[img8];  $image9 = $_REQUEST[img9];  $image10 = $_REQUEST[img10];  
            $image11 = $_REQUEST[img11];  $image12 = $_REQUEST[img12];  $image13 = $_REQUEST[img13];  $image14 = $_REQUEST[img14];  $image15 = $_REQUEST[img15];  
            
            //var_dump($_REQUEST);exit;
            
            $interface_url = $common_path_url . "interface/";
            
            if (is_uploaded_file($_FILES["img1_file"]["tmp_name"])) {               
                $image1 = $interface_url . "images/" . $id . "_img1";
                move_uploaded_file($_FILES["img1_file"]["tmp_name"], $image_path . $id . "_img1");
            } 
            if (is_uploaded_file($_FILES["img2_file"]["tmp_name"])) {       
                $image2 =  $interface_url . "images/" . $id . "_img2";
                move_uploaded_file($_FILES["img2_file"]["tmp_name"], $image_path . $id . "_img2");            
            }
            if (is_uploaded_file($_FILES["img3_file"]["tmp_name"])) {       
                $image3 = $interface_url . "images/" . $id . "_img3";
                move_uploaded_file($_FILES["img3_file"]["tmp_name"], $image_path . $id . "_img3");            
            }
            if (is_uploaded_file($_FILES["img4_file"]["tmp_name"])) {       
                $image4 = $interface_url . "images/" . $id . "_img4";     
                move_uploaded_file($_FILES["img4_file"]["tmp_name"], $image_path . $id . "_img4");            
            }
            if (is_uploaded_file($_FILES["img5_file"]["tmp_name"])) {       
                $image5 = $interface_url . "images/" . $id . "_img5";
                move_uploaded_file($_FILES["img5_file"]["tmp_name"], $image_path . $id . "_img5");            
            } 
            if (is_uploaded_file($_FILES["img6_file"]["tmp_name"])) {       
                $image6 = $interface_url . "images/" . $id . "_img6";
                move_uploaded_file($_FILES["img6_file"]["tmp_name"], $image_path . $id . "_img6");            
            } 
            if (is_uploaded_file($_FILES["img7_file"]["tmp_name"])) {       
                $image7 = $interface_url . "images/" . $id . "_img7";
                move_uploaded_file($_FILES["img7_file"]["tmp_name"], $image_path . $id . "_img7");            
            } 
            if (is_uploaded_file($_FILES["img8_file"]["tmp_name"])) {       
                $image8 = $interface_url . "images/" . $id . "_img8";
                move_uploaded_file($_FILES["img8_file"]["tmp_name"], $image_path . $id . "_img8");            
            } 
            if (is_uploaded_file($_FILES["img9_file"]["tmp_name"])) {       
                $image9 = $interface_url . "images/" . $id . "_img9";
                move_uploaded_file($_FILES["img9_file"]["tmp_name"], $image_path . $id . "_img9");            
            } 
            if (is_uploaded_file($_FILES["img10_file"]["tmp_name"])) {       
                $image10 = $interface_url . "images/" . $id . "_img10";
                move_uploaded_file($_FILES["img10_file"]["tmp_name"], $image_path . $id . "_img10");            
            } 
            if (is_uploaded_file($_FILES["img11_file"]["tmp_name"])) {       
                $image11 = $interface_url . "images/" . $id . "_img11";
                move_uploaded_file($_FILES["img11_file"]["tmp_name"], $image_path . $id . "_img11");            
            } 
            if (is_uploaded_file($_FILES["img12_file"]["tmp_name"])) {       
                $image12 = $interface_url . "images/" . $id . "_img12";
                move_uploaded_file($_FILES["img12_file"]["tmp_name"], $image_path . $id . "_img12");            
            } 
            if (is_uploaded_file($_FILES["img13_file"]["tmp_name"])) {       
                $image13 = $interface_url . "images/" . $id . "_img13";
                move_uploaded_file($_FILES["img13_file"]["tmp_name"], $image_path . $id . "_img13");            
            } 
            if (is_uploaded_file($_FILES["img14_file"]["tmp_name"])) {       
                $image14 = $interface_url . "images/" . $id . "_img14";
                move_uploaded_file($_FILES["img14_file"]["tmp_name"], $image_path . $id . "_img14");            
            }
            if (is_uploaded_file($_FILES["img15_file"]["tmp_name"])) {       
                $image15 = $interface_url . "images/" . $id . "_img15";
                move_uploaded_file($_FILES["img15_file"]["tmp_name"], $image_path . $id . "_img15");            
            }  
            

            $main_templ_path = $template_path . $_REQUEST[name] . "-main-" . $id . ".htm";
            $download_templ_path = $template_path . $_REQUEST[name] . "-download-" . $id . ".htm";
            $thank_templ_path = $template_path . $_REQUEST[name] . "-thank-" . $id . ".htm"; 
            
            {
            if (!is_uploaded_file($_FILES["main_templ_html"]["tmp_name"])) 
            {         
                $homepage = file_get_contents($main_templ_path);
            }
            else
            {
                //var_dump($_FILES["templ_html"]);exit;  
                $homepage = file_get_contents($_FILES["main_templ_html"]["tmp_name"]);       
            }
            
            $homepage = str_replace("@image1@", $image1, $homepage); $homepage = str_replace("@image2@", $image2 ,$homepage); $homepage = str_replace("@image3@", $image3, $homepage);
            $homepage = str_replace("@image4@", $image4, $homepage); $homepage = str_replace("@image5@", $image5, $homepage); $homepage = str_replace("@image6@", $image6, $homepage);
            $homepage = str_replace("@image7@", $image7, $homepage); $homepage = str_replace("@image8@", $image8, $homepage); $homepage = str_replace("@image9@", $image9, $homepage);
            $homepage = str_replace("@image10@", $image10, $homepage); $homepage = str_replace("@image11@", $image11, $homepage); $homepage = str_replace("@image12@", $image12, $homepage);
            $homepage = str_replace("@image13@", $image13, $homepage); $homepage = str_replace("@image14@", $image14, $homepage); $homepage = str_replace("@image15@", $image15, $homepage);
                    
            file_put_contents($main_templ_path, $homepage);
            }
            
            {
            if (!is_uploaded_file($_FILES["download_templ_html"]["tmp_name"])) 
            {         
                $homepage = file_get_contents($download_templ_path);
            }
            else
            {
                //var_dump($_FILES["templ_html"]);exit;  
                $homepage = file_get_contents($_FILES["download_templ_html"]["tmp_name"]);       
            }
            
            $homepage = str_replace("@image1@", $image1, $homepage); $homepage = str_replace("@image2@", $image2 ,$homepage); $homepage = str_replace("@image3@", $image3, $homepage);
            $homepage = str_replace("@image4@", $image4, $homepage); $homepage = str_replace("@image5@", $image5, $homepage); $homepage = str_replace("@image6@", $image6, $homepage);
            $homepage = str_replace("@image7@", $image7, $homepage); $homepage = str_replace("@image8@", $image8, $homepage); $homepage = str_replace("@image9@", $image9, $homepage);
            $homepage = str_replace("@image10@", $image10, $homepage); $homepage = str_replace("@image11@", $image11, $homepage); $homepage = str_replace("@image12@", $image12, $homepage);
            $homepage = str_replace("@image13@", $image13, $homepage); $homepage = str_replace("@image14@", $image14, $homepage); $homepage = str_replace("@image15@", $image15, $homepage);
                    
            file_put_contents($download_templ_path, $homepage);
            }
            
            {
            if (!is_uploaded_file($_FILES["thank_templ_html"]["tmp_name"])) 
            {         
                $homepage = file_get_contents($thank_templ_path);
            }
            else
            {
                //var_dump($_FILES["templ_html"]);exit;  
                $homepage = file_get_contents($_FILES["thank_templ_html"]["tmp_name"]);       
            }
            
            $homepage = str_replace("@image1@", $image1, $homepage); $homepage = str_replace("@image2@", $image2 ,$homepage); $homepage = str_replace("@image3@", $image3, $homepage);
            $homepage = str_replace("@image4@", $image4, $homepage); $homepage = str_replace("@image5@", $image5, $homepage); $homepage = str_replace("@image6@", $image6, $homepage);
            $homepage = str_replace("@image7@", $image7, $homepage); $homepage = str_replace("@image8@", $image8, $homepage); $homepage = str_replace("@image9@", $image9, $homepage);
            $homepage = str_replace("@image10@", $image10, $homepage); $homepage = str_replace("@image11@", $image11, $homepage); $homepage = str_replace("@image12@", $image12, $homepage);
            $homepage = str_replace("@image13@", $image13, $homepage); $homepage = str_replace("@image14@", $image14, $homepage); $homepage = str_replace("@image15@", $image15, $homepage);
                    
            file_put_contents($thank_templ_path, $homepage);
            }
            
            $sql =  "UPDATE `templates` SET `name`='{$_REQUEST[name]}', `camp_description`='{$_REQUEST[camp_description]}',
                    `maintemplate_filepath`='{$main_templ_path}', `downloadtemplate_filepath`='{$download_templ_path}', `thanktemplate_filepath`='{$thank_templ_path}', 
                    `img1`='{$image1}' , `img2`='{$image2}' , `img3`='{$image3}' , `img4`='{$image4}' , `img5`='{$image5}',
                    `img6`='{$image6}' , `img7`='{$image7}' , `img8`='{$image8}' , `img9`='{$image9}' , `img10`='{$image10}',
                    `img11`='{$image11}' , `img12`='{$image12}' , `img13`='{$image13}' , `img14`='{$image14}' , `img15`='{$image15}'
                     WHERE `id`='{$id}'";
            //var_dump($sql); exit;
            mysql_query($sql);       
            
            echo('<script language="JavaScript">window.location.href = "template_list.php"</script>');
            break;
        
        }
    }
    else if($_REQUEST[mode]=="add_campaigns")
    {           
        //get selected campaigns ids
        $camp_array_str = "0,";        
        foreach ($_POST['campaigns'] as $selectedCampaign)
        {
            $camp_array_str .= $selectedCampaign . ",";                            
        }
        $camp_array_str =  substr($camp_array_str,0,-1);
        
        //delete old campaigns that is not selected now for the bundle.
        $sql = "DELETE FROM template_campaigns WHERE template_id='{$id}' AND camp_id NOT IN ({$camp_array_str})";
        //var_dump($sql);exit;
        mysql_query($sql);  
        
        //insert new campaigns to the template
        
        $sql_insert = "INSERT INTO template_campaigns(template_id, camp_id) VALUES"; 
        $new_count = 0;
        foreach ($_POST['campaigns'] as $selectedCampaign)
        {   
            $sql = "SELECT * FROM template_campaigns WHERE template_id={$id} AND camp_id={$selectedCampaign}";
            $q = mysql_query($sql);
            $num = mysql_numrows($q);
            
            if($num == 0)
            {                   
                //new campaign
                $new_count ++;                
                $sql_insert .= "('{$id}', {$selectedCampaign})" . ",";                  
            }                            
        }
        $sql_insert =  substr($sql_insert,0,-1);
        //var_dump($sql_insert);exit;
        mysql_query($sql_insert);        
   

    }
        
}

if ($id != '') {
    $sql = "SELECT * FROM templates WHERE id={$id}";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
  
    foreach ($row as $key => $value) {
        $_REQUEST[$key] = $value;
    }
    
    //var_dump($_REQUEST);exit;
}
?>  

<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link type="text/css" href="../common/multiselector/css/ui.multiselect.css" rel="stylesheet" />
<script type="text/javascript" src="../common/multiselector/js/plugins/localisation/jquery.localisation-min.js"></script>
<script type="text/javascript" src="../common/multiselector/js/ui.multiselect.js"></script>

<script type="text/javascript">
    $(function(){
        $.localise('ui-multiselect', {/*language: 'en',*/ path: '../common/multiselector/js/locale/'});
        $(".multiselect").multiselect({sortable: true, searchable: true});
        
    });
</script>
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
                    Edit Template
                    <small>edit HTML template for installer manager interface</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Edit Template</a></li>
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
            <?
            if ($_REQUEST[mode] == 'add_campaigns') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Campaigns has been saved successfully!
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
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">
                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" data-toggle="tab" onclick="$('#buttons_general').show();
                                            $('#buttons_offers').show();">Add/Remove Campaigns</a></li>
                                    <li <? if ($_REQUEST[tab] != '2') { ?>class="active"<? } ?>><a href="#portlet_tab1" data-toggle="tab" onclick="$('#buttons_general').hide();
                                            $('#buttons_offers').hide();">General Template Settings</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <? if ($_REQUEST[tab] != '2') { ?>active<? } ?>" id="portlet_tab1">
                                        <!-- BEGIN FORM--> 
                                        <form action="template_edit.php?tid=<?=$id ?>" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                            <input type="hidden" name="tryout" value="1"/>
                                            <input type="hidden" name="mode" value="edit_template"/>                                            
                                            <input type="hidden" name="img1" value="<?= $_REQUEST[img1]?>">
                                            <input type="hidden" name="img2" value="<?= $_REQUEST[img2]?>">
                                            <input type="hidden" name="img3" value="<?= $_REQUEST[img3]?>">
                                            <input type="hidden" name="img4" value="<?= $_REQUEST[img4]?>">
                                            <input type="hidden" name="img5" value="<?= $_REQUEST[img5]?>">
                                            <input type="hidden" name="img6" value="<?= $_REQUEST[img6]?>">
                                            <input type="hidden" name="img7" value="<?= $_REQUEST[img7]?>">
                                            <input type="hidden" name="img8" value="<?= $_REQUEST[img8]?>">
                                            <input type="hidden" name="img9" value="<?= $_REQUEST[img9]?>">
                                            <input type="hidden" name="img10" value="<?= $_REQUEST[img10]?>">
                                            <input type="hidden" name="img11" value="<?= $_REQUEST[img11]?>">
                                            <input type="hidden" name="img12" value="<?= $_REQUEST[img12]?>">
                                            <input type="hidden" name="img13" value="<?= $_REQUEST[img13]?>">
                                            <input type="hidden" name="img14" value="<?= $_REQUEST[img14]?>">
                                            <input type="hidden" name="img15" value="<?= $_REQUEST[img15]?>">
                                            
                                            <input type="hidden" name="file_path" value="<?= $_REQUEST[main_file_path]?>">                                

                                            <div class="control-group">
                                                <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Template Name</label>
                                                <div class="controls">
                                                    <input type="text" id="name" name="name" value="<?= $_REQUEST[name] ?>" class="span6 popovers"  />
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
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img1] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img1_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 2</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img2] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img2_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div> 
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 3</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img3] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img3_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>  
                                                                          
                                            <div class="control-group">
                                                <label class="control-label">Image 4</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img4] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img4_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 5</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img5] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img5_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>  
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 6</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img6] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="img6_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div> 
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 7</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img7] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img7_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>     
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 8</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img8] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img8_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div> 
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 9</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img9] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img9_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div> 
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 10</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img10] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img10_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 11</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img11] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img11_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 12</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img12] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img12_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 13</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img13] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img13_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>  
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 14</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img14] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img14_file"/></span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">Image 15</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail" style="width: 250px; height: 100px;"><img src="<?= $_REQUEST[img15] ?>" alt=""/></div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                                <input type="file" class="default" name="img15_file"/></span>
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
                                                                    <span class="fileupload-preview"><?=$_REQUEST[name]?>_main</span>
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
                                                                    <span class="fileupload-preview"><?=$_REQUEST[name]?>_download</span>
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
                                                <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Template HTML file</label>                                    
                                                <div class="controls">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                              <div class="input-append">
                                                                <div class="uneditable-input span3">
                                                                    <i class="icon-file fileupload-exists"></i> 
                                                                    <span class="fileupload-preview"><?=$_REQUEST[name]?>_thank</span>
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
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <div style="float: left;">
                                         <form action="template_edit.php?tid=<?= $id?>" class="form-horizontal" method="POST" id="campaign_form" enctype="multipart/form-data">
                                            <input type="hidden" name="tryout" value="1"/>  
                                            <input type="hidden" name="tab" value="2"/>                                          
                                            <input type="hidden" name="mode" value="add_campaigns"/>
                                            
                                            <div class="control-group" style="overflow-y: hidden ;">
                                             
                                                  <div id="multi_header" style="width:500px;height:30px;margin: 10px 0px 0px 0px;">
                                                    <div style="width:210px;height:30px;float:left;text-align: center;"> Avaialbe Campaigns </div>
                                                    <div style="width:70px;height:30px;float:left;text-align: center;"><img src="../common/multiselector/images/switch.png" alt=""> </div>
                                                    <div style="width:200px;height:30px;float:left;text-align: center;"> Added Campaigns  </div>
                                                  </div>
                                                  
                                                  <select id="campaigns" class="multiselect" multiple="multiple" name="campaigns[]" style="display: none; width:500px;height: 390px;">
                                                  <?php                                                                                                        
                                                        $sql = "SELECT * FROM projects WHERE status=0 AND id NOT IN (SELECT camp_id FROM template_campaigns WHERE template_id={$id})";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>"> <?= $row[proj_name]?></option>
                                                  <?php
                                                        }
                                                        
                                                        $sql = "SELECT * FROM projects WHERE status=0 AND id IN (SELECT camp_id FROM template_campaigns WHERE template_id={$id})";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>" selected > <?= $row[proj_name]?></option>
                                                  <?php
                                                        }        
    
                                                  ?>    
                                                  </select>                                                 
                                                  
                                            </div>
                                            
                                        </form>
                                        </div>
                                        <div  id="buttons_general" style="float: left; margin-left: 100px; margin-top: 100px;">
                                            <a href="#" style="margin-top: 50px;" class="btn btn-success" onclick="$('#campaign_form').submit();
                                                        return false;"><i class="icon-check"></i> Save Settings</a>
                                            <a href="template_list.php" style="margin-top: 50px;" class="btn">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
