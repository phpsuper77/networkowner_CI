<?
include 'z_header.php';

FB::log($_SERVER);

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    $_REQUEST[proj_exe] = str_ireplace('.exe', '', $_REQUEST[proj_exe]);

    if ($_REQUEST[proj_exe] == '') {
        $_REQUEST[proj_exe] = 'installfactory';
    }

    if ($_REQUEST[proj_name] == '') {
        $errmsg.='<li>Field "Campaign Name" should not be empty</li>';
    }

    if ($_REQUEST[assigned_user_id] == '') {
        $errmsg.='<li>Field "Campaign Assigned To" should not be empty</li>';
    }

    if (!preg_match('~^[a-z0-9_\-]*$~i', $_REQUEST[proj_exe])) {
        $errmsg.='<li>Field "Installer EXE name" should contain only [A-Z], [a-z] and [0-9]</li>';
    }

    if ($_REQUEST[software_name] == '') {
        $errmsg.='<li>Field "Application Name" should not be empty</li>';
    }
  
    if ($_REQUEST[software_url] == '') {
        $errmsg.='<li>Field "Application URL" should not be empty</li>';
    }

    if ($_REQUEST[software_silent] == '') {
        $errmsg.='<li>Field "Application Silent Key" should not be empty</li>';
    }
    
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
        
        $strdesc =  $_REQUEST[software_description];        
        $strdesc = str_replace("\\r\\n","",$strdesc);
        $strdesc = str_replace("\\","",$strdesc);   
        $_REQUEST[software_description] =  $strdesc;        
    } 
    else {
        
        
        $proj_exe = $_REQUEST[proj_exe] . ".exe";
        
        /*
        //if proj_exe is new string, then get new campaign using windows api server
        $sql_exe = "SELECT * FROM projects WHERE proj_exe='{$proj_exe}'";
        $q_exe = mysql_query($sql_exe);
        $num_exe = mysql_numrows($q_exe);
        if($num_exe == 0)
        {
            ///get installer for gampaign from windows api    
            //make new isntaller to windows server
            $signurl = "http://totalnethits.biz/signcampaign.php?name=" . $_REQUEST[proj_exe];
            $res = file_get_contents($signurl);          
            
            //copy the installer from windows server to totalnetiz.biz
            $geturl = "http://totalnethits.biz/getcampaign.php?name=" . $_REQUEST[proj_exe];
            $res = file_get_contents($geturl);          
        }
         */
        
        mysql_query("INSERT INTO `projects`(
            `user_id`,
            `assigned_user_id`,
            `network_id`,
            `proj_datetime`,
            `proj_name`,
            `proj_description`,
            `proj_exe`,
            `software_name`,
            `software_version`,
            `software_description`,
            `software_url`,
            `software_silent`,
            `software_tos_url`,
            `software_pp_url`,
            `software_eula_url`
            ) VALUES (
            '{$_SESSION[user_id]}',
            '{$_REQUEST[assigned_user_id]}',
            '{$_SESSION[network_id]}',
            NOW(),
            '{$_REQUEST[proj_name]}',
            '{$_REQUEST[proj_description]}',
            '{$_REQUEST[proj_exe]}',
            '{$_REQUEST[software_name]}',
            '{$_REQUEST[software_version]}',
            '{$_REQUEST[software_description]}',
            '{$_REQUEST[software_url]}',
            '{$_REQUEST[software_silent]}',
            '{$_REQUEST[software_tos_url]}',
            '{$_REQUEST[software_pp_url]}',
            '{$_REQUEST[software_eula_url]}' 
            )");

        $proj_id = mysql_insert_id();

        $logopath =  $my_common_path . 'installer_logos/';
        
        $logo_url = "";
        if (is_uploaded_file($_FILES["proj_logo"]["tmp_name"])) {
            
            move_uploaded_file($_FILES["proj_logo"]["tmp_name"], $logopath . $proj_id . '.jpg');
            //custom_crop($logopath . $proj_id . '_tmp.jpg',$logopath . $proj_id . '.jpg', 210, 400);
            //unlink($logopath . $proj_id . '_tmp.jpg');
            mysql_query("UPDATE `projects` SET `proj_logo`=1 WHERE `id`={$proj_id}");
            $logo_url = $common_path_url . 'installer_logos/' . $proj_id . '.jpg'; 
        }
         
        echo('<script language="JavaScript">window.location.href = "camp_edit.php?cid=' . $proj_id . '&new_camp=1"</script>');
        break;
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
                    Add New Campaign
                    <small>create your own installation package</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New Campaign</a></li>
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
                            <h4><i class="icon-reorder"></i>  General Campaign Settings</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="camp_add.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Campaign Name</label>
                                    <div class="controls">
                                        <input type="text" id="proj_name" name="proj_name" value="<?= $_REQUEST[proj_name] ?>" class="span6 popovers" data-trigger="hover" data-content="Name of your campaign. This name will be shown only to you." data-original-title="Campaign Name" />
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Campaign Assigned To</label>
                                    <div class="controls">
                                        <select class="span6 chosen" name='assigned_user_id'>
                                            <option value="-1" <? if ($_REQUEST[assigned_user_id] == '-1') echo 'SELECTED'; ?>>Not yet assigned</option>
                                            <?
                                            $sql1 = "SELECT id, user_name, user_first_name, user_last_name FROM `users` WHERE `user_status`=3 ORDER BY `id` DESC";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[assigned_user_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[user_first_name] . ' ' . $row1[user_last_name] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="inputRemarks">Campaign Description</label>
                                    <div class="controls">
                                        <textarea class="span6 popovers" rows="3" id="proj_description" name="proj_description" style="resize: none;" data-trigger="hover" data-content="Description of your campaign. This description will be shown only to you. It is not a mandatory field." data-original-title="Campaign Description"><?= $_REQUEST[proj_description] ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">Installer EXE name</label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" id="proj_exe" name="proj_exe" value="<?= str_ireplace('.exe', '', $_REQUEST[proj_exe]) ?>" class="input-large popovers"><span class="add-on">.exe</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Installer Logo</label>
                                    <div class="controls">

                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 250px; height: 250px;"><img src="" alt=""/></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" class="default" name="proj_logo"/></span>
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                            
                                        </div>
                                        <span class="label label-important">NOTE!</span>
                                        <span class="help-inline">Please use .jpg file.</span>
                                    </div>
                                </div>

                                <hr>


                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application Name</label>
                                    <div class="controls">
                                        <input type="text" id="software_name" name="software_name" value="<?= $_REQUEST[software_name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the main application, which will be installed. This name will be shown in your installer. Eg: "Firefox"' data-original-title="Main Software Name" />
                                    </div>
                                </div>
       
                                <div class="control-group">
                                    <label class="control-label" for="input3">Application Version</label>
                                    <div class="controls">
                                        <input type="text" id="software_version" name="software_version" value="<?= $_REQUEST[software_version] ?>" class="span6 popovers" data-trigger="hover" data-content='The version of the main application, which will be installed. This will be shown in your installer. It is not a mandatory field. Eg: "18.0.1"' data-original-title="Main Software Version" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Application URL</label>
                                    <div class="controls">
                                        <input type="text" id="software_url" name="software_url" value="<?= $_REQUEST[software_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct URL of the main application, which will be installed. Eg: "http://www.mozilla.org/en-US/products/download.html?product=firefox-18.0.1&os=win&lang=en-US"' data-original-title="Main Software URL" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Command Line Parameters</label>
                                    <div class="controls">
                                        <input type="text" id="software_silent" name="software_silent" value="<?= $_REQUEST[software_silent] ?>" class="span6 popovers" data-trigger="hover" data-content='The key to the silent installation of the main application, which will be installed. Eg: "/S" or "-s"' data-original-title="Command Line Parameters" />
                                    </div>
                                </div>
                                <hr>


                                <div class="control-group">
                                    <label class="control-label" for="input3">"Terms Of Service" URL</label>
                                    <div class="controls">
                                        <input type="text" id="software_tos_url" name="software_tos_url" value="<?= $_REQUEST[software_tos_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "Terms Of Service" page. It is not a mandatory field. Eg: https://services.mozilla.com/tos/' data-original-title='"Terms Of Service" URL' />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">"Privacy Policy" URL</label>
                                    <div class="controls">
                                        <input type="text" id="software_pp_url" name="software_pp_url" value="<?= $_REQUEST[software_pp_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "Privacy Policy" page. It is not a mandatory field. Eg: https://www.mozilla.org/en-US/privacy/' data-original-title='"Privacy Policy" URL' />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3">"EULA" URL</label>
                                    <div class="controls">
                                        <input type="text" id="software_eula_url" name="software_eula_url" value="<?= $_REQUEST[software_eula_url] ?>" class="span6 popovers" data-trigger="hover" data-content='The direct link to the "End User License Agreement (EULA)" page. It is not a mandatory field. Eg: http://www.mozilla.org/en-US/legal/eula/' data-original-title='"EULA" URL' />
                                    </div>
                                </div>
                                
                                <hr>

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Campaign</a>
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
