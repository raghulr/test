<!--Main-wrapper-->
<div class="shadow-wrapper">
<div class="shadow-bg">		
<!--top-wrapper-->
<div class="top-wrapper">		
		<div class="logo">
        	<?php echo $html->link($html->image('/images/logo.png',array('width'=>231,'height'=>'58')),'/homes',array('escape'=>false)); ?>
		<div class="spacer"></div>
		</div>    
		<div class="top-right">
		<ul class="sn-link">
        
			<li><?php echo $html->image('/images/logo-chicago.png',array('width'=>247,'height'=>'45','border'=>0)); ?></li>
			<li class="img-sn">
			<?php	echo $html->link($html->image('/images/sn-t.png',array('width'=>32,'height'=>'32')),Configure::read('website.twitter'),array('escape'=>false));?></li>
			<li class="img-sn"><?php	echo $html->link($html->image('/images/sn-f.png',array('width'=>32,'height'=>'32')),Configure::read('website.facebook'),array('escape'=>false));?></li>
		</ul>
		<div class="spacer"></div>
		</div>
<div class="spacer"></div>
</div>
		<!--Header-->
		<div class="header-wrapper">
		<h1>The most memorable experiences <br />are rarely booked in advance.</h1>
		<div class="header-image">
			<!--Header-Left-->
			<div class="header-left">
			<div class="header-left-content">
				<ul class="checker-list">
				<li>Launching Soon!! Sign up with TableSavvy today to get exclusive access to  last minute tables at Chicago's finest restaurants</li>
				<li class="last-checker">Are you a restaurant that wants to participate?? Email us at <a href="mailto:support@TableSavvy.com">support@TableSavvy.com!</a></li>
				</ul>
			</div>
			<div class="spacer"></div>
			</div>
			<!--Form Right-->
			<div class="header-form">
            	 <?php  echo $form->create('Subscription');  ?>
				<!--successful submission message-->
				<div class="success-message hidden-div02">You made a successful submission</div>
                <!--successful submission message hidden-->
				<label>First name</label>
				<div class="textbox-bg">
               <?php echo $form->input('Subscription.firstName',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'First name'));?>
				</div>
				<div class="spacer">&nbsp;</div>
				<!--Error Styling hidden-->
				<div class="error-div hidden-div">
				<label>First name</label>
				<div class="textbox-bg">
				<!--<input type="text" class="textbox01" value="First name" 
				onfocus="if(this.value=='First name')this.value='';" onblur="if(this.value=='')this.value='First name';" />-->
				</div>
				<div class="spacer"></div>
				</div>
				<!--Error Styling-->
				<div class="gap01">&nbsp;</div>
				
				<label>Last name</label>
				<div class="textbox-bg">
                 <?php echo $form->input('Subscription.lastName',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'Last name'));?>
				</div>
				<div class="gap01">&nbsp;</div>
				<label>Email</label>
				<div class="textbox-bg">
                 <?php echo $form->input('Subscription.email',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'Email'));?>
				</div>
				<div class="gap01">&nbsp;</div>
				<label>Phone</label>
				<div class="textbox-bg">
                <?php echo $form->input('Subscription.phone',array('type'=>'text','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'(xxx)xxx-xxxx'));?>  
				</div>
				<div class="gap01">&nbsp;</div>
				<label>Password</label>
				<div class="textbox-bg">
                 <?php echo $form->input('Subscription.passwd',array('type'=>'password','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'Password'));?>
				</div>
				<div class="gap01">&nbsp;</div>
				<label>Confirm Password</label>
				<div class="textbox-bg">
                <?php echo $form->input('Subscription.confirm_password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'textbox01','placeholder'=>'Confirm password'));?>
				</div>
				<div class="gap01">&nbsp;</div>
                <?php echo $form->submit('',array('class'=>'buttonSubmit')); ?>
                 <?php echo $form->end();?>
			<div class="spacer"></div>
			</div>
		</div>
		<div class="spacer"></div>
		</div>
		<!--How It works-->
		<div class="how-it-work">
		<h2 class="align-center">How it works</h2>
		<div class="steps-wrapper">
			<!--Steps#01-->
			<div class="steps" id="column01">
			<h3>Step 1 </h3>
			<h4>Daily<br />Offerings</h4>
			<p>On a daily basis, restaurants will push their empty tables out to TableSavvy's customers for 30% off your meal!</p>
			<div class="spacer"></div>
			</div>
			<!--Steps#02-->
			<div class="steps" id="column02">
			<h3>Step 2</h3>
			<h4>Click, buy<br />and save</h4>
			<p>See offers you like? With one click, for a small processing fee of $5, 
			you can secure this last minute offer for 30% off your food selection!</p>
			<div class="spacer"></div>
			</div>
			<!--Steps#03-->
			<div class="steps steps-space" id="column03">
			<h3>Step 3</h3>
			<h4>No coupon<br />necessary</h4>
			<p>Once your reservation is set, an automatic alert will be sent to the restaurant
			and 30% will automatically be taken off your bill. No coupon necessary!</p>
			<div class="spacer"></div>
			</div>
		<div class="spacer"></div>
		</div>
		<div class="spacer"></div>
		</div>
<div class="spacer"></div>
</div>
<!--Shadow-bottom-->
<div class="shadow-bg-bottom">&nbsp;</div>
<div class="spacer"></div>
</div>
