<?php

include '../config.php';
  
// parameter : ...?proj_id=1018&min_offerspot=3         
    
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

function Get_OpenSession_Revenue_OfAllCombos()
{   
    $ret_arr = array();
      
    //return value : array [combo_id, combo, session, revenue, bundle_id]
    $sql_or = "
          SELECT oc.combo_id, oc.combo, oc.session, o_r.revenue, oc.bundle_id
          FROM 
                (
                    SELECT c.id as combo_id, c.combo, io1.cc as session, c.bundle_id 
                    FROM 
                        (   SELECT count(io.id) as cc, io.combo_id 
                            FROM 
                                (   SELECT count(id) as id, combo_id 
                                    FROM install_offers 
                                    GROUP BY download_id, combo_id 
                                ) io 
                            GROUP BY io.combo_id
                        ) io1 
                    LEFT JOIN combos c 
                    ON io1.combo_id=c.id 
                ) oc
          LEFT JOIN 
                (
                    SELECT c.id as combo_id, c.combo, io1.revenue, c.bundle_id 
                    FROM 
                        (   
                            SELECT sum(io.price) as revenue, io.combo_id 
                            FROM 
                                (   
                                    SELECT sum(price*adjust_rate/100) as price, combo_id 
                                    FROM install_offers WHERE install_completed=1 
                                    GROUP BY download_id, combo_id 
                                ) io 
                            GROUP BY io.combo_id
                        ) io1 
                    LEFT JOIN combos c 
                    ON io1.combo_id=c.id
                ) o_r
          ON oc.combo_id=o_r.combo_id 
    ";
    
    $q_or = mysql_query($sql_or);
    
    while($row_or=mysql_fetch_assoc($q_or))
    {                      
        array_push($ret_arr, $row_or);
    }
            
    return $ret_arr;
}

function Analyze_Combo_bundle($all_combos, $search_combos, $bundle_id, $mode, $max_session)
{
    //$all_combos[combo, session, revenue, bundle_id], 
    //$search_combos[combo, combo_string, combo_arr[]]
    //$mode = 1 : test mode , $mode=0 : opt mode
       
    $ret_arr = array();
        
    $pre_test_combo = NULL;
    $test_combo = NULL;
    $test_combo_id = 0;
    $max_rpobc = 0;
    $opt_combo = NULL;
    $opt_combo_id = 0;
    
    
    foreach($search_combos as $search_combo)
    {
        
        $selected_allcombo = NULL;
        $selected_searchcombo = NULL;
        foreach($all_combos as $all_combo)
        {               
            if(($all_combo[bundle_id] == $bundle_id)&&($all_combo[combo] == $search_combo[combo_string]))
            {
                $selected_searchcombo = $search_combo;
                $selected_allcombo = $all_combo;
                break;
            }
        }             
        
        if($selected_searchcombo != NULL)
        {           
            if($selected_allcombo[session]>$max_session)
            {
                //opt combo
                $rpobc = 0;
                if($selected_allcombo[session] == 0) 
                    $rpobc = 0;
                else
                    $rpobc = $selected_allcombo[revenue]/$selected_allcombo[session];
                         
                if($max_rpobc <= $rpobc)
                {
                    $max_rpobc = $rpobc;
                    $opt_combo = $selected_searchcombo;
                    $opt_combo_id = $selected_allcombo[combo_id];
                }
            }
            else
            {
                //test combo
                if($test_combo == NULL)
                {
                    $test_combo = $selected_searchcombo;
                    $test_combo_id = $selected_allcombo[combo_id];
                    if($mode == 1)
                    {
                        //if test mode, then return .
                        break;
                    }
                }
            }
        }   
        else
        {
            if($pre_test_combo == NULL)
            {
                $pre_test_combo = $search_combo;          
            }
        }   
    }
    $ret_arr[pre_test_combo] = $pre_test_combo;
    $ret_arr[test_combo] = $test_combo;
    $ret_arr[test_combo_id] = $test_combo_id;
    $ret_arr[opt_combo] = $opt_combo;
    $ret_arr[opt_combo_id] = $opt_combo_id;
    $ret_arr[bundle_id] = $bundle_id;
    
    return $ret_arr;
}

