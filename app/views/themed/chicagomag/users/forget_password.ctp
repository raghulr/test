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
</style>
<div class="users form js-responses">
    <div class="login_back login">
   <?php
	$formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
	echo $form->create('User', array('action' => 'forget_password', 'class' => 'normal '.$formClass));
	?>    
        <div class="login_top">
            	Forgot your password?
        </div>
        <div class="login_content">
        	<div class="email_content">
            	<div class="email"><h2>Email address:</h2></div>
                <div class="email_text"><?php echo $form->input('email',array('label'=>false,'class'=>'text')); ?></div>
            </div>
            <div class="login_button">
            	<div class="lbutton"><?php echo $form->submit('Submit',array('url'=> array('controller'=>'users', 'action'=>'forget_password'),'class'=>'but')); ?> </div>
            </div>
        </div>
        <div class="login_bottom">
        	<?php echo $html->link('Back to Login','/admin'); ?>
        </div>
        <?php /*?><div class="email"><?php echo $form->input('email',array('label'=>'Email address : ')); ?></div>
        <div class="email"><?php  echo $form->input('password', array('label' => 'Password : ')); ?></div>
        <div class="log_button"><?php echo $form->submit('Login'); ?></div>		
        <?php echo $html->link('Forget your password?',array('controller'=>'users','action'=>'forget_password')); ?><?php */?>
        <?php echo $form->end(); ?>
    </div>
</div>