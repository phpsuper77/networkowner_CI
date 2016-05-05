<?php
include '../config.php';   

define('NETWORK_ALERT', 1); 
define('ADVERTISER_ALERT', 2); 
define('PUBLISHER_ALERT', 3); 
define('CAMPAIGN_ALERT', 4); 
define('GEO_ALERT', 5); 


function InsertAlertToDB($dataconn, $current_user_id, $network_id, $alerts_type, $alert_text)
{
    $sql = "
        INSERT INTO news(user_id, network_id, news_type, news_datetime, news_title, news_text) 
        VALUES ({$current_user_id},{$network_id}, {$alerts_type}, NOW(), '', '{$alert_text}')
    ";
    //echo($sql); echo("<br>");
    mysqli_query($dataconn, $sql);
}


// get global alert rate
$sql = "SELECT field_value FROM network_setting 
        WHERE field_name='alert_rate' OR field_name='alert_revenue' OR field_name='alert_install' OR field_name='alert_click'";
$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$g_rate = (float)$row[field_value];
$row = mysqli_fetch_assoc($q);
$g_revenue = (float)$row[field_value];
$row = mysqli_fetch_assoc($q);
$g_install = (int)$row[field_value];
$row = mysqli_fetch_assoc($q);
$g_click = (int)$row[field_value];
///////// generate alert for network owner

///// check total revenue
{
//get total revenue of prev day of yesterday
$sql = "
        SELECT sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND  
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1
";

$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$prev_total_revenue = (float)$row[revenue];

//get total revenue of yesterday
$sql = "
        SELECT sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND  
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1
";

$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$yesterday_total_revenue = (float)$row[revenue];

if(($yesterday_total_revenue>$g_revenue) || ($prev_total_revenue>$g_revenue))
{
    $diff_total_revenue = abs($yesterday_total_revenue - $prev_total_revenue);
    $total_revenue_rate = number_format( $diff_total_revenue / $prev_total_revenue * 100, 0);

    //var_dump($total_revenue_rate);exit;

    if($total_revenue_rate > $g_rate)
    {
        //insert alert into news table
        if($yesterday_total_revenue > $prev_total_revenue)
        {
            $alert = "Total Revenue has increased by {$total_revenue_rate} %";        
        }
        else
        {
            $alert = "Total Revenue has decreased by {$total_revenue_rate} %";        
        }
        /*
        $sql = "INSERT INTO news(user_id, network_id, news_type, news_datetime, news_title, news_text) 
                    VALUES (0, -1, 0, NOW(), '', '{$alert}')
                    ";   
        mysqli_query($newconn, $sql); 
        */
        InsertAlertToDB($newconn, 0, -1, NETWORK_ALERT, $alert);
    }
}
}
///// check total click
{
//get total click of prev day of yesterday
$sql = "
        SELECT count(id) as click FROM projects_downloads 
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND  
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)
";

$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$prev_total_click = (int)$row[click];

//get total revenue of yesterday
$sql = "
        SELECT count(id) as click FROM projects_downloads 
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND  
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY)
";

$q = mysqli_query($newconn, $sql);
$row = mysqli_fetch_assoc($q);
$yesterday_total_click = (int)$row[click];

if(($prev_total_click>$g_click) || ($yesterday_total_click>$g_click))
{
    $diff_total_click = abs($yesterday_total_click - $prev_total_click);
    $total_click_rate = number_format( (float)($diff_total_click / $prev_total_click) * 100, 0);

    //var_dump($total_click_rate);exit;

    if($total_click_rate > $g_rate)
    {
        //insert alert into news table
        if($yesterday_total_click > $prev_total_click)
        {
            $alert = "Total Clicks has increased by {$total_click_rate} %";        
        }
        else
        {
            $alert = "Total Clicks has decreased by {$total_click_rate} %";        
        } 
        
        InsertAlertToDB($newconn, 0, -1, NETWORK_ALERT, $alert); 
    }
}
}

