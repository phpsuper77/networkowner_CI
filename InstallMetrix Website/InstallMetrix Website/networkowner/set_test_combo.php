<?
include 'z_header.php';

$bundle_id = $_REQUEST[id];
if($bundle_id == NULL) 
{
    echo('<script language="JavaScript">window.location.href = "bundle_list.php"</script>');  
    break;
}

$combo_arr = array();

if ($_REQUEST[tryout] == '1') 
{  
    $errmsg = '';  
     
    if($_REQUEST[mode] == "savecombo")
    {
        //var_dump($_REQUEST);exit;
        $combo_id = 0;
        $combo = $_REQUEST[combo];
        $test_session = $_REQUEST[test_session];
        
        $sql = "SELECT * FROM combos WHERE combo='{$combo}'";
        $q = mysql_query($sql);
        $cc = mysql_num_rows($q);
        if($cc == 0)
        {
            //insert new combo
            $sql = "INSERT INTO combos(bundle_id, combo, session, rpobc, test_session) VALUES ({$bundle_id}, '{$combo}', 0, 0, {$test_session})";
            mysql_query($sql);
            $combo_id = mysql_insert_id();
        }
        else
        {
            $row = mysql_fetch_assoc($q);
            $combo_id = $row[id];
            $sql = "UPDATE combos SET test_session={$test_session} WHERE combo='{$combo}'";
            mysql_query($sql);
        }
        echo($combo_id);
        break;
    }
         
    if($_REQUEST[mode] == "getcombo")
    {
        //var_dump($_REQUEST);
        //get categories from bundle
        $sql = "SELECT c.name, c.id FROM bundle_categories bc LEFT JOIN categories c ON c.id=bc.cat_id 
                WHERE bc.bundle_id={$bundle_id} ORDER BY bc.cat_order ASC";
        $q = mysql_query($sql);   
        $i = 0;
        $in_arr = array();
        while($row=mysql_fetch_assoc($q))
        {
            $offer_id = $_REQUEST["cat_" . $i];
            $i++;
            if($offer_id=="-1") continue;
            
            $cat_arr = array();
            
            if($offer_id>10000000)
            {
                //offergroup
                $offer_id = $offer_id - 10000000;
                $sql1 = "SELECT * FROM offergroups WHERE id={$offer_id}";
                $q1 = mysql_query($sql1);
                $row1 = mysql_fetch_assoc($q1);
                
                $tmp_arr = array();
                
                if((int)$row1[offer1_id]>0) array_push($tmp_arr, (int)$row1[offer1_id]);
                if((int)$row1[offer2_id]>0) array_push($tmp_arr, (int)$row1[offer2_id]);
                if((int)$row1[offer3_id]>0) array_push($tmp_arr, (int)$row1[offer3_id]);
                if((int)$row1[offer4_id]>0) array_push($tmp_arr, (int)$row1[offer4_id]);
                if((int)$row1[offer5_id]>0) array_push($tmp_arr, (int)$row1[offer5_id]);
                
                //var_dump($tmp_arr);exit;
                
                $tmp1_arr = array(0,0,0,0,0);
                $tmp_size = sizeof($tmp_arr);
                
                while(true)
                {                     
                    $tmp1_arr[$tmp_size-1]++;  
                    for($j=$tmp_size-1;$j>0;$j--)
                    {
                        if($tmp1_arr[$j]>1)
                        {
                            $tmp1_arr[$j] = 0;
                            $tmp1_arr[$j-1]++;
                        }
                    }
                    if($tmp1_arr[0]>1) 
                    {
                        break;
                    }                        
                    else
                    {
                        //process
                        $str = "";
                        for($k=0;$k<$tmp_size;$k++)
                        {
                            //$str .= $tmp1_arr[$k] . "|";
                            if($tmp1_arr[$k] == 0) continue;
                            $str .= $tmp_arr[$k] . "|";
                        }
                        $str = substr($str, 0, -1);
                        //echo($str); echo("<br>");   
                        array_push($cat_arr, $str);
                    }                    
                }  
            }
            else
            {
                //offer
                array_push($cat_arr, $offer_id);
            } 
            array_push($in_arr, $cat_arr);
        }
        
        ///// get combos
        //var_dump($in_arr);exit;      
        $size_in = sizeof($in_arr);
        $size_cat_arr = array();
        $indexs_in_cat = array();

        foreach($in_arr as $in)
        {
            array_push($size_cat_arr, sizeof($in));
            array_push($indexs_in_cat, 0);
        }
        
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
                
                //echo($combo_str); echo("<br>");  
                
                array_push($combo_arr, $combo_str);

            }                        
            $indexs_in_cat[$size_in-1]++;            
        }
        
        //exit;

        
    }
    //$errmsg = "error";     
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
        $save_message = '0';
    }    
}

