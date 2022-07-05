<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- Main content -->
<section class="content">
    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> <i class="fa fa-edit"></i> Set Appointment Location</h3>

                
                </div>
                <div class="panel-body ">
                  
                        <form method="post">
                            <div class="col-md-12"> 
                                <div class="col-md-4">
                                    <input type="hidden" name="place_id">
                                    <div class="form-group">
                                        <label class="control-label" style="">Hotel Name</label>
                                        <input type="text" class="time start form-control" name="location"  />
                                    </div>
                                </div>

                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label class="control-label" style="">Hotel Address or Fill Flat/House No.</label>
                                        <input type="text" class="time start form-control"  id="address2" name="address2"/>

                                    </div>
                                </div>          
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" style="">City</label>
                                        <input type="text" class="time start form-control" name="city"   />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" style="">State</label>
                                        <input type="text" class="time start form-control" name="state"   />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" style="">Country</label>
                                        <input type="text" class="time start form-control" name="country"   />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" style="">Contact No.</label>
                                        <input type="text" class="time start form-control" name="contact_no"   />
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <label class="control-label" style="">Select From Date and To Date</label>

                                    <div class="input-group default-daterange" id="default-daterange">
                                        <input type="text" name="default-daterange" class="form-control" value="2018-10-15  To  2018-10-15" placeholder="click to select the date range"/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">

                                    <label class="control-label" style="">Total Days</label>

                                    <div class="input-group " >
                                        <input type="text" name="total_days" class="form-control" value="" placeholder="Total Days"/>

                                    </div>
                                </div>

                                <div class="col-md-6">


                                    <div class="row row-space-10" id="basicExample1">
                                        <div class="col-md-6">
                                            <label class="control-label" style="float:left;width: 100%">Select From Time</label>
                                            <select id="fromhour"  class="form-control" style="width: 65px;float:left;" onclick="fromDateChange()">
                                                <option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>                                </select>
                                            <select id="fromminut" class="form-control " style="width: 65px;float:left;"  onclick="fromDateChange()">
                                                <option>00</option><option>15</option><option>30</option><option>45</option>                                </select>
                                            <select id="fromampm" class="form-control " style="width: 65px;float:left;"  onclick="fromDateChange()">
                                                <option>AM</option>
                                                <option>PM</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label" style="float:left;width: 100%">Select To Time</label>
                                            <select id="tohour"  class="form-control" style="width: 65px;float:left;"  onclick="toDateChange()">
                                                <option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option><option>09</option><option>10</option><option>11</option><option>12</option>                                </select>
                                            <select id="tominut" class="form-control " style="width: 65px;float:left;"  onclick="toDateChange()">
                                                <option>00</option><option>15</option><option>30</option><option>45</option>                                </select>
                                            <select id="toampm" class="form-control " style="width: 65px;float:left;"  onclick="toDateChange()">
                                                <option>AM</option>
                                                <option>PM</option>
                                            </select>
                                        </div>
                                        <input type="hidden" class="time start form-control" name="start_time"  placeholder="Start Time" />

                                        <input type="hidden" class="time end form-control" name="end_time"  placeholder="End Time" />
                                    </div>


                                </div>


                            </div>
                            <div style="clear:both"></div><br/>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <button name="submit" type="submit" class="btn btn-info  submitBtn">Submit</button>
                                </div>
                            </div>

                        </form>

                </div>
            </div>
            <!-- /.col -->
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
                                        tinymce.init({selector: 'textarea', plugins: 'advlist autolink link image lists charmap print preview'});


                                    })


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
                                        $('#tableDataOrder').DataTable({
                                            "language": {
                                                "search": "Search Order By Email, First Name, Last Name Etc."
                                            }
                                        })
                                    })
</script>
