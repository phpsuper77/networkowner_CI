<?php
include '../common/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
}

if($_REQUEST[mode] == "getoffersstable_by_bundle_category")
{
    $bundle_id = $_REQUEST[bundle_id];//campign id
    $cat_id = $_REQUEST[cat_id]; //category id
    
    $str = '<table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>OID</th>
                            <th>Company Name</th>
                            <th>Offer Name</th>
                            <th>Activation</th>                                                        
                        </tr>
                    </thead>
                    <tbody>';

                    
    //identify offer or group
    $sql = "SELECT oc.offer_id, oc.isgroup, bo.isactive 
            FROM (SELECT * FROM offer_categories where category_id={$cat_id}) oc 
            LEFT JOIN (SELECT * FROM bundle_offers WHERE bundle_id={$bundle_id} AND cat_id={$cat_id}) bo
            ON oc.offer_id=bo.offer_id";
                  
    $q = mysqli_query($newconn, $sql);
    
    //var_dump($sql);exit;
    
    while($row = mysqli_fetch_assoc($q))
    {
        //var_dump($row);
        if($row[isgroup]==0)
        {
            //this is offer
            $sql1 = "   SELECT o.id as offer_id, o.offer_name, u.user_company_name 
                        FROM offers o 
                        LEFT JOIN  users u ON o.assigned_user_id=u.id                         
                        WHERE o.id={$row[offer_id]} AND offer_show=1 AND status=0";
            //var_dump($sql1);exit;     
            $q1 = mysqli_query($newconn, $sql1); 
            $cc1 = mysqli_num_rows($q1);
            if($cc1 == 0) continue;
            $row1 = mysqli_fetch_assoc($q1);
    
            $str = $str . '<tr class="odd gradeX"><td class="highlight"><a href="offer_edit.php?oid=' . $row1[offer_id] . '"><div class="success"></div>' . $row1[offer_id] . '</a></td>';
            $str = $str . '<td>' . $row1[user_company_name] . '</td>';
            $str = $str . '<td>' . $row1[offer_name] . '</td>';              
                                           
            $str = $str . '<td><input type="checkbox" name="offers[]" value="';
            $str = $str . $row1[offer_id] . '|0"';
            if($row[isactive] == 1)
            {
                $str .= "checked";
            }
            
            $str .= ' > </td></tr>';
          
        }
        else
        {
            //this is group           
            
            $sql1 = "   SELECT og.id as group_id, og.name FROM offergroups og 
                        WHERE og.id={$row[offer_id]} AND og.status=0";
            //var_dump($sql);exit;
            $q1 = mysqli_query($newconn, $sql1);                               
            $row1 = mysqli_fetch_assoc($q1); 
            
            $cc = mysqli_num_rows($q1);
            if($cc==0) continue;
                                                           
            $str = $str . '<tr class="odd gradeX"><td class="highlight"><a href="offergroup_edit.php?id=' . $row1[group_id] . '"><div class="success"></div>' . $row1[group_id] . '</a></td>';
            $str = $str . '<td>' . '&nbsp;' . '</td>';
            $str = $str . '<td>' . $row1[name] . '</td>';
            $str = $str . '<td><input type="checkbox" name="offers[]" value="';
            $str = $str . $row1[group_id] . '|1"';            
            if($row[isactive] == 1)
            {
                $str .= ' checked';
            }
            $str .= ' > </td></tr>'; 

        }
    }
    $str = $str . '</tbody> </table>';
    echo($str);
}
?>
