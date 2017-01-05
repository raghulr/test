<script type="text/javascript">
function validate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   return reg.test(email);
   alert(reg.test(email));
}

function trim(str){
  var str = str.replace(/^\s\s*/,''),
    ws = /\s/,
    i = str.length;
  while (ws.test(str.charAt(--i)));
  return str.slice(0, i + 1);
}

function checkAll(){
  //var status = true;
  var i = 0;
  var emails = document.getElementById('mail').value.split(",");
  for(i=0; i<emails.length; i++){
    if(!validate(trim(emails[i]))){     
      alert("Please enter valid email: "+emails[i]);
      return false;
      break;
    }
  }
  return true;
}
</script>
<div class="ui body container">


  <div class="ui grid stackable">
    <div class="four wide column">
      <?php echo $this->element('profile_sidebar', array('active' => 'index')); ?>
    </div>
    <div class="twelve wide column">
      <div>
        <div id="content">
          <div class="contact-wrapper">
            <h2>Send Invitations to Your Friends</h2>
            <?php echo $form->create('User', array('controller'=>'profiles','action' => 'send','class'=> 'ui form','onsubmit'=>'return checkAll()')); ?>    
            <div class="contact-form">
              <div class="field" style="display:none;">
                <label class="label-contact">Sender Name</label>
                <?php foreach($sender as $send) ?>
                  <?php echo $form->input('name',array('type'=>'text','value'=>$send['User']['firstName'],'label'=>false,'div'=>false,'readonly' => 'readonly','class'=>'textbox-contact'));?>
                  <label class="label-contact">Sender Email</label>
                  
                  <?php foreach($sender as $send) ?>    
                    <?php echo $form->input('senderemail',array('type'=>'text','value'=>$send['User']['email'],'label'=>false,'div'=>false,'readonly' => 'readonly','class'=>'textbox-contact'));?>
              </div>
              <div class="field"> 
                <label class="label-contact">Receiver Email</label>
                <?php echo $form->input('receiveremail',array('type'=>'text','id'=>'mail','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
              </div>
              <div class="field">              
                <label class="label-contact">Subject</label>
                <?php echo $form->input('subject',array('type'=>'text','value'=>$subject,'label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
              </div>
              <div class="field">
                <label class="label-contact">Comment </label>
                <?php if(empty($transactionId)) 
                  $transactionId ='';
                  echo $form->hidden('transactionId',array('value'=>$transactionId));
                ?> 
                <?php echo $form->input('content1',array('type'=>'textarea','label'=>false, 'class'=>'textarea', 'div'=>false,'class'=>'textarea-contact'));?>
              </div>
              <div class="field">
                <?php echo $html->link('Cancel','/profile',array('class'=>'ui button default')); ?>
                <?php echo $form->submit('Submit',array('label'=>false,'div'=>false,'class'=>'ui button primary'));?>
              </div>
              <?php echo $form->end(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>