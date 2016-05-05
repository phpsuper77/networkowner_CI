<?
include 'z_header.php';


FB::log($_SERVER);

if (($_REQUEST[id] != '') && ($_REQUEST[tryout] == '')) {
    $sql = "SELECT * FROM domains WHERE id='{$_REQUEST[id]}'";
    $q = mysql_query($sql);
    $row = mysql_fetch_assoc($q);

    foreach ($row as $key => $value) {
        $_REQUEST[$key] = $value;
    }
  
}   

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    if ($_REQUEST[domain] == '') {
        $errmsg.='<li>Field "Domain" should not be empty</li>';
    } 
    
    $a = strstr($_REQUEST[domain], "http");
    //var_dump($a);
    if($a == '')  
    {
        $errmsg.='<li>Field "Domain" should be http://***.com or https://***.com so on</li>';
    }   
   
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } 
    else 
    {    
        
        $sql = "UPDATE domains SET domain='{$_REQUEST[domain]}' WHERE id={$_REQUEST[id]}";
        $q = mysql_query($sql);
        
        $sql = "DELETE FROM domain_publisher WHERE domain_id={$_REQUEST[id]}";
        mysql_query($sql);
            
        $domain_id = $_REQUEST[id];
        $sql = "INSERT INTO domain_publisher(domain_id, pub_id) VALUES ";
    
        $count = 0;
        
        foreach ($_POST['publishers'] as $pub)
        {                                          
            $sql .= "( {$domain_id}, {$pub}),";                
        }
        $sql = substr($sql,0,-1);
        //var_dump($sql);exit;
        $q = mysql_query($sql);    
                
        //echo('<script language="JavaScript">window.location.href = "domain_list.php"</script>');            
        //break;
            
        
    }  
    
}
?>

<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link type="text/css" href="../common/multiselector/css/ui.multiselect.css" rel="stylesheet" />
<script type="text/javascript" src="../common/multiselector/js/plugins/localisation/jquery.localisation-min.js"></script>
<script type="text/javascript" src="../common/multiselector/js/ui.multiselect.js"></script>
<script type="text/javascript">
    $(function(){
        $.localise('ui-multiselect', {/*language: 'en',*/ path: '../common/multiselector/js/locale/'});
        $(".multiselect").multiselect({sortable: true, searchable: true});
        
    });
</script>
<div id="body">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER-->
                <!-- END STYLE CUSTOMIZER-->
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Edit Domain
                    <small>edit domain for publisher</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="domain_list.php">List Domain</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Edit Domain</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Edit Domain</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="domain_edit.php?id=<?= $_REQUEST[id]?>" class="form-horizontal" method="POST" id="edit_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span>Domain</label>
                                    <div class="controls">
                                        <input type="text" id="domain" name="domain" value="<?= $_REQUEST[domain] ?>" class="span6 popovers"  />
                                    </div>
                                </div>  
                                
                                <hr>           
                                        
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Assigned Publishers</label>
                                    <div class="controls">
                                        <select id="publishers" class="multiselect" multiple="multiple" name="publishers[]" style="display: none; width:500px;height: 250px;">
                                          <?php                                                                                                        
                                                $sql = "SELECT id, CONCAT(user_first_name, ' ', user_last_name) as publisher_name FROM users WHERE user_system_status=1 AND user_status=3 AND id NOT IN (SELECT pub_id FROM domain_publisher WHERE domain_id={$_REQUEST[id]})";
                                                //var_dump($sql);exit;
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                          ?>
                                                <option value="<?= $row[id]?>"> <?= $row[publisher_name]?></option>
                                          <?php
                                                }
                                                $sql = "SELECT id, CONCAT(user_first_name, ' ', user_last_name) as publisher_name FROM users WHERE user_system_status=1 AND user_status=3 AND id IN (SELECT pub_id FROM domain_publisher WHERE domain_id={$_REQUEST[id]})";
                                                //var_dump($sql);exit;
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                          ?>
                                                <option value="<?= $row[id]?>" selected > <?= $row[publisher_name]?></option>
                                          <?php
                                                }        

                                          ?>    
                                          </select>                                                 
                                    </div>    
                                 </div>

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#edit_form').submit();
                                            return false;"><i class="icon-check"></i> Save Domain</a>
                                    <a href="dashboard.php" class="btn">Cancel</a>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>

        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>

<? include 'z_footer.php'; ?>
