<div class="ui body container">

	<?php if(isset($update)){?>
		<div id="successMessage" class="message">Please add your first and last name so our restaurants recognize you when you dine with them.</div>
	<?php } ?>

	<div class="ui grid stackable">

	  <div class="four wide column">
			<?php echo $this->element('profile_sidebar', array('active' => 'profile')); ?>
		</div>

		<div class="twelve wide column">
			<a href="/profiles/profile"><i class="angle double left icon"></i> Back</a>
			<h2>Add Location</h2>
			<?php echo  $form->create('User', array('action' => 'location', 'class' => 'ui form'));   ?>
			<div class="field">
				<label>Location Type</label>
		    <?php
					$location_url = $html->url(array('controller'=>'profile','action'=>'location'));
					if(empty($location_type)):
						echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('1'=>'Home','2'=>'Work'),'div'=>false,'class'=>'ui dropdown'));
					elseif($location_type==1):
						echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('2'=>'Work'),'div'=>false,'class'=>'ui dropdown'));
					elseif($location_type==2):
						echo $form->input('location_type',array('type'=>'select','label'=>false,'options' => array('1'=>'Home'),'div'=>false,'class'=>'ui dropdown'));
					endif;
				?>
			</div>
			<div class="field">
	    	<label>Address</label>
	     	<?php echo $form->input('address',array('type'=>'text','label'=>false,'div'=>false));?>
			</div>
			<div class="field">
	    	<label>City</label>
	    	<?php echo $form->input('city',array('type'=>'text','label'=>false,'div'=>false));?>
			</div>
			<div class="field">
	    	<label>State</label>
	    	<?php echo $form->input('state',array('type'=>'text','label'=>false,'div'=>false));?>
			</div>
			<div class="field">
	    	<label>Zipcode</label>
	     	<?php echo $form->input('zipcode',array('type'=>'text','label'=>false,'div'=>false));?>
			</div>
			<div class="field">
	    	<?php echo $form->submit('Add',array('label'=>false,'div'=>false,'class'=>'ui button primary'));?>
			</div>
			<?php echo $form->end(); ?>
		</div>
	</div>
</div>
