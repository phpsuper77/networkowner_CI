<?php

include '../config.php';

function GetSubXmlSoftware($download_id, $my_common_path, $common_path_url)
{
    global $newconn;  
    $html_path = $my_common_path . "interface/htmls/";
    $html_url = $common_path_url . "interface/htmls/";
    //for software
    $sql = "SELECT u.subid, p.* FROM projects p, projects_downloads pd, users u WHERE p.assigned_user_id=u.id AND p.id=pd.proj_id AND pd.id={$download_id}";
 
    //var_dump($sql); exit;    
    
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q); 
    
    

    foreach ($row as $key => $value) {
        $row[$key] = htmlspecialchars($value);
    }
  
    $proj_id = $row[id]; 
    $pub_id = $row[assigned_user_id]; 
    $pub_subid = $row[subid];
    
    
    ///// make template html
    $sql = "SELECT * FROM template_campaigns WHERE camp_id={$proj_id}";
    $q = mysqli_query($newconn, $sql);
    $count_template = mysqli_num_rows($q);
    $rand_val = rand(0,$count_template-1);
    $index = 0;
    $template_id = -1;
    while ($row = mysqli_fetch_assoc($q))
    {           
        if($rand_val==$index)
        {
            $template_id = $row[template_id];
            break;
        }
        $index++;
    }
    
    //var_dump($template_id);exit;
    
    $sql = "SELECT * FROM templates WHERE id={$template_id}";
    
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
        
    $main_path = $row[maintemplate_filepath];
    $download_path = $row[downloadtemplate_filepath];
    $thank_path = $row[thanktemplate_filepath];
    
    
    $sql_p = "SELECT * FROM projects WHERE id={$proj_id}";
    $q_p = mysqli_query($newconn,$sql_p);
    $row_p = mysqli_fetch_assoc($q_p);
    
    $logo_url = $common_path_url . "installer_logos/" . $proj_id . ".jpg"; 
    
    //get software description for template 
    $desc_for_template = $row[camp_description];
         
    {
    //make main template html      
    
    $homepage = file_get_contents($main_path);    
    
    if($row_p[software_tos_url] == "")
        $homepage = str_replace("@tos_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@tos_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_pp_url] == "")
        $homepage = str_replace("@pp_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@pp_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_eula_url] == "")
        $homepage = str_replace("@eula_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@eula_url_enable@", "return true;", $homepage); 

    $strdesc =  $desc_for_template;     
    
    $strdesc = str_replace("\\r\\n","",$strdesc);
    $strdesc = str_replace("\\","",$strdesc);  
    $strdesc = str_replace("@campaigndescription@", $row_p[proj_description], $strdesc);   
      
    
    $homepage = str_replace("@description@", $strdesc, $homepage);
    
    $homepage = str_replace("@logo_image@", $logo_url, $homepage);
    $homepage = str_replace("@title@", $row_p[software_name] , $homepage);
    $homepage = str_replace("@version@", $row_p[software_version] , $homepage);        
    $homepage = str_replace("@tos_url@", $row_p[software_tos_url], $homepage); 
    $homepage = str_replace("@pp_url@", $row_p[software_pp_url], $homepage); 
    $homepage = str_replace("@eula_url@", $row_p[software_eula_url], $homepage); 
    $homepage = str_replace("@campaigndescription@", $row_p[proj_description], $homepage); 
    
    $main_homepage = $homepage;
    //$homepage_path = $html_path . "main-" . $download_id . ".htm";
    //file_put_contents($homepage_path, $homepage); 
    
    
    //var_dump($homepage);exit;
    
    //$main_homepage_url = $html_url . "main-" . $download_id . ".htm";   
     
    }
    
    {
    //make download template html          
    $homepage = file_get_contents($download_path);    
    
    if($row_p[software_tos_url] == "")
        $homepage = str_replace("@tos_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@tos_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_pp_url] == "")
        $homepage = str_replace("@pp_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@pp_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_eula_url] == "")
        $homepage = str_replace("@eula_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@eula_url_enable@", "return true;", $homepage); 

    $strdesc =  $row_p[software_description];        
    $strdesc = str_replace("\\r\\n","",$strdesc);
    $strdesc = str_replace("\\","",$strdesc);
    $strdesc = str_replace("@campaigndescription@", $row_p[proj_description], $strdesc);   
    
    $homepage = str_replace("@logo_image@", $logo_url, $homepage);
    $homepage = str_replace("@title@", $row_p[software_name] , $homepage);
    $homepage = str_replace("@version@", $row_p[software_version] , $homepage);        
    $homepage = str_replace("@description@", $strdesc, $homepage);
    $homepage = str_replace("@tos_url@", $row_p[software_tos_url], $homepage); 
    $homepage = str_replace("@pp_url@", $row_p[software_pp_url], $homepage); 
    $homepage = str_replace("@eula_url@", $row_p[software_eula_url], $homepage); 
    $homepage = str_replace("@campaigndescription@", $row_p[proj_description], $homepage);
    
    //$homepage_path = $html_path . "download-" . $download_id . ".htm";
    //file_put_contents($homepage_path, $homepage); 
    
    //$download_homepage_url = $html_url . "download-" . $download_id . ".htm";  
    $download_homepage = $homepage;
    }
    
    {
    //make thank template html          
    $homepage = file_get_contents($thank_path);    
    
    if($row_p[software_tos_url] == "")
        $homepage = str_replace("@tos_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@tos_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_pp_url] == "")
        $homepage = str_replace("@pp_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@pp_url_enable@", "return true;", $homepage); 
        
    if($row_p[software_eula_url] == "")
        $homepage = str_replace("@eula_url_enable@", "return false;", $homepage); 
    else
        $homepage = str_replace("@eula_url_enable@", "return true;", $homepage); 

    $strdesc =  $row_p[software_description];        
    $strdesc = str_replace("\\r\\n","",$strdesc);
    $strdesc = str_replace("\\","",$strdesc);
    $strdesc = str_replace("@campaigndescription@", $row_p[proj_description], $strdesc);   
    
    $homepage = str_replace("@logo_image@", $logo_url, $homepage);
    $homepage = str_replace("@title@", $row_p[software_name] , $homepage);
    $homepage = str_replace("@version@", $row_p[software_version] , $homepage);        
    $homepage = str_replace("@description@", $strdesc, $homepage);
    $homepage = str_replace("@tos_url@", $row_p[software_tos_url], $homepage); 
    $homepage = str_replace("@pp_url@", $row_p[software_pp_url], $homepage); 
    $homepage = str_replace("@eula_url@", $row_p[software_eula_url], $homepage); 
    $homepage = str_replace("@campaigndescription@", $row_p[proj_description], $homepage);
    
    //$homepage_path = $html_path . "thank-" . $download_id . ".htm";
    //file_put_contents($homepage_path, $homepage); 
    
    //$thank_homepage_url = $html_url . "thank-" . $download_id . ".htm";  
    
    $thank_homepage = $homepage;
    }
    $str_projdesc = $strdesc;
    
    
    //// select exit url
    $sql = "SELECT * FROM exiturl_campaigns WHERE proj_id={$proj_id}";
    $q = mysqli_query($newconn, $sql);
    $count_exiturl = mysqli_num_rows($q);
    $rand_val = rand() % $count_exiturl;
    $index = 0;
    $exiturl_id = -1;
    while ($row = mysqli_fetch_assoc($q))
    {           
        if($rand_val==$index)
        {
            $exiturl_id = $row[exiturl_id];
            break;
        }
        $index++;
    }
    $sql = "SELECT exiturl FROM exiturl WHERE id={$exiturl_id}";
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
    $exiturl = $row[exiturl];
    
    $msg .= "<application>";
    $msg .= "<software_id>" . $proj_id . "</software_id>";    
    $msg .= "<software_name>" . $row_p[software_name] . "</software_name>"; 
    $msg .= "<software_url>" . $row_p[software_url] . "</software_url>";
    
    $slient = str_replace("@pubid@", $pub_id, $row_p[software_silent]); 
    $msg .= "<software_silent>" . $slient . "</software_silent>";     
    $msg .= "<software_templateid>" . $template_id . "</software_templateid>"; 
    $msg .= "<software_html1>" . $main_homepage . "</software_html1>";     
    $msg .= "<software_html2>" . $download_homepage . "</software_html2>";     
    $msg .= "<software_html3>" . $thank_homepage . "</software_html3>";     
    $msg .= "<software_exiturl>" . $exiturl . "</software_exiturl>";  
    $msg .= "</application>";   
    
    return $msg; 
}

function GetSubXmlOffers($proj_id, $combo)
{
    global $newconn;  
    //var_dump($combo);echo("<br>");echo("<br>");echo("<br>");
    //var_dump($combo); exit;
    $arr_offers = $combo[combo_arr];
    
    $offer_count = sizeof($arr_offers);
    $msg = "";
       
    //get projects info
    $sql_p = "SELECT p.*, u.subid FROM projects p LEFT JOIN users u ON p.assigned_user_id=u.id WHERE p.id={$proj_id}";
    //var_dump($sql_p);exit;
    $q_p = mysqli_query($newconn, $sql_p);
    $row_p = mysqli_fetch_assoc($q_p);
    $pub_subid = $row_p[subid];
    //get offers information for the combo
    for($xx=0;$xx<$offer_count;$xx++)
    {
        $offer_tmp = $arr_offers[$xx]; //array of offers for the category
        if($offer_tmp[0] > 10000000)
        {
            //this is offergroup
            $group_id = $offer_tmp[0] - 10000000;
            $sql_group = "SELECT * FROM offergroups WHERE id={$group_id}";
            
            $q_group = mysqli_query($newconn, $sql_group);
            $row_group = mysqli_fetch_assoc($q_group);
                 
            $msg .= "<group>";
            $msg .= "<group_name>" . $row_group[name] . "</group_name>";
                        
            /// replace key in group description                                
            $group_desc = $row_group[description]; 
            $group_desc = str_replace("@title@", $row_p[software_name] , $group_desc);
            $group_desc = str_replace("@version@", $row_p[software_version] , $group_desc); 
            $group_desc = str_replace("@campaigndescription@", $row_p[proj_description], $group_desc);    
                              
                       
            $msg .= "<group_description>" . $group_desc . "</group_description>";  
            
            $offer_id_arr = array($row_group[offer1_id],$row_group[offer2_id],$row_group[offer3_id],$row_group[offer4_id],$row_group[offer5_id]);
            $isdefault_arr = array($row_group[isdefault_1],$row_group[isdefault_2],$row_group[isdefault_3],$row_group[isdefault_4],$row_group[isdefault_5]);
            $isinstallneeded = array();
            
            $yy = FindItemFromArray($row_group[offer1_id], $offer_tmp);
            array_push($isinstallneeded, $yy);            
            $yy = FindItemFromArray($row_group[offer2_id], $offer_tmp);
            array_push($isinstallneeded, $yy);
            $yy = FindItemFromArray($row_group[offer3_id], $offer_tmp);
            array_push($isinstallneeded, $yy);
            $yy = FindItemFromArray($row_group[offer4_id], $offer_tmp);
            array_push($isinstallneeded, $yy);
            $yy = FindItemFromArray($row_group[offer5_id], $offer_tmp);
            array_push($isinstallneeded, $yy);
            
            //get count of offers in the group
            $count_offer_in_group = 0;
            for($i=0;$i<5;$i++)
            {
                if($offer_id_arr[$i] == 0)
                {
                    break;
                }
                $count_offer_in_group++;
            }
            $msg .= "<offercount>" . $count_offer_in_group . "</offercount>"; 
             
            
            for($i=0;$i<5;$i++)
            {
                if($offer_id_arr[$i] != 0)
                {
                    $msg .= "<offer_application>"; 
                    $msg .= "<isdefault>" . $isdefault_arr[$i] . "</isdefault>";
                    $msg .= "<offer_id>" . $offer_id_arr[$i] . "</offer_id>";
                    if($isinstallneeded[$i] == -1)
                    {
                        //this offer is not able to install. so no needs to get other info for this offer
                        $msg .= "<isinstallneeded>0</isinstallneeded>";                        
                    }
                    else
                    {
                        $msg .= "<isinstallneeded>1</isinstallneeded>";                        
                        //get offer1
                        $sql_offer = "SELECT * FROM offers WHERE id={$offer_id_arr[$i]}";
                        $q_offer = mysqli_query($newconn, $sql_offer);
                        $row_offer = mysqli_fetch_assoc($q_offer);
                        
                        $msg .= "<offer_name>" . $row_offer[offer_name] . "</offer_name>";                           
                        $msg .= "<offer_url>" . $row_offer[offer_url] . "</offer_url>";
                        
                        /// slient keys
                        $slient = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main]); 
                        $slient1 = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main1]); 
                        
                        $tmp_ran = rand(0, 100);
                        if(($tmp_ran < 50) || ($slient1 == NULL))
                        {
                            
                        }
                        else
                        {
                            $slient = $slient1;
                        }
                        
                        $msg .= "<offer_silent_main>" . $slient . "</offer_silent_main>";
                        
                        $msg .= "<offer_silent_check1_on>" . $row_offer[offer_silent_check1_on] . "</offer_silent_check1_on>";
                        $msg .= "<offer_silent_check1_off>" . $row_offer[offer_silent_check1_off] . "</offer_silent_check1_off>";
                        $msg .= "<offer_silent_check2_on>" . $row_offer[offer_silent_check2_on] . "</offer_silent_check2_on>";
                        $msg .= "<offer_silent_check2_off>" . $row_offer[offer_silent_check2_off] . "</offer_silent_check2_off>";
                        $msg .= "<offer_silent_check3_on>" . $row_offer[offer_silent_check3_on] . "</offer_silent_check3_on>";
                        $msg .= "<offer_silent_check3_off>" . $row_offer[offer_silent_check3_off] . "</offer_silent_check3_off>";
                        $msg .= "<offer_silent_check4_on>" . $row_offer[offer_silent_check4_on] . "</offer_silent_check4_on>";
                        $msg .= "<offer_silent_check4_off>" . $row_offer[offer_silent_check4_off] . "</offer_silent_check4_off>";
                        $msg .= "<offer_silent_check5_on>" . $row_offer[offer_silent_check5_on] . "</offer_silent_check5_on>";
                        $msg .= "<offer_silent_check5_off>" . $row_offer[offer_silent_check5_off] . "</offer_silent_check5_off>";
                         
                        $sql_check = "SELECT method_name FROM checkinstalled_method WHERE id={$row_offer[checkinstalled_method]}";
                        $q_check = mysqli_query($newconn, $sql_check);
                        $row_check = mysqli_fetch_assoc($q_check);                                                                     
                                                
                        $msg .= "<checkinstalled_method>" . $row_check[method_name] . "</checkinstalled_method>";                                          
                        $row_offer[reg_path_post] = str_replace("\\\\","\\",$row_offer[reg_path_post]);
                        $row_offer[reg_path_post] = str_replace("\r\n","",$row_offer[reg_path_post]);
                        $msg .= "<offer_registry_path_post>" . $row_offer[reg_path_post] . "</offer_registry_path_post>";
                        $row_offer[reg_path_64_post] = str_replace("\\\\","\\",$row_offer[reg_path_64_post]);
                        $row_offer[reg_path_64_post] = str_replace("\r\n","",$row_offer[reg_path_64_post]);
                        $msg .= "<offer_registry_path_64_post>" . $row_offer[reg_path_64_post] . "</offer_registry_path_64_post>";                         
                    }
                    
                    $msg .= "</offer_application>";                  
                    
                    
                }
                else
                {
                    //offer id is null
                    break;
                }            
            }
            $msg .= "</group>";                     
        }
        else
        {
            // this is offer
            $offer_id = $offer_tmp[0];
            
            $sql_offer = "SELECT * FROM offers WHERE id={$offer_id}";
            $q_offer = mysqli_query($newconn, $sql_offer);                 
            $row_offer = mysqli_fetch_assoc($q_offer);
             
            $msg .= "<offer_application>";
            $msg .= "<isdefault>1</isdefault>";            
            $msg .= "<offer_id>" . $row_offer[id] . "</offer_id>";
            $msg .= "<isinstallneeded>1</isinstallneeded>";                        
            $msg .= "<offer_name>" . $row_offer[offer_name] . "</offer_name>"; 
            
               
            //$xmlmsg .= "<offer_desc>" .  htmlspecialchars( $row_offer[offer_description], ENT_QUOTES ) . "</offer_desc>";
            
            //$row_offer[offer_description] = str_replace("\"","&quot;",$row_offer[offer_description]);
            
            /// replace key to contents in offer description
            
            $homepage = $row_offer[offer_description];
            if($row_offer[offer_tos_url] == "")
                $homepage = str_replace("@tos_url_enable@", "return false;", $homepage); 
            else
                $homepage = str_replace("@tos_url_enable@", "return true;", $homepage); 
                
            if($row_offer[offer_pp_url] == "")
                $homepage = str_replace("@pp_url_enable@", "return false;", $homepage); 
            else
                $homepage = str_replace("@pp_url_enable@", "return true;", $homepage); 
                
            if($row_offer[offer_eula_url] == "")
                $homepage = str_replace("@eula_url_enable@", "return false;", $homepage); 
            else
                $homepage = str_replace("@eula_url_enable@", "return true;", $homepage); 
            
            $homepage = str_replace("@logo_image@", $logo_url, $homepage);
            $homepage = str_replace("@title@", $row_p[software_name] , $homepage);
            $homepage = str_replace("@version@", $row_p[software_version] , $homepage);        
            $homepage = str_replace("@tos_url@", $row_offer[offer_tos_url], $homepage); 
            $homepage = str_replace("@pp_url@", $row_offer[offer_pp_url], $homepage); 
            $homepage = str_replace("@eula_url@", $row_offer[offer_eula_url], $homepage); 
            $homepage = str_replace("@campaigndescription@", $row_p[proj_description], $homepage);  
            ///
            
            $msg .= "<offer_desc>" . $homepage . "</offer_desc>";
            $msg .= "<offer_url>" . $row_offer[offer_url] . "</offer_url>";
            
            /// slient keys
            $slient = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main]); 
            $slient1 = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main1]); 
            $slient2 = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main2]); 
            $slient3 = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main3]); 
                        
            $tmp_ran = rand(0, 100);
            if(($tmp_ran > 75 ) && ($slient3 != NULL))
            {
                $slient = $slient3;
            }
            else if(($tmp_ran > 66 ) && ($slient2 != NULL))
            {
                $slient = $slient2;
            }
            else if(($tmp_ran > 50 ) && ($slient1 != NULL))
            {
                $slient = $slient1;
            }
            
            $msg .= "<offer_silent_main>" . $slient . "</offer_silent_main>";            
            
            $msg .= "<offer_silent_check1_on>" . $row_offer[offer_silent_check1_on] . "</offer_silent_check1_on>";
            $msg .= "<offer_silent_check1_off>" . $row_offer[offer_silent_check1_off] . "</offer_silent_check1_off>";
            $msg .= "<offer_silent_check2_on>" . $row_offer[offer_silent_check2_on] . "</offer_silent_check2_on>";
            $msg .= "<offer_silent_check2_off>" . $row_offer[offer_silent_check2_off] . "</offer_silent_check2_off>";
            $msg .= "<offer_silent_check3_on>" . $row_offer[offer_silent_check3_on] . "</offer_silent_check3_on>";
            $msg .= "<offer_silent_check3_off>" . $row_offer[offer_silent_check3_off] . "</offer_silent_check3_off>";
            $msg .= "<offer_silent_check4_on>" . $row_offer[offer_silent_check4_on] . "</offer_silent_check4_on>";
            $msg .= "<offer_silent_check4_off>" . $row_offer[offer_silent_check4_off] . "</offer_silent_check4_off>";
            $msg .= "<offer_silent_check5_on>" . $row_offer[offer_silent_check5_on] . "</offer_silent_check5_on>";
            $msg .= "<offer_silent_check5_off>" . $row_offer[offer_silent_check5_off] . "</offer_silent_check5_off>";
            
            ///
            $sql_check = "SELECT method_name FROM checkinstalled_method WHERE id={$row_offer[checkinstalled_method]}";
            $q_check = mysqli_query($newconn, $sql_check);
            $row_check = mysqli_fetch_assoc($q_check);
            
            $msg .= "<checkinstalled_method>" . $row_check[method_name] . "</checkinstalled_method>";
            
            $row_offer[reg_path_post] = str_replace("\\\\","\\",$row_offer[reg_path_post]);
            $row_offer[reg_path_post] = str_replace("\r\n","",$row_offer[reg_path_post]);
            $msg .= "<offer_registry_path_post>" . $row_offer[reg_path_post] . "</offer_registry_path_post>";
            $row_offer[reg_path_64_post] = str_replace("\\\\","\\",$row_offer[reg_path_64_post]);
            $row_offer[reg_path_64_post] = str_replace("\r\n","",$row_offer[reg_path_64_post]);
            $msg .= "<offer_registry_path_64_post>" . $row_offer[reg_path_64_post] . "</offer_registry_path_64_post>";
            
            $msg .= "</offer_application>";
        }
        
    } 
        
    return $msg; 
}