$sql = "SELECT * FROM bundles WHERE id='{$bundle_id}'";
//var_dump($sql); exit;
$q = mysql_query($sql);
$row = mysql_fetch_assoc($q);

foreach ($row as $key => $value) {
    $_REQUEST[$key] = $value;
}
?>

<script type="text/javascript">
function SaveTestSessionToCombo(bundle_id, combo, test_session)
{
    str = "set_test_combo.php?tryout=1&mode=savecombo&id=" + bundle_id + "&combo=" + combo + "&test_session=" + test_session;
    //alert(str);
    
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
      {         
        //$("#error_msg").html("success");
        $('#get_testcombo_form').submit();
        $(".chosen-with-diselect").chosen({
            allow_single_deselect: true
        });        
      }
    }
    xmlhttp.open("GET",str,true);
    xmlhttp.send();    
}
</script>
<div id="body">

    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER-->
                <!-- END STYLE CUSTOMIZER-->
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Set Test Combo
                    <small>Set test combo</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="bundle_list.php">Bundle List</a> <span class="divider">/</span>
                    </li>                    
                    <li><a href="#">Set test combo</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">
            <?
            if ($isSaved==1) {
            ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    Test combo setting is saved successfully !
                </div>
            <? } ?>
            <? if ($usermessage != '') { ?>
                <div id="error_msg" class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Get test combos</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" >
                                
                                <div class="tab-pane active" id="portlet_tab1">
                                    <form action="set_test_combo.php?id=<?= $bundle_id?>" class="form-inline" role="form" method="POST" id="get_testcombo_form" enctype="multipart/form-data">
                                        <input type="hidden" name="tryout" value="1"/>
                                        <input type="hidden" name="mode" value="getcombo"/>
                                        <br>
                                        <?
                                        //get categories of the bundle
                                        $sql = "SELECT c.name, c.id FROM bundle_categories bc LEFT JOIN categories c ON c.id=bc.cat_id 
                                                WHERE bc.bundle_id={$bundle_id} ORDER BY bc.cat_order ASC";
                                        $q = mysql_query($sql);
                                        $i = 0;
                                        while($row=mysql_fetch_assoc($q))
                                        { 
                                        ?>
                                            <div class="control-group">
                                                <label class="control-label" for="input3" style="float: left; width: 400px;padding-top: 9px;"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span><?= $row[name]?></label>
                                                <div class="controls">
                                                    <!--<select class="span6 chosen" name='cat_<?=$i ?>' onchange="GetOffersByCategory_Bundle(<?=$_REQUEST[id]?>,this.options[this.selectedIndex].value);">-->
                                                    <select class="span6 chosen" name='cat_<?=$i ?>' id='cat_<?=$i ?>' style="width: 300px;">
                                                        <option value="-1"></option>
                                                        <?
                                                        
                                                        $sql1 = "SELECT bo.offer_id, bo.isgroup FROM bundle_offers bo 
                                                                WHERE bo.bundle_id={$bundle_id} AND bo.cat_id={$row[id]} AND bo.isactive=1 ORDER BY bo.offer_id ASC ";
                                                        //var_dump($sql1);exit;
                                                        $q1 = mysql_query($sql1);
                                                        
                                                        while ($row1 = mysql_fetch_assoc($q1)) {    
                                                            $isgroup = $row1[isgroup];
                                                            if($isgroup == 1)
                                                            {
                                                                //offergroup
                                                                $sql2 = "SELECT name as offer_name FROM offergroups WHERE id={$row1[offer_id]}";                                                                     
                                                                $offer_id = 10000000 + (int)$row1[offer_id];
                                                            }                                                        
                                                            else
                                                            {
                                                                $sql2 = "SELECT offer_name FROM offers WHERE id={$row1[offer_id]}";
                                                                $offer_id = (int)$row1[offer_id];
                                                            }
                                                            $q2 = mysql_query($sql2);
                                                            $row2 = mysql_fetch_assoc($q2);
                                                            ?>
                                                            <option value="<?= $offer_id ?>" <? if($offer_id==$_REQUEST["cat_".$i]) echo("selected"); ?>><?= $row2[offer_name]?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                        <?
                                        $i++;
                                        } 
                                        ?>   
                                        <div class="form-actions" id="buttons_getcombos" style="width:800px;" >
                                            <a href="#" class="btn btn-success" onclick="$('#get_testcombo_form').submit();return false;"><i class="icon-check"></i> Get Combos</a>                                                
                                        </div>
                                         
                                    </form>
                                    
                                 </div>
                                
                            </div>    
                            
                            
                        </div>
                    </div>                    
                   
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Set session for combo</h4>
                        </div>
                        <div class="widget-body form">
                            <div class="tabbable portlet-tabs" >                                 
                                <div class="tab-pane active" id="portlet_tab1">  
                                <!--
                                    <form action="set_test_combo.php?id=<?= $bundle_id?>" class="form-inline" role="form" method="POST" id="save_testcombo_form" enctype="multipart/form-data">
                                        <input type="hidden" name="tryout" value="1"/>
                                        <input type="hidden" name="mode" value="savecombo"/>
                                        <input type="hidden" name="combo_id" id="combo_id" value="0">
                                        <input type="hidden" name="test_session" id="test_session" value="0">
                                        -->
                                        <div class="control-group" style="float: left; ">
                                            
                                            <div id="offers_table" style="">    
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ComboID</th>
                                                            <th>Combo</th>
                                                            <th>Session</th>
                                                            <th>RPOBC</th>                                                        
                                                            <th>Test Session</th>
                                                            <th>&nbsp;</th>                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?
                                                    $xx = 0;
                                                    foreach($combo_arr as $combo)
                                                    {
                                                        $sql3 = "SELECT * FROM combos WHERE combo='{$combo}'";
                                                        
                                                        $q3 = mysql_query($sql3);
                                                        $cc = mysql_num_rows($q3);
                                                        
                                                        //convert combo to combo name
                                                        $tmp3_arr = explode("|", $combo);
                                                        $combo_names = "";
                                                        foreach($tmp3_arr as $tmp3)
                                                        {
                                                            $sql5 = "SELECT offer_name FROM offers WHERE id={$tmp3}";
                                                            $q5 = mysql_query($sql5);
                                                            $row5 = mysql_fetch_assoc($q5);
                                                            $combo_names .= $row5[offer_name] . " | ";
                                                        }
                                                        $combo_names = substr($combo_names, 0, -3);
                                                        
                                                        if($cc==0)
                                                        {
                                                    ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td><?=$combo_names ?></td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>                                                                    
                                                                    <input type="text" style="width: 30px; float: left;" id="combo_testsession_<?=$xx?>" name="combo_testsession_<?=$xx?>" value="0">                                                                 
                                                                </td>
                                                                <td><button onclick="SaveTestSessionToCombo(<?=$bundle_id?>, '<?=$combo?>', $('#combo_testsession_<?=$xx?>').val());">Save</button></td>
                                                            </tr>
                                                    <?   
                                                        }
                                                        else
                                                        {
                                                            $row3 = mysql_fetch_assoc($q3);
                                                    ?>
                                                            <tr>
                                                                <td><?=$row3[id] ?></td>
                                                                <td><?=$combo_names ?></td>
                                                                <td><?=$row3[session] ?></td> 
                                                                <td><?=$row3[rpobc] ?> </td>
                                                                <td>                                                                    
                                                                    <input type="text" style="width: 30px; float: left;" id="combo_testsession_<?=$xx?>" name="combo_testsession_<?=$xx?>" value="<?=$row3[test_session] ?>">                                                                 
                                                                </td>
                                                                <td><button onclick="SaveTestSessionToCombo(<?=$bundle_id?>, '<?=$combo?>', $('#combo_testsession_<?=$xx?>').val());">Save</button></td>
                                                                
                                                            </tr>
                                                    <?
                                                        } 
                                                        $xx++;
                                                    } 
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                             
                                    <!--</form>-->
                                </div>
                            
                            </div>    
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
         </div>
    </div>
</div>                                      
 
<? include 'z_footer.php'; ?> 