<div class="signup-register">
	<?php
		echo $form->create('User', array('action' => 'register', 'class' => 'ui form','onsubmit'=>'return checkAll()'));
		// If reservation is being made with this sign up
		if ($reservation == TRUE) {
			// Create form
			// Hidden Fields
			echo $form->input('hidvalue',array('type'=>'hidden','value'=>'regis_res'));
			echo $form->input('reservehidvalue',array('type'=>'hidden','value'=>'reservation'));

			if(!empty($rest_id_res))
				echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res));
			else
	      echo $form->input('rest_id_res', array('type' => 'hidden','value'=>''));
	    if(!empty($time_res))
				echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res));
			else
	      echo $form->input('time_res', array('type' => 'hidden','value'=>''));
	    if(!empty($party_res))
				echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res));
			else
				echo $form->input('party_res', array('type' => 'hidden','value'=>''));
	    if(!empty($ampm_res))
				echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res));
			else
	    	echo $form->input('ampm_res', array('type' => 'hidden','value'=>''));
		}
	?>
	<div class="ui middle aligned stackable grid">
	  <div class="nine wide column">
			<div class="field">
				<div class="two fields">
					<div class="field">
						<?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false, 'placeholder'=>'First Name'));?>
					</div>
					<div class="field">
						<?php echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false, 'placeholder'=>'Last Name'));?>
					</div>
				</div>
			</div>
			<div class="two fields">
				<div class="field">
					<?php if(($reservation == TRUE) && isset($email)){ ?>
					    <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'value'=>$email));?>
					<?php }else{ ?>
					    <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false, 'placeholder'=>'Email'));?>
					<?php }?>
				</div>
				<div class="field">
					<?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false, 'placeholder'=>'Phone'));?>
				</div>
			</div>
			<div class="field">
		  	<div class="two fields">
		  		<div class="field">
		  			<?php echo $form->input('passwd',array('type'=>'password','label'=>false,'div'=>false, 'placeholder'=>'Password'));?>
		  		</div>
		  		<div class="field">
		  			<?php echo $form->input('confirm_password',array('type'=>'password','label'=>false,'div'=>false, 'placeholder'=>'Password Confirmation'));?>
		  		</div>
		  	</div>
		  </div>
			<div class="field">
				<div class="inline fields">
					<div class="field">
						<?php echo $form->submit('Sign Up',array('class'=>'ui button primary')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="center aligned one wide column"></div>
		<div class="ui vertical divider">
	    Or
	  </div>
		<div class="center aligned one wide column"></div>
		<div class="center aligned five wide column">
			<a href="<?php echo $fb_login_url ?>" class="ui facebook fluid button">
				<i class="facebook icon"></i><strong>Sign Up</strong> with <strong>Facebook</strong>
			</a>
	  </div>
	</div>
	<?php echo $form->end();?>
</div>
