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
		$rcount=mysql_fetch_array(mysql_query("select count(userId) as ct from reservations where reservations.userId='".$user_id."' "));
	}
?>

<div class="ui body container reservation-complete">
	<div class="ui middle aligned very relaxed stackable grid reservation_summary ">
		<div class="three wide column logo">
			<div class="img" style="background-image: url('/img/original/<?php echo $rest_logo; ?>')"></div>
		</div>
		<div class="thirteen wide column">
			<div class="ui three column grid">
				<div class="column">
					<span class="label">Guests</span>
					<span class="value"> <?php echo $size; ?> People</span>
				</div>
				<div class="column">
					<span class="label">Time</span>
					<span class="value"><?php echo $time; ?></span>
					<small><?php echo date("m/d/Y"); ?></small>
				</div>
				<div class="column booking-fee">
					<span class="label">Cost <span class="booking-fee-info info"><i class="icon info circle"></i> <em>Why a fee?</em></span></span>
					<span class="value">
					  <?php if($user_amount == 0){?>
					    $5
					  <?php }else{ ?>
					    <span class="strike">$5</span> $0
            <?php } ?>
					</span>
					<small>Booking Fee</small>
				</div>
			</div>
		</div>
	</div>
	


	<?php /* RESTAURANT NAME
	   
    if(strlen($this->Session->read('res_name'))>15)                
        $res_name=substr($this->Session->read('res_name'),0,15).'..' ;                
    else 
        $res_name=$this->Session->read('res_name'); 
    */
  ?>
	
