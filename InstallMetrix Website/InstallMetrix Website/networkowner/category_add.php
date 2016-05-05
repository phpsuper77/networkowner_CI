<?
include 'z_header.php';


FB::log($_SERVER);

// id : categoriy's id

if ($_REQUEST[tryout] == '1') {

    //var_dump($_REQUEST);exit;
    $errmsg = '';
    
    if($_REQUEST[name]=='')
    {
        $errmsg .= '<li>Field "Category Name" should not be empty</li>';   
    }
    else
    {
        $sql = "select id from categories where name='{$_REQUEST[name]}'";
        $q = mysql_query($sql);
        if (mysql_num_rows($q) != 0) 
        {
              $errmsg.='<li>The name already exists.</li>';     
        }
        else
        {
            $sql = "insert into categories (name,lastdate) values ('{$_REQUEST[name]}',NOW()) ";
            mysql_query($sql);
            $category_id = mysql_insert_id();
            echo('<script language="JavaScript">window.location.href = "category_edit.php?id=' . $category_id . '"</script>');
            break;    
        }
    }

    if ($errmsg != '') {
        $usermessage = '<b>Please correct the following errors:</b><br><ul>';
        $usermessage .= $errmsg;
        $usermessage .= '</ul>';
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
                    Add Category
                    <small>add new Category</small>
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="dashboard.php">Home</a> <span class="divider">/</span>
                    </li>
                    <li><a href="category_list.php">Category List</a><span class="divider">/</span></li>
                    <li><a href="#">Add Category</a></li>
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
                            <h4><i class="icon-reorder"></i>  Category Settings</h4>
                        </div>
                        <div class="widget-body form">
                            <!-- BEGIN FORM--> 
                            <form action="category_add.php" class="form-horizontal" method="POST" id="add_form" enctype="multipart/form-data">
                                <input type="hidden" name="tryout" value="1"/>                                                                 
                                <div class="control-group">
                                    <label class="control-label" for="input3"><span style="color: #FF0000; font-weight: bold; font-size: 10px; margin-top: -3px;"><i class="icon-asterisk"></i></span> Category Name</label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" value="" class="span6 popovers"  />
                                    </div>
                                </div>                          

                                <div class="form-actions">
                                    <a href="#" class="btn btn-success" onclick="$('#add_form').submit();
                                            return false;"><i class="icon-check"></i> Save Category </a>                                    
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
