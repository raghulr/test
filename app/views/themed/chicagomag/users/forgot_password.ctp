<div class="popup_min">
    <div id="login-update">
        <div class="modal-header">
            <h2>Forgot your password</h2>
        </div><!--/.modal-header-->
        <?php
        $formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
        echo $form->create('User', array('action' => 'forgot_password', 'class' => 'normal '.$formClass));
        ?> 
        <div id="modal-login" class="modal-inner modal-inner-with-header clearfix">
            <div class="half">
                <div class="label">E-mail</div>
                <div class="input  margin-bottom"> 
                <?php echo $form->input('email',array('label'=>false,'class'=>'text')); ?>
                </div>
            </div>

            <div class="btn-group-center  full-width margin-bottom">
                <div class="submit">
                <?php echo $form->submit('Forgot Password', array('url'=> array('controller'=>'users', 'action'=>'forgot_password'),'label'=>false,'class'=>'btn btn-large btn-success'));?>
                </div>
            </div>      
        <?php echo $form->end();?>
        </div><!-- /.modal-inner -->
    </div>
</div>