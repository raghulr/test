<script type="application/javascript">
function checkAll(){
	var pass = document.getElementById('pass').value;
	var cpass = document.getElementById('cpass').value;
	if(pass==cpass){
		document.forms["register_submit"].submit();
		return true;
		
	}else{
		alert('Password and Confirm Password must be same')
		return false;
	}
}
function paymenttype(val){
	if(val==''){
		document.getElementById('payment-form-head1').style.display = 'none';
		
	}else{
		document.getElementById('payment-form-head1').style.display = 'block';
	}
}
</script>

<!--Restaurant Reservation-->
			<div class="contact-wrapper erro_class">
			<div class="heading-txt">Sign Up</div>
			<div class="gap04">&nbsp;</div>
			<div class="contact-form">
             <?php  echo $form->create('User', array('action' => 'register', 'class' => 'normal','id'=>'register_submit'));  ?>
				<label class="label-contact">First Name</label>
                <?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Last Name</label>
                 <?php echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Email</label>
                 <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Phone</label>
                <?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Password</label>
                <?php echo $form->input('confirm_password',array('id'=>'pass','type'=>'password','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Confirm Password</label>
                 <?php echo $form->input('passwd',array('id'=>'cpass','type'=>'password','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Payment Type</label>
                <?php 
                        $redirectUrl = $this->Session->read('Auth.redirectUrl');	
                        //$this->Session->write('Auth.redirectUrl','');
                        if(!empty($redirectUrl)):
                            $gateway_options['creditCardTypes'] = array(
                                '' => __l('Choose Later') ,
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                            );
                            echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false,'class'=>'select-contact'));
                        else:	
                            $gateway_options['creditCardTypes'] = array(
                                '' => __l('Choose Later') ,
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                            );
                            echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false,'class'=>'select-contact'));
                        endif;	
                 ?>
				<div class="gap02">&nbsp;</div>
				<ul class="login-links-list">								
					<li>I would like to receive daily emails with available reservations</li>
                    
					<li><?php echo $form->input('agree',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'checkbox-signup'));?></li>		
				</ul>
			<div class="spacer"></div>
			</div>
			
			<!--payment info-->
             <div <?php  if(!empty($this->data['User']['card_type'])): echo 'style="display:block;"';else: 
        echo 'style="display:none;"'; endif;?> id="payment-form-head1">
        <div class="gap05">&nbsp;</div>
			<div class="heading-txt">Payment information</div>
			<div class="gap02">&nbsp;</div>
			<p class="sub-txt02"> Welcome to TableSavvy! Your first reservation is on us!! Sign up and you receive 
			a $5 credit to your account! <!--Your credit card information will be stored securely with 
			our credit processor for your conveniance.-->There are no startup fees, your card will
			only be charged when you make a reservation.</p>
			<div class="gap02">&nbsp;</div>
			<div class="contact-form">
				<label class="label-contact">First Name</label>
                 <?php echo $form->input('User.holder_fname',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Last Name</label>
				<?php echo $form->input('User.holder_lname',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Card Number</label>
                <?php echo $form->input('User.creditCardNumber',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap03">&nbsp;</div>
				<div class="select-small">
               		 <?php 
                        $year=date('Y')+2;
                        $month=date('m');
                        if(!empty($this->data['User']['expDateMonth']['month']))
                            $month=null;
                        if(!empty($this->data['User']['expDateYear']['year']))
                            $year=null;
                            
                        ?>
                        <?php 
                              echo $form->month('User.expDateMonth', $month, array('empty' => false,'class'=>'select-contact02 select-space')); 
                              echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('empty' => false,'class'=>'select-contact02'));
                        ?>
				<div class="spacer"></div>
				</div>
				<label class="label-contact">Expiration Date</label>
				
				<div class="gap03">&nbsp;</div>
				<label class="label-contact">Security Code</label>
                 <?php echo $form->input('User.cvv2Number',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox-contact'));?>
				<div class="gap02">&nbsp;</div>
				<ul class="login-links-list">								
					<li>I would like to store my credit card  for future reservations</li>
					<li><?php echo $form->input('User.store',array('type'=>'checkbox','checked' => true,'label'=>false,'div'=>false,'class'=>'checkbox-signup'));?></li>		
				</ul>
				<div class="gap02">&nbsp;</div>
			</div>
             </div>
             <div class="contact-form">
              <?php echo $form->button('Cancel',array('class'=>'button-contact','type'=>'reset','value'=>'Cancel')); ?>
             <?php echo $form->submit('Sign Up',array('class'=>'button-contact')); ?>
                
                 <?php echo $form->end();?>
			<div class="spacer"></div>
            </div>
            <div class="spacer">&nbsp;</div>
				<div class="or-login-big"><p>OR</p></div>
				<div class="gap03">&nbsp;</div>
				<div class="center button-login-fb">
                <?php echo $html->link($html->image('/images/facebook-signup.png', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','class'=>'button-image img_header')), $fb_login_url, array('escape' => false,'onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
				</div>
			</div>
			
	<div class="spacer"></div>