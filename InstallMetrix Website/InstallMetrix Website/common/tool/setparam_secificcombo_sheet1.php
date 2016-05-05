<?php
include '../config.php';   

$bundle_id = 73;
$proj_id = 1167;
$pub_id = 114;
$fakedata_count = 17;

$cat1 = array('1032|1103|1081|1105', '1032|1103|1081', '1032|1103|1105', '1032|1049|1081|1105', '1032|1049|1081', '1032|1049|1105');
$cat2 = array('1056', '1130');
$cat3 = array('1113', '1148', '1144', '1075');
$cat4 = array('1086', '1122', '1146', '1040');
$cat5 = array('1119');
$cat6 = array('1111', '1129');
$cat7 = array('1060');
$in_arr = array($cat1, $cat2, $cat3, $cat4, $cat5, $cat6, $cat7);


/*
$cat1 = array('1032|1103|1081|1105', '1032|1103|1081', '1032|1103|1105', '1032|1049|1081|1105', '1032|1049|1081', '1032|1049|1105');
$cat2 = array('1056', '1130');
$cat3 = array('1113', '1148', '1144', '1075');
$cat4 = array('1086', '1122', '1146', '1040');
$cat6 = array('1111', '1129');
$cat7 = array('1060');
$in_arr = array($cat1, $cat2, $cat3, $cat4, $cat6, $cat7);
*/

/*
$cat1 = array('1032|1103|1081|1105', '1032|1103|1081', '1032|1103|1105', '1032|1049|1081|1105', '1032|1049|1081', '1032|1049|1105');
$cat2 = array('1056', '1130');
$cat3 = array('1113', '1148', '1144', '1075');
$cat4 = array('1086', '1122', '1146', '1040');
$cat5 = array('1119');
$cat6 = array('1111', '1129');
$in_arr = array($cat1, $cat2, $cat3, $cat4, $cat5, $cat6);
*/

/*
$cat1 = array('1032|1103|1081|1105', '1032|1103|1081', '1032|1103|1105', '1032|1049|1081|1105', '1032|1049|1081', '1032|1049|1105');
$cat2 = array('1056', '1130');
$cat3 = array('1113', '1148', '1144', '1075');
$cat4 = array('1086', '1122', '1146', '1040');
$cat6 = array('1111', '1129');
$in_arr = array($cat1, $cat2, $cat3, $cat4, $cat6);
*/

$size_in = sizeof($in_arr);
$size_cat_arr = array();
$indexs_in_cat = array();

foreach($in_arr as $in)
{
    array_push($size_cat_arr, sizeof($in));
    array_push($indexs_in_cat, 0);
}

$combo_arr = array();
$flag = true;
                      
while($flag==true)
{            
    for($pos=$size_in-1; $pos>0;$pos--)
    {               
        if($indexs_in_cat[$pos]>=$size_cat_arr[$pos])
        {
            $indexs_in_cat[$pos] = 0;
            $indexs_in_cat[$pos-1]++;         
        }
    }
    
    if($indexs_in_cat[0]>=$size_cat_arr[0])
    {
        $flag = false;
    }
    else
    {

        $combo_str = "";
        for($kk=0;$kk<$size_in;$kk++)
        {
            //echo($indexs_in_cat[$kk]); echo("|");    
            $combo_str .= $in_arr[$kk][$indexs_in_cat[$kk]] . "|";
        }
        $combo_str = substr($combo_str,0,-1); 
        
        //echo($combo_str);
        //echo("<br>");  
        
        array_push($combo_arr, $combo_str);

    }                        
    $indexs_in_cat[$size_in-1]++;            
}

//get auto optimizer term
$sql_t = "SELECT field_value FROM network_setting WHERE field_name='auto_optimizer_term'";

$q_t = mysqli_query($newconn, $sql_t);
$row_t = mysqli_fetch_assoc($q_t);
$term = (int)$row_t[field_value];


//check combo session and rpobc

