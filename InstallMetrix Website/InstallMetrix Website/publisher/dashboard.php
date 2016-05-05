<? 
include 'z_header.php'; 
$newconn = mysqli_connect(SQLHOST, SQLUSER, SQLPASS, SQLDB);
 
?>
<!-- BEGIN PAGE -->
<div id="body">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">

                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Dashboard
                    <small>statistics and more</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page" class="dashboard">

            <!--                        <div class="alert alert-warning">
                                        <button class="close" data-dismiss="alert">×</button>
                                        After completion of the second project these fake data will be replaced with real data. I left these indicators here to show how the dashboard page will look in future.
                                    </div>-->
            <!-- BEGIN OVERVIEW STATISTIC BARS-->
            <div class="row-fluid stats-overview-cont">
                
                <div class="span2 responsive" data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Today's Revenue<br>&nbsp;</div>
                            <? $time1 = microtime(true);
                                $sql="  SELECT SUM(io.price*adjust_rate/100*io.pub_revenue/100) as price 
                                        FROM install_offers io
                                        LEFT JOIN projects p ON io.proj_id=p.id                                         
                                        WHERE   p.assigned_user_id={$user_id} AND
                                                io.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND
                                                io.install_datetime < DATE_ADD(DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                                io.install_completed=1"; 
                               //var_dump($sql);exit; 
                                        
                            ?>
                            <div class="numbers">$
                            <? 
                                $q = mysqli_query($newconn, $sql);
                                $row = mysqli_fetch_assoc($q);
                                echo(number_format($row[price],2)); 
                            ?>
                            </div>
                        </div>
                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="span2 responsive" data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Yesterday's Revenue<br>&nbsp;</div>
                            <? $time2 = microtime(true);
                            $sql="  SELECT SUM(io.price*io.adjust_rate/100*io.pub_revenue/100) as price 
                                    FROM install_offers io 
                                    LEFT JOIN projects p ON io.proj_id=p.id
                                    WHERE   p.assigned_user_id={$user_id} AND
                                            io.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone}+24 HOUR) AND
                                            io.install_datetime < DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND 
                                            io.install_completed=1"; 
                            $q = mysqli_query($newconn, $sql);
                            $row = mysqli_fetch_assoc($q);
                            
                            ?>
                            <div class="numbers">$<?= number_format($row[price],2); ?></div>                            
                        </div>

                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="span2 responsive " data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Month To Date Revenue<br>&nbsp;</div>
                            <? $time3 = microtime(true);
                            $sql="  SELECT SUM(io.price*io.adjust_rate/100*io.pub_revenue/100) as price 
                                    FROM install_offers io
                                    LEFT JOIN projects p ON io.proj_id=p.id
                                    WHERE   p.assigned_user_id={$user_id} AND 
                                            io.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00'), INTERVAL 1 MONTH), INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                            io.install_completed=1"; //var_dump($sql);exit;
                            $q = mysqli_query($newconn, $sql);
                            $row = mysqli_fetch_assoc($q);
                            //var_dump($row);exit;
                            ?>
                            <div class="numbers">$<?= number_format($row[price],2); ?></div>                            
                        </div>
                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                
                 <div class="span2 responsive" data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Today's Installs Completed</div>
                            <? $time4 = microtime(true);
                            $sql="  SELECT count(ip.id) as cc 
                                    FROM install_projects ip
                                    LEFT JOIN projects p ON ip.proj_id=p.id
                                    WHERE   p.assigned_user_id={$user_id} AND 
                                            ip.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                            ip.install_completed=1"; 
                            //var_dump($sql);exit;
                            $q = mysqli_query($newconn, $sql);
                            $row = mysqli_fetch_assoc($q);
                            //var_dump($row);exit;
                            ?>
                            <div class="numbers"><?= $row[cc]; ?></div>                            
                        </div>
                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div class="span2 responsive" data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Yesterday's Installs Completed</div>
                            <? $time5 = microtime(true);
                            $sql="  SELECT count(ip.id) as cc 
                                    FROM install_projects ip 
                                    LEFT JOIN projects p ON ip.proj_id=p.id
                                    WHERE   p.assigned_user_id={$user_id} AND
                                            ip.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone}+24 HOUR) AND
                                            ip.install_datetime < DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND 
                                            ip.install_completed=1"; 
                            $q = mysqli_query($newconn, $sql);
                            $row = mysqli_fetch_assoc($q);
                            ?>
                            <div class="numbers"><?= $row[cc]; ?></div>                            
                        </div>
                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div class="span2 responsive " data-tablet="span4" data-desktop="span2">
                    <div class="stats-overview block clearfix">

                        <div class="details">
                            <div class="title">Month To Date Installs Completed</div>
                            <? $time6 = microtime(true);
                            $sql="  SELECT count(ip.id) as cc 
                                    FROM install_projects ip 
                                    LEFT JOIN projects p ON ip.proj_id=p.id
                                    WHERE   p.assigned_user_id={$user_id} AND
                                            ip.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND
                                            ip.install_datetime < DATE_ADD(DATE_SUB(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01 00:00:00'), INTERVAL 1 MONTH), INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND 
                                            ip.install_completed=1"; 
                            $q = mysqli_query($newconn, $sql);
                            $row = mysqli_fetch_assoc($q);
                            ?>
                            <div class="numbers"><?= $row[cc] ?></div>                            
                        </div>
                        <div class="progress progress-warning">
                            <div class="bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                            
            </div>
            <!-- END OVERVIEW STATISTIC BARS-->
            <div class="row-fluid">
                <div class="span8">
                    <!-- BEGIN SITE VISITS PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-signal"></i>Network Revenue by hour</h4>
                        </div>
                        <div class="widget-body">
                            <div id="site_statistics_loading">
                                <img src="../common/assets/img/loading.gif" alt="loading" />
                            </div>
                            <div id="site_statistics_content" class="hide">

                                <div id="site_statistics" class="chart"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                            function randValue() {
                                return 10;
                            }
                                        
                            <?php 
                            $str_max = "var max = [";
                            $str_today = "var today = [";
                            $str_yesterday = "var yesterday = [";
                            
                            $max = 0;
                            $time7 = microtime(true);
                            
                                $sql_today = "SELECT hour(io.install_datetime) as hour, SUM(io.price*io.adjust_rate/100*io.pub_revenue/100) as revenue
                                        FROM install_offers io
                                        LEFT JOIN projects p ON io.proj_id=p.id
                                        WHERE   p.assigned_user_id={$user_id} AND
                                            io.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND
                                            io.install_datetime < DATE_ADD(DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR), INTERVAL 1 DAY) AND         
                                            io.install_completed=1 
                                        GROUP BY hour(io.install_datetime)
                                        ORDER BY io.install_datetime
                                        
                                        ";   
                                        
                                $q_today = mysqli_query($newconn, $sql_today);
                             $time8 = microtime(true);   
                                $sql_yesterday =  "SELECT hour(io.install_datetime) as hour, SUM(io.price*io.adjust_rate/100*io.pub_revenue/100) as revenue
                                        FROM install_offers io
                                        LEFT JOIN projects p ON io.proj_id=p.id
                                        WHERE   p.assigned_user_id={$user_id} AND   
                                                io.install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone}+24 HOUR) AND
                                                io.install_datetime < DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$diff_timezone} HOUR) AND                                                                                         
                                                io.install_completed=1 
                                        GROUP BY hour(io.install_datetime)
                                        ORDER BY io.install_datetime
                                        ";
                                $q_yesterday = mysqli_query($newconn, $sql_yesterday);
                                $time9 = microtime(true);
                                for($nHour=0; $nHour<24; $nHour++)
                                {
                                    $row_t = mysqli_fetch_assoc($q_today);
                                    $revenue = $row_t[revenue];
                                    if($revenue==NULL) $revenue = 0;
                                    if($max<$revenue) $max = $revenue;
                                    
                                    $str_today .= $revenue . ",";
                                    
                                    $row_y = mysqli_fetch_assoc($q_yesterday);
                                    $revenue = $row_y[revenue];
                                    if($revenue==NULL) $revenue = 0;
                                    if($max<$revenue) $max = $revenue;
                                
                                    $str_yesterday .= $revenue . ",";                                 
                            }
                            $str_today .= "0];";
                            $str_yesterday .= "0];";
                            
                            $max += 10;
                            for($nHour=0; $nHour<24; $nHour++)   
                            {
                                $str_max .= $max . ",";
                            }
                            $str_max .= "0];";
                            
                            echo ($str_today);
                            echo ($str_yesterday);
                            echo ($str_max);   
                            $time10 = microtime(true); 
                            $timestr = ($time2-$time1) . " | " . ($time3-$time2) . " | " . ($time4-$time3) . " | " . ($time5-$time4) . " | " . 
                            	($time6-$time5) . " | " . ($time7-$time6) . " | " . ($time8-$time7) . " | " . ($time9-$time8) . " | " . ($time10-$time9); 
                            	//var_dump($timestr);exit;
                            ?>
                                                                  
                             $('#site_statistics_loading').hide();
                             $('#site_statistics_content').show();   
                             
                            var time_arr = ["midnight-1AM", "1AM-2AM", "2AM-3AM", "3AM-4AM", "4AM-5AM", "5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM",
                                                                        "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", "8PM-9PM", "9PM-10PM", "10PM-11PM", "11PM-midnight" ];
                           var line3 = new Array(24);  
                           var line2 = new Array(24);
                           for (var i = 0; i < 24; i++) {
                                line3[i] = new Array(2);
                                line3[i][0] = time_arr[i];
                                line3[i][1] = today[i];    
                                
                                line2[i] = new Array(2);
                                line2[i][0] = time_arr[i];
                                line2[i][1] = yesterday[i];    
                           }     
                            var title = '<div style="float:left;width:150px;"><div class="jqplot-table-legend-type-color" style="border-radius: 10px;width:40px;height:7px;background-color:#EAA228;float:left;margin-top:5px;margin-right:5px;"></div><div class="jqplot-table-legend-type-label" style="clear:none;float:left;padding:0 0 0 0;color:#00547D;font-weight:bold;max-width:300px;">';
                                 title += 'Yesterday';
                                 title += '</div></div> <div style="float:left;width:150px;"><div class="jqplot-table-legend-type-color" style="border-radius: 10px;width:40px;height:7px;background-color:#278CC0;float:left;margin-top:5px;margin-right:5px;"></div><div class="jqplot-table-legend-type-label" style="clear:none;float:left;padding:0 0 0 0;color:#00547D;font-weight:bold;max-width:300px;">';
                                 title += 'Today';
                                 title += '</div></div>';
                                 
                            var label1 = "Revenue1";
                             var label2 = "Revenue2";                          
                             var labels = [label1, label2];                    

                            var plot3 = $.jqplot('site_statistics', [line3,line2], {
                            legend: {
                                 show: false,
                                 renderer: $.jqplot.EnhancedLegendRenderer,
                                 rendererOptions: {
                                     numberRows: 1
                                 },
                                 placement: 'outside',
                                 labels: labels,
                                 location: 'n'
                             },
                            series:[],
                            title : {
                                 text : title,
                                 textAlign:'right'                                 
                             }, 
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
                        });                                        
                        
                        function showTooltip(x, y, contents) {
                                $('<div id="tooltip">' + contents + '</div>').css({
                                    position: 'absolute',
                                    display: 'none',
                                    top: y + 5,
                                    left: x + 15,
                                    border: '1px solid #333',
                                    padding: '4px',
                                    color: '#fff',
                                    'border-radius': '3px',
                                    'background-color': '#333',
                                    opacity: 0.80
                                }).appendTo("body").fadeIn(200);
                            }

                            var previousPoint = null;
                            $("#site_statistics").bind("plothover", function(event, pos, item) {
                                $("#x").text(pos.x.toFixed(2));
                                $("#y").text(pos.y.toFixed(2));

                                if (item) {
                                    if (previousPoint != item.dataIndex) {
                                        previousPoint = item.dataIndex;

                                        $("#tooltip").remove();
                                        var x = item.datapoint[0].toFixed(0),
                                                y = item.datapoint[1];

                                        showTooltip(item.pageX, item.pageY, "$" + y + " (" + x + " <?= date("M") ?>)");
                                    }
                                } else {
                                    $("#tooltip").remove();
                                    previousPoint = null;
                                }
                            });

                            //server load
                            var options = {
                                series: {
                                    shadowSize: 1
                                },
                                lines: {
                                    show: true,
                                    lineWidth: 0.5,
                                    fill: true,
                                    fillColor: {
                                        colors: [{
                                                opacity: 0.1
                                            }, {
                                                opacity: 1
                                            }]
                                    }
                                },
                                yaxis: {
                                    min: 0,
                                    max: 100,
                                    tickFormatter: function(v) {
                                        return v + "%";
                                    }
                                },
                                xaxis: {
                                    show: false
                                },
                                colors: ["#e14e3d"],
                                grid: {
                                    tickColor: "#a8a3a3",
                                    borderWidth: 0
                                }
                            };

                            $('#load_statistics_loading').hide();
                            $('#load_statistics_content').show();

                            App.setMainPage(true);
                            App.init();
                        });
                    </script>
                    <!-- END SITE VISITS PORTLET-->
                </div>
                <div class="span4">
                    <!-- BEGIN NOTIFICATIONS PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-warning-sign"></i> Latest News</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-refresh"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <ul class="item-list scroller padding" data-height="295" data-always-visible="1">
                                <?
                                $sql = "SELECT news.*, users.user_first_name, users.user_last_name 
                                        FROM news LEFT JOIN users ON news.user_id=users.id 
                                        WHERE news.user_id={$user_id}
                                        ORDER by news.news_datetime DESC";
                                //var_dump($sql);exit;
                                $q = mysql_query($sql);
                                
                                
                                $first_collaps_id = "";
                                $collaps_arr = array();
                                $date_backup = "";
                                while ($row = mysql_fetch_assoc($q)) 
                                {      
                                    $date = $row[news_datetime];                              
                                    if($date != $datebackup)
                                    {
                                        if($datebackup != "")
                                        {    
                                            array_push($collaps_arr, $date);                                       
                                ?>
                                        </div>
                                        </div>
                                <?
                                        }
                                        else
                                        {
                                            $first_collaps_id = $date;   
                                        }
                                        $datebackup = $date;
                                        
                                ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" 
                                                       href="#<?=$date ?>"> Posted <?=$date?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="<?=$date ?>" class="panel-collapse collapse in">
                                <?
                                    }                                    
                                    ?>
                                    
                                    <li>
                                        <? if($row[news_type] == 0) { ?>
                                            <span class="label label-success">System News</span>
                                        <?} else if ($row[news_type] == 1) { ?>
                                            <span class="label label-warning">Network Alert</span>
                                        <?} else if ($row[news_type] == 2) { ?>
                                            <span class="label label-warning">Advertiser Alert</span>
                                        <?} else if ($row[news_type] == 3) { ?>
                                            <span class="label label-warning">Publisher Alert</span>
                                        <?} else if ($row[news_type] == 4) { ?>
                                            <span class="label label-warning">Campaign Alert</span>
                                        <?} else if ($row[news_type] == 5) { ?>
                                            <span class="label label-warning">Geo Alert</span>
                                        <?}?>
                                                                                     
                                        <!--<span class="bold">Posted <?= $row[news_datetime] ?> </span><br>-->
                                        <h4><?= $row[news_title] ?></h4>
                                        <span><?= $row[news_text] ?></span>
                                    </li>
                                <? 
                                    
                                }
                                 ?> 
                            <script type="text/javascript">
                                $(function () { $('#<?= $first_collaps_id?>').collapse({
                                  toggle: false
                                  })});
                                <?
                                foreach($collaps_arr as $collaps)
                                {
                                    ?>
                                    $(function () { $('#<?=$collaps?>').collapse('toggle')});
                                    <?
                                }
                                ?>
                            </script> 
                           
                            </ul>
                            <div class="space5"></div>
                            <div class="clearfix no-top-space no-bottom-space"></div>
                        </div>
                    </div>
                    <!-- END NOTIFICATIONS PORTLET-->
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>


<? include 'z_footer.php'; ?>