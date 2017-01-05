<style>
.tim_div{
	display:none;
}
.log_out{
	display:none;
}
</style>
<div class="users form js-responses" id="js-responses">
    <div class="login_back">
        <?php
        $formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-form' : 'js-ajax-form';
        echo $form->create('User', array('action' => 'login', 'class' => 'normal '.$formClass)); 
        echo $form->input('is_requested', array('type' => 'hidden'));
		echo $form->input('hideval', array('type' => 'hidden','value'=>'admin'));
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
            	<div class="lbutton"><?php echo $ajax->submit('LOGIN', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'js-responses','class'=>'but'));?> </div>
                
            </div>
        </div>
        <div class="login_bottom">
        	<?php echo $html->link('Forgot your password?',array('controller'=>'users','action'=>'forget_password')); ?>
        </div>
        <?php echo $form->end(); ?>
    </div>
</div>