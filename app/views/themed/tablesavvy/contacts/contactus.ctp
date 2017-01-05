<div class="ui body container">
  <h2>Contact Us </h2>
  <?php echo $form->create('Contact', array('action' => 'contactus', 'class' => 'ui form ','type' => 'file')); ?>
    <p> Have a question that isn't answered on our FAQ page? A suggestion? We'd love to hear from you!</p>
    <div class="field">
      <label>Your name</label>
      <?php echo $form->input('name',array('type'=>'text','class'=>'textbox-contact','label'=>false,'div'=>false));?>
    </div>
    <div class="field">
      <label>Contact type</label>
      <?php echo $form->input('contact',array(
  		  'type'=>'select',
  			'selected'=>$inquiries,
  			'label'=>false,
  			'class'=>'ui fluid dropdown',
  			'options'=>array('General'=>'General','Support'=>'Support','Restaurant Inquiries'=>'Restaurant Inquiries')
      ));?>
    </div>
    <div class="field">
      <label>Your Email</label>
       <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
    </div>
    <div class="field">
      <label>Comment</label>
      <?php echo $form->input('comment',array('type'=>'textarea', 'label'=>false,'div'=>false));?>
    </div>
    <div class="field">
      <input type="button" class="ui button primary" onclick="document.getElementById('ContactContactusForm').submit();" value="Submit">
    </div>
  <?php echo $form->end(); ?>
</div>
