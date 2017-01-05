<?php if(isset($paginate)) { ?>
<div class="cont_navi">
    <ul class="navigation">
        <li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
        <li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
        <li class="active_link"><?php echo $html->link('History',array('controller'=>'history','action'=>'index')); ?></li>
        <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
    </ul>
</div>
<div class="navi_content">
	<div id="changedate">
	<?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
        <div class="ddd">
        	<div class="date_set">
       			 <div class="dis_date">Reservation history for <input id="rdate" class="dp-applied" value="<?php echo $currentdate; ?>" name="date1" disabled="disabled"></div>
       			 <div class="bgg"> 
            		<input id="date1" class="date-pick dp-applied" name="date1" onchange="return get_date_display('<?php echo $html->url(array('controller'=>'history','action'=>'date_display'))?>')" value="<?php echo $currentdate; ?>">
        		 </div>
       		</div>
        </div>
    </div>
    <div class="res_tabl">
    	<div class="tabl_head">
        	<div class="time_reserve"><span id="time">TIME</span></div>
            <div class="time_reserve"><span id="party">PARTY</span></div>
            <div class="name"><span id="f_name">FIRST NAME</span></div>
            <div class="l_name"><span id="f_name">LAST NAME</span></div>
            <div class="phone"><span id="party">PHONE</span></div>
            <div class="email" id="email_right"><span id="party">EMAIL</span></div>
           
        </div>
<?php } ?>
<div class="tabl_cont">
    <div class="fist_row">
     <?php foreach($data as $user){ ?>
        <div class="time_reserve"><span id="time_no"><?php $off_time=strtotime($user['Offer']['offerTime']); echo date('h:i a',$off_time); ?></span></div>
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
        <?php 
               $approval = $user['Reservation']['approved'];
                if($approval == 1){
        ?>
        <div class="seat"><?php echo $html->image('/images/ad_select.png',array('class'=>'approve'));?></div>
        <div class="cancel"></div>
        <?php } else { ?>
        <div class="seat"></div>
        <div class="cancel"><?php echo $html->image('/images/ad_cancel.png',array('class'=>'reject'));?></div>
    <?php } ?><?php } ?>   
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
<?php if(isset($paginate)) { ?>
	</div>
</div>
<div class="navi_botom"></div>
<?php } ?>