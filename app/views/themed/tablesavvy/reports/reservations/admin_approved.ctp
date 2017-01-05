<?php if(isset($paginate)){ ?>
	<div class="cont_navi">
    <ul class="navigation">
        <li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
         <li class="active_link"><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
        <li><?php echo $html->link('History',array('controller'=>'history','action'=>'index')); ?></li>
        <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
    </ul>
</div>
<div class="navi_content">
	<div class="drop_down">
		<?php echo $form->create(); 
			  $changeurl = $html->url(array('controller'=>'reservations', 'action'=>'select'),true);
			  echo $form->input('Show Active Reservations',array('label'=>false, 'class'=>'select_box','type'=>'select','options'=>array('1'=>'Show All Reservations','2'=>'Approved reservations','3'=>'Canceled reservations'),'selected'=>'Show Active Reservations','onchange' =>'changereserve(this.value,"'.$changeurl.'");')); ?>
	</div>
    <div class="res_tabl">
    	<div class="tabl_head">
        	<div class="time_reserve"><span id="time">TIME</span></div>
            <div class="time_reserve"><span id="party">PARTY</span></div>
            <div class="name"><span id="f_name">FIRST NAME</span></div>
            <div class="l_name"><span id="f_name">LAST NAME</span></div>
            <div class="phone"><span id="party">PHONE</span></div>
            <div class="email" id="email_right"><span id="party">EMAIL</span></div>
            <div class="seat"><span id="party">SEATED</span></div>
            <div class="cancel lastc"><span id="cancel">CANCELED</span></div>
            <div class="cancel"><span id="cancel">No Show</span></div>
        </div>
<?php } ?>
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
        <div class="time_reserve"><span id="time_no"><?php echo $user['Offer']['offerTime']; ?></span></div>
        <div class="time_reserve"><span id="pa_no">
        <?php if($user['Offer']['seating_custom']!=0)
			echo $user['Offer']['seating_custom'];
		elseif($user['Reservation']['cancel_custom']!=0)
			echo $user['Reservation']['cancel_custom'];
		else
			echo $user['Offer']['seating'];
		?>
        </span></div>
        <div class="name"><span id="f_name_text"><?php echo $user['User']['firstName']; ?></span></div>
        <div class="l_name"><span id="f_name_text"><?php echo $user['User']['lastName']; ?></span></div>
        <div class="phone"><span id="party_no"><?php echo $user['User']['phone']; ?></span></div>
        <div class="email"><span id="party_no"><a href="mailto:<?php echo $user['User']['email']; ?>"><?php $mail = substr($user['User']['email'],0,15)."..."; echo $mail; ?></a></span></div>
        <?php if($approve==0){?>
        <div class="seat"></div>
        <div class="cancel lastc"><?php echo $html->image('/images/ad_cancel.png',array('class'=>'reject'));?></div>
      <?php } else { ?>   
        <div class="seat"> 
          <div id="approve">
           <?php echo $ajax->link($html->image("/images/ad_select.png"),array('controller'=>'reservations','action'=> 'approved',$resid,$userid),array('update'=>'post','escape'=>false,'class'=>'approve','complete'=>'funcall()','confirm'=>'Are you sure to cancel this reservation?')); ?>
           </div>
        </div>
        <div class="cancel lastc">
        </div>
    <?php }?>
    	<div class="cancel">
            	 <?php  $url=$html->url(array('controller'=>'reservations','action'=>'admin_supportmail','admin'=>true),true);?>
                <?php echo $form->checkbox('Reservation.no_show',array('label'=>false,'div'=>false,'onclick'=>'no_show_click("'.$resid.'","'.$url.'")','checked'=>$no_show)); ?>
             </div>
	<?php } ?>
    <?php if(empty($data)){ ?>
    <div id="no_records">
    <?php echo "No reservation found"; ?>
    </div>
    <?php } ?>
    <div class="paginate">
		<?php if($paginator->numbers()){?>
        <?php echo $paginator->prev('Prev',null,null,array('class'=>'disabled'));?>&nbsp;&nbsp;
        <?php echo $paginator->numbers(); ?>&nbsp;&nbsp;
        <?php echo $paginator->next('Next',null,null,array('class'=>'disabled')); ?>&nbsp;&nbsp;
        <?php } ?>  
    </div>     
    </div> 
    </div>
</div>
<?php if(isset($paginate)){?>
	</div>
    </div>
</div>
<div class="navi_botom"></div>
<?php } ?>