///// check offers install successed
{
$sql = "
    SELECT u.user_manager as manager_id, o.id, o.offer_name, pd.cc as pd_cc, yd.cc as yd_cc
    FROM offers o 
    LEFT JOIN users u ON o.assigned_user_id=u.id
    LEFT JOIN 
    (  
        SELECT offer_id, count(id) as cc FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1
        GROUP BY offer_id
    ) pd ON pd.offer_id=o.id
    LEFT JOIN
    (
        SELECT offer_id, count(id) as cc FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1
        GROUP BY offer_id
    ) yd ON yd.offer_id=o.id 
    WHERE o.offer_show=1 AND o.status=0 AND pd.cc>0
";

$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $offer_id = $row[offer_id];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc];
    
    if(($pd_cc>$g_install) || ($yd_cc>$g_install))
    {
        if($yd_cc == 0)
        {
            $alert = "{$row[offer_name]} has decreased to 0";   
            
            InsertAlertToDB($newconn, 0, -1, ADVERTISER_ALERT, $alert);     
            InsertAlertToDB($newconn, $manager_id, -1, NETWORK_ALERT, $alert);          
        }
        else 
        {
            $diff_cc = abs($yd_cc - $pd_cc);
            $offer_cc_rate = number_format( $diff_cc / $pd_cc * 100, 0);
            
            if($offer_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$row[offer_name]} has increased installs by {$offer_cc_rate} %";
                }
                else
                {
                    $alert = "{$row[offer_name]} has decreased installs by {$offer_cc_rate} %";
                }
                
                InsertAlertToDB($newconn, 0, -1, ADVERTISER_ALERT, $alert);     
                InsertAlertToDB($newconn, $manager_id, -1, NETWORK_ALERT, $alert); 
            }
        }        
    }
}
}

///// check publisher revenue
{
$sql = "
    SELECT u.id as user_id, u.user_manager as manager_id, u.user_first_name, u.user_last_name, sum(pd.revenue) as pd_revenue, sum(yd.revenue) as yd_revenue
    FROM users u 
    LEFT JOIN projects p ON p.assigned_user_id=u.id    
    LEFT JOIN 
    (  
        SELECT  proj_id, sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1
        GROUP BY proj_id
    ) pd ON pd.proj_id=p.id
    LEFT JOIN
    (
        SELECT  proj_id, sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1
        GROUP BY proj_id
    ) yd ON yd.proj_id=p.id 
    WHERE u.user_status=3 AND pd.revenue>0
    GROUP BY u.id 
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $current_user_id = $row[user_id];
    $manager_id = $row[manager_id];
    $pd_revenue = (float)$row[pd_revenue];
    $yd_revenue = (float)$row[yd_revenue];     
    
    if(($pd_revenue>$g_revenue) || ($yd_revenue>$g_revenue))
    {
        if($yd_revenue == 0)
        {
            $alert = "{$row[user_first_name]} {$row[user_last_name]} has decreased revenue to 0";  
            InsertAlertToDB($newconn, 0, -1, PUBLISHER_ALERT, $alert);     
            InsertAlertToDB($newconn, $current_user_id, -1, PUBLISHER_ALERT, $alert);     
            InsertAlertToDB($newconn, $manager_id, -1, PUBLISHER_ALERT, $alert);                  
        }
        else
        {
            $diff_revenue = abs($yd_revenue - $pd_revenue) / $pd_revenue * 100;
            $pub_revenue_rate = number_format($diff_revenue , 0);
        
            if($pub_revenue_rate>$g_rate)
            {
                if($yd_revenue>$pd_revenue)
                {
                    $alert = "{$row[user_first_name]} {$row[user_last_name]} has increased revenue by {$pub_revenue_rate} %";
                }
                else
                {
                    $alert = "{$row[user_first_name]} {$row[user_last_name]} has decreased revenue by {$pub_revenue_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, PUBLISHER_ALERT, $alert);     
                InsertAlertToDB($newconn, $current_user_id, -1, PUBLISHER_ALERT, $alert);     
                InsertAlertToDB($newconn, $manager_id, -1, PUBLISHER_ALERT, $alert);             
            }
        }        
    }
}
}

