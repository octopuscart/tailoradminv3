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
    ">Design Profile ID: <?php echo $desingdata["name"]; ?></th>
    </tr>
    <?php
    foreach ($desingdata["style"] as $key => $value) {
        ?>
        <tr >
            <th style="text-align: right;border: 1px solid #e0e0e0;padding:10px;width: 50%"><?php echo $key;?></th>
            <td style="border: 1px solid #e0e0e0;padding:10px;width: 50%;"><?php echo $value;?></td>
        </tr>
        <?php
    }
    ?>




</table>

