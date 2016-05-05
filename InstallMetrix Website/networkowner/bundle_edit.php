<?
include 'z_header.php';

$bundle_id = $_REQUEST[id];
$isSaved = 0;

if ($_REQUEST[tryout] == '1') 
{

    $errmsg = '';  
      
    if($_REQUEST[mode] == "select_categories")
    {
        $name = $_REQUEST[name];
        $min_offerspot = (int)$_REQUEST[min_offerspot];
        $count = count($_POST['categories']);
        
        if($_REQUEST[status] == NULL)
        {
            //paused
            $_REQUEST[status] = 2;
        }
        else
        {
            $_REQUEST[status] = 0;
        }
        
        if($_REQUEST[isdemo] == NULL)
        {
            //paused
            $_REQUEST[isdemo] = 0;
        }
        else
        {
            $_REQUEST[isdemo] = 1;
        }
    
        if($name == '')
        {
            $errmsg.='<li>Field "Bundle Name" should not be empty</li>';
        }
        /*
        else if($min_offerspot == 0)
        {
            $errmsg.='<li>Field "Minimum # of Offer Spots To Test" should not be small than 1</li>';
        }
        */
        else if($count<$min_offerspot)
        {
            $errmsg.='<li>Bundle should have categories at least "Minimum # of Offer Spots To Test" </li>';
        }
        else
        {
            $sql = "UPDATE bundles SET name='{$name}', min_offerspot={$min_offerspot}, status={$_REQUEST[status]}, isdemo={$_REQUEST[isdemo]} WHERE id={$bundle_id}";
            mysql_query($sql);  
            
            $selected_cats_id = "";
            
            //delete all of categories and insert again about the bundle
            $sql = "DELETE FROM bundle_categories WHERE bundle_id={$bundle_id}";
            mysql_query($sql);  
            
            $order = 0;              
                                 
            if($count>0)
            {                           
                $sql = "INSERT INTO bundle_categories(bundle_id, cat_id, cat_order) VALUES ";
                foreach ($_POST['categories'] as $selectedCategory)
                {                   
                    $sql .= "({$bundle_id}, {$selectedCategory}, {$order}),";
                    $order++;
                }
                $sql = substr($sql,0,-1);            
                //var_dump($sql);exit;
                
                mysql_query($sql);  
            }
            
            //get selected categoriy ids
            $cat_array_str = "";        
            foreach ($_POST['categories'] as $selectedCategory)
            {
                $cat_array_str .= $selectedCategory . ",";                            
            }
            $cat_array_str =  substr($cat_array_str,0,-1);
            
            
            //delete category and % rotate data that is not in selected category ids string from bundle_offers table
            if($count>0)
                $sql = "DELETE FROM bundle_offers where bundle_id={$bundle_id} AND cat_id NOT IN ({$cat_array_str})";   
            else
                $sql = "DELETE FROM bundle_offers where bundle_id={$bundle_id}";   
            
            //var_dump($sql);exit;
            mysql_query($sql);
            
            //var_dump($_POST['categories']);exit;
            //insert offers % rate data of categories that selected as newly.              
            foreach ($_POST['categories'] as $selectedCategory)
            {               
                $sql = "SELECT * FROM bundle_offers WHERE bundle_id={$bundle_id} AND cat_id={$selectedCategory}";
                
                $q = mysql_query($sql);
                $num = mysql_numrows($q);
                                                      
                if($num == 0)
                {                   
                    ///first adding about the category, it means no offer is selected yet.
                    // so % rate of offers in the category will be equal.
                    
                    $sql = "INSERT into bundle_offers (bundle_id, cat_id, offer_id, isgroup, isactive) VALUES ";
                    
                    $sql1 = "SELECT * FROM offer_categories WHERE category_id={$selectedCategory}";
                    $q1 = mysql_query($sql1);
                    
                    while($row1=mysql_fetch_assoc($q1))
                    {
                        $sql .= "({$bundle_id}, {$selectedCategory}, {$row1[offer_id]}, {$row1[isgroup]}, 0),";
                    }
                    
                    $sql =  substr($sql,0,-1);                 
                    
                    //var_dump($sql);exit;
                    mysql_query($sql);
                }
                    
            }
            //var_dump($sql);exit;  
            $isSaved = 1;      
        }
    }
    else if($_REQUEST[mode] == "offers_activate")
    {

        $cat_id = $_REQUEST[selected_categoryid];
        
        //delete old rate data and insert new rate

        $sql = "DELETE FROM bundle_offers WHERE bundle_id={$bundle_id} AND cat_id={$cat_id}";
        $q = mysql_query($sql);
         
        //insert new records 
        $sql = "INSERT INTO bundle_offers(bundle_id, cat_id, offer_id, isgroup, isactive) VALUES ";
        
        $count = 0;
        
        //$_POST[offers] is array of "offer_id|isgroup"
        
        foreach ($_POST['offers'] as $selectedoffer)
        {   
            $selectedOffer_isgroup = substr($selectedoffer, -1);
            $selectedOffer_id = substr($selectedoffer, 0, -2);
                                    
            $sql .= "( {$bundle_id}, {$cat_id}, {$selectedOffer_id}, {$selectedOffer_isgroup}, 1),";
            
            $count++;
        }
        $sql = substr($sql,0,-1);
        //var_dump($sql);exit;
        $q = mysql_query($sql); 

        $isSaved = 1;
    }
    else if($_REQUEST[mode] == "add_campaigns")
    {
        //get selected campaigns ids
        $camp_array_str = "";        
        foreach ($_POST['campaigns'] as $selectedCampaign)
        {
            $camp_array_str .= $selectedCampaign . ",";                            
        }
        $camp_array_str =  substr($camp_array_str,0,-1);
        
        //delete old campaigns that is not selected now for the bundle.
        $sql = "DELETE FROM bundle_campaigns WHERE bundle_id={$bundle_id} AND camp_id NOT IN ({$camp_array_str})";
        //var_dump($sql);exit;
        mysql_query($sql);  
        
        //insert new campaigns to the bundle
        
        $sql_insert = "INSERT INTO bundle_campaigns(bundle_id, camp_id) VALUES";            ;
        $new_count = 0;
        foreach ($_POST['campaigns'] as $selectedCampaign)
        {   
            $sql = "SELECT * FROM bundle_campaigns WHERE bundle_id={$bundle_id} AND camp_id={$selectedCampaign}";
            $q = mysql_query($sql);
            $num = mysql_numrows($q);
            
            if($num == 0)
            {                   
                //new campaign
                $new_count ++;                
                $sql_insert .= "({$bundle_id}, {$selectedCampaign})" . ",";                  
            }                            
        }
        $sql_insert =  substr($sql_insert,0,-1);
        
        mysql_query($sql_insert);
        
        $isSaved = 1;        
       
    }
       
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
        $save_message = '0';
    } 
    else 
    {        
                                                                      
    }    
}

