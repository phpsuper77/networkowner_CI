<?
include 'z_header.php';


FB::log($_SERVER);

// id : categoriy's id

if (($_REQUEST[id] != '') && ($_REQUEST[tryout] == '')) {
    $sql = "SELECT * FROM `categories` WHERE `id`='{$_REQUEST[id]}'";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
  
    foreach ($row as $key => $value) {
        $_REQUEST[$key] = $value;
    }
    
    //var_dump($_REQUEST);exit;
}

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';
    
    if($_REQUEST[mode]=="category_name_change")
    {
        //var_dump($_REQUEST);exit;
         if ($_REQUEST[name] == '') {
            $errmsg.='<li>Field "Category Name" should not be empty</li>';
         }
         else
         {
            $sql = "UPDATE categories SET name='{$_REQUEST[name]}' WHERE id='{$_REQUEST[id]}'";
            mysql_query($sql);
         }
    }
    else if($_REQUEST[mode]=="removed")
    {
        $sql = "DELETE FROM offer_categories WHERE id='{$_REQUEST[uid]}'";
        //var_dump($sql);exit;
        mysql_query($sql);        
    }
    else if($_REQUEST[mode]=="add_offer")
    {
        if($_REQUEST[new_offer_id]=='')
        {
             $errmsg.='<li>Field "Offer Id" should be selected</li>';     
        }
        else
        {
            $sql = "INSERT INTO offer_categories(category_id, offer_id, isgroup) VALUES ('{$_REQUEST[id]}', '{$_REQUEST[new_offer_id]}', '0')";
            mysql_query($sql);                    
        }
    }      
    else if($_REQUEST[mode]=="add_offergroup")
    {
        if($_REQUEST[new_offergroup_id]=='')
        {
             $errmsg.='<li>Field "Offer Group Id" should be selected</li>';     
        }
        else
        {
            $sql = "INSERT INTO offer_categories(category_id, offer_id, isgroup) VALUES ('{$_REQUEST[id]}', '{$_REQUEST[new_offergroup_id]}', '1')";
            
            mysql_query($sql);                    
        }
    }  


    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } 
    else 
    {       
                      
        $sql = "SELECT * FROM `categories` WHERE `id`='{$_REQUEST[id]}'";
        $q = mysql_query($sql);
        $row = mysql_fetch_assoc($q);
      
        foreach ($row as $key => $value) {
            $_REQUEST[$key] = $value;
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
                    Edit Category
                    <small>edit Category and control Offer rate</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="category_list.php">Category List</a><span class="divider">/</span></li>
                    <li><a href="#">Edit Category</a></li>
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
                            <h4><i class="icon-reorder"></i>  Category Settings</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM--> 
                            <form action="category_edit.php" class="form-horizontal" method="POST" id="change_name_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/> 
                                <input type="hidden" name="mode" value="category_name_change"/> 
                                <input type="hidden" name="id" value="<?=$_REQUEST[id]?>">
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Category Name</label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" value="<?= $_REQUEST[name] ?>" class="span6 popovers"  />
                                    </div>
                                </div>                          

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#change_name_form').submit();
                                            return false;"><i class="icon-check"></i> Save Category Name</a>                                    
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
            
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Offers List of this Category</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <table class="table table-striped table-bordered" id="other_list">
                                <thead>
                                    <tr>                                        
                                        <th>Offer ID</th>
                                        <th>Company Name</th>
                                        <th>Offer Name</th>
                                        <th>Offer Type</th> 
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    //list offers in the category
                                    $sql = "SELECT o.*, oc.id as uniq_id, u.user_company_name  FROM offers o, offer_categories oc, users u
                                            WHERE o.status=0 AND o.offer_show=1 AND o.assigned_user_id=u.id AND o.id=oc.offer_id AND isgroup=0 AND oc.category_id={$_REQUEST[id]}
                                            ORDER BY o.id DESC";
                                    //var_dump($sql);exit;
                                    $q = mysql_query($sql);
                                    while ($row = mysql_fetch_assoc($q)) {
                                        ?>
                                        <tr class="odd gradeX">                                            
                                            <td><a href="offer_edit.php?oid=<?= $row[id] ?>"><?= $row[id] ?></a></td>  
                                            <td><?= $row[user_company_name] ?></td>                                          
                                            <td><?= $row[offer_name] ?></td>   
                                            <td>Offer</td>                                         
                                            <td class="center">                                                 
                                                <a href="category_edit.php?mode=removed&tryout=1&id=<?=$_REQUEST[id]?>&uid=<?= $row[uniq_id] ?>" onclick="return confirm('Are you sure to remove <?= $row[offer_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                            </td>
                                            
                                        </tr>
                                    <? } ?>
                                       <?
                                    //list offer groups in the category
                                    $sql = "SELECT og.* , oc.id as uniq_id FROM offergroups og, offer_categories oc
                                            WHERE og.status=0 AND og.id=oc.offer_id AND isgroup=1 AND oc.category_id={$_REQUEST[id]} ORDER BY og.id DESC";
                                    $q = mysql_query($sql);
                                    while ($row = mysql_fetch_assoc($q)) {
                                        ?>
                                        <tr class="odd gradeX">                                            
                                            <td><a href="offergroup_edit.php?id=<?= $row[id] ?>"><?= $row[id] ?></a></td> 
                                            <td></td>                                           
                                            <td><?= $row[name] ?></td>  
                                            <td>Group</td>                                          
                                            <td class="center">                                                 
                                                <a href="category_edit.php?mode=removed&tryout=1&id=<?=$_REQUEST[id]?>&uid=<?= $row[uniq_id] ?>" onclick="return confirm('Are you sure to remove <?= $row[offer_name] ?>?')" class="icon huge tooltips" data-placement="bottom" data-original-title="Delete Offer"><i class="icon-remove"></i></a>&nbsp;
                                            </td>
                                            
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>                            
                                                     
                            <!-- END FORM-->
                            <br>
                            <div class="form-actions" id="buttons_offers"  style=" padding-left: 15px;">
                                <a style="float: left;" a href="#myModal2" class="btn btn-success" data-toggle="modal"><i class="icon-plus-sign"></i> Add New Offer</a>
                                <a style="float: left; margin-left: 20px;" a href="#myModal3" class="btn btn-success" data-toggle="modal"><i class="icon-plus-sign"></i> Add New Offer Group</a>
                            </div>
                                     
                            <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 id="myModalLabel1">Add A New Offer</h4>
                                </div>
                                <form action="category_edit.php" class="form-horizontal" method="POST" id="add_offer_form">
                                    <div class="modal-body">  
                                        <input type="hidden" name="id" value="<?= $_REQUEST[id] ?>"/>
                                        <input type="hidden" name="tryout" value="1"/>
                                        <input type="hidden" name="mode" value="add_offer"/>
                                        <select size="5" name="new_offer_id" id="new_offer_id" data-placeholder="Select an offer to add" class="chosen-with-diselect" tabindex="-1" id="selCSI" style="width: 500px; z-index: 1000; overflow: auto;">
                                            <option value=""></option>
                                            <?
                                            $sql = "SELECT o.*, u.user_company_name FROM offers o, users u WHERE o.status=0 AND u.id=o.assigned_user_id AND o.id NOT IN ( select offer_id from offer_categories where isgroup=0 )";
                                            $q = mysql_query($sql);
                                            while ($row = mysql_fetch_assoc($q)) {
                                                ?>
                                                <option value="<?= $row[id] ?>"><?= $row[offer_name] ?> (&nbsp; <?= $row[user_company_name] ?> &nbsp;)  </option>
                                            <? } ?>
                                        </select>   
                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                                    </div>   
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <button class="btn btn-success" onclick="$('#add_offer_form').submit();">Save</button>
                                    </div>
                                </form>
                            </div>  
                            
                            <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 id="myModalLabel2">Add A New Offer Group</h4>
                                </div>
                                <form action="category_edit.php" class="form-horizontal" method="POST" id="add_offergroup_form">
                                    <div class="modal-body">  
                                        <input type="hidden" name="id" value="<?= $_REQUEST[id] ?>"/>
                                        <input type="hidden" name="tryout" value="1"/>
                                        <input type="hidden" name="mode" value="add_offergroup"/>
                                        <select size="5" name="new_offergroup_id" id="new_offergroup_id" data-placeholder="Select an offer group to add" class="chosen-with-diselect" tabindex="-1" id="selCSI" style="width: 500px; z-index: 1000; overflow: auto;">
                                            <option value=""></option>
                                            <?
                                            $sql = "SELECT * FROM offergroups WHERE status=0 AND id NOT IN ( select offer_id from offer_categories where isgroup=1 )";
                                            $q = mysql_query($sql);
                                            while ($row = mysql_fetch_assoc($q)) {
                                                ?>
                                                <option value="<?= $row[id] ?>"><?= $row[name] ?></option>
                                            <? } ?>
                                        </select>   
                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                                    </div>   
                                    <div class="modal-footer">
                                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <button class="btn btn-success" onclick="$('#add_offergroup_form').submit();">Save</button>
                                    </div>
                                </form>
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