function FindItemFromArray($item, $arr)
{
    if($item == 0) return -1;
    
    $arr_res = array();
    $pos1 = 0;
    foreach($arr as $arr_item)
    {   
        if($arr_item == $item) 
        {
            return $pos1;
        }
        $pos1++;
    }
    return -1;
}

function Get_OpenSession_Revenue_OfAllCombos($isTestMode, $all_bundles, $all_offers)
{   
    global $newconn;  
    
    $ret_arr = array();
    
    $test_combo = "";
    $opt_comb = "";
    
    //get max session
    $sql_m = "SELECT field_value FROM network_setting WHERE field_name='max_testcombo_opensession'";
    $q_m = mysqli_query($newconn, $sql_m);
    $row_m = mysqli_fetch_assoc($q_m);
    $max_session = $row_m[field_value];
    
    //get all bundles for this campaign
    $all_bundles_str = "";
              
    foreach($all_bundles as $bundle)
    {
        $all_bundles_str .= $bundle . ",";
    }
    
    if($all_bundles_str == "")
        return NULL;
    
    $all_bundles_str = substr($all_bundles_str,0,-1);
    
    //get auto optimizer term
    $sql_t = "SELECT field_value FROM network_setting WHERE field_name='auto_optimizer_term'";
    
    $q_t = mysqli_query($newconn, $sql_t);
    $row_t = mysqli_fetch_assoc($q_t);
    $term = (int)$row_t[field_value];
      
    //return value : array [combo_id, combo, session, revenue, bundle_id]
 
    /*
    $sql_or = " 
    SELECT c.id as combo_id, c.combo, c.session, io1.cc as session_r, io1.revenue, (io1.revenue/io1.cc) as rpobc, c.bundle_id 
    FROM combos c
    LEFT JOIN
        (   SELECT io.combo_id, count(io.id) as cc, sum(io.price) as revenue 
            FROM 
                (   SELECT combo_id, id, sum(install_completed*price*adjust_rate/100) as price
                    FROM install_offers
                    WHERE   install_datetime >= DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL {$term} DAY) AND                
                            install_datetime < DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00'), INTERVAL 1 DAY)
                    GROUP BY download_id, combo_id 
                ) io 
            GROUP BY io.combo_id
        ) io1
    ON io1.combo_id=c.id
    WHERE c.bundle_id IN ({$all_bundles_str})
    ORDER BY (io1.revenue/io1.cc) DESC 
    "; 
    */
    
    $sql_or = "SELECT id as combo_id, combo, session, rpobc, bundle_id FROM combos WHERE bundle_id IN ({$all_bundles_str}) ORDER BY rpobc DESC";
    
    //echo("<textarea>" . $sql_or . "</textarea>");exit;
    $q_or = mysqli_query($newconn, $sql_or);
    
    while($row_or=mysqli_fetch_assoc($q_or))
    { 
        //check this combo is eligible or not
        //echo($row_or[combo]);
        $comb_offers = explode("|", $row_or[combo]);
        $containsAllValues = !array_diff($comb_offers, $all_offers);
        
        if(!$containsAllValues) continue;
          
        if($isTestMode == 0)
        {
            //opt_mode
            if((int)$row_or[session]>=$max_session)
            {
                $opt_combo = $row_or[combo];
                $ret_arr[combo] = $opt_combo;
                $ret_arr[combo_id] = $row_or[combo_id];
                $ret_arr[bundle_id] = $row_or[bundle_id];
                $ret_arr[session] = $row_or[session];
                $ret_arr[rpobc] = $row_or[rpobc];
                return $ret_arr;
            }
            else if($test_combo == "")
            {
                $test_combo = $row_or[combo];
                $ret_arr[combo] = $test_combo;
                $ret_arr[combo_id] = $row_or[combo_id];
                $ret_arr[bundle_id] = $row_or[bundle_id];
                $ret_arr[session] = $row_or[session];
                $ret_arr[rpobc] = $row_or[rpobc];
            }
        }   
        else
        {
            //test mode
            if((int)$row_or[session]<$max_session)
            {
                $test_combo = $row_or[combo];
                $ret_arr[combo] = $test_combo;
                $ret_arr[combo_id] = $row_or[combo_id];
                $ret_arr[bundle_id] = $row_or[bundle_id];
                $ret_arr[session] = $row_or[session];
                $ret_arr[rpobc] = $row_or[rpobc];
                return $ret_arr;
            }
            else if($opt_combo == "")
            {
                $opt_combo = $row_or[combo];
                $ret_arr[combo] = $opt_combo;
                $ret_arr[combo_id] = $row_or[combo_id];
                $ret_arr[bundle_id] = $row_or[bundle_id];
                $ret_arr[session] = $row_or[session];
                $ret_arr[rpobc] = $row_or[rpobc];
            }
        }
    }
        
    if(($test_combo != "") || ($opt_combo != ""))
    {
        return $ret_arr;
    }
    return NULL;
}

