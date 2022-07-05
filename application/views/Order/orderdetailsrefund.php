<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>


<section class="content" style="min-height: auto;">

    <div class="row">
        <!--title row--> 
        <div class="col-md-12">



            <div class="col-md-9">


                <div class="panel panel-default">
                    <div class="panel-heading with-border">
                        <h3 class="panel-title">Order No.:<?php echo $ordersdetails['order_data']->order_no; ?></h3>
                    </div>
      <div class="panel panel-default">
                            <div class="panel-body">
                                <h2>Step 1: Refund to customer</h2>
                                <p>Go to your payment admin link and do payment manually to customer and enter details in step 2.</p>
                            </div>
                        </div>

                    <form role="form" action="#" method="post">

                        <div class="panel-body">
                            <h2>Step 2: Enter Refund Details</h2><br/>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Order Status</label>
                                    <?php if ($status != 'Other') { ?>
                                        <input class="form-control" readonly="" name="status" value="<?php echo $status; ?>">
                                    <?php } else { ?>
                                        <input class="form-control"  name="status" value="<?php echo $status != 'Other' ? $status : ''; ?>">
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Remark <small>(It will be subject of email.)</small></label>
                                    <input type="text" class="form-control" placeholder="Remark for order status" value="Your refund has been processed."  name="remark" required="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description <small>(Enter reson of refund and refund ID#)</small></label>
                                    <textarea class="form-control" placeholder="Type Here"  name="description"></textarea>
                                </div>
                            </div>

                        </div>
                        <!--/.panel-body--> 

                        <div class="panel-footer ">
                            <div class="row form-group">
                                <div class="col-md-4" style="   ">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="sendmail" checked="true">
                                            Notify to customer by mail.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary btn-lg" style="    font-size: 13px;" name="submit" value="submit">Submit</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <?php
                $this->load->view('Order/orderstatusside');
                ?>
            </div>
        </div>
    </div>


 
</section>

   <?php
    $this->load->view('Order/orderinfocomman');
    ?> 

<div class="clearfix"></div>





<?php
$this->load->view('layout/footer');
?> 