function GetComboID($bundle_id, $combo)
{   
    //get id of combos table
    $sql_c = "SELECT id FROM combos WHERE bundle_id={$bundle_id} AND combo='{$combo}'";
    $q_c = mysql_query($sql_c);
    $cc1 = mysql_numrows($q_c);
    
    if($cc1 == 0)
    {
        return 0;
    }   
    
    $row_c = mysql_fetch_assoc($q_c);
    
    return (int)$row_c[id];
}


function GetSubXmlSoftware($download_id, $my_common_path, $common_path_url)
{
    $html_path = $my_common_path . "interface/htmls/";
    $html_url = $common_path_url . "interface/htmls/";
    //for software
    $sql = "SELECT u.subid, p.* FROM projects p, projects_downloads pd, users u WHERE p.assigned_user_id=u.id AND p.id=pd.proj_id AND pd.id={$download_id}";
 
    //var_dump($sql); exit;    
    
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q); 
    
    

    foreach ($row as $key => $value) {
        $row[$key] = htmlspecialchars($value);
    }
  
    $proj_id = $row[id]; 
    $pub_id = $row[assigned_user_id]; 
    $pub_subid = $row[subid];
    
    
    ///// make template html
    $sql = "SELECT * FROM template_campaigns WHERE camp_id={$proj_id}";
    $q = mysql_query($sql);
    $count_template = mysql_numrows($q);
    $rand_val = rand(0,$count_template-1);
    $index = 0;
    $template_id = -1;
    while ($row = mysql_fetch_assoc($q))
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
    
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
        
    $main_path = $row[maintemplate_filepath];
    $download_path = $row[downloadtemplate_filepath];
    $thank_path = $row[thanktemplate_filepath];
    
    
    $sql_p = "SELECT * FROM projects WHERE id={$proj_id}";
    $q_p = mysql_query($sql_p);
    $row_p = mysql_fetch_assoc($q_p);
    
    $logo_url = $common_path_url . "installer_logos/" . $proj_id . ".jpg"; 
    
    //get software description for template 
    $desc_for_template = $row[camp_description];
         
    {
    //make main template html      
    //var_dump($main_path); exit;    
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
    
    $homepage_path = $html_path . "main-" . $download_id . ".htm";
    file_put_contents($homepage_path, $homepage); 
    
    //var_dump($homepage);exit;
    
    $main_homepage_url = $html_url . "main-" . $download_id . ".htm";   
     
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
    
    $homepage_path = $html_path . "download-" . $download_id . ".htm";
    file_put_contents($homepage_path, $homepage); 
    
    $download_homepage_url = $html_url . "download-" . $download_id . ".htm";  
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
    
    $homepage_path = $html_path . "thank-" . $download_id . ".htm";
    file_put_contents($homepage_path, $homepage); 
    
    $thank_homepage_url = $html_url . "thank-" . $download_id . ".htm";  
    
    $str_projdesc = $strdesc;
    }
    
    //// select exit url
    $sql = "SELECT * FROM exiturl_campaigns WHERE proj_id={$proj_id}";
    $q = mysql_query($sql);
    $count_exiturl = mysql_numrows($q);
    $rand_val = rand() % $count_exiturl;
    $index = 0;
    $exiturl_id = -1;
    while ($row = mysql_fetch_assoc($q))
    {           
        if($rand_val==$index)
        {
            $exiturl_id = $row[exiturl_id];
            break;
        }
        $index++;
    }
    $sql = "SELECT exiturl FROM exiturl WHERE id={$exiturl_id}";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
    $exiturl = $row[exiturl];
    
    $msg .= "<application>";
    $msg .= "<software_id>" . $proj_id . "</software_id>";    
    $msg .= "<software_name>" . $row_p[software_name] . "</software_name>"; 
    $msg .= "<software_url>" . $row_p[software_url] . "</software_url>";
    
    $slient = str_replace("@pubid@", $pub_id, $row_p[software_silent]); 
    $msg .= "<software_silent>" . $slient . "</software_silent>";     
    $msg .= "<software_templateid>" . $template_id . "</software_templateid>"; 
    $msg .= "<software_html1>" . $main_homepage_url . "</software_html1>";     
    $msg .= "<software_html2>" . $download_homepage_url . "</software_html2>";     
    $msg .= "<software_html3>" . $thank_homepage_url . "</software_html3>";     
    $msg .= "<software_exiturl>" . $exiturl . "</software_exiturl>";  
    $msg .= "</application>";   
    
    return $msg; 
}