function GetOffers_Cap()
{
    global $newconn;  
    //return array of offers that has more session than offer_cap in a day
    //var_dump($newconn);exit;          
    $arr_offers = array();
     
    //get all offers that has more session than offer cap

    $sql_o = "
        SELECT io.offer_id, io.cc, o.offer_cap 
        FROM
            (
            SELECT offer_id, COUNT(id) as cc
                    FROM install_offers
                    WHERE install_datetime>=DATE_SUB(NOW(), INTERVAL 1 DAY) AND install_completed=1 
                    GROUP BY offer_id
            ) io 
        LEFT JOIN offers o ON o.id=io.offer_id       
        WHERE io.cc>=o.offer_cap
    ";
    //var_dump($sql_o);exit;
    $q_o = mysqli_query($newconn, $sql_o);
    while($row_o=mysqli_fetch_assoc($q_o))
    {
        array_push($arr_offers, (int)$row_o[offer_id]);
    }
    //var_dump($arr_offers);exit;
    return $arr_offers;
}
function Analyze_Combo_bundle($all_combos, $search_combos, $bundle_id, $mode, $max_session)
{
    //$all_combos[combo_id, session, revenue, combo, bundle_id, rpobc], 
    //$search_combos[combo, combo_string, combo_arr[]]
    //$mode = 1 : test mode , $mode=0 : opt mode
      
    //var_dump($all_combos);
    //var_dump($search_combos);
    //var_dump($bundle_id);
    //var_dump($mode);
    //var_dump($max_session);    
    //exit;   
    
    
    //sort opt combos by rpobc
    //var_dump($all_combos[opt_combos]);
    $rpobc_opt = array();
    foreach($all_combos[opt_combos] as $combo)
    {
        array_push($rpobc_opt, $combo[rpobc]);
    }
    array_multisort($rpobc_opt,SORT_DESC, $all_combos[opt_combos]);
    /*
    if($bundle_id==44)
    {
        var_dump($all_combos); 
        var_dump($search_combos);
    }
    */
    $selected_combo = array();
    $opt_combo = NULL;
    
    if($mode == 0)
    {
        ///opt mode
        //get opt combo
         
        foreach($all_combos[opt_combos] as $combo)
        {
            foreach($search_combos as $search_combo)
            {                   
                if($combo[combo]==$search_combo[combo_string])
                {                       
                    //result is opt_combo
                    $selected_combo = $search_combo;
                    $selected_combo[combo_id] = $combo[combo_id];
                    $selected_combo[rpobc] = $combo[rpobc];
                    return $selected_combo;    
                }
            }
        }        
        //there is no available opt combo, in this case, first of $search_combos will be test combo
        $selected_combo = $search_combos[0];
        $selected_combo[combo_id] = 0;
        $selected_combo[rpobc] = 0; 
        return $selected_combo;           

    }
    else
    {
        //test mode        
        foreach($all_combos[test_combos] as $combo)
        {
            foreach($search_combos as $search_combo)
            {
                if($combo[combo]==$search_combo[combo_string])
                {
                    //result is test_combo
                    $selected_combo = $search_combo;
                    $selected_combo[combo_id] = $combo[combo_id];
                    $selected_combo[rpobc] = 0;
                    return $selected_combo;    
                }
            }            
        }
        
        //if there is no available test combo, then get opt_combo and pre_test_combo that is in $search_combos and is not in $all_combos
        //get opt combo
        $k = 0;
        foreach($all_combos[opt_combos] as $combo)
        {
            $num_arr = sizeof($search_combos);
            
            for($ii=0;$ii<$num_arr;$ii++)
            {
                if($search_combos[$ii][combo]==$search_combo[combo_string])
                {
                    if($k==0)
                    {
                        //result is test_combo
                        $opt_combo = $search_combo;
                        $opt_combo[combo_id] = $combo[combo_id]; 
                        $opt_combo[rpobc] = $combo[rpobc];
                        $k++;                       
                    }
                    
                    //unset this combo from $search_combos
                    $search_combos[$ii] = NULL;                        
                    break;
                }
            }   
        }
        
        //get pre_test_combo, if there is pre_test_combo, then it will be result
        foreach($search_combos as $search_combo)
        {
            if($search_combo != NULL)
            {
                $selected_combo = $search_combo;
                $selected_combo[combo_id] = 0;
                $selected_combo[rpobc] = 0;
                return $selected_combo;
            }
        }
        
        //if there is no pre_test_combo too, then result will be opt_combo 
        return $opt_combo;
    }
    
    return NULL;
}

