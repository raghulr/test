<div class="ui body container">

<div class="ui grid stackable">
  <div class="four wide column">
		<?php echo $this->element('profile_sidebar', array('active' => 'index')); ?>
	</div>
	<div class="twelve wide column">
		<div class="ui middle aligned stackable container">
			<?php
				echo $html->link(
					'<i class="icon angle double left"></i> Back','/profiles/profile',
					array('class'=>'button-contact button-hover','escape' => FALSE)
				);
			?>
			<h2>Edit Location</h2>
			<div class="ui form">
    	<?php echo $form->create('User', array('action' => 'edit_location'));  ?>
	    <?php echo $form->input('id');?>
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
      	<?php echo $form->submit('Update',array('label'=>false,'div'=>false,'class'=>'ui primary button'));?>
			</div>
			<?php echo $form->end(); ?>
		</div>
	</div>
</div>
