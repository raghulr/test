<div id="page-body-right" class="reservation_details">
   <?php echo $this->element('navigation'); ?>
    <div id="content" class="clearfix">
        <div id="content-header" class="hatched clearfix">
            <ul>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>">My Reservation</a></li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>">Alerts</a></li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>">History</a></li>
                <li class="on">Profile</li>
            </ul>
        </div>
        <div class="content">							
        	<h1>My Profile</h1>
        	<div class="clearfix">&nbsp;</div>
            <div class="my-profile-left">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    	<?php  echo $form->create('User',array('url'=>array('controller'=>'profiles','action'=>'profile'))); ?>
                         <?php  echo $form->input('id');?>
                        <td width="237" align="left" valign="center" class="label02">First Name:</td>
                        <td class="input-td">
                        <?php echo $form->input('firstName',array('type'=>'text','label'=>false,'size'=>37,'div'=>false)); ?>
                        </td>
                    </tr>
                	<tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                        <td align="left" valign="center" class="label02">Last Name:</td>
                        <td class="input-td">
                         <?php  echo $form->input('lastName',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </td>
                    </tr>
                	<tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                        <td align="left" valign="center" class="label02">Email:</td>
                        <td class="input-td">
                        <div class="input select">
                         <?php  echo $form->input('email',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </div>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                        <td align="left" valign="center" class="label02">Phone:</td>
                        <td class="input-td">
                         <?php  echo $form->input('phone',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                    				
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                        <td align="left" valign="center" class="label02">Alternate Phone:</td>
                        <td class="input-td">
                         <?php  echo $form->input('altphone',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>				
                        </td>
                    </tr>
                </table>
                <div class="profile_change">
                    <div class="btn-group-container">
                    	<div id="paymentmethod">Payment method</div>
                        <div id="card_type">
							<?php
								if(!empty($this->data['User']['card_type']))
									echo ucfirst(strtolower($this->data['User']['card_type'])).' ending with ';
								if(!empty($this->data['User']['card_number']))
									echo $this->data['User']['card_number']; 
							?> 
                        </div>
                    	<a href="javascript:;" id=""class="btn btn-success" onclick="view_payment_form()">Change</a>
                    </div>
                </div>
                <?php
				$display='style="display:none;float:left"';  
				if(!empty($this->data['User']['hidden_payment']) && $this->data['User']['hidden_payment']==1)
						$display='style="display:block;float:left"';
				?>
                <table width="100%"  border="0" cellspacing="0" cellpadding="0"  class="payment_show" <?php echo $display; ?> >
                	<tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                    	<td width="237" align="left" valign="center" class="label02">First Name:</td>
                        <td class="input-td">
                         <?php  echo $form->input('holder_fname',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                     <tr>
                    	<td align="left" valign="center" class="label02">Last Name:</td>
                        <td class="input-td">
                         <?php  echo $form->input('holder_lname',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                    	<td align="left" valign="center" class="label02">Payment Type:</td>
                        <td class="input-td new_payment">
                        <?php 
							$gateway_options['creditCardTypes'] = array(
							'Visa' => __l('Visa') ,
							'MasterCard' => __l('MasterCard') ,
							'Discover' => __l('Discover') ,
							'Amex' => __l('Amex')
							);
							echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes']));
                    	?>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                     <tr>
                    	<td align="left" valign="center" class="label02">Card Number:</td>
                        <td class="input-td">
                         <?php  echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                    <tr>
                    	<td align="left" valign="center" class="label02">Expiry Date:</td>
                        <td class="input-td">
                         <?php 
							$year=date('Y')+2;
							$month=date('m');
							if(!empty($this->data['User']['expDateMonth']['month']))
								$month=null;
							if(!empty($this->data['User']['expDateYear']['year']))
								$year=null;
						?>
						<?php echo $form->month('User.expDateMonth', $month, array('class'=>'select_new'), false); 
                            echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array('class'=>'select_new'), false);
                        ?>
                        </td>
                    </tr>
                    <tr><td class="gap01">&nbsp;</td></tr>
                     <tr>
                    	<td align="left" valign="center" class="label02">Security Code:</td>
                        <td class="input-td">
                         <?php  echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'size'=>37,'div'=>false));?>
                        </td>
                          <?php 
							echo $form->input('hidden_payment',array('type'=>'text','id'=>'payment_box','label'=>false,'style'=>'display:none'));
						?>
                    </tr>
                </table>
                <div class="spacer">&nbsp;</div>
            </div>
            <div class="my-profile-right">
                <div class="modal-profile">
                    <div class="modal-profile-inner">
                        <div class="hd-edit">
                        	<?php 
									$count = 0;
									if(!empty($location))
										$count = count($location);
							?>
                            <div>
							<?php 
								if($count<2){
							 		echo $html->link('+',array('controller'=>'users','action'=>'location'),array('class'=>'color_location btn btn-success btn-location'));
							 	}
							 ?>
                            </div>
                            <div><h4>My Location</h4></div>
                            <div class="spacer"></div>
                        </div>
                    	<div class="spacer">&nbsp;</div>
                         <?php $set = false; if(!empty($location)){
								 foreach($location as $value){
								 	$set = true;
								 	$location=($value['Userlocation']['location_type'] == 1)?'Home':'Work';
								 ?>
									<div class="edit-wrap">
										<div class="edit-list">
                                        <?php echo $html->link('Delete',array('controller'=>'users','action'=>'delete_location',$value['Userlocation']['id']),array('class'=>'delete-tab')); ?>
                                        <?php echo $html->link('Edit',array('controller'=>'users','action'=>'edit_location',$value['Userlocation']['id']),array('class'=>'edit-tab btn-location')); ?>
										</div>
										<h5><?php echo $location; ?></h5>
										<div class="spacer">&nbsp;</div>
										<p><?php echo $value['Userlocation']['address'];?><br />
										<?php echo $value['Userlocation']['city'];?>, <?php echo $value['Userlocation']['state'];?>, <?php echo $value['Userlocation']['zipcode'];?></p>
										<div class="spacer"></div>
									</div>
                        <?php 	} 
							}?>
                    <div class="clearfix"></div>
                    </div>
                </div>
            	<div class="spacer"></div>
                <div class="btn-group-container width_set <?php if($set){ echo 'postion_class new_set';}?>" id="check_position_css">
					 <?php echo $form->submit('Update',array('class'=>'btn btn-success','div'=>false)); ?>
                    <?php echo $form->end(); ?>
            	</div>
            </div>
             
        </div>
    </div><!-- /#content -->
</div>