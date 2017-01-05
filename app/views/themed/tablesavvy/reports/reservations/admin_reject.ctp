<div class="tabl_cont" id="post">   
    <div class="fist_row my_time">
     <?php foreach($data as $user){ 
            $email = $user['User']['firstName'];
            $approve = $user['Reservation']['approved'];
			$resid = $user['Reservation']['id'];
			$userid = $user['User']['id'];
			$no_show='';
			$no_show = $user['Reservation']['no_show'];
     ?>
        <div class="time"><span id="time_no"><?php echo $user['Offer']['offerTime']; ?></span></div>
        <div class="time"><span id="pa_no"><?php 
			if($user['Offer']['seating_custom']!=0)
				echo $user['Offer']['seating_custom'];
			elseif($user['Reservation']['cancel_custom']!=0)
				echo $user['Reservation']['cancel_custom'];
			else
				echo $user['Offer']['seating'];
		?></span></div>
        <div class="name"><span id="f_name_text"><?php echo $user['User']['firstName']; ?></span></div>
        <div class="l_name"><span id="f_name_text"><?php echo $user['User']['lastName']; ?></span></div>
        <div class="phone"><span id="party_no"><?php echo $user['User']['phone']; ?></span></div>
        <div class="email"><span id="party_no"><a href="mailto:<?php echo $user['User']['email']; ?>"><?php $mail = substr($user['User']['email'],0,15)."..."; echo $mail; ?></a></span></div>
        <?php if($approve==0){?>
        <div class="seat"></div>
        <div class="cancel lastc"><?php echo $html->image('/images/ad_cancel.png',array('class'=>'reject'));?></div>
      <?php } else { ?>   
        <div class="seat"> 
            <?php /*?><a href="javascript:void(0)" onclick="return approved('<?php echo $user['Reservation']['id'] ?>','<?php echo $user['User']['id'] ?>','<?php echo $html->url(array('controller'=>'reservations', 'action'=>'approved'),true);?>')"><?php echo $html->image('/images/ad_select.png',array('class'=>'approve')); ?></a><?php */?>
             <?php echo $ajax->link($html->image("/images/ad_select.png"),array('controller'=>'reservations','action'=> 'approved',$resid,$userid),array('update'=>'post','escape'=>false,'complete'=>'funcall()','confirm'=>'Are you sure to cancel this reservation?')); ?>
        </div>
        <div class="cancel lastc">
        </div>
    <?php } ?>
    	<div class="cancel">
            	 <?php  $url=$html->url(array('controller'=>'reservations','action'=>'admin_supportmail','admin'=>true),true);?>
                <?php echo $form->checkbox('Reservation.no_show',array('label'=>false,'div'=>false,'onclick'=>'no_show_click("'.$resid.'","'.$url.'")','checked'=>$no_show)); ?>
             </div>
	<?php } ?>       
    </div>
</div>