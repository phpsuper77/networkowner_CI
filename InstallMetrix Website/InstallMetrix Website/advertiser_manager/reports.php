<?
include 'z_header.php';
$newconn = mysqli_connect(SQLHOST, SQLUSER, SQLPASS, SQLDB);     

$topAmount = array();
$topName = array();
$endDate1 = 	new DateTime('2000-01-01');
$startDate1 = 	new DateTime('2000-01-01');
$endDate6 = 	new DateTime('2000-01-01');
$startDate6 = 	new DateTime('2000-01-01');
$endDate8 = 	new DateTime('2000-01-01');
$startDate8 = 	new DateTime('2000-01-01');

/*
$arr_timezone = array(
-12,-11,-10,-9,-8,-7,-7,-7,-6,-6,-6,-6,-5,-5,-5,-4,-4,-4,-3,-3,-3,-3,-2,-1,-1,-0,-0,1,1,1,1,1,2,2,2,2,2,2,3,3,3,3,3,4,4,4,5,5,5,5,6,6,6,6,7,7,8,8,8,8,8,9,9,9,9,9,10,10,10,10,10,11,12,12,13
);

//var_dump($_REQUEST[timezone]);
if($_REQUEST[timezone] == NULL) $_REQUEST[timezone] = 4;
$timezone = $arr_timezone[$_REQUEST[timezone]];
$default_timezone = -8;
$diff_timezone = $timezone - $default_timezone;
 */
?>


