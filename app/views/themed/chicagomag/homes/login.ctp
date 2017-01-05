<div class="popup_min">
<div  id="login-update">
		<div class="modal-header">
			<h2>Login</h2>
		</div><!--/.modal-header-->
		<div class="modal-inner modal-inner-with-header clearfix" id="modal-login">
		<?php
			echo $form->create('User', array('action' => 'login', 'class' => 'normal'));
        ?>
			<div class="clearfix">
					<div class="half">
						<div class="label">E-mail</div>
						<div class="input  margin-bottom"> 
							<?php echo $form->input('email',array('type'=>'text','label'=>false,'size'=>30,'div'=>false));?>
                        </div>
					</div>
					<div class="half no-right-margin">
						<div class="label">Password</div>
						<div class="input margin-bottom">
                        	<?php echo $form->input('password',array('label'=>false,'size'=>30,'div'=>false));?>
                        </div>
					</div>
			</div>
			<div class="btn-group-center  full-width margin-bottom">
             <?php echo $form->submit('Login to tableSavvy', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false,'class'=>'btn btn-large btn-success'));?>
			</div>
            <?php echo $form->end();?>
			<div class="conjunction clearfix margin-bottom"><div>or</div></div>
			<div class="btn-group-center  full-width margin-bottom">
            	<?php echo $html->link('Connect using Facebook', $fb_login_url, array('class'=>'btn btn-inverse','target'=>'_parent')); ?>
			</div>
			<div id="restNav">
				<ul>
					<li><a href="<?php echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>">Not a member? Sign up</a></li>
					<li><a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a></li>
				</ul>
			</div>

		</div><!-- /.modal-inner -->
</div>
    </div>