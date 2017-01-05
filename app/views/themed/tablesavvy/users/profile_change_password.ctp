<div class="ui body container">
<div class="ui segment ui form contained">
  <h2>Change password</h2>
  <?php
    echo $form->create('User', array('action' => 'profile_change_password',$this->params['pass'])); 
    echo $form->input('id', array('value'=>$string));
  ?>
  
  <div class="field">
    <label>Email</label>
    <?php echo $form->input('email', array('type' => 'text','label'=>false,'div'=>false,'class'=>'textbox-contact')); ?>
  </div>
  <div class="field">
    <label>New Password</label>
   <?php echo $form->input('passwd', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password','class'=>'textbox-contact')); ?>
  </div>
  <div class="field">
    <label>Confirm Password</label>
    <?php echo $form->input('confirm_password', array('type' => 'password','label'=>false,'div'=>false, 'id' => 'new-password','class'=>'textbox-contact')); ?>
  </div>
  <div class="field">
    <?php echo $form->submit('Confirm', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false,'class'=>'ui button primary'));?>
  </div>
  <?php echo $form->end();?>
</div>
</div>