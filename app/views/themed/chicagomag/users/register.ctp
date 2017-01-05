<script language="javascript1.1">
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
		document.getElementById('payment-form').style.display = 'none';
		parent.$.colorbox.resize({innerHeight:800});
	}else{
		document.getElementById('payment-form').style.display = 'block';
		parent.$.colorbox.resize({height:1200});
	}
}
</script>
<div class="popup_min">
<div  id="login-update" class="modal-new-class">
    <div class="modal-header">
        <h2>Create a new account</h2>
    </div><!--/.modal-header-->
    <?php  echo $form->create('User', array('action' => 'register', 'class' => 'normal','id'=>'register_submit'));  ?>
    <div class="modal-inner modal-inner-with-header clearfix" id="modal-signup">
        
         <?php echo $form->input('hidvalue',array('type'=>'hidden','value'=>''));?>
        <table>
            <tr>
                <td class="label">First Name</td>
                <td class="input-td">
                <?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Last Name</td>
                <td class="input-td">
                 <?php echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="input-td">
                <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Phone</td>
                <td class="input-td">
                <?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Password</td>
                <td class="input-td">
                <?php echo $form->input('passwd',array('id'=>'pass','type'=>'password','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Confirm password</td>
                <td class="input-td">
                <?php echo $form->input('passwd',array('id'=>'cpass','type'=>'password','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Payment type</td>
                <td class="input-td">
                <div class="input select">
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
                            echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false));
                        else:	
                            $gateway_options['creditCardTypes'] = array(
                                '' => __l('Choose Later') ,
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                            );
                            echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false));
                        endif;	
                 ?>
                </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="smaller"> <?php echo $form->input('agree',array('type'=>'checkbox','label'=>'I would like to receive daily emails with available reservations','div'=>false));?>
                </td>
            </tr>
        
        </table>       
        
        <!--<div class="conjunction clearfix margin-bottom"><div>or</div></div>
        <div class="btn-group-center  full-width margin-bottom">
            <a class="btn btn-inverse">Connect using Facebook</a>
        </div>
        <div id="restNav">
            <ul>
                <li><a href="#">Not a member? Sign up</a></li>
                <li><a href="#">Forgot your password?</a></li>
            </ul>
        </div>-->
    </div><!-- /.modal-inner -->
    <div class="modal-inner modal-inner-with-header clearfix" id="modal-payment">
        <table id="payment-form"  <?php  if(!empty($this->data['User']['card_type'])): echo 'style="display:block;"';else: 
        echo 'style="display:none;"'; endif;?>>
            <tr>
                <td class="label">First name</td>
                <td class="input-td">
                         <?php echo $form->input('User.holder_fname',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Last name</td>
                <td class="input-td">
                       <?php echo $form->input('User.holder_lname',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
            <tr>
                <td class="label">Card number</td>
                <td class="input-td">
                     <?php echo $form->input('User.creditCardNumber',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                
                </td>
            </tr>
        
            <tr>
                <td class="label">Expiration date</td>
                <td class="input-td">
                    <?php 
					$year=date('Y')+2;
					$month=date('m');
					if(!empty($this->data['User']['expDateMonth']['month']))
						$month=null;
					if(!empty($this->data['User']['expDateYear']['year']))
						$year=null;
						
					?>
					<?php 
						  echo $form->month('User.expDateMonth', $month, array('empty' => false)); 
						  echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('empty' => false));
					?>
                </td>
            </tr>
            
        
            <tr>
                <td class="label">Security code</td>
                <td class="input-td">
                    <?php echo $form->input('User.cvv2Number',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>
                </td>
            </tr>
        
            <tr>
                <td class="smaller" colspan="2">
               <?php echo $form->input('User.store',array('type'=>'checkbox','label'=>'I would like to store my credit card information for future reservation','div'=>false));?>
                </td>
            </tr>
        </table>
         <div class="btn-group-wrap margin-bottom">
            <div class="btn-group btn-group-center">
                <?php echo $html->link('Cancel','/homes',  array('class'=>'btn btn-large btn-danger float_class')) ?>
                <a href="javascript:;" class="btn btn-large btn-success float_class" id="submit_signup" onclick="checkAll()">Create your account</a>
                
            </div>
            <div class="fb_class">
            <?php echo $html->link('Connect using Facebook', $fb_login_url, array('class'=>'btn btn-inverse','target'=>'_parent')); ?><br />
			</div>
        </div>
    </div>
    <?php echo $form->end();?>
</div>
</div>    