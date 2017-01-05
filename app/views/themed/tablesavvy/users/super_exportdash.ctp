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
        <td colspan="6" class="header"><b>SUPERADMIN DASHBOARD REPORT<b></td>
    </tr>
    <tr>
        <td><b>Date:</b>&nbsp;&nbsp;<?php echo date("F j, Y,"); ?></td>
    </tr>
    <tr>
        <td><b>Number of Reservations:&nbsp;&nbsp;</b><?php echo count($page); ?></td>
        <td colspan="2"><b>Number of Approved reservation:</b>&nbsp;&nbsp;<span style='color:green;'><?php echo $approved;?></span></td>
         <td colspan="2"><b>Number of Canceled reservation:</b>&nbsp;&nbsp;<span style='color:red;'><?php echo count($page)-$approved;?></span></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr id="titles">
        <td class="tableTd">Transaction Date/Time</td>
        <td class="tableTd">User FirstName</td>
        <td class="tableTd">User LastName</td>
        <td class="tableTd">User Email</td>
        <td class="tableTd">Restaurant Name</td>
        <td class="tableTd">Reservation Time</td>
        <td class="tableTd">Party Size</td>
        <td class="tableTd">Active /Canceled</td>
        <td class="tableTd">Credit Used or CC</td>
        <td class="tableTd">No Show</td>
        <td class="tableTd">By using</td>
        <td class="tableTd">Rest Confirmation</td>
        <td class="tableTd">Customer Sign up date</td>
    </tr>		
    <?php
    //pr($neighbor);exit;
    $j=0;
    foreach ($page as $row) {
        $partysize = '';
        $approve = '';
        $payment = '';
        $noshow = '';
        $receipt = '';
        $seating_cus = $row['Offer']['seating_custom'];
        $seating = $row['Offer']['seating'];
        if (!empty($seating)) {
            if ($seating_cus != 0)
                $partysize = $seating_cus;
            elseif ($row['Reservation']['cancel_custom'] != 0)
                $partysize = $row['Reservation']['cancel_custom'];
            else
                $partysize = $seating;
        }
        if ($row['Reservation']['approved'] != 0){
            $approve = 'Active';
        }
        else{
            $approve = 'Canceled';
        }       
        if(isset($row['Reservation']['transactionId'])&&!empty($row['Reservation']['transactionId']))
                $payment =  'Credit Card'; 
        else
                $payment =  'TS Credit';
        if ($row['Reservation']['no_show'] == 0)
            $noshow = '-';
        else
            $noshow = 'No Show';
        if ($row['Reservation']['receipt'] == 1)
            $receipt = 'Yes';
        else
            $receipt = 'No';
        echo '<tr>';
        echo '<td class="tableTdContent">' . $row['Reservation']['trasaction_time'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['firstName'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['lastName'] . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['email'] . '</td>';
        echo '<td class="tableTdContent">' . $resname[$j] . '</td>';
        echo '<td class="tableTdContent">' . date('g:i A', strtotime($row['Offer']['offerTime'])) . '</td>';
        echo '<td class="tableTdContent">' . $partysize . '</td>';
        echo '<td class="tableTdContent">' . $approve . '</td>';
        echo '<td class="tableTdContent">' . $payment . '</td>';
        echo '<td class="tableTdContent">' . $noshow . '</td>';
        echo '<td class="tableTdContent">' . $row['Reservation']['from'] . '</td>';
        echo '<td class="tableTdContent">' . $receipt . '</td>';
        echo '<td class="tableTdContent">' . $row['User']['created'] . '</td>';
        echo '</tr>';        
    $j++;
    }
    ?>
</table>