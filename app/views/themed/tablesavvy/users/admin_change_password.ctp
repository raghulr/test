<style>
.error-message{
	text-indent:0px !important;
}
</style>
<div class="popup_min rec_table_back">
    <div id="login-update">
    	<div style="width:498px;" class="upload_top">
         <a style="float:right; margin: 7px 4px 0 0;" onclick="parent.$.colorbox.close(); return true;" href="#"><img width="33" height="34" border="0" alt="" src="/theme/tablesavvy/images/close.png"></a>
        <div class="upload_text"><h2>Change password</h2></div>    
        <div class="up_middle"></div>
    </div>
        <!--/.modal-header-->
        <?php 
        echo $form->create('User', array('action' => 'change_password'));
        echo $form->input('id');
        ?>
        <div id="modal-login" class="modal-inner modal-inner-with-header clearfix" style="width:70%;margin:5%; float:left;">
            <div class="half">
                <div class="label">New Password</div>
                <div class="input  margin-bottom"> 
                <?php echo $form->input('password', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password')); ?>
                </div>
            </div>
            <div class="half">
                <div class="label">Confirm Password</div>
                <div class="input  margin-bottom"> 
                <?php echo $form->input('confirm_password', array('type' => 'password', 'label'=>false,'div'=>false));?>
                </div>
            </div>

            <div class="btn-group-center  full-width margin-bottom">
                <div class="submit">
                <?php echo $form->submit('Change Password',array('label'=>false,'class'=>'btn btn-large btn-success'));?>
                </div>
            </div>
            <?php echo $form->end(); ?>
			
        </div>
    </div>
</div>    
<style>
    .input input{
        width: 100%;
    }
</style>
    
