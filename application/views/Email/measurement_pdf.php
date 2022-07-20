<?php
echo PDF_HEADER;
?>

<table class="detailstable" align="center" border="0" cellpadding="0" cellspacing="0" width="400" style="background: #fff;margin-top:20px;">
    <tr>
        <td colspan="2">Name : <?php echo $desingdata["user_data"]["first_name"] . " " . $desingdata["user_data"]["last_name"]; ?></td>
    </tr>
    <tr>
        <td  colspan="2">Email: <?php echo $desingdata["user_data"]["email"]; ?></td>
    </tr>
    <tr>
        <td colspan="2" style="height: 10px;"></td>
    </tr>
    <tr>
        <th colspan="2" style="border: 1px solid #e0e0e0;padding:10px;background: #e0e0e0;
            ">Measurement Profile ID: <?php echo $desingdata["name"]; ?></th>
    </tr>
    <?php
    foreach ($desingdata["measurements"] as $key => $value) {
        ?>
        <tr >
            <th style="text-align: right;border: 1px solid #e0e0e0;padding:10px;width: 50%"><?php echo $value["measurement_key"]; ?></th>
            <td style="border: 1px solid #e0e0e0;padding:10px;width: 50%;">
                <?php
                $mvalues = explode(" ", $value['measurement_value']);
                echo $mvalues[0];
                echo " <span style='margin-left: 1px;
    padding: 0;
    font-size: 10px;

    position: absolute;
    margin-top: -5px;
    width: 20px;'>" . $mvalues[1] . '</span>';
                ?> 
            </td>
        </tr>
        <?php
    }
    ?>




</table>

