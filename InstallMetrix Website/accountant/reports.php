<?
include 'z_header.php';
$newconn = mysqli_connect(SQLHOST, SQLUSER, SQLPASS, SQLDB);     

$topAmount = array();
$topName = array();

$endDate4 = 	new DateTime('2000-01-01');
$startDate4 =	new DateTime('2000-01-01');
$endDate5 = 	new DateTime('2000-01-01');
$startDate5 = 	new DateTime('2000-01-01');
$endDate6 = 	new DateTime('2000-01-01');
$startDate6 = 	new DateTime('2000-01-01');
$endDate8 = 	new DateTime('2000-01-01');
$startDate8 = 	new DateTime('2000-01-01');

?>


<div id="body">
	
 <script>
    	  
	 function  getSubCSV(startdate, enddate, subid1, subid2, subid3, subid4, subid5, proj_name, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&subid1_5="	    + subid1;
        reportspecs = reportspecs + "&subid2_5="        + subid2;
        reportspecs = reportspecs + "&subid3_5="        + subid3;
        reportspecs = reportspecs + "&subid4_5="        + subid4;
        reportspecs = reportspecs + "&subid5_5="        + subid5;
        reportspecs = reportspecs + "&proj_name_5="     + proj_name;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=subid";
        
		window.open(reportspecs, '_blank');

	  }  

