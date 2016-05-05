<?php
     include '../config.php';  
     
      
     $sql = "SELECT count(id), hash FROM `projects_downloads1` where refer_url_id=0 group by hash order by count(id) desc limit 0, 5";
     $q = mysql_query($sql);

     $a = 0;
     
     while($row=mysql_fetch_assoc($q))
     { 
         $sql1 =    "SELECT id FROM refer_url WHERE hash='{$row[hash]}'";
                     //echo($sql1);echo("<br>"); exit;
         $q1 = mysql_query($sql1);
         $row1 = mysql_fetch_assoc($q1);
         $refer_id = $row1[id];
         //echo($loc_id);
         $sql2 =    "UPDATE projects_downloads1 SET refer_url_id={$refer_id} WHERE hash='{$row[hash]}'";
         //echo($sql2);
         mysql_query($sql2);
         
         $a++;

         
     }
     
     echo($a);
?>