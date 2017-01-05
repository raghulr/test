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
	}
        .header{
            text-align:center;
            font-size:20px;
            text-decoration: underline;
        }
        .subheader{
            font-size:15px;
            text-decoration: underline;
        }
   
</STYLE>
<table>
	<tr>
		<td colspan="2" class="header"><b>STATISTICS REPORT<b></td>
	</tr>
        <tr></tr>
	<tr>
		<td><b>Date:</b></td>
		<td><?php echo date("F j, Y,"); ?></td>
	</tr>
         <tr>
        <td><b>Number Of Posted Today : </b></td>
        <td style="text-align:left"><?php echo $total_tables."&nbsp;&nbsp;Tables"; ?></td>
	</tr>
	<tr>
		<td><b>Number of Users:</b></td>
		<td style="text-align:left"><?php echo $result;?></td>
	</tr>
        <tr></tr>
        <tr>
                <td colspan="2" class='subheader'><b>Restaurants Details:</b></td>
        </tr>
        <tr>
                <td><b>Total Number of Restaurants:</b></td>
		<td style="text-align:left"><?php echo $tot_rest."&nbsp;&nbsp;Restaurants";?></td>
	</tr>
        <tr>
                <td><b>Number of Approved Restaurants:</b></td>
		<td style="text-align:left"><?php echo $tot_approved_rest."&nbsp;&nbsp;Approved"; ?></td>
	</tr>
        <tr>
                <td><b>Number of Unapproved Restaurants:</b></td>
		<td style="text-align:left"><?php echo $tot_unapproved_rest."&nbsp;&nbsp;Unapproved"; ?></td>
	</tr>  
        <tr></tr>
        <tr>
                <td colspan="2" class='subheader'><b>Reservation Details:</b></td>
        </tr>
        <tr>
        <td><b>Reservations On Today: </b></td>
        <td style="text-align:left"><?php echo $count."&nbsp;&nbsp;Reservations"; ?></td> 
	</tr>
        <tr>
        <td><b>Reservations On <?php echo date("F"); ?>: </b></td>
        <td style="text-align:left"><?php echo $month_count."&nbsp;&nbsp;Reservations"; ?></td> 
	</tr>
        <tr>
        <td><b>Reservations On <?php echo date("Y"); ?>: </b></td>
        <td style="text-align:left"><?php echo $year_count."&nbsp;&nbsp;Reservations"; ?></td> 
	</tr>
        <tr>
        <td><b>Total Approved Reservations : </b></td>
        <td style="text-align:left"><?php echo $total_count."&nbsp;&nbsp;Reservations"; ?></td>
	</tr>
		
</table>

