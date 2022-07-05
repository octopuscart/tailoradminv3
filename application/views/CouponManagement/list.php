<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE CSS STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>

<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->

    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Coupon Management</h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">
            <div class="col-md-3">
                <form action="#" method="post">
                    <div class="form-group">
                        <lable for="coupon_code">
                            Coupon Code
                        </lable>
                        <input type="text" name="code" class="form-control"  required="" />
                    </div>
                    <div class="form-group">
                        <lable for="coupon_code">
                            Value Type
                        </lable>
                        <select name="value type" class="form-control" required="">
                            <option value="Percent">Percent</option>
                            <option value="Fixed">Fixed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="coupon_code">
                            Value
                        </lable>
                        <input type="number" name="value" class="form-control"  required="" />
                    </div>
                    <div class="form-group">
                        <lable for="coupon_code">
                            Valid Till
                        </lable>
                        <input type="date" name="valid_till" class="form-control" min="<?php echo date("Y-m-d") ?>"  required="" />
                    </div>
                    <div class="form-group">
                        <lable for="coupon_code">
                            Coupon Type
                        </lable>
                        <select name="coupon_type" class="form-control" required="">
                            <option value="All User">For All User</option>
                            <option value="Individual User">For Individual User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="coupon_code">
                           Promotion Message
                        </lable>
                        <input type="text" maxlength="230" name="promotion_message" class="form-control"  required="" />
                    </div>

                    <div class="well well-sm">
                        <button type="submit" name="submitData" class="btn btn-primary">Add Coupon</button>
                    </div>
                    <div class="alert alert-danger">
                        1. Coupon code must be unique.<br/>
                        2. Individual User coupon type can be used only one time.<br/>
                    </div>
                </form>
            </div>

            <div class="col-md-9">
                <div class="table-responsive">
                    <table id="user" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Value</th>
                                <th>Value Type</th>
                                <th>Coupon Type</th>
                                <th>Valid Till</th>
                                <th>Promotion Message</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($coupon_list as $key => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value["id"]; ?></td>
                                    <td><?php echo $value["code"]; ?></td>
                                    <td><?php echo $value["value"]; ?></td>
                                    <td><?php echo $value["value_type"]; ?></td>
                                    <td><?php echo $value["coupon_type"]; ?></td>
                                    <td><?php echo $value["valid_till"]; ?></td>
                                    <td><?php echo $value["promotion_message"]; ?></td>
                                    <td><a href="<?php echo site_url("CouponManager/deleteCoupon/".$value["id"])?>" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end #content -->

<!-- Modal -->
<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="changePassword">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>



<?php
$this->load->view('layout/footer');
?>
<script>
    $(function () {


        $('#tags').tagit({
            availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
        });


        $('.edit_detail').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            $($(this).prev()).editable('toggle');
        });

        $(".editable").editable();



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