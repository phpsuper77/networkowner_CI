<?
include 'z_header.php';


FB::log($_SERVER);

  

if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    if ($_REQUEST[exiturl] == '') {
        $errmsg.='<li>Field "Exit URL" should not be empty</li>';
    }    
   
    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } 
    else 
    {    
        
        $sql = "SELECT * FROM exiturl WHERE exiturl='{$_REQUEST[exiturl]}'";
        $q = mysql_query($sql);
        $cc = mysql_numrows($q);
        if($cc > 0)
        {
            //already existed
            $usermessage = '<b>Please correct the following errors:</b><br><ul>';
            $usermessage .= "The url is already existed";
            $usermessage .= '</ul>';
        }
        else
        {
            $sql = "INSERT INTO exiturl(exiturl) VALUES ('{$_REQUEST[exiturl]}')";
            mysql_query($sql);
            $exiturl_id = mysql_insert_id();
            
            $sql = "INSERT INTO exiturl_campaigns(exiturl_id, proj_id) VALUES ";
        
            $count = 0;
            
            foreach ($_POST['campigns'] as $campaign)
            {                                          
                $sql .= "( {$exiturl_id}, {$campaign}),";                
            }
            $sql = substr($sql,0,-1);
            //var_dump($sql);exit;
            $q = mysql_query($sql);    
        }
        
        echo('<script language="JavaScript">window.location.href = "exiturl_list.php"</script>');            
        break;
            
        
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
                    Add New URL
                    <small>add new url for campign</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New URL</a></li>
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
                            <h4><i class="icon-reorder"></i>  Add new URL</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="exiturl_add.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>

                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Exit URL</label>
                                    <div class="controls">
                                        <input type="text" id="exiturl" name="exiturl" value="<?= $_REQUEST[exiturl] ?>" class="span6 popovers"  />
                                    </div>
                                </div>  
                                
                                <hr>           
                                        
                                <div class="control-group">
                                    <label class="control-label" for="input3"> Assigned Campign</label>
                                    <div class="controls">
                                        <select id="campigns" class="multiselect" multiple="multiple" name="campigns[]" style="display: none; width:500px;height: 250px;">
                                          <?php                                                                                                        
                                                $sql = "SELECT id, proj_name FROM projects WHERE status=0 ";
                                                //var_dump($sql);exit;
                                                $q = mysql_query($sql);
                                                while ($row = mysql_fetch_assoc($q)) {
                                          ?>
                                                <option value="<?= $row[id]?>"> <?= $row[proj_name]?></option>
                                          <?php
                                                }
                                                
                                                       
                                          ?>    
                                          </select>                                                 
                                    </div>    
                                 </div>

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save URL</a>
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
