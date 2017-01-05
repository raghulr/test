<div class="ui body container">
<div class="page ui segment">
<div class="ui form contained">

<?php

	if(!empty( $this->data['User']['hideval']) && $this->data['User']['hideval']=='admin'){

		if ($session->check('Message.error')):
		echo $session->flash('error');
		endif;

		if ($session->check('Message.success')):
		echo $session->flash('success');
		endif;

		if ($session->check('Message.error1')):
		echo $session->flash('error1');
		endif;

		if ($session->check('Message.flash')):
		echo $session->flash();
		endif;
		?>

	<div class="users form js-responses" id="js-responses">
    <?php
			$formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-form' :
			'js-ajax-form';
			echo $form->create('User', array('action' => 'login', 'class' => 'normal '.$formClass));
			echo $form->input('is_requested', array('type' => 'hidden'));
			echo $form->input('hideval', array('type' => 'hidden','value'=>'admin'));
			//if(isset($chicagomag)){
			//}
		?>

    <h2>Log In</h2>
		<p>New to TableSavvy? <a href="/register">Sign Up</a></p>
    <div class="field">
      <label>Email address:</label>
      <div class="email_text"><?php echo $form->input('email',array('label'=>false,'class'=>'text')); ?></div>
    </div>
    <div class="field">
      <label>Password:</label>
      <div class="p_text"><?php  echo $form->input('password',array('label'=>false,'class'=>'text1','size'=>'10')); ?></div>
    </div>
    <div class="field">
			<?php  echo $ajax->submit('LOGIN', array('class' => 'ui button', 'url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'js-responses','class'=>'but')); ?>
    </div>
    <div class="field">
      <?php echo $html->link('Forgot your password?',array('controller'=>'users','action'=>'forget_password')); ?>
    </div>
    <?php echo $form->end(); ?>
	</div>
<?php
	}

	elseif(!empty( $this->data['User']['hideval']) && $this->data['User']['hideval']=='reserv') {
?>
<?php
		echo $form->create('User', array('action' => 'login', 'class' => 'normal'));
		echo $form->input('hideval', array('type' => 'hidden','value'=>'reserv'));
		if(!empty($rest_id_res)) echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res)); else echo $form->input('rest_id_res', array('type' => 'hidden','value'=>''));
		if(!empty($time_res)) echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res)); else echo $form->input('time_res', array('type' => 'hidden','value'=>''));
		if(!empty($party_res)) echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res)); else echo $form->input('party_res', array('type' => 'hidden','value'=>''));
		if(!empty($ampm_res)) echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res)); else echo $form->input('ampm_res', array('type' => 'hidden','value'=>''));
		echo $form->input('test_login', array('type' => 'hidden','value'=>'test_log'));
?>
 		<h2>Log In</h2>
		<p>New to TableSavvy? <a href="/register">Sign Up</a></p>
    <label class="label-signup-login">Email</label>
    <?php  echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-signup')); ?>
    <div class="gap03">&nbsp;</div>
    <label class="label-signup-login">Password</label>
      <?php  echo $form->input('password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'textbox-signup')); ?>
    <div class="gap03">&nbsp;</div>
    <?php  if(!isset($this->data['User']['test_login'])) { ?>
    <script type="text/javascript">
     $(document).ready(function(){
       $('.signup-login .error-message').remove();
     });
    </script>
		<?php  } ?>
      <ul class="login-links-list">
          <li> <?php  echo $ajax->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login_update', 'label'=>false,'class'=>'button-contact')); ?></li>
          <li><a href="<?php  echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a></li>
           <?php  echo $form->end(); ?>
      </ul>
      <div class="gap03">&nbsp;</div>
      <div class="or-login"><p>OR</p></div>
      <div class="gap03">&nbsp;</div>
      <div class="center-width button-login-fb_login">
       <?php echo $html->link($html->image('/images/facebook-login02.png', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','class'=>'img_header button-image')), $fb_login_url, array('escape' => false,'onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
       <div class="spacer"></div>
      </div>
  		<div class="spacer"></div>
		<?php  } else { ?>
		<div class="contact-wrapper login-required">
        <h2>Log In</h2>
				<p>New to TableSavvy? <a href="/register">Sign Up</a></p>
        <?php echo $form->create('User', array('action' => 'login', 'class' => 'normal')); ?>
        <div class="ui form">
					<div class="field">
            <label>Email</label>
            <?php  echo $form->input('email',array('type'=>'text','label'=>false,'class'=>'textbox-contact','size'=>30,'div'=>false)); ?>
          </div>
					<div class="field">
					  <label class="label-login">Password </label>
            <?php  echo $form->input('password',array('class'=>'textbox-contact','label'=>false,'size'=>30,'div'=>false)); ?>
					</div>
					<div class="field">
           <?php
						if(!empty($_GET['f']))        $f = $_GET['f'];
						elseif(!empty($this->data['User']['f']))        $f = $this->data['User']['f']; else        $f='';

						if (!empty($f)):
						echo $form->input('f', array('type' => 'hidden', 'value' => $f));
						endif;
						?>
					</div>
					<?php  echo $form->end(); ?>
					<?php  echo $form->submit('Login', array('class' => 'ui button fluid primary', 'url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false)); ?>
          <div class="or-login"><p>OR</p></div>
          <div class="center button-login-fb_login">
          	<a href="<?php echo $fb_login_url ?>" class="ui facebook button">
							<i class="facebook icon"></i><strong>Log In</strong> with <strong>Facebook</strong>
						</a>
          </div>
					<a href="<?php  echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a>
					<span>|</span>
					<a href="<?php  echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>">Not a member? Sign up</a>
	     </div>
</div>
<?php  } ?>
</div>
</div>
</div>
