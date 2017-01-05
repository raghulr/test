<div class="ui body container">
  <div class="users form js-responses">
   <?php
     $formClass = !empty($this->data['User']['is_requested']) ? 'js-ajax-login' : '';
     echo $form->create('User', array('action' => 'forget_password', 'class' => 'ui form '.$formClass));
    ?>    
    <h2>Forgot your password?</h2>
    <div class="field">
      <label>Email address:</label>
      <?php echo $form->input('email',array('label'=>false,'class'=>'text')); ?>
    </div>
    <div class="field">
      <?php echo $form->submit('Submit',array('url'=> array('controller'=>'users', 'action'=>'forget_password'),'class'=>'')); ?>
    </div>
    <?php echo $form->end(); ?>
  </div>
</div>