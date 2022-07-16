<?php
$this->load->view('layout/header');
$this->load->view('layout/topmenu');
?>
<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?php echo base_url(); ?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->
<style>
    .product_text {
        float: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width:100px
    }
    .product_title {
        font-weight: 700;
    }
    .price_tag{
        float: left;
        width: 100%;
        border: 1px solid #222d3233;
        margin: 2px;
        padding: 0px 2px;
    }
    .price_tag_final{
        width: 100%;
    }
    .sub_item_table tr{
        border-bottom: 1px solid #dbd3d3;
    }
    span.colorbox {
        float: left;
        width: 100%;
        padding: 5px;
        text-align: center;
        color: white;
        text-shadow: 0px 2px 4px #fff;
    }

</style>
<!-- Main content -->
<section class="content">
    <div class="">

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Product Reports</h3>
            </div>
            <div class="panel-body">
                <table id="tableData" class="table table-bordered ">
                    <thead>
                        <tr>
                            <th style="width: 20px;">S.N.</th>
                            <th style="width:50px;">Image</th>
                            <th style="width:150px;">Category</th>
                            <th style="width:50px;">SKU</th>
                            <th style="width:100px;">Title</th>
                            <th style="width:100px;">Color</th>
                            <th style="width:200px;">Short Description</th>
                            <th >Items Prices</th>
                            <th style="width: 75px;">Edit</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>


    </div>
</section>
<!-- end col-6 -->
</div>

<div class="modal fade" id="imageZoomModel" tabindex="-1" role="dialog" aria-labelledby="attributeModel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body" id="showimageproduct">
                <img src="" id="showimageproduct_src" width="100%"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attributeModel" tabindex="-1" role="dialog" aria-labelledby="attributeModel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="#" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add/Change Color</h4>
                </div>
                <div class="modal-body">
                    <li class='list-group-item'>
                        <?php // echo $attr; ?> 

                        <select  name='attr_value' id="attr_value" class='form-control' style="margin-top: 10px;">
                            <option value="" selected="">Select Color</option>
                            <?php
                            foreach ($attribuites as $key => $value) {
                                $atv = $value['attribute_value'];
                                $atid = $value['attribute_id'];
                                $attav = $value['additional_value'];
                                $atvid = $value['id'];
                                echo "<option value='$atvid'  style='background:$attav'>$atv</option>";
                            }
                            ?>
                        </select>
                    </li>
                </div>
                <div class="modal-footer">
                    <button type="button" name="save_attr" id="save_attr_product_list" onclick="selectcolor()" class="btn btn-primary" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/table-manage-default.demo.min.js"></script>
<?php
$this->load->view('layout/footer');
?> 
<script>
                        var selectedcolor;
                        var iscolorselect = false;
                        var selectedcolorid;

                        function selecteddiv(selectedid) {
                            selectedcolorid = (selectedid);
                        }
                        function zoomImage(imgid) {
                            console.log($("#" + imgid).html())
                            $("#showimageproduct_src").attr("src", $("#" + imgid).attr("src"));
                        }
                        function selectcolor() {
                            if (iscolorselect) {
                                console.log(selectedcolor);
                                selectedcolor["product_id"] = selectedcolorid;
                                var innterhtml = '<span class="colorbox" title="Dark Blue" style="background:' + selectedcolor.color_code + '">' + selectedcolor.color_name + '</span>';
                                var buttonhtml = "<button class= 'btn btn-default btn-xs btn-block' data-toggle='modal' data-target='#attributeModel' onclick=selecteddiv('" + selectedcolorid + "')>Add/Change</button>";
                                $.get("<?php echo $set_color_api; ?>", selectedcolor, function (r, v) {
                                    console.log("color inserted");
                                });
                                $("#" + selectedcolorid).html(innterhtml + buttonhtml);
                            } else {
                                console.log("selected none");
                            }
                        }

                        $(function () {
                            var colorlist = [];
<?php
$colorlistarray = array();
foreach ($attribuites as $key => $value) {
    $atv = $value['attribute_value'];
    $atid = $value['attribute_id'];
    $attav = $value['additional_value'];
    $color_id = $value["id"];
    $colorele = array("color_code" => $attav, "color_name" => $atv, "id" => $color_id, "attr_id" => $atid);
    $colorlistarray[$color_id] = $colorele;
}
echo "var colorlist=" . json_encode($colorlistarray);
?>

                            $("#attr_value").on("change", function () {
                                if (this.value) {
                                    iscolorselect = true;
                                    selectedcolor = colorlist[this.value];
                                } else {
                                    iscolorselect = false;
                                }

                            });



                            $('#tableData').DataTable({
                                "processing": true,
                                "serverSide": true,
                                "ajax": {
                                    url: "<?php echo site_url("ProductManager/productReportApi/" . $condition) ?>",
                                    type: 'GET'
                                },
                                dom: 'Blfrtip',
                                buttons: [
                                    'excel', 'pdf', 'csv', 'print'
                                ],
                                "columns": [
                                    {"data": "s_n"},
                                    {"data": "image"},
                                    {"data": "category"},
                                    {"data": "sku"},
                                    {"data": "title"},
                                    {"data": "color"},
                                    {"data": 'short_description'},
                                    {"data": "items_prices"},
                                    {"data": "edit"}]
                            })
                        })

</script>