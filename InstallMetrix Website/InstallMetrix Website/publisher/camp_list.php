<?
include 'z_header.php';
     
     $act = $_REQUEST["mode"];
     if($act=="del")
     {
         $sql = "SELECT proj_name FROM projects WHERE id={$_REQUEST["cid"]}";         
         $proj_name = mysql_result(mysql_query($sql), 0);
         //$sql = "DELETE FROM projects WHERE id={$_REQUEST["cid"]}";
         $sql = "UPDATE projects SET status=1 WHERE id={$_REQUEST["cid"]}";
         $q = mysql_query($sql);
         //var_dump($sql);exit;
     }
     else if($act=="copy")
     {                                  
         $sql = "INSERT INTO projects(
            user_id,
            assigned_user_id,
            network_id,
            proj_datetime,
            proj_name,
            proj_description,
            proj_exe,
            proj_logo,
            status,
            software_name,
            software_version,
            software_description,
            software_url,
            software_silent,
            software_tos_url,
            software_pp_url,
            software_eula_url) 
            (SELECT  user_id,
                        assigned_user_id,
                        network_id,
                        proj_datetime,
                        CONCAT('copy-',proj_name),
                        proj_description,
                        proj_exe,
                        proj_logo,
                        status,
                        software_name,
                        software_version,
                        software_description,
                        software_url,
                        software_silent,
                        software_tos_url,
                        software_pp_url,
                        software_eula_url
            FROM projects p 
            WHERE id={$_REQUEST[cid]})";    
              
         
         
         $q = mysql_query($sql);
         $proj_id = mysql_insert_id(); 
           
         $logopath =  $my_common_path . 'installer_logos/';  
         
         $logo_src = $logopath . $_REQUEST[cid] . '.jpg';
         $logo_dst = $logopath . $proj_id . '.jpg';
         copy($logo_src, $logo_dst);
         
         //copy projects template
         $sql = "INSERT INTO template_campaigns(template_id, camp_id) 
                (SELECT template_id, {$proj_id} FROM template_campaigns WHERE camp_id={$_REQUEST[cid]}) ";
         //var_dump($sql);exit;
         $q = mysql_query($sql);
         
         //copy projects_offer
         $sql = "INSERT INTO bundle_campaigns(bundle_id, camp_id) 
                (SELECT bundle_id, {$proj_id} FROM bundle_campaigns WHERE camp_id={$_REQUEST[cid]})";
         $q = mysql_query($sql);
         
         //copy exit url part
         $sql = "INSERT INTO exiturl_campaigns(exiturl_id, proj_id) 
                (SELECT exiturl_id, {$proj_id} FROM exiturl_campaigns WHERE proj_id={$_REQUEST[cid]})";
         $q = mysql_query($sql);
         
         echo('<script language="JavaScript">window.location.href = "camp_list.php"</script>');
         break;
            
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
                    Campaigns List
                    <small>list of your installation packages</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Campaigns List</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>

        <form action="#" class="form-horizontal" id="form_1" method="POST">

            <div class="control-group">
                <label class="control-label" for="input3">Campaign Name Search:</label>
                <div class="controls">
                    <input type="text" id="search_string_1" name="search_string_1" value="<?= $_REQUEST[search_string_1] ?>" class="span12"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="input3">Publisher Name Search:</label>
                <div class="controls">
                    <input type="text" id="search_string_2" name="search_string_2" value="<?= $_REQUEST[search_string_2] ?>" class="span12"/>
                </div>
            </div>


        </form>


        <div style="height: 45px;">
			    <a href="#" class="btn btn-success" name = "html"
				    onclick="$('#type1').value = 'html';$('#form_1').submit();"
                <i class="icon-check"></i>Update Campaign List</a>
                <a href="#" class="btn btn-success" name = "html"
                    onclick="
                    $('#search_string_1').val('');
                    $('#search_string_2').val('');
                    $('#type1').value = 'html';$('#form_1').submit();"
                <i class="icon-check"></i>Get Full List</a>
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
            if ($_REQUEST[mode] == 'del') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Project <b>"<?= $proj_name ?>"</b> has been removed successfully from the list!
                </div>
            <? } ?>
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Campaigns List</h4>
                        </div>
                        <div class="widget-body form">
                            <form action="camp_list.php" class="form-horizontal" method="POST" id="copy_form">
                                <input type="hidden" name="cid" value="0" id="copy_form_cid">
                                <input type="hidden" name="mode" value="copy">
                            </form>
                            <!-- BEGIN FORM-->
                            <table class="table table-striped table-bordered" id="other_list">
                                <thead>
                                    <tr>
                                        <th>CID</th>
                                        <th>Created Date/Time</th>
                                        <th>Created By</th>
                                        <th>Assigned To</th>
                                        <th>Campaign Name</th>
                                        <th>Application</th>
                                        <th>Download URL</th>
                                                                                  
                                        <th>Campaign Status</th>
                                        <!--<th>Actions</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $sql = "SELECT p.*, um.*
                                            FROM projects p, (SELECT u1.id as user_id, u1.user_first_name, u1.user_last_name, u2.id as PM_id, u2.user_first_name as PM_first_name, u2.user_last_name as PM_last_name FROM users u1, users u2 WHERE u1.id={$user_id} AND u1.user_manager=u2.id) um 
                                            WHERE p.assigned_user_id=um.user_id AND proj_name like '%".$_REQUEST['search_string_1']."%' AND p.status=0 AND
                                            ( user_first_name like '%".$_REQUEST['search_string_2']."%' or user_last_name like '%".$_REQUEST['search_string_2']."%')
                                            ORDER BY p.id ";
                                    //var_dump($sql);exit;
                                    $q = mysql_query($sql);
                                    while ($row = mysql_fetch_assoc($q)) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="highlight"><div class="success"></div><?= $row[id] ?></td>
                                            <td><?= date_format(date_create($row[proj_datetime]), SHORTDATETIME) ?></td>
                                            <td><?= $row[PM_first_name] . ' ' . $row[PM_last_name] ?></td>
                                            <td><?= $row[user_first_name] . ' ' . $row[user_last_name] ?></td>
                                            <td><?= $row[proj_name] ?></td>
                                            <td><?= $row[software_name] . ' ' . $row[software_version] ?></td>
                                            <td>
                                            <?
                                                $sql1 = "   SELECT d.domain FROM domains d LEFT JOIN domain_publisher dp ON dp.domain_id=d.id
                                                            WHERE dp.pub_id={$row[user_id]} ORDER BY dp.id DESC
                                                " ;
                                                //var_dump($sql1);exit;
                                                $q1 = mysql_query($sql1);
                                                while($row1 = mysql_fetch_assoc($q1))
                                                {
                                                    $download_url = $row1[domain] . "/download_gate.php?cid=";
                                            ?>
                                            <a href="<?=$download_url ?><?= $row[id] ?>&file=<?= $row[proj_exe] ?>"><? echo($download_url . $row[id] . "&file=" . $row[proj_exe]); ?></a><br>
                                            <?
                                                }
                                            ?>                                             
                                            </td>
                                            
                                            
                                            <td><span class="label label-success">Active</span></td>
                                            <!--
                                            <td class="center">
                                                <a href="<?=$download_url ?><?= $row[id] ?>&file=<?= $row[proj_exe] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Direct download EXE File"><i class="icon-download-alt"></i></a>&nbsp;                                                
                                                <a href="camp_edit.php?cid=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Campaign"><i class="icon-pencil"></i></a>&nbsp;
                                                <a href="camp_list.php?cid=<?=$row[id]?>&mode=del" onclick="return confirm('Are you sure to remove <?= $row[proj_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Campaign"><i class="icon-remove"></i></a>&nbsp;
                                                <a href="" onclick="document.getElementById('copy_form_cid').value=<?=$row[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Campaign"><i class="icon-plus"></i></a>&nbsp;
                                            </td>
                                            -->
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                            
                            
                            <!-- END FORM-->
                            <br>
                            <!--
                            <div class="form-actions" id="buttons_general"  style="<? if ($_REQUEST[tab] == '2') { ?> display: none; <? } ?> padding-left: 15px;">
                                <a href="camp_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Campaign</a>
                            </div>
                            -->
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
