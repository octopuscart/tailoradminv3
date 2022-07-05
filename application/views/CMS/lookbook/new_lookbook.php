<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<!-- begin #content -->
<!-- begin #content -->
<div id="content" class="content content-full-width">
    <!-- begin vertical-box -->
    <div class="vertical-box">

        <div class="vertical-box-column">

            <!-- begin wrapper -->
            <div class="wrapper col-md-5">
                <div class="p-30 bg-white">
                    <!-- begin email form -->

                    <form action="#" method="post" enctype="multipart/form-data">

                        <div class="thumbnail">
                            <img src="<?php echo base_url(); ?>/assets/product_images/default2.png" style="height:200px;width:100px">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label col-form-label">Set Cover Image</label>
                                    <div class="input-group">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name='picture' id="inputGroupFile01" file-model="filename" required="">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                        <br/>

                                    </div>
                                    <p>W:600px X H:800px</p>
                                </div>
                            </div>
                        </div>
                        <label class="control-label">Add Image:</label>
                      
                        <!-- end email to -->
                        <!-- begin email subject -->
                        <label class="control-label">Style No.:</label>
                        <div class="m-b-15">
                            <input type="text" class="form-control" name="title" required="" />
                        </div>
                        <!-- end email subject -->
                        <!-- begin email content -->




                        <!-- end email content -->
                        <button type="submit" name="submit_data" class="btn btn-primary p-l-40 p-r-40">Add Book</button>
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
<script>
    function changeCategory(cat_name, cat_id) {
        $("#category_name").text(cat_name);
        $("#category_id").val(cat_id);
    }

    $(function () {






<?php
$checklogin = $this->session->flashdata('checklogin');
if ($checklogin['show']) {
    ?>
            $.gritter.add({
                title: "<?php echo $checklogin['title']; ?>",
                text: "<?php echo $checklogin['text']; ?>",
                image: '<?php echo base_url(); ?>assets/emoji/<?php echo $checklogin['icon']; ?>',
                            sticky: true,
                            time: '',
                            class_name: 'my-sticky-class '
                        });
    <?php
}
?>
                })
</script>