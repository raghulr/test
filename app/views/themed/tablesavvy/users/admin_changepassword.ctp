<style type="text/css">
.login_top{
color: #ffffff;
    font-family: Arial;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    text-shadow: 2px 2px 0 #000000;
	padding:10px 0 0 10px;
	width:510px;
	line-height:30px;
}	
.login_content{
height:203px!important;
}
.tim_div{
	display:none;
}
.log_out{
	display:none;
}
</style>

<div class="login-wrapper">
	<?php
		$formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
		echo $form->create('User', array('action' => 'changepassword', 'class' => 'normal '.$formClass));
		echo $form->input('id', array('value'=>$string));
	?>  
    <div class="top-login">Change Password</div>
    <div class="login-form change_pass">			
    	<label class="label-admin01">Email address</label>
        <?php echo $form->input('email', array('type' => 'text','label'=>false,'div'=>false,'class'=>'textbox-admin01')); ?>
        <div class="spacer">&nbsp;</div>
        <label class="label-admin01">New password</label>
       <?php echo $form->input('passwd', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password','class'=>'textbox-admin01')); ?>
        <div class="spacer">&nbsp;</div>
        <label class="label-admin01">Confirm password</label>
        <?php echo $form->input('confirm_password', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password','class'=>'textbox-admin01')); ?>
        <div class="spacer">&nbsp;</div>
        <?php echo $form->submit('Confirm', array('url'=> array('controller'=>'users', 'action'=>'changepassword','admin'=>true), 'update' => 'login-update','label'=>false,'class'=>'button-confirm floatR'));?>
    <div class="spacer"></div>
    </div>
    <div class="bottom-login align-center">
   		<?php echo $html->link('Back to Login','/admin'); ?>
    </div>
    <div class="spacer"></div>
    <?php echo $form->end(); ?>
</div>