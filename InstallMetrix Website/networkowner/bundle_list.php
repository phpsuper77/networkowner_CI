<?
include 'z_header.php';

if ($_REQUEST[mode] == 'removed') {
    $offer_name = mysql_result(mysql_query("SELECT name FROM bundles WHERE id='{$_REQUEST[id]}'"), 0);
   //mysql_query("DELETE FROM `offergroups` WHERE `id`={$_REQUEST[id]}");
   mysql_query("UPDATE bundles SET status=1 WHERE id={$_REQUEST[id]}");
}

if($_REQUEST[mode] == "copy")
{
    $id = $_REQUEST[id];
    $sql = "INSERT INTO bundles(name, create_datetime, status, isdemo, min_offerspot) 
            SELECT name, NOW(), status, isdemo, min_offerspot 
            FROM bundles WHERE id={$id}";   
    //var_dump($sql);exit;     
    mysql_query($sql);  
    
    $new_bundle_id = mysql_insert_id();
    
    $sql = "INSERT INTO bundle_categories(bundle_id, cat_id, cat_order)
            SELECT {$new_bundle_id}, cat_id, cat_order FROM bundle_categories WHERE bundle_id={$id}";
    mysql_query($sql);  
    
    $sql = "INSERT INTO bundle_offers(bundle_id, cat_id, offer_id, isgroup, isactive)
            SELECT {$new_bundle_id}, cat_id, offer_id, isgroup, isactive FROM bundle_offers WHERE bundle_id={$id}";
    mysql_query($sql);  
    
    $sql = "INSERT INTO bundle_campaigns(bundle_id, camp_id)
            SELECT {$new_bundle_id}, camp_id FROM bundle_campaigns WHERE bundle_id={$id}";
    mysql_query($sql);              
            
    echo('<script language="JavaScript">window.location.href = "bundle_list.php"</script>');
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
                    Offer Bundle List
                    <small>list of offer bundles</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Offers Bundle List</a></li>
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
                    <button class="close" data-dismiss="alert"></button>
                    Offer Bundle<b>"<?= $offer_name ?>"</b> has been removed successfully from the list!
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Offers Bundle List</h4>
                        </div>
                        
                        <div class="widget-body form">
                            <form action="bundle_list.php" class="form-horizontal" method="POST" id="copy_form">
                                <input type="hidden" name="id" value="0" id="copy_form_id">
                                <input type="hidden" name="mode" value="copy">
                            </form>
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">
                                    <li <? if ($_REQUEST[tab] == '3') { ?>class="active"<? } ?>><a href="#portlet_tab3" id="tab3" data-toggle="tab" >Demo Offer Bundles</a></li>
                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" id="tab2" data-toggle="tab" >Paused Offer Bundles</a></li>
                                    <li <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab1" id="tab1" data-toggle="tab" >Actived Offer Bundles</a></li>
                                </ul>
                                <div class="tab-content" style="font-size: 12px;">
                                    <div class="tab-pane <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab1">
                                        <!-- BEGIN FORM-->
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>OBID</th>
                                                    <th>Created Date/Time</th>                                        
                                                    <th>Bundle Name</th>
                                                    <th>Category 1</th>
                                                    <th>Category 2</th>
                                                    <th>Category 3</th>
                                                    <th>Category 4</th>
                                                    <th>Category 5</th>
                                                    <th>Category 6</th>
                                                    <th>Category 7</th>
                                                    <th>Category 8</th>
                                                    <th>Campaigns</th>
                                                    <!--<th>Active</th>-->
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $table_body = "";
                                                
                                                $sql_bundle = "SELECT b.*, (SELECT count(bc.id) FROM bundle_campaigns bc WHERE bc.bundle_id=b.id) as cc 
                                                                FROM bundles b WHERE status=0 AND isdemo=0";
                                                $q_bundle = mysql_query($sql_bundle);
                                                while($row_bundle=mysql_fetch_assoc($q_bundle))
                                                {
                                                ?>
                                                    <tr class="odd gradeX">
                                                    <td><?= $row_bundle[id] ?></td>
                                                    <td><?= date_format(date_create($row_bundle[create_datetime]), SHORTDATETIME) ?></td>
                                                    <td><?= $row_bundle[name] ?></td>
                                                <?
                                                    $sql_cat = "SELECT b.*, c.name as cat_name, bc.cat_order, bc.cat_id FROM bundles b, categories c, bundle_categories bc
                                                        WHERE b.id=bc.bundle_id AND b.id={$row_bundle[id]} AND bc.cat_id=c.id AND c.status=0 ORDER BY bc.cat_order ";
                                                    $q_cat = mysql_query($sql_cat);
                                                    
                                                    $td_str = "";                               
                                                    $count_cat = 0;                                                                                
                                                    while($row_cat=mysql_fetch_assoc($q_cat))
                                                    {
                                                        $td_str .= "<td>" . $row_cat[cat_name] . "<br>";
                                                        
                                                        $sql_oc = " SELECT oc.offer_id, oc.isgroup FROM offer_categories oc, bundle_offers bo 
                                                                    WHERE bo.isactive=1 AND bo.offer_id=oc.offer_id AND bo.cat_id={$row_cat[cat_id]} AND 
                                                                    bo.bundle_id={$row_cat[id]} AND category_id={$row_cat[cat_id]}";    
                                                        //var_dump($sql_oc); exit;                                       
                                                        $q_oc = mysql_query($sql_oc);                                            
                                                        while($row_oc=mysql_fetch_assoc($q_oc))
                                                        {
                                                            if($row_oc[isgroup] == 0)
                                                            {
                                                                $sql_o = "SELECT offer_name as name FROM offers WHERE id={$row_oc[offer_id]} AND offer_show=1 AND status=0";
                                                            }
                                                            else
                                                            {
                                                                $sql_o = "SELECT name FROM offergroups WHERE id={$row_oc[offer_id]} AND status=0";    
                                                            }
                                                            //var_dump($sql_o);
                                                            $q_o = mysql_query($sql_o);
                                                            $cc_o = mysql_numrows($q_o);
                                                            if($cc_o == 0) continue;
                                                            $row_o = mysql_fetch_assoc($q_o);
                                                            
                                                            $o_name = $row_o[name];
                                                            if(strlen($o_name)>8)
                                                            {
                                                                $o_name = substr($o_name,0,8);
                                                                $o_name .= "...";
                                                            }
                                                            $o_name = "-- " . $o_name;
                                                            $td_str .= "<span style='font-size:10px; float:right;'>{$o_name} </span> <br>";
                                                        }
                                                        
                                                        $td_str .= "</td>";
                                                        $count_cat++;
                                                    }
                                                    
                                                    for($i=$count_cat;$i<8;$i++)
                                                    {
                                                        $td_str .= "<td>&nbsp;</td>"; 
                                                    }
                                                    echo($td_str);
                                                    
                                                    
                                                    ?>
                                                    <td><?=$row_bundle[cc] ?></td>
                                                    <!--<td><span class="label label-success">Active</span></td>-->
                                                    <td class="center">  
                                                            <a href="" onclick="document.getElementById('copy_form_id').value=<?=$row_bundle[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Bundle"><i class="icon-plus"></i></a>&nbsp;                                              
                                                            <a href="bundle_edit.php?id=<?= $row_bundle[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="bundle_list.php?mode=removed&id=<?= $row_bundle[id] ?>" onclick="return confirm('Are you sure to remove <?= $row_bundle[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                            <a href="set_test_combo.php?id=<?= $row_bundle[id] ?>"  class="icon huge tooltips" data-placement="bottom" data-original-title="Set Test Combo"><i class="icon-cog"></i></a>&nbsp;
                                                    </td>
                                                    <?
                                                    echo("</tr>");                                       
                                                    
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- END FORM-->
                                    </div>
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <!-- BEGIN FORM-->
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>OBID</th>
                                                    <th>Created Date/Time</th>                                        
                                                    <th>Bundle Name</th>
                                                    <th>Category 1</th>
                                                    <th>Category 2</th>
                                                    <th>Category 3</th>
                                                    <th>Category 4</th>
                                                    <th>Category 5</th>
                                                    <th>Category 6</th>
                                                    <th>Category 7</th>
                                                    <th>Category 8</th>
                                                    <th>Campaigns</th>
                                                    <!--<th>Active</th>-->
                                                    
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $table_body = "";
                                                
                                                $sql_bundle = "SELECT b.*, (SELECT count(bc.id) FROM bundle_campaigns bc WHERE bc.bundle_id=b.id) as cc 
                                                                FROM bundles b WHERE status=2 AND isdemo=0";
                                                $q_bundle = mysql_query($sql_bundle);
                                                while($row_bundle=mysql_fetch_assoc($q_bundle))
                                                {
                                                ?>
                                                    <tr class="odd gradeX">
                                                    <td><?= $row_bundle[id] ?></td>
                                                    <td><?= date_format(date_create($row_bundle[create_datetime]), SHORTDATETIME) ?></td>
                                                    <td><?= $row_bundle[name] ?></td>
                                                <?
                                                    $sql_cat = "SELECT b.*, c.name as cat_name, bc.cat_order, bc.cat_id FROM bundles b, categories c, bundle_categories bc
                                                        WHERE b.id=bc.bundle_id AND b.id={$row_bundle[id]} AND bc.cat_id=c.id AND c.status=0 ORDER BY bc.cat_order ";
                                                    $q_cat = mysql_query($sql_cat);
                                                    
                                                    $td_str = "";                               
                                                    $count_cat = 0;                                                                                
                                                    while($row_cat=mysql_fetch_assoc($q_cat))
                                                    {
                                                        $td_str .= "<td>" . $row_cat[cat_name] . "<br>";
                                                        
                                                        $sql_oc = " SELECT oc.offer_id, oc.isgroup FROM offer_categories oc, bundle_offers bo 
                                                                    WHERE bo.isactive=1 AND bo.offer_id=oc.offer_id AND bo.cat_id={$row_cat[cat_id]} AND 
                                                                    bo.bundle_id={$row_cat[id]} AND category_id={$row_cat[cat_id]}";    
                                                        //var_dump($sql_oc); exit;                                       
                                                        $q_oc = mysql_query($sql_oc);                                            
                                                        while($row_oc=mysql_fetch_assoc($q_oc))
                                                        {
                                                            if($row_oc[isgroup] == 0)
                                                            {
                                                                $sql_o = "SELECT offer_name as name FROM offers WHERE id={$row_oc[offer_id]} AND offer_show=1 AND status=0";
                                                            }
                                                            else
                                                            {
                                                                $sql_o = "SELECT name FROM offergroups WHERE id={$row_oc[offer_id]} AND status=0";    
                                                            }
                                                            //var_dump($sql_o);
                                                            $q_o = mysql_query($sql_o);
                                                            $cc_o = mysql_numrows($q_o);
                                                            if($cc_o == 0) continue;
                                                            $row_o = mysql_fetch_assoc($q_o);
                                                            
                                                            $o_name = $row_o[name];
                                                            if(strlen($o_name)>8)
                                                            {
                                                                $o_name = substr($o_name,0,8);
                                                                $o_name .= "...";
                                                            }
                                                            $o_name = "-- " . $o_name;
                                                            $td_str .= "<span style='font-size:10px; float:right;'>{$o_name} </span> <br>";
                                                        }
                                                        
                                                        $td_str .= "</td>";
                                                        $count_cat++;
                                                    }
                                                    
                                                    for($i=$count_cat;$i<8;$i++)
                                                    {
                                                        $td_str .= "<td>&nbsp;</td>"; 
                                                    }
                                                    echo($td_str);
                                                    
                                                    
                                                    ?>
                                                    <td><?=$row_bundle[cc] ?></td>
                                                    <!--<td> <span class="label label-default">Paused</span></td>                                            -->
                                                    <td class="center"> 
                                                            <a href="" onclick="document.getElementById('copy_form_id').value=<?=$row_bundle[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Bundle"><i class="icon-plus"></i></a>&nbsp;                                               
                                                            <a href="bundle_edit.php?id=<?= $row_bundle[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="bundle_list.php?mode=removed&id=<?= $row_bundle[id] ?>" onclick="return confirm('Are you sure to remove <?= $row_bundle[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                            <a href="set_test_combo.php?id=<?= $row_bundle[id] ?>"  class="icon huge tooltips" data-placement="bottom" data-original-title="Set Test Combo"><i class="icon-cog"></i></a>&nbsp;
                                                    </td>
                                                    <?
                                                    echo("</tr>");                                       
                                                    
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- END FORM-->
                                    </div>
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '3') { ?>active<? } ?>" id="portlet_tab3">
                                        <!-- BEGIN FORM-->
                                        <table class="table table-striped table-bordered" id="other_list">
                                            <thead>
                                                <tr>
                                                    <th>OBID</th>
                                                    <th>Created Date/Time</th>                                        
                                                    <th>Bundle Name</th>
                                                    <th>Category 1</th>
                                                    <th>Category 2</th>
                                                    <th>Category 3</th>
                                                    <th>Category 4</th>
                                                    <th>Category 5</th>
                                                    <th>Category 6</th>
                                                    <th>Category 7</th>
                                                    <th>Category 8</th>
                                                    <th>Campaigns</th>
                                                    <th>Active</th>                                                    
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $table_body = "";
                                                
                                                $sql_bundle = "SELECT b.*, (SELECT count(bc.id) FROM bundle_campaigns bc WHERE bc.bundle_id=b.id) as cc 
                                                                FROM bundles b WHERE isdemo=1 AND (status=0 OR status=2)";
                                                $q_bundle = mysql_query($sql_bundle);
                                                while($row_bundle=mysql_fetch_assoc($q_bundle))
                                                {
                                                ?>
                                                    <tr class="odd gradeX">
                                                    <td><?= $row_bundle[id] ?></td>
                                                    <td><?= date_format(date_create($row_bundle[create_datetime]), SHORTDATETIME) ?></td>
                                                    <td><?= $row_bundle[name] ?></td>
                                                <?
                                                    $sql_cat = "SELECT b.*, c.name as cat_name, bc.cat_order, bc.cat_id FROM bundles b, categories c, bundle_categories bc
                                                        WHERE b.id=bc.bundle_id AND b.id={$row_bundle[id]} AND bc.cat_id=c.id AND c.status=0 ORDER BY bc.cat_order ";
                                                    $q_cat = mysql_query($sql_cat);
                                                    
                                                    $td_str = "";                               
                                                    $count_cat = 0;                                                                                
                                                    while($row_cat=mysql_fetch_assoc($q_cat))
                                                    {
                                                        $td_str .= "<td>" . $row_cat[cat_name] . "<br>";
                                                        
                                                        $sql_oc = " SELECT oc.offer_id, oc.isgroup FROM offer_categories oc, bundle_offers bo 
                                                                    WHERE bo.isactive=1 AND bo.offer_id=oc.offer_id AND bo.cat_id={$row_cat[cat_id]} AND 
                                                                    bo.bundle_id={$row_cat[id]} AND category_id={$row_cat[cat_id]}";    
                                                        //var_dump($sql_oc); exit;                                       
                                                        $q_oc = mysql_query($sql_oc);                                            
                                                        while($row_oc=mysql_fetch_assoc($q_oc))
                                                        {
                                                            if($row_oc[isgroup] == 0)
                                                            {
                                                                $sql_o = "SELECT offer_name as name FROM offers WHERE id={$row_oc[offer_id]} AND offer_show=1 AND status=0";
                                                            }
                                                            else
                                                            {
                                                                $sql_o = "SELECT name FROM offergroups WHERE id={$row_oc[offer_id]} AND status=0";    
                                                            }
                                                            //var_dump($sql_o);
                                                            $q_o = mysql_query($sql_o);
                                                            $cc_o = mysql_numrows($q_o);
                                                            if($cc_o == 0) continue;
                                                            $row_o = mysql_fetch_assoc($q_o);
                                                            
                                                            $o_name = $row_o[name];
                                                            if(strlen($o_name)>8)
                                                            {
                                                                $o_name = substr($o_name,0,8);
                                                                $o_name .= "...";
                                                            }
                                                            $o_name = "-- " . $o_name;
                                                            $td_str .= "<span style='font-size:10px; float:right;'>{$o_name} </span> <br>";
                                                        }
                                                        
                                                        $td_str .= "</td>";
                                                        $count_cat++;
                                                    }
                                                    
                                                    for($i=$count_cat;$i<8;$i++)
                                                    {
                                                        $td_str .= "<td>&nbsp;</td>"; 
                                                    }
                                                    echo($td_str);
                                                    
                                                    
                                                    ?>
                                                    <td><?=$row_bundle[cc] ?></td>
                                                    <td><?if($row_bundle[status]==0) {?> 
                                                        <span class="label label-success">Active</span> </td>
                                                        <?}else{?>
                                                        <span class="label label-default">Paused</span> </td>
                                                        <?} ?>
                                                    <td class="center">   
                                                            <a href="" onclick="document.getElementById('copy_form_id').value=<?=$row_bundle[id]?> ;$('#copy_form').submit();return false;" class="icon huge tooltips" data-placement="bottom" data-original-title="Copy Bundle"><i class="icon-plus"></i></a>&nbsp;                                             
                                                            <a href="bundle_edit.php?id=<?= $row_bundle[id] ?>" class="icon huge tooltips" data-placement="bottom" data-original-title="Edit Offer"><i class="icon-pencil"></i></a>&nbsp;
                                                            <a href="bundle_list.php?mode=removed&id=<?= $row_bundle[id] ?>" onclick="return confirm('Are you sure to remove <?= $row_bundle[name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                                            <a href="set_test_combo.php?id=<?= $row_bundle[id] ?>"  class="icon huge tooltips" data-placement="bottom" data-original-title="Set Test Combo"><i class="icon-cog"></i></a>&nbsp;
                                                    </td>
                                                    <?
                                                    echo("</tr>");                                       
                                                    
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                            </div>
                                    
                            <br>
                            <div class="form-actions" id="buttons_general"  style="padding-left: 15px;">
                                <a href="bundle_add.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add A New Bundle</a>
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