function GetSubXmlOffers($proj_id, $combo)
{
    //var_dump($combo);echo("<br>");echo("<br>");echo("<br>");
    //var_dump($combo); exit;
    $arr_offers = $combo[combo_arr];
    
    $offer_count = sizeof($arr_offers);
    $msg = "";
       
    //get projects info
    $sql_p = "SELECT p.*, u.subid FROM projects p LEFT JOIN users u ON p.assigned_user_id=u.id WHERE p.id={$proj_id}";
    //var_dump($sql_p);exit;
    $q_p = mysql_query($sql_p);
    $row_p = mysql_fetch_assoc($q_p);
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
            
            $q_group = mysql_query($sql_group);
            $row_group = mysql_fetch_assoc($q_group);
                 
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
                        $q_offer = mysql_query($sql_offer);
                        $row_offer = mysql_fetch_assoc($q_offer);
                        
                        $msg .= "<offer_name>" . $row_offer[offer_name] . "</offer_name>";                           
                        $msg .= "<offer_url>" . $row_offer[offer_url] . "</offer_url>";
                        
                        /// slient keys
                        $slient = str_replace("@pubid@", $pub_subid, $row_offer[offer_silent_main]); 
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
                        $q_check = mysql_query($sql_check);
                        $row_check = mysql_fetch_assoc($q_check);                                                                     
                                                
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
            $q_offer = mysql_query($sql_offer);                 
            $row_offer = mysql_fetch_assoc($q_offer);
             
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
            $q_check = mysql_query($sql_check);
            $row_check = mysql_fetch_assoc($q_check);
            
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

//if ($_REQUEST["download_id"] != '') 
{

    $proj_id = $_REQUEST[proj_id];
    $min_offerspot = $_REQUEST[min_offerspot];
    $count_combos = 0;
    
    //var_dump($proj_id);exit;
    

    /// get all offers pre checking info 
    
    //get bundles and process rotate
 
     $sql_bundle = "SELECT * FROM bundle_campaigns WHERE camp_id={$proj_id}";   
     $q_bundle = mysql_query($sql_bundle);
     $count_bundle = mysql_numrows($q_bundle);
     
     $index = 0;
     
     $all_offers = array();
     
     while($row_bundle = mysql_fetch_assoc($q_bundle))
     {      
     
         $bundle_id = $row_bundle[bundle_id];
         //get all activated offers of the bundle
         $sql = "SELECT * FROM bundle_offers WHERE bundle_id={$bundle_id} AND isactive=1"; 
         //var_dump($sql);exit;
         
         $q = mysql_query($sql);
         while($row=mysql_fetch_assoc($q))
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
                 $q2 = mysql_query($sql2);
                 $row2 = mysql_fetch_assoc($q2);
                 
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
             }
             
         }
     }             
     $final_offers = array_values(array_unique($all_offers));                         
     
                         
    $all_offers = $final_offers;
    
    for($xx=0;$xx<sizeof($all_offers);$xx++)
    {
        $all_offers[$xx] = (int)$all_offers[$xx];
    }
     /*
    //get combo test rate
    $sql = "SELECT field_value FROM network_setting WHERE field_name='combo_test_rate'";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);
    $combo_test_rate = $row[field_value];
    
    //decide to test mode or rpboc mode
    $rand_val = rand(0,100);
    $isTestMode = 0;
    if($rand_val <= $combo_test_rate)
    {
        //test mode
        $isTestMode = 1;
    }
    
    // get max_testcombo_opensession from network_setting table
    $sql_m = "SELECT field_value FROM network_setting WHERE field_name='max_testcombo_opensession'";
    $q_m = mysql_query($sql_m);
    $row_m = mysql_fetch_assoc($q_m);
    $max_session = $row_m[field_value];
    
    //////  make combos for all bundle
    
    //get list of open_sessions and revenue for all combos of entire system
    $arr_data_all_combos = Get_OpenSession_Revenue_OfAllCombos(); // array of [combo, session, revenue, bundle_id]
    //var_dump($arr_data_all_combos);exit;
    */
    $final_combo_data = array();
    //get all bundles    
    $sql = "SELECT * FROM bundle_campaigns bc LEFT JOIN bundles b ON bc.bundle_id=b.id WHERE bc.camp_id={$proj_id} AND b.status=0";
    //var_dump($sql);exit;
    $q = mysql_query($sql);               
    while($row=mysql_fetch_assoc($q))
    {
        $bundle_id = $row[bundle_id];
        /*                                       
        //get  value of "Minimum # of Offer Spots To Test" of the bundle.
        $sql_b = "SELECT min_offerspot FROM bundles WHERE id={$bundle_id}";
        $q_b = mysql_query($sql_b);
        $row_b = mysql_fetch_assoc($q_b);            
        $min_offerspot = $row_b[min_offerspot]; 
        */
        //echo("aaaaaaaaaa");echo($bundle_id);echo($min_offerspot);echo("<br>");
        //get all categories
        $sql_cat = "SELECT * FROM bundle_categories WHERE bundle_id={$bundle_id} ORDER BY cat_order";
        $q_cat = mysql_query($sql_cat);
        
        $offers_arr_of_cat_available = array();
        $arr_combos_bundle = array();
        $arr_sizeofcombo_bundle = array();
        /// get all offers of every categories
        while($row_cat=mysql_fetch_assoc($q_cat))
        {      
            $arr_tmp_cat = array();
            $sql1 = "   SELECT bo.offer_id, bo.isgroup FROM bundle_offers bo  
                        WHERE bo.bundle_id={$bundle_id} AND bo.cat_id={$row_cat[cat_id]} AND bo.isactive=1"; 
            //var_dump($sql1);exit;                                  
            $q1 = mysql_query($sql1);
            
            $cc = mysql_numrows($q1);
            if($cc == 0) continue;
                            
            while($row1=mysql_fetch_assoc($q1))
            {                   
                $arr_tmp1 = array();                    
                if($row1[isgroup] == 0)
                {
                    $sql2 = "SELECT * FROM offers WHERE id={$row1[offer_id]} AND offer_show=1 AND status=0";
                    $q2 = mysql_query($sql2);
                    $cc = mysql_numrows($q2);
                    if($cc == 0) continue;
                    $row2 = mysql_fetch_assoc($q2);
                    
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
                     $q2 = mysql_query($sql2);
                     $row2 = mysql_fetch_assoc($q2);
                     
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
            if (sizeof($arr_tmp_cat)>0)
                array_push($offers_arr_of_cat_available, $arr_tmp_cat);
            
        }
    
    
        //var_dump($offers_arr_of_cat_available); echo("<br>");  echo("<br>"); echo("<br>"); exit;
        //get all available comination of offers
        
        $available_count_cat = sizeof($offers_arr_of_cat_available);
        
           
        if($available_count_cat > 0)
        {
        
            $maxcount_offers_of_cat = array();
            $indexs_in_cat = array();
                              
            for($i=0;$i<$available_count_cat;$i++)
            {
                array_push($maxcount_offers_of_cat,sizeof($offers_arr_of_cat_available[$i]));    
                array_push($indexs_in_cat, 0);                        
            }
            
            //var_dump($maxcount_offers_of_cat);  exit;
            
            $max_rev = 0;
            
            $flag = true;      
            while($flag==true)
            {            
                for($pos=$available_count_cat-1; $pos>0;$pos--)
                {               
                    if($indexs_in_cat[$pos]>$maxcount_offers_of_cat[$pos])
                    {
                        $indexs_in_cat[$pos] = 0;
                        $indexs_in_cat[$pos-1]++;         
                    }
                }
                
                if($indexs_in_cat[0]>$maxcount_offers_of_cat[0])
                {
                    $flag = false;
                }
                else
                {
                    
                    //process selected combo : $offers_arr_of_cat_available[$indexs_in_cat[0]], $offers_arr_of_cat_available[$indexs_in_cat[1]], .. so on
                    /*
                    for($kk=0;$kk<$available_count_cat;$kk++)
                    {
                        echo($offers_arr_of_cat_available[$kk][$indexs_in_cat[$kk]][0]); echo("|");    
                    }
                    
                    echo("<br>");    
                    */
                    
                    //make string of combo and push it to array of (for counts of non zero)
                    
                    $str_tmp = "";
                    $str_tmp_offer = "";
                    $arr_tmp_combo = array();
                    
                    //var_dump($available_count_cat);exit;
                    for($xx=0;$xx<$available_count_cat;$xx++)
                    {
                        $tmp_1 = $offers_arr_of_cat_available[$xx][$indexs_in_cat[$xx]];
                        
                        if($tmp_1 == NULL) continue;
                        
                        array_push($arr_tmp_combo, $tmp_1);
                        
                        $str_tmp = $str_tmp . $tmp_1[0] . "|";                    
                        
                        if($tmp_1[0]>10000000)
                        {
                            //this is offergroup
                            for($ii=1;$ii<sizeof($tmp_1);$ii++)
                            {                   
                                $str_tmp_offer = $str_tmp_offer . $tmp_1[$ii] . "|";
                            }    
                        }
                        else
                        {
                            //this is offer
                            $str_tmp_offer = $str_tmp_offer . $tmp_1[0] . "|";
                        } 
                         
                                                             
                    }
                    $str_tmp = substr($str_tmp,0,-1);
                    $str_tmp_offer = substr($str_tmp_offer,0,-1);
                    
                    //if the size of combo is less than $min_offerspot, then it will be ignored
                    //var_dump($min_offerspot);exit; 
                    if(sizeof($arr_tmp_combo)>=$min_offerspot)
                    {
                        $arr_tmp1_combo = array();
                        $arr_tmp1_combo[combo] = $str_tmp;
                        $arr_tmp1_combo[combo_string] = $str_tmp_offer;
                        $arr_tmp1_combo[combo_arr] = $arr_tmp_combo;
                        array_push($arr_sizeofcombo_bundle,sizeof($arr_tmp_combo));
                        array_push($arr_combos_bundle, $arr_tmp1_combo);                            
                    }              
                }
                
                $indexs_in_cat[$available_count_cat-1]++;            
            }
            
            
            array_multisort($arr_sizeofcombo_bundle,SORT_DESC, $arr_combos_bundle);
            //var_dump($arr_combos_bundle);
            
            //get best test combo and best optimze combo for the bundle
            
            //$final_combo_bundle = Analyze_Combo_bundle($arr_data_all_combos, $arr_combos_bundle, $bundle_id, $isTestMode, $max_session);
            $arr_combos_bundle[bundle_id] = $bundle_id;
            array_push($final_combo_data, $arr_combos_bundle);  
            
        }              
    }
    
    //var_dump($all_offers);  
    
    //get offer names
    $arr_offer_name = array();
    foreach($all_offers as $a_offer)
    {
        $sql_o = "SELECT * FROM offers WHERE id={$a_offer}";
        $q_o = mysql_query($sql_o);
        $row_o = mysql_fetch_assoc($q_o);
        $arr_offer_name[$a_offer][name] = $row_o[offer_name];
    }
    
    //var_dump($final_combo_data);
    $total_count = 0;
    foreach($final_combo_data as $final)
    {
        echo("bundle id = " . $final[bundle_id] . "<br>");
        echo("count of combo = " . sizeof($final) . "<br><br>");
        $total_count += sizeof($final);
        foreach($final as $arr_combo)
        {   
            $str_tmp_offer = "";
            $tmp_0 = $arr_combo[combo_arr];
            
            foreach($tmp_0 as $tmp_1)
            { 
                if($tmp_1[0]>10000000)
                {
                    //this is offergroup
                    for($ii=1;$ii<sizeof($tmp_1);$ii++)
                    {                   
                        $str_tmp_offer = $str_tmp_offer . $arr_offer_name[$tmp_1[$ii]][name] . "|";
                    }    
                }
                else
                {
                    //this is offer
                    $str_tmp_offer = $str_tmp_offer . $arr_offer_name[$tmp_1[0]][name] . "|";
                }
            }
            $str_tmp_offer = substr($str_tmp_offer,0,-1);
            echo($str_tmp_offer);echo("<br>");       
        }
        echo("<br><br><br>");    
        
    }
    echo("total count = " . $total_count);          
    exit;

}
       
?>