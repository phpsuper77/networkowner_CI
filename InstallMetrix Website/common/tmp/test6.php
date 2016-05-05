<?php
     include '../config.php';  
     
      
     $sql = "SELECT download_os FROM `projects_downloads1` group by download_os limit 7, 8";
     $q = mysql_query($sql);

     $a = 0;
     
     while($row=mysql_fetch_assoc($q))
     {
         
         
  
         $sql1 =    "SELECT id FROM os_type WHERE os_name='{$row[download_os]}' AND os_additional='' AND os_build=''";
                     //echo($sql1);echo("<br>");
         $q1 = mysql_query($sql1);
         $row1 = mysql_fetch_assoc($q1);
         $os_id = $row1[id];
         //echo($loc_id);
         $sql2 =    "UPDATE projects_downloads1 SET os_typeid={$os_id} WHERE download_os='{$row[download_os]}'";
         //echo($sql2);
         mysql_query($sql2);
         
         $a++;

         
     }
     
     echo($a);
?>