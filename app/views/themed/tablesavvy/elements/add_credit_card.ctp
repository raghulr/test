
<?php

/* $user = $session->read( 'Auth.User' ); */
$first_name= Configure::read('user.firstName');
$last_name= Configure::read('user.lastName');

echo $form->create('User', array('action' => 'payment', 'class' => 'ui form'));

// If reservation is being made with this entry
if ($reservation == TRUE) {
	echo $form->input('hidvalue', array('type' => 'hidden','value'=>'payment_res'));
	if(!empty($rest_id_res))
		echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res));
	else
    echo $form->input('rest_id_res', array('type' => 'hidden','value'=>''));
  if(!empty($time_res))
		echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res));
	else
    echo $form->input('time_res', array('type' => 'hidden','value'=>''));
  if(!empty($party_res))
		echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res));
	else
		echo $form->input('party_res', array('type' => 'hidden','value'=>''));
  if(!empty($ampm_res))
		echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res));
	else
  	echo $form->input('ampm_res', array('type' => 'hidden','value'=>''));
}
?>

<div class="two fields">
  <div class="field">
    <label>First Name</label>
    <?php echo $form->input('holder_fname',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact','autocomplete'=>'off', 'value'=>$first_name));?>
  </div>
  <div class="field">  
    <label>Last Name</label>
    <?php echo $form->input('holder_lname',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact','autocomplete'=>'off', 'value'=>$last_name));?>
  </div>
</div>
<div class="field">   
  <label>Card Number</label>
  <?php echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact','autocomplete'=>'off'));?>
</div>
<div class="two fields">
  <div class="field"> 
    <label>Payment Type</label>
    <?php
    	$redirectUrl = $this->Session->read('Auth.redirectUrl');
    	//$this->Session->write('Auth.redirectUrl','');
    	if(!empty($redirectUrl)):
    			$gateway_options['creditCardTypes'] = array(
    					'' => __l('Select Card') ,
    					'Visa' => __l('Visa') ,
    					'MasterCard' => __l('MasterCard') ,
    					'Discover' => __l('Discover') ,
    					'Amex' => __l('Amex')
    			);
    			echo $form->input('card_type',array('type'=>'select', 'label'=>false, 'options' => $gateway_options['creditCardTypes'], 'onchange' =>'paymenttype(this.value);', 'div'=>false, 'div'=>false, 'class'=>'ui dropdown'));
    	else:
    			$gateway_options['creditCardTypes'] = array(
    					'' => __l('Select Card') ,
    					'Visa' => __l('Visa') ,
    					'MasterCard' => __l('MasterCard') ,
    					'Discover' => __l('Discover') ,
    					'Amex' => __l('Amex')
    			);
    			echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false,'class'=>'ui dropdown'));
    	endif;
    ?>
  </div>
  <div class="field">
    <label>Expiration Date</label>
    <div class="two fields">
      <div class="field">
        <?php
        	$year=date('Y')+2;
        	$month=date('m');
        	if(!empty($this->data['User']['expDateMonth']['month']))
        			$month=null;
        	if(!empty($this->data['User']['expDateYear']['year']))
        			$year=null;
        ?>
        <?php echo $form->month('User.expDateMonth', $month, array('empty' => false,'class'=>'ui fluid dropdown')); ?>
      </div>
      <div class="field">
        <?php echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('empty' => false,'class'=>'ui fluid dropdown')); ?>
      </div>
    </div>
  </div>
  <div class="field">  
  <label>Security Code</label>
  <?php echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact','autocomplete'=>'off'));?>
</div>
</div>
<div class="field">  
  <?php if(!empty($offer_id)){
		  echo $form->hidden('offerId',array('value'=>$offer_id));
    } else {
      echo $form->hidden('offerId',array('value'=>''));
    }
  ?>
</div>
<div class="field">
  <label>
    <?php echo $form->input('store',array('type'=>'checkbox','checked' => true,'label'=>false,'div'=>false,'class'=>'ui checkbox'));?>
    I would like to store my credit card for future reservations
  </label>
</div>
<div class="field">
  <?php echo $form->submit('Submit',array('class'=>'ui button primary','div'=>false,'id'=>'show_button')); ?>
  <?php echo $html->link('Cancel','/homes',array('class'=>'ui button default'));?>
</div>
<?php echo $form->end();?>