<div class="ui segment primary">
	<h1>Complete Your Reservation</h1>
	<h2>For 30% Off Your Meal</h2>
		
  <?php 
    $display_new='';
    if(isset($this->data['User'])) {
      $display_new=" style='display:none;'";
    }
    
    if(isset($confirm) && $confirm == true){?>
      <div<?php echo $display_new; ?> class="ui basic center aligned segment">
      <div class="center">
      <?php echo $html->link('Confirm',array('controller'=>'users','action'=>'referenceTransaction',$offer_id,$party_res),array('class'=>'ui button primary')); ?>
      <?php echo $html->link('Cancel','/home',array('class'=>'ui button default')); ?>
      <?php echo $form->input('reserve_url', array('type' => 'hidden','value'=>$saved_url));?>
      <?php 
        if($user_amount==0){ 
          echo '<br /><br /><p><small>'.Configure::read('website.name').' will be using the credit card on file,<br /> if you would like to use a different credit card please <a href="javascript:;" id="new_card" onclick="new_card()">click here</a></small></p>';
        }else{               
          echo '<br /><br /><p><small>Your complimentary credit will be applied to this reservation</small></p>';
        }
      ?>
      </div>
      </div>
      <?php }?>


	<?php if(empty($user_id)): ?>
		<!-- Not signed in, and/or new user -->
	<?php
		else:
		if(isset($rcount['ct'])&&$rcount['ct']>0){?>
			<!-- Existing User -->
	<?php } else {?>
			<!-- Signed up but never booked -->
	<?php }?>
	<?php endif;?></h2>


	<!-- If user logged in, confirm reservation -->
	<?php
		 if(isset($this->data['User']))
			if(isset($confirm) && $confirm == true){
			  ?>
			  <div class="box_new" <?php echo $display_new; ?>>
        <?php
				echo $html->link('Confirm',array('controller'=>'users','action'=>'referenceTransaction',$offer_id,$party_res),array('class'=>'button-contact button-hover'));
				echo $form->input('reserve_url', array('type' => 'hidden','value'=>$saved_url));
				if($user_amount==0){
				  echo Configure::read('website.name').' will be using the credit card on file, if you would like to use a different credit card please <a href="javascript:;" id="new_card" onclick="new_card()">click here</a>';
				} else {
				  echo 'You have a credit in your '.Configure::read('website.name').' account that will be applied to this reservation.';
        }
        ?>
        </div>
        <?php
      }
	?>
	<!-- end confirm -->

	<div class="ui segment">
		<div class="ui horizontal divider">
		</div>
		
		<?php 
  		// IF NO USER EXISTS / NOT LOGGED IN
  		if(empty($user_id)){ 
		?>

		<div class="ui active tab" data-tab="signup">
			<!-- Sign Up Form -->
			<p>Already a member? <a onclick="$.tab('change tab', 'login');">Sign In</a></p>
			<?php echo $this->element('sign_up', array('reservation' => TRUE)); ?>
			<!-- / End Sign Up Form -->
		</div>
		<div class="ui tab" data-tab="login" id="login_update">
			<!-- Login Form -->
			<div class="ui contained form">
			<p>Not a member? <a onclick="$.tab('change tab', 'signup');">Sign Up</a></p>
			<?php echo $this->element('log_in', array('reservation' => TRUE, 'submit_ajax' => TRUE)); ?>
			<!-- End Sign Up Login -->
			</div>
		</div>
		
		<?php 

		// IF USER LOGGED IN
		} else {
  		
  		$display ='';
      if(!isset($this->data['User']['hidvalue'])&&!empty($billingKey)&&$billingKey!='NULL'||isset($user_amount)&&$user_amount!=0){
        $display='display:none;';
      }
    ?>
    
      <div class="payment_R" style=" <?php echo $display;?>" >
      <h2>Checkout</h2>

      <?php if(!empty($user_id)&&(!empty($offer_id) || !empty($party_res))&&!empty($billingKey)&&$billingKey!='NULL'){ ?>
  		  <div>
          <label><?php echo $form->input('agree',array('type'=>'checkbox','checked'=> 'checked','label'=>false,'class'=>'checkbox-signup agree_check_new','div'=>false,'onclick'=>'agree_check_new()'));?>
  				Use Existing Credit Card</label><br /><br />
        </div>

        <?php if(isset($this->data['User'])){	?>
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
  
    <?php
      if(!empty($user_credit_availables) && empty($user_id)): ?>
      <p>
        <em>
          Welcome to <?php echo Configure::read('website.name');?>! Your first reservation is on us!!
          Sign up and you receive a $5 credit to your account!
        </em>
      </p>
    <?php endif; ?>

    <?php echo $this->element('add_credit_card', array('reservation'=> TRUE)); ?>
<?php } ?>
		
	</div>
</div>


</div>
</div>

<?php if(!isset($this->data['User']['test_login'])) { ?>
	<script>
		$(document).ready(function(){
			$('.signup-login .error-message').remove();
		});
	</script>
<?php }?>

<script>
	jQuery(function($) {
	
	  <?php if ($user_amount > 0) { ?>
		$('.booking-fee').popup({
			hideOnScroll: false,
			on: 'manual',
			offset: 20,
			inline: true,
			<?php if (empty($user_id)) { ?>
			content: "Free $5 Credit for New Members"
			<?php } else { ?>
      content: "This one's on us!"
			<?php } ?>
		}).popup('show');
		<?php } ?>
		$('.booking-fee-info').popup({
			hideOnScroll: false,
			on: 'click',
			content: "We've negotiated 30% off at our restaurants saving you money on your meal. This fee simply secures you the seat."
		});
	});
	
  function new_card(){
    var check = document.getElementsByClassName("agree_check_new")[0].checked;
    if(check == true){
  		$('.payment_R').show();
  		$('.box_new').hide();
  		$('#agree').attr('checked',false);
  		parent.$.colorbox.resize({height:900});
    }
  }
  
  function agree_check_new(){
	  var check = document.getElementsByClassName("agree_check_new")[0].checked;
	   if(check == true){
			$('.payment_R').hide();
			$('.box_new').show();
	   } else {
	   		$('.payment_R').show();
				$('.box_new').hide();
	   }
  }
</script>
