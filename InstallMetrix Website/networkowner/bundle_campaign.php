<?
include 'z_header.php';

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';
  
    $bundle_id = $_REQUEST[id];
    if($_REQUEST[mode] == "add_campaigns")
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
       
    }
      
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
        $save_message = '0';
    } else {
        
    }    
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
                    Add Campaigns
                    <small>add campaigns to the offer bundle</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="bundle_list.php">Bundle List</a> <span class="divider">/</span>
                    </li>                    
                    <li>
                        <a href="bundle_edit.php?id=<?= $_REQUEST[id]?>">Bundle Edit</a> <span class="divider">/</span>
                    </li>                    
                    <li><a href="#">Add Campaigns to the bundle</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">
    
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Add Campaigns Setting</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" style="width: 600px; float: left;">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                    
                                        <form action="bundle_campaign.php?id=<?= $_REQUEST[id]?>" class="form-horizontal" method="POST" id="campaign_form" enctype="multipart/form-data">
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
                                                        $sql = "SELECT * FROM projects WHERE id NOT IN (SELECT bc.camp_id FROM bundle_campaigns bc, bundles b WHERE b.status=0 AND b.id=bc.bundle_id)";
                                                        //var_dump($sql);exit;
                                                        $q = mysql_query($sql);
                                                        while ($row = mysql_fetch_assoc($q)) {
                                                  ?>
                                                        <option value="<?= $row[id]?>"> <?= $row[proj_name]?></option>
                                                  <?php
                                                        }
                                                        
                                                        $sql = "SELECT * FROM projects WHERE id IN (SELECT camp_id FROM bundle_campaigns WHERE bundle_id={$_REQUEST[id]})";
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
                                            return false;"><i class="icon-check"></i> Save Campaigns</a>                                
                            </div>
                        </div>
                    </div>
                                
                </div>
            </div>
         </div>
    </div>
</div>                                      
 
<? include 'z_footer.php'; ?> 