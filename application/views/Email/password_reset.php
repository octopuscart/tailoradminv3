<?php
echo PDF_HEADER;
?>

<table class="detailstable" align="center" border="0" cellpadding="0" cellspacing="0"  style="background: #fff;margin-top:20px;">

    <tr>
        <td  colspan="2" style="text-align: center;">


            <h2> Reset your password </h2>

        </td>
    </tr>
    <tr>
        <td  colspan="2" style="text-align: left;">



            <p> Hi <?php echo $user_data["first_name"] . " " . $user_data["last_name"]; ?>,</p>

            <p>
                We have received a request to recover your <?php echo SITE_NAME; ?> password. 
                To set a new password, simply click below.
            </p>
        </td>
    </tr>

    <tr>
        <th colspan="2" >
            <br/>
            <a href="<?php echo SITE_URL ."Account/resetPassword/". $user_data["password"]."AAA". $user_data["id"]; ?>".>RESET PASSWORD</a>

        </th>
    </tr>
    <tr>
        <td colspan="2" >
            <br/>
            <p style="font-size: 12px;">
                If you didn’t ask to recover your password, please ignore this email.

            </p>

        </td>
    </tr>




</table>

