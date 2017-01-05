<div class="modal-header-register">
        <h2><?php if(empty($user_id)): ?>
            Please sign up as a new user or login below to complete your reservation
            <?php else: ?>
            Please confirm and complete your reservation
            <?php endif;?>
        </h2>
    </div><!--/.modal-header-->
    <div class="modal-sub-header">
        <h2>Reservation FOR <?php echo $size; ?>, AT  <?php echo $time; ?> ON  <?php echo date("m/d/Y"); ?></h2>
        <div class="bg-white">
            <?php   
                if(strlen($this->Session->read('res_name'))>15)                
                    $res_name=substr($this->Session->read('res_name'),0,12).'..' ;                
                else 
                    $res_name=$this->Session->read('res_name'); 
            ?>
            <h4>AT <?php echo $res_name;?></h4>
            <div class="bg_cyan">COST: $5.00</div>		
            <div class="spacer"></div>
        </div>		
        <div class="spacer"></div>
    </div>
     <?php 
	$user_amount=0;
	if(!empty($user_id)){
		 $confirm=false;
		 $row=mysql_fetch_array(mysql_query("select users.billingKey,users.user_amount from users where users.id='".$user_id."' "));
		 $billingKey= $row['billingKey'];
		 $user_amount= $row['user_amount'];
		 if(!empty($billingKey)&&$billingKey!='NULL'||$user_amount!=0){
                    $confirm=true;
		 }
		 
	}
	?>
     <?php $display_new='';
     if(isset($this->data['User']))
         $display_new="style='display:none;'";         
     ?>
    <div class="modal-inner-register" id="modal-payment">
    	<?php 
        if(isset($confirm) && $confirm == true){?>
            <div class="btn-group-register box_new" <?php echo $display_new; ?>>
            <p> 
            <?php 
            if($user_amount==0){ 
		echo 'TableSavvy will be using the credit card on file, if you would like to use a different credit card please <a href="javascript:;" id="new_card" onclick="new_card()">click here</a>';
                
            }else{               
                echo 'You have a credit in your TableSavvy account that will be applied to this reservation.';
            }?>
            </p>
            <?php echo $html->link('Cancel','/homes',array('class'=>'btn btn-large')); ?>
            <?php echo $html->link('Confirm',array('controller'=>'users','action'=>'referenceTransaction',$offer_id,$party_res),array('class'=>'btn btn-large btn-success')); ?>	
            </div>
        <?php }?>
    	<div class="gap01">&nbsp;</div>
        <?php if(empty($user_id)){ ?>
            <div class="registerL">				
                <div class="spacer">&nbsp;</div>
                <ul class="signup-link">
                    <li><a href="#" class="active-reg" onClick="changeTab('sign')" id="sign_up">Signup</a></li>
                    <li><a href="#"  onClick="changeTab('login')" id="log_in">Login</a></li>
                </ul>
                <div class="spacer">&nbsp;</div>
                 <?php /******************Login page**********************/ ?>
                <div class="register-grey login_grey" id="login_update" style="display:none;">
                	<?php 
						echo $form->create('User', array('action' => 'login', 'class' => 'normal')); 
						echo $form->input('hideval', array('type' => 'hidden','value'=>'reserv'));
						if(!empty($rest_id_res)) echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res)); else 
							echo $form->input('rest_id_res', array('type' => 'hidden','value'=>''));
						if(!empty($time_res)) echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res)); else 
							echo $form->input('time_res', array('type' => 'hidden','value'=>''));
						if(!empty($party_res)) echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res)); else
							echo $form->input('party_res', array('type' => 'hidden','value'=>''));
						if(!empty($ampm_res)) echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res)); else
							echo $form->input('ampm_res', array('type' => 'hidden','value'=>''));
						?>
                    <div class="register_top">
                    	<?php echo $html->link($html->image('/images/bttn-facebook.gif', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','width'=>225,'height'=>39,'border'=>0)), $fb_login_url, array('escape' => false,'onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
                        <div class="spacer">&nbsp;</div>
                        <h4>Or Login an account below</h4>
                    </div>
                    <table  width="400"  border="0" cellspacing="0" cellpadding="0" class="table-register">
                        <tr>
                             <td class="label01">Email</td>
                            <td align="left"><?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>  </td>
                        </tr>
                        <tr>
                             <td class="label01">Password</td>
                             <td align="left"><?php echo $form->input('password',array('label'=>false,'div'=>false,'size'=>30));?>    </td>
                        </tr>
                    </table>
                    <div class="btn-group-register">
                    <div class="forget_pass float"><a href="<?php echo $html->url(array('controller'=>'users','action'=>'forgot_password'),true); ?>">Forgot your password?</a></div>     
                    <?php echo $ajax->submit('Login', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login_update', 'label'=>false,'class'=>'btn btn-success')); ?>
                    </div>
                     <?php echo $form->end();?>  
                </div>
                  <?php /************************************************/ ?>
                <?php /******************Signup page**********************/ ?>
                <div class="register-grey signup_grey">
                    <div class="register_top">
                       <?php echo $html->link($html->image('/images/bttn-facebook.gif', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','width'=>225,'height'=>39,'border'=>0)), $fb_login_url, array('escape' => false,'onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
                        <div class="spacer">&nbsp;</div>
                        <h4>Or create an account below</h4>
                    </div>
                    <table  width="400"  border="0" cellspacing="0" cellpadding="0" class="table-register">
                     <?php echo $form->create('User', array('action' => 'register', 'class' => 'normal','onsubmit'=>'return checkAll()'));  ?>
                    <?php 
						echo $form->input('hidvalue',array('type'=>'hidden','value'=>'regis_res'));
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
					?>       
                        <tr>
                            <td class="label01">First name</td>
                            <td align="left"><?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?></td>
                        </tr>
                        <tr>
                             <td class="label01">Last name</td>
                            <td align="left"><?php echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?></td>
                        </tr>
                        <tr>
                             <td class="label01">Email</td>
                           <td align="left"><?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?></td>
                        </tr>
                        <tr>
                             <td class="label01">Phone</td>
                            <td align="left"><?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'(xxx)xxx-xxxx','size'=>30));?></td>
                        </tr>
                        <tr>
                            <td class="label01">Password</td>
                            <td align="left"><?php echo $form->input('passwd',array('id'=>'pass','type'=>'password','label'=>false,'div'=>false,'size'=>30));?> </td>
                        </tr>
                        <tr>
                             <td class="label01">Confirm password</td>
                            <td align="left"><?php echo $form->input('confirm_password',array('id'=>'cpass','type'=>'password','label'=>false,'div'=>false,'size'=>30));?></td>
                        </tr>
                        <tr>
                             <td class="label01">Payment type</td>
                             <td align="left">
                                <div class="input select">
                                  <?php 
                                    $redirectUrl = $this->Session->read('Auth.redirectUrl');
                                    $gateway_options['creditCardTypes'] = array(
                                        //'' => __l('Choose Later') ,
                                        'Visa' => __l('Visa') ,
                                        'MasterCard' => __l('MasterCard') ,
                                        'Discover' => __l('Discover') ,
                                        'Amex' => __l('Amex')
                                    );
                                    echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'div'=>false));
                        	
                                ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="checkbox-gap"><?php echo $form->input('agree',array('type'=>'checkbox','label'=>false,'div'=>false));?> 
                        <div class="checkbox_cntr">I would like to receive daily emails with available reservations</div> 
                    </div>
                    <div class="spacer">&nbsp;</div>
                    <div class="btn-group-register">
                    	<?php //echo $form->submit('Signup',array('class'=>'btn btn-success')); ?>
                    </div>
                </div>
                <?php /***************************************************/ ?>
            <div class="spacer"></div>
            </div>
        <?php }?>
        <?php
            $display ='';
            if(!isset($this->data['User']['hidvalue'])&&!empty($billingKey)&&$billingKey!='NULL'||isset($user_amount)&&$user_amount!=0){
                    $display='display:none';
            }
        ?>
    	<!--Payment Information-->
        <div class="registerR payment_R" <?php if(!empty($user_id)) {?>style="margin:0 auto; float:none;<?php echo $display;?>"<?php }?> >	
            <ul class="signup-link">
            	<li><a href="#" class="active-reg">Payment Information</a></li>
            </ul>
       		<div class="spacer">&nbsp;</div>
            <div class="register-grey">
            <?php if(!empty($user_id)&&(!empty($offer_id) || !empty($party_res))&&!empty($billingKey)&&$billingKey!='NULL'){ ?>
                <div class="payment_top">
                    <div class="payment_checkbox"><?php echo $form->input('agree',array('type'=>'checkbox','checked'=> 'checked','label'=>false,'class'=>'agree_check_new','div'=>false,'onclick'=>'agree_check_new()'));?>
                    	<div class="checkbox_cntr02">Use Existing Credit Card</div> 
                    	<div class="spacer"></div>
                    </div>
                </div>
                 <?php if(isset($this->data['User'])){  ?>
                    <script type="text/javascript">
                            var check = document.getElementsByClassName("agree_check_new")[0].checked;
                            var display='';
                            if(check == true){
                                $('#agree').attr('checked',false);
                                display=1;
                            }
                    </script>
                <?php } ?>
                <?php } ?> 
                <div class="spacer">&nbsp;</div>
                <?php
                if(!empty($user_credit_availables) && empty($user_id)): ?>
                    <p>
                        <em>
                        Welcome to TableSavvy! Your first reservation is on us!! 
                        Sign up and your receive a $5 credit to your account!
                        </em>
                    </p>
                <?php endif; ?>        
                <p><em>Your credit card information will be stored securely with our credit processor for your conveniance. 
                There are no startup fees, your card will be charged when you make a reservation.</em></p>
                <?php if(!empty($user_id)){ echo $form->create('User', array('action' => 'payment', 'class' => 'normal')); 
					echo $form->input('hidvalue',array('type'=>'hidden','value'=>'payment_res'));
					if(!empty($rest_id_res)) echo $form->input('rest_id_res', array('type' => 'hidden','value'=>$rest_id_res)); else 
                    echo $form->input('rest_id_res', array('type' => 'hidden','value'=>''));
                   if(!empty($time_res)) echo $form->input('time_res', array('type' => 'hidden','value'=>$time_res)); else 
                     echo $form->input('time_res', array('type' => 'hidden','value'=>''));
                   if(!empty($party_res)) echo $form->input('party_res', array('type' => 'hidden','value'=>$party_res)); else
                     echo $form->input('party_res', array('type' => 'hidden','value'=>''));
                   if(!empty($ampm_res)) echo $form->input('ampm_res', array('type' => 'hidden','value'=>$ampm_res)); else
                     echo $form->input('ampm_res', array('type' => 'hidden','value'=>'')); 
					} ?>
               <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="table-register">
                    <tr>
                         <td class="label01">First name</td>
                        <td align="left"><?php echo $form->input('holder_fname',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>  </td>
                    </tr>
                    <tr>
                        <td class="label01">Last name</td>
                        <td align="left"><?php echo $form->input('holder_lname',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?> </td>
                    </tr>
                    <?php if(!empty($user_id)){ ?>
                    <tr>
                         <td class="label01">Payment Type</td>
                       <td align="left">
                        <?php 
                        $redirectUrl = $this->Session->read('Auth.redirectUrl');
                        $gateway_options['creditCardTypes'] = array(
                                '' => __l('Select Card') ,
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                        );
                        echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'div'=>false));
                        ?>  
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                         <td class="label01">Card Number </td>
                        <td align="left"><?php echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?> </td>
                    </tr>
                    <tr>
                        <td class="label01">Expiry Date</td>
                        <td align="left">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                            	 <?php 
									$year=date('Y')+2;
									$month=date('m');
									if(!empty($this->data['User']['expDateMonth']['month']))
										$month=null;
									if(!empty($this->data['User']['expDateYear']['year']))
										$year=$this->data['User']['expDateYear']['year'];
									else 
										$year=date('Y');
                   			 	?>
                                <td align="right">					
                                   <?php 
                          			echo $form->month('User.expDateMonth', $month, array('empty' => false,'class'=>'small-select-register' ));
									?>
                                </td>
                                <td align="right">
                                <?php 
                                   echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('empty' => false,'class'=>'small-select-register'));
                    			?>     
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	 <?php if(!empty($offer_id)){
								echo $form->hidden('offerId',array('value'=>$offer_id)); 
							} else {
								 echo $form->hidden('offerId',array('value'=>'')); 
							}
						?>
                        <td class="label01">Security Code</td>
                        <td align="right" style="text-align: left">  <?php echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'div'=>false,'size'=>30));?>    </td>
                    </tr>
                </table>
                <div class="checkbox-gap">
                  <?php echo $form->input('store',array('type'=>'checkbox','label'=>false,'div'=>false));?>
                    <div class="checkbox_cntr">I would like to store my credit card information for future reservation</div> 
                </div>
                <div class="spacer">&nbsp;</div>
                <div class="btn-group-register">
                    <?php echo $html->link('Cancel','/homes',array('class'=>'btn btn'));?>
                    <?php echo $form->submit('Submit',array('class'=>'btn btn','id'=>'show_button','div'=>false)); ?>
                    <?php echo $form->end();?>
                </div>  
            </div>
        	<div class="spacer">&nbsp;</div>
        </div>
    <div class="spacer">&nbsp;</div>
    </div><!-- /.modal-inner -->