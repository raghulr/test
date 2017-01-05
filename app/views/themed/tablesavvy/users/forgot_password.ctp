<div class="ui body container">
  <div class="ui segment">
   <?php
     $formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
     echo $form->create('User', array('action' => 'forgot_password', 'class' => 'ui form contained forgot_password'.$formClass));
    ?>    
    <h2>Forgot your password?</h2>
    <div class="field">
      <?php echo $form->input('email',array('label'=>false,'class'=>'ui fluid', 'placeholder'=>'Email')); ?>
    </div>
    <div class="field">
      <?php echo $form->submit('Submit',array('url'=> array('controller'=>'users', 'action'=>'forgot_password'),'class'=>'ui fluid button primary')); ?>
    </div>
    <?php echo $form->end(); ?>
  </div>
</div>