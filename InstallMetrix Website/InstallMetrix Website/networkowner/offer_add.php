<?
include 'z_header.php';


if ($_REQUEST[tryout] == '1') {

    $errmsg = '';

    if ($_REQUEST[offer_name] == '') {
        $errmsg.='<li>Field "Application Name" should not be empty</li>';
    }

    

    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
           
    } else {
        
        $sql =  "INSERT INTO `offers`(
            `user_id`,            
            `offer_name`
            ) VALUES (
            '{$_SESSION[user_id]}',            
            '{$_REQUEST[offer_name]}'
            )";   
            
        //var_dump($sql);exit;
        mysql_query($sql);

        $offer_id = mysql_insert_id();
        
        // insert data into offer_prices_country
        $sql = "INSERT INTO offer_prices_country(offer_id, country_id, price) VALUES 
                ({$offer_id}, 0, 0), ({$offer_id}, 17, 0), ({$offer_id}, 39, 0), ({$offer_id}, 57, 0), 
                ({$offer_id}, 75, 0), ({$offer_id}, 77, 0), ({$offer_id}, 223, 0) 
        ";
        //var_dump($sql);exit;
        mysql_query($sql);
                
        $str = "<script language='JavaScript'>window.location.href = 'offer_edit.php?oid={$offer_id}'</script>";
        //var_dump($str);exit;
        echo($str);
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
                    Add New Offer
                    <small>add new application offer</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="offer_list.php">Offers List</a> <span class="divider">/</span>
                    </li>
                    <li><a href="#">Add New Offer</a></li>
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
                            <h4><i class="icon-reorder"></i>  Add New Offer</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM-->
                            <form action="offer_add.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>
  
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Offer Name</label>
                                    <div class="controls">
                                        <input type="text" id="software_name" name="offer_name" value="<?= $_REQUEST[offer_name] ?>" class="span6 popovers" data-trigger="hover" data-content='The name of the offer application, which will be installed. This name will be shown in your installer. Eg: "Firefox"' data-original-title="Main Software Name" />
                                    </div>
                                </div>                                

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick=" $('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Offer</a>
                                    <a href="offer_list.php" class="btn">Cancel</a>
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