
<div class="popup_min">
    <div id="login-update">
        <div class="modal-header">
            <h2>Change password</h2>
        </div><!--/.modal-header-->
        <?php 
        echo $form->create('User', array('action' => 'change_password'));
        echo $form->input('id');
        ?>
        <div id="modal-login" class="modal-inner modal-inner-with-header clearfix">
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
        </div>
    </div>
</div>    
<style>
    .input input{
        width: 100%;
    }
</style>
    