$sql = "SELECT * FROM bundles WHERE id='{$bundle_id}'";
//var_dump($sql); exit;
$q = mysql_query($sql);
$row = mysql_fetch_assoc($q);

foreach ($row as $key => $value) {
    $_REQUEST[$key] = $value;
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
                    Edit Offer Bundle
                    <small>edit offer bundle</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="bundle_list.php">Bundle List</a> <span class="divider">/</span>
                    </li>                    
                    <li><a href="#">Edit Bundle</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">
            <?
            if ($isSaved==1) {
            ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Setting is saved successfully !
                </div>
            <? } ?>
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
                            <h4><i class="icon-reorder"></i>  Select Categories Settings</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" style="width: 600px; float: left;">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                    
                                        <form action="bundle_edit.php?id=<?= $_REQUEST[id]?>" class="form-horizontal" method="POST" id="category_form" enctype="multipart/form-data">
                                            <input type="hidden" name="tryout" value="1"/>                                            
                                            <input type="hidden" name="mode" value="select_categories"/>
                                            
                                            <div class="control-group" style="margin-top: 30px;">
                                                <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Offer Bundle Name</label>
                                                <div class="controls">
                                                    <input type="text" id="bundle_name" name="name" value="<?= $_REQUEST[name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the offer bundle' data-original-title="Offer Bundle Name" />
                                                </div>
                                            </div>
                                            
                                            <div class="control-group" style="margin-top: 30px;">
                                                <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Minimum # of Offer Spots To Test:</label>
                                                <div class="controls">
                                                    <input type="text" id="min_offerspot" name="min_offerspot" value="<? if($_REQUEST[min_offerspot] < 0) $_REQUEST[min_offerspot]=0; echo($_REQUEST[min_offerspot]); ?>" class="span6 popovers" data-trigger="hover" data-content='Minimum # of Offer Spots To Test:' data-original-title="" />
                                                </div>
                                            </div>
                                            
                                            <div class="control-group" >
                                                <label class="control-label" >Acitve : &nbsp;</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="status" id="status" value="0" <? if (($_REQUEST[status] == '0') || ($_REQUEST[status] == '')) { ?> CHECKED <? } ?>/>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="control-group" >
                                                <label class="control-label" >Demo : &nbsp;</label>
                                                <div class="controls">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="isdemo" id="isdemo" value="1" <? if ($_REQUEST[isdemo] == '1') { ?> CHECKED <? } ?>/>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="control-group" style="overflow-y: hidden ;">
                                             
                                                  <div id="multi_header" style="width:500px;height:30px;margin: 10px 0px 0px 0px;">
                                                    <div style="width:210px;height:30px;float:left;text-align: center;"> Avaialbe Categories </div>
                                                    <div style="width:70px;height:30px;float:left;text-align: center;"><img src="../common/multiselector/images/switch.png" alt=""> </div>
                                                    <div style="width:200px;height:30px;float:left;text-align: center;"> Added Categories  </div>
                                                  </div>
                                                  
                                                  <select id="categories" class="multiselect" multiple="multiple" name="categories[]" style="display: none; width:500px;height: 120px;">
                                                  <?php                                                                                                        
                                                        $sql = "select c.* from categories c where c.status=0 AND c.id not in (select bc.cat_id from bundle_categories bc where bc.bundle_id={$_REQUEST[id]}) ";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>"> <?= $row[name]?></option>
                                                  <?php
                                                        }
                                                        
                                                        $sql = "SELECT c.*, bc.cat_order FROM categories c, bundle_categories bc WHERE c.status=0 AND c.id=bc.cat_id AND bc.bundle_id={$_REQUEST[id]} ORDER BY bc.cat_order ";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>" selected > <?= $row[name]?></option>
                                                  <?php
                                                        }        
    
                                                  ?>    
                                                  </select>                                                 
                                                  
                                            </div>
                                            
                                        </form>
                                        
                                     </div>
                                </div>
                            </div>    
                            
                            <div class="form-actions" id="buttons_general">
                                <a href="#" style="margin-top: 200px;" class="btn btn-success" onclick="$('#category_form').submit();
                                            return false;"><i class="icon-check"></i> Save Bundle Settings</a>
                                <a href="camp_edit.php?cid=<?=$_REQUEST[cid] ?>&tab=2" style="margin-top: 200px;" class="btn">Cancel</a>
                              </div>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Set Offer Activation to Category</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" >
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                        <form action="bundle_edit.php?id=<?= $_REQUEST[id]?>" class="form-inline" role="form" method="POST" id="offer_rate_form" enctype="multipart/form-data">
                                            <input type="hidden" name="tryout" value="1"/>
                                            <input type="hidden" name="mode" value="offers_activate"/>
                                            <br>
                                            <div class="control-group">
                                                <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span>Added Categories</label>
                                                <div class="controls">
                                                    <select class="span6 chosen" name='selected_categoryid' onchange="GetOffersByCategory_Bundle(<?=$_REQUEST[id]?>,this.options[this.selectedIndex].value);">
                                                        <option value="-1"></option>
                                                        <?
                                                        
                                                        $sql = "SELECT c.*, bc.cat_order FROM categories c, bundle_categories bc WHERE c.status=0 AND c.id=bc.cat_id AND bc.bundle_id={$_REQUEST[id]} ORDER BY bc.cat_order ";
                                                        $q = mysql_query($sql);
                                                        
                                                        while ($row = mysql_fetch_assoc($q)) {                                                            
                                                            ?>
                                                            <option value="<?= $row[id] ?>"><?= $row[name]?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            </div>
                                                                                         
                                            <div class="control-group" style="float: left; width:600px;">
                                                <br>Offers of category <br><br>
                                                <div id="offers_table" style="">    
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>OID</th>
                                                                <th>Company Name</th>
                                                                <th>Offer Name</th>
                                                                <th>Activation</th>                                                        
                                                            </tr>
                                                        </thead>
                                                        <tbody>
           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                                             
                                            
                                        </form>
                                        
                                     </div>
                                </div>
                            </div>    
                            
                            <div class="form-actions" id="buttons_general">
                                <a href="#" class="btn btn-success" onclick="$('#offer_rate_form').submit();
                                            return false;"><i class="icon-check"></i> Save Offers</a>
                                <!--<a href="bundle_list.php?cid=<?=$_REQUEST[cid] ?>&tab=2" class="btn">Return</a>-->
                              </div>
                        </div>
                    </div>                    
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Select Campaigns</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" style="width: 600px; float: left;">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                    
                                        <form action="bundle_edit.php?id=<?= $_REQUEST[id]?>" class="form-horizontal" method="POST" id="campaign_form" enctype="multipart/form-data">
                                            <input type="hidden" name="tryout" value="1"/>                                            
                                            <input type="hidden" name="mode" value="add_campaigns"/>
                                            
                                            <div class="control-group" style="overflow-y: hidden ;">
                                             
                                                  <div id="multi_header" style="width:500px;height:30px;margin: 10px 0px 0px 0px;">
                                                    <div style="width:210px;height:30px;float:left;text-align: center;"> Avaialbe Campaigns </div>
                                                    <div style="width:70px;height:30px;float:left;text-align: center;"><img src="../common/multiselector/images/switch.png" alt=""> </div>
                                                    <div style="width:200px;height:30px;float:left;text-align: center;"> Added Campaigns  </div>
                                                  </div>
                                                  
                                                  <select id="campaigns" class="multiselect" multiple="multiple" name="campaigns[]" style="display: none; width:500px;height: 390px;">
                                                  <?php                                                                                                        
                                                        $sql = "SELECT id, proj_name FROM projects WHERE status=0 AND id NOT IN (SELECT camp_id FROM bundle_campaigns WHERE bundle_id={$_REQUEST[id]})";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>"> <?= $row[proj_name]?></option>
                                                  <?php
                                                        }
                                                        
                                                        $sql = "SELECT id, proj_name FROM projects WHERE status=0 AND id IN (SELECT camp_id FROM bundle_campaigns WHERE bundle_id={$_REQUEST[id]})";
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
                                </div>
                            </div>    
                            
                            <div class="form-actions" id="buttons_general">
                                <a href="#" style="margin-top: 50px;" class="btn btn-success" onclick="$('#campaign_form').submit();
                                            return false;"><i class="icon-check"></i> Save Settings</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>                                      
 
<? include 'z_footer.php'; ?> 