///// check publisher clicks
{
$sql = "
    SELECT u.id as user_id, u.user_manager as manager_id, u.user_first_name, u.user_last_name, sum(pd.cc) as pd_cc, sum(yd.cc) as yd_cc
    FROM users u 
    LEFT JOIN projects p ON p.assigned_user_id=u.id    
    LEFT JOIN 
    (  
        SELECT  proj_id, count(id) as cc FROM projects_downloads
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)
        GROUP BY proj_id
    ) pd ON pd.proj_id=p.id
    LEFT JOIN
    (
        SELECT  proj_id, count(id) as cc FROM projects_downloads
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY)
        GROUP BY proj_id
    ) yd ON yd.proj_id=p.id 
    WHERE u.user_status=3 AND pd.cc>0
    GROUP BY u.id
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $current_user_id = $row[user_id];
    $manager_id = $row[manager_id];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc];    
    
    if(($pd_cc>$g_click) || ($yd_cc>$g_click))
    {
        if($yd_cc==0)
        {
            $alert = "{$row[user_first_name]} {$row[user_last_name]} has decreased clicks to 0";    
            InsertAlertToDB($newconn, 0, -1, PUBLISHER_ALERT, $alert);     
            InsertAlertToDB($newconn, $current_user_id, -1, PUBLISHER_ALERT, $alert);     
            InsertAlertToDB($newconn, $manager_id, -1, PUBLISHER_ALERT, $alert);             

        }
        else
        {
            $diff_cc = abs($yd_cc - $pd_cc) / $pd_cc * 100;
            $pub_cc_rate = number_format($diff_cc , 0);
        
            if($pub_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$row[user_first_name]} {$row[user_last_name]} has increased clicks by {$pub_cc_rate} %";
                }
                else
                {
                    $alert = "{$row[user_first_name]} {$row[user_last_name]} has decreased clicks by {$pub_cc_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, PUBLISHER_ALERT, $alert);     
                InsertAlertToDB($newconn, $current_user_id, -1, PUBLISHER_ALERT, $alert);     
                InsertAlertToDB($newconn, $manager_id, -1, PUBLISHER_ALERT, $alert);             
            }                                                                                    
        }
    }
}
}

