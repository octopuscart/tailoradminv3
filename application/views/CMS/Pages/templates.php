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
    <h1 class="page-header">Newsletter Template List 

    </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">


            <div class="table-responsive col-md-12">

                <table id="user" class="table table-bordered table-striped" >

                    <tbody>

                        <?php
                        foreach ($templatelist as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>

                                <td>
                                    <span  id="bank" data-type="textarea" data-pk="<?php echo $value["id"]; ?>" data-name="title" data-value="<?php echo $value["title"]; ?>" data-params ={'tablename':'newsletter_template'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editable editable-click text-left" tabindex="-1" ><?php echo $value["title"]; ?>
                                    </span>
                                </td>


                                <td>
                                    <span  id="defaultpayment" data-type="select" data-pk="<?php echo $value["id"]; ?>" data-name="newsletter_type" data-value="<?php echo $value["newsletter_type"]; ?>" data-params ={'tablename':'newsletter_template'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselectnstypet editable-click" tabindex="-1" >
                                        <?php echo $value["newsletter_type"]; ?>
                                    </span>
                                </td>
                                <td>
                                    <span  id="defaultpayment" data-type="select" data-pk="<?php echo $value["id"]; ?>" data-name="status" data-value="<?php echo $value["status"]; ?>" data-params ={'tablename':'newsletter_template'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselectnsstatus editable-click" tabindex="-1" >
                                        <?php echo $value["status"]; ?>
                                    </span>
                                </td>
                                <td>
                                    <div id="templatecheck<?php echo $value["id"]; ?>" style="display: none;"><?php echo $value["newsletter_content"]; ?></div>
                                    <button type="button" class="btn btn-primary p-l-40 p-r-40" onclick="openModelViewer('templatecheck<?php echo $value["id"]; ?>')" data-toggle="modal" data-target="#add_item"><i class="fa fa-eye"></i> View Template</button>

                                </td>
                                <td>
                                    <a href="<?php echo site_url("CMS/sendNewsLetter/" . $value["id"]) ?>"  class="btn btn-warning">Send Newsletter</a>
                                </td>

                            </tr>




                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end #content -->

<!-- Modal -->
<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="changePassword">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Template</h4>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <div id="templateviewer"></div>

            </div>

        </div>
    </div>
</div>


<?php
$this->load->view('layout/footer');
?>
<script>
    function openModelViewer(templateid) {
        $("#templateviewer").html($("#" + templateid).html());
    }

    $(function () {




    $('.edit_detail').click(function (e) {
    e.stopPropagation();
            e.preventDefault();
            $($(this).prev()).editable('toggle');
    });
            $(".editable").editable();
            $('.editableselectnsstatus').editable({
    source: {
    'Active': 'Active',
            'Inactive':'Inactive'
    }
    });
            $('.editableselectnstypet').editable({
    source: {
<?php
$ns_type = [
    'Full Experience',
    'Sales Or Promotion',
    'New Arrival',
    'Monthly Subscription'
];
foreach ($ns_type as $key => $value) {
    ?>
        '<?php echo $value; ?>': '<?php echo $value; ?>',
    <?php
}
?>
    }

    });
    });
</script>