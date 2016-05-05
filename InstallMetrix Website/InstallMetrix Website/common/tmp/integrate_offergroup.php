<?php
     include '../config.php';  
     
     // get offer group
     
     $sql = "SELECT * FROM offergroups";
     $q = mysql_query($sql);
     while($row=mysql_fetch_assoc($q))
     {
         $group_id = $row[id];
         $group_name = $row[name];
         $group_desc = $row[description];
         $group_time = $row[offergroup_datetime];
         $group_status = $row[status];
         
         //insert into offer
         $sql1 = "  INSERT INTO offers(user_id, assigned_user_id, offer_datetime, offer_name, offer_description, status, offergroup_id) VALUES 
                    (0, 0, '{$group_time}', '{$group_name}', '{$group_desc}', {$group_status}, {$group_id} )";
         mysql_query($sql1);
         
         $id = mysql_insert_id();
         //change the offergroupid to new offerid on bundle_offers and offer_categories table
         
         $sql2 = "UPDATE bundle_offers SET offer_id={$id} WHERE offer_id={$group_id}";
         mysql_query($sql2);
         
         $sql2 = "UPDATE offer_categories SET offer_id={$id} WHERE offer_id={$group_id}";
         mysql_query($sql2);
         
         echo($group_id);echo("<br>");
     }
     
?>