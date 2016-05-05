<?
include 'z_header.php';

//var_dump($_REQUEST);
if (($_REQUEST[oid] != '') && ($_REQUEST[tryout] == '')) {
    $sql = "SELECT * FROM `offers` WHERE `id`='{$_REQUEST[oid]}'";
    //var_dump($sql);exit;
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
     
    foreach ($row as $key => $value) {
        $_REQUEST[$key] = $value;
    }   
    
}
$_REQUEST[offer_silent_main] = str_replace('"', '&quot;', $_REQUEST[offer_silent_main]);
//var_dump($_REQUEST[offer_silent_main]);exit;

if ($_REQUEST[tryout] == '1') {

    if($_REQUEST[mode] == "update_offer")
    {
        $errmsg = '';

        if ($_REQUEST[offer_name] == '') {
            $errmsg.='<li>Field "Application Name" should not be empty</li>';
        }
      
        if ($_REQUEST[offer_description] == '') {
            $errmsg.='<li>Field "Application Description" should not be empty</li>';
        }

        if ($_REQUEST[offer_url] == '') {
            $errmsg.='<li>Field "Application URL" should not be empty</li>';
        }       
        
        if ($_REQUEST[offer_cap] == '') {
            $errmsg.='<li>Field "Offer Cap" should not be empty</li>';
        }
                
            
        if ($errmsg != '') {
            $usermessage = '<b>Please correct the following errors:</b><br><ul>';
            $usermessage .= $errmsg;
            $usermessage .= '</ul>';
                                    
            
            $str =  $_REQUEST[reg_path_pre]; $str = str_replace("\\r\\n","\r\n",$str); $str = str_replace("\\\\","\\",$str); $_REQUEST[reg_path_pre] =  $str;
            $str =  $_REQUEST[reg_path_64_pre]; $str = str_replace("\\r\\n","\r\n",$str); $str = str_replace("\\\\","\\",$str); $_REQUEST[reg_path_64_pre] =  $str;
            $str =  $_REQUEST[reg_path_post]; $str = str_replace("\\r\\n","\r\n",$str); $str = str_replace("\\\\","\\",$str); $_REQUEST[reg_path_post] =  $str;
            $str =  $_REQUEST[reg_path_64_post]; $str = str_replace("\\r\\n","\r\n",$str); $str = str_replace("\\\\","\\",$str); $_REQUEST[reg_path_64_post] =  $str;
            
            
        } else {
            if ($_REQUEST[offer_show] == '')
                $_REQUEST[offer_show] = '0';      
                
            //var_dump($_REQUEST[reg_path_pre]);exit;                                                                    
            $offer_id = $_REQUEST[oid];      
            
            $str_offerdesc = $_REQUEST[offer_description];
            $str_offerdesc = str_replace("<a href","<a target=\"_blank\" href", $str_offerdesc);      
            $str_offerdesc = str_replace("“","\"", $str_offerdesc);      
            $str_offerdesc = str_replace("”","\"", $str_offerdesc); 
            
            $_REQUEST[offer_silent_main] = str_replace("&quot;", '"', $_REQUEST[offer_silent_main]);
            $_REQUEST[offer_silent_main1] = str_replace("&quot;", '"', $_REQUEST[offer_silent_main1]);
            $_REQUEST[offer_silent_main2] = str_replace("&quot;", '"', $_REQUEST[offer_silent_main2]);
            $_REQUEST[offer_silent_main3] = str_replace("&quot;", '"', $_REQUEST[offer_silent_main3]);
            
            $add_con = "";
            foreach ($_POST['conditions'] as $selectedCondition)
            {
                $add_con .= "{$selectedCondition},";
            }
            $add_con =  substr($add_con,0,-1);
            //var_dump($add_con);exit;
                                   
            //var_dump($_REQUEST[registry_path]);exit;              
            $sql = "UPDATE `offers` SET         
                `offer_name`='{$_REQUEST[offer_name]}',
                `assigned_user_id`='{$_REQUEST[assigned_user_id]}',   
                `offer_description`='{$str_offerdesc}',
                `offer_url`='{$_REQUEST[offer_url]}',
                `offer_silent_main`='{$_REQUEST[offer_silent_main]}',
                `offer_silent_main1`='{$_REQUEST[offer_silent_main1]}',
                `offer_silent_main2`='{$_REQUEST[offer_silent_main2]}',
                `offer_silent_main3`='{$_REQUEST[offer_silent_main3]}',
                `offer_silent_check1_on`='{$_REQUEST[offer_silent_check1_on]}',
                `offer_silent_check1_off`='{$_REQUEST[offer_silent_check1_off]}',
                `offer_silent_check2_on`='{$_REQUEST[offer_silent_check2_on]}',
                `offer_silent_check2_off`='{$_REQUEST[offer_silent_check2_off]}',
                `offer_silent_check3_on`='{$_REQUEST[offer_silent_check3_on]}',
                `offer_silent_check3_off`='{$_REQUEST[offer_silent_check3_off]}',
                `offer_silent_check4_on`='{$_REQUEST[offer_silent_check4_on]}',
                `offer_silent_check4_off`='{$_REQUEST[offer_silent_check4_off]}',
                `offer_silent_check5_on`='{$_REQUEST[offer_silent_check5_on]}',
                `offer_silent_check5_off`='{$_REQUEST[offer_silent_check5_off]}',
                `offer_tos_url`='{$_REQUEST[offer_tos_url]}',
                `offer_pp_url`='{$_REQUEST[offer_pp_url]}',
                `offer_eula_url`='{$_REQUEST[offer_eula_url]}',
                `offer_show`='{$_REQUEST[offer_show]}',
                `checkinstalled_method`='{$_REQUEST[checkinstalled_method]}',            
                `reg_path_pre`='{$_REQUEST[reg_path_pre]}',            
                `reg_path_64_pre`='{$_REQUEST[reg_path_64_pre]}',
                `reg_path_post`='{$_REQUEST[reg_path_post]}',            
                `reg_path_64_post`='{$_REQUEST[reg_path_64_post]}',
                `add_condition`='{$add_con}',
                `adjust_rate`='{$_REQUEST[adjust_rate]}',
                `offer_cap`='{$_REQUEST[offer_cap]}'
                WHERE `id`='{$offer_id}'
                ";                     
                
                //var_dump($sql);exit;
            mysql_query($sql);

            FB::log($sql);
            echo('<script language="JavaScript">window.location.href = "offer_list.php"</script>');
            break;
        }
    }
    else if($_REQUEST[mode] == "setting_price")
    {
        //var_dump($_POST['prices']);var_dump($_POST['country_ids']); exit;
        $sql = "DELETE FROM offer_prices_country WHERE offer_id={$_REQUEST[oid]}";
        mysql_query($sql);
        
        $sql = "INSERT INTO offer_prices_country(offer_id, country_id, price) VALUES";
        $xx = 0;
        
        
        foreach ($_POST['country_ids'] as $country_id)
        {
            $price = $_POST['prices'][$xx];
            $sql .= "({$_REQUEST[oid]}, {$country_id}, {$price}),";   
            $xx++;         
        }
        $sql = substr($sql,0,-1);  
        
        mysql_query($sql); 
        
        $sql = "SELECT * FROM `offers` WHERE `id`='{$_REQUEST[oid]}'";
        //var_dump($sql);exit;
        $q = mysql_query($sql);
        $row = mysql_fetch_assoc($q);
         
        foreach ($row as $key => $value) {
            $_REQUEST[$key] = $value;
        }    
    }
}