</script>	
	
	
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
                <div>
                     <div class="control-group" style="float: right;">
                        <label class="control-label" style="float: left; margin-top: 8px; margin-left: 10px;" for="input3">TimeZone : &nbsp;</label>
                        <div class="controls" style="float: left;">
                            <select class="span6 chosen" id="timezone_list" name='timezone_list' style="width: 350px;">
                                <option value="0" <?php if($_REQUEST[timezone]==0) echo("selected") ?>>(UTC-12:00) International Date Line West</option>
                                <option value="1" <?php if($_REQUEST[timezone]==1) echo("selected") ?>>(UTC-11:00) Midway Island, Samoa</option>
                                <option value="2" <?php if($_REQUEST[timezone]==2) echo("selected") ?>>(UTC-10:00) Hawaii</option>
                                <option value="3" <?php if($_REQUEST[timezone]==3) echo("selected") ?>>(UTC-09:00) Alaska</option>
                                <option value="4" <?php if($_REQUEST[timezone]==4) echo("selected") ?>>(UTC-08:00) Pacific Time (US and Canada); Tijuana</option>
                                <option value="5" <?php if($_REQUEST[timezone]==5) echo("selected") ?>>(UTC-07:00) Mountain Time (US and Canada)</option>
                                <option value="6" <?php if($_REQUEST[timezone]==6) echo("selected") ?>>(UTC-07:00) Chihuahua, La Paz, Mazatlan</option>
                                <option value="7" <?php if($_REQUEST[timezone]==7) echo("selected") ?>>(UTC-07:00) Arizona</option>
                                <option value="8" <?php if($_REQUEST[timezone]==8) echo("selected") ?>>(UTC-06:00) Central Time (US and Canada</option>
                                <option value="9" <?php if($_REQUEST[timezone]==9) echo("selected") ?>>(UTC-06:00) Saskatchewan</option>
                                <option value="10" <?php if($_REQUEST[timezone]==10) echo("selected") ?>>(UTC-06:00) Guadalajara, Mexico City, Monterrey</option>
                                <option value="11" <?php if($_REQUEST[timezone]==11) echo("selected") ?>>(UTC-06:00) Central America</option>
                                <option value="12" <?php if($_REQUEST[timezone]==12) echo("selected") ?>>(UTC-05:00) Eastern Time (US and Canada)</option>
                                <option value="13" <?php if($_REQUEST[timezone]==13) echo("selected") ?>>(UTC-05:00) Indiana (East)</option>
                                <option value="14" <?php if($_REQUEST[timezone]==14) echo("selected") ?>>(UTC-05:00) Bogota, Lima, Quito</option>
                                <option value="15" <?php if($_REQUEST[timezone]==15) echo("selected") ?>>(UTC-04:00) Atlantic Time (Canada)</option>
                                <option value="16" <?php if($_REQUEST[timezone]==16) echo("selected") ?>>(UTC-04:00) Caracas, La Paz</option>
                                <option value="17" <?php if($_REQUEST[timezone]==17) echo("selected") ?>>(UTC-04:00) Santiago</option>
                                <option value="18" <?php if($_REQUEST[timezone]==18) echo("selected") ?>>(UTC-03:30) Newfoundland and Labrador</option>
                                <option value="19" <?php if($_REQUEST[timezone]==19) echo("selected") ?>>(UTC-03:00) Brasilia</option>
                                <option value="20" <?php if($_REQUEST[timezone]==20) echo("selected") ?>>(UTC-03:00) Buenos Aires, Georgetown</option>
                                <option value="21" <?php if($_REQUEST[timezone]==21) echo("selected") ?>>(UTC-03:00) Greenland</option>
                                <option value="22" <?php if($_REQUEST[timezone]==22) echo("selected") ?>>(UTC-02:00) Mid-Atlantic</option>
                                <option value="23" <?php if($_REQUEST[timezone]==23) echo("selected") ?>>(UTC-01:00) Azores</option>
                                <option value="24" <?php if($_REQUEST[timezone]==24) echo("selected") ?>>(UTC-01:00) Cape Verde Islands</option>
                                <option value="25" <?php if($_REQUEST[timezone]==25) echo("selected") ?>>(UTC) Greenwich Mean Time: Dublin, Edinburgh, Lisbon, London</option>
                                <option value="26" <?php if($_REQUEST[timezone]==26) echo("selected") ?>>(UTC) Casablanca, Monrovia</option>
                                <option value="27" <?php if($_REQUEST[timezone]==27) echo("selected") ?>>(UTC+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                <option value="28" <?php if($_REQUEST[timezone]==28) echo("selected") ?>>(UTC+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                <option value="29" <?php if($_REQUEST[timezone]==29) echo("selected") ?>>(UTC+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                <option value="30" <?php if($_REQUEST[timezone]==30) echo("selected") ?>>(UTC+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                <option value="31" <?php if($_REQUEST[timezone]==31) echo("selected") ?>>(UTC+01:00) West Central Africa</option>
                                <option value="32" <?php if($_REQUEST[timezone]==32) echo("selected") ?>>(UTC+02:00) Bucharest</option>
                                <option value="33" <?php if($_REQUEST[timezone]==33) echo("selected") ?>>(UTC+02:00) Cairo</option>
                                <option value="34" <?php if($_REQUEST[timezone]==34) echo("selected") ?>>(UTC+02:00) Helsinki, Kiev, Riga, Sofia, Tallinn, Vilnius</option>
                                <option value="35" <?php if($_REQUEST[timezone]==35) echo("selected") ?>>(UTC+02:00) Athens, Istanbul, Minsk</option>
                                <option value="36" <?php if($_REQUEST[timezone]==36) echo("selected") ?>>(UTC+02:00) Jerusalem</option>
                                <option value="37" <?php if($_REQUEST[timezone]==37) echo("selected") ?>>(UTC+02:00) Harare, Pretoria</option>
                                <option value="38" <?php if($_REQUEST[timezone]==38) echo("selected") ?>>(UTC+03:00) Moscow, St. Petersburg, Volgograd</option>
                                <option value="39" <?php if($_REQUEST[timezone]==39) echo("selected") ?>>(UTC+03:00) Kuwait, Riyadh</option>
                                <option value="40" <?php if($_REQUEST[timezone]==40) echo("selected") ?>>(UTC+03:00) Nairobi</option>
                                <option value="41" <?php if($_REQUEST[timezone]==41) echo("selected") ?>>(UTC+03:00) Baghdad</option>
                                <option value="42" <?php if($_REQUEST[timezone]==42) echo("selected") ?>>(UTC+03:30) Tehran</option>
                                <option value="43" <?php if($_REQUEST[timezone]==43) echo("selected") ?>>(UTC+04:00) Abu Dhabi, Muscat</option>
                                <option value="44" <?php if($_REQUEST[timezone]==44) echo("selected") ?>>(UTC+04:00) Baku, Tbilisi, Yerevan</option>
                                <option value="45" <?php if($_REQUEST[timezone]==45) echo("selected") ?>>(UTC+04:30) Kabul</option>
                                <option value="46" <?php if($_REQUEST[timezone]==46) echo("selected") ?>>(UTC+05:00) Ekaterinburg</option>
                                <option value="47" <?php if($_REQUEST[timezone]==47) echo("selected") ?>>(UTC+05:00) Islamabad, Karachi, Tashkent</option>
                                <option value="48" <?php if($_REQUEST[timezone]==48) echo("selected") ?>>(UTC+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                <option value="49" <?php if($_REQUEST[timezone]==49) echo("selected") ?>>(UTC+05:45) Kathmandu</option>
                                <option value="50" <?php if($_REQUEST[timezone]==50) echo("selected") ?>>(UTC+06:00) Astana, Dhaka</option>
                                <option value="51" <?php if($_REQUEST[timezone]==51) echo("selected") ?>>(UTC+06:00) Sri Jayawardenepura</option>
                                <option value="52" <?php if($_REQUEST[timezone]==52) echo("selected") ?>>(UTC+06:00) Almaty, Novosibirsk</option>
                                <option value="53" <?php if($_REQUEST[timezone]==53) echo("selected") ?>>(UTC+06:30) Yangon Rangoon</option>
                                <option value="54" <?php if($_REQUEST[timezone]==54) echo("selected") ?>>(UTC+07:00) Bangkok, Hanoi, Jakarta</option>
                                <option value="55" <?php if($_REQUEST[timezone]==55) echo("selected") ?>>(UTC+07:00) Krasnoyarsk</option>
                                <option value="56" <?php if($_REQUEST[timezone]==56) echo("selected") ?>>(UTC+08:00) Beijing, Chongqing, Hong Kong SAR, Urumqi</option>
                                <option value="57" <?php if($_REQUEST[timezone]==57) echo("selected") ?>>(UTC+08:00) Kuala Lumpur, Singapore</option>
                                <option value="58" <?php if($_REQUEST[timezone]==58) echo("selected") ?>>(UTC+08:00) Taipei</option>
                                <option value="59" <?php if($_REQUEST[timezone]==59) echo("selected") ?>>(UTC+08:00) Perth</option>
                                <option value="60" <?php if($_REQUEST[timezone]==60) echo("selected") ?>>(UTC+08:00) Irkutsk, Ulaanbaatar</option>
                                <option value="61" <?php if($_REQUEST[timezone]==61) echo("selected") ?>>(UTC+09:00) Seoul</option>
                                <option value="62" <?php if($_REQUEST[timezone]==62) echo("selected") ?>>(UTC+09:00) Osaka, Sapporo, Tokyo</option>
                                <option value="63" <?php if($_REQUEST[timezone]==63) echo("selected") ?>>(UTC+09:00) Yakutsk</option>
                                <option value="64" <?php if($_REQUEST[timezone]==64) echo("selected") ?>>(UTC+09:30) Darwin</option>
                                <option value="65" <?php if($_REQUEST[timezone]==65) echo("selected") ?>>(UTC+09:30) Adelaide</option>
                                <option value="66" <?php if($_REQUEST[timezone]==66) echo("selected") ?>>(UTC+10:00) Canberra, Melbourne, Sydney</option>
                                <option value="67" <?php if($_REQUEST[timezone]==67) echo("selected") ?>>(UTC+10:00) Brisbane</option>
                                <option value="68" <?php if($_REQUEST[timezone]==68) echo("selected") ?>>(UTC+10:00) Hobart</option>
                                <option value="69" <?php if($_REQUEST[timezone]==69) echo("selected") ?>>(UTC+10:00) Vladivostok</option>
                                <option value="70" <?php if($_REQUEST[timezone]==70) echo("selected") ?>>(UTC+10:00) Guam, Port Moresby</option>
                                <option value="71" <?php if($_REQUEST[timezone]==71) echo("selected") ?>>(UTC+11:00) Magadan, Solomon Islands, New Caledonia</option>
                                <option value="72" <?php if($_REQUEST[timezone]==72) echo("selected") ?>>(UTC+12:00) Fiji Islands, Kamchatka, Marshall Islands</option>
                                <option value="73" <?php if($_REQUEST[timezone]==73) echo("selected") ?>>(UTC+12:00) Auckland, Wellington</option>
                                <option value="74" <?php if($_REQUEST[timezone]==74) echo("selected") ?>>(UTC+13:00) Nuku'alofa</option>
                                
                            </select>
                        </div>
                    </div>
                    <script>
                    var d = new Date()                 
                    var n = d.getTimezoneOffset()/60>>0;
                    n = n + 12;
                    var arr_time = [72, 71, 66, 61, 56, 54, 50, 46, 43, 38, 32, 27, 25, 23, 22, 18, 15, 12, 8, 5, 4, 3, 2, 1, 0];
                    var _timezone = arr_time[n];
                    //alert(_timezone);
                    <? 
                    if($_REQUEST[mode] != "generate"){ 
                    ?>   
                        $("#timezone_list").val(_timezone);
                    <? 
                    }
                    ?>
                    </script>
                    <div>
                        <h3 class="page-title">
                            Reports
                            <small>stats and charts</small>
                        </h3>
                    </div>
                    
                </div>
                <div>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Reports</a></li>
                    
                </ul>
                </div>
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
                            <h4><i class="icon-reorder"></i>  Reports</h4>
                        </div>
              
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs">
                                <ul class="nav nav-tabs">
                                    <li <? if (($_REQUEST[tab] == '5') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab5" data-toggle="tab" >SubID</a></li>
                                </ul>
  
                                <div class="tab-content">                               
                                    <div style = "display:none" id = "download"></div>
                                    

                                    <div class="tab-pane <? if (($_REQUEST[tab] == '5') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab5">                                                                        
                                        <div class="widget-body form span6" >
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_5" method="POST">
                                                <input type="hidden" name="tab" value="5"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range5-startdate" id="form-date-range5-startdate" value="<?= $_REQUEST['form-date-range5-startdate']?>">
                                                <input type="hidden" name="form-date-range5-enddate" id="form-date-range5-enddate" value="<?= $_REQUEST['form-date-range5-enddate']?>">
                                                <input type="hidden" id="timezone_5" name="timezone" value="12"/>
                                                <div class="control-group">
                                                    <? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range5-startdate'])) == 0)
                                                        {
                                                            $endDate5 = new DateTime();
                                                            $startDate5  = new DateTime();
                                                            
                                                            $startDate5->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range5-enddate'] = $endDate5->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range5-startdate'] = $startDate5->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range5-startdate'])) > 0)
                                                        {
                                                            $endDate5 = new DateTime($_REQUEST['form-date-range5-enddate']); 
                                                            $startDate5  = new DateTime($_REQUEST['form-date-range5-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate5     = "<?php echo $startDate5->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate5     = "<?php echo $endDate5->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range5" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate5->format('F j, Y')." - ".$endDate5->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                  
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3" style="width:90px;">SubID 1:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="subid1_5" name="subid1_5" value="<?= $_REQUEST[subid1_5] ?>" class=""/>
                                                    </div>
                                                </div>    
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;width:90px;">SubID 2:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="subid2_5" name="subid2_5" value="<?= $_REQUEST[subid2_5] ?>" class=""/>
                                                    </div>
                                                </div>                                  
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3" style="width:90px;">SubID 3: </label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="subid3_5" name="subid3_5" value="<?= $_REQUEST[subid3_5] ?>" class=""/>
                                                    </div>
                                                </div>          
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;width:90px;">SubID 4:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="subid4_5" name="subid4_5" value="<?= $_REQUEST[subid4_5] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float:left;">
                                                    <label class="control-label" for="input3" style="width:90px;">SubID 5: </label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="subid5_5" name="subid5_5" value="<?= $_REQUEST[subid5_5] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;width:90px;">Campaign: </label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="proj_name_5" name="proj_name_5" value="<?= $_REQUEST[proj_name_5] ?>" class=""/>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_5').val(timezone);
                                                            $('#form_5').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                            
                                                    <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_5').val(timezone);
                                                    $('#type2').value = 'csv';
                                                    getSubCSV(
                                                        startDate5,
                                                        endDate5, 
                                                        $('#subid1_5').val(), 
                                                        $('#subid2_5').val(), 
                                                        $('#subid3_5').val(), 
                                                        $('#subid4_5').val(), 
                                                        $('#subid5_5').val(), 
                                                        $('#proj_name_5').val(), 
                                                        timezone);    
                                                        ">Save as CSV</a> 
                                                            
                                                            
                                                </div>
                                            </form>

                                        </div>
                                        
                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_5" ></div>
                                            
                                        </div>
                                        


                                        <? if (($_REQUEST[tab] == '5') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_5">
                                                    <thead>
                                                        <tr>
                                                            <th>CID</th>
                                                            <th>Application</th>
                                                            <th>Subid #1</th>
                                                            <th>Subid #2</th>
                                                            <th>Subid #3</th>
                                                            <th>Subid #4</th> 
                                                            <th>Subid #5</th> 
                                                            <th>Clicks</th>
                                                            <th>Open Session</th>
                                                            <th>Installs Accepted</th>
                                                            <th>Installs Started</th>
                                                            <th>Installs Completed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                            <th>EPC</th>
                                                            <th>Network Revenue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;
$res_arr = array();   
/////                                                     
                            $sql = " 
                                SELECT
                                    pd_click.proj_id, pd_click.subid_id, pd_click.clicks,                                     
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM
                                    (
                                        SELECT 
                                            count(id) as clicks, 
                                            proj_id, 
                                            subid_id 
                                        FROM 
                                            projects_downloads 
                                        WHERE
                                            download_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY proj_id, subid_id
                                    ) pd_click                                
                                LEFT JOIN projects p ON pd_click.proj_id = p.id
                                LEFT JOIN subid s ON pd_click.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][clicks] = $row[clicks];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];
} 

 /////
                            $sql = " 
                                SELECT
                                    pdip.proj_id, pdip.proj_id, pdip.subid_id, 
                                    pdip.open_sessions, pdip.install_accepted, pdip.install_started, pdip.install_completed,                                    
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM
                                    (
                                        SELECT 
                                            pd.proj_id, pd.subid_id, 
                                            sum(ip.open_session) as open_sessions, 
                                            sum(ip.install_accepted) as install_accepted, 
                                            sum(ip.install_started) as install_started, 
                                            sum(ip.install_completed) as install_completed 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN install_projects ip ON pd.id=ip.download_id
                                        WHERE
                                            
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)  
                                        GROUP BY proj_id, subid_id
                                    ) pdip
                                LEFT JOIN projects p ON pdip.proj_id = p.id
                                LEFT JOIN subid s ON pdip.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ";
$q = mysqli_query($newconn,$sql);
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][open_sessions] = $row[open_sessions];   
    $res_arr[$row[proj_id]][$row[subid_id]][install_accepted] = $row[install_accepted];
    $res_arr[$row[proj_id]][$row[subid_id]][install_started] = $row[install_started];
    $res_arr[$row[proj_id]][$row[subid_id]][install_completed] = $row[install_completed];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];
}

/////
                            $sql = " 
                                SELECT
                                    pdio.proj_id, pdio.subid_id, pdio.total, pdio.network_revenue, 
                                    s.subid1, s.subid2, s.subid3, s.subid4, s.subid5,
                                    p.proj_name
                                FROM 
                                    (
                                        SELECT 
                                            pd.proj_id, pd.subid_id, 
                                            sum(io.price*io.adjust_rate/100) as total, 
                                            sum(io.price*io.adjust_rate/100*(100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN 
                                            ( SELECT * FROM install_offers WHERE install_completed=1) io ON pd.id = io.download_id 
                                        WHERE
                                            
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY pd.proj_id, pd.subid_id
                                    ) pdio 
                                LEFT JOIN projects p ON pdio.proj_id = p.id
                                LEFT JOIN subid s ON pdio.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%' AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%'
                                ORDER BY pdio.total DESC
                                ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);


$rowcount = 0;
while($row=mysqli_fetch_assoc($q))
{
    $res_arr[$row[proj_id]][$row[subid_id]][proj_id] = $row[proj_id];
    $res_arr[$row[proj_id]][$row[subid_id]][total] = $row[total];
    $res_arr[$row[proj_id]][$row[subid_id]][network_revenue] = $row[network_revenue];
    $res_arr[$row[proj_id]][$row[subid_id]][subid1] = $row[subid1];
    $res_arr[$row[proj_id]][$row[subid_id]][subid2] = $row[subid2];
    $res_arr[$row[proj_id]][$row[subid_id]][subid3] = $row[subid3];
    $res_arr[$row[proj_id]][$row[subid_id]][subid4] = $row[subid4];
    $res_arr[$row[proj_id]][$row[subid_id]][subid5] = $row[subid5];
    $res_arr[$row[proj_id]][$row[subid_id]][proj_name] = $row[proj_name];  //var_dump($res_arr[$row[proj_id]][$row[subid_id]]); 
    
    if ($rowcount < 5)
    {
        array_push($topName,$row[proj_name]);
        array_push($topAmount,$row[total]);
        $rowcount++;
    }
    
    //echo($row[total]);echo("<br>");
}                                  //exit;
                            
                                
                            
                                                        //$q = mysqli_query($newconn,$sql);
                                                        
                                                        $total_clicks = 0;
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_start = 0;
                                                        $total_install_success = 0;
                                                        $total_revenue = 0;
                                                        $total_network = 0;
                                                        $rowcount = 0;
                                                        
                                                        
                                                        //while ($row = mysqli_fetch_assoc($q)) {
                                                        foreach($res_arr as $res_arr_proj)
                                                        {
                                                            foreach($res_arr_proj as $row)
                                                            {
                                                                  
                                                            $total_clicks += $row[clicks];
                                                            $total_open_sessions += $row[open_sessions];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_start += $row[install_started];
                                                            $total_install_success += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                            $total_network += $row[network_revenue];
                                                            
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[proj_id] ?></td>
                                                                <td><?= $row[proj_name] ?></td>
                                                                <td><?= $row[subid1] ?></td>
                                                                <td><?= $row[subid2] ?></td>
                                                                <td><?= $row[subid3] ?></td>
                                                                <td><?= $row[subid4] ?></td>
                                                                <td><?= $row[subid5] ?></td>
                                                                <td><? if($row[clicks]==NULL) echo "0"; else echo($row[clicks]); ?></td>
                                                                <td><? if($row[open_sessions]==NULL) echo "0"; else echo($row[open_sessions]); ?></td>
                                                                <td><? if($row[install_accepted]==NULL) echo "0"; else echo($row[install_accepted]); ?></td>
                                                                <td><? if($row[install_started]==NULL) echo "0"; else echo($row[install_started]); ?></td>
                                                                <td><? if($row[install_completed]==NULL) echo "0"; else echo($row[install_completed]); ?></td>
                                                                <td>$<?= number_format($row[total], 2, ".", ",")?></td>
                                                                <td>$<?= number_format($row[total]/$row[install_completed], 2, ".", ",")?></td>
                                                                <td>$<?= number_format($row[total]/$row[clicks], 2, ".", ",")?></td>
                                                                <td>$<?= number_format($row[network_revenue], 2, ".", ",")?></td>
                                                            </tr>
                                                            <?      
                                                            
                                                            }
                                                        }
                                                       
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>
                                                
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 1000px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th> 
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                            <th>EPC</th>
                                                            <th>Network Revenue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td><?= $total_clicks?></td>
                                                            <td><?= $total_open_sessions?></td> 
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_start?></td>
                                                            <td><?= $total_install_success?></td>
                                                            <td>$<?= number_format($total_revenue, 2, ".", ",")?></td>
                                                            <td>$<?= number_format($total_revenue / $total_install_success, 2, ".", ",")?></td>
                                                            <td>$<?= number_format($total_revenue / $total_clicks, 2, ".", ",")?></td>
                                                            <td>$<?= number_format($total_network, 2, ".", ",")?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                                         <script> 
             
$(document).ready(function(){
    
    <?php 
        echo " var s1 = [".$topAmount[0]." , ".$topAmount[1].", ".$topAmount[2].", ".$topAmount[3].",".$topAmount[4]."];";  
        echo " var ticks = ['".$topName[0]."' , '".$topName[1]."', '".$topName[2]."', '".$topName[3]."','".$topName[4]."'];"    
    ?> 
    var plot1 = $.jqplot('chart_sort_div_5', [s1], {
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            
        },

        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            yaxis: {
                min: 0,
                tickOptions: {formatString: '$%d'}
            }
        },
        seriesColors: [ "#f89406"]
    });
});

       
                                                </script>
                                            </div>
                                        <? } ?>
                                    </div>

                                    
                                </div>
                            </div>

                            
                        </div>

                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>

            </div>
        </div>

    </div>
    <!-- END PAGE CONTENT-->
</div>
<!-- END PAGE CONTAINER-->
</div>

<? include 'z_footer.php'; ?>
