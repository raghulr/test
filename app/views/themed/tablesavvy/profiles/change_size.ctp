<?php if(!empty($change_reservation_time)) {?>
<?php 
	$originl_time = array();
	foreach($change_reservation_time as $time){                        
		$select_time = strtotime($time['Offer']['offerTime']);
		$originl_time[$select_time] = date('h:i a',$select_time);
	}
					
?>
 <?php echo $form->input('time',array('label'=>false,'id'=>'HomeChangeTime','class'=>'select_box','type'=>'select','options'=>array($originl_time),'selected'=>'select')); 
 ?>
 <?php } else { echo "<p>No times available</p>"; } ?>
 

