<?php
include '../config.php';   

$sql = "SELECT pd.location_id, io.* FROM install_offers io INNER JOIN projects_downloads pd ON io.download_id=pd.id ";
//var_dump($sql);exit;
$q = mysqli_query($newconn, $sql);
while($row=mysqli_fetch_assoc($q))
{        
    $id = $row[id];
    $loc_id = $row[location_id];
    //var_dump($sql1);exit;  
    $sql2 = "SELECT id FROM geo_location 
            WHERE country=(SELECT country FROM geo_location WHERE id={$loc_id}) AND region='' AND city=''";
    $q2 = mysqli_query($newconn, $sql2);
    $row = mysqli_fetch_assoc($q2);
    $country_id = $row[id];
    
    $sql3 = "UPDATE install_offers SET country_id={$country_id} WHERE id={$id}";
    //var_dump($sql3);exit;
    mysqli_query($newconn, $sql3);
}

  
?>