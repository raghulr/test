<ul id="navlist">
	<li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
   	<li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
    <li><a href="javascript:;">History</a></li>
    <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
</ul>
<label style="width:135px;float:left; margin-left:5px;">Schedule Future Date:</label><input id="date1" class="date-pick dp-applied" name="date1">
<div class="table_container">
	<div class="drop-down">
        <div class="table-date">
        <p>Table Avaliablity for <?php echo date('Y-m-d'); ?></p>
        </div>
  		<div class="drop-box">
    	    <?php echo $this->Form->button('Add Recurring table',array('label'=>false,'value'=>'Add Recurring table')); ?>
    	</div>
    </div>
    <div class="inner_table">
        <div class="total_seat">
        Total
        </div>
    	<?php  $url=$html->url(array('controller'=>'table','action'=>'addtable'),true); $url1=$html->url(array('controller'=>'table','action'=>'deletetable'),true);
		
		if($interval!=0){for($i=0;$i<=$interval;$i++){ $k1=$k2=$k3=$k4=0;?>
         <fieldset class="field" id="<?php echo 'int_'.$i;?>">
            <legend><?php echo date('h:i A',$starttime); ?></legend>
            <ul id="table_list">
                <li id="<?php echo 'int_'.$i.'_2';?>">
                
                    <a href="javascript:;"  onMouseOver="show('<?php echo date('h:i A',$starttime); ?>',2,'<?php echo $i;?>','<?php echo $res_id;?>')" onMouseOut="hide(2,'<?php echo $i;?>')" >
                     <span class="set_back"><div class="text"><?php if(!empty($getdata)):foreach($getdata as $dat): if($dat['Offer']['offerTime']==date('H:i:s',$starttime) && $dat['Offer']['offerDate']==date('Y-m-d') && $dat['Offer']['seating']==2): $k1=$dat[0]['total']; echo $dat[0]['total'];  endif; endforeach; endif;?></div></span>&nbsp;<span class="seat_name">2</span></a>
                    <div id="<?php echo 'show_hide_'.$i.'_2';?>" style="display:none;" onMouseOver="showtip('<?php echo 'show_hide_'.$i.'_2';?>')"  onMouseOut="hidetip('<?php echo 'show_hide_'.$i.'_2';?>')" class="apply">
                    <?php echo $form->create('Table',array('action'=>$url));  echo $form->input('time',array('type'=>'hidden','id'=>'assign_current_2_'.$i));  echo $form->button('Add',array('type'=>'button','onclick'=>'return add('."'".$url."'".',2,'.$i.')','value'=>'Add')); echo $form->button('Delete',array('type'=>'button','onclick'=>'return delete1('."'".$url1."'".',2,'.$i.')','value'=>'Delete')); echo $form->end();?>
                    </div>
                </li> 
                <li id="<?php echo 'int_'.$i.'_4';?>">
                    <a href="javascript:;" onMouseOver="show('<?php echo date('h:i A',$starttime); ?>',4,'<?php echo $i;?>','<?php echo $res_id;?>')" onMouseOut="hide(4,'<?php echo $i;?>')" ><span class="set_back"><div class="text"><?php if(!empty($getdata)):foreach($getdata as $dat): if($dat['Offer']['offerTime']==date('H:i:s',$starttime) && $dat['Offer']['offerDate']==date('Y-m-d') && $dat['Offer']['seating']==4): $k2=$dat[0]['total'];echo $dat[0]['total']; break; endif; endforeach; endif;?></div></span>&nbsp;<span class="seat_name">4</span></a>
                    <div id="<?php echo 'show_hide_'.$i.'_4';?>" style="display:none;" onMouseOver="showtip('<?php echo 'show_hide_'.$i.'_4';?>')" onMouseOut="hidetip('<?php echo 'show_hide_'.$i.'_4';?>')" class="apply">
                    <?php  echo $form->create('Table',array('action'=>$url));  echo $form->input('time',array('type'=>'hidden','id'=>'assign_current_4_'.$i));  echo $form->button('Add',array('type'=>'button','onclick'=>'return add('."'".$url."'".',4,'.$i.')','value'=>'Add')); echo $form->button('Delete',array('type'=>'button','onclick'=>'return delete1('."'".$url1."'".',4,'.$i.')','value'=>'Delete')); echo $form->end();?>
                    </div>
                </li>
                <li id="<?php echo 'int_'.$i.'_6';?>">
                    <a href="javascript:;" onMouseOver="show('<?php echo date('h:i A',$starttime); ?>',6,'<?php echo $i;?>','<?php echo $res_id;?>')" onMouseOut="hide(6,'<?php echo $i;?>')" ><span class="set_back"><div class="text"><?php if(!empty($getdata)):foreach($getdata as $dat): if($dat['Offer']['offerTime']==date('H:i:s',$starttime) && $dat['Offer']['offerDate']==date('Y-m-d') && $dat['Offer']['seating']==6): $k3=$dat[0]['total']; echo $dat[0]['total']; break; endif; endforeach; endif;?></div></span>&nbsp;<span class="seat_name">6</span></a>
                    <div id="<?php echo 'show_hide_'.$i.'_6';?>" style="display:none;"  onMouseOver="showtip('<?php echo 'show_hide_'.$i.'_6';?>')" onMouseOut="hidetip('<?php echo 'show_hide_'.$i.'_6';?>')"  class="apply">
                    <?php echo $form->create('Table',array('action'=>$url));  echo $form->input('time',array('type'=>'hidden','id'=>'assign_current_6_'.$i));  echo $form->button('Add',array('type'=>'button','onclick'=>'return add('."'".$url."'".',6,'.$i.')','value'=>'Add')); echo $form->button('Delete',array('type'=>'button','onclick'=>'return delete1('."'".$url1."'".',6,'.$i.')','value'=>'Delete')); echo $form->end();?>
                    </div>
                </li>
                <li id="<?php echo 'int_'.$i.'_8';?>">
                    <a href="javascript:;"  onMouseOver="show('<?php echo date('h:i A',$starttime); ?>',8,'<?php echo $i;?>','<?php echo $res_id;?>')"  onMouseOut="hide(8,'<?php echo $i;?>')" ><span class="set_back"><div class="text"><?php if(!empty($getdata)):foreach($getdata as $dat): if($dat['Offer']['offerTime']==date('H:i:s',$starttime) && $dat['Offer']['offerDate']==date('Y-m-d')  && $dat['Offer']['seating']==8): $k4=$dat[0]['total']; echo $dat[0]['total']; break; endif; endforeach; endif;?></div></span>&nbsp;<span class="seat_name">8</span></a>
                    <div id="<?php echo 'show_hide_'.$i.'_8';?>" style="display:none;" onMouseOver="showtip('<?php echo 'show_hide_'.$i.'_8';?>')" onMouseOut="hidetip('<?php echo 'show_hide_'.$i.'_8';?>')" class="apply">
                    <?php echo $form->create('Table',array('action'=>$url));  echo $form->input('time',array('type'=>'hidden','id'=>'assign_current_8_'.$i));  echo $form->button('Add',array('type'=>'button','onclick'=>'return add('."'".$url."'".',8,'.$i.')','value'=>'Add')); echo $form->button('Delete',array('type'=>'button','onclick'=>'return delete1('."'".$url1."'".',8,'.$i.')','value'=>'Delete')); echo $form->end();?>
                    </div>
                </li>
            </ul>
            <div id="<?php echo 'total_'.$i; ?>" style="float:left;margin-top:20px;margin-left:10px;">
            <?php echo $k1+$k2+$k3+$k4; ?>
            </div>
  		</fieldset>
        <?php $starttime=$starttime+1800; } }?>
        
      
    </div>
</div>
<div class="dis">

</div>
