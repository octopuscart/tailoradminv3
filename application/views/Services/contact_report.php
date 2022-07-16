<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<!-- Main content -->
<section class="content">
    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="index-5">
                <div class="panel-heading">
                    <h4 class="panel-title" style ="font-size:17px; font-weight:500; ">
                        <i class="fa fa-list"></i>  Contact From Report
                    </h4>



                </div>


                <div class="panel panel-body" style='overflow: overlay;'>
                    <div class="row">
                        <?php
                        $this->load->view('layout/orderdates');
                        ?>
                    </div>
                    <hr/>
                    <div class="row">
                        <table id="location_table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <?php
                                    $reportheader = [
                                        'id',
                                        'last_name',
                                        'first_name',
                                        'email',
                                        'message',
                                        'contact',
                                        'subject',
                                        'datetime',];

                                    foreach ($reportheader as $hkey => $hvalue) {
                                        ?>
                                        <th ><?php echo strtoupper(($hvalue)); ?></th>
                                        <?php
                                    }
                                    ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($reports as $key => $value) {
                                    echo "<tr><td>" . ($key + 1) . "</td>";
                                    foreach ($reportheader as $hkey => $hvalue) {
                                        ?>
                                    <td><?php echo $value[$hvalue]; ?></td>
                                    <?php
                                }
                                echo "</tr>";
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- /.row -->
</section>
<!-- /.content -->

<?php
$this->load->view('layout/footer');
?> 
<script src="<?php echo base_url(); ?>assets_main/tinymce/js/tinymce/tinymce.min.js"></script>


<script>


    $(function () {
        $("#daterangepicker").daterangepicker({
            format: 'YYYY-MM-DD',
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                "Today's": [moment(), moment()],
                "Yesterday's": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function (start, end, label) {
            $('input[name=daterange]').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
        $('#location_table').DataTable({

            "language": {
                "search": "Search Order By Email, First Name, Last Name Etc."
            },
            dom: 'Blfrtip',
            buttons: [
                'excel', 'pdf', 'csv', 'print'
            ]
        })
    })
</script>
