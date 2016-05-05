<?
include 'z_header.php';
$newconn = mysqli_connect(SQLHOST, SQLUSER, SQLPASS, SQLDB);     

$topAmount = array();
$topName = array();
$endDate1 = 	new DateTime('2000-01-01');
$startDate1 = 	new DateTime('2000-01-01');
$endDate2 = 	new DateTime('2000-01-01');
$startDate2 = 	new DateTime('2000-01-01');
$endDate3 = 	new DateTime('2000-01-01');
$startDate3 = 	new DateTime('2000-01-01');
$endDate4 = 	new DateTime('2000-01-01');
$startDate4 =	new DateTime('2000-01-01');
$endDate5 = 	new DateTime('2000-01-01');
$startDate5 = 	new DateTime('2000-01-01');
$endDate6 = 	new DateTime('2000-01-01');
$startDate6 = 	new DateTime('2000-01-01');
$endDate7 = 	new DateTime('2000-01-01');
$startDate7 = 	new DateTime('2000-01-01');
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
	function  getPCSV(startdate, enddate, searchString, timezone) 
	{
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchString="	+ searchString;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=publisher";
		window.open(reportspecs, '_blank');

	  }
	  
	function  getRCSV(startdate, enddate, searchString, timezone) 
	{
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchString="	+ searchString;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=refferes";
		window.open(reportspecs, '_blank');

	  }
	 function  getCCSV(startdate, enddate, searchString, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchString="	+ searchString;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=campaign";
		window.open(reportspecs, '_blank');

	  }
	  
	 function  getSubCSV(startdate, enddate, subid1, subid2, subid3, subid4, subid5, proj_name, country, timezone) 
	 {
         
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&subid1_5="	    + subid1;
        reportspecs = reportspecs + "&subid2_5="        + subid2;
        reportspecs = reportspecs + "&subid3_5="        + subid3;
        reportspecs = reportspecs + "&subid4_5="        + subid4;
        reportspecs = reportspecs + "&subid5_5="        + subid5;
        reportspecs = reportspecs + "&proj_name_5="     + proj_name;
        reportspecs = reportspecs + "&country_5="     + country;   
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=subid";
        //alert(reportspecs);
		window.open(reportspecs, '_blank');
        //window.open(reportspecs);

	  }  
	 function  getGeoCSV(startdate, enddate, adv, offer, pub, camp, subid, country, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&adv_6="	+ adv;
        reportspecs = reportspecs + "&offer_6="    + offer;
        reportspecs = reportspecs + "&pub_6="    + pub;
        reportspecs = reportspecs + "&camp_6="    + camp;
        reportspecs = reportspecs + "&subid_6="    + subid;
        reportspecs = reportspecs + "&country_6="    + country;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=geo";
		window.open(reportspecs, '_blank');

	  }
	 function  getTempCSV(startdate, enddate, searchString, searchCampaign,timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchCampaign="	+ searchCampaign;
		reportspecs = reportspecs + "&searchString="	+ searchString;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=temp";
		window.open(reportspecs, '_blank');

	  }
     function  getDailyBreakdownCSV(startdate, enddate, searchAdv, searchPub, searchCampaighn , searchSubid, searchCountry , searchTemplate, searchBundle, searchOffer, timezone) 
     {
        reportspecs = "report_data.php?startDate="        + startdate;
        reportspecs = reportspecs + "&endDate="            + enddate;
        reportspecs = reportspecs + "&searchAdv="        + searchAdv;
        reportspecs = reportspecs + "&searchPub="        + searchPub;
        reportspecs = reportspecs + "&searchCampaighn="    + searchCampaighn;
        reportspecs = reportspecs + "&searchSubid="        + searchSubid;
        reportspecs = reportspecs + "&searchCountry="    + searchCountry;
        reportspecs = reportspecs + "&searchTemplate="        + searchTemplate;
        reportspecs = reportspecs + "&searchBundle="        + searchBundle;
        reportspecs = reportspecs + "&searchOffer="        + searchOffer;
        reportspecs = reportspecs + "&timezone="    + timezone;
        reportspecs = reportspecs + "&type=daily";
        
        window.open(reportspecs, '_blank');

      } 
	 function  getDayCSV(startdate, enddate, searchAdv, searchPub, searchCampaighn , searchSubid, searchCountry , searchOffer, timezone) 
	 {
		reportspecs = "report_data.php?startDate="		+ startdate;
		reportspecs = reportspecs + "&endDate="			+ enddate;
		reportspecs = reportspecs + "&searchAdv="		+ searchAdv;
		reportspecs = reportspecs + "&searchPub="		+ searchPub;
		reportspecs = reportspecs + "&searchCampaighn="	+ searchCampaighn;
		reportspecs = reportspecs + "&searchSubid="		+ searchSubid;
		reportspecs = reportspecs + "&searchCountry="	+ searchCountry;
		reportspecs = reportspecs + "&searchOffer="		+ searchOffer;
        reportspecs = reportspecs + "&timezone="    + timezone;
		reportspecs = reportspecs + "&type=day";
        
		window.open(reportspecs, '_blank');

	  }
      function  getOfferBundleCSV(startdate, enddate, bundle, offer, timezone) 
     {
        reportspecs = "report_data.php?startDate="        + startdate;
        reportspecs = reportspecs + "&endDate="            + enddate;
        reportspecs = reportspecs + "&bundle="        + bundle;
        reportspecs = reportspecs + "&offer="        + offer;
        reportspecs = reportspecs + "&timezone="    + timezone;
        reportspecs = reportspecs + "&type=offerbundle";
        
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
                                    <li <? if ($_REQUEST[tab] == '10') { ?>class="active"<? } ?>><a href="#portlet_tab10" data-toggle="tab" >Offer Bundle</a></li>
                                    <li <? if ($_REQUEST[tab] == '9') { ?>class="active"<? } ?>><a href="#portlet_tab9" data-toggle="tab" >Daily Breakdowns</a></li>
                                    <li <? if ($_REQUEST[tab] == '8') { ?>class="active"<? } ?>><a href="#portlet_tab8" data-toggle="tab" >Day Parting</a></li>
                                    <li <? if ($_REQUEST[tab] == '7') { ?>class="active"<? } ?>><a href="#portlet_tab7" data-toggle="tab" >Template</a></li>
                                    <li <? if ($_REQUEST[tab] == '6') { ?>class="active"<? } ?>><a href="#portlet_tab6" data-toggle="tab" >Geo</a></li>
                                    <li <? if ($_REQUEST[tab] == '5') { ?>class="active"<? } ?>><a href="#portlet_tab5" data-toggle="tab" >SubID</a></li>
                                    <li <? if ($_REQUEST[tab] == '4') { ?>class="active"<? } ?>><a href="#portlet_tab4" data-toggle="tab" >Campaigns</a></li>
                                    <li <? if ($_REQUEST[tab] == '3') { ?>class="active"<? } ?>><a href="#portlet_tab3" data-toggle="tab" >Referrers</a></li>
                                    <li <? if ($_REQUEST[tab] == '2') { ?>class="active"<? } ?>><a href="#portlet_tab2" data-toggle="tab" >Publishers</a></li>
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
														    $('#form-date-range1-startdate').val(), 
                                                            $('#form-date-range1-enddate').val(), 
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
                                                 
                                       
                                       
                                       
                                            
<!--================================================================= -->
<link rel="stylesheet" href="../common/assets/treetable/screen.css" media="screen">
<link rel="stylesheet" href="../common/assets/treetable/jquery.treetable.css">
<link rel="stylesheet" href="../common/assets/treetable/jquery.treetable.theme.default.css">
<script async="" src="../common/assets/treetable/analytics.js"></script>

<script src="../common/assets/treetable/jquery.ui.core.js"></script>
<script src="../common/assets/treetable/jquery.ui.widget.js"></script>
<script src="../common/assets/treetable/jquery.ui.mouse.js"></script>
<script src="../common/assets/treetable/jquery.ui.draggable.js"></script>
<script src="../common/assets/treetable/jquery.ui.droppable.js"></script>
<script src="../common/assets/treetable/jquery.treetable.js"></script> 
<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-184215-9', 'cubicphuse.nl');
      ga('send', 'pageview');    
</script>
    
<div id="advertiser_treetable">
      
      <table id="example-basic" class="treetable">
        <caption>        
          <a href="#" onclick="jQuery(&#39;#example-basic&#39;).treetable(&#39;expandAll&#39;); return false;">Expand all</a>
          <a href="#" onclick="jQuery(&#39;#example-basic&#39;).treetable(&#39;collapseAll&#39;); return false;">Collapse all</a>        
        </caption>
        <thead>
            <th>AID</th>
            <th>Advertiser Manager</th>
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
            <th>Network Revenue</th>
        </thead>
        <tbody>
        <?
                                                        
                             $tmp_id = (int)$_REQUEST[search_string_1];
                            $campign = $_REQUEST[campaign_list_1];
                            $cat = $_REQUEST[cat_list_1];

                            
$sql = "
SELECT  u1.id as user_id, u1.subid, CONCAT(u1.user_first_name, ' ', u1.user_last_name) as user_name, 
        u2.id as manager_id, CONCAT(u2.user_first_name, ' ', u2.user_last_name) as manager_name, o.id as offer_id, o.offer_name, 
        ct.cat_id, ct.name as cat_name, cr.offer_shown, cr.install_accepted, cr.install_started, cr.install_completed, cr.adjust_install, 
        cr.price as total, cr.am_commission, cr.network_revenue 
FROM 
        offers o
";
if ($campign!=-1) 
    $sql .= "INNER JOIN";
else
    $sql .= "LEFT JOIN";
 
$sql .= "
        (
        SELECT  offer_id, sum(offer_shown) as offer_shown, sum(install_accepted) as install_accepted, sum(install_started) as install_started, 
                sum(install_completed) as install_completed ,sum(install_completed*adjust_rate/100) as adjust_install, 
                sum(install_completed*price*adjust_rate/100) as price, sum(install_completed*price*adjust_rate/100*am_revenue) as am_commission, 
                sum(install_completed*price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue
        FROM install_offers 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
        ";
        if ($campign!=-1) $sql .= "AND proj_id={$campign}";
        $sql .= "
        GROUP BY offer_id
        ) cr 
ON o.id=cr.offer_id
LEFT JOIN users u1 ON o.assigned_user_id=u1.id 
LEFT JOIN users u2 ON u1.user_manager=u2.id 
LEFT JOIN 
        (SELECT oc.offer_id, cat.name, cat.id as cat_id FROM offer_categories oc LEFT JOIN categories cat ON oc.category_id=cat.id WHERE oc.isgroup=0) ct 
ON o.id=ct.offer_id
WHERE 
cr.offer_shown>0 AND
(   
    o.offer_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_first_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.user_last_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u2.user_first_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u2.user_last_name LIKE '%{$_REQUEST[search_string_1]}%' OR
    u1.subid = {$tmp_id}
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
                                                        
                                                        $i = 0;
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
          <tr data-tt-id="<?= $i ?>" class="branch collapsed">
            <td><span class="indenter" style="padding-left: 0px;"></span><div class="success"></div><a href="adv_edit.php?id=<?=$row[user_id] ?>"><?= $row[subid] ?></a></td>
            <td> <a href="adv_edit.php?id=<?= $row[manager_id] ?>"><?echo($row[manager_name]);?></a></td>
            <td> <a href="adv_edit.php?id=<?= $row[user_id] ?>"><?echo($row[user_name]);?></a></td>
            <td> <a href="category_edit.php?id=<?=$row[cat_id] ?>"><?=$row[cat_name] ?></a></td>
            <td><a href="offer_edit.php?oid=<?= $row[offer_id] ?>"><?= $row[offer_name]?></a></td>                                                                
            <td><?= $row[offer_shown] ?></td>
            <td><?= $row[install_accepted] ?></td>
            <td><?= $row[install_started] ?></td>
            <td><?= $row[install_completed] ?></td>
            <td><?= (int)$row[adjust_install] ?></td>
            <td>$<?= number_format($row[total],2) ?></td>
            <td>$<?= number_format($row[am_commission],2) ?></td>
            <td>$<?= number_format($row[network_revenue],2) ?></td>
          </tr>
          <? 
            $offer_id = $row[offer_id];
            $sql1 = "
                    SELECT cr.*, l.country
                    FROM
                    (
                        SELECT  country_id, sum(offer_shown) as offer_shown, sum(install_accepted) as install_accepted, sum(install_started) as install_started, 
                                sum(install_completed) as install_completed ,sum(install_completed*adjust_rate/100) as adjust_install, 
                                sum(install_completed*price*adjust_rate/100) as total, sum(install_completed*price*adjust_rate/100*am_revenue) as am_commission, 
                                sum(install_completed*price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue
                        FROM install_offers 
                        WHERE   offer_id = {$offer_id} AND
                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range1-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range1-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                        ";
                        if ($campign!=-1) $sql .= "AND proj_id={$campign}";
                        $sql1 .= "
                        GROUP BY offer_id, country_id
                    ) cr
                    LEFT JOIN geo_location l ON l.id=cr.country_id
            ";
            //echo("<textarea>" . $sql1 . "</textarea>"); if($i>5) exit;
            $q1 = mysqli_query($newconn, $sql1);
            $j = 0;
            while($row1=mysqli_fetch_assoc($q1))
            {
                $country = $row1[country];
                if($country == NULL) $country = "Other";
          ?>
          <tr data-tt-id="<?=$i ?>.<?=$j ?>" data-tt-parent-id="<?=$i ?>" class="branch" style="display: none;">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?=$country ?></td>
            <td><?= $row1[offer_shown] ?></td>
            <td><?= $row1[install_accepted] ?></td>
            <td><?= $row1[install_started] ?></td>
            <td><?= $row1[install_completed] ?></td>
            <td><?= (int)$row1[adjust_install] ?></td>
            <td>$<?= number_format($row1[total],2) ?></td>
            <td>$<?= number_format($row1[am_commission],2) ?></td>
            <td>$<?= number_format($row1[network_revenue],2) ?></td>
          </tr>
          
        <?
                $j++;
            }                                                  
        $i++;
    } 
    ?> 

        </tbody>
      </table>
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
                                                            <th>Network Revenue</th>
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
                                                            <td>$<?= number_format($total_network,2)?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
    </div>

    <script>
      $("#example-basic").treetable({ expandable: true }); 
    </script>
    
    <!---------------------------------------------------------------->                                       
                                       
                                       
                                       
                                       
                                       
                                       
                                       
                                                
                                            </div>
                                        <? } ?>
                                    </div>



                                    <div class="tab-pane <? if ($_REQUEST[tab] == '2') { ?>active<? } ?>" id="portlet_tab2">
                                        <div class="widget-body form span6" >
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_2" method="POST">
                                                <input type="hidden" name="tab" value="2"/>
                                                <input id = "type2" type="hidden" name="type" value="html"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range2-startdate" id="form-date-range2-startdate" value="<?= $_REQUEST['form-date-range2-startdate']?>">
                                                <input type="hidden" name="form-date-range2-enddate" id="form-date-range2-enddate" value="<?= $_REQUEST['form-date-range2-enddate']?>">
                                                <input type="hidden" id="timezone_2" name="timezone" value="12"/>
                                                <div class="control-group">                                                    
													
													<? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range2-startdate'])) == 0)
                                                        {
                                                            $endDate2 = new DateTime();
                                                            $startDate2  = new DateTime();
                                                            
                                                            $startDate2->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range2-enddate'] = $endDate2->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range2-startdate'] = $startDate2->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range2-startdate'])) > 0)
                                                        {
                                                            $endDate2 = new DateTime($_REQUEST['form-date-range2-enddate']); 
                                                            $startDate2  = new DateTime($_REQUEST['form-date-range2-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate2     = "<?php echo $startDate2->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate2     = "<?php echo $endDate2->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range2" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate2->format('F j, Y')." - ".$endDate2->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label class="control-label" for="input3">Search String:</label>
                                                    <div class="controls">
                                                        <input type="text" id="search_string_2" name="search_string_2" value="<?= $_REQUEST[search_string_2] ?>" class="span12"/>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
												
														$('#type2').value = 'html'; 
                                                        timezone = $('#timezone_list').val();
                                                        $('#timezone_2').val(timezone);
                                                        $('#form_2').submit();
                                                        return false;"><i class="icon-check"></i> Generate Report</a>
                                                   <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
													$('#type2').value = 'csv';
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_2').val(timezone);
													getPCSV(
													    $('#form-date-range2-startdate').val(), 
                                                        $('#form-date-range2-enddate').val(), 
														$('#search_string_2').val(), 														
                                                        timezone);	
                                                        ">Save as CSV</a>         
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_2" ></div>
                                        </div>



                                        <? if (($_REQUEST[tab] == '2') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_2">
                                                    <thead>
                                                        <tr>
                                                            <th>PublisherID</th>
                                                            <th>Publisher Manager</th>
                                                            <th>Publisher</th>
                                                            <th>Clicks</th>  
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th> 
                                                            <th>Install Started</th>  
                                                            <th>Install Completed</th>  
                                                            <th>Publisher Revenue</th>
                                                            <th>PM Commission</th>
                                                            <th>Network Revenue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;
							$tmp_id = (int)$_REQUEST[search_string_2];
                            
                            $sql = "
                                SELECT     
                                    user_inf.subid,
                                    user_inf.user_id,
                                    user_inf.user_name,
                                    user_inf.manager_id,
                                    user_inf.manager_name,
                                    sum(proj_click.clicks) AS clicks,
                                    sum(proj_state.open_session) AS open_session, 
                                    sum(proj_state.install_accepted) AS install_accepted, 
                                    sum(proj_state.install_started) AS install_started, 
                                    sum(proj_state.install_completed) AS install_completed,
                                    sum(proj_revenue.pub_revenue) AS pub_revenue,
                                    sum(proj_revenue.pm_revenue) AS pm_revenue,
                                    sum(proj_revenue.net_revenue) AS net_revenue            
                                FROM
                                    ( 
                                        SELECT 
                                            u1.subid,
                                            u1.id AS user_id,
                                            u1.user_manager AS manager_id,
                                            CONCAT(u1.user_first_name, ' ', u1.user_last_name) AS user_name, 
                                            CONCAT(u2.user_first_name, ' ', u2.user_last_name) AS manager_name,
                                            u1.user_status                
                                        FROM users u1
                                        LEFT JOIN users u2 ON u1.user_manager = u2.id                
                                    ) user_inf
                                    LEFT JOIN projects ON user_inf.user_id = projects.assigned_user_id
                                    LEFT JOIN 
                                        (
                                            SELECT 
                                                proj_id, count(id) AS clicks
                                            FROM
                                                projects_downloads
                                            WHERE
                                                download_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY
                                                proj_id
                                        ) proj_click
                                    ON projects.id = proj_click.proj_id
                                    LEFT JOIN     
                                        (
                                            SELECT 
                                                proj_id, 
                                                sum(open_session) AS open_session, 
                                                sum(install_accepted) AS install_accepted, 
                                                sum(install_started) AS install_started, 
                                                sum(install_completed) AS install_completed
                                            FROM 
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY 
                                                proj_id
                                        ) proj_state
                                    ON projects.id = proj_state.proj_id
                                    LEFT JOIN
                                        (
                                            
                                            SELECT
                                                io.proj_id,
                                                sum(io.price*io.adjust_rate/100) AS total,
                                                sum(io.price*io.adjust_rate/100*io.pub_revenue/100) AS pub_revenue,
                                                sum(io.price*io.adjust_rate/100*io.pm_revenue/100) AS pm_revenue,
                                                sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                            FROM 
                                                (    
                                                    SELECT 
                                                        *
                                                    FROM 
                                                        install_offers
                                                    WHERE
                                                        install_completed = 1 AND
                                                        install_datetime >= DATE_SUB('{$_REQUEST['form-date-range2-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range2-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                                ) io
                                            GROUP BY io.proj_id
                                        ) proj_revenue
                                    ON projects.id = proj_revenue.proj_id
                                WHERE
                                    user_inf.user_status = 3 AND
                                    (
                                        user_inf.user_name LIKE '%{$_REQUEST[search_string_2]}%' OR 
                                        user_inf.manager_name LIKE '%{$_REQUEST[search_string_2]}%' OR                                                 
                                        user_inf.subid = {$tmp_id}
                                    )                                        
                                GROUP BY user_id ORDER BY net_revenue DESC";                                
                                          
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
                                           
                                                        $q = mysqli_query($newconn,$sql);
    
                                                        
                                                        $total_clicks = 0;
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        $total_PM = 0;
                                                        $total_network = 0;
                                                        $rowcount = 0;
                                                        while ($row = mysqli_fetch_assoc($q)) { 
                                                            if($row[pub_revenue]==NULL) $row[pub_revenue] = 0;
                                                            
                                                            $total_clicks += $row[clicks];
                                                            $total_open_sessions += $row[open_session];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[pub_revenue];
                                                            $total_PM += $row[pm_revenue];
                                                            $total_network += $row[net_revenue];
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[subid] ?></td>
                                                                <td><?
                                                                    if ($row[manager_id] == '-1') {
                                                                        echo('Not yet assigned');
                                                                    } else {
                                                                        echo('<a href="adv_edit.php?id=' . $row[manager_id] . '">' . $row[manager_name] . ' </a>');
                                                                    }
                                                                    ?></td>
                                                                <td><a href="pub_edit.php?id=<?= $row[user_id] ?>"><?= $row[user_name] ?></a></td>
                                                                <td><? if($row[clicks]==NULL) $row[clicks] = 0; echo($row[clicks]);?></td>
                                                                <td><? if($row[open_session]==NULL) $row[open_session] = 0; echo($row[open_session]);?></td>
                                                                <td><? if($row[install_accepted]==NULL) $row[install_accepted] = 0; echo($row[install_accepted]);?></td>
                                                                <td><? if($row[install_started]==NULL) $row[install_started] = 0; echo($row[install_started]);?></td>
                                                                <td><? if($row[install_completed]==NULL) $row[install_completed] = 0; echo($row[install_completed]);?></td>
                                                                <td>$<?= number_format($row[pub_revenue], 2, ".", ",") ?></td>
                                                                <td>$<?= number_format($row[pm_revenue], 2,".",",") ?></td>
                                                                <td>$<?= number_format($row[net_revenue], 2,".",",") ?></td>
                                                            </tr>
                                                            <?  
                                                            
                                                            $i++;
                                                            if ($rowcount < 5)
                                                            {
                                                                array_push($topName,$row[user_name]);
                                                                array_push($topAmount,$row[net_revenue]);                                                                
                                                            }
                                                            $rowcount ++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>                                                        
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 800px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <th>Publisher Revenue</th>
                                                            <th>PM Commission</th>
                                                            <th>Network Revenue</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td><?= $total_clicks?></td>
                                                            <td><?= $total_open_sessions?></td>
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_started?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <td>$<?= number_format($total_revenue, 2, ".", ",")?></td>
                                                            <td>$<?= number_format($total_PM, 2, ".", ",")?></td>
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
    var plot1 = $.jqplot('chart_sort_div_2', [s1], {
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            
        },
        /*
        legend: {
            show: true,
            placement: 'outsideGrid'
        },*/
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



                                    <div class="tab-pane <? if ($_REQUEST[tab] == '3') { ?>active<? } ?>" id="portlet_tab3">
                                        <div class="widget-body form span6" >
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_3" method="POST">
                                                <input type="hidden" name="tab" value="3"/>
                                                <input id = "type3" type="hidden" name="type" value="html"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range3-startdate" id="form-date-range3-startdate" value="<?= $_REQUEST['form-date-range3-startdate']?>">
                                                <input type="hidden" name="form-date-range3-enddate" id="form-date-range3-enddate" value="<?= $_REQUEST['form-date-range3-enddate']?>">
                                                <input type="hidden" id="timezone_3" name="timezone" value="12"/> 
                                                 <div class="control-group">
													 <? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range3-startdate'])) == 0)
                                                        {
                                                            $endDate3 = new DateTime();
                                                            $startDate3  = new DateTime();
                                                            
                                                            $startDate3->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range3-enddate'] = $endDate3->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range3-startdate'] = $startDate3->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range3-startdate'])) > 0)
                                                        {
                                                            $endDate3 = new DateTime($_REQUEST['form-date-range3-enddate']); 
                                                            $startDate3  = new DateTime($_REQUEST['form-date-range3-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate3     = "<?php echo $startDate3->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate3     = "<?php echo $endDate3->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range3" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate3->format('F j, Y')." - ".$endDate3->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="control-group">
                                                    <label class="control-label" for="input3">Search String:</label>
                                                    <div class="controls">
                                                        <input type="text" id="search_string_3" name="search_string_3" value="<?= $_REQUEST[search_string_3] ?>" class="span12"/>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_3').val(timezone);
                                                            $('#form_3').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                            
                                                    <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_3').val(timezone);
													$('#type2').value = 'csv';
													getRCSV(
													    $('#form-date-range3-startdate').val(), 
                                                        $('#form-date-range3-enddate').val(), 
														$('#search_string_3').val(), 
														timezone);	
                                                        ">Save as CSV</a>
                                                            
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form span6">
                                        </div>



                                        <? if (($_REQUEST[tab] == '3') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_3">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Publisher</th>
                                                            <th>App Name</th>
                                                            <th>Referrer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;
                                                        
							$sql = "                                    
                                    SELECT
                                        pd.proj_id,
                                        pd.download_datetime,
                                        projects.id,
                                        projects.proj_name,
                                        pd.refer_url_id,
                                        refer_url.refer_url,
                                        users.id AS publisher_id,
                                        CONCAT(users.user_first_name, ' ', users.user_last_name) AS publisher_name
                                    FROM
                                        (
                                            SELECT proj_id, download_datetime, refer_url_id 
                                            FROM projects_downloads 
                                            WHERE   projects_downloads.download_datetime >=DATE_SUB('{$_REQUEST['form-date-range3-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                    projects_downloads.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range3-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY proj_id, refer_url_id
                                        ) pd
                                        LEFT JOIN projects ON pd.proj_id = projects.id
                                        LEFT JOIN refer_url ON pd.refer_url_id = refer_url.id
                                        LEFT JOIN users ON projects.assigned_user_id = users.id
                                    WHERE
                                        projects.proj_name IS NOT NULL AND
                                        ( 
                                            projects.proj_name LIKE '%{$_REQUEST[search_string_3]}%' OR 
                                            refer_url.refer_url LIKE '%{$_REQUEST[search_string_3]}%' OR
                                            users.user_first_name LIKE '%{$_REQUEST[search_string_3]}%' OR
                                            users.user_last_name LIKE '%{$_REQUEST[search_string_3]}%' 
                                        )
                                    ORDER BY pd.download_datetime                                     
                                    ";

							//echo("<textarea> " . $sql . "</textarea>"); exit;
                                                        		             
							$q = mysqli_query($newconn,$sql);

                                                        while ($row = $q->fetch_assoc()) {
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[download_datetime] ?></td>
                                                                <td><a href="pub_edit.php?id=<?= $row[publisher_id] ?>"><?= $row[publisher_name] ?></a></td>
                                                                <td><a href="camp_edit.php?cid=<?= $row[proj_id] ?>"><?= $row[proj_name] ?></a></td>
                                                                <td><a href="<?= $row[refer_url] ?>"><?= $row[refer_url] ?></a></td>
                                                            </tr>
                                                            <?
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br><br>
                                            </div>
                                        <? } ?>
                                    </div>


   
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '4') { ?>active<? } ?>" id="portlet_tab4">
                                        <div class="widget-body form span6" >
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_4" method="POST">
                                                <input type="hidden" name="tab" value="4"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range4-startdate" id="form-date-range4-startdate" value="<?= $_REQUEST['form-date-range4-startdate']?>">
                                                <input type="hidden" name="form-date-range4-enddate" id="form-date-range4-enddate" value="<?= $_REQUEST['form-date-range4-enddate']?>">
                                                <input type="hidden" id="timezone_4" name="timezone" value="12"/>
                                                
												<div class="control-group">
													<? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range4-startdate'])) == 0)
                                                        {
                                                            $endDate4 = new DateTime();
                                                            $startDate4  = new DateTime();
                                                            
                                                            $startDate4->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range4-enddate'] = $endDate4->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range4-startdate'] = $startDate4->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range4-startdate'])) > 0)
                                                        {
                                                            $endDate4 = new DateTime($_REQUEST['form-date-range4-enddate']); 
                                                            $startDate4  = new DateTime($_REQUEST['form-date-range4-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate4     = "<?php echo $startDate4->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate4     = "<?php echo $endDate4->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range4" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate4->format('F j, Y')." - ".$endDate4->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
												
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label" for="input3">Search String:</label>
                                                    <div class="controls">
                                                        <input type="text" id="search_string_4" name="search_string_4" value="<?= $_REQUEST[search_string_4] ?>" class="span12"/>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
												
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_4').val(timezone);
                                                            $('#form_4').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                          
                                                    <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_4').val(timezone);
													$('#type2').value = 'csv';
													getCCSV(
													    $('#form-date-range4-startdate').val(), 
                                                        $('#form-date-range4-enddate').val(),  
														$('#search_string_4').val(), 
														timezone);	
                                                        ">Save as CSV</a> 
                                                            
                                                            
                                                            
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_4" ></div>
                                        </div>



                                        <? if (($_REQUEST[tab] == '4') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_4">
                                                    <thead>
                                                        <tr>
                                                            <th>CID</th>
                                                            <th>Manager</th>
                                                            <th>Publisher</th>
                                                            <th>Campaign</th>
                                                            <th>Clicks</th>           
                                                            <th>Open Sessions</th>                                                 
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

							$tmp_id = (int)$_REQUEST[search_string_4];
							$sql = "
                                SELECT 
                                    projects.id,
                                    projects.proj_name,
                                    proj_click.clicks,
                                    proj_state.open_session,
                                    proj_state.install_accepted,
                                    proj_state.install_started,
                                    proj_state.install_completed,
                                    proj_revenue.total,
                                    proj_revenue.net_revenue,
                                    user_inf.user_id,
                                    user_inf.user_name,
                                    user_inf.manager_id,    
                                    user_inf.manager_name
                                FROM
                                    projects
                                    LEFT JOIN 
                                        (
                                            SELECT 
                                                proj_id, count(id) AS clicks
                                            FROM
                                                projects_downloads
                                            WHERE
                                                download_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY
                                                proj_id
                                        ) proj_click
                                    ON projects.id = proj_click.proj_id
                                    LEFT JOIN
                                        (
                                            SELECT 
                                                proj_id, 
                                                sum(open_session) AS open_session, 
                                                sum(install_accepted) AS install_accepted, 
                                                sum(install_started) AS install_started, 
                                                sum(install_completed) AS install_completed
                                            FROM 
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                            GROUP BY 
                                                proj_id                        
                                        ) proj_state
                                    ON projects.id = proj_state.proj_id
                                    LEFT JOIN
                                        (
                                            
                                            SELECT
                                                io.proj_id,
                                                sum(io.price*io.adjust_rate/100) AS total,
                                                sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                            FROM 
                                                (    
                                                    SELECT 
                                                        *
                                                    FROM 
                                                        install_offers
                                                    WHERE
                                                        install_completed = 1 AND
                                                        install_datetime >= DATE_SUB('{$_REQUEST['form-date-range4-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                        install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range4-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                                ) io
                                            GROUP BY io.proj_id
                                        ) proj_revenue
                                    ON projects.id = proj_revenue.proj_id
                                    LEFT JOIN 
                                        ( 
                                            SELECT                 
                                                u1.id AS user_id,
                                                u1.user_manager AS manager_id,
                                                CONCAT(u1.user_first_name, ' ', u1.user_last_name) AS user_name, 
                                                CONCAT(u2.user_first_name, ' ', u2.user_last_name) AS manager_name                
                                            FROM users u1
                                            LEFT JOIN users u2 ON u1.user_manager = u2.id 
                                        ) user_inf
                                    ON projects.assigned_user_id = user_inf.user_id
                                WHERE
                                    (
                                            projects.proj_name LIKE '%{$_REQUEST[search_string_4]}%' OR
                                            user_inf.user_name LIKE '%{$_REQUEST[search_string_4]}%' OR                                            
                                            user_inf.manager_name LIKE '%{$_REQUEST[search_string_4]}%'
                                    )
                                ORDER BY total DESC
                                ";
                                
                                //echo("<textarea>" . $sql . "</textarea>"); exit;

                                                        $q = mysqli_query($newconn,$sql);
                                                        
                                                        $total_clicks = 0;
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        $total_network = 0;
                                                        
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            
                                                            $total_clicks += $row[clicks];
                                                            $total_open_sessions += $row[open_session];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                            $total_network += $row[net_revenue];
                                                            
                                                            
                                                            if ($rowcount < 5)
                                                            {
																array_push($topName,$row[proj_name]);
																array_push($topAmount,$row[total]);
															}
                                                            $rowcount ++;
                                                            
                                                            
                                                            ?>
                                                            <tr class="odd gradeX">                                                                
                                                                <td class="highlight"><div class="success"></div><?= $row[id] ?></td>
                                                                <td><?
                                                                    if ($row[manager_id] == '-1') {
                                                                        echo('Not yet assigned');
                                                                    } else {
                                                                        echo('<a href="adv_edit.php?id=' . $row[manager_id] . '">' . $row[manager_name] . ' </a>');
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo($row[user_name]);?></td>
                                                                <td><a href="camp_edit.php?cid=<?= $row[id] ?>"><?= $row[proj_name]?></a></td>
                                                                <td><?php if($row[clicks] == NULL) echo "0"; else echo $row[clicks]; ?></td>
                                                                <td><?php if($row[open_session] == NULL) echo "0"; else echo $row[open_session]; ?></td>
                                                                <td><?php if($row[install_accepted] == NULL) echo "0"; else echo $row[install_accepted]; ?></td>
                                                                <td><?php if($row[install_started] == NULL) echo "0"; else echo $row[install_started]; ?></td>
                                                                <td><?php if($row[install_completed] == NULL) echo "0"; else echo $row[install_completed];?></td>
                                                                <td>$<?= number_format($row[total], 2, ".", ",") ?></td>
                                                                <td>$<? if(($row[install_completed]==NULL)||($row[install_completed]==0)) echo("0.00");
                                                                        else echo(number_format($row[total]/$row[install_completed], 2, ".", ","));?></td>
                                                                <td>$<? if(($row[clicks]==NULL)||($row[clicks]==0)) echo("0.00");
                                                                        else echo(number_format($row[total]/$row[clicks], 2, ".", ","));?></td>
                                                                <td>$<?= number_format($row[net_revenue], 2, ".", ",") ?></td>
                                                                
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
                                                            <td><?= $total_install_started?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <td>$<?= number_format($total_revenue, 2, ".", ",")?></td>
                                                            <td>$<?= number_format($total_revenue / $total_install_successed, 2, ".", ",")?></td>
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
    var plot1 = $.jqplot('chart_sort_div_4', [s1], {
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            
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

                                   
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '5') { ?>active<? } ?>" id="portlet_tab5">
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
                                                
                                                <div class="control-group" style="margin-bottom: 5px;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;width:90px;">Country: </label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:129px;" id="country_5" name="country_5" value="<?= $_REQUEST[country_5] ?>" class=""/>
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
													    $('#form-date-range5-startdate').val(), 
                                                        $('#form-date-range5-enddate').val(), 
														$('#subid1_5').val(), 
                                                        $('#subid2_5').val(), 
                                                        $('#subid3_5').val(), 
                                                        $('#subid4_5').val(), 
                                                        $('#subid5_5').val(), 
                                                        $('#proj_name_5').val(), 
                                                        $('#country_5').val(),
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
                                            count(pd.id) as clicks, 
                                            pd.proj_id, 
                                            pd.subid_id 
                                        FROM 
                                            projects_downloads pd 
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id                                            
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST[country_5]}%'  AND
                                            pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)                                             
                                        GROUP BY proj_id, subid_id
                                    ) pd_click                                
                                LEFT JOIN projects p ON pd_click.proj_id = p.id
                                LEFT JOIN subid s ON pd_click.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%'
                                ";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";   
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
$q = mysqli_query($newconn,$sql);

$cc = 0;
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
    
    $cc++;
} 


if($cc>3000)
{
    //it will go csv download, because there are a lot of results (>3000)    
    unset($res_arr);    
}
else
{

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
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                                        INNER JOIN install_projects ip ON pd.id=ip.download_id
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST[country_5]}%' AND                                                                                
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)  
                                        GROUP BY proj_id, subid_id
                                    ) pdip
                                LEFT JOIN projects p ON pdip.proj_id = p.id
                                LEFT JOIN subid s ON pdip.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%'
                                ";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";
                                //echo("<textarea>" . $sql . "</textarea>"); exit;
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
                                        LEFT JOIN geo_location gl ON gl.id=pd.location_id
                                        INNER JOIN 
                                            ( SELECT * FROM install_offers WHERE install_completed=1) io ON pd.id = io.download_id 
                                        WHERE
                                            gl.country LIKE '%{$_REQUEST[country_5]}%' AND
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range5-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range5-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY pd.proj_id, pd.subid_id
                                    ) pdio 
                                LEFT JOIN projects p ON pdio.proj_id = p.id
                                LEFT JOIN subid s ON pdio.subid_id=s.id
                                WHERE 
                                     s.subid1 LIKE '%{$_REQUEST[subid1_5]}%' AND s.subid2 LIKE '%{$_REQUEST[subid2_5]}%' AND 
                                     s.subid3 LIKE '%{$_REQUEST[subid3_5]}%' AND s.subid4 LIKE '%{$_REQUEST[subid4_5]}%' AND 
                                     s.subid5 LIKE '%{$_REQUEST[subid5_5]}%'";
                            if($_REQUEST[proj_name_5] != "")
                                $sql .= " AND p.proj_name LIKE '%{$_REQUEST[proj_name_5]}%' ";
                                
                                $sql .= "ORDER BY pdio.total DESC";
                                
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
     

}                                           
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
                                                
                                                         <script type="text/javascript">

    			 
$(document).ready(function(){
	
	<?php 
        
        if($cc>3000)
        {
        echo 'alert("There are a lot of results, so it is difficult to load it on this page. Please download CSV");';
        /*
        $start_date = $_REQUEST['form-date-range5-startdate'];
        $end_date = $_REQUEST['form-date-range5-enddate'];
        $str = "  getSubCSV( '{$start_date}', '{$end_date}', '{$_REQUEST[subid1_5]}', '{$_REQUEST[subid2_5]}', '{$_REQUEST[subid3_5]}', '{$_REQUEST[subid4_5]}', '{$_REQUEST[subid5_5]}', '{$_REQUEST[proj_name_5]}', '{$_REQUEST[country_5]}', '{$_REQUEST[timezone]}');";

        //echo ("<textarea>" . $str . "</textarea>");
        echo($str); 
        */  
        }
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
                                                    <label class="control-label" for="input3" style="width: 90px;">Publisher:</label>
                                                    <div class="controls" style="margin-left: 100px;">
                                                        <input type="text" style="width:100px" id="pub_6" name="pub_6" value="<?= $_REQUEST[pub_6] ?>" class="span12"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 10px;">
                                                    <label class="control-label" for="input3" style="width: 90px; margin-right: 10px;">Campaign:</label>
                                                    <div class="controls">
                                                        <input type="text" style="width:100px" id="camp_6" name="camp_6" value="<?= $_REQUEST[camp_6] ?>" class="span12"/>
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
														$('#form-date-range6-startdate').val(), 
                                                        $('#form-date-range6-enddate').val(),   
														$('#adv_6').val(), 
                                                        $('#offer_6').val(), 
                                                        $('#pub_6').val(), 
                                                        $('#camp_6').val(), 
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
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>
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
                                                        
$arr_res_tmp = array();

$adv = $_REQUEST[adv_6];
$offer = $_REQUEST[offer_6];
$pub = $_REQUEST[pub_6];
$camp = $_REQUEST[camp_6];
$subid = $_REQUEST[subid_6];
$country = $_REQUEST[country_6];

if(($adv != "")||($offer != ""))
{
    $sql = "

            SELECT  sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, sum(io.install_completed) as install_completed, 
                    sum(io.install_completed*io.price*io.adjust_rate/100) as total,             
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
                    o.offer_name LIKE '%{$offer}%' 
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
}
else
{
    $sql = "
            SELECT count(pd.id) as clicks, l.country 
            FROM 
            (
                SELECT id, location_id, proj_id, subid_id FROM projects_downloads 
                WHERE   download_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                        download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
            ) pd 
            LEFT JOIN  geo_location l ON pd.location_id=l.id
            LEFT JOIN projects p ON p.id=pd.proj_id
            LEFT JOIN users u ON p.assigned_user_id=u.id        
            LEFT JOIN subid s ON s.id=pd.subid_id
            WHERE   l.country LIKE '%{$country}%' AND p.proj_name LIKE '%{$camp}%' AND
                    (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
                    s.subid_all LIKE '%{$subid}%' 
            GROUP BY l.country
        
        ";
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][clicks] = $row[clicks];
        $arr_res_tmp[$row[country]][country] = $row[country];
    }    

    $sql = "
    SELECT 
        pd.location_id,
        l.country, 
        sum(ip.open_session) as open_sessions, 
        sum(ip.install_accepted) as install_accepted, 
        sum(ip.install_started) as install_started, 
        sum(ip.install_completed) as install_completed 
    FROM 
    (
        SELECT proj_id, download_id, open_session, install_accepted, install_started, install_completed 
        FROM install_projects 
        WHERE   install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
    ) ip
    LEFT JOIN projects_downloads pd ON pd.id=ip.download_id 
    LEFT JOIN geo_location l ON pd.location_id=l.id
    LEFT JOIN projects p ON p.id=ip.proj_id
    LEFT JOIN users u ON p.assigned_user_id=u.id        
    LEFT JOIN subid s ON s.id=pd.subid_id  
    WHERE   l.country LIKE '%{$country}%' AND p.proj_name LIKE '%{$camp}%' AND
            (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
            s.subid_all LIKE '%{$subid}%'
    GROUP BY l.country
        ";   
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][open_sessions] = $row[open_sessions];
        $arr_res_tmp[$row[country]][install_accepted] = $row[install_accepted];
        $arr_res_tmp[$row[country]][install_started] = $row[install_started];
        $arr_res_tmp[$row[country]][install_completed] = $row[install_completed];
        $arr_res_tmp[$row[country]][country] = $row[country];
    }                                 

    $sql = "
    SELECT 
        pd.location_id, 
        l.country, 
        sum(io.revenue) as total, 
        sum(io.net_revenue) as network_revenue
    FROM 
    (
        SELECT download_id, proj_id, (price*adjust_rate/100) as revenue, (price*adjust_rate/100*(100-am_revenue-pub_revenue-pm_revenue)/100) as net_revenue 
        FROM install_offers 
        WHERE   install_completed=1 AND
                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range6-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range6-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY)
    ) io 
    LEFT JOIN projects_downloads pd ON io.download_id=pd.id  
    LEFT JOIN geo_location l ON pd.location_id=l.id
    LEFT JOIN projects p ON p.id=io.proj_id
    LEFT JOIN users u ON p.assigned_user_id=u.id        
    LEFT JOIN subid s ON s.id=pd.subid_id  
    WHERE   l.country LIKE '%{$country}%' AND p.proj_name LIKE '%{$camp}%' AND
            (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
            s.subid_all LIKE '%{$subid}%'
    GROUP BY l.country
    ORDER BY sum(io.revenue) DESC
        ";
    //echo("<textarea>" . $sql . "</textarea>");exit;
    $rowcount = 0;
    $q = mysqli_query($newconn,$sql);
    while ($row = mysqli_fetch_assoc($q)) {
        if($row[country] == NULL)
        {
            $row[country] = "";
        }    
        $arr_res_tmp[$row[country]][total] = $row[total];
        $arr_res_tmp[$row[country]][network_revenue] = $row[network_revenue];     
        $arr_res_tmp[$row[country]][country] = $row[country];
        
        if ($rowcount < 5)
        {
            array_push($topName,$row[country]);
            array_push($topAmount,$row[total]);    
            $rowcount ++;
        }        
    }
}

						        // var_dump($sql); exit;

                                                        
                                                        
                                                        $total_clicks = 0;
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        $total_network = 0;
                                                        
                                                        foreach($arr_res_tmp as $row) {        //var_dump($row);exit;
                                                            if(($adv != "")||($offer != "")) 
                                                            {}
                                                            else
                                                            {
                                                                $total_clicks += $row[clicks];
                                                                $total_open_sessions += $row[open_sessions];
                                                            }
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                            $total_network += $row[network_revenue];
                                                            
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[country] ?></td>
                                                                <? if(($adv != "")||($offer != "")) {?>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <? } else { ?>
                                                                <td><? if($row[clicks] == NULL) echo "0"; else echo($row[clicks]);?></td>
                                                                <td><? if($row[open_sessions] == NULL) echo "0"; else echo($row[open_sessions]);?></td>
                                                                <? } ?>
                                                                <td><? if($row[install_accepted] == NULL) echo "0"; else echo($row[install_accepted]);?></td>
                                                                <td><? if($row[install_started] == NULL) echo "0"; else echo($row[install_started]);?></td>
                                                                <td><? if($row[install_completed] == NULL) echo "0"; else echo($row[install_completed]);?></td>
                                                                <td>$<?= number_format($row[total], 2, ".", ",") ?></td>
                                                                <td>$<?= number_format($row[total]/$row[install_completed], 2, ".", ",") ?></td>
                                                                <? if(($adv != "")||($offer != "")) {?>
                                                                <td>&nbsp;</td>
                                                                <? } else { ?>
                                                                <td><?= number_format($row[total]/$row[clicks], 2, ".", ",")?></td>
                                                                <? } ?>
                                                                <td><?= number_format($row[network_revenue], 2, ".", ",")?></td>
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
                                                        <? if(($adv != "")||($offer != "")) {?>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <? }else { ?>
                                                        <td><?= $total_clicks?></td>
                                                        <td><?= $total_open_sessions?></td> 
                                                        <? } ?>
                                                        <td><?= $total_install_accepted?></td> 
                                                        <td><?= $total_install_started?></td>
                                                        <td><?= $total_install_successed?></td>
                                                        <td>$<?= number_format($total_revenue, 2, ".", ",")?></td>
                                                        <td>$<?= number_format($total_revenue / $total_install_successed, 2, ".", ",")?></td>
                                                        <? if(($adv != "")||($offer != "")) {?>
                                                        <td>&nbsp;</td>
                                                        <? } else { ?>
                                                        <td>$<?= number_format($total_revenue / $total_clicks, 2, ".", ",")?></td>
                                                        <? } ?>
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
                                    
                                    
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '7') { ?>active<? } ?>" id="portlet_tab7">
                                        <div class="widget-body form span6" >
                                            
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_7" method="POST">
                                                <input type="hidden" name="tab" value="7"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range7-startdate" id="form-date-range7-startdate" value="<?= $_REQUEST['form-date-range7-startdate']?>">
                                                <input type="hidden" name="form-date-range7-enddate" id="form-date-range7-enddate" value="<?= $_REQUEST['form-date-range7-enddate']?>">
                                                <input type="hidden" id="timezone_7" name="timezone" value="12"/>
                                            <div class="control-group">
										            <? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range7-startdate'])) == 0)
                                                        {
                                                            $endDate7 = new DateTime();
                                                            $startDate7  = new DateTime();
                                                            
                                                            $startDate7->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range7-enddate'] = $endDate7->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range7-startdate'] = $startDate7->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range7-startdate'])) > 0)
                                                        {
                                                            $endDate7     = new DateTime($_REQUEST['form-date-range7-enddate']); 
                                                            $startDate7  = new DateTime($_REQUEST['form-date-range7-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate7     = "<?php echo $startDate7->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate7     = "<?php echo $endDate7->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls">
                                                        <div id="form-date-range7" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate7->format('F j, Y')." - ".$endDate7->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
												      <div class="control-group">
                                                    <label class="control-label" for="input3">Search String:</label>
                                                    <div class="controls">
                                                        <input type="text" id="search_string_7" name="search_string_7" value="<?= $_REQUEST[search_string_7] ?>" class="span12"/>
                                                    </div>
                                                </div>                                                
                                                <div class="control-group">
                                                    <label class="control-label" for="input3">Search Campign:</label>
                                                    <div class="controls">
                                                        <select class="span6 chosen" id="campign_list_7" name='campign_list_7' style="width: 150px;">
                                                            <option value="-1" selected>&nbsp;</option>                                                            
                                                            <?
                                                            $sql1 = "SELECT * FROM projects";
                                                            $q1 = mysqli_query($newconn, $sql1);
                                                            while ($row1 = mysqli_fetch_assoc($q1)) {
                                                                ?>
                                                                <option value="<?= $row1[id] ?>"><?= $row1[proj_name]?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_7').val(timezone);
                                                            $('#form_7').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                            
                                                    <a href="#" id = 'csv2' class="btn btn-success" name = "csv_download" onclick="
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_7').val(timezone);
													$('#type2').value = 'csv';
                                                    
                                                    strCampaign = $('#campign_list_7').val();
                                                    strCampaign = strCampaign.trim();
                                                    if (strCampaign.length == 0){strCampaign = -1;};
                                                                                                        
													getTempCSV(
													    $('#form-date-range7-startdate').val(), 
                                                        $('#form-date-range7-enddate').val(), 
														$('#search_string_7').val(),
														strCampaign,
														timezone);	
                                                        ">Save as CSV</a>         
                                                            
                                                            
                                                         
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form span6">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_7" ></div>
                                        </div>



                                        <? if (($_REQUEST[tab] == '7') && ($_REQUEST[mode] == 'generate')) { ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_1">
                                                    <thead>
                                                        <tr>
                                                            <th>Template</th>
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th> 
                                                            <th>Install Started</th>
                                                            <th>Install Successful</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>  
                                                            <th>RPOS</th>                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        $i = 0;  
  
							$tmp_id = (int)$_REQUEST[search_string_7];

							$campign = $_REQUEST[campign_list_7];
                            
                            $sql = "
                                    SELECT 
                                        t.id,
                                        t.name,
                                        template_state.open_sessions,
                                        template_state.install_accepted,
                                        template_state.install_started,
                                        template_state.install_completed,
                                        template_revenue.revenue,
                                        (template_revenue.revenue/template_state.install_completed) as rpi
                                    FROM 
                                        templates t
                                    LEFT JOIN
                                        (
                                            SELECT
                                                template_id,
                                                sum(open_session) AS open_sessions,
                                                sum(install_accepted) AS install_accepted,
                                                sum(install_started) AS install_started,
                                                sum(install_completed) AS install_completed
                                            FROM
                                                install_projects
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range7-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range7-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    ";
                            if($campign != -1) $sql .= " AND proj_id = {$campign}";
                            $sql .= "
                                            GROUP BY
                                                template_id
                                        ) template_state
                                    ON t.id = template_state.template_id
                                    LEFT JOIN
                                        (
                                            SELECT
                                                template_id,
                                                sum(price*adjust_rate/100 * install_completed) AS revenue
                                            FROM
                                                install_offers
                                            WHERE
                                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range7-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range7-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                     ";
                             if($campign != -1) $sql .= " AND proj_id = {$campign}";
                             $sql .= "
                                            GROUP BY
                                                template_id
                                        ) template_revenue
                                    ON t.id = template_revenue.template_id
                                    WHERE t.name LIKE '%{$_REQUEST[search_string_7]}%'
                                    ORDER by revenue DESC";
                            
							
                            //echo("<textarea>" . $sql . "</textarea>"); exit;
                                                        $q = mysqli_query($newconn,$sql);
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_revenue = 0;
                                                        $total_rpi = 0;
                                                        $rowcount = 0;
                                                        
                                                        while ($row = mysqli_fetch_assoc($q)) { 
                                                            $total_open_sessions += $row[open_sessions];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];                                                            
                                                            $total_revenue += $row[revenue];
                                                                     
                                                            if ($rowcount < 5)
                                                            {
																array_push($topName,$row[name]);
																array_push($topAmount,$row[revenue]);
																	
																
															}
                                                            $rowcount ++;
                                                                                                                       
                                                            ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $row[name] ?></td>                                                                
                                                                <td><? if($row[open_sessions] == NULL) echo "0"; else echo($row[open_sessions]);?></td>
                                                                <td><? if($row[install_accepted] == NULL) echo "0"; else echo($row[install_accepted]);?></td>
                                                                <td><? if($row[install_started] == NULL) echo "0"; else echo($row[install_started]);?></td>
                                                                <td><? if($row[install_completed] == NULL) echo "0"; else echo($row[install_completed]);?></td>
                                                                <td>$<?= number_format($row[revenue],2) ?></td>
                                                                <td>$<?= number_format($row[rpi],2) ?></td>   
                                                                <td>$<?= number_format($row[revenue]/$row[open_sessions],2)?></td>                                                             
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
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Successed</th>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>   
                                                            <th>RPOS</th>                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td><?= $total_open_sessions?></td>
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_started?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <td>$<?= number_format($total_revenue,2)?></td>
                                                            <td>$<?= number_format($total_revenue/$total_install_successed,2) ?></td>                                                            
                                                            <td>$<?= number_format($total_revenue/$total_open_sessions,2) ?></td>                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                      

                                                         <script> 
			 
$(document).ready(function(){
	
	<?php 
		echo " var s1 = [".$topAmount[0]." , ".$topAmount[1].", ".$topAmount[2].", ".$topAmount[3].",".$topAmount[4]."];";  
		echo " var ticks = ['".$topName[0]."' , '".$topName[1]."', '".$topName[2]."', '".$topName[3]."','".$topName[4]."'];"    
	?> 
    var plot1 = $.jqplot('chart_sort_div_7', [s1], {
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
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Publisher:</label>
                                                    <div class="controls">
                                                        <input type="text" id="publisher_8" name="publisher_8" value="<?= $_REQUEST[publisher_8] ?>" class=""/>
                                                    </div>
                                                </div>                                  
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Campign: </label>
                                                    <div class="controls">
                                                        <input type="text" id="campign_8" name="campign_8" value="<?= $_REQUEST[campign_8] ?>" class=""/>
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
													    $('#form-date-range8-startdate').val(), 
                                                        $('#form-date-range8-enddate').val(),  
														$('#advertiser_8').val(), 
														$('#publisher_8').val(), 
														$('#campign_8').val(), 
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
                                        $pub = $_REQUEST[publisher_8];
                                        $camp = $_REQUEST[campign_8];
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
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>   
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <? 
                                                                if(($adv != "")||($offer != "")) 
                                                                    echo("<th>Adjust Install</th>");
                                                            ?>
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                            <th>EPC</th>
                                                            <th>Network Revenue</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                    $i = 0;
                    
                    

                    if(($adv != "")||($offer != ""))
                    {
                        // if advertiser filter is used, then get offer install accepted, install started and install completed
                        $sql = "    
                            SELECT
                                install_datetime, hour(install_datetime) as hour,           
                                sum(install_accepted) as install_accepted,
                                sum(install_started) as install_started,
                                sum(install_completed) as install_completed,
                                sum(install_completed * install_offers.adjust_rate/100) as adjust_install,
                                sum(price * install_offers.adjust_rate/100 * install_completed) as revenue,
                                sum(price * install_offers.adjust_rate/100 * install_completed * (100-am_revenue-pub_revenue-pm_revenue)/100) as network_revenue
                            FROM 
                                install_offers
                            LEFT JOIN offers ON install_offers.offer_id = offers.id
                            LEFT JOIN users ON install_offers.user_id = users.id
                            WHERE
                                (users.user_first_name LIKE '%{$adv}%' OR users.user_last_name LIKE '%{$adv}%') AND 
                                offers.offer_name LIKE '%{$offer}%' AND 
                                install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                            GROUP BY hour(install_datetime)
                            ORDER BY install_datetime
                        ";
                        
                        // var_dump($sql);
                    }                    
                    else if($pub != "")
                    {
                        $sql = "
                            SELECT
                                pub_state.install_datetime,
                                pub_click.download_datetime, pub_click.hour, pub_click.clicks,
                                pub_state.open_session, pub_state.install_accepted, pub_state.install_started, pub_state.install_completed,
                                pub_revenue.revenue, pub_revenue.network_revenue
                            FROM
                                (
                                    SELECT 
                                        download_datetime,                                        
                                        hour(pd.download_datetime) AS hour,
                                        count(pd.id) AS clicks
                                    FROM 
                                        projects_downloads pd
                                    LEFT JOIN projects p ON pd.proj_id = p.id
                                    LEFT JOIN users u ON p.assigned_user_id = u.id
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
                                        pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(pd.download_datetime)
                                ) pub_click
                            LEFT JOIN
                                (
                                    SELECT 
                                        ip.install_datetime,
                                        hour(ip.install_datetime) AS hour,
                                        sum(ip.open_session) as open_session, 
                                        sum(ip.install_accepted) as install_accepted, 
                                        sum(ip.install_started) as install_started, 
                                        sum(ip.install_completed) as install_completed 
                                    FROM 
                                        install_projects ip
                                    LEFT JOIN projects p ON ip.proj_id = p.id 
                                    LEFT JOIN users u ON p.assigned_user_id = u.id 
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND
                                        ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(ip.install_datetime)        
                                ) pub_state ON pub_click.hour = pub_state.hour
                            LEFT JOIN 
                                (    
                                    SELECT 
                                        hour(io.install_datetime) AS hour, 
                                        sum(io.price * io.adjust_rate / 100) AS revenue, 
                                        sum(io.price * io.adjust_rate / 100 * (100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                    FROM 
                                        projects_downloads pd 
                                    INNER JOIN ( SELECT * FROM install_offers WHERE install_completed = 1 ) io ON pd.id = io.download_id 
                                    LEFT JOIN projects p ON pd.proj_id = p.id
                                    LEFT JOIN users u ON p.assigned_user_id = u.id
                                    WHERE
                                        (u.user_first_name LIKE '%{$pub}%' OR u.user_last_name LIKE '%{$pub}%') AND                                        
                                        io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                        io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                    GROUP BY hour(io.install_datetime)
                                ) pub_revenue 
                            ON pub_click.hour = pub_revenue.hour
                            ORDER BY pub_state.install_datetime
                            ";
                            
                            // var_dump($sql);
                    }
                    else //for campign, subid, country 
                    {
                            $sql = "
                                SELECT 
                                    click.download_datetime, click.hour, click.clicks,
                                    state.open_session, state.install_accepted, state.install_started, state.install_completed, 
                                    revenue.revenue, revenue.network_revenue 
                                FROM
                                    (
                                        SELECT 
                                            download_datetime,
                                            hour(pd.download_datetime) AS hour,
                                            count(pd.id) AS clicks 
                                        FROM 
                                            projects_downloads pd
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE";
                            if($camp!="")
                                $sql .= "   p.proj_name LIKE '%{$camp}%' AND ";
                                
                            $sql .= "       l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND 
                                            pd.download_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            pd.download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(pd.download_datetime)
                                    ) click
                                LEFT JOIN
                                    (
                                        SELECT 
                                            ip.install_datetime,
                                            hour(ip.install_datetime) AS hour, 
                                            sum(ip.open_session) as open_session, 
                                            sum(ip.install_accepted) as install_accepted, 
                                            sum(ip.install_started) as install_started, 
                                            sum(ip.install_completed) as install_completed 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN install_projects ip ON pd.id = ip.download_id 
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE";
                            if($camp!="")
                                $sql .= "   p.proj_name LIKE '%{$camp}%' AND ";
                            $sql .= "       l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND 
                                            ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(ip.install_datetime)
                                    ) state ON click.hour = state.hour
                                LEFT JOIN
                                    (
                                        SELECT 
                                            hour(io.install_datetime) AS hour, 
                                            sum(io.price * io.adjust_rate / 100) AS revenue, 
                                            sum(io.price * io.adjust_rate / 100 * (100-io.am_revenue-io.pub_revenue-io.pm_revenue)/100) as network_revenue 
                                        FROM 
                                            projects_downloads pd 
                                        INNER JOIN ( SELECT * FROM install_offers WHERE install_completed = 1 ) io ON pd.id = io.download_id 
                                        LEFT JOIN projects p ON pd.proj_id = p.id
                                        LEFT JOIN geo_location l ON pd.location_id = l.id
                                        LEFT JOIN subid s ON pd.subid_id = s.id
                                        WHERE";
                            if($camp!="")
                                $sql .= "   p.proj_name LIKE '%{$camp}%' AND ";
                            
                            $sql .= "       l.country LIKE '%{$country}%' AND s.subid_all LIKE '%{$subid}%' AND                                             
                                            io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range8-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range8-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) 
                                        GROUP BY hour(io.install_datetime)
                                    ) revenue 
                                ON click.hour = revenue.hour
                                ORDER BY click.download_datetime
                                ";
                                
                                 
                    }
                    //echo("<textarea>" . $sql . "</textarea>"); exit;                                
                                                        $q = mysqli_query($newconn, $sql);
                                                        
                                                        $total_clicks = 0;
                                                        $total_install_opensession = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_adjust_install = 0;
                                                        $total_revenue = 0;
                                                        $total_network = 0;
                                                        $rowcount = 0;
                                                        
                                                        $time_arr = array("midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                                                                        "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ) ;
                                                    
                                                        $pre_hour = 0;
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            
                                                            $hour = ($row[hour] + $diff_timezone) % 24;
                                                            if($hour<0) $hour = $hour + 24;
                                                            
                                                            if($row[open_session] == NULL) $row[open_session] = 0;
                                                            if($row[install_accepted] == NULL) $row[install_accepted] = 0;
                                                            if($row[install_started] == NULL) $row[install_started] = 0;
                                                            if($row[install_completed] == NULL) $row[install_completed] = 0;
                                                            
                                                            $total_clicks += $row[clicks];
                                                            $total_install_opensession += $row[open_session];
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_adjust_install += $row[adjust_install];
                                                            $total_revenue += $row[revenue];
                                                            $total_network += $row[network_revenue];                                                       
                                                            
                                                            $rowcount ++;
                                                            
                                                            //var_dump($pre_hour);var_dump($hour);
                                                            for($xx=$pre_hour;$xx<$hour;$xx++)
                                                            {
                                                                
                                                        ?>
                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $time_arr[$xx] ?></td>
                                                                <?php if(($adv!="")||($offer!="")) {?>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>     
                                                                <?php }else {?>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <?php } ?>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <?
                                                                    if(($adv != "")||($offer != ""))
                                                                    {
                                                                        echo("<td>0</td>");    
                                                                    }
                                                                ?>
                                                                <td>$0.00</td>
                                                                <td>$0.00</td>
                                                                <?php if($adv!="") {?>
                                                                    <td>&nbsp;</td>
                                                                <?php }else {?>
                                                                <td>$0.00</td>
                                                                <?php } ?>
                                                                <td>$0.00</td>                                                                
                                                            </tr>
                                                        <?    
                                                            }
                                                        ?>

                                                            <tr class="odd gradeX">
                                                                <td class="highlight"><div class="success"></div><?= $time_arr[$hour] ?></td>
                                                                <?php if(($adv!="")||($offer!="")) {?>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>     
                                                                <?php }else {?>
                                                                <td><?= $row[clicks] ?></td>
                                                                <td><?= $row[open_session] ?></td>
                                                                <?php } ?>
                                                                <td> <?= $row[install_accepted] ?></td>
                                                                <td> <?= $row[install_started] ?></td>
                                                                <td> <?= $row[install_completed] ?></td>
                                                                <?
                                                                    if(($adv != "")||($offer != ""))
                                                                    {
                                                                        echo("<td>");echo((int)$row[adjust_install]);echo("</td>");    
                                                                    }
                                                                ?>
                                                                <td>$<?= number_format($row[revenue],2) ?></td>
                                                                <td>$<?= number_format($row[revenue]/$row[install_completed],2) ?></td>
                                                                <?php if($adv!="") {?>
                                                                    <td>&nbsp;</td>
                                                                <?php }else {?>
                                                                <td>$<?= number_format($row[revenue]/$row[clicks],2)?></td>
                                                                <?php } ?>
                                                                <td>$<?= number_format($row[network_revenue],2) ?></td>                                                                
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
                                                                <?php if(($adv!="")||($offer!="")) {?>
                                                                    <td>&nbsp;</td>
                                                                    <td>&nbsp;</td>     
                                                                <?php }else {?>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <?php } ?>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <td> 0</td>
                                                                <?
                                                                    if(($adv != "")||($offer != ""))
                                                                    {
                                                                        echo("<td>0</td>");    
                                                                    }
                                                                ?>
                                                                <td>$0.00</td>
                                                                <td>$0.00</td>
                                                                <?php if($adv!="") {?>
                                                                    <td>&nbsp;</td>
                                                                <?php }else {?>
                                                                <td>$0.00</td>
                                                                <?php } ?>
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
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Successed</th>
                                                            <? 
                                                                if(($adv != "")||($offer != "")) 
                                                                    echo("<th>Adjust Installs</th>");
                                                            ?>
                                                            <th>Revenue</th>                                                            
                                                            <th>Network Revenue</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <?php if(($adv!="")||($offer!="")) {?>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>     
                                                            <?php }else {?>
                                                            <td><?= $total_clicks?></td>
                                                            <td><?= $total_install_opensession?></td> 
                                                            <?php } ?>
                                                                
                                                            
                                                            <td><?= $total_install_accepted?></td>
                                                            <td><?= $total_install_started ?></td>
                                                            <td><?= $total_install_successed?></td>
                                                            <? 
                                                                if(($adv != "")||($offer != ""))
                                                                { 
                                                                    echo("<td>");echo((int)$total_adjust_install);echo("</td>");    
                                                                }
                                                            ?>
                                                            <td>$<?= number_format($total_revenue,2)?></td>                                                            
                                                            <td>$<?= number_format($total_network,2)?></td>
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
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Publisher:</label>
                                                    <div class="controls">
                                                        <input type="text" id="publisher_9" name="publisher_9" value="<?= $_REQUEST[publisher_9] ?>" class=""/>
                                                    </div>
                                                </div>                                  
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Campign: </label>
                                                    <div class="controls">
                                                        <input type="text" id="campign_9" name="campign_9" value="<?= $_REQUEST[campign_9] ?>" class=""/>
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
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Template: </label>
                                                    <div class="controls">
                                                        <input type="text" id="template_9" name="template_9" value="<?= $_REQUEST[template_9] ?>" class=""/>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px;float:left;">
                                                    <label class="control-label" for="input3" style=" margin-right:10px;">Offer Bundle: </label>
                                                    <div class="controls">
                                                        <input type="text" id="bundle_9" name="bundle_9" value="<?= $_REQUEST[bundle_9] ?>" class=""/>
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
                                                        $('#form-date-range9-startdate').val(), 
                                                        $('#form-date-range9-enddate').val(),  
                                                        $('#advertiser_9').val(), 
                                                        $('#publisher_9').val(), 
                                                        $('#campign_9').val(), 
                                                        $('#subid_9').val(), 
                                                        $('#geo_9').val(), 
                                                        $('#template_9').val(),
                                                        $('#bundle_9').val(),
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
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>                                                            
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th> 
                                                            <?
                                                                if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                                {
                                                            ?>
                                                            <th>Adjust Install</th>
                                                            <?
                                                                }
                                                            ?>                                                           
                                                            <th>Revenue</th>
                                                            <th>RPI</th>
                                                            <th>EPC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                    $i = 0;
 
if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
{
    //advertiser or bundle
    $sql = "
        SELECT  DATE_FORMAT(io.install_datetime, '%Y-%m-%d') as date,
                sum(io.install_accepted) as install_accepted, sum(io.install_started) as install_started, 
                sum(install_completed) as install_completed, sum(io.install_completed * io.adjust_rate / 100) as adjust_install,
                sum(io.install_completed*io.price*io.adjust_rate/100) as total 
        FROM install_offers io        
        LEFT JOIN offers o ON io.offer_id=o.id
        LEFT JOIN users u ON o.assigned_user_id=u.id
        WHERE   
                io.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND                
                io.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[advertiser_9]}%' AND
                o.offer_name LIKE '%{$_REQUEST[offer_9]}%' 
        GROUP BY DATE_FORMAT(io.install_datetime, '%Y-%m-%d')
    ";    
}
else
{
    //for publisher, campaign, subid, geo, template
                             $sql = "
                                SELECT 
                                    proj_click.date,                                
                                    proj_click.clicks,
                                    proj_state.open_session,
                                    proj_state.install_accepted,
                                    proj_state.install_started,
                                    proj_state.install_completed,
                                    proj_revenue.total
                                FROM 
                                        (
                                            SELECT 
                                                DATE_FORMAT(DATE_ADD(pd.download_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date, count(pd.id) AS clicks
                                            FROM
                                                projects_downloads pd
                                            LEFT JOIN projects p ON pd.proj_id=p.id
                                            LEFT JOIN users u ON p.assigned_user_id=u.id
                                            LEFT JOIN subid s ON pd.subid_id=s.id
                                            LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                            WHERE                                            
                                                download_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                download_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                                p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND 
                                                l.country LIKE '%{$_REQUEST[geo_9]}%' AND
                                                (   
                                                    s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                    s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                    s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                ) 
                                            GROUP BY
                                                DATE_FORMAT(DATE_ADD(download_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                        ) proj_click
                                    LEFT JOIN
                                        (
                                            SELECT 
                                                DATE_FORMAT(DATE_ADD(ip.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date,
                                                sum(ip.open_session) AS open_session, 
                                                sum(ip.install_accepted) AS install_accepted, 
                                                sum(ip.install_started) AS install_started, 
                                                sum(ip.install_completed) AS install_completed
                                            FROM 
                                                install_projects ip
                                            LEFT JOIN projects p ON ip.proj_id=p.id
                                            LEFT JOIN users u ON p.assigned_user_id=u.id
                                            LEFT JOIN projects_downloads pd ON pd.id=ip.download_id
                                            LEFT JOIN subid s ON pd.subid_id=s.id
                                            LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                            LEFT JOIN templates t ON t.id=ip.template_id
                                            WHERE
                                                ip.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND 
                                                ip.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                                p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND                                                 
                                                l.country LIKE '%{$_REQUEST[geo_9]}%' AND
                                                (   
                                                    s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                    s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                    s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                ) AND
                                                t.name LIKE '%{$_REQUEST[template_9]}%'
                                            GROUP BY 
                                                DATE_FORMAT(DATE_ADD(ip.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                        ) proj_state
                                    ON proj_click.date = proj_state.date
                                    LEFT JOIN
                                        (                                             
                                            SELECT
                                                DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d') as date,
                                                sum(io.price*io.adjust_rate/100) AS total,
                                                sum(io.price*io.adjust_rate/100*(100 - io.am_revenue - io.pub_revenue - io.pm_revenue)/100) AS net_revenue
                                            FROM 
                                                (    
                                                    SELECT 
                                                        io1.install_datetime,
                                                        io1.price, io1.adjust_rate, io1.am_revenue, io1.pub_revenue, io1.pm_revenue
                                                    FROM 
                                                        install_offers io1
                                                    LEFT JOIN projects_downloads pd on io1.download_id=pd.id                                                    
                                                    LEFT JOIN projects p ON io1.proj_id=p.id
                                                    LEFT JOIN users u ON p.assigned_user_id=u.id                                                    
                                                    LEFT JOIN subid s ON pd.subid_id=s.id
                                                    LEFT JOIN geo_location l ON pd.location_id=l.id                                            
                                                    LEFT JOIN templates t ON t.id=io1.template_id
                                                        
                                                    WHERE
                                                        io1.install_completed = 1 AND
                                                        io1.install_datetime >= DATE_SUB('{$_REQUEST['form-date-range9-startdate']}', INTERVAL {$diff_timezone} HOUR) AND
                                                        io1.install_datetime < DATE_ADD(DATE_SUB('{$_REQUEST['form-date-range9-enddate']}', INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND
                                                        p.proj_name LIKE '%{$_REQUEST[campign_9]}%' AND
                                                        CONCAT( u.user_first_name,  ' ', u.user_last_name ) LIKE '%{$_REQUEST[publisher_9]}%' AND 
                                                        l.country LIKE '%{$_REQUEST[geo_9]}%' AND
                                                        (   
                                                            s.subid1 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid2 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid3 LIKE '%{$_REQUEST[subid_9]}%' OR s.subid4 LIKE '%{$_REQUEST[subid_9]}%' OR 
                                                            s.subid5 LIKE '%{$_REQUEST[subid_9]}%' 
                                                        ) AND
                                                        t.name LIKE '%{$_REQUEST[template_9]}%'
                                                        
                                                ) io
                                            GROUP BY DATE_FORMAT(DATE_ADD(io.install_datetime,INTERVAL {$diff_timezone} HOUR), '%Y-%m-%d')
                                        ) proj_revenue
                                    ON proj_click.date = proj_revenue.date                                    
                                ORDER BY proj_click.date
                                ";
}
                    //echo("<textarea>" . $sql . "</textarea>"); exit;                                
                                                        $q = mysqli_query($newconn, $sql);
                                                        
                                                        $total_clicks = 0;
                                                        $total_open_sessions = 0;
                                                        $total_install_accepted = 0;
                                                        $total_install_started = 0;
                                                        $total_install_successed = 0;
                                                        $total_adjust_install = 0;
                                                        $total_revenue = 0;
                                                                                                                
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                            {
                                                                $total_adjust_install += (int)$row[adjust_install];    
                                                            }
                                                            else
                                                            {
                                                                $total_clicks += $row[clicks];
                                                                $total_open_sessions += $row[open_session];
                                                            }
                                                            $total_install_accepted += $row[install_accepted];
                                                            $total_install_started += $row[install_started];
                                                            $total_install_successed += $row[install_completed];
                                                            $total_revenue += $row[total];
                                                        ?>

                                                            <tr class="odd gradeX">
                                                                
                                                                <td><?= $row[date] ?></td>                                  
                                                                <? if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                                {?>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <?
                                                                }
                                                                else
                                                                { 
                                                                ?>
                                                                <td><?= $row[clicks]?></td>
                                                                <td> <?= $row[open_session] ?></td>
                                                                <? 
                                                                } 
                                                                ?>
                                                                <td> <?= $row[install_accepted] ?></td>
                                                                <td> <?= $row[install_started] ?></td>
                                                                <td> <?= $row[install_completed] ?></td>
                                                                <? if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                                {
                                                                ?>
                                                                <td><?=(int)$row[adjust_install] ?></td>
                                                                <?
                                                                }
                                                                ?>
                                                                <td>$<?= number_format($row[total], 2) ?></td>
                                                                <td>$<?= number_format($row[total]/$row[install_completed], 2) ?></td>
                                                                <? if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                                {?>
                                                                <td>$0.00</td>
                                                                <? } else { ?>
                                                                <td>$<?= number_format($row[total]/$row[clicks], 2) ?></td>
                                                                <? } ?>
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
                                                            <th>Clicks</th>
                                                            <th>Open Sessions</th>
                                                            <th>Install Accepted</th>
                                                            <th>Install Started</th>
                                                            <th>Install Completed</th>
                                                            <? if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                            {
                                                            ?>
                                                            <th>Adjust Installs</th>
                                                            <?}?>
                                                                
                                                            <th>Revenue</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                
                                                    <tr>
                                                        <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                        <? if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9])) {?>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <?
                                                        }
                                                        else
                                                        { 
                                                         ?>
                                                        <td><?= $total_clicks?></td>
                                                        <td><?= $total_open_sessions ?></td>
                                                        <? } ?>
                                                        <td><?= $total_install_accepted ?></td>
                                                        <td><?= $total_install_started?></td>
                                                        <td><?= $total_install_successed?></td>
                                                        <?
                                                        if(($_REQUEST[advertiser_9]!='')||($_REQUEST[bundle_9])||($_REQUEST[offer_9]))
                                                        {
                                                        ?>
                                                        <td><?= $total_adjust_install?></td>
                                                        <?
                                                        } 
                                                        ?>
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
                                    
                                    
                                    <div class="tab-pane <? if ($_REQUEST[tab] == '10')  { ?>active<? } ?>" id="portlet_tab10">
                                        <div class="widget-body form" >
                                            
                                            <!-- BEGIN FORM-->
                                            <form action="#" class="form-horizontal" id="form_10" method="POST">
                                                <input type="hidden" name="tab" value="10"/>
                                                <input type="hidden" name="mode" value="generate"/>
                                                <input type="hidden" name="form-date-range10-startdate" id="form-date-range10-startdate" value="<?= $_REQUEST['form-date-range10-startdate']?>">
                                                <input type="hidden" name="form-date-range10-enddate" id="form-date-range10-enddate" value="<?= $_REQUEST['form-date-range10-enddate']?>">
                                                <input type="hidden" id="timezone_10" name="timezone" value="12"/>
                                                <div class="control-group" style="width: 480px;">
                                                    <? 
                                                    //    Neither Request or Session holds a date
                                                        if (strlen(trim($_REQUEST['form-date-range10-startdate'])) == 0)
                                                        {
                                                            $endDate10 = new DateTime();
                                                            $startDate10  = new DateTime();
                                                            
                                                            $startDate10->modify('-29 days');                                                            
                                                            $_REQUEST['form-date-range10-enddate'] = $endDate10->format('Y-m-d 00:00:00');
                                                            $_REQUEST['form-date-range10-startdate'] = $startDate10->format('Y-m-d 00:00:00');
                                                            
                                                        }
                                                        elseif (strlen(trim($_REQUEST['form-date-range10-startdate'])) > 0)
                                                        {
                                                            $endDate10     = new DateTime($_REQUEST['form-date-range10-enddate']); 
                                                            $startDate10  = new DateTime($_REQUEST['form-date-range10-startdate']);                                                        
                                                        }
                                                        
                                                        ?> 
                                                    <script>
                                                        var startDate10     = "<?php echo $startDate10->format('Y-m-d 00:00:00'); ?>";
                                                        var endDate10     = "<?php echo $endDate10->format('Y-m-d 00:00:00'); ?>";                                                        
                                                
                                                    </script>
                                                    <label class="control-label" >Date Ranges:</label>
                                                    <div class="controls" >
                                                        <div id="form-date-range10" class="report-range-container span12">
                                                            <i class="icon-calendar icon-large"></i>&nbsp;&nbsp;<span><? echo $startDate10->format('F j, Y')." - ".$endDate10->format('F j, Y') ?></span> <b class="caret pull-right"></b>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Offer Bundle:</label>
                                                    <div class="controls">
                                                        <input type="text" id="bundle_10" name="bundle_10" value="<?= $_REQUEST[bundle_10] ?>" class=""/>
                                                    </div>
                                                </div> 
                                                
                                                <div class="control-group" style="margin-bottom: 5px; float: left;">
                                                    <label class="control-label" for="input3">Offer :</label>
                                                    <div class="controls">
                                                        <input type="text" id="offer_10" name="offer_10" value="<?= $_REQUEST[offer_10] ?>" class=""/>
                                                    </div>
                                                </div> 

                                                <div style="height: 45px;"></div>

                                                <div class="form-actions">
                                                    <a href="#" class="btn btn-success" onclick="
                                                            timezone = $('#timezone_list').val();
                                                            $('#timezone_10').val(timezone);
                                                            $('#form_10').submit();
                                                            return false;"><i class="icon-check"></i> Generate Report</a>
                                                           
                                                    <a href="#" id = 'csv1' class="btn btn-success" name = "csv_download" onclick="
                                                    $('#type1').value = 'csv';
                                                    timezone = $('#timezone_list').val();
                                                    $('#timezone_10').val(timezone);
                                                    getOfferBundleCSV(
                                                        $('#form-date-range10-startdate').val(), 
                                                        $('#form-date-range10-enddate').val(),  
                                                        $('#bundle_10').val(), 
                                                        $('#offer_10').val(),
                                                        timezone)" 
                                                        >Save as CSV</a>        
                                                
                                                </div>
                                            </form>

                                        </div>

                                        <div class="widget-body form ">
                                            <!-- BEGIN FORM-->
                                            <div id="chart_sort_div_8" ></div>
                                        </div>
             
                                        <? if (($_REQUEST[tab] == '10') && ($_REQUEST[mode] == 'generate')) { 
                                            
                                        $bundle = $_REQUEST[bundle_10];

                                        ?>
                                            <div class="clearfix"></div>
                                            <br><br>
                                            <div class="widget-body form">
                                                <table class="table table-striped table-bordered" id="sample_10">
                                                    <thead>
                                                        <tr>
                                                            <th>Combo ID</th>
                                                            <th>Offer Bundle</th>
                                                            <th>Offer Bundle Combo</th>                                                            
                                                            <th>Session</th>
                                                            <th>Revenue</th>
                                                            <th>RPOBC</th>             
                                                            <th>Total Session</th>
                                                            <th>Current RPOBC</th>                                               
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?
                                                        
 //get auto optimizer term                                                       
 $sql_t = "SELECT field_value FROM network_setting WHERE field_name='auto_optimizer_term'";
    
 $q_t = mysqli_query($newconn, $sql_t);
 $row_t = mysqli_fetch_assoc($q_t);
 $term = (int)$row_t[field_value];
    
 //get offer_id

$arr_offer_id = array();
if($_REQUEST[offer_10] == "")
{
    
} 
else
{
    $sql = "SELECT id FROM offers WHERE offer_name LIKE '%{$_REQUEST[offer_10]}%'";
    $q = mysqli_query($newconn, $sql);
    while($row = mysqli_fetch_assoc($q))
    {
        array_push($arr_offer_id, $row[id]);
    }
}
 //var_dump($arr_offer_id);exit;

 $t = date("H");
$sql = "

SELECT  c.id as combo_id, c.combo, io1.cc as session, io1.revenue, c.bundle_id, (io1.revenue/io1.cc) as rpobc, b.name as bundle_name,
        c.session as total_session, c.rpobc as current_rpobc   
FROM 
    (   SELECT io.combo_id, count(io.id) as cc, sum(io.price) as revenue 
        FROM 
            (   SELECT combo_id, id, sum(install_completed*price*adjust_rate/100) as price
                FROM install_offers
                WHERE   install_datetime >= '{$_REQUEST['form-date-range10-startdate']}' AND                
                        install_datetime < DATE_ADD('{$_REQUEST['form-date-range10-enddate']}', INTERVAL {$t} HOUR)
                GROUP BY download_id, combo_id 
            ) io 
        GROUP BY io.combo_id
    ) io1 
LEFT JOIN combos c ON io1.combo_id=c.id
LEFT JOIN bundles b ON c.bundle_id=b.id
WHERE b.name LIKE '%{$_REQUEST[bundle_10]}%'
ORDER BY (io1.revenue/io1.cc) DESC               
";
                                                        
                    //echo("<textarea>" . $sql . "</textarea>"); exit;                                
                                                        $q = mysqli_query($newconn, $sql);
                                                            
                                                        $arr_data_bundle = array();                                                    
                                                        while ($row = mysqli_fetch_assoc($q)) {
                                                            $i = 0;
                                                            //apply offer filter
                                                            $arr_offer_size = sizeof($arr_offer_id);
                                                            if($arr_offer_size==0)
                                                            {
                                                                //without offer filter
                                                            }
                                                            else
                                                            {
                                                                //with offer filter
                                                                for($i=0;$i<$arr_offer_size;$i++)
                                                                {
                                                                    //echo($row[combo] . "==" . $arr_offer_id[$i] . "<br>");
                                                                    $r1 = strstr($row[combo], $arr_offer_id[$i]);
                                                                    //var_dump($r1);echo("<br>");
                                                                    if(strstr($row[combo], $arr_offer_id[$i])!=false)
                                                                        break;
                                                                }
                                                                if($i==$arr_offer_size)
                                                                    continue;                                                                 
                                                            }
                                                            
                                                            
                                                            $bundle_id = $row[bundle_id];
                                                            $arr_data_bundle[$bundle_id][session] += (int)$row[session];
                                                            $arr_data_bundle[$bundle_id][revenue] += (float)$row[revenue];
                                                            $arr_data_bundle[$bundle_id][bundle_name] = $row[bundle_name];
                                                            $arr_data_bundle[$bundle_id][bundle_id] = $row[bundle_id];
                                                        ?>

                                                            <tr class="odd gradeX">
                                                                <td> <?=$row[combo_id] ?></td>
                                                                <td> <a href="bundle_edit.php?id=<?=$row[bundle_id] ?>"><?= $row[bundle_name] ?></a></td>
                                                                <?php 
                                                                //get combos
                                                                $arr_offer = explode("|", $row[combo]);
                                                                $str_tmp1 = "";
                                                                foreach( $arr_offer as $offer_tmp)
                                                                {
                                                                    $sql1 = "SELECT offer_name FROM offers WHERE id={$offer_tmp}";
                                                                    $q1 = mysqli_query($newconn, $sql1);
                                                                    $row1 = mysqli_fetch_assoc($q1);
                                                                    $str_tmp1 .= " <a href='offer_edit.php?oid={$offer_tmp}'>" . $row1[offer_name] . "</a> |";
                                                                }
                                                                $str_tmp1 = substr($str_tmp1, 0 ,-1);
                                                                //$str_tmp1 .= $arr_offer_id[$i];
                                                                ?>                                   
                                                                <td><?= $str_tmp1?></td>
                                                                <!--<td><?=$row[combo] ?></td>-->
                                                                <td> <?= $row[session] ?></td>
                                                                <td>$<?= number_format($row[revenue], 2) ?></td>                                                                
                                                                <td>$<?= number_format($row[rpobc],2) ?></td>
                                                                <td><?=$row[total_session] ?></td>
                                                                <td>$<?=number_format($row[current_rpobc],2) ?></td>
                                                            </tr>
                                                            <?
                                                            $i++;  
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <br>
<?
    //for total table
    //var_dump($arr_data_bundle);exit;
    /*
 $sql = "
SELECT b.id as bundle_id, b.name as bundle_name, sum(ioc.cc) as session, sum(ioc.revenue) as revenue  
FROM combos c 
LEFT JOIN bundles b ON c.bundle_id=b.id 
LEFT JOIN 
(           SELECT count(io.id) as cc, sum(io.price) as revenue, io.combo_id 
            FROM (
                    SELECT count(id) as id, download_id, combo_id, sum(price*adjust_rate/100) as price 
                    FROM install_offers 
                    WHERE install_completed=1 AND install_datetime>=CAST(DATE_SUB(NOW(), INTERVAL {$auto_optimizer_term} DAY) AS DATE)
                    GROUP BY download_id, combo_id
                    ) io                
            GROUP BY io.combo_id) ioc 
ON c.id=ioc.combo_id
WHERE ioc.revenue>0 AND b.name LIKE '%{$_REQUEST[bundle_10]}%'
GROUP BY b.id
ORDER BY b.id 
";
*/
?>
                                                <table class="table table-striped table-bordered" style="margin: auto;width: 800px;">
                                                    <thead>
                                                        <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Offer Bundle</th>
                                                            <th>Total Sessions</th>
                                                            <th>Total Revenue</th>
                                                            <th>RPOB</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <? 
                                                    //$q = mysqli_query($newconn, $sql);
                                                    //while ($row = mysqli_fetch_assoc($q)) {
                                                    foreach($arr_data_bundle as $row){
                                                    ?>
                                                        <tr>
                                                            <td class="highlight" style="color: blue;font-weight: bold;">TOTAL VALUE</td>
                                                            <td> <a href="bundle_edit.php?id=<?=$row[bundle_id] ?>"><?= $row[bundle_name] ?></a></td>
                                                            <td><?= $row[session]?></td>
                                                            <td>$<?= number_format($row[revenue], 2)?></td>
                                                            <td>$<?= number_format($row[revenue]/$row[session],2) ?></td>                                                            
                                                        </tr>
                                                    <? 
                                                    }
                                                    ?>
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
