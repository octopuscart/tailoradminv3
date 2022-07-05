<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<style>
    .product_image{
        height: 200px!important;
    }
    .product_image_back{
        background-size: contain!important;
        background-repeat: no-repeat!important;
        height: 200px!important;
        background-position-x: center!important;
        background-position-y: center!important;
    }
</style>
<style>
    .cartbutton{
        width: 100%;
        padding: 6px;
        color: #fff!important;
    }
    .noti-check1{
        background: #f5f5f5;
        padding: 25px 30px;

        font-weight: 600;
        margin-bottom: 30px;
    }

    .noti-check1 span{
        color: red;
        color: red;
        width: 111px;
        float: left;
        text-align: right;
        padding-right: 13px;
    }

    .noti-check1 h6{
        font-size: 15px;
        font-weight: 600;
    }

    .address_block{
        background: #fff;
        border: 3px solid #d30603;
        padding: 5px 10px;
        margin-bottom: 20px;

    }
    .checkcart {
        border-radius: 50%;
        position: absolute;
        top: -12px;
        left: 2px;
        font-size: 6px;
        padding: 4px;
        background: #fff;
        border: 2px solid green;
    }


    .default{
        border: 2px solid green;
    }

    .default{
        border: 2px solid green;
    }

    .checkcart i{
        color: green;
    }



    .cartdetail_small {
        float: left;
        width: 203px;
    }

    .subtext{
        margin-left: 10px;
        margin-left: 17px;
        color: black;
        font-weight: 400;
    }

</style>

<style>
    .order_box{
        padding: 10px;
        padding-bottom: 11px!important;
        height: 110px;
        border-bottom: 1px solid #c5c5c5;
    }
    .order_box li{
        line-height: 19px!important;
        padding: 7px!important;
        border: none!important;
    }

    .order_box li i{
        float: left!important;
        line-height: 19px!important;
        margin-right: 13px!important;
    }

    .blog-posts article {
        margin-bottom: 10px;
    }
</style>
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!--sweet alert-->
<script src="<?php echo base_url(); ?>assets/sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/sweetalert2/sweetalert2.min.css">



