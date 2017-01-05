<ul id="navlist">
	<li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
   	<li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
    <li><a href="javascript:;">History</a></li>
    <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
</ul>
<?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
<label style="width:135px;float:left; margin-left:5px;">Schedule Future Date:</label><input id="date1" class="date-pick dp-applied" name="date1" onChange="changedate(this.value,'<?php echo $changedateurl; ?>')">
<div class="table_container">
	<div class="drop-down">
        <div class="table-date">
        <p>Table Avaliablity for <?php echo $date2; ?></p>
        </div>
  		<div class="drop-box">
    	     <a href="<?php echo $html->url(array('controller'=>'table','action'=>'recurringtable'),true); ?>" class="colorbox-min">Add Recurring table</a>
    	</div>
    </div>
    <div class="inner_table">
        <div class="total_seat">
        Total
        </div>
    	<?php  $url=$html->url(array('controller'=>'table','action'=>'addtable'),true); $url1=$html->url(array('controller'=>'table','action'=>'deletetable'),true);?>
       <div style="display:none"> <?php
		echo $form->create('');
		echo $form->input('Offer.offerTime',array('type'=>'text','value'=>'','class'=>'offerTime')); 
		echo $form->input('Offer.restaurantId',array('type'=>'hidden','value'=>$res_id));
		echo $form->input('Offer.seating',array('type'=>'text','value'=>'','class'=>'seating'));
		echo $form->input('Offer.offerDate',array('type'=>'text','value'=>'','class'=>'offerDate'));
		echo $form->input('Offer.recurring',array('type'=>'text','value'=>0));
		echo $form->end();
		?></div><?php
		if($interval!=0){
			for($i=0;$i<=$interval;$i++){ 
				$timearray=array(0=>2,1=>4,2=>6,3=>8);
			   
				$sum=0;
				?>
                 <fieldset class="field" id="<?php echo 'int_'.$i;?>">
                    <legend><?php echo date('h:i A',$starttime); ?></legend>
                    <ul id="table_list">
                    <?php for($k=0;$k<4;$k++){  $offer=$tables->getTables(date('H:i:s',$starttime),$date2,$timearray[$k]);?>
                        <li>
                            <a href="javascript:;" onMouseOver="show('<?php echo date('H:i:s',$starttime); ?>','<?php echo $timearray[$k]; ?>','<?php echo $i;?>','<?php echo $date2; ?>')" onMouseOut="hide('<?php echo $timearray[$k]; ?>','<?php echo $i;?>')">
                                <span class="set_back"><div class="text" id="<?php echo 'int_'.$i.'_'.$timearray[$k];?>"><?php if(!empty($offer[0]['total'])){ $sum+=$offer[0]['total']; echo $offer[0]['total'];}?></div></span>
                                <span class="seat_name"><?php echo $timearray[$k]; ?></span>
                            </a>
                            <div class="apply tooltip" id="<?php echo 'show_hide_'.$i.'_'.$timearray[$k];?>" style="display:none;" onMouseOver="showtip('<?php echo 'show_hide_'.$i.'_'.$timearray[$k];?>')"  onMouseOut="hidetip('<?php echo 'show_hide_'.$i.'_'.$timearray[$k];?>')">
                            <a href="javascript:;" style="color:#fff;" onclick="return add('<?php echo $html->url(array('controller'=>'table','action'=>'addtable'),true);?>','<?php echo $timearray[$k]; ?>','<?php echo $i;?>')">Add</a>
                            <a href="javascript:;" style="color:#fff;" onclick="return delete1('<?php echo $html->url(array('controller'=>'table','action'=>'deletetable'),true);?>','<?php echo $timearray[$k]; ?>','<?php echo $i;?>')">Delete</a>
                            </div>
                        </li> 
                        <?php } ?>
                    </ul>
                    <div id="<?php echo 'total_'.$i; ?>" style="float:left;margin-top:20px;margin-left:10px;">
                    <?php echo $sum; ?>
                    </div>
                </fieldset>
        <?php $starttime=$starttime+1800; 
			} 
		}?>     
    </div>
</div>