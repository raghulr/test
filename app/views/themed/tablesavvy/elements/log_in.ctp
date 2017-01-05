<div class="signup-login">
	<?php
		echo $form->create('User', array('action' => 'login', 'class' => 'ui form'));
		echo $form->input('test_login', array('type' => 'hidden','value'=>'test_log'));
		// If reservation is being made with this sign up
		if ($reservation == TRUE) {
			echo $form->input('hideval', array('type' => 'hidden','value'=>'reserv'));
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
	<div class="field">
		<a href="<?php echo $fb_login_url ?>" class="ui facebook fluid button">
			<i class="facebook icon"></i><strong>Log In</strong> with <strong>Facebook</strong>
		</a>
	</div>
	<div class="ui horizontal divider">
	 Or
	</div>
	<div class="field">
		<?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false, 'placeholder' => 'Email')); ?>
	</div>
	<div class="field">
		<?php echo $form->input('password',array('type'=>'password','label'=>false,'div'=>false, 'placeholder' => 'Password')); ?>
	</div>
	<div class="field">
	  <?php 
	    if (isset($submit_ajax) && $submit_ajax == TRUE) {
		    echo $ajax->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login_update', 'label'=>false,'class'=>'ui button primary fluid')); 
      } else {
        echo $form->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login_update', 'label'=>false,'class'=>'ui button primary fluid')); 
      }
		?>
	</div>

	<a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a>
	<?php echo $form->end();?>
</div>
