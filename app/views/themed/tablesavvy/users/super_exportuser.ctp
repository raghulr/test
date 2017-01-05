<STYLE type="text/css">
    .tableTd {
        border-width: 0.5pt; 
        border: solid; 
    }
    .tableTdContent{
        border-width: 0.5pt; 
        border: solid;
    }
    #titles{
        font-weight: bolder;
        font-size:17px;
    }
    .header{
        font-size:30px;
        text-align:center;
        text-decoration: underline;
    }

</STYLE>
<table>
    <tr>    
        <td></td><td></td>
        <td colspan="6" class="header"><b>USER DETAILS REPORT<b></td>
    </tr>
    <tr>
        <td><b>Date:</b>&nbsp;&nbsp;<?php echo date("F j, Y,"); ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Number of Approved Users:</b>&nbsp;&nbsp;<span style='color:green;'><?php echo $approved;?></span></td>
         <td colspan="2"><b>Number of Restaurant Admins:</b>&nbsp;&nbsp;<span style='color:red;'><?php echo $res_admin;?></span></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr id="titles">
        <td class="tableTd">FirstName</td>
        <td class="tableTd">LastName</td>
        <td class="tableTd">Email</td>
        <td class="tableTd">No of Reservations</td>
        <td class="tableTd">Phone</td>
        <td class="tableTd">Alt Phone</td>
        <td class="tableTd">Password</td>
        <td class="tableTd">Card Type</td>
        <td class="tableTd">Created</td>
        <td class="tableTd">Modified</td>
        <td class="tableTd">Reset Password</td>
        <td class="tableTd">Approved</td>
        <td class="tableTd">User Amount</td>
        <td class="tableTd">Last Reservation</td>
        <td class="tableTd">Email Code</td>
        <td class="tableTd">From</td>
        <td class="tableTd">facebook signup</td>
    </tr>		
    <?php
    $j=0;
    foreach ($users as $row) {
        echo '<tr>';        
        echo '<td class="tableTdContent">' . $row['User']['firstName'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['lastName'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['email'] . '</td>';
        echo '<td class="tableTdContent">' . $row['0']['reservation_counts'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['phone'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['altphone'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['password'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['card_type'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['created'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['modified'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['pw_reset_string'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['approved'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['user_amount'] . '</td>';
        echo '<td class="tableTdContent">' . $row['0']['last_reservation'] . '</td>';
if($row['0']['reservation_counts'] == 0){ $email_code = 0; }else{ $email_code = ($row['0']['reservation_counts']-1)%3 + 1; }
        echo '<td class="tableTdContent">' . $email_code . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['from'] . '</td>';
        if($row['User']['fb_signup'] == 1){
            $signup='fb signup';
        }elseif($row['User']['fb_signup'] == 2){
            $signup='signup';
        }else{
            $signup=$row['User']['fb_signup'];
        }
        echo '<td class="tableTdContent">' . $signup . '</td>';
        echo '</tr>';          
    $j++;
    }
    ?>
</table>