$kkk = 0;
$kkkkk = 0;
foreach($combo_arr as $combo)
{
    $kkkkk++;
    if($kkk>=15) break;
    
    $sql = "SELECT id, session FROM combos WHERE combo='{$combo}'";      
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
    
    $combo_id = $row[id];
    //echo($sql); var_dump($combo_id);exit;
    $cc = 0;
    if($combo_id == NULL) 
    {
        echo($combo . "<br>");
        //insert combo
        $sql = "INSERT INTO combos(bundle_id, combo, session) VALUES ({$bundle_id}, '{$combo}', 17)";
        //echo($sql);exit;      
        mysqli_query($newconn, $sql);                
        $combo_id = mysqli_insert_id($newconn);
        
        $cc = $fakedata_count;
        
        $kkk++;
    
        /*
        for($i=0;$i<$fakedata_count;$i++)
        {
            //insert into projects_downloads
            $sql = "INSERT INTO projects_downloads(proj_id) VALUES ({$proj_id})";        
            mysqli_query($newconn, $sql);
            $download_id = mysqli_insert_id($newconn);
            
            //insert into install_projects
            $sql = "INSERT INTO install_projects(proj_id, download_id) VALUES ({$proj_id}, {$download_id})";    
            mysqli_query($newconn, $sql);
            
            //insert into install_offers 
            $offer_arr = explode("|", $combo);
            $sql_insert = "INSERT INTO install_offers(proj_id, offer_id, install_datetime, download_id, price, user_id, manager_id, offer_shown, install_accepted, install_started, install_completed, adjust_rate, combo_id) VALUES";       
            foreach($offer_arr as $offer_id)
            {
                $sql = "SELECT o.*, u.id as user_id, u.user_manager as manager_id FROM offers o, users u WHERE o.id={$offer_id} AND u.id=o.assigned_user_id";
                $q = mysqli_query($newconn, $sql);
                $row = mysqli_fetch_assoc($q);
                $price = $row[offer_price];
                $adjust_rate = $row[adjust_rate];
                $user_id = $row[user_id];
                $manager_id = $row[manager_id];
                
                $sql_insert .= "({$proj_id}, {$offer_id}, NOW(), {$download_id}, {$price}, {$user_id}, {$manager_id}, 1, 1, 1, 1, {$adjust_rate}, {$combo_id}),";
            }
            
            $sql_insert = substr($sql_insert,0,-1); 
            //echo($sql_insert);exit;      
            mysqli_query($newconn, $sql_insert);
        }
        */
    }
    else    //combo is already existed
    {
        $cc = $row[session];
        /*
        $sql = "SELECT io.combo_id, count(io.id) as cc, sum(io.price) as revenue 
                FROM 
                    (   SELECT combo_id, id, sum(install_completed*price*adjust_rate/100) as price
                        FROM install_offers
                        WHERE   install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$term} DAY) AND                
                                install_datetime < DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY) AND
                                combo_id = (SELECT id FROM combos WHERE id={$combo_id}) 
                        GROUP BY download_id, combo_id 
                    ) io 
                GROUP BY io.combo_id                     
                ";
                          
        //echo("<textarea>" . $sql . "</textarea>");exit;
    
        $q = mysqli_query($newconn, $sql); 
        $row = mysqli_fetch_assoc($q);
        $cc = $row[cc];
        */
        //echo($row[combo_id] . "===" . $row[cc] . "__" . $row[revenue]/$row[cc] . "<br>" );
        //update combo
        if($cc<17)
        {
            $cc = 17 - $cc;      $kkk++;    echo($combo . "-------------------- <br>");   
        }
        else
        {
            $cc = 0;
        }
        
        $sql = "UPDATE combos SET session=session+{$cc} WHERE id={$combo_id}";
        mysqli_query($newconn,$sql);  
       
               
    }
    
    for($i=0;$i<$cc;$i++)
    {
        //insert into projects_downloads
        $sql = "INSERT INTO projects_downloads(proj_id) VALUES ({$proj_id})";        
        mysqli_query($newconn, $sql);
        $download_id = mysqli_insert_id($newconn);
        
        //insert into install_projects
        $sql = "INSERT INTO install_projects(proj_id, download_id) VALUES ({$proj_id}, {$download_id})";    
        mysqli_query($newconn, $sql);
        
        //insert into install_offers 
        $offer_arr = explode("|", $combo);
        $sql_insert = "INSERT INTO install_offers(proj_id, offer_id, install_datetime, download_id, price, user_id, manager_id, offer_shown, install_accepted, install_started, install_completed, adjust_rate, combo_id) VALUES";       
        foreach($offer_arr as $offer_id)
        {
            $sql = "SELECT o.*, u.id as user_id, u.user_manager as manager_id FROM offers o, users u WHERE o.id={$offer_id} AND u.id=o.assigned_user_id";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $price = $row[offer_price];
            $adjust_rate = $row[adjust_rate];
            $user_id = $row[user_id];
            $manager_id = $row[manager_id];
            
            $sql_insert .= "({$proj_id}, {$offer_id}, NOW(), {$download_id}, {$price}, {$user_id}, {$manager_id}, 1, 1, 1, 1, {$adjust_rate}, {$combo_id}),";
        }
        
        $sql_insert = substr($sql_insert,0,-1); 
        //echo($sql_insert);exit;      
        mysqli_query($newconn, $sql_insert);
    }
}

echo($kkkkk);


?>