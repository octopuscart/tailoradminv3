<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css" rel="stylesheet" />

<!-- begin #content -->
<!-- begin #content -->
<div id="content" class="content content-full-width">

    <h1 class="page-header">Send Newsletter<small></small></h1>

    <!-- begin vertical-box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->

        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">

            <!-- begin wrapper -->
            <div class="wrapper">
                <div class="p-30 ">

                    <!-- begin email form -->
                    <!-- begin email to -->
                    <div class="row">
                        <div class="col-md-8 bg-white">
                            <div class="panel panel-default">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <!--tags-->
                                    <b class="control-label ">Newsletter Subject</b>
                                    <div class="m-b-15">
                                        <?php echo $templateobj["title"]; ?>
                                    </div>
                                    <hr/>
                                    <div class="m-b-15 ">
                                        <b class="control-label ">Newsletter Email Content</b>
                                        <div class="">
                                            <?php echo $templateobj["newsletter_content"]; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                        </div>
                        <div class="col-md-4 bg-gray-light">
                            <div class="panel panel-default">
                                <div class="panel-body" style="overflow-x: auto;">
                                    <b>Subscriber Emails</b><br/>
                                    <?php echo $templateobj["newsletter_type"]; ?>
                                    
                                    <hr/>
                                    <a href="<?php echo site_url(); ?>" class="btn btn-primary btn-block">SEND EMAIL</a>

                                    <table class="table">
                                        <tr>
                                            <th>Email</th>
                                        </tr>
                                        <?php
                                        foreach ($subscriptionlist as $slkey => $slvalue) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $slvalue["email"]; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end vertical-box-column -->
    </div>
    <!-- end vertical-box -->
</div>
<!-- end #content -->


<?php
$this->load->view('layout/footer');
?>

<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-wysiwyg.demo.min.js"></script>


<script>
    function changeCategory(cat_name, cat_id) {
        $("#category_name").text(cat_name);
        $("#category_id").val(cat_id);
    }

    $(function () {






        FormWysihtml5.init();


    })
</script>

