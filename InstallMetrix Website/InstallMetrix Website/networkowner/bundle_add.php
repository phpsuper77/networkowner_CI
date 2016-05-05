<?
include 'z_header.php';


if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    //var_dump($_REQUEST);exit;
    if ($_REQUEST[bundle_name] == '') {
        $errmsg.='<li>Field "Bundle Name" should not be empty</li>';
    }

    $sql = "SELECT * from bundles WHERE name='{$_REQUEST[bundle_name]}'";
    $q = mysql_query($sql); 
    $c = mysql_numrows($q);
    //var_dump($c);exit;
    if($c>0)
    {
         $errmsg.="<li>The Bundle named {$_REQUEST[bundle_name]} is existing already, please put other name</li>";
    }

    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
    } else {
        
                                    
        $sql =  "INSERT INTO bundles( name ) VALUES ( '{$_REQUEST[bundle_name]}' )";   
            
        mysql_query($sql);
        
        echo('<script language="JavaScript">window.location.href = "bundle_list.php"</script>');
        break;
    }
}
?>

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
                    Add New Offer Bundle
                    <small>add new bundle</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="bundle_list.php">Offers Bundle List</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New Offer Bundle</a></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div id="page">

            <? if ($usermessage != '') { ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <?= $usermessage ?>
                </div>
            <? } ?>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>  Add New Offer Bundle</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="bundle_add.php" class="form-horizontal" method="POST" id="add_form">
                                <input type="hidden" name="tryout" value="1"/>
  
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Offer Bundle Name</label>
                                    <div class="controls">
                                        <input type="text" id="bundle_name" name="bundle_name" value="<?= $_REQUEST[bundle_name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the offer bundle' data-original-title="Offer Bundle Name" />
                                    </div>
                                </div>
                                 
                                <hr>
             
                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick=" $('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Bundle</a>
                                    <a href="bundle_list.php" class="btn">Cancel</a>
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