function GetComboID($bundle_id, $combo)
{   
    global $newconn;  
    //get id of combos table
    $sql_c = "SELECT id FROM combos WHERE bundle_id={$bundle_id} AND combo='{$combo}'";
    $q_c = mysqli_query($newconn, $sql_c);
    $cc1 = mysqli_num_rows($q_c);
    
    if($cc1 == 0)
    {
        return 0;
    }   
    
    $row_c = mysqli_fetch_assoc($q_c);
    
    return (int)$row_c[id];
}


function CheckTestCombos($all_offers, $all_bundles)
{
    global $newconn;
    
    //get all bundles for this campaign
    $arr_res = array();
    
    $all_bundles_str = "";
              
    foreach($all_bundles as $bundle)
    {
        $all_bundles_str .= $bundle . ",";
    }
    
    if($all_bundles_str == "")
        return NULL;
    
    $all_bundles_str = substr($all_bundles_str,0,-1);
        
    $sql = "SELECT * FROM combos WHERE test_session>0 AND bundle_id IN ({$all_bundles_str})";
    $q = mysqli_query($newconn, $sql);
    $cc = mysqli_num_rows($q);
    while($row=mysqli_fetch_assoc($q))
    {
        $comb_offers = explode("|", $row[combo]);
        $containsAllValues = !array_diff($comb_offers, $all_offers);         
        if(!$containsAllValues) continue;
        
        //decrease test_session of the combo
        $sql = "UPDATE combos SET test_session=test_session-1 WHERE id={$row[id]}";
        mysqli_query($newconn, $sql);
        
        $arr_res[combo] = $row[combo];
        $arr_res[combo_id] = $row[id];
        $arr_res[bundle_id] = $row[bundle_id];
        $arr_res[session] = $row[session];
        $arr_res[rpobc] = $row[rpobc];
        
        return $arr_res;
    }
    
    return NULL;
}

