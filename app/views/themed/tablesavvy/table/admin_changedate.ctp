
<?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
<div class="date_set"><span></span><input id="date1" class="date-pick dp-applied" name="date1" onChange="changedate(this.value,'<?php echo $changedateurl; ?>')" value="<?php echo $date1; ?>"></div>
<div class="cont_navi">
        <ul class="navigation">
           <li class="active_link"><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
           <li><?php echo $html->link('Table Dashboard',array('controller'=>'table','action'=>'admin_clear_group')); ?></li>
   			<li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
    		<li><a href="javascript:;">History</a></li>
   			 <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
        </ul>
</div>
<?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
 <div class="navi_content">
 	<div id="gif" style="display:none;">
	 <?php echo $html->image('/images/wait.gif', array('alt'=>'wait','border'=>0));?>
	</div>
    	<div class="table_content">
            <div class="drop-box">
            <div class="tableres"> 
                <div class="table_available">Table Availabilty for</div>
                <input id="rdate" value="<?php if($today==$date2): echo "today"; else: echo date('m-d-Y', strtotime($date2)); endif; ?>" name="date1" disabled="disabled">
            <?php if($today!=$date2):?><a href="<?php echo $html->url(array('controller'=>'table','action'=>'index'),true)?>"><?php echo $html->image('/images/button_today.png',array('border'=>0,'width'=>115,'height'=>30)); ?></a> <?php endif;?>
            </div>
            <a href="<?php echo $html->url(array('controller'=>'table','action'=>'recurringtable'),true).'?date='.$date2; ?>" class="colorbox-min"><?php echo $html->image('/images/addrecurr.png',array('border'=>0,'width'=>174,'height'=>30)); ?></a>
            <?php $time_url = $html->url(array('controller'=>'table','action'=>'cleartable',$date2),true); ?>
            <a href="javascript:;" onclick="return sample('<?php echo $time_url; ?>');">
				<?php echo $html->image('/images/clear_all_new.png',array('border'=>0,'width'=>90,'height'=>30)); ?>            </a>
    	    </div>
            <div class="inner_table">
			<?php  $url=$html->url(array('controller'=>'table','action'=>'addtable'),true); $url1=$html->url(array('controller'=>'table','action'=>'deletetable'),true);?>
                <div style="display:none">
                <?php echo $form->create('');
                echo $form->input('Offer.offerTime',array('type'=>'text','value'=>'','class'=>'offerTime')); 
                echo $form->input('Offer.restaurantId',array('type'=>'hidden','value'=>$res_id));
                echo $form->input('Offer.seating',array('type'=>'text','value'=>'','class'=>'seating'));
                echo $form->input('Offer.offerDate',array('type'=>'text','value'=>'','class'=>'offerDate'));
                echo $form->input('Offer.recurring',array('type'=>'text','value'=>0));
                echo $form->end();
                ?>
                </div>
                <?php 
		if($interval!=0){
			$grandSum =0;
                         $newoffer = '';
                    $newpurchased='';
                    $reservation = $tables->getRestaurantReservation($date2);
                    $offer = $tables->getAvilableTables($res_id, $reservation, $date2); //pr($offer);
                    $purchased = $tables->getPurchased($res_id, $reservation, $date2); //pr($purchased);
                    for ($r = 0; $r < count($offer); $r++) {
                        $time = $offer[$r]['Offer']['offerTime'];
                        $seat = $offer[$r]['Offer']['seating'];
                        $newoffer[$time][$seat] = $offer[$r][0]['total'];
                    }
                    for ($r = 0; $r < count($purchased); $r++) {
                        $time = $purchased[$r]['Offer']['offerTime'];
                        $seat = $purchased[$r]['Offer']['seating'];
                        $newpurchased[$time][$seat] = $purchased[$r][0]['total'];
                    }
			 for ($i = 0; $i <= $interval; $i++) {
                        $timearray = array(0 => 2, 1 => 4, 2 => 6, 3 => 8);

                        $sum = 0;
                        ?>
                        <fieldset id="update_clear" class="field" id="<?php echo 'int_' . $i; ?>">
                            <legend><?php echo date('h:i A', $starttime); ?></legend>
                            <ul id="table_list">                    
                                <?php for ($k = 0; $k < 4; $k++) { ?>
                                    <li onMouseOver="show('<?php echo date('H:i:s', $starttime); ?>','<?php echo $timearray[$k]; ?>','<?php echo $i; ?>','<?php echo $date2;?>')" onMouseOut="hide('<?php echo $timearray[$k]; ?>','<?php echo $i; ?>')">
                                        <?php //$offer=$tables->getAvilableTables($res_id,$reservation,date('H:i:s',$starttime),date('Y-m-d'),$timearray[$k]);?>
                                        <?php   //$offer_pur = $tables->getPurchased($res_id, $reservation, date('H:i:s', $starttime), date('Y-m-d'), $timearray[$k]);?>
                                        <a href="javascript:;" >
                                            <span class="set_back">
                                                <div  class="text" id="<?php echo 'int_' . $i . '_' . $timearray[$k]; ?>">
                                                    <?php if (!empty($newoffer[date('H:i:s', $starttime)][$timearray[$k]])) {
                                                                $sum+=$newoffer[date('H:i:s', $starttime)][$timearray[$k]];
                                                                echo $newoffer[date('H:i:s', $starttime)][$timearray[$k]];
                                                                $grandSum = $grandSum + $newoffer[date('H:i:s', $starttime)][$timearray[$k]];
                                                        }
                                                    ?>
                                                </div>
                                            </span>
                                            <span class="set_back1"><div  class="text" id="<?php echo 'int_' . $i . '_' . $timearray[$k]; ?>"><?php if (!empty($newpurchased[date('H:i:s', $starttime)][$timearray[$k]])) {
                echo $newpurchased[date('H:i:s', $starttime)][$timearray[$k]];
            } ?></div></span>
                                            <span class="seat_name vtip" title="Table size" ><?php echo $timearray[$k]; ?></span>
                                        </a>
                                        <div class="apply tooltip" id="<?php echo 'show_hide_' . $i . '_' . $timearray[$k]; ?>" style="display:none;" onMouseOver="showtip('<?php echo 'show_hide_' . $i . '_' . $timearray[$k]; ?>')"  onMouseOut="hidetip('<?php echo 'show_hide_' . $i . '_' . $timearray[$k]; ?>')">
                                            <div id="avail">Available tables for <?php echo $timearray[$k]; ?></div>
                                            <a href="javascript:;" style="color:#fff;" onClick="return add('<?php echo $html->url(array('controller' => 'table', 'action' => 'addtable'), true); ?>','<?php echo $timearray[$k]; ?>','<?php echo $i; ?>')"><?php echo $html->image('/images/addseat.png', array('border' => 0, 'width' => 103)); ?></a>
                                            <a href="javascript:;" style="color:#fff;" onClick="return delete1('<?php echo $html->url(array('controller' => 'table', 'action' => 'deletetable'), true); ?>','<?php echo $timearray[$k]; ?>','<?php echo $i; ?>')"><?php echo $html->image('/images/delseat.png', array('border' => 0, 'width' => 103)); ?></a>
                                        </div>
                                    </li> 
                        <?php } ?>
                            </ul>
                            <div style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#595959; margin-top:24px;">Total</div><div id="<?php echo 'total_' . $i; ?>" style="float:left;margin-top:5px;margin-left:7px; font-family:Arial; font-size:24px; color:#595959;">
        <?php echo $sum; ?>
                            </div>
                        </fieldset>
        <?php
        $starttime = $starttime + 1800; 
			} 
		}?>     
        <?php if(isset($grandSum)){ ?>
		   <div style="width:175px; height:30px; float:right; font-family:Arial, Helvetica, sans-serif; font-weight:bold;  color:#595959;">Grand Total : <span style="color: #595959; font-family: Arial,Helvetica,sans-serif; font-size: 20px;" id="grandtotal"><?php echo $grandSum;?></span></div> 
       	<?php } ?>
            </div>
        </div>
    </div>
    <div class="navi_botom"></div>	