///// check campaign revenue
{
$sql = "
    SELECT u.id as user_id, u.user_manager as manager_id, p.id as proj_id, p.proj_name, pd.revenue as pd_revenue, yd.revenue as yd_revenue
    FROM projects p 
    LEFT JOIN users u ON u.id=p.assigned_user_id
    LEFT JOIN 
    (  
        SELECT  proj_id, sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1
        GROUP BY proj_id
    ) pd ON pd.proj_id=p.id
    LEFT JOIN
    (
        SELECT  proj_id, sum(price) as revenue FROM install_offers 
        WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1
        GROUP BY proj_id
    ) yd ON yd.proj_id=p.id 
    WHERE p.status=0 AND pd.revenue>0    
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{
    $current_user_id = $row[user_id];
    $manager_id = $row[manager_id];
    $proj_id = (int)$row[proj_id];
    $pd_revenue = (float)$row[pd_revenue];
    $yd_revenue = (float)$row[yd_revenue];   
    
    if(($pd_revenue>$g_revenue) || ($yd_revenue>$g_revenue)) 
    {    
        if($yd_revenue == 0)
        {
            $alert = "{$row[proj_name]} has decreased revenue to 0";
            InsertAlertToDB($newconn, 0, -1, CAMPAIGN_ALERT, $alert);     
            InsertAlertToDB($newconn, $current_user_id, -1, CAMPAIGN_ALERT, $alert);     
            InsertAlertToDB($newconn, $manager_id, -1, CAMPAIGN_ALERT, $alert);
        }
        else
        {
            $diff_revenue = abs($yd_revenue - $pd_revenue) / $pd_revenue * 100;
            $camp_revenue_rate = number_format($diff_revenue , 0);
        
            if($camp_revenue_rate>$g_rate)
            {
                if($yd_revenue>$pd_revenue)
                {
                    $alert = "{$row[proj_name]} has increased revenue by {$camp_revenue_rate} %";
                }
                else
                {
                    $alert = "{$row[proj_name]} has decreased revenue by {$camp_revenue_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, CAMPAIGN_ALERT, $alert);     
                InsertAlertToDB($newconn, $current_user_id, -1, CAMPAIGN_ALERT, $alert);     
                InsertAlertToDB($newconn, $manager_id, -1, CAMPAIGN_ALERT, $alert);                 
            }
        }       
    }
}
}

///// check campaign clicks
{
$sql = "
    SELECT u.id as user_id, u.user_manager as manager_id, p.id as proj_id, p.proj_name, pd.cc as pd_cc, yd.cc as yd_cc
    FROM projects p
    LEFT JOIN users u ON u.id=p.assigned_user_id
    LEFT JOIN 
    (  
        SELECT  proj_id, count(id) as cc FROM projects_downloads
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)
        GROUP BY proj_id
    ) pd ON pd.proj_id=p.id
    LEFT JOIN
    (
        SELECT  proj_id, count(id) as cc FROM projects_downloads
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY)
        GROUP BY proj_id
    ) yd ON yd.proj_id=p.id 
    WHERE p.status=0 AND pd.cc>0   
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $current_user_id = $row[user_id];
    $manager_id = $row[manager_id];
    $proj_id = $row[proj_id];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc]; 
    
    if(($pd_cc>$g_click) || ($yd_cc > $g_click)) 
    {    
        if($yd_cc == 0)
        {
            $alert = "{$row[proj_name]} has decreased clicks to 0";
            
            InsertAlertToDB($newconn, 0, -1, CAMPAIGN_ALERT, $alert);     
            InsertAlertToDB($newconn, $current_user_id, -1, CAMPAIGN_ALERT, $alert);     
            InsertAlertToDB($newconn, $manager_id, -1, CAMPAIGN_ALERT, $alert);
        }
        else
        {
            $diff_cc = abs($yd_cc - $pd_cc) / $pd_cc * 100;
            $camp_cc_rate = number_format($diff_cc , 0);
        
            if($camp_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$row[proj_name]} has increased clicks by {$camp_cc_rate} %";
                }
                else
                {
                    $alert = "{$row[proj_name]} has decreased clicks by {$camp_cc_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, CAMPAIGN_ALERT, $alert);     
                InsertAlertToDB($newconn, $current_user_id, -1, CAMPAIGN_ALERT, $alert);     
                InsertAlertToDB($newconn, $manager_id, -1, CAMPAIGN_ALERT, $alert);
            }              
        }
    }
}
}

///// check geo clicks 
{
$sql = "
    SELECT pd.country, yd.cc as yd_cc, pd.cc as pd_cc
    FROM 
    (  
        SELECT  gl.country, count(pd.id) as cc 
        FROM projects_downloads pd
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)
        GROUP BY gl.country
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, count(pd.id) as cc 
        FROM projects_downloads pd
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY)
        GROUP BY gl.country
    ) yd ON yd.country=pd.country
    WHERE pd.cc>0        
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $country = $row[country];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc];    
    
    if(($pd_cc>$g_click) || ($yd_cc > $g_click)) 
    {
        if($yd_cc == 0)
        {
            $alert = "{$country} has decreased clicks to 0";                     
            InsertAlertToDB($newconn, 0, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_cc = abs($yd_cc - $pd_cc) / $pd_cc * 100;
            $geo_cc_rate = number_format($diff_cc , 0);
        
            if($geo_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$country} has increased clicks by {$geo_cc_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_cc_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, GEO_ALERT, $alert);                     
            }              
        }                 
    }
}
} 

///// check geo revenue
{
$sql = "
    SELECT pd.country, yd.revenue as yd_revenue, pd.revenue as pd_revenue
    FROM 
    (  
        SELECT  gl.country, sum(io.price) as revenue 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id          
        GROUP BY gl.country
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, sum(io.price) as revenue 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id          
        GROUP BY gl.country
    ) yd ON yd.country=pd.country  
    WHERE pd.revenue>0      
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $country = $row[country];
    $pd_revenue = (float)$row[pd_revenue];
    $yd_revenue = (float)$row[yd_revenue];    
    
    if(($pd_revenue>$g_revenue) || ($yd_revenue>$g_revenue))
    {
        if($yd_revenue == 0)
        {
            $alert = "{$country} has decreased revenue to 0";                     
            InsertAlertToDB($newconn, 0, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_revenue = abs($yd_revenue - $pd_revenue) / $pd_revenue * 100;
            $geo_revenue_rate = number_format($diff_revenue , 0);
        
            if($geo_revenue_rate>$g_rate)
            {
                if($yd_revenue>$pd_revenue)
                {
                    $alert = "{$country} has increased clicks by {$geo_revenue_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_revenue_rate} %";
                }
                InsertAlertToDB($newconn, 0, -1, GEO_ALERT, $alert);                     
            }              
        }                 
    }
}
} 

 ///// check publisher geo clicks 
{
$sql = "
    SELECT pd.country, pd.user_id, yd.cc as yd_cc, pd.cc as pd_cc
    FROM 
    (  
        SELECT  gl.country, count(pd.id) as cc, u.id as user_id 
        FROM projects_downloads pd
        LEFT JOIN projects p ON pd.proj_id=p.id
        LEFT JOIN users u ON u.id=p.assigned_user_id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)                 
        GROUP BY gl.country, u.id
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, count(pd.id) as cc, u.id as user_id
        FROM projects_downloads pd
        LEFT JOIN projects p ON pd.proj_id=p.id
        LEFT JOIN users u ON u.id=p.assigned_user_id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY)                 
        GROUP BY gl.country, u.id
    ) yd ON yd.country=pd.country AND yd.user_id=pd.user_id  
    WHERE pd.cc>0      
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $current_user_id = $row[user_id];
    $country = $row[country];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc];    

    if(($pd_cc>$g_click) || ($yd_cc>$g_click))
    {
        if($yd_cc == 0)
        {
            $alert = "{$country} has decreased clicks to 0";                     
            InsertAlertToDB($newconn, $current_user_id, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_cc = abs($yd_cc - $pd_cc) / $pd_cc * 100;
            $geo_cc_rate = number_format($diff_cc , 0);
        
            if($geo_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$country} has increased clicks by {$geo_cc_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_cc_rate} %";
                }
                InsertAlertToDB($newconn, $current_user_id, -1, GEO_ALERT, $alert);                     
            }              
        }         
    }
}
} 

