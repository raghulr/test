<?php
  $user = $session->read( 'Auth.User' );
  $user_amount= Configure::read('user.user_amount');
?>

<div class="ui body container profile">
<?php if(isset($update)){?>
	<div id="successMessage" class="message">Please add your first and last name so our restaurants recognize you when you dine with them.</div>
<?php } ?>

  <?php if ($user_amount > 0) { ?>
  <div class="ui icon message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        You have a $<?php echo $user_amount ?> credit in your account
      </div>
      <p>Your next reservation is on us.</p>
    </div>
    <a href="/all_restaurant" class="ui button basic right floated">Book Now</a>
  </div>
  <?php } ?>

<div class="ui grid stackable">
  <div class="four wide column">
		<?php echo $this->element('profile_sidebar', array('active' => 'profile')); ?>
	</div>
	<div class="twelve wide column">
	  <?php  echo $form->create('User',array('url'=>array('controller'=>'profile','action'=>'profile'),'class' => 'ui form')); ?>
		<div class="ui middle aligned stackable grid container">
      <div class="row">
        <div class="eight wide column">
  				<?php  echo $form->input('id');?>
  				<h2>My Profile </h2>
  				<div class="field">
  					<label>First Name</label>
  					<?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false)); ?>
  				</div>
  				<div class="field">
  					<label>Last Name</label>
  					<?php  echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false));?>
  				</div>
  				<div class="field">
  					<label>Email</label>
  					 <?php  echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
  			 	</div>
  				<div class="field">
  					<label>Phone</label>
  					<?php  echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false));?>
  				</div>
  				<div class="field">
  					<label>Alternate Phone</label>
  					 <?php  echo $form->input('altphone',array('type'=>'text','label'=>false,'div'=>false));?>
  				</div>
  				<div class="field">
  					<?php
  						if(!empty($this->data['User']['card_type'])){?>
  						<h3>Payment Method</h3>
  						<?php
  						  // Show Card Icon
  						  $card_type =strtolower($this->data['User']['card_type']);
  						  switch ($card_type) {
    						  case 'visa': 
    						    $card_icon = 'visa';
    						    break;
    						  case 'mastercard': 
    						    $card_icon = 'visa';
    						    break;
    						  case 'discover': 
    						    $card_icon = 'visa';
    						    break;
                  default:
    						    $card_icon = 'dollar';
                    break;
  						  }
              ?>
              <i class="icon <?php echo $card_icon ?>"></i>
  						<?php
  							echo  ucfirst($card_type).' ending with ';
    						if(!empty($this->data['User']['card_number'])){
    							if(!isset($card_number))
    								echo $this->data['User']['card_number'];
    							else
    								echo $card_number;
    						}
    						
    						?>
    						<a value="Change" onclick="view_payment_form()">Change</a>
    						<?php 
  						}
  						
  						if(empty($this->data['User']['card_number'])&&(empty($this->data['User']['card_type']))){?>
  						No Payment Method Selected Yet
  						<a href="#" class="" value="Change" onclick="view_payment_form()">Add Card</a>
  					<?php }
  					?>
  				<?php
  					$display='style="display:none;"';
  					if(!empty($this->data['User']['hidden_payment']) && $this->data['User']['hidden_payment']==1){
  						$display='style="display:block;"';
  					}
  				?>
				  </div>
    			<!--Below form appears when the user press - Change Button-->
    			<div class="field payment_show1" <?php echo $display; ?>>
    				<div class="field">
    				  <label>First Name</label>
    					 <?php  echo $form->input('holder_fname',array('class'=>'textbox-contact','type'=>'text','label'=>false,'div'=>false));?>
    				</div>
    				<div class="field">
    					<label>Last Name</label>
    					<?php  echo $form->input('holder_lname',array('class'=>'textbox-contact','type'=>'text','label'=>false,'div'=>false));?>
            </div>
    				<div class="field">
    					<label>Card Type</label>
    					<?php
    							$gateway_options['creditCardTypes'] = array(
    							'Visa' => __l('Visa') ,
    							'MasterCard' => __l('MasterCard') ,
    							'Discover' => __l('Discover') ,
    																			'Amex' => __l('Amex')
    							);
    							echo $form->input('card_type',array('class'=>'ui fluid dropdown','type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes']));
    						?>
            </div>
    				<div class="field">
    					<label>Card Number</label>
    					<?php  echo $form->input('creditCardNumber',array('class'=>'textbox-contact','autocomplete'=>'off','type'=>'text','label'=>false,'div'=>false));?>
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
        						<?php echo $form->month('User.expDateMonth', $month, array('class'=>'ui fluid dropdown'), false); ?>
                </div>
        				<div class="field">
          				<?php echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('class'=>'ui fluid dropdown'), false); ?>
            		</div>
              </div>
            </div>
            <div class="field">
    				  <label>Security Code</label>
              <?php  echo $form->input('cvv2Number',array('class'=>'textbox-contact','type'=>'text','label'=>false,'div'=>false));?>
            </div>
          </div>
          <div class="field">
            <?php echo $form->submit('Update',array('class'=>'ui button primary','div'=>false)); ?>
          </div>
          <?php echo $form->input('hidden_payment',array('type'=>'text','id'=>'payment_box','label'=>false,'style'=>'display:none')); ?>
        </div>
				<?php
				
					$count = 0;
					$i=0;
					if(!empty($location))
						$count = count($location);
					 ?>
				<div class="eight wide column my-location-right position" id="column02">
				  <h2>My Location</h2>
          <?php $set = false; if(!empty($location)){
            foreach($location as $value){
						  $set = true;
              $location=($value['Userlocation']['location_type'] == 1)?'Home':'Work';
          ?>
          <div class="ui cards">
						<div class="card">
					  	<div class="content">
								<?php if ($location == 'Work') { ?>
						    	<i class="right floated icon building"></i>
								<?php } else { ?>
									<i class="right floated icon home"></i>
								<?php } ?>
				       	<div class="header">
				        	<?php echo $location; ?>
				       	</div>
				       	<div class="description">
								 <?php echo $value['Userlocation']['address'];?><br />
								 <?php echo $value['Userlocation']['city'];?>,
								 <?php echo $value['Userlocation']['state'];?>,
								 <?php echo $value['Userlocation']['zipcode'];?>
				       	</div>
					    </div>
					    <div class="extra content">
					    	<div class="ui two buttons">
 									<?php echo $html->link('Edit',array('controller'=>'profile','action'=>'edit_location',$value['Userlocation']['id']),array('class'=>'ui basic button')); ?>
									<?php echo $html->link('Delete',array('controller'=>'users','action'=>'delete_location',$value['Userlocation']['id']),array('class'=>'ui basic button')); ?>
								</div>
					    </div>
					  </div>
					</div>

          <?php
								$i=$i+1;
							}
						}
						if($count<2){
              echo $html->link('Add Location',array('controller'=>'profile','action'=>'location'),array('class'=>'add_location_new')); 
            }
          ?>
          <?php if($count==1) $set=false;?>
					</div>
					<?php echo $form->end(); ?>
				</div>
      </div>
		</div>
	</div>
</div>
