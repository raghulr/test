<div class="signup ui page dimmer">
  <div class="content">
    <div class="center">
      <div class="logo mark"></div>

        <h1>Contact Us</h1>
        <h2>Say hello!</h2>
        <p>Have a question that is not answered on our help page? A suggestion? We'd love to hear from you!</p>
        <div class="ui form">
          <?php echo $form->create(); ?>
          <div class="two fields">
            <div class="field">
              <?php echo $form->input('name',array('type'=>'text','label'=>false,'div'=>false, 'placeholder' => 'Your Name'));?>
            </div>
            <div class="field">
              <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false, 'placeholder' => 'Your Email'));?>
            </div>
          </div>
          <div class="field">
            <?php echo $form->input('comment',array('type'=>'textarea','label'=>false,'div'=>false, 'placeholder' => 'Your Message'));?>
          </div>
          <div class="field">
            <?php echo $form->submit('Submit',array('class' => 'ui button primary','div'=>false));?>
          </div>
        </div>

      <div class="ui form">
        <?php echo $form->create('User', array('action' => 'login', 'class' => 'normal')); ?>
        <h3>Become a Member</h3>
        <div class="three fields">
          <div class="field">
            <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false, 'placeholder' => 'Email')); ?>
          </div>
          <div class="field">
            <?php echo $form->input('password',array('type'=>'password','label'=>false,'div'=>false, 'placeholder' => 'Password')); ?>
          </div>
          <div class="field">
            <?php  echo $form->submit('Login', array('class' => 'ui button fluid primary', 'url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update','label'=>false)); ?>
          </div>
        </div>
      </div>
      <?php echo $form->end(); ?>
      <a href="<?php  echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a>
      <span>|</span>
      <a href="<?php  echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>">Not a member? Sign up</a>
      <p>CREATE AN ACCOUNT AND UNLOCK 30% OFF WITH EVERY RESERVATION</p>

      <div class="center button-login-fb_login">
        <a href="<?php echo $fb_login_url ?>" class="ui facebook button">
          <i class="facebook icon"></i><strong>Log In</strong> with <strong>Facebook</strong>
        </a>
      </div>



    </div>
  </div>
</div>
