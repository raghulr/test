
<?php  
if(!empty( $this->data['User']['hideval']) && $this->data['User']['hideval']=='admin'){ 
?>
<div class="users form js-responses" id="js-responses">
    <div class="login_back">
        <?php
        $formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-form' : 'js-ajax-form';
        echo $form->create('User', array('action' => 'login', 'class' => 'normal '.$formClass)); 
        echo $form->input('is_requested', array('type' => 'hidden'));
		echo $form->input('hideval', array('type' => 'hidden','value'=>'admin'));
		//if(isset($chicagomag)){
			
		//}
        ?>
        <div class="login_top">
        	<ul class="login_list">
            	<li><a href="#">LOGIN</a></li>
            </ul>
        </div>
        <div class="login_content">
        	<div class="email_content">
            	<div class="email"><h2>Email address:</h2></div>
                <div class="email_text"><?php echo $form->input('email',array('label'=>false,'class'=>'text')); ?></div>
            </div>
           
            <div class="pwd_content">
            	<div class="pwd"><h2>Password: </h2></div>
                	<div class="p_text"><?php echo $form->input('password',array('label'=>false,'class'=>'text1','size'=>'10')); ?></div>    
            </div>
            <div class="login_button">
            	<div class="lbutton"><?php echo $form->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'js-responses','class'=>'but'));?> </div>
                
            </div>
        </div>
        <div class="login_bottom">
        	<?php echo $html->link('Forgot Your Password?',array('controller'=>'users','action'=>'forget_password')); ?>
        </div>
        <?php echo $form->end(); ?>
    </div>
</div>
<?php } elseif(!empty( $this->data['User']['hideval']) && $this->data['User']['hideval']=='reserv'){?>
                	<?php 
                        echo $form->create('User', array('action' => 'login', 'class' => 'normal'));
                        if(!empty($rest_id_res)): 
                            echo $form->input('hideval', array('type' => 'hidden','value'=>'reserv'));
                            echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res));
                            echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res));
                            echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res));
                            echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res));
                        endif;
                        ?>
                    <div class="register_top">
                    	<?php echo $html->link($html->image('/images/bttn-facebook.gif', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','width'=>225,'height'=>39,'border'=>0)), $fb_login_url, array('escape' => false,'onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
                        <div class="spacer">&nbsp;</div>
                        <h4>Or Login an account below</h4>
                    </div>
                    <table  width="400"  border="0" cellspacing="0" cellpadding="0" class="table-register">
                        <tr>
                             <td class="label01">Email</td>
                            <td align="left"><?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>  </td>
                        </tr>
                        <tr>
                             <td class="label01">Password</td>
                             <td align="left"><?php echo $form->input('password',array('label'=>false,'div'=>false,'size'=>30));?>    </td>
                        </tr>
                    </table>
                    <div class="btn-group-register">
                    <div class="forget_pass float">
                        <a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a>
                    </div>     
                    <?php echo $ajax->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login_update', 'label'=>false,'class'=>'btn btn-success')); ?>
                    </div>
                     <?php echo $form->end();?>  
               <?php } else{ 
?>
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
			<div class="btn-group-center  full-width margin-bottom">                               
             <?php echo $form->submit('Login to TableSavvy', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false,'class'=>'btn btn-large btn-success'));?>
			<div id="restNav" style="width:380px;float:none;margin:20px auto 0 auto;">
				<ul>
					<li><a href="<?php echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>">Not a member? Sign up</a></li>
					<li><a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a></li>
				</ul>
			</div>
                        </div>
            <?php echo $form->end();?>
			<div class="conjunction clearfix margin-bottom"><div>or</div></div>
			<div class="btn-group-center  full-width margin-bottom">
            	<?php echo $html->link('Connect using Facebook', $fb_login_url, array('class'=>'btn btn-inverse','target'=>'_parent')); ?>
			</div>
			

		</div><!-- /.modal-inner -->
</div>
    </div>
<?php } ?>
