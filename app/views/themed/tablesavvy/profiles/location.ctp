<ul class="change-reservation-tab">
				<li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>"><span>My Reservation</span></a></li>
				<li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>"><span>Alerts</span></a></li>
				<li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>"><span>History</span></a></li>
				<li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>" class="active-reservation-tab-all"><span>Profile</span></a></li>
</ul>
<div class="contact-wrapper add-space">
<div class="heading-txt">Add Location</div>
<div class="gap03">&nbsp;</div>
<div class="contact-form">
<?php echo  $form->create('User', array('action' => 'location', 'class' => 'normal'));   ?>
    <label class="label-contact">Location Type</label>
     <?php 
				$location_url = $html->url(array('controller'=>'profile','action'=>'location'));
			if(empty($location_type)):
				echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('1'=>'Home','2'=>'Work'),'div'=>false,'class'=>'select-contact'));
			elseif($location_type==1):
				echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('2'=>'Work'),'div'=>false,'class'=>'select-contact'));
			elseif($location_type==2):
				echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('1'=>'Home'),'div'=>false,'class'=>'select-contact'));
			endif;
			?>
    <div class="gap03">&nbsp;</div>
    <label class="label-contact">Address</label>
     <?php echo $form->input('address',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
    <div class="gap03">&nbsp;</div>
    <label class="label-contact">City</label>
    <?php echo $form->input('city',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
    <div class="gap03">&nbsp;</div>
    <label class="label-contact">State</label>
    <?php echo $form->input('state',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
    <div class="gap03">&nbsp;</div>
    <label class="label-contact">Zipcode</label>
     <?php echo $form->input('zipcode',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
    <div class="gap02">&nbsp;</div>
      <?php echo $html->link('Back','/profiles/profile',array('class'=>'button-contact button-hover')); ?>
     <?php echo $form->submit('Add',array('label'=>false,'div'=>false,'class'=>'button-contact'));?>
     <?php echo $form->end(); ?>
<div class="spacer"></div>
</div>
<div class="spacer"></div>
</div>