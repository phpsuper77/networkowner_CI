<?
include 'z_header.php';
    
if ($_REQUEST[mode] == 'removed') {
    $offer_name = mysql_result(mysql_query("SELECT `name` FROM `offergroups` WHERE `id`='{$_REQUEST[id]}'"), 0);   
   mysql_query("UPDATE offergroups SET status=1 WHERE id={$_REQUEST[id]}");
}

if($_REQUEST[mode] == "copy")
{
    $oid = $_REQUEST[oid];
    $sql = "INSERT INTO offergroups(name, description, status, offer1_id, isdefault_1, offer2_id, isdefault_2, 
                                offer3_id, isdefault_3, offer4_id, isdefault_4, offer5_id, isdefault_5) 
            SELECT name, description, status, offer1_id, isdefault_1, offer2_id, isdefault_2, 
                    offer3_id, isdefault_3, offer4_id, isdefault_4, offer5_id, isdefault_5 
            FROM offergroups WHERE id={$oid}";
            
    $q = mysql_query($sql);  
    echo('<script language="JavaScript">window.location.href = "offergroup_list.php"</script>');
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
                    Offers Group List
                    <small>list of the offer groups</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Offers Group List</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <?
            if ($_REQUEST[mode] == 'removed') {
                ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert"></button>
                    Offer Group<b>"<?= $offer_name ?>"</b> has been removed successfully from the list!
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Offers Group List</h4>
                        </div>
                        <div class="widget-body form">
                            <form action="offergroup_list.php" class="form-horizontal" method="POST" id="copy_form">
                                <input type="hidden" name="oid" value="0" id="copy_form_oid">
                                <input type="hidden" name="mode" value="copy">
                            </form>
                            
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">

                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" id="tab2" data-toggle="tab" >Paused OfferGroups</a></li>
                                    <li <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab1" id="tab1" data-toggle="tab" >Actived OfferGroups</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab1">
                                        <!-- BEGIN FORM-->
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>OGID</th>
                                                    <th>Created Date/Time</th>                                        
                                                    <th>Group Name</th>
                                                    <th>Offer1</th>
                                                    <th>Offer2</th>
                                                    <th>Offer3</th>
                                                    <th>Offer4</th>
                                                    <th>Offer5</th>
                                                    <th>Action</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $sql = "SELECT og.*
                                                    , (SELECT offer_name FROM offers where id=og.offer1_id) as offer1_name
                                                    , (SELECT offer_name FROM offers where id=og.offer2_id) as offer2_name
                                                    , (SELECT offer_name FROM offers where id=og.offer3_id) as offer3_name
                                                    , (SELECT offer_name FROM offers where id=og.offer4_id) as offer4_name
                                                    , (SELECT offer_name FROM offers where id=og.offer5_id) as offer5_name
                                                     FROM offergroups og WHERE og.status=0"; 
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $row[id] ?></td>
                                                        <td><?= date_format(date_create($row[offergroup_datetime]), SHORTDATETIME) ?></td>
                                                        <td><?= $row[name] ?></td>
                                                        <td><?= $row[offer1_name] ?></td>
                                                        <td><?= $row[offer2_name] ?></td>
                                                        <td><?= $row[offer3_name] ?></td>
                                                        <td><?= $row[offer4_name] ?></td>
                                                        <td><?= $row[offer5_name] ?></td>
                                                        <td><span class="label label-success">Active</span></td>
                                                        <td class="center">   
                                                            <a href="" onclick="document.getElementById('copy_form_oid').value=<?=$row[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Offergroup"><i class="icon-plus"></i></a>&nbsp;                                             
                                                            <a href="offergroup_edit.php?id=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="offergroup_list.php?mode=removed&id=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                        </td>
                                                    </tr>
                                                <? } ?>
                                            </tbody>
                                        </table>
                                        <!-- END FORM-->
                                    </div>
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <!-- BEGIN FORM-->
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>OGID</th>
                                                    <th>Created Date/Time</th>                                        
                                                    <th>Group Name</th>
                                                    <th>Offer1</th>
                                                    <th>Offer2</th>
                                                    <th>Offer3</th>
                                                    <th>Offer4</th>
                                                    <th>Offer5</th>
                                                    <th>Active</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $sql = "SELECT og.*
                                                    , (SELECT offer_name FROM offers where id=og.offer1_id) as offer1_name
                                                    , (SELECT offer_name FROM offers where id=og.offer2_id) as offer2_name
                                                    , (SELECT offer_name FROM offers where id=og.offer3_id) as offer3_name
                                                    , (SELECT offer_name FROM offers where id=og.offer4_id) as offer4_name
                                                    , (SELECT offer_name FROM offers where id=og.offer5_id) as offer5_name
                                                     FROM offergroups og WHERE og.status=2"; 
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td><?= $row[id] ?></td>
                                                        <td><?= date_format(date_create($row[offergroup_datetime]), SHORTDATETIME) ?></td>
                                                        <td><?= $row[name] ?></td>
                                                        <td><?= $row[offer1_name] ?></td>
                                                        <td><?= $row[offer2_name] ?></td>
                                                        <td><?= $row[offer3_name] ?></td>
                                                        <td><?= $row[offer4_name] ?></td>
                                                        <td><?= $row[offer5_name] ?></td>
                                                        <td> <span class="label label-default">Paused</span></td>                                            
                                                        <td class="center"> 
                                                            <a href="" onclick="document.getElementById('copy_form_oid').value=<?=$row[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Offergroup"><i class="icon-plus"></i></a>&nbsp;                                               
                                                            <a href="offergroup_edit.php?id=<?= $row[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="offergroup_list.php?mode=removed&id=<?= $row[id] ?>" onclick="return confirm('Are you sure to remove <?= $row[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                        </td>
                                                    </tr>
                                                <? } ?>
                                            </tbody>
                                        </table>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                            </div>
                                    
                            <br>
                            <div class="form-actions" id="buttons_general"  style="padding-left: 15px;">
                                <a href="offergroup_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Group</a>
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