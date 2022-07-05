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
    <h1 class="page-header">Shipping & Payment Configuration <small>Here you can set shipping and payment settings.</small></h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">

        <div class="panel-body">


            <div class="table-responsive col-md-7">

                <table id="user" class="table table-bordered table-striped" >

                    <tbody>
                        <tr>
                            <th colspan="2">
                                <h4>Enable/Disable Payment Settings</h4>
                              
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 300px;">PayPal Payment</th>

                            <td>
                                <span  id="paypal" data-type="select" data-pk="2" data-name="payment_paypal" data-value="<?php echo $configuration_payment["payment_paypal"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselect editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["payment_paypal"]; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Bank Payment</th>

                            <td>
                                <span  id="bank" data-type="select" data-pk="2" data-name="payment_bank" data-value="<?php echo $configuration_payment["payment_bank"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselect editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["payment_bank"]; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Cheque Payment</th>

                            <td>
                                <span  id="paypal" data-type="select" data-pk="2" data-name="payment_cheque" data-value="<?php echo $configuration_payment["payment_cheque"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselect editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["payment_cheque"]; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Cash On Delivery Payment</th>

                            <td>
                                <span  id="paypal" data-type="select" data-pk="2" data-name="payment_cod" data-value="<?php echo $configuration_payment["payment_cod"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselect editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["payment_cod"]; ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Select Default Payment</th>

                            <td>
                                <span  id="defaultpayment" data-type="select" data-pk="2" data-name="default_payment_mode" data-value="<?php echo $configuration_payment["default_payment_mode"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselectdefaultpayment editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["default_payment_mode"]; ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2"></th>
                        </tr>
                         <tr>
                            <th colspan="2"></th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <h4>Shipping Settings</h4>
                             
                            </th>
                        </tr>
                        <tr>
                            <th>Default Shipping Amount (in <?php echo GLOBAL_CURRENCY ?>)</th>

                            <td>
                                <span  id="shipping_price" data-type="number" data-pk="2" data-name="shipping_price" data-value="<?php echo $configuration_payment["shipping_price"]; ?>" data-params ={'tablename':'configuration_cartcheckout'} data-url="<?php echo site_url("LocalApi/updateCurd"); ?>" data-mode="inline" class="m-l-5 editableselect editable-click" tabindex="-1" >
                                    <?php echo $configuration_payment["shipping_price"]; ?>
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end #content -->


<?php
$this->load->view('layout/footer');
?>
<script>
    $(function () {




        $('.edit_detail').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            $($(this).prev()).editable('toggle');
        });

        $(".editable").editable();

        $('.editableselect').editable({
            source: {
                'on': 'on',
                'off': 'off'
            }
        });

        $('.editableselectdefaultpayment').editable({
            source: {
                'PayPal': 'PayPal',
                'Bank Transfer': 'Bank Transfer',
                'Cash On Delivery': 'Cash On Delivery',
                'Cheque On Delivery': 'Cheque On Delivery'
            }
        });




    });
</script>