if ($_REQUEST["download_id"] != '') 
{
    
    
    header("Content-type: text/xml");
    set_time_limit(0);
    ob_implicit_flush();
      
    $download_id = $_REQUEST["download_id"];
    
    //get proj_id
    $sql = "SELECT proj_id FROM projects_downloads WHERE id={$download_id}";
    $q = mysqli_query($newconn, $sql);
    $row = mysqli_fetch_assoc($q);
    
    $proj_id = $row[proj_id];
    
    //var_dump($proj_id);exit; 
    
    if($_REQUEST['mode']=='prechecking')
    {
        /// get all offers pre checking info 
        
        //get bundles and process rotate
         
         $arr_offers_cap = GetOffers_Cap(); //offercap array
         //var_dump($arr_offers_cap);exit;
              
         $sql_bundle = "SELECT * FROM bundle_campaigns WHERE camp_id={$proj_id}";   
         $q_bundle = mysqli_query($newconn, $sql_bundle);
         $count_bundle = mysqli_num_rows($q_bundle);
         
         $index = 0;
         //var_dump($count_bundle );exit;
         $all_offers = array();
         
         while($row_bundle = mysqli_fetch_assoc($q_bundle))
         {      
         
             $bundle_id = $row_bundle[bundle_id];
             //get all activated offers of the bundle
             $sql = "SELECT * FROM bundle_offers WHERE bundle_id={$bundle_id} AND isactive=1"; 
             //var_dump($sql);exit;
             
             $q = mysqli_query($newconn, $sql);
             while($row=mysqli_fetch_assoc($q))
             {
                 if($row[isgroup] == 0)
                 {
                     //this is offer  
                    array_push($all_offers, (int)$row[offer_id]);                    
                 }
                 else
                 {
                     //it is group
                     $sql2 = "SELECT * FROM offergroups WHERE id={$row[offer_id]}";   
                     $q2 = mysqli_query($newconn, $sql2);
                     $row2 = mysqli_fetch_assoc($q2);
                     
                     $sql3 = "  SELECT o.* FROM offers o WHERE o.offer_show=1 AND o.status=0 AND 
                                o.id IN ({$row2[offer1_id]}, {$row2[offer2_id]}, {$row2[offer3_id]}, {$row2[offer4_id]}, {$row2[offer5_id]})
                                ";
                     $q3 = mysqli_query($newconn, $sql3);
                     while($row3=mysqli_fetch_assoc($q3))
                     {
                        array_push($all_offers, (int)$row3[id]);     
                     }
                     
                     /*
                     if($row2[offer1_id]!=0)
                     {
                         array_push($all_offers, (int)$row2[offer1_id]);
                         if($row2[offer2_id]!=0)
                         {
                             array_push($all_offers, (int)$row2[offer2_id]);
                             if($row2[offer3_id]!=0)
                             {
                                 array_push($all_offers, (int)$row2[offer3_id]);
                                 if($row2[offer4_id]!=0)
                                 {
                                     array_push($all_offers, (int)$row2[offer4_id]);
                                     if($row2[offer5_id]!=0)
                                     {
                                         array_push($all_offers, (int)$row2[offer5_id]);
                                     }
                                 }
                             }
                         }
                     } 
                     */                    
                 }
                 
             }
         }             
         $final_offers = array_values(array_unique($all_offers));
         
         //apply offer cap
         $final_offers_cap = array_diff($final_offers, $arr_offers_cap);
         
         $count_offers = sizeof($final_offers_cap);             
         
         //make xml with offers prechecking information
         $xmlmsg = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
         $xmlmsg .= "<response>";
         $xmlmsg .= "<offercounts>" . $count_offers . "</offercounts>";
         //var_dump($final_offers_cap);exit;
         foreach($final_offers_cap as $final_offer)
         {
            $xmlmsg .= "<offer>";
            $xmlmsg .= "<offer_id>" . $final_offer . "</offer_id>";
            
            $sql = "SELECT * FROM offers WHERE id={$final_offer}";
            $q = mysqli_query($newconn, $sql);
            $row_offer = mysqli_fetch_assoc($q);
            
            $sql_check = "SELECT method_name FROM checkinstalled_method WHERE id={$row_offer[checkinstalled_method]}";
            $q_check = mysqli_query($newconn, $sql_check);
            $row_check = mysqli_fetch_assoc($q_check);
                        
            $xmlmsg .= "<checkinstalled_method>" . $row_check[method_name] . "</checkinstalled_method>";
            $row_offer[reg_path_pre] = str_replace("\\\\","\\",$row_offer[reg_path_pre]);
            $row_offer[reg_path_pre] = str_replace("\r\n","",$row_offer[reg_path_pre]);
            $xmlmsg .= "<offer_registry_path_pre>" . $row_offer[reg_path_pre] . "</offer_registry_path_pre>";
            $row_offer[reg_path_64_pre] = str_replace("\\\\","\\",$row_offer[reg_path_64_pre]);
            $row_offer[reg_path_64_pre] = str_replace("\r\n","",$row_offer[reg_path_64_pre]);
            $xmlmsg .= "<offer_registry_path_64_pre>" . $row_offer[reg_path_64_pre] . "</offer_registry_path_64_pre>";
            $xmlmsg .= "<offer_additional_condition>" . $row_offer[add_condition] . "</offer_additional_condition>";
            
            $xmlmsg .= "</offer>";
         }  
         $xmlmsg .= "</response>";
         
         
         echo $xmlmsg;
                 
    }    
    else if($_REQUEST['mode']=='getcombo')
    {       
        
        $all_offers = explode("|", $_REQUEST[offers]);
                        
        $xml_software = GetSubXmlSoftware($download_id, $my_common_path, $common_path_url);
        $offer_xml = ""; 
        
        //change offers from string to int
        
        for($xx=0;$xx<sizeof($all_offers);$xx++)
        {
            $all_offers[$xx] = (int)$all_offers[$xx];
        }
        
        //get all bundles
        $all_bundles = array();
        $sql = "SELECT bc.bundle_id FROM bundle_campaigns bc LEFT JOIN bundles b ON bc.bundle_id=b.id WHERE bc.camp_id={$proj_id} AND b.status=0";
        $q = mysqli_query($newconn, $sql);               
        while($row=mysqli_fetch_assoc($q))
        {
            array_push($all_bundles, $row[bundle_id]);
        }
        
        $final_combo_data = array();
        $arr_real_combo = array();
                    
        // check combos that has test session first
        $arr_data_selected_combo = CheckTestCombos($all_offers, $all_bundles);
        //var_dump($arr_data_selected_combo );exit;
        if($arr_data_selected_combo != NULL)
        {
            //there is test combo 
        }
        else
        {
            // apply auto optimizer logic
            //get combo test rate
            $sql = "SELECT field_value FROM network_setting WHERE field_name='combo_test_rate'";
            $q = mysqli_query($newconn, $sql);
            $row = mysqli_fetch_assoc($q);
            $combo_test_rate = $row[field_value];
            
            //decide to test mode or rpboc mode
            $rand_val = rand(0,100);
            $isTestMode = 0;
            if($rand_val <= $combo_test_rate)
            {
                //test mode
                $isTestMode = 1;
            }        
            
             
            //////  make combos for all bundle
 
            //get list of open_sessions and revenue for all combos of entire system
            $arr_data_selected_combo = Get_OpenSession_Revenue_OfAllCombos($isTestMode, $all_bundles, $all_offers); // array of [combo, session, revenue, bundle_id]
            //var_dump($arr_data_selected_combo );exit;
        }
        if($arr_data_selected_combo != NULL)
        {
            /// if there is selected combo, then get combo_arr string to auto optimizer, 
            /// this step is the case that the combo include group, ex : 1032|1033|1023 => 10001012|1033|1023
            $combo_arr_str = ""; //result string
            
            $bundle_id = $arr_data_selected_combo[bundle_id];
            $arr_offers_combo = explode("|", $arr_data_selected_combo[combo]);
            
            //get all categories of the bundle
            
            $sql_cat = "SELECT cat_id FROM bundle_categories WHERE bundle_id={$bundle_id} ORDER BY cat_order";
            $q_cat = mysqli_query($newconn, $sql_cat);            
            
            while($row_cat=mysqli_fetch_assoc($q_cat))
            {
                $arr_tmp_cat = array();  
                //get all offers and offergroups of the category 
                $sql1 = "   SELECT bo.offer_id, bo.isgroup FROM bundle_offers bo  
                            WHERE bo.bundle_id={$bundle_id} AND bo.cat_id={$row_cat[cat_id]} AND bo.isactive=1"; 
                
                $q1 = mysqli_query($newconn, $sql1);
                while($row1=mysqli_fetch_assoc($q1))
                {
                    $arr_tmp1 = array();
                    if($row1[isgroup] == 0)
                    {
                        $sql2 = "SELECT * FROM offers WHERE id={$row1[offer_id]} AND offer_show=1 AND status=0";
                        $q2 = mysqli_query($newconn, $sql2);
                        $cc = mysqli_num_rows($q2);
                        if($cc == 0) continue;
                        $row2 = mysqli_fetch_assoc($q2);
           
                        $tt = FindItemFromArray((int)$row1[offer_id], $arr_offers_combo);
                        if($tt != -1)                        
                        {                        
                            array_push($arr_tmp1, (int)$row1[offer_id]);                            
                            array_push($arr_tmp_cat, $arr_tmp1);  
                            
                        }  
                    }
                    else
                    {
                         //it is group
                         $sql2 = "SELECT * FROM offergroups WHERE id={$row1[offer_id]}";   
                         $q2 = mysqli_query($newconn, $sql2);
                         $row2 = mysqli_fetch_assoc($q2);
                         
                         $flag_group = 0;
                         
                         array_push($arr_tmp1, (int)$row1[offer_id] + 10000000); //first item of this array is offergroup id, offergroup id is plused with 10,000,000
                                                 
                         
                         
                         $tt = FindItemFromArray((int)$row2[offer1_id], $arr_offers_combo);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer1_id]);                             
                         }

                         $tt = FindItemFromArray((int)$row2[offer2_id], $arr_offers_combo);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer2_id]);   
                         }    
                         
                         $tt = FindItemFromArray((int)$row2[offer3_id], $arr_offers_combo);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer3_id]);  
                         }    
                         
                         $tt = FindItemFromArray((int)$row2[offer4_id], $arr_offers_combo);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer4_id]);  
                         }
                         
                         $tt = FindItemFromArray((int)$row2[offer5_id], $arr_offers_combo);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer5_id]);  
                         }
                         
                         if(sizeof($arr_tmp1) > 1) //there is offer to be able to select
                            array_push($arr_tmp_cat, $arr_tmp1);  
                    }       
                }
                $max_len = 0;
                $selected_offer = NULL;
                foreach($arr_tmp_cat as $tmp_cat)
                {
                    $tt = sizeof($tmp_cat);
                    if($tt>$max_len)
                    {
                        $max_len = $tt;
                        $selected_offer = $tmp_cat;
                    }
                }
                //var_dump($selected_offer);
                if($max_len>0)
                {
                    array_push($arr_real_combo, $selected_offer);
                }