<div id="body">
	
 <script>
	function  getACSV(startdate, enddate, searchString, searchCampaign, searchCatagory, timezone) 
	{
		
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchString="	+ searchString;
		reportspecs = reportspecs + "&searchCampaign="	+ searchCampaign;
		reportspecs = reportspecs + "&searchCatagory="	+ searchCatagory;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=advertising";
	
		window.open(reportspecs, '_blank');

	  }
	
	 function  getGeoCSV(startdate, enddate, adv, offer, subid, country, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&adv_6="	+ adv;
        reportspecs = reportspecs + "&offer_6="    + offer;
        reportspecs = reportspecs + "&subid_6="    + subid;
        reportspecs = reportspecs + "&country_6="    + country;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=geo";
		window.open(reportspecs, '_blank');

	  }
	 
     
	 function  getDayCSV(startdate, enddate, searchAdv, searchSubid, searchCountry , searchOffer, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&adv_8="		+ searchAdv;
		reportspecs = reportspecs + "&subid_8="		+ searchSubid;
		reportspecs = reportspecs + "&country_8="	+ searchCountry;
		reportspecs = reportspecs + "&offer_8="		+ searchOffer;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=day";
        
		window.open(reportspecs, '_blank');

	  }
      
      function  getDailyBreakdownCSV(startdate, enddate, searchAdv,  searchSubid, searchCountry , searchOffer, timezone) 
     {
        reportspecs = "report_data.php?startDate="        + startdate;
        reportspecs = reportspecs + "&endDate="            + enddate;
        reportspecs = reportspecs + "&adv_9="        + searchAdv;
        reportspecs = reportspecs + "&subid_9="        + searchSubid;
        reportspecs = reportspecs + "&country_9="    + searchCountry;
        reportspecs = reportspecs + "&offer_9="        + searchOffer;
        reportspecs = reportspecs + "&timezone="    + timezone;
        reportspecs = reportspecs + "&type=daily";
        
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
                                    <li <? if ($_REQUEST[tab] == '9') { ?>class="active"<? } ?>><a href="#portlet_tab9" data-toggle="tab" >Daily Breakdowns</a></li>
                                    <li <? if ($_REQUEST[tab] == '8') { ?>class="active"<? } ?>><a href="#portlet_tab8" data-toggle="tab" >Day Parting</a></li>
                                    <li <? if ($_REQUEST[tab] == '6') { ?>class="active"<? } ?>><a href="#portlet_tab6" data-toggle="tab" >Geo</a></li>
                                    <li <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>class="active"<? } ?>><a href="#portlet_tab1" data-toggle="tab" >Advertisers</a></li>
                                </ul>
  
                                <div class="tab-content">                               
                                    <div style = "display:none" id = "download"></div>
                                   
                                    <div class="tab-pane <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '')) { ?>active<? } ?>" id="portlet_tab1">
                                        <div class="widget-body form span6" >
                                            
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_1" method="POST">
                                                
                                                <input type="hidden" name="tab" value="1"/>
                                                <input id = "type1" type="hidden" name="type" value="html"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range1-startdate" id="form-date-range1-startdate" value="<?= $_REQUEST['form-date-range1-startdate']?>">
                                                <input type="hidden" name="form-date-range1-enddate" id="form-date-range1-enddate" value="<?= $_REQUEST['form-date-range1-enddate']?>">
                                                <input type="hidden" id="timezone_1" name="timezone" value="12"/>
                                                <div class="control-group">
													
												    <? 
                                                    //    Neither Request or Session holds a date
                                                    
                                                        if (strlen(trim($_REQUEST['form-date-range1-startdate'])) == 0)
                                                        {
                                                            $endDate1 = new DateTime();
                                                            $startDate1  = new DateTime();  
                                                            
                                                            $startDate1->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range1-enddate'] = $endDate1->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range1-startdate'] = $startDate1->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range1-startdate'])) > 0)
                                                        {
                                                            $endDate1 = new DateTime($_REQUEST['form-date-range1-enddate']); 
                                                            $startDate1  = new DateTime($_REQUEST['form-date-range1-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate1     = "<?php echo $startDate1->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate1     = "<?php echo $endDate1->format('Y-m-d 00:00:00'); ?>";    
                                                                                                          
                                                        
                                                    </script>
													
													   <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range1" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate1->format('F j, Y')." - ".$endDate1->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="input3">Search String:</label>
                                                    <div class="controls">
                                                        <input type="text" id="search_string_1" name="search_string_1" value="<?= $_REQUEST[search_string_1] ?>" class="span12"/>
                                                    </div>
                                                </div>                                                
                                                <div class="control-group">
                                                    <label class="control-label" for="input3">Search Campign:</label>
                                                    <div class="controls"> 
                                                        <select class="span6 chosen" id="campaign_list_1" name='campaign_list_1' style="width: 150px;">
                                                            <option value="-1" <?php if($_REQUEST[campaign_list_1]==NULL) echo " selected" ?>>&nbsp;</option>                                                            
                                                            <?
                                                            $sql1 = "SELECT * FROM projects";
                                                            $q1 = mysqli_query($newconn, $sql1);
                                                            while ($row1 = mysqli_fetch_assoc($q1)) {  
                                                                ?>                                                                
                                                                <option value="<?= $row1[id] ?>" <?php if(($_REQUEST[campaign_list_1]!=NULL)&&((int)$_REQUEST[campaign_list_1]==(int)$row1[id])) {echo("selected");} ?> ><?= $row1[proj_name]?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="input3">Search Category:</label>
                                                    <div class="controls">
                                                        <select class="span6 chosen" id="cat_list_1" name='cat_list_1' style="width: 150px;">
                                                            <option value="-1" <?php if($_REQUEST[cat_list_1]==-1) echo " selected" ?>>&nbsp;</option>                                                            
                                                            <?
                                                            $sql1 = "SELECT * FROM categories";
                                                            $q1 = mysqli_query($newconn, $sql1);
                                                            while ($row1 = mysqli_fetch_assoc($q1)) {
                                                                ?>
                                                                <option value="<?= $row1[id] ?>" <?php if($_REQUEST[cat_list_1]==$row1[id]) echo " selected" ?>><?= $row1[name]?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
	                                            <div style="height: 45px;">                                                 
												<a href="#" class="btn btn-success" name = "html" 
													onclick="
														strCampaign = $('#campaign_list_1').val();                                                        
														strCampaign = strCampaign.trim();
														if (strCampaign.length == 0){strCampaign = -1;}
														strCatagory = $('#cat_list_1').val();
														strCatagory = strCatagory.trim();
														if (strCatagory.length == 0){strCatagory= -1;}
														$('#campaign_list_1').val(strCampaign);
														$('#cat_list_1').val(strCatagory);
                                                        timezone = $('#timezone_list').val();
														$('#timezone_1').val(timezone);                                                        														
														$('#type1').value = 'html';    
                                                        $('#form_1').submit();
														"
                                                    >
                                                  <i class="icon-check"></i> Generate Report</a>  
												<a href="#" id = 'csv1' class="btn btn-success" name = "csv_download" 
                                                    onclick="
													    strCampaign = $('#campaign_list_1').val();
													    strCampaign = strCampaign.trim();
													    if (strCampaign.length == 0){strCampaign = -1;}
													    strCatagory = $('#cat_list_1').val();
													    strCatagory = strCatagory.trim();
													    if (strCatagory.length == 0){strCatagory= -1;}
													    $('#type1').value = 'csv';
                                                        timezone = $('#timezone_list').val();
                                                        $('#timezone_1').val(timezone);                                                    
													    getACSV(
														    startDate1,
														    endDate1,
														    $('#search_string_1').val(), 
														    strCampaign,
														    strCatagory,
                                                            timezone);"
                                                >Save as CSV</a>
                                                       
													</div>
                                            </form>
                                        </div>
                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_1" ></div>
                                        </div>
                                        <? if (($_REQUEST[tab] == '1') || ($_REQUEST[tab] == '') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_1">
                                                    <thead>
                                                        <tr>
                                                            <th>AID</th>
                                                            <th>Advertiser</th>
                                                            <th>Category</th>
                                                            <th>Offer</th>    
                                                            <th>Offer Screens</th>      
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Successed</th>
                                                            <th>Adjust Install</th> 
                                                            <th>Total Revenue</th>
                                                            <th>AM Commission</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;  
 							$tmp_id = (int)$_REQUEST[search_string_1];
							$campign = $_REQUEST[campaign_list_1];
							$cat = $_REQUEST[cat_list_1];

							
$sql = "
SELECT u1.id as user_id, u1.subid, CONCAT(u1.user_first_name, ' ', u1.user_last_name) as user_name, 
             o.id as offer_id, o.offer_name, 
             ct.cat_id, ct.name as cat_name, cr.offer_shown, cr.install_accepted, cr.install_started, cr.install_completed, cr.adjust_install, 
             cr.price as total, cr.am_commission
FROM 
        offers o
";
if ($campign!=-1) 
    $sql .= "INNER JOIN";
else
    $sql .= "LEFT JOIN";
 
$sql .= "
        (SELECT offer_id, sum(offer_shown) as offer_shown, sum(install_accepted) as install_accepted, 
        sum(install_started) as install_started, sum(install_completed) as install_completed ,sum(install_completed*adjust_rate/100) as adjust_install, 
        sum(install_completed*price*adjust_rate/100) as price, sum(install_completed*price*adjust_rate/100*am_revenue) as am_commission
        FROM install_offers 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
        ";
        if ($campign!=-1) $sql .= "AND proj_id={$campign}";
        $sql .= "
        GROUP BY offer_id) cr 
ON o.id=cr.offer_id
LEFT JOIN users u1 ON o.assigned_user_id=u1.id
LEFT JOIN 
        (SELECT oc.offer_id, cat.name, cat.id as cat_id FROM offer_categories oc LEFT JOIN categories cat ON oc.category_id=cat.id WHERE oc.isgroup=0) ct 
ON o.id=ct.offer_id
WHERE 
(                  
    u1.user_manager={$user_id} AND
    (
    o.offer_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_first_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_last_name LIKE '%{$_REQUEST[search_string_1]}%' OR    
    u1.subid = {$tmp_id}
    )
) 
";
 if ($cat!=-1) $sql .= " AND ct.cat_id={$cat}"; 
$sql .= " ORDER BY cr.price DESC";    
                            
                            
//echo("<textarea>" . $sql . "</textarea>");exit;
                                                        $q = mysqli_query($newconn,$sql);
                                                
                                                        $total_offerscreen_shown = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_adjust_installs = 0; 
                                                        $total_revenue = 0;
                                                        $total_AM = 0;
                                                        $total_network = 0;
                                                        $rowcount = 0;                                                        
                                                        
                                                        while ($row = mysqli_fetch_assoc($q)) { 
                                                            
                                                            if($row[offer_shown] == NULL) $row[offer_shown] = 0;
                                                            if($row[install_accepted] == NULL) $row[install_accepted] = 0;
                                                            if($row[install_started] == NULL) $row[install_started] = 0;
                                                            if($row[install_completed] == NULL) $row[install_completed] = 0;
                                                            
                                                            $total_offerscreen_shown += $row[offer_shown];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_adjust_installs += (int)$row[adjust_install];
                                                            
                                                            $total_revenue += $row[total];
                                                            $total_AM += $row[am_commission];
                                                            $total_network += $row[network_revenue];     
                                                            
                                                            if ($rowcount < 5)
                                                            {
																array_push($topName,$row[offer_name]);
																array_push($topAmount,$row[total]);
															}
                                                            $rowcount ++;
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><a href="adv_edit.php?id=<?=$row[user_id] ?>"><?= $row[subid] ?></a></td>
                                                                <td> <!--<a href="adv_edit.php?id=<?= $row[user_id] ?>">--><?echo($row[user_name]);?></a></td>
                                                                <td> <a href="category_edit.php?id=<?=$row[cat_id] ?>"><?=$row[cat_name] ?></a></td>
                                                                <td><a href="offer_edit.php?oid=<?= $row[offer_id] ?>"><?= $row[offer_name]?></a></td>                                                                
                                                                <td><?= $row[offer_shown] ?></td>
                                                                <td><?= $row[install_accepted] ?></td>
                                                                <td><?= $row[install_started] ?></td>
                                                                <td><?= $row[install_completed] ?></td>
                                                                <td><?= (int)$row[adjust_install] ?></td>
                                                                <td>$<?= number_format($row[total],2) ?></td>
                                                                <td>$<?= number_format($row[am_commission],2) ?></td>                                                                
                                                            </tr>
                                                            <?
                                                            
                                                            //if ($row[adv_revenue] == NULL) $row[adv_revenue] = 0;                                                            
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>
                                            
                                                
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 800px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Offer Screens</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Successed</th>
                                                            <th>Adjust Installs</th>
                                                            <th>Total Revenue</th>
                                                            <th>AM Commission</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td><?= $total_offerscreen_shown?></td>
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_started?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <td><?= $total_adjust_installs?></td>
                                                            <td>$<?= number_format($total_revenue,2)?></td>
                                                            <td>$<?= number_format($total_AM,2)?></td>                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>

         <script> 
			 
$(document).ready(function(){
	
	<?php 
		echo " var s1 = [".$topAmount[0]." , ".$topAmount[1].", ".$topAmount[2].", ".$topAmount[3].",".$topAmount[4]."];";  
		echo " var ticks = ['".$topName[0]."' , '".$topName[1]."', '".$topName[2]."', '".$topName[3]."','".$topName[4]."'];"    
	?> 
    var plot1 = $.jqplot('chart_sort_div_1', [s1], {
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            
        },
        /*
        legend: {
            show: true,
            placement: 'outsideGrid'
        }, */
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
                                    

                                    <div class="tab-pane <? if ($_REQUEST[tab] == '6') { ?>active<? } ?>" id="portlet_tab6">
                                        <div class="widget-body form span6" >
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_6" method="POST">
                                                <input type="hidden" name="tab" value="6"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range6-startdate" id="form-date-range6-startdate" value="<?= $_REQUEST['form-date-range6-startdate']?>">
                                                <input type="hidden" name="form-date-range6-enddate" id="form-date-range6-enddate" value="<?= $_REQUEST['form-date-range6-enddate']?>">
                                                <input type="hidden" id="timezone_6" name="timezone" value="12"/>
                                                <div class="control-group" style="margin-bottom: 20px;">
													<? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range6-startdate'])) == 0)
                                                        {
                                                            $endDate6 = new DateTime();
                                                            $startDate6  = new DateTime();
                                                            
                                                            $startDate6->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range6-enddate'] = $endDate6->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range6-startdate'] = $startDate6->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range6-startdate'])) > 0)
                                                        {
                                                            $endDate6 = new DateTime($_REQUEST['form-date-range6-enddate']); 
                                                            $startDate6  = new DateTime($_REQUEST['form-date-range6-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate6     = "<?php echo $startDate6->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate6     = "<?php echo $endDate6->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" style="width: 90px;" >Date Ranges:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <div id="form-date-range6" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate6->format('F j, Y')." - ".$endDate6->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="float:left;margin-bottom: 10px;">
                                                    <label class="control-label" for="input3" style="width: 90px;">Advertiser:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:100px" id="adv_6" name="adv_6" value="<?= $_REQUEST[adv_6] ?>" class="span12"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 10px;">
                                                    <label class="control-label" for="input3" style="width: 90px; margin-right: 10px;">Offer:</label>
                                                    <div class="controls">
                                                        <input type="text" style="width:100px" id="offer_6" name="offer_6" value="<?= $_REQUEST[offer_6] ?>" class="span12"/>
                                                    </div>
                                                </div>
                                                  
                                                <div class="control-group" style="float:left;margin-bottom: 10px;">
                                                    <label class="control-label" for="input3" style="width: 90px;">Subid:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:100px" id="subid_6" name="subid_6" value="<?= $_REQUEST[subid_6] ?>" class="span12"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 10px;">
                                                    <label class="control-label" for="input3" style="width: 90px; margin-right: 10px;">Country:</label>
                                                    <div class="controls" >
                                                        <input type="text" style="width:100px" id="country_6" name="country_6" value="<?= $_REQUEST[country_6] ?>" class="span12"/>
                                                    </div>
                                                </div>                                                

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_6').val(timezone);
                                                            $('#form_6').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                            
                                                    <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
													$('#type2').value = 'csv';
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_6').val(timezone);
                                                    
													getGeoCSV(
														startDate6,
														endDate6,  
														$('#adv_6').val(), 
                                                        $('#offer_6').val(), 
                                                        $('#subid_6').val(), 
                                                        $('#country_6').val(), 
														timezone);	
                                                        ">Save as CSV</a> 
                                                            
                                                            
                                                            
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_6" ></div>
                                        </div>



                                        <? if (($_REQUEST[tab] == '6') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_6">
                                                    <thead>
                                                        <tr>
                                                            <th>Country</th>                                                            
                                                            <th>Offer Shown</th>
                                                            <th>Installs Accepted</th>
                                                            <th>Installs Started</th>
                                                            <th>Installs Completed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;
                                                        
$arr_res_tmp = array();

$adv = $_REQUEST[adv_6];
$offer = $_REQUEST[offer_6];
$subid = $_REQUEST[subid_6];
$country = $_REQUEST[country_6];

$sql = "

        SELECT  sum(io.offer_shown) as offer_shown, sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, 
                sum(io.install_completed) as install_completed, sum(io.install_completed*io.price*io.adjust_rate/100) as total,             
                sum(io.install_completed*io.price*io.adjust_rate/100*(100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue, 
                l.country
        FROM 
        (
            SELECT * FROM install_offers 
            WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                    install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
        ) io
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id  
        LEFT JOIN subid s ON s.id=pd.subid_id
        LEFT JOIN geo_location l ON l.id=pd.location_id
        LEFT JOIN users u ON u.id=io.user_id
        LEFT JOIN offers o ON o.id=io.offer_id  
        WHERE   s.subid_all LIKE '%{$subid}%' AND l.country LIKE '%{$country}%' AND 
                (u.user_first_name LIKE '%{$adv}%' OR u.user_last_name LIKE '%{$adv}%') AND
                o.offer_name LIKE '%{$offer}%' AND u.user_manager={$user_id} 
        GROUP BY l.country 
        ORDER BY sum(io.install_completed*io.price*io.adjust_rate/100) DESC
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn,$sql);
while ($row = mysqli_fetch_assoc($q)) {
    if($row[country] == NULL)
    {
        $row[country] = "";
    }
    $arr_res_tmp[$row[country]][country] = $row[country];
    $arr_res_tmp[$row[country]][offer_shown] = $row[offer_shown]; 
    $arr_res_tmp[$row[country]][install_accepted] = $row[install_accepted]; 
    $arr_res_tmp[$row[country]][install_started] = $row[install_started]; 
    $arr_res_tmp[$row[country]][install_completed] = $row[install_completed]; 
    $arr_res_tmp[$row[country]][total] = $row[total]; 
    $arr_res_tmp[$row[country]][network_revenue] = $row[network_revenue];
     
    if ($rowcount < 5)
    {
        array_push($topName,$row[country]);
        array_push($topAmount,$row[total]);    
        $rowcount ++;
    }
}    

						        // var_dump($sql); exit;

                                                        
                                                        
                                                        $total_offer_shown = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        
                                                        foreach($arr_res_tmp as $row) {        //var_dump($row);exit;
                                                            $total_offer_shown += $row[offer_shown];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                            
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[country] ?></td>
                                                                <td>&nbsp;</td>
                                                                <td><? if($row[offer_shown] == NULL) echo "0"; else echo($row[offer_shown]);?></td>
                                                                <td><? if($row[install_accepted] == NULL) echo "0"; else echo($row[install_accepted]);?></td>
                                                                <td><? if($row[install_started] == NULL) echo "0"; else echo($row[install_started]);?></td>
                                                                <td><? if($row[install_completed] == NULL) echo "0"; else echo($row[install_completed]);?></td>
                                                                <td>$<?= number_format($row[total], 2, ".", ",") ?></td>
                                                                <td>$<?= number_format($row[total]/$row[install_completed], 2, ".", ",") ?></td>
                                                            </tr>
                                                            <?    
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>
                                                
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 1000px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Offer Showns</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                        <td><?= $total_offer_shown?></td> 
                                                        <td><?= $total_install_accepted?></td> 
                                                        <td><?= $total_install_started?></td>
                                                        <td><?= $total_install_successed?></td>
                                                        <td>$<?= number_format($total_revenue, 2, ".", ",")?></td>
                                                        <td>$<?= number_format($total_revenue / $total_install_successed, 2, ".", ",")?></td>                                                        
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                         <script> 
			 
$(document).ready(function(){
	
	<?php 
		echo " var s1 = [".$topAmount[0]." , ".$topAmount[1].", ".$topAmount[2].", ".$topAmount[3].",".$topAmount[4]."];";  
		echo " var ticks = ['".$topName[0]."' , '".$topName[1]."', '".$topName[2]."', '".$topName[3]."','".$topName[4]."'];"    
	?> 
    var plot1 = $.jqplot('chart_sort_div_6', [s1], {
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
                                    
                                                                       
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '8')  { ?>active<? } ?>" id="portlet_tab8">
                                        <div class="widget-body form" >
                                            
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_8" method="POST">
                                                <input type="hidden" name="tab" value="8"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range8-startdate" id="form-date-range8-startdate" value="<?= $_REQUEST['form-date-range8-startdate']?>">
                                                <input type="hidden" name="form-date-range8-enddate" id="form-date-range8-enddate" value="<?= $_REQUEST['form-date-range8-enddate']?>">
												<input type="hidden" id="timezone_8" name="timezone" value="12"/>
                                                <div class="control-group">
													<? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range8-startdate'])) == 0)
                                                        {
                                                            $endDate8 = new DateTime();
                                                            $startDate8  = new DateTime();
                                                            
                                                            $startDate8->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range8-enddate'] = $endDate8->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range8-startdate'] = $startDate8->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range8-startdate'])) > 0)
                                                        {
                                                            $endDate8     = new DateTime($_REQUEST['form-date-range8-enddate']); 
                                                            $startDate8  = new DateTime($_REQUEST['form-date-range8-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate8     = "<?php echo $startDate8->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate8     = "<?php echo $endDate8->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range8" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate8->format('F j, Y')." - ".$endDate8->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
												
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Advertiser:</label>
                                                    <div class="controls">
                                                        <input type="text" id="advertiser_8" name="advertiser_8" value="<?= $_REQUEST[advertiser_8] ?>" class=""/>
                                                    </div>
                                                </div>    
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Offer:&nbsp; </label>
                                                    <div class="controls">
                                                        <input type="text" id="offer_8" name="offer_8" value="<?= $_REQUEST[offer_8] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float:left;">
                                                    <label class="control-label" for="input3">Subid: </label>
                                                    <div class="controls">
                                                        <input type="text" id="subid_8" name="subid_8" value="<?= $_REQUEST[subid_8] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Country: </label>
                                                    <div class="controls">
                                                        <input type="text" id="Country_8" name="Country_8" value="<?= $_REQUEST[Country_8] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                
                                                

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_8').val(timezone);
                                                            $('#form_8').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                    <a href="#" id = 'csv1' class="btn btn-success" name = "csv_download" onclick="
													$('#type1').value = 'csv';
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_8').val(timezone);
													getDayCSV(
													    startDate8,
														endDate8, 
														$('#advertiser_8').val(), 
														$('#subid_8').val(), 
														$('#Country_8').val(), 
														$('#offer_8').val(),
                                                        timezone
                                                        );
                                                        " 
                                                        >Save as CSV</a>        
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form ">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_8" ></div>
                                        </div>
             
                                        <? if (($_REQUEST[tab] == '8') && ($_REQUEST[mode] == 'generate')) { 
                                            
                                        $adv = $_REQUEST[advertiser_8];
                                        $subid = $_REQUEST[subid_8];
                                        $country = $_REQUEST[Country_8];
                                        $offer = $_REQUEST[offer_8];
                                        ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_8">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Offer Shown</th>   
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                    $i = 0;
                    

                    // if advertiser filter is used, then get offer install accepted, install started and install completed
                    $sql = "    
                        SELECT
                            install_datetime, hour(install_datetime) as hour,           
                            sum(offer_shown) as offer_shown,
                            sum(install_accepted) as install_accepted,
                            sum(install_started) as install_started,
                            sum(install_completed) as install_completed,
                            sum(install_completed * io.adjust_rate/100) as adjust_install,
                            sum(install_completed * price * io.adjust_rate/100) as revenue
                        FROM 
                            (
                                SELECT * FROM install_offers 
                                WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
                            ) io
                        INNER JOIN projects_downloads pd ON pd.id=io.download_id
                        LEFT JOIN subid s ON pd.subid_id=s.id
                        LEFT JOIN geo_location l ON l.id=pd.location_id
                        LEFT JOIN offers ON io.offer_id = offers.id
                        LEFT JOIN users ON io.user_id = users.id
                        WHERE
                            (users.user_first_name LIKE '%{$adv}%' OR users.user_last_name LIKE '%{$adv}%') AND 
                            offers.offer_name LIKE '%{$offer}%' AND l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%'                             
                        GROUP BY hour(install_datetime)
                        ORDER BY install_datetime
                    ";
                                      
                    //echo("<textarea>" . $sql . "</textarea>"); exit;                                
                                                        $q = mysqli_query($newconn, $sql);
                                                        
                                                        $total_offer_shown = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        $rowcount = 0;
                                                        
                                                        $time_arr = array("midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                                                                        "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ) ;
                                                    
                                                        $pre_hour = 0;
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            
                                                            $hour = ($row[hour] + $diff_timezone) % 24;
                                                            if($hour<0) $hour = $hour + 24;
                                                            
                                                            if($row[offer_shown] == NULL) $row[offer_shown] = 0;
                                                            if($row[install_accepted] == NULL) $row[install_accepted] = 0;
                                                            if($row[install_started] == NULL) $row[install_started] = 0;
                                                            if($row[install_completed] == NULL) $row[install_completed] = 0;
                                                            
                                                            $total_offer_shown += $row[offer_shown];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[revenue];
                                                            
                                                            $rowcount ++;
                                                            
                                                            //var_dump($pre_hour);var_dump($hour);
                                                            for($xx=$pre_hour;$xx<$hour;$xx++)
                                                            {
                                                                
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $time_arr[$xx] ?></td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td>$0.00</td>
                                                                <td>$0.00</td>                                                                
                                                            </tr>
                                                        <?    
                                                            }
                                                        ?>

                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $time_arr[$hour] ?></td>
                                                                <td><?= $row[offer_shown] ?></td>
                                                                <td> <?= $row[install_accepted] ?></td>
                                                                <td> <?= $row[install_started] ?></td>
                                                                <td> <?= $row[install_completed] ?></td>
                                                                <td>$<?= number_format($row[revenue],2) ?></td>
                                                                <td>$<?= number_format($row[revenue]/$row[install_completed],2) ?></td>                                                                
                                                            </tr>
                                                            <?
                                                            $i++;
                                                            $pre_hour = $hour+1;                                                             
                                                        }
                                                            for($xx=$hour+1;$xx<24;$xx++)
                                                            {
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $time_arr[$xx] ?></td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td>$0.00</td>
                                                                <td>$0.00</td>                                                                
                                                            </tr>
                                                        <?    
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>
                                                
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 800px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Offer Showns</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Successed</th>
                                                            <th>Revenue</th>                                                                                                                        
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td><?= $total_offer_shown?></td> 
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_started ?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <td>$<?= number_format($total_revenue,2)?></td>                                                                                                                        
                                                        </tr>
                                                    </tbody> 
                                                </table>                                                      
                                                  
                                                <script>       /*
                                                            <?=$str_gen?>
                                                            <?= $str_max?>
                                                            var time_arr = ["midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                                                                        "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ];
                                                               var line3 = new Array(10);
                                                              for (var i = 0; i < 24; i++) {
                                                                line3[i] = new Array(2);
                                                                line3[i][0] = time_arr[i];
                                                                line3[i][1] = revenue[i];
                                                              }
                                                                
 
                                                                var plot3 = $.jqplot('chart_sort_div_8', [line3], {
                                                              series:[],
                                                              axesDefaults: {
                                                                tickRenderer: $.jqplot.CanvasAxisTickRenderer
                                                                },
                                                              axes: {
                                                                xaxis: {
                                                                  renderer: $.jqplot.CategoryAxisRenderer,                                                                  
                                                                  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                                                                  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                                                  tickOptions: {
                                                                      angle: -30,
                                                                      fontFamily: 'Courier New',
                                                                      fontSize: '9pt'
                                                                  }
                                                                   
                                                                },
                                                                yaxis: {
                                                                    min: 0,
                                                                    autoscale: true,
                                                                    ticks: addDollarCommasToArray(numTicksForArray(max, 10)) ,
                                                                    tickOptions: {
                                                                        textColor: '#8d8d8d',
                                                                        fontFamily: 'Arial Narrow',
                                                                        fontSize: '10px',
                                                                        formatString:'%d'
                                                                    }
                                                                }
                                                              }
                                                            });    */
                                                </script> 
                                            </div>
                                        <? } ?>
                                    </div>
                                    
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '9')  { ?>active<? } ?>" id="portlet_tab9">
                                        <div class="widget-body form" >
                                            
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_9" method="POST">
                                                <input type="hidden" name="tab" value="9"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range9-startdate" id="form-date-range9-startdate" value="<?= $_REQUEST['form-date-range9-startdate']?>">
                                                <input type="hidden" name="form-date-range9-enddate" id="form-date-range9-enddate" value="<?= $_REQUEST['form-date-range9-enddate']?>">
                                                <input type="hidden" id="timezone_9" name="timezone" value="12"/>
                                                <div class="control-group" style="width: 480px;">
                                                    <? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range9-startdate'])) == 0)
                                                        {
                                                            $endDate9 = new DateTime();
                                                            $startDate9  = new DateTime();
                                                            
                                                            $startDate9->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range9-enddate'] = $endDate9->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range9-startdate'] = $startDate9->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range9-startdate'])) > 0)
                                                        {
                                                            $endDate9     = new DateTime($_REQUEST['form-date-range9-enddate']); 
                                                            $startDate9  = new DateTime($_REQUEST['form-date-range9-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate9     = "<?php echo $startDate9->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate9     = "<?php echo $endDate9->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls" >
                                                        <div id="form-date-range9" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate9->format('F j, Y')." - ".$endDate9->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Advertiser:</label>
                                                    <div class="controls">
                                                        <input type="text" id="advertiser_9" name="advertiser_9" value="<?= $_REQUEST[advertiser_9] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Subid:&nbsp; </label>
                                                    <div class="controls">
                                                        <input type="text" id="subid_9" name="subid_9" value="<?= $_REQUEST[subid_9] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float:left;">
                                                    <label class="control-label" for="input3">Geo: </label>
                                                    <div class="controls">
                                                        <input type="text" id="geo_9" name="geo_9" value="<?= $_REQUEST[geo_9] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Offer: </label>
                                                    <div class="controls">
                                                        <input type="text" id="offer_9" name="offer_9" value="<?= $_REQUEST[offer_9] ?>" class=""/>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_9').val(timezone);
                                                            $('#form_9').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                           
                                                    <a href="#" id = 'csv1' class="btn btn-success" name = "csv_download" onclick="
                                                    $('#type1').value = 'csv';
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_9').val(timezone);
                                                    getDailyBreakdownCSV(
                                                        startDate9,
                                                        endDate9, 
                                                        $('#advertiser_9').val(), 
                                                        $('#subid_9').val(), 
                                                        $('#geo_9').val(), 
                                                        $('#offer_9').val(),
                                                        timezone)" 
                                                        >Save as CSV</a>        
                                                    
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form ">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_8" ></div>
                                        </div>
             
                                        <? if (($_REQUEST[tab] == '9') && ($_REQUEST[mode] == 'generate')) { 
                                            
                                        

                                        ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_9">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Offer Shown</th>                                                            
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th> 
                                                            <th>Revenue</th>
                                                            <th>RPI</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                    $i = 0;
 
//advertiser or bundle
$sql = "
    SELECT  DATE_FORMAT(io.install_datetime, '%Y-%m-%d') as date, sum(io.offer_shown) as offer_shown,
            sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, 
            sum(install_completed) as install_completed, sum(io.install_completed * io.adjust_rate / 100) as adjust_install,
            sum(io.install_completed*io.price*io.adjust_rate/100) as total 
    FROM 
    (
        SELECT * FROM install_offers 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
    ) io        
    INNER JOIN projects_downloads pd ON pd.id=io.download_id
    LEFT JOIN offers o ON io.offer_id=o.id
    LEFT JOIN users u ON o.assigned_user_id=u.id
    LEFT JOIN subid s ON s.id=pd.subid_id
    LEFT JOIN geo_location l ON l.id=pd.location_id
    WHERE                                                      
            CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[advertiser_9]}%' AND
            o.offer_name LIKE '%{$_REQUEST[offer_9]}%' AND s.subid_all LIKE '%{$_REQUEST[subid_9]}%' AND l.country LIKE '%{$_REQUEST[geo_9]}%'
    GROUP BY DATE_FORMAT(io.install_datetime, '%Y-%m-%d')
";

//echo("<textarea>" . $sql . "</textarea>"); exit;                                
                                                        $q = mysqli_query($newconn, $sql);
                                                        
                                                        $total_offer_showns = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_adjust_install = 0;
                                                        $total_revenue = 0;
                                                                                                                
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            $total_offer_showns += $row[offer_shown];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                        ?>

                                                            <tr class="odd gradeX">
                                                                
                                                                <td><?= $row[date] ?></td>                                  
                                                                <td> <?= $row[offer_shown] ?></td>
                                                                <td> <?= $row[install_accepted] ?></td>
                                                                <td> <?= $row[install_started] ?></td>
                                                                <td> <?= $row[install_completed] ?></td>
                                                                <td>$<?= number_format($row[total], 2) ?></td>
                                                                <td>$<?= number_format($row[total]/$row[install_completed], 2) ?></td>                                                                
                                                            </tr>
                                                            <?
                                                            $i++;  
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>

                                                <table class="table table-striped table-bordered" style="margin: auto;width: 800px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Offer Showns</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>                                                                
                                                            <th>Revenue</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                
                                                    <tr>
                                                        <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                        <td><?= $total_offer_showns ?></td>
                                                        <td><?= $total_install_accepted ?></td>
                                                        <td><?= $total_install_started?></td>
                                                        <td><?= $total_install_successed?></td>
                                                        <td>$<?= number_format($total_revenue, 2)?></td>                                                        
                                                    </tr>
                                                
                                                    </tbody>
                                                </table>                                                      
                                                  
                                                <script>       /*
                                                            <?=$str_gen?>
                                                            <?= $str_max?>
                                                            var time_arr = ["midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                                                                        "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ];
                                                               var line3 = new Array(10);
                                                              for (var i = 0; i < 24; i++) {
                                                                line3[i] = new Array(2);
                                                                line3[i][0] = time_arr[i];
                                                                line3[i][1] = revenue[i];
                                                              }
                                                                
 
                                                                var plot3 = $.jqplot('chart_sort_div_8', [line3], {
                                                              series:[],
                                                              axesDefaults: {
                                                                tickRenderer: $.jqplot.CanvasAxisTickRenderer
                                                                },
                                                              axes: {
                                                                xaxis: {
                                                                  renderer: $.jqplot.CategoryAxisRenderer,                                                                  
                                                                  labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                                                                  tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                                                                  tickOptions: {
                                                                      angle: -30,
                                                                      fontFamily: 'Courier New',
                                                                      fontSize: '9pt'
                                                                  }
                                                                   
                                                                },
                                                                yaxis: {
                                                                    min: 0,
                                                                    autoscale: true,
                                                                    ticks: addDollarCommasToArray(numTicksForArray(max, 10)) ,
                                                                    tickOptions: {
                                                                        textColor: '#8d8d8d',
                                                                        fontFamily: 'Arial Narrow',
                                                                        fontSize: '10px',
                                                                        formatString:'%d'
                                                                    }
                                                                }
                                                              }
                                                            });    */
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