<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<!-- Main content -->
<section class="content" ng-controller="UserController">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php
                    if ($user_details->image) {
                        echo base_url() . 'assets/profile_image/' . $user_details->image;
                    } else {
                        echo ( base_url() . "assets/dist/img/avatar5.png");
                    }
                    ?>" alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $user_details->first_name; ?> <?php echo $user_details->last_name; ?></h3>

                    <p class="text-muted text-center"><?php echo $user_details->user_type; ?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><i class="fa fa-phone"></i>  Contact no.</b> <br/><a class="subtext"><?php echo $user_details->contact_no; ?></a>
                        </li>
                        <li class="list-group-item">

                            <b> <i class="fa fa-<?php echo strtolower($user_details->gender); ?>"></i>   Gender</b> <br/><a class="subtext"><?php echo $user_details->gender; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-birthday-cake"></i>  Date Of Birth</b> <br/><a class="subtext"><?php echo $user_details->birth_date; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-suitcase"></i>  Profession</b> <br/><a class="subtext"><?php echo $user_details->profession; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-globe"></i>  Country</b><br/> <a class="subtext"><?php echo $user_details->country; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-calendar"></i> Registration Date</b> <br/><a  style="font-size: 12px"><?php echo $user_details->registration_datetime; ?></a>
                        </li>
                    </ul>

                    <form method="post" action="#">
                        <div class="button-group">
                            <button type="submit" name="delete_user" class="btn btn-danger subtext  btn-sm" value="<?php echo $user_details->id; ?>" >Delete User</button>
                            <button type="submit" name="<?php echo $user_details->status == 'Blocked' ? 'unblock_user' : 'block_user'; ?>" class="btn btn-sm btn-<?php echo $user_details->status == 'Blocked' ? 'success' : 'warning'; ?> subtext" value="<?php echo $user_details->id; ?>" style="margin-right: 10px"><?php echo $user_details->status == 'Blocked' ? 'Unblock User' : 'Block User'; ?></button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#orderslist" data-toggle="tab">Orders</a>
                    </li>
                    <li>
                        <a href="#address" data-toggle="tab">Address</a>
                    </li>
                    <li>
                        <a href="#desingProfile" data-toggle="tab">Design Profiles</a>
                    </li>
                    <li>
                        <a href="#measurementProfile" data-toggle="tab">Measurements</a>
                    </li>
                    <li>
                        <a href="#newsletter" data-toggle="tab">Newsletters Preferences</a>
                    </li>
                    <li>
                        <a href="#loginHistory" data-toggle="tab">Customer Log</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="orderslist">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="orderslisttable" class="table  display"">
                                    <thead>
                                        <tr>
                                            <th>Order Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($orderslist)) {
                                            foreach ($orderslist as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="col-md-12  "> 
                                                            <div class="pricing">
                                                                <article class="order_box" style="padding: 10px">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <h6 style="font-weight: bold;">
                                                                                Order No. #<?php echo $value->order_no; ?>
                                                                            </h6>
                                                                            Total Amount: {{<?php echo $value->total_price; ?>|currency:" "}}
                                                                            <br/>
                                                                            Total Products: {{<?php echo $value->total_quantity; ?>}}
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <span >
                                                                                <i class="fa fa-calendar"></i> <?php echo $value->order_date; ?>  <?php echo $value->order_time; ?>
                                                                            </span><br/>
                                                                            Status: <?php echo $value->status; ?>

                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <a href="<?php echo site_url('order/orderdetails/' . $value->order_key); ?>" class="btn btn-default btn-small" style="margin: 0px;    float: right;">View Order <i  class="fa fa-arrow-right"></i> </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" style="margin-top: 10px;">

                                                                        <div class="col-md-6 orderlist_stylemes">
                                                                            <b>Sizes:</b>  <span style="font-weight: 500"><?php echo $value->measurement_style; ?></span>
                                                                        </div>
                                                                    </div>

                                                                </article>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                        <h4><i class="fa fa-warning"></i> No order found</h4>
                                        <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="address">
                        <div class="row">
                            <div class="col-md-12" style="margin-top:25px;">
                                <?php
                                if (count($user_address_details)) {
                                    ?>
                                    <?php
                                    foreach ($user_address_details as $key => $value) {
                                        ?>
                                        <div class="col-md-12">
                                            <?php if ($value['status'] == 'default') { ?> 
                                                <div class="checkcart <?php echo $value['status']; ?> ">
                                                    <i class="fa fa-check fa-2x"></i>
                                                </div>
                                            <?php } ?> 
                                            <div class=" address_block <?php echo $value['status']; ?> ">
                                                <p>
                                                    <?php echo $value['address1']; ?>,<br/>
                                                    <?php echo $value['address2']; ?>,<br/>
                                                    <?php echo $value['city']; ?>, <?php echo $value['state']; ?>, <?php echo $value['country']; ?>, <?php echo $value['zipcode']; ?>
                                                </p>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h4><i class="fa fa-warning"></i> No Shipping Address Found</h4>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>  
                    </div>
                    <!-- /.tab-pane -->

                    <!--mesurement profiles-->
                    <div class="tab-pane" id="measurementProfile">

                        <table class="table">
                            <tr>
                                <th>
                                    Profile ID
                                </th>

                                <th>
                                    Recent Used
                                </th>
                                <th>
                                    Created On
                                </th>
                                <th></th>
                            </tr>
                            <tr ng-repeat="(meskey, mesval) in measurementsDict.premeasurements">
                                <th>
                                    {{mesval.name}}

                                </th>
                                <td>
                                    {{mesval.order_no}}

                                </td>


                                <td>{{mesval.meausrement_data.datetime}}</td>
                                <td>                                
                                    <a href="<?php echo site_url("Order/selectPreviouseMeasurementProfilesReport"); ?>/{{mesval.meausrement_data.id}}/1" class="btn btn-default"  title ="Dowload Profile"><i class="fa fa-download"></i></a>
                                    <button type="button" ng-click="viewMeasurementOnly(mesval.name, mesval.measurements)" class="btn btn-default  btn-small-xs"  >View</button>

                                    <button type="button" ng-click="setAsFavorite(mesval.meausrement_data.id, mesval.meausrement_data.status)" class="btn btn-default btn-small-xs"  title ="Favorite Profile"><i class="text-danger fa {{mesval.meausrement_data.status=='f'?'fa-heart':'fa-heart-o'}}"></i></button>

                                </td>
                            </tr>

                        </table>
                    </div>

                    <!--desing profiles-->
                    <div class="tab-pane" id="desingProfile">
                        <table class="table">
                            <tr>
                                <th>
                                    Profile ID
                                </th>

                                <th>
                                    Recent Used
                                </th>

                                <th></th>
                            </tr>
                            <tr ng-repeat="style in customizationDict.prestyle">
                                <th>
                                    {{style.name}}


                                </th>

                                <td>
                                    {{style.order_no}}
                                    <br/> <small>  {{style.cart_data.op_date_time}}</small>
                                </td>

                                <td>

                                    <a href="<?php echo site_url("Order/selectPreviouseProfilesReport"); ?>/{{style.cart_data.id}}/1" class="btn btn-default"  title ="Dowload Profile"><i class="fa fa-download"></i></a>

                                    <button type="button" ng-click="viewStyleOnly(style.cart_data.item_name, style.style)" class="btn btn-default btn-small-xs"  title ="Update Profile">View</button>
                                    <button type="button" ng-click="setAsFavorite(style.cart_data.id, style.cart_data.status)" class="btn btn-default btn-small-xs"  title ="Favorite Profile"><i class="text-danger fa {{style.cart_data.status=='f'?'fa-heart':'fa-heart-o'}}"></i></button>

                                </td>

                            </tr>
                        </table>

                    </div>


                    <!--newsletter preference-->
                    <div class="tab-pane" id="newsletter">
                        <div class="row " >
                            
                           

                 
                            <div class="col-md-10" id="block_frequncey">

                                <div ng-if="newsalertDict.user_subscription.has_subscription == 'no'">
                                    <h3>You have no subscription.</h3>
                                </div>
                                <div ng-if="newsalertDict.user_subscription.has_subscription != 'no'">
                                    <p>Your newsletter frequency preference</p>
                                    <h3>{{newsalertDict.user_subscription.subscription_data.newsletter_type}}</h3>
                                    <br/>
                                    <p>Updated On</p>
                                    <span style="margin: 0px">
                                        <i class="fa fa-calendar"></i> {{newsalertDict.user_subscription.subscription_data.c_date}} {{newsalertDict.user_subscription.subscription_data.c_time}}
                                    </span>
                                </div>



                            </div>
                        </div>
                    </div>

                    <!--login history-->
                    <div class="tab-pane" id="loginHistory">
                        <div class="row">
                            <div class="col-md-12" style="margin-top:25px;">
                                <div class="" >
                                    <h4>User Log</h4>
                                    <p>User login and other activity log</p>

                                    <table id="tableDataOrder" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px;">S.N.</th>
                                                <th style="width:50px;">Activity Type</th>
                                                <th style="width: 75px;">Details</th>
                                                <th style="width: 100px;">Date Time </th>

                <!--                <th style="width: 75px;">Edit</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($systemlog)) {

                                                $count = 1;
                                                foreach ($systemlog as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>



                                                        <td>
                                                            <?php echo $value->log_type; ?>
                                                        </td>

                                                        <td>
                                                            <?php echo $value->log_detail; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $value->log_datetime; ?>
                                                        </td>



                                                    </tr>
                                                    <?php
                                                    $count++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <!-- /.tab-pane -->


                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

<script>
    var adminurl = "<?php echo site_url(); ?>";
    var user_id = <?php echo $user_id; ?>;
    var item_id = 0;
    var itemarrays = '';</script>
<script src="<?php echo base_url(); ?>assets/angular/userController.js"></script>

<?php
$this->load->view('layout/footer');
?> 
<script>
    $(function () {


    $('#orderslisttable').DataTable({
    language: {
    "search": "Apply filter _INPUT_ to table"
    }
    });
    $('#tableDataOrder').DataTable({
    language: {
    "search": "Apply filter _INPUT_ to table"
    }
    })
    })
</script>