//                var_dump($arr_tmp_cat);
            }
            //var_dump($arr_real_combo);
            $final_combo_data[combo_arr] = $arr_real_combo;
            $final_combo_data[combo_id] = $arr_data_selected_combo[combo_id];
            $final_combo_data[rpobc] = $arr_data_selected_combo[rpobc];
            $final_combo_data[bundle_id] = $arr_data_selected_combo[bundle_id];
            //var_dump($final_combo_data); 
            //exit;
        }    
        else         
        {
            //make new combo
            
            ///  select random bundle, and get combo that has most offers in the bundle
            //select random bundle
            $bundle_id = $all_bundles[rand(0,sizeof($all_bundles)-1)];       
            //var_dump($bundle_id);exit;
                      
                       
            //get  value of "Minimum # of Offer Spots To Test" of the bundle.
            $sql_b = "SELECT min_offerspot FROM bundles WHERE id={$bundle_id}";
            $q_b = mysqli_query($newconn, $sql_b);
            $row_b = mysqli_fetch_assoc($q_b);            
            $min_offerspot = $row_b[min_offerspot]; 
            
           
            //get all categories
            $sql_cat = "SELECT cat_id FROM bundle_categories WHERE bundle_id={$bundle_id} ORDER BY cat_order";
            $q_cat = mysqli_query($newconn, $sql_cat);
            
            $offers_arr_of_cat_available = array();
            $arr_combos_bundle = array();
            $arr_sizeofcombo_bundle = array();
                        
            /// get all offers of every categories from $all_offers
            while($row_cat=mysqli_fetch_assoc($q_cat))
            {      
                $arr_tmp_cat = array();
                $sql1 = "   SELECT bo.offer_id, bo.isgroup FROM bundle_offers bo  
                            WHERE bo.bundle_id={$bundle_id} AND bo.cat_id={$row_cat[cat_id]} AND bo.isactive=1"; 
                //var_dump($sql1);exit;                                  
                $q1 = mysqli_query($newconn, $sql1);
                
                $cc = mysqli_num_rows($q1);
                if($cc == 0) continue;
                                
                while($row1=mysqli_fetch_assoc($q1))
                {                   
                    $arr_tmp1 = array();                    
                    if($row1[isgroup] == 0)
                    {
                        $sql2 = "SELECT * FROM offers WHERE id={$row1[offer_id]} AND offer_show=1 AND status=0";
                        $q2 = mysqli_query($newconn, $sql2);
                        $cc = mysqli_num_rows($q2);
                        if($cc == 0) continue;
                        $row2 = mysqli_fetch_assoc($q2);
                        
                        //this is offer, so check the offer id is in available offer id array
                        
                        
                        $tt = FindItemFromArray((int)$row1[offer_id], $all_offers);
                        if($tt != -1)                        
                        {                        
                            array_push($arr_tmp1, (int)$row1[offer_id]);                            
                            array_push($arr_tmp_cat, $arr_tmp1);  
                        }
                    }
                    else
                    {
                        //it is group
                         $sql2 = "SELECT * FROM offergroups WHERE id={$row1[offer_id]}";   
                         $q2 = mysqli_query($newconn, $sql2);
                         $row2 = mysqli_fetch_assoc($q2);
                         
                         $flag_group = 0;
                         
                         array_push($arr_tmp1, (int)$row1[offer_id] + 10000000); //first item of this array is offergroup id, offergroup id is plused with 10,000,000
                                                 
                         $tt = FindItemFromArray((int)$row2[offer1_id], $all_offers);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer1_id]);                            
                         }

                         $tt = FindItemFromArray((int)$row2[offer2_id], $all_offers);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer2_id]);                            
                         }    
                         
                         $tt = FindItemFromArray((int)$row2[offer3_id], $all_offers);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer3_id]);                            
                         }    
                         
                         $tt = FindItemFromArray((int)$row2[offer4_id], $all_offers);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer4_id]);                            
                         }
                         
                         $tt = FindItemFromArray((int)$row2[offer5_id], $all_offers);
                         if($tt != -1)
                         {
                            array_push($arr_tmp1, (int)$row2[offer5_id]);                            
                         }
                         if(sizeof($arr_tmp1) > 1) //there is offer to be able to select
                            array_push($arr_tmp_cat, $arr_tmp1);  
                    }
                }  
                //var_dump($arr_tmp_cat); echo("<br>"); 
                //remove offers that existed the category from $all_offers
                //if (sizeof($arr_tmp_cat)>0)
                //    array_push($offers_arr_of_cat_available, $arr_tmp_cat);
                $max_len = 0;
                $selected_offer = NULL;
                foreach($arr_tmp_cat as $tmp_cat)
                {
                    $tt = sizeof($tmp_cat);
                    if($tt>$max_len)
                    {
                        $max_len = $tt;
                        $selected_offer = $tmp_cat;
                    }
                }
                //var_dump($selected_offer);
                if($max_len>0)
                {
                    array_push($arr_real_combo, $selected_offer);
                }                
            }
           
            //var_dump($offers_arr_of_cat_available); echo("<br>");  echo("<br>"); echo("<br>"); exit;
            //get all available comination of offers
            //var_dump($arr_real_combo);exit;    
            $available_count_cat = sizeof($arr_real_combo);
             
            $new_combo = "";   
            if($available_count_cat >= $min_offerspot)
            {
                foreach($arr_real_combo as $arr_offer_cat)
                {
                    if((int)$arr_offer_cat[0]>10000000)
                    {
                        for($aa=1;$aa<sizeof($arr_offer_cat)-1;$aa++)
                        {
                            $new_combo .= $arr_offer_cat[$aa] . "|";
                        }    
                    }
                    else
                        $new_combo .= $arr_offer_cat[0] . "|";
                }
                $new_combo = substr($new_combo,0,-1);
                
                $final_combo_data[combo] = $new_combo;  
                               
                $final_combo_data[combo_arr] = $arr_real_combo;
                
                //insert new combo
                $sql_cc = "INSERT INTO combos(bundle_id, combo) VALUES ({$bundle_id}, '{$new_combo}')";
                //var_dump($sql_cc); exit;
                mysqli_query($newconn, $sql_cc);
                $final_combo_data[combo_id] = mysqli_insert_id($newconn);
                
                $final_combo_data[rpobc] = 0;
                $final_combo_data[bundle_id] = $bundle_id;
                //var_dump($final_combo_data);exit;
            } 
            
        }   
   
        $selected_combo = $final_combo_data; 
        
          
        if($selected_combo == NULL)
        {
            //there is no combo available
            $offer_xml = "<bundle_id>" . $selected_combo[bundle_id] . "</bundle_id>";
            $offer_xml .= "<combo_id>0</combo_id>";
            $offer_xml .= "<cat_count>0</cat_count>";
        }
        else
        {
            
            $offer_xml = "<bundle_id>" . $selected_combo[bundle_id] . "</bundle_id>";
            $offer_xml .= "<combo_id>" . $selected_combo[combo_id] . "</combo_id>";
            $offer_xml .= "<cat_count>" . sizeof($selected_combo[combo_arr]) . "</cat_count>";
            
            $xml_offer = GetSubXmlOffers($proj_id, $selected_combo);
            
            $offer_xml .= $xml_offer;
        }
        
        //var_dump($xml_offers);exit;

        $xmlmsg = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";        
        $xmlmsg .= "<ip>" . $_SERVER["REMOTE_ADDR"] . "</ip>";
        $xmlmsg .= $xml_software;
        $xmlmsg .= $offer_xml . $xml_offers;
        
        
        //var_dump($xmlmsg);exit;
        echo($xmlmsg);
    }
     
    
}
  
?>