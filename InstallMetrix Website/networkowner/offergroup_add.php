<?
include 'z_header.php';


if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    //var_dump($_REQUEST);exit;
    if ($_REQUEST[name] == '') {
        $errmsg.='<li>Field "Group Name" should not be empty</li>';
    }


    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } else {
                       
        $str_offerdesc = $_REQUEST[description];
        $str_offerdesc = str_replace("<a href","<a target=\"_blank\" href", $str_offerdesc);    
              
        $sql =  "INSERT INTO `offergroups`(
            `name`,
            `description`,
            `offergroup_datetime`,
            `offer1_id`,            
            `isdefault_1`,
            `offer2_id`,            
            `isdefault_2`,
            `offer3_id`,            
            `isdefault_3`,
            `offer4_id`,            
            `isdefault_4`,
            `offer5_id`,            
            `isdefault_5`            
            ) VALUES (
            '{$_REQUEST[name]}',
            '{$str_offerdesc}',
                NOW(),
            '{$_REQUEST[offer1_id]}',
            '{$_REQUEST[isdefault_1]}',
            '{$_REQUEST[offer2_id]}',
            '{$_REQUEST[isdefault_2]}',
            '{$_REQUEST[offer3_id]}',
            '{$_REQUEST[isdefault_3]}',
            '{$_REQUEST[offer4_id]}',
            '{$_REQUEST[isdefault_4]}',
            '{$_REQUEST[offer5_id]}',
            '{$_REQUEST[isdefault_5]}'            
            )";   
            
        //var_dump($sql);exit;
        mysql_query($sql);

        $offer_id = mysql_insert_id();

        echo('<script language="JavaScript">window.location.href = "offergroup_list.php"</script>');
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
                    Add New Offer Group
                    <small>add new group</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="offer_list.php">Offers Group List</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New Offer Group</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Add New Offer Group</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="offergroup_add.php" class="form-horizontal" method="POST" id="add_form">
                                <input type="hidden" name="tryout" value="1"/>
  
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Offer Group Name</label>
                                    <div class="controls">
                                        <input type="text" id="group_name" name="name" value="<?= $_REQUEST[name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the offer group' data-original-title="Offer Group Name" />
                                    </div>
                                </div>
                                
                                
                                <div class="control-group">
                                    <label class="control-label" >Offer Group Description</label>
                                    <div class="controls">
                                        <textarea class="span6 editor popovers" rows="6" style="width: 700px;" id="group_description" name="description" data-trigger="hover" data-content='The description of the offer group.'><?= $_REQUEST[description] ?></textarea>
                                    </div>
                                </div>
                                
                                <hr>
                                
  
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Offer 1 </label>
                                    <div class="controls form-inline" style="margin-left: 50px; float: left; width: 300px;">
                                        <select class="span6 chosen" name='offer1_id' style="width: 240px;" >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.assigned_user_id=u.id AND o.status=0 AND o.offer_show=1";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[offer1_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[offer_name]?> ( <?=$row1[user_company_name] ?> )</option>
                                            <? } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label" for="input3"> IsDefault </label>   
                                    <div class="controls" style="float: left; margin-left: 50px;">
                                        <label class="checkbox">
                                            <input type="checkbox" name="isdefault_1" id="isdefault_1" value="1" <? if ($_REQUEST[isdefault_1] == '1') { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>  
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Offer 2 </label>
                                    <div class="controls form-inline" style="margin-left: 50px; float: left; width: 300px;">
                                        <select class="span6 chosen" name='offer2_id' style="width: 240px;" >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.assigned_user_id=u.id AND o.status=0 AND o.offer_show=1";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[offer2_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[offer_name]?> ( <?=$row1[user_company_name] ?> )</option>
                                            <? } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label" for="input3"> IsDefault </label>   
                                    <div class="controls" style="float: left; margin-left: 50px;">
                                        <label class="checkbox">
                                            <input type="checkbox" name="isdefault_2" id="isdefault_2" value="1" <? if ($_REQUEST[isdefault_2] == '1') { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>  
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Offer 3 </label>
                                    <div class="controls form-inline" style="margin-left: 50px; float: left; width: 300px;">
                                        <select class="span6 chosen" name='offer3_id' style="width: 240px;" >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.assigned_user_id=u.id AND o.status=0 AND o.offer_show=1";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[offer3_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[offer_name]?> ( <?=$row1[user_company_name] ?> )</option>
                                            <? } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label" for="input3"> IsDefault </label>   
                                    <div class="controls" style="float: left; margin-left: 50px;">
                                        <label class="checkbox">
                                            <input type="checkbox" name="isdefault_3" id="isdefault_3" value="1" <? if ($_REQUEST[isdefault_3] == '1') { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>  
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Offer 4 </label>
                                    <div class="controls form-inline" style="margin-left: 50px; float: left; width: 300px;">
                                        <select class="span6 chosen" name='offer4_id' style="width: 240px;" >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.assigned_user_id=u.id AND o.status=0 AND o.offer_show=1";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[offer4_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[offer_name]?> ( <?=$row1[user_company_name] ?> )</option>
                                            <? } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label" for="input3"> IsDefault </label>   
                                    <div class="controls" style="float: left; margin-left: 50px;">
                                        <label class="checkbox">
                                            <input type="checkbox" name="isdefault_4" id="isdefault_4" value="1" <? if ($_REQUEST[isdefault_4] == '1') { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>  
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Offer 5 </label>
                                    <div class="controls form-inline" style="margin-left: 50px; float: left; width: 300px;">
                                        <select class="span6 chosen" name='offer5_id' style="width: 240px;" >
                                            <option value="0">&nbsp;</option>
                                            <?
                                            $sql1 = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.assigned_user_id=u.id AND o.status=0 AND o.offer_show=1";
                                            $q1 = mysql_query($sql1);
                                            while ($row1 = mysql_fetch_assoc($q1)) {
                                                ?>
                                                <option value="<?= $row1[id] ?>" <? if ($_REQUEST[offer5_id] == $row1[id]) echo 'SELECTED'; ?>><?= $row1[offer_name]?> ( <?=$row1[user_company_name] ?> )</option>
                                            <? } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label" for="input3"> IsDefault </label>   
                                    <div class="controls" style="float: left; margin-left: 50px;">
                                        <label class="checkbox">
                                            <input type="checkbox" name="isdefault_5" id="isdefault_5" value="1" <? if ($_REQUEST[isdefault_5] == '1') { ?> CHECKED <? } ?>/>
                                        </label>
                                    </div>  
                                </div>
                              

                                <hr>
             
                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick=" $('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Offer</a>
                                    <a href="offer_list.php" class="btn">Cancel</a>
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