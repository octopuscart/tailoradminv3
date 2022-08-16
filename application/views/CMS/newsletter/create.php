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

    <h1 class="page-header">Newsletter Templates<small></small></h1>

    <!-- begin vertical-box -->
    <div class="vertical-box">
        <!-- begin vertical-box-column -->

        <!-- end vertical-box-column -->
        <!-- begin vertical-box-column -->
        <div class="vertical-box-column">

            <!-- begin wrapper -->
            <div class="wrapper">
                <div class="p-30 bg-white">

                    <!-- begin email form -->
                    <form action="#" method="post" enctype="multipart/form-data">
                        <!-- begin email to -->


                        <!--tags-->
                        <label class="control-label">Newsletter Title</label>
                        <div class="m-b-15">
                            <input  class="form-control "   name="title" required="" value="<?php echo $nsobj["title"]; ?>"/>
                        </div>
                        <br/>

                        <div class="m-b-15 row">
                            <div class="m-b-15 col-md-3">
                                <label class="control-label">Newsletter Type</label>
                                <select  name='newsletter_type' class='form-control'>
                                    <?php
                                    $ns_type = [
                                        'Full Experience',
                                        'Sales Or Promotion',
                                        'New Arrival',
                                        'Monthly Subscription'
                                    ];
                                    foreach ($ns_type as $key => $value) {
                                        ?>
                                        <option value='<?php echo $value; ?>' <?php echo ($nsobj["newsletter_type"] == $value ? 'selected' : ''); ?> ><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end email subject -->

                        <!-- begin email content -->

                        <div class="m-b-15 row">
                            <div class="col-md-12">
                                <label class="control-label">Newsletter Content:</label>
                                <textarea  class="textarea form-control ckeditor"   rows="8" name="newsletter_content" required="">
                                    <?php echo $ns_header; ?>
<div>Hello,</div>

<div>As one of Hong Kong&#39;s leading custom tailors, we are proud of our international reputation for making the highest quality tailored clothing.&nbsp;</div>

<div>We are known across the globe for professionally hand-crafted suits, shirts, leather jackets, sports jackets and Tuxedo from Hong Kong.</div>

<div>&nbsp;</div>

<div>We have 10% Off Coupon on all orders.<span style="white-space:pre"> </span></div>

<div>&nbsp;</div>

<h1>RH10</h1>

<div>(Use this coupon now) 
                                        <?php echo $nsobj["newsletter_content"]; ?>
                                        <?php echo $ns_footer; ?>
                                </textarea>
                            </div>
                        </div>







                        <!-- end email content -->
                        <button type="submit" name="update_data" class="btn btn-primary p-l-40 p-r-40">Save Template</button>
                    </form>
                    <!-- end email form -->
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