?>
<script type="text/javascript">

function FixRegPath()
{
    
    var str = $('#reg_path_pre').val(); 
 
    str = str.replace(/\\\\/g,'\\');  
    str = str.replace(/\\/g,'\\\\');  
    $('#reg_path_pre').val(str); 
    
    str = $('#reg_path_64_pre').val(); 
    str = str.replace(/\\\\/g,'\\');  
    str = str.replace(/\\/g,'\\\\');  
    $('#reg_path_64_pre').val(str);  
    
    str = $('#reg_path_post').val(); 
    str = str.replace(/\\\\/g,'\\');  
    str = str.replace(/\\/g,'\\\\');  
    $('#reg_path_post').val(str); 
    
    str = $('#reg_path_64_post').val(); 
    str = str.replace(/\\\\/g,'\\');  
    str = str.replace(/\\/g,'\\\\');  
    $('#reg_path_64_post').val(str);
}
</script>

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
                    Edit Offer
                    <small>edit application offer</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="offer_list.php">Offers List</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Edit Offer</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">Ã—</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Edit Application Offer</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="offer_edit.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>                                
                                <input type="hidden" name="oid" value="<?= $_REQUEST[oid] ?>"/>
                                <input type="hidden" name="mode" value="update_offer"/>                                
                                                                                                                                                                                              
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application Name</label>
                                    <div class="controls">
                                        <input type="text" id="software_name" name="offer_name" value="<?= $_REQUEST[offer_name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the offer application, which will be installed. This name will be shown in your installer. Eg: "Firefox"' data-original-title="Main Software Name" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Campaign Assigned To</label>
                                    <div class="controls">
                                        <select class="span6 chosen" name='assigned_user_id'>
                                            <option value="-1" <? if ($_REQUEST[assigned_user_id] == '-1') echo 'SELECTED'; ?>>Not yet assigned</option>
                                            <?
                                            $sql1 = "SELECT id, user_name, user_first_name, user_last_name, user_company_name FROM `users` WHERE `user_status`=2 ORDER BY `id` DESC";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[assigned_user_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[user_company_name] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" ><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application Description</label>
                                    <div class="controls">
                                        <textarea class="span6 editor popovers" rows="6" style="width: 700px;" id="offer_description" name="offer_description" data-trigger="hover" data-content='The description of the offer application, which will be installed. This will be shown in your installer.'><?= $_REQUEST[offer_description] ?></textarea>
                                    </div>
                                </div>
     
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application URL</label>
                                    <div class="controls">
                                        <input type="text" id="offer_url" name="offer_url" value="<?= $_REQUEST[offer_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct URL of the offer application download. Eg: "http://www.mozilla.org/en-US/products/download.html?product=firefox-18.0.1&os=win&lang=en-US"' data-original-title="Main Software URL" />
                                    </div>
                                </div>
                                
                                <hr>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Main Command Line 1</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_main" name="offer_silent_main" value="<?= $_REQUEST[offer_silent_main] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation 1 of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Main Command Line 2</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_main1" name="offer_silent_main1" value="<?= $_REQUEST[offer_silent_main1] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation 2 of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Main Command Line 3</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_main2" name="offer_silent_main2" value="<?= $_REQUEST[offer_silent_main2] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation 2 of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Main Command Line 4</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_main3" name="offer_silent_main3" value="<?= $_REQUEST[offer_silent_main3] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation 2 of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> CheckBox 1</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">On</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check1_on" name="offer_silent_check1_on" value="<?= $_REQUEST[offer_silent_check1_on] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">Off</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check1_off" name="offer_silent_check1_off" value="<?= $_REQUEST[offer_silent_check1_off] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> CheckBox 2</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">On</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check2_on" name="offer_silent_check2_on" value="<?= $_REQUEST[offer_silent_check2_on] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">Off</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check2_off" name="offer_silent_check2_off" value="<?= $_REQUEST[offer_silent_check2_off] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> CheckBox 3</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">On</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check3_on" name="offer_silent_check3_on" value="<?= $_REQUEST[offer_silent_check3_on] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">Off</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check3_off" name="offer_silent_check3_off" value="<?= $_REQUEST[offer_silent_check3_off] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> CheckBox 4</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">On</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check4_on" name="offer_silent_check4_on" value="<?= $_REQUEST[offer_silent_check4_on] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">Off</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check4_off" name="offer_silent_check4_off" value="<?= $_REQUEST[offer_silent_check4_off] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> CheckBox 5</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">On</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check5_on" name="offer_silent_check5_on" value="<?= $_REQUEST[offer_silent_check5_on] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3">Off</label>
                                    <div class="controls">
                                        <input type="text" id="offer_silent_check5_off" name="offer_silent_check5_off" value="<?= $_REQUEST[offer_silent_check5_off] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Main Software Silent Key" />
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="control-group">
                                    <label class="control-label-1" for="input3"> (If you select check installed method of dropdown , then registry keys will be ignored)</label>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Check Installed Method </label>
                                    <div class="controls">
                                        <select class="span6 chosen" name='checkinstalled_method' >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT * FROM checkinstalled_method";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[checkinstalled_method] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[method_name]?></option>
                                            <? } ?>
                                        </select>
                                    </div>      
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">Registry For Pre_Install on 32bit OS</label>
                                    <div class="controls">
                                        <!--<input type="text" id="reg_path_pre" name="reg_path_pre" value="<?= str_replace("\\\\","\\",$_REQUEST[reg_path_pre]) ?>" class="span6 popovers" data-trigger="hover" data-content='The registry path need to be checked to determine the successful installation. Eg: HKEY_CURRENT_USER\Software\Microsoft\MyCoolApp' data-original-title='Registry Path' />-->
                                        <textarea class="span6 popovers" wrap="off" rows="5" style="width: 700px;" id="reg_path_pre" name="reg_path_pre" data-trigger="hover" data-content='The description of the offer application, which will be installed. This will be shown in your installer.'><?= str_replace("\\\\","\\",$_REQUEST[reg_path_pre]) ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3">Registry For Pre-Install on 64bit OS</label>
                                    <div class="controls">
                                        <!--<input type="text" id="reg_path_64_pre" name="reg_path_64_pre" value="<?= str_replace("\\\\","\\",$_REQUEST[reg_path_64_pre]) ?>" class="span6 popovers" data-trigger="hover" data-content='The registry path need to be checked to determine the successful installation. Eg: HKEY_CURRENT_USER\Software\Microsoft\MyCoolApp' data-original-title='Registry Path For 64' />-->
                                        <textarea class="span6 popovers" wrap="off" rows="5" style="width: 700px;" id="reg_path_64_pre" name="reg_path_64_pre" data-trigger="hover" data-content='The description of the offer application, which will be installed. This will be shown in your installer.'><?= str_replace("\\\\","\\",$_REQUEST[reg_path_64_pre]) ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3">Registry For Post-Install 32bit OS</label>
                                    <div class="controls">
                                        <!--<input type="text" id="reg_path_post" name="reg_path_post" value="<?= str_replace("\\\\","\\",$_REQUEST[reg_path_post]) ?>" class="span6 popovers" data-trigger="hover" data-content='The registry path need to be checked to determine the successful installation. Eg: HKEY_CURRENT_USER\Software\Microsoft\MyCoolApp' data-original-title='Registry Path' />-->
                                        <textarea class="span6 popovers" wrap="off" rows="5" style="width: 700px;" id="reg_path_post" name="reg_path_post" data-trigger="hover" data-content='The description of the offer application, which will be installed. This will be shown in your installer.'><?= str_replace("\\\\","\\",$_REQUEST[reg_path_post]) ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3">Registry For Post-Install 64bit OS</label>
                                    <div class="controls">
                                        <!--<input type="text" id="reg_path_64_post" name="reg_path_64_post" value="<?= str_replace("\\\\","\\",$_REQUEST[reg_path_64_post]) ?>" class="span6 popovers" data-trigger="hover" data-content='The registry path need to be checked to determine the successful installation. Eg: HKEY_CURRENT_USER\Software\Microsoft\MyCoolApp' data-original-title='Registry Path For 64' />-->
                                        <textarea class="span6 popovers" wrap="off" rows="5" style="width: 700px;" id="reg_path_64_post" name="reg_path_64_post" data-trigger="hover" data-content='The description of the offer application, which will be installed. This will be shown in your installer.'><?= str_replace("\\\\","\\",$_REQUEST[reg_path_64_post]) ?></textarea>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="control-group">
                                    <!--<label class="control-label" for="input3"> Conditions</label>-->
                                    <div id="multi_header" style="width:500px;height:30px;margin: 10px 0px 0px 180px;">
                                        <div style="width:210px;height:30px;float:left;text-align: center;"> Additional Conditions </div>
                                        <div style="width:70px;height:30px;float:left;text-align: center;"><img src="../common/multiselector/images/switch.png" alt=""> </div>
                                        <div style="width:200px;height:30px;float:left;text-align: center;"> Required Conditions </div>
                                    </div>
                                    
                                    <div class="controls">
                                        <select id="conditions" class="multiselect" multiple="multiple" name="conditions[]" style="display: none; width:500px;height: 250px;">
                                          <?php       
                                                $add_con = $_REQUEST[add_condition];
                                                                                                                        
                                                if($add_con == "")
                                                {
                                                    $sql = "SELECT * FROM additional_conditions";     
                                                }                                               
                                                else
                                                {                                            
                                                    $sql = "SELECT * FROM additional_conditions WHERE id NOT IN (" . $add_con . ") ORDER BY id ASC";
                                                }
                                                //var_dump($sql);exit;
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                          ?>
                                                <option value="<?= $row[id]?>"> <?= $row[condition]?></option>
                                          <?php
                                                }
                                                
                                                if($add_con != "")
                                                {
                                                    $sql = "SELECT * FROM additional_conditions WHERE id IN (" .  $add_con . ") ORDER BY id ASC";
                                                
                                                    //var_dump($sql);exit;
                                                    $q = mysql_query($sql);
                                                    while ($row = mysql_fetch_assoc($q)) {
                                          ?>
                                                <option value="<?= $row[id]?>" selected > <?= $row[condition]?></option>
                                          <?php
                                                    }
                                                }        

                                          ?>    
                                          </select>                                                 
                                    </div>    
                                </div>
                                
                                <hr>
                                
                                <div class="control-group">
                                    <label class="control-label" >Application Visible</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                            <input type="checkbox" name="offer_show" id="offer_show" value="1" <? if (($_REQUEST[offer_show] == '1') || ($_REQUEST[offer_show] == '')) { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>
                                </div>
                                <hr>


                                <div class="control-group">
                                    <label class="control-label" for="input3">"Terms Of Service" URL</label>
                                    <div class="controls">
                                        <input type="text" id="offer_tos_url" name="offer_tos_url" value="<?= $_REQUEST[offer_tos_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "Terms Of Service" page. It is not a mandatory field. Eg: https://services.mozilla.com/tos/' data-original-title='"Terms Of Service" URL' />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">"Privacy Policy" URL</label>
                                    <div class="controls">
                                        <input type="text" id="offer_pp_url" name="offer_pp_url" value="<?= $_REQUEST[offer_pp_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "Privacy Policy" page. It is not a mandatory field. Eg: https://www.mozilla.org/en-US/privacy/' data-original-title='"Privacy Policy" URL' />
                                    </div>
                                </div>

                                <div class="control-group">

                                    <label class="control-label" for="input3">"EULA" URL</label>
                                    <div class="controls">
                                        <input type="text" id="offer_eula_url" name="offer_eula_url" value="<?= $_REQUEST[offer_eula_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "End User License Agreement (EULA)" page. It is not a mandatory field. Eg: http://www.mozilla.org/en-US/legal/eula/' data-original-title='"EULA" URL' />
                                    </div>

                                </div>

                                <hr>

                                <div class="control-group">
                                <!--
                                    <label class="control-label" for="input8">Price Per Install</label>
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <span class="add-on">$</span><input class="input-small" type="text" id="offer_price" name="offer_price" value="<?= $_REQUEST[offer_price] ?>"/>
                                        </div>
                                    </div>
                                -->
                                    <label class="control-label" for="input3">Price Per Install</label>
                                        <div class="controls">
                                            <a style="float: left;" a href="#myModal2" class="btn btn-success" data-toggle="modal"><i class="icon-plus-sign"></i> Setting Price Per Country</a>
                                        </div>
                                    </div> 
                                
                                <div class="control-group">
                                    <label class="control-label" for="input8">Adjust Discrepancy</label>
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <input class="input-small" type="text" id="adjust_rate" name="adjust_rate" value="<?= $_REQUEST[adjust_rate] ?>"/><span class="add-on">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input8">Offer Cap</label>
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <span class="add-on"><</span><input class="input-small" type="text" id="offer_cap" name="offer_cap" value="<?= $_REQUEST[offer_cap] ?>"/>
                                        </div>
                                    </div>
                                </div>
                                 

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick=" FixRegPath();$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Offer</a>
                                    <a href="offer_list.php" class="btn">Cancel</a>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                        
                        <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Ã—</button>
                                    <h4 id="myModalLabel1">Setting Price Per Country</h4>
                                </div>   
                                <div class="modal-body">
                                    <form action="offer_edit.php" class="form-horizontal" method="POST" id="set_price_form">
                                          
                                            <input type="hidden" name="oid" value="<?= $_REQUEST[oid] ?>"/>
                                            <input type="hidden" name="tryout" value="1"/>
                                            <input type="hidden" name="mode" value="setting_price"/>
                                            
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Country</th>                                                                
                                                        <th>Price</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>   
                                                <?                                            
                                                $arr_country_id = array(0, 223, 77, 39, 75, 57, 17);
                                                $arr_country_name = array('Default', 'US', 'UK', 'CA', 'FR', 'DE', 'AU');
                                                $arr_len = sizeof($arr_country_id);
                                                for($xx=0;$xx<$arr_len; $xx++)
                                                {
                                                    $country_id = $arr_country_id[$xx];
                                                    $sql1 = "SELECT price FROM offer_prices_country WHERE offer_id={$_REQUEST[oid]} AND country_id={$country_id}";
                                                    $q1 = mysql_query($sql1);
                                                    $row1 = mysql_fetch_assoc($q1);
                                                    $price = $row1[price];
                                                    if($price == NULL) $price = 0;
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td class="highlight"><?=$arr_country_name[$xx]?></td>
                                                        <td><input type="hidden" name="country_ids[]" value="<?=$country_id?>"><input type="input" name="prices[]" value="<?=$price?>"></td>
                                                    </tr>
                                                <?
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                    </form> 
                                </div> 
                                    
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                    <button class="btn btn-success" onclick="$('#set_price_form').submit();">Save</button>
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