<div class="more-spacer">&nbsp;</div>
<div id="content">
<div class="popup_min-new">
<div  id="login-update">
		<div class="register_top">
                    	<h2>Login</h2>
                        <div class="line1"></div>
                        <div class="spacer">&nbsp;</div>
         </div><!--/.modal-header-->
		<div class="modal-login" id="modal-login">
		<?php
			echo $form->create('User', array('action' => 'login', 'class' => 'normal'));
        ?>
			<div class="modal-new">
                            <div class="half-new">
                                    <div class="label">E-mail</div>
                                    <div class="input-new-field"> 
                                            <?php echo $form->input('email',array('type'=>'text','label'=>false,'size'=>30,'div'=>false));?>
                                    </div>
                            </div>
                            <div class="half-new">
                                    <div class="label">Password</div>
                                    <div class="input-new-field">
                                            <?php echo $form->input('password',array('label'=>false,'size'=>30,'div'=>false));?>
                                    </div>
                            </div>
			</div>
                        <?php
                        if(!empty($_GET['f']))
                            $f = $_GET['f'];
                        elseif(!empty($this->data['User']['f']))
                            $f = $this->data['User']['f'];
                        else
                            $f='';                            
                        
                        if (!empty($f)):
                                echo $form->input('f', array('type' => 'hidden', 'value' => $f));
                        endif;
                        ?>
			<div class="btn-group-center full-width set-right">                               
            
			<div id="restNav-new">
				<ul>
					<li class="sign"><a href="<?php echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>">Not a member? Sign up</a></li>
                    <li class="pipe-li">|</li>
					<li class="forgot"><a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a></li>
				</ul>
			</div>
            <?php echo $form->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false,'class'=>'btn1 btn-large btn-success1 btn-large-for'));?>
                        </div>
            <?php echo $form->end();?>
			 <div class="orclass-login mar-h">
                <div class="linedotted-login">&nbsp;</div>
                <h2>OR</h2>
                <div class="linedotted-login-right">&nbsp;</div>
             </div>
              <div class="orclass-login">
                    <?php echo $html->link($html->image('/images/logfb.png', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','border'=>0)), $fb_login_url, array('escape'=>false,'class'=>'','target'=>'_parent')); ?>
             </div>
			

		</div><!-- /.modal-inner -->
</div>
    </div>
    </div>