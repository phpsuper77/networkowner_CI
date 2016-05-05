<?
include 'z_header.php';

                            
if ($_REQUEST[tryout] == '1') 
{

    $errmsg = '';
    
    if ($_REQUEST[max_revenue_publisher] == '') {
        $errmsg.='<li>Field "Max Publisher Revenue" should not be empty</li>';
    }

    if ($_REQUEST[max_revenue_PM] == '') {
        $errmsg.='<li>Field "Max PM Revenue" should not be empty</li>';
    }

    if ($_REQUEST[max_revenue_AM] == '') {
        $errmsg.='<li>Field "Max AM Revenue" should not be empty</li>';
    } 
    
    if ($_REQUEST[auto_optimizer_term] == '') {
        $errmsg.='<li>Field "Auto Optimiser Term" should not be empty</li>';
    }
    
    if (((int)$_REQUEST[combo_test_rate] < 0) || ((int)$_REQUEST[combo_test_rate] >100 )) {
        $errmsg.='<li>Field "Combo Test Rate" should be from 0% to 100%</li>';
    }
    if ((int)$_REQUEST[max_testcombo_opensession] < 1)  {
        $errmsg.='<li>Field "Max count of opensession of testcombo" should be large than 1 </li>';
    }  
    
    if ((int)$_REQUEST[ip_monitor_time] == '')  {
        $errmsg.='<li>Field "Monitoring Time Interval" should not be empty </li>';
    }  
    
    if ((int)$_REQUEST[ip_monitor_limit] == '')  {
        $errmsg.='<li>Field "IP duplication limit" should not be empty </li>';
    }  
    
    if ((int)$_REQUEST[ip_block_time] == '')  {
        $errmsg.='<li>Field "Blocking IP Time" should not be empty </li>';
    }  
      
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } 
    else 
    {                                  
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[max_revenue_publisher]}' WHERE field_name='max_revenue_publisher'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[max_revenue_PM]}' WHERE field_name='max_revenue_PM'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[max_revenue_AM]}' WHERE field_name='max_revenue_AM'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[auto_optimizer_term]}' WHERE field_name='auto_optimizer_term'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[combo_test_rate]}' WHERE field_name='combo_test_rate'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[max_testcombo_opensession]}' WHERE field_name='max_testcombo_opensession'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[offer_cap]}' WHERE field_name='offer_cap'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[ip_monitor_time]}' WHERE field_name='ip_monitor_time'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[ip_monitor_limit]}' WHERE field_name='ip_monitor_limit'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[ip_block_time]}' WHERE field_name='ip_block_time'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[block_url]}' WHERE field_name='block_url'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[alert_rate]}' WHERE field_name='alert_rate'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[alert_revenue]}' WHERE field_name='alert_revenue'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[alert_install]}' WHERE field_name='alert_install'");
        mysql_query("UPDATE `network_setting` SET field_value='{$_REQUEST[alert_click]}' WHERE field_name='alert_click'");
        
        $usermessage = '<b>Saving Success:</b><br>';
        
    }
} 
else 
{
    $sql = "SELECT * FROM network_setting ";
    $q = mysql_query($sql);
    while($row = mysql_fetch_assoc($q))
    {
        $_REQUEST[$row[field_name]] = $row[field_value];            
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
                    Network Setting
                    <small>edit Network setting values</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="">Network Setting</a> 
                    </li>
                    
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
                            <h4><i class="icon-reorder"></i>  Netwok Setting</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="net_setting.php" class="form-horizontal" method="POST" id="net_setting" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Max Publisher Revenue</label>
                                    <div class="controls">
                                        <input type="text" id="max_revenue_publisher" name="max_revenue_publisher" value="<?= $_REQUEST[max_revenue_publisher] ?>" class="span6"  />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Max PM Revenue</label>
                                    <div class="controls">
                                        <input type="text" id="max_revenue_PM" name="max_revenue_PM" value="<?= $_REQUEST[max_revenue_PM] ?>" class="span6"  />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Max AM Revenue</label>
                                    <div class="controls">
                                        <input type="text" id="max_revenue_AM" name="max_revenue_AM" value="<?= $_REQUEST[max_revenue_AM] ?>" class="span6" />
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Auto Optimizer Term (day) </label>
                                    <div class="controls">
                                        <input type="text" id="auto_optimizer_term" name="auto_optimizer_term" value="<?= $_REQUEST[auto_optimizer_term] ?>" class="span6" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Combo Test Rate ( % )</label>
                                    <div class="controls">
                                        <input type="text" id="combo_test_rate" name="combo_test_rate" value="<?= $_REQUEST[combo_test_rate] ?>" class="span6 popovers" data-trigger="hover" data-content='Any combo with less than the minimum # sessions gets traffics as many as this rate' data-original-title="Combo Test Rate" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Max count of opensession of test combo </label>
                                    <div class="controls">
                                        <input type="text" id="max_testcombo_opensession" name="max_testcombo_opensession" value="<?= $_REQUEST[max_testcombo_opensession] ?>" class="span6 popovers" data-trigger="hover" data-content='Max count of opensession of test combo' data-original-title="MCTC" />
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Monitoring Time Interval(sec) </label>
                                    <div class="controls">
                                        <input type="text" id="ip_monitor_time" name="ip_monitor_time" value="<?= $_REQUEST[ip_monitor_time] ?>" class="span6 popovers" data-trigger="hover" data-content='Monitoring time interval' data-original-title="Block IP" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> IP duplication limit</label>
                                    <div class="controls">
                                        <input type="text" id="ip_monitor_limit" name="ip_monitor_limit" value="<?= $_REQUEST[ip_monitor_limit] ?>" class="span6 popovers" data-trigger="hover" data-content='IP duplication limit' data-original-title="Block IP" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Blocking IP Time(min) </label>
                                    <div class="controls">
                                        <input type="text" id="ip_block_time" name="ip_block_time" value="<?= $_REQUEST[ip_block_time] ?>" class="span6 popovers" data-trigger="hover" data-content='blocking ip time interval' data-original-title="Block IP" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Redirecting URL after blocking  </label>
                                    <div class="controls">
                                        <input type="text" id="block_url" name="block_url" value="<?= $_REQUEST[block_url] ?>" class="span6 popovers" data-trigger="hover" data-content='blocking ip time interval' data-original-title="Block IP" />
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Alert % Rate  </label>
                                    <div class="controls">
                                        <input type="text" id="alert_rate" name="alert_rate" value="<?= $_REQUEST[alert_rate] ?>" class="span6 popovers" data-trigger="hover" data-content='alert % rate' data-original-title="Alert Rate" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Alert Revenue  </label>
                                    <div class="controls">
                                        <input type="text" id="alert_revenue" name="alert_revenue" value="<?= $_REQUEST[alert_revenue] ?>" class="span6 popovers" data-trigger="hover" data-content='alert revenue' data-original-title="Alert Revenue" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Alert Install  </label>
                                    <div class="controls">
                                        <input type="text" id="alert_install" name="alert_install" value="<?= $_REQUEST[alert_install] ?>" class="span6 popovers" data-trigger="hover" data-content='alert install' data-original-title="Alert Install" />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Alert Click  </label>
                                    <div class="controls">
                                        <input type="text" id="alert_rate" name="alert_click" value="<?= $_REQUEST[alert_click] ?>" class="span6 popovers" data-trigger="hover" data-content='alert click' data-original-title="Alert Click" />
                                    </div>
                                </div>
 
                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#net_setting').submit();
                                            return false;"><i class="icon-check"></i> Save Setting</a>
                                    <a href="" class="btn">Cancel</a>
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