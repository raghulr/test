<div class="popup_min">
    <div  id="login-update">
        <div class="modal-header">
            <h2>Change Password</h2>
        </div><!--/.modal-header-->
    <div class="modal-inner modal-inner-with-header clearfix" id="modal-login">
        <?php
        echo $form->create('User', array('action' => 'profile_change_password',$this->params['pass'])); 
        echo $form->input('id', array('value'=>$string));
        ?>
        <div class="clearfix">
            <div class="">
                <div class="label">E-mail</div>
                <div class="input  margin-bottom"> 
                <?php echo $form->input('email', array('type' => 'text','label'=>false,'div'=>false)); ?>
                </div>
            </div>
            <div class="no-right-margin">
                <div class="label">New Password</div>
                <div class="input margin-bottom">
                <?php echo $form->input('passwd', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password')); ?>
                </div>
            </div>
            <div class="no-right-margin">
                <div class="label">Confirm Password</div>
                <div class="input margin-bottom">
                <?php echo $form->input('confirm_password', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password')); ?>
                </div>
            </div>
        </div>
        <div class="btn-group-center  full-width margin-bottom">
        <?php echo $form->submit('Confirm', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false,'class'=>'btn btn-large btn-success'));?>
        </div>
        <?php echo $form->end();?>
        </div><!-- /.modal-inner -->
    </div>
</div>