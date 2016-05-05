<?
include 'z_header.php';
    
if ($_REQUEST[mode] == 'removed') {
    $offer_name = mysql_result(mysql_query("SELECT `offer_name` FROM `offers` WHERE `id`='{$_REQUEST[oid]}'"), 0);
    mysql_query("UPDATE offers SET status=1 WHERE `id`={$_REQUEST[oid]}");
}

if($_REQUEST[mode] == "copy")
{
    $oid = $_REQUEST[oid];
    $sql = "INSERT INTO offers(user_id, assigned_user_id, offer_datetime, offer_name, offer_description, offer_url, 
                                offer_silent_main, offer_silent_main1, offer_silent_check1_on, offer_silent_check1_off,
                                offer_silent_check2_on, offer_silent_check2_off, offer_silent_check3_on, offer_silent_check3_off,
                                offer_silent_check4_on, offer_silent_check4_off, offer_silent_check5_on, offer_silent_check5_off,
                                offer_tos_url, offer_pp_url, offer_eula_url, offer_show, offer_price, reg_path_pre, reg_path_64_pre,
                                reg_path_post, reg_path_64_post, checkinstalled_method, add_condition, adjust_rate, offer_cap ,status ) 
            SELECT user_id, assigned_user_id, NOW(), offer_name, offer_description, offer_url, 
                    offer_silent_main, offer_silent_main1, offer_silent_check1_on, offer_silent_check1_off,
                    offer_silent_check2_on, offer_silent_check2_off, offer_silent_check3_on, offer_silent_check3_off,
                    offer_silent_check4_on, offer_silent_check4_off, offer_silent_check5_on, offer_silent_check5_off,
                    offer_tos_url, offer_pp_url, offer_eula_url, offer_show, offer_price, reg_path_pre, reg_path_64_pre,
                    reg_path_post, reg_path_64_post, checkinstalled_method, add_condition, adjust_rate, offer_cap ,status 
            FROM offers WHERE id={$oid}";
    $q = mysql_query($sql);  
    echo('<script language="JavaScript">window.location.href = "offer_list.php"</script>');
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
                    Offers List
                    <small>list of the offers</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Offers List</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <?
            if ($_REQUEST[mode] == 'removed') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Offer <b>"<?= $offer_name ?>"</b> has been removed successfully from the list!
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Offers List</h4>
                        </div>
                        <div class="widget-body form">
                            <form action="offer_list.php" class="form-horizontal" method="POST" id="copy_form">
                                <input type="hidden" name="oid" value="0" id="copy_form_oid">
                                <input type="hidden" name="mode" value="copy">
                            </form>
                            
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">

                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" id="tab2" data-toggle="tab" >Paused Offers</a></li>
                                    <li <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab1" id="tab1" data-toggle="tab" >Actived Offers</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab1">
                                        <table class="table table-striped table-bordered" id="active_list">
                                        <thead>
                                            <tr>
                                                <th>OID</th>
                                                <th>Created Date/Time</th>
                                                <th>Created By</th>
                                                <th>Advertiser</th>  
                                                <th>Offer Name</th>
                                                <th>Default Price</th>
                                                <th>Offer Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?                                    
                                            $sql = "
        SELECT o.id, o.user_id, o.assigned_user_id, o.offer_datetime, o.offer_name, opc.price as offer_price, o.offer_show, 
               u1.user_first_name as created_first_name, u1.user_last_name as created_last_name, 
               u2.user_first_name as assigned_first_name, u2.user_last_name as assigned_last_name       
        FROM offers o      
             LEFT JOIN users u1 ON o.user_id=u1.id
             LEFT JOIN users u2 ON o.assigned_user_id=u2.id
             LEFT JOIN (SELECT offer_id, price FROM offer_prices_country WHERE country_id=0) opc ON o.id=opc.offer_id
        WHERE o.offer_show=1 AND o.status=0 ORDER BY o.id DESC
                                            ";
                                            
                                            $q = mysql_query($sql);
                                            while ($row = mysql_fetch_assoc($q)) {
                                                
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $row[id] ?></td>
                                                    <td><?= date_format(date_create($row[offer_datetime]), SHORTDATETIME) ?></td>
                                                    <td><a href="adv_edit.php?id=<?= $row[user_id] ?>"><?= $row[created_first_name] . ' ' . $row[created_last_name] ?></a></td>
                                                    <td><a href="adv_edit.php?id=<?= $row[assigned_user_id] ?>"><?= $row[assigned_first_name] . ' ' . $row[assigned_last_name] ?></a></td>
                                                    <td><?= $row[offer_name] ?></td>
                                                    <td>$<?= $row[offer_price] ?></td>
                                                    
                                                    <td><span class="label label-success">Active</span></td>
                                                    
                                                    <td class="center">
                                                        <a href="" onclick="document.getElementById('copy_form_oid').value=<?=$row[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Campaign"><i class="icon-plus"></i></a>&nbsp;                                                        
                                                        <a href="offer_edit.php?oid=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                        <a href="offer_list.php?mode=removed&oid=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[offer_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                        <a href="http://totalnethits.biz/download_offer.php?offer_id=<?= $row[id] ?>" class="icon icon-arrow-down" data-placement="bottom" data-original-title="Download Offer"></a>&nbsp;
                                                    </td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <table class="table table-striped table-bordered" id="paused_list">
                                        <thead>
                                            <tr>
                                                <th>OID</th>
                                                <th>Created Date/Time</th>
                                                <th>Created By</th>
                                                <th>Advertiser</th>  
                                                <th>Offer Name</th>
                                                <th>Default Price</th>
                                                <th>Offer Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?                                    
                                            $sql = "
        SELECT o.id, o.user_id, o.assigned_user_id, o.offer_datetime, o.offer_name, opc.price as offer_price, o.offer_show, 
               u1.user_first_name as created_first_name, u1.user_last_name as created_last_name, 
               u2.user_first_name as assigned_first_name, u2.user_last_name as assigned_last_name       
        FROM offers o      
             LEFT JOIN users u1 ON o.user_id=u1.id
             LEFT JOIN users u2 ON o.assigned_user_id=u2.id
             LEFT JOIN (SELECT offer_id, price FROM offer_prices_country WHERE country_id=0) opc ON o.id=opc.offer_id
        WHERE o.offer_show=0 AND o.status=0 ORDER BY o.id DESC
                                            ";
                                            
                                            $q = mysql_query($sql);
                                            while ($row = mysql_fetch_assoc($q)) {
                                                
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td><?= $row[id] ?></td>
                                                    <td><?= date_format(date_create($row[offer_datetime]), SHORTDATETIME) ?></td>
                                                    <td><a href="adv_edit.php?id=<?= $row[user_id] ?>"><?= $row[created_first_name] . ' ' . $row[created_last_name] ?></a></td>
                                                    <td><a href="adv_edit.php?id=<?= $row[assigned_user_id] ?>"><?= $row[assigned_first_name] . ' ' . $row[assigned_last_name] ?></a></td>
                                                    <td><?= $row[offer_name] ?></td>
                                                    <td>$<?= $row[offer_price] ?></td>
                                                    
                                                    <td> <span class="label label-default">Paused</span></td>
                                                    
                                                    <td class="center">
                                                        <a href="" onclick="document.getElementById('copy_form_oid').value=<?=$row[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Campaign"><i class="icon-plus"></i></a>&nbsp;                                                        
                                                        <a href="offer_edit.php?oid=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                        <a href="offer_list.php?mode=removed&oid=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[offer_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                    </td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            
                            <br>
                            <div class="form-actions" id="buttons_general"  style="<? if ($_REQUEST[tab] == '2') { ?> display: none; <? } ?> padding-left: 15px;">
                                <a href="offer_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Offer</a>
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