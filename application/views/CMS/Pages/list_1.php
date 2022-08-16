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
    <h1 class="page-header">Page List 

    </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">


            <div class="table-responsive col-md-12">

                <table id="user" class="table table-bordered table-striped" >

                    <tbody>

                        <?php
                        foreach ($pagelist as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo $value["title"]; ?>
                                </td>
                                <td>
                                    <?php echo $value["uri"]; ?>
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