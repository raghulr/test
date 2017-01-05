<style type="text/css">
.margin-style{
margin-left:60px!important;
}
.margin-style label{
width:120px!important;
}
.margin-style input{
width:250px!important;
}
.margin-style .error-message{
margin-left:143px!important;
}
</style>
<div class="rec_table_back">
<div class="upload_top" style="width:498px;">
	<div style=" float:right; top:0; width:19px;">
		<a href="javascript:void(0)" onclick="parent.$.colorbox.close(); return true;" style="float:right;"><?php echo $html->image('/images/close.png',array("width"=>20,"height"=>20)); ?></a>
	</div>
	<div class="upload_text">
    	<h2>CHANGE PASSWORD</h2>
    </div>  
 <div class="up_middle"></div>
</div>
     <div class="recurringdata_new">
<?php echo $form->create('User', array('action' => 'change_password')); ?>
</div>
<?php //echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
	<?php
		echo $form->input('id');
	?>
	<div class="loginname margin-style">
   		 <label>New Password</label>
		 <?php echo $form->input('password', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password')); ?>
	</div>
    <div class="loginname margin-style">
     	<label>Confirm Password</label>
        <?php echo $form->input('confirm_password', array('type' => 'password', 'label'=>false,'div'=>false));?>
    </div>
    <div class="butn" style="margin-top:35px; margin-left:204px; border:none;">
		<?php 
		   echo $form->Submit('/images/conform.png'); echo $form->end(); ?>
    </div>
	</div>
    
