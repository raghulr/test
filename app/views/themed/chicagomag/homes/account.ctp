<div class="curve_topp">
    <div class="left_cur"></div>
    <div class="top_mid"></div>
    <div class="right_cur"></div>
</div>

  <div class="con_left"></div>
 <div class="all">
 <div class="titlepopup">
        <div class="lefttitlepopup"></div>
        <div class="midtitlepopup"><div class="new_text"></div></span></div>
        <div class="righttitlepopup"></div>
    </div>
<div class="mainlogin">
	<div class="loginname">
    	<label>First Name</label>
        <?php echo $form->input('fname',array('type'=>'text','label'=>false,'div'=>false));?>
    </div>
    <div class="loginname">
    	<label>Last Name</label>
        <?php echo $form->input('lname',array('type'=>'text','label'=>false,'div'=>false));?>
    </div>
     <div class="loginname">
    	<label>Email</label>
        <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
    </div>
     <div class="loginname">
    	<label>Phone</label>
        <?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false));?>
    </div>
     <div class="loginname">
    	<label>Password</label>
        <?php echo $form->input('Password',array('type'=>'password','label'=>false,'div'=>false));?>
    </div>
    <div class="paymentuser">
    	<div class="paymenthead">
        	<div class="pay_text"></div>
        </div>
        <div class="paymentmain">
        	<div class="paymentpolicy">
            	Your credit card information will be stored securely with our credit processor for your convenience. There are no startup fees; your card will be charged when you make a reservation.
            </div>
            <div class="paymentdetails">
            <label>Cardholder Name</label>
            <?php echo $form->input('holder_name',array('type'=>'text','label'=>false,'div'=>false));?>
   			 </div>
              <div class="paymentdetails">
               <label>Card Type</label>
            <?php echo $form->input('card_type',array('type'=>'select','label'=>false,'options'=>array('Visa'),'div'=>false));?>
              </div>
              <div class="paymentdetails">
            <label>Card Number</label>
            <?php echo $form->input('card_number',array('type'=>'text','label'=>false,'div'=>false));?>
   			 </div>
             <div class="paymentdetails">
            <label>Security Code</label>
            <?php echo $form->input('security_code',array('type'=>'text','label'=>false,'div'=>false));?>
   			 </div>
              <div class="paymentdetailscheck">
               <?php echo $form->input('later',array('type'=>'checkbox','label'=>'I’ll fill this in later','div'=>false));?>
              </div>
        </div>
    </div>
    <div class="agreeterms">
     <?php echo $form->input('agree',array('type'=>'checkbox','label'=>'I did like to receive daily emails with available reservations','div'=>false));?>
    </div>
     <div class="agreeterms">
     <?php echo $form->submit('/images/signup.png',array()); ?>
      <?php echo $form->submit('/images/cance.png',array()); ?>
     </div>
</div>
</div>
<div class="con_right"></div>
<div class="bott">
    <div class="bot_left"></div>
    <div class="bot_mid"></div>
    <div class="bot_right"></div>
</div>