///// check publisher geo revenue
{
$sql = "
    SELECT pd.country, pd.user_id, yd.revenue as yd_revenue, pd.revenue as pd_revenue
    FROM 
    (  
        SELECT  gl.country, sum(io.price) as revenue, u.id as user_id 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN projects p ON p.id=pd.proj_id  
        LEFT JOIN users u ON u.id=p.assigned_user_id      
        LEFT JOIN geo_location gl ON gl.id=pd.location_id                  
        GROUP BY gl.country, u.id
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, sum(io.price) as revenue, u.id as user_id 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN projects p ON p.id=pd.proj_id  
        LEFT JOIN users u ON u.id=p.assigned_user_id      
        LEFT JOIN geo_location gl ON gl.id=pd.location_id                  
        GROUP BY gl.country, u.id
    ) yd ON yd.country=pd.country AND pd.user_id=yd.user_id  
    WHERE pd.revenue>0      
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $country = $row[country];
    $pd_revenue = (float)$row[pd_revenue];
    $yd_revenue = (float)$row[yd_revenue];    
    
    if(($pd_revenue>$g_revenue) || ($yd_revenue>$g_revenue))
    {
        if($yd_revenue == 0)
        {
            $alert = "{$country} has decreased revenue to 0";                     
            InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_revenue = abs($yd_revenue - $pd_revenue) / $pd_revenue * 100;
            $geo_revenue_rate = number_format($diff_revenue , 0);
        
            if($geo_revenue_rate>$g_rate)
            {
                if($yd_revenue>$pd_revenue)
                {
                    $alert = "{$country} has increased clicks by {$geo_revenue_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_revenue_rate} %";
                }
                InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                     
            }              
        }        
    }
}
} 

 ///// check publisher manager geo clicks 
{
$sql = "
    SELECT yd.country, yd.cc as yd_cc, pd.cc as pd_cc
    FROM 
    (  
        SELECT  gl.country, count(pd.id) as cc 
        FROM projects_downloads pd
        LEFT JOIN projects p ON pd.proj_id=p.id
        LEFT JOIN users u ON u.id=p.assigned_user_id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                u.user_manager={$user_id}
        GROUP BY gl.country
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, count(pd.id) as cc 
        FROM projects_downloads pd
        LEFT JOIN projects p ON pd.proj_id=p.id
        LEFT JOIN users u ON u.id=p.assigned_user_id
        LEFT JOIN geo_location gl ON gl.id=pd.location_id
        WHERE   download_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                download_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND
                u.user_manager={$user_id}
        GROUP BY gl.country
    ) yd ON yd.country=pd.country  
    WHERE pd.cc>0      
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $country = $row[country];
    $pd_cc = (int)$row[pd_cc];
    $yd_cc = (int)$row[yd_cc];    
    
    if(($pd_cc>$g_click) || ($yd_cc > $g_click)) 
    {
        if($yd_cc == 0)
        {
            $alert = "{$country} has decreased clicks to 0";                     
            InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_cc = abs($yd_cc - $pd_cc) / $pd_cc * 100;
            $geo_cc_rate = number_format($diff_cc , 0);
        
            if($geo_cc_rate>$g_rate)
            {
                if($yd_cc>$pd_cc)
                {
                    $alert = "{$country} has increased clicks by {$geo_cc_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_cc_rate} %";
                }
                InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                     
            }              
        }
    }
}
} 

///// check publisher geo revenue
{
$sql = "
    SELECT yd.country, yd.revenue as yd_revenue, pd.revenue as pd_revenue
    FROM 
    (  
        SELECT  gl.country, sum(io.price) as revenue 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 2 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN projects p ON p.id=pd.proj_id        
        LEFT JOIN geo_location gl ON gl.id=pd.location_id  
        WHERE   p.assigned_user_id={$user_id}         
        GROUP BY gl.country
    ) pd 
    LEFT JOIN
    (
        SELECT  gl.country, sum(io.price) as revenue 
        FROM 
        (
            SELECT price, download_id FROM install_offers 
            WHERE   install_datetime>=DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                    install_datetime<DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 0 DAY) AND install_completed=1 
        ) io 
        LEFT JOIN projects_downloads pd ON io.download_id=pd.id
        LEFT JOIN projects p ON p.id=pd.proj_id        
        LEFT JOIN geo_location gl ON gl.id=pd.location_id  
        WHERE   p.assigned_user_id={$user_id}         
        GROUP BY gl.country
    ) yd ON yd.country=pd.country 
    WHERE pd.revenue>0       
";
//echo("<textarea>" . $sql . "</textarea>");exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{    
    $country = $row[country];
    $pd_revenue = (float)$row[pd_revenue];
    $yd_revenue = (float)$row[yd_revenue];    
    
    if(($pd_revenue>$g_revenue) || ($yd_revenue>$g_revenue))
    {
        if($yd_revenue == 0)
        {
            $alert = "{$country} has decreased revenue to 0";                     
            InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                 
        }
        else
        {
            $diff_revenue = abs($yd_revenue - $pd_revenue) / $pd_revenue * 100;
            $geo_revenue_rate = number_format($diff_revenue , 0);
        
            if($geo_revenue_rate>$g_rate)
            {
                if($yd_revenue>$pd_revenue)
                {
                    $alert = "{$country} has increased clicks by {$geo_revenue_rate} %";
                }
                else
                {
                    $alert = "{$country} has decreased clicks by {$geo_revenue_rate} %";
                }
                InsertAlertToDB($newconn, $user_id, -1, GEO_ALERT, $alert);                     
            }              
        }
    }
}
} 


 mysqli_close($newconn);

?>