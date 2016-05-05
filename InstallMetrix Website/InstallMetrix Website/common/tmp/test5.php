<?php
     include '../config.php';  
     
      
     $sql = "SELECT count(id) as count, download_country_code, download_region, download_city FROM `projects_downloads1` where location_id=0 group by download_country_code, download_region, download_city ORDER BY count  DESC LIMIT 1,20";
     $q = mysql_query($sql);

     $a = 0;
     
     while($row=mysql_fetch_assoc($q))
     {
         
         if($a>=10)
         {
             var_dump($a);exit;
         }
  
         $sql1 =    "SELECT id FROM location WHERE country_code='{$row[download_country_code]}' AND 
                     region='{$row[download_region]}' AND city='{$row[download_city]}'";
                     //echo($sql1);echo("<br>");
         $q1 = mysql_query($sql1);
         $row1 = mysql_fetch_assoc($q1);
         $loc_id = $row1[id];
         //echo($loc_id);
         $sql2 =    "UPDATE projects_downloads1 SET location_id={$loc_id} WHERE download_country_code='{$row[download_country_code]}' AND 
                    download_region='{$row[download_region]}' AND download_city='{$row[download_city]}'";
         //echo($sql2);
         mysql_query($sql2);
         
         $a++;

         
     }
     
     echo($a);
?>