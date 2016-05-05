<?php

include '../config.php';

/*
input sample : ../report.php?download_id=LFA0Z4eE9iV2Q52D&mode=2&os_name=Windows 7&os_add=&os_build=7600&proj_id=1012&offer_id=1027
mode => 0 : project install try , 1: project install success, 2: offer install try , 3: offer install success
        4 : "project" is accepted, 5 : offer is accepted (4 and 5 is for "accepted" on report) 
        6 : it means "open session", when user run installer
        7 : it means screen of the offer is shown. it is for "Offer Screens" column of advertiser tab on report page.
*/
if ($_REQUEST["download_id"] != '') 
{   
    
    $download_id = $_REQUEST["download_id"]; 
    $mode = (int)$_REQUEST["mode"];
    $os_name = $_REQUEST["os_name"];
    $os_add = $_REQUEST["os_add"];
    $os_build = $_REQUEST["os_build"];
    $proj_id = $_REQUEST["proj_id"];         
    $offer_id = $_REQUEST["offer_id"]; 
    $templateid = $_REQUEST["templateid"];
    $combo_id = $_REQUEST["combo_id"]; 
    
    $remote_ip = Convert_IPString_To_Int($_SERVER["REMOTE_ADDR"]);
    
    //get os_typeid
    $os_typeid = 0;
    $sql = "SELECT id FROM os_type WHERE os_name='{$os_name}' AND os_additional='{$os_add}' AND os_build='{$os_build}'";
    $q = mysqli_query($newconn, $sql);   
    $count = mysqli_num_rows($q);
    $row = mysqli_fetch_assoc($q);
    if($count>0)
    {
        $os_typeid = $row[id];
    }
    else
    {
        $sql = "INSERT INTO os_type(os_name, os_additional, os_build) VALUES ('{$os_name}', '{$os_add}', '{$os_build}')";
        mysqli_query($newconn, $sql);
        $os_typeid= mysqli_insert_id($newconn);
    }
    
       
    if(($mode==2)||($mode==3)||($mode==5)||($mode==7))
    {        
        //check record that has the download_id is already or not.
        $sql = "SELECT * FROM install_offers WHERE download_id={$download_id} AND offer_id={$offer_id} AND proj_id={$proj_id}";
        $q =  mysqli_query($newconn, $sql);
        $c = mysqli_num_rows($q); 
        
        if($c==0)
        {
                    //if install_offers case, get price, user_id, manager_id, am_revenue
            $sql = "
                SELECT o.id, o.offer_price as price, o.adjust_rate, u1.id as user_id, u2.id as manager_id, u2.user_revenue as am_revenue 
                FROM offers o 
                LEFT JOIN users u1 ON o.assigned_user_id=u1.id 
                LEFT JOIN users u2 ON u1.user_manager=u2.id
                WHERE o.id={$offer_id} 
            ";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            
            $adjust_rate = $row[adjust_rate];
            $user_id = $row[user_id];
            $manager_id = $row[manager_id];
            $am_revenue = $row[am_revenue];
            
            //get price per country
            $sql = "SELECT location_id FROM projects_downloads WHERE id={$download_id}";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $loc_id = $row[location_id];
            
            $sql = "SELECT id FROM geo_location 
                    WHERE country=(SELECT country FROM geo_location WHERE id={$loc_id}) AND region='' AND city=''";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $country_id = $row[id];
            
            if(($country_id==223) || ($country_id==77) || ($country_id==39) || ($country_id==75) || ($country_id==57) || ($country_id==17) )
            {
                $sql = "SELECT price FROM offer_prices_country WHERE offer_id={$offer_id} AND country_id={$country_id}";
            }
            else
            {
                $sql = "SELECT price FROM offer_prices_country WHERE offer_id={$offer_id} AND country_id=0";
            }
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $price = $row[price];
            
            
            //get pm_revenue, pub_revenue
            $sql = "
                SELECT p.id, u1.user_revenue as pub_revenue, u2.user_revenue as pm_revenue 
                FROM projects p 
                LEFT JOIN users u1 ON p.assigned_user_id=u1.id 
                LEFT JOIN users u2 ON u1.user_manager=u2.id
                WHERE p.id={$proj_id}
            ";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $pub_revenue = $row[pub_revenue];
            $pm_revenue = $row[pm_revenue];
            
            $sql = "
                INSERT INTO install_offers (`network_id`, `proj_id`, `offer_id`, `template_id`, `install_datetime`, 
                    `os_typeid`, `ip`, `download_id`, `price`, `user_id`, `manager_id` ,`pub_revenue`, `pm_revenue`,
                    `am_revenue`, `offer_shown`, `install_accepted`, `install_started`, `install_completed`, `adjust_rate`, `combo_id`, `country_id`) 
                    VALUES (-1, {$proj_id}, {$offer_id}, {$templateid}, NOW(), {$os_typeid}, {$remote_ip}, {$download_id}, 
                    {$price}, {$user_id}, {$manager_id}, {$pub_revenue}, {$pm_revenue}, {$am_revenue}, 0, 0, 0, 0, {$adjust_rate}, {$combo_id}, {$country_id}
                    );
            ";
            //var_dump($sql);exit;     
            mysqli_query($newconn, $sql);
        }
             
    }
    else
    {   
        //for install_projects
        //check record that has the download_id is already or not.
        $sql = "SELECT * FROM install_projects WHERE download_id={$download_id} AND proj_id={$proj_id}";
        $q =  mysqli_query($newconn, $sql);
        $c = mysqli_num_rows($q); 
        
        if($c==0)
        {
            $sql = "
                INSERT INTO install_projects (`proj_id`, `download_id`, `template_id`, `install_datetime`, 
                    `open_session`, `install_accepted`, `install_started`, `install_completed`) 
                    VALUES ({$proj_id}, {$download_id}, {$templateid}, NOW(), 0, 0, 0, 0
                    );
            ";
            //var_dump($sql);exit;
            mysqli_query($newconn, $sql);
            
            //update session of combo
            $sql = "UPDATE combos SET session=session+1 WHERE id={$combo_id}";
            mysqli_query($newconn, $sql);
        }
    } 
    
    if($mode == 0)
    {
        $sql = "UPDATE install_projects SET install_started=1 WHERE download_id={$download_id} AND proj_id={$proj_id} ";
        $q = mysqli_query($newconn, $sql);
    }
    else if($mode == 1)
    {
        $sql = "UPDATE install_projects SET install_completed=1 WHERE download_id={$download_id} AND proj_id={$proj_id}";
        $q = mysqli_query($newconn, $sql);
    }
    else if($mode == 2)       
    {        
        $sql = "UPDATE install_offers SET install_started=1 WHERE download_id={$download_id} AND proj_id={$proj_id} AND offer_id={$offer_id}";
        $q = mysqli_query($newconn, $sql);        
    }
    else if($mode == 3)       
    {        
        $sql = "UPDATE install_offers SET install_completed=1, install_datetime=NOW() WHERE download_id={$download_id} AND proj_id={$proj_id} AND offer_id={$offer_id}";
        $q = mysqli_query($newconn, $sql);        
    }
    else if($mode == 4)
    {
        $sql = "UPDATE install_projects SET install_accepted=1 WHERE download_id={$download_id} AND proj_id={$proj_id}";
        $q = mysqli_query($newconn, $sql);
    }
    else if($mode == 5)       
    {        
        $sql = "UPDATE install_offers SET install_accepted=1 WHERE download_id={$download_id} AND proj_id={$proj_id} AND offer_id={$offer_id}";
        $q = mysqli_query($newconn, $sql);
    }
    else if($mode == 6)
    {     
        $sql = "UPDATE install_projects SET open_session=1 WHERE download_id={$download_id} AND proj_id={$proj_id}";
        //var_dump($sql);exit;
        $q = mysqli_query($newconn, $sql);
        
    }
    else if($mode == 7)       
    {        
        $sql = "UPDATE install_offers SET offer_shown=1 WHERE download_id={$download_id} AND proj_id={$proj_id} AND offer_id={$offer_id}";
        $q = mysqli_query($newconn, $sql);
    }
}  
 
?>