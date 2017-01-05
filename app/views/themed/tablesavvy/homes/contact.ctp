<div class="ui body container">
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
    <?php echo $form->end();?>
  </div>
</div>
