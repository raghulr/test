<style>
	body {
	padding:14px 0 0;
	margin:0;
	font-family:Helvetica, arial, sans-serif;
	}
	.message {
		font-weight: 700;
		font-size:14px;
		left: 0;
		padding: 0px 60px 6px 60px;
		position: fixed;
		top: 0;
		width: 100%;
		z-index: 10000;
	}
	.admin .message {
		width: 65%;
	}
	.loginname .submit_login1{
	background: url(../images/login_03.png) no-repeat;
	float:right;
	width:123px;
	margin-left:135px;
	border:none;
	text-indent:8000px;
	height:43px;
}
	.loginname{ margin:0px; width:258px;}
	
</style>

<?php echo $html->css('tabcontent.css'); 
	  //echo $html->css('popup.css');?>
<?php echo $html->css('style1.css'); ?>
<?php $javascript->link('tabcontent', false);?>
<script language="javascript1.1">
function change_reservation(url){
	//$.colorbox.close();
	parent.window.location = url;
}
</script> 
<script type="text/javascript">
   $(document).ready(function(){
    $(".agree_check").click(function(){
	  var check = document.getElementsByClassName("agree_check")[0].checked;
	   if(check == true){
			$('#pay_form_show').hide();
			$('#pay_sub').show(); 
	   } else {
	   		$('#pay_form_show').show();
			$('#pay_sub').hide();
	   }
	 });
  });    
</script>
<script type="text/javascript">
function check_login(){
	
		var data='<?php if($user_id==''){ echo '<a href="'.$html->url(array('controller'=>'users','action'=>'login',1),true).'"  class="color_login">LOGIN</a>';
 }else { echo '<a href="'.$html->url(array('controller'=>'users','action'=>'logout'),true).'">LOGOUT</a>';
}?>';
		parent.$("#check_log").html(data);
		parent.Cufon.replace('.menu_list ul li a',{ fontFamily: 'diavlo light' });
		
		var data1='<?php if($user_id==''){ echo '<a href="'.$html->url(array('controller'=>'users','action'=>'register'),true).'"  class="color_sign" style="color:#FFFFFF;padding-left:20px;">Not a member? Sign up!</a>';
		}else{
			$row=mysql_fetch_array(mysql_query("select users.Firstname,users.user_amount from users where users.id='".$user_id."' "));
			$user_fname= $row['Firstname'];
			$user_amount= $row['user_amount'];
		?>
		Welcome, <?php echo $user_fname.'!'?> | My Account $<?php echo $user_amount;?>
		<?php
		}?>';
		
		parent.$("#fb_sign").html(data1);
		parent.Cufon.replace('.fb_sign',{ fontFamily: 'diavlo light' });
		
		var data2='<?php if($user_id==''){ echo '<a href="'.$html->url(array('controller'=>'users','action'=>'login'),true).'"  class="color_login">MY SAVVY DEALS</a>';
		}else{
			echo '<a href="'.$html->url(array('controller'=>'profiles','action'=>'index'),true).'">MY SAVVY DEALS</a>';
		?>
		<?php
		}?>';
		
		parent.$("#check_login").html(data2);
		parent.Cufon.replace('.menu_list ul li a',{ fontFamily: 'diavlo light' });
		parent.$.colorbox.close();
		//parent.window.location.reload();
		return true;
}
</script>

<div class="reserve_new" style="position:relative;"> <!-- <a href="#" onclick="return check_login()" style="float:right; position:relative; top:-12px; height:25px;">-->
    <a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; position:relative; top:-12px; height:25px;">
<?php echo $html->image('/images/close.png',array('width'=>33,'height'=>34,'border'=>0)); ?></a>
<div id="reservation_container" style="height:856px;">
	
	<?php if(!empty($result) && ($result>0)):?>
        <div class="reservation_box">
            <div class="box1">If you are already logged in, you can confirm and complete your reservation.<br /> 
                If not, you can sign up as a new user or login below!!</div>
                <div class="box2">
                <div class="first">RESERVATION FOR  <?php echo $size; ?>, AT <?php echo $time; ?> ON <?php echo date("m/d/Y"); ?></div>
                <div class="second">AT <?php echo $this->Session->read('res_name'); ?><div class="secondinner">COST: $5.00</div></div>
            </div>
        </div>
    
        <div class="confirmation">
       	  <div class="cancel"><a  onclick="return check_login()" style="cursor:pointer; float:left; padding:7px 21px;">CANCEL</a></div>
        	<!--<div><input type="button" class="confirm" value="Confrim" /></div>-->
			<?php 
                        $chic=explode('/',$this->params['url']['url']);
                        if($chic[0]=='chicago'){
                            $chicagomag = 'chicagomag';
                        }else{
                            $chicagomag='';
                        }
                        $user_id = $this->Auth->user('id'); $account_type = $this->Auth->user('account_type');?>
                    <?php if(!empty($user_id) && $account_type == 3 ){ ?>
                    <?php 
                        $row=mysql_fetch_array(mysql_query("select users.billingKey from users where users.id='".$user_id."' "));
                        $billingKey= $row['billingKey'];
                        //echo $billingKey = $this->Auth->user('billingKey');
                        if(!empty($billingKey)):
                        echo $form->create('Reservation', array('action' => 'login', 'class' => 'normal')); 
                        echo $form->input('time', array('type' => 'hidden','value'=>$this->params['url']['time']));
                        echo $form->input('ampm', array('type' => 'hidden','value'=>$this->params['url']['ampm']));
                        echo $form->input('party', array('type' => 'hidden','value'=>$this->params['url']['party']));
                        echo $form->input('rest_id', array('type' => 'hidden','value'=>$this->params['url']['rest_id']));
                        echo $form->input('offerId', array('type' => 'hidden','value'=>$offerid['Offer']['id']));
						
                    ?>	
                    <?php
                        if($size==2||$size==4||$size==6||$size==8)
                             $size=0;
                    ?>
                    <a href="<?php echo $html->url(array('controller'=>'users','action'=>'payment',$offerid['Offer']['id']),true); ?>" onclick="parent.$.colorbox({href:'<?php echo $html->url(array('controller'=>'users','action'=>'payment',$offerid['Offer']['id'],$size,$chicagomag),true); ?>',iframe:true,innerWidth:625,innerHeight:1500,scrolling:false}); return true;"><input type="button" class="confirm" value="Confrim" /></a>
                    <?php echo $form->end(); ?>        
                    <?php else: ?>
                    <a href="<?php echo $html->url(array('controller'=>'users','action'=>'payment',$offerid['Offer']['id']),true); ?>" onclick="parent.$.colorbox({href:'<?php echo $html->url(array('controller'=>'users','action'=>'payment',$offerid['Offer']['id'],$size,$chicagomag),true); ?>',iframe:true,innerWidth:900,innerHeight:1500,scrolling:false}); return true;"><input type="button" class="confirm" value="Confrim" /></a>
                    <?php endif;	?>
                    <?php } else {
                        $chic=explode('/',$this->params['url']['url']);
                        if($chic[0]=='chicago'){
                    ?>
                    <a href="<?php echo $html->url(array('controller'=>'users','action'=>'login','chicago'=>true),true); ?>" onclick="parent.$.colorbox({href:'<?php echo $html->url(array('controller'=>'homes','action'=>'reservation','chicago'=>true),true); ?>',iframe:true,innerWidth:950,innerHeight:900,scrolling:false}); return true;"><input type="button" class="confirm" value="Confrim" /></a>
                    <?php }else{?>
                    <a href="<?php echo $html->url(array('controller'=>'users','action'=>'login',$chicagomag),true); ?>" onclick="parent.$.colorbox({href:'<?php echo $html->url(array('controller'=>'homes','action'=>'reservation',$chicagomag),true); ?>',iframe:true,innerWidth:950,innerHeight:900,scrolling:false}); return true;"><input type="button" class="confirm" value="Confrim" /></a>	
                    <?php }
                    } ?>
        </div>
    <?php endif; ?>
    
    
<div class="login_payment_page">
<div class="login_page">
    <ul id="countrytabs" class="shadetabs">
        <li><a href="#" rel="country1" class="selected">Sign Up</a></li>
        <li><a href="#" rel="country2">Login</a></li>
    </ul>
<div style="border:1px solid #bababa; width:424px; margin-bottom: 1em; padding: 10px">

	<div id="country2" class="tabcontent">
         <div style="width:424px" id="login-update">
            <?php  echo $form->create('User', array('action' => 'login', 'class' => 'normal')); 
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
             <?php $redirectUrl = $this->Session->read('Auth.redirectUrl');	
                $approved = $this->Auth->user('approved');
                if($this->Auth->user('account_type')!=3&&$approved!=1) : ?>
        <div style="text-align:center">
            <?php echo $html->link($html->image('/images/facebook_login.png', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','width'=>228,'height'=>42,			            'border'=>0)), $fb_login_url, array('escape' => false,'class'=>'facebook-link','onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
        </div>
        <div> <p style="width:368px;">Or Login an account below</p> </div>
        <div> <img src="../images/single-line.jpg" width="421" height="4" /> </div>
        <div style="width:100%">
            <div class="loginname" style="margin:10px 0 10px 33px; width:396px; float:none; height:42px;"> 
                   <label style="float:left; width:18%;">Email : </label>
                   <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>   
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 33px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:18%;">Password : </label>
                    <?php echo $form->input('password',array('label'=>false,'div'=>false));?>
            </div>
        </div>
        <div style="width:100%">
            <div style="margin:0 0 10px 33px; width:396px; float:none;"> 
               <?php
                echo $ajax->submit('', array('url'=> array('controller'=>'users', 'action'=>'login'), 'update' => 'login-update', 'label'=>false,'class'=>'submit_login')); 
                ?>
            </div>
        </div>
        <?php endif; ?> <?php echo $form->end();?>
        </div>
	</div>

	<div id="country1" class="tabcontent">
    	 <?php $approved = $this->Auth->user('approved');
            if($this->Auth->user('account_type')!=3&&$approved!=1) : ?>
        <div style="width:424px">
        	<div style="width:424px">
                <div style="float:left; margin:0px 75px;">
                    <?php echo $html->link($html->image('/images/facebook_login.png', array('alt' =>'[Image: Facebook Connect]', 'title' => 'Facebook connect','width'=>228,'height'=>42,'border'=>0)), $fb_login_url, array('escape' => false,'class'=>'facebook-link','onclick'=>'return change_reservation("'.$fb_login_url.'")')); ?>
                </div>
        	</div>
            <div style="width:424px">
                <p style="width:368px;">Or Login an account below</p>
            </div>
            <img src="../images/single-line.jpg" width="421" height="4" />
        <?php echo $form->create('User', array('action' => 'register', 'class' => 'normal','onsubmit'=>'return checkAll()'));  ?>
        <?php echo $form->input('hidvalue',array('type'=>'hidden','value'=>'regis_res'));?>
        <div style="width:100%">
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                   <label style="float:left; width:29%;">First Name </label>
                    <?php echo $form->input('firstName',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>   
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:29%;">Last Name</label>
                     <?php echo $form->input('lastName',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:29%;">Email</label>
                     <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:29%;">Phone</label>
                     <?php echo $form->input('phone',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:29%;">Password</label>
                    <?php echo $form->input('passwd',array('id'=>'pass','type'=>'password','label'=>false,'div'=>false));?>
            </div>
        </div>
        <div style="width:100%">   
            <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:42px;"> 
                     <label style="float:left; width:29%;">Confirm Password</label>
                    <?php echo $form->input('passwd',array('id'=>'cpass','type'=>'password','label'=>false,'div'=>false));?>
            </div>
        </div>
        <div class="loginname" style="margin:10px 0 10px 20px; width:396px; float:none; height:61px;">
            <label style="float:left; width:29%;">Payment Type</label>
            <?php 
            $redirectUrl = $this->Session->read('Auth.redirectUrl');	
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
        <div class="agreeterms" style="margin:15px 0 15px 12px; width:410px; float:none;">
            <?php echo $form->input('agree',array('type'=>'checkbox','label'=>'I would like to receive daily emails with available reservations','div'=>false));?>
        </div>
        <div style="width:100%">
             <div class="agreeterms" id="show_sign" style="float:none; margin:0px;" <?php  if(!empty($this->data['User']['card_type'])): echo 'style="display:block;"'; else: 
                echo 'style="display:none;"';endif; ?>>
             <?php echo $form->submit('/images/signup.png',array('class'=>'reg_sub')); ?>
             </div>
        </div>
    </div> <?php endif; ?>
    	 <?php //echo $form->end();?>
    
<script type="text/javascript">
	var countries=new ddtabcontent("countrytabs")
	countries.setpersist(true)
	countries.setselectedClassTarget("link") //"link" or "linkparent"
	countries.init()
</script>
    </div>
  </div>
</div> 
    <div class="payment_information">
        <ul id="countrytabs" class="shadetabs">
            <li><a href="#" rel="country1" class="selected">Payment Information</a></li>
        </ul>
        <div style="border:1px solid #bababa; width:424px;  margin-bottom: 1em; padding: 10px">
         <?php $approved = $this->Auth->user('approved');
            if($this->Auth->user('account_type')!=3&&$approved!=1 && empty($user_id)) : ?>
        <div class="paymentuser1" id="paymentuser1" style="width:424px; float:none; margin:0px;">
            <div class="agreeterms" style="width:336px; margin:0px 0px 10px 95px; float:none;">
                 <?php echo $form->input('agree',array('type'=>'checkbox','label'=>' Use stored credit card information','div'=>false));?>
            </div>
            <img src="../images/single-line.jpg" width="421" height="4" />
            <p> <i>Your credit card information will be stored securely with our credit processor for your conveniance. There are no startup fees, your card will be charged when you make a reservation.</i> </p>
            <div class="paymentdetails">
                 <label>First Name</label>
                 <?php echo $form->input('holder_fname',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
            <div class="paymentdetails">
                  <label>Last Name</label>
                  <?php echo $form->input('holder_lname',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
            <div class="paymentdetails">
                  <label>Card Number</label>
                  <?php echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
            <div class="paymentdetails" style="height:80px;">
                <label>Expiration Date</label>
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
           </div>
           <div class="paymentdetails" style="height:45px;">
                 <label>Security Code</label>
                 <?php echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'div'=>false));?>
           </div>
            <div class="agreeterms" style="font-style:italic; height:45px;line-height:17px; margin:15px 0 15px 22px; width:368px; float:none;">
                <?php echo $form->input('store',array('type'=>'checkbox','label'=>'Check if you would like to store your credit card information for future purchases.','div'=>false));?>
           </div>
           <div style="width:100%">
             <div class="agreeterms" style="float:none; margin:0px;">
				 <?php echo $form->button('Cancel',array('class'=>'cancel','onclick' => 'return check_login()','value'=>'Cancel')); ?>
                 <?php echo $form->submit('submit',array('class'=>'confirm')); ?>
              </div>
            </div> 
             <?php echo $form->end();?>
            </div> <?php endif; ?>
	
        <?php echo $form->create('User', array('action' => 'payment', 'class' => 'normal'));  ?>
        	<?php echo $form->input('hidvalue',array('type'=>'hidden','value'=>'payment_res'));?>
         	<div class="paymentuser1" id="paymentuser2" style="width:424px; float:none; margin:0px;">
        		<div class="paymentmain" style=" float:none;">
				<?php //echo $user_id;
                    $row=mysql_fetch_array(mysql_query("select users.billingKey,users.user_amount from users where users.id='".$user_id."' "));
                    $billingKey= $row['billingKey'];
                    $user_amount= $row['user_amount'];
					echo $this->Session->read('off_id');
                    if(!empty($billingKey)&&$billingKey!='NULL'||$user_amount!=0){ 
                ?>
                
                <div class="continue">
                    <?php if(!isset($size)){
                        $size=0;
                    }
                    $chic=explode('/',$this->params['url']['url']);
                    if($chic[0]=='chicago'){
                        $chicagomag='Referenced';
                    }else{
                        $chicagomag='';
                    }  //echo $offerid;
                    //echo $party_res;
                    ?>
                    <?php if(!empty($offer_id) || !empty($party_res)){  ?>
                    <div id="pay_sub" style="display:block;">
                        <div class="agreeterms"  style="width:336px; margin:0px 0px 10px 95px; float:none;"> 
                         <?php echo $form->input('agree',array('type'=>'checkbox','checked'=> 'checked','label'=>' Use stored credit card information','class'=>'agree_check',
                         'div'=>false));?>
                        </div>
                        <div class="agreeterms" id="pay_org"> 
                         <?php echo $form->button('Cancel',array('class'=>'cancel','onclick' => 'return check_login()','value'=>'Cancel','style'=>'margin-left:60px;')); ?>
                       <a style="float:left; margin:-2px 3px" onclick="loader()" href="<?php echo $html->url(array('controller'=>'users',
						'action'=>'referenceTransaction',$offer_id,$party_res,$chicagomag),true); ?>">
                        <?php echo $html->image("/images/sub_payme.png",array('alt' => "continue",'border'=>0,'height'=>28,'width'=>101)); ?> </a>
                        </div>
            		</div>
                    
                    <?php } } ?> 
                    <div id="pay_form_show" style="display:none;"> 
                    	 <?php echo $form->input('agree',array('type'=>'checkbox','label'=>' Use stored credit card information','class'=>'agree_check',
					 'div'=>false));?>
                        <img src="../images/single-line.jpg" width="421" height="4" />
                        <p> <i>Your credit card information will be stored securely with our credit processor for your conveniance. There are no startup fees, your card will be charged when you make a reservation.</i> </p>
                        <div class="newpaymentdetails">
                            <label>Fisrt Name</label>
                            <?php echo $form->input('holder_fname',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Last Name</label>
                            <?php echo $form->input('holder_lname',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails" id="ptype">
                            <label>Payment Type</label>
                            <?php 
                                $gateway_options['creditCardTypes'] = array(
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                                );
                                echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],
								'onchange' =>'paymenttype(this.value);','div'=>false));
                            ?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Card Number</label>
                            <?php echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Expiry Date</label>
                                <?php 
                                    $year=date('Y')+2;
                                    $month=date('m');
                                    if(!empty($this->data['User']['expDateMonth']['month']))
                                    $month=null;
                                    if(!empty($this->data['User']['expDateYear']['year']))
                                    $year=null;
                                ?>
                                <?php echo $form->month('User.expDateMonth', $month, array(), false); 
                                     echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array(), false);
                                ?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Security Code</label>
                            <?php echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                       <?php if(!empty($offer_id)){
                            	echo $form->hidden('offerId',array('value'=>$offer_id)); 
							} else {
								 echo $form->hidden('offerId',array('value'=>'')); 
							}
                        ?>
                        <div class="storecredit">
                            <?php echo $form->input('store',array('type'=>'checkbox','label'=>'I would like to store my credit card information for future reservation','div'=>false));?>
                        </div>
                        <div class="agreeterms" id="pay_org">
                             <?php echo $form->button('Cancel',array('class'=>'cancel','onclick' => 'return check_login()','value'=>'Cancel')); ?>
                             <?php echo $form->submit('submit',array('class'=>'confirm','onclick'=>'payment();')); ?>
                        </div>
        </div> </div>  
               		 <?php if(empty($offer_id) || empty($party_res) && ((!empty($billingKey)&&$billingKey!='NULL')||$user_amount!=0) && !empty($user_id)){  ?>
		            <div id="pay_form"> 
                    	 <?php echo $form->input('agree',array('type'=>'checkbox','label'=>' Use stored credit card information','class'=>'agree_check',
					 'div'=>false));?>
                        <img src="../images/single-line.jpg" width="421" height="4" />
                        <p> <i>Your credit card information will be stored securely with our credit processor for your conveniance. There are no startup fees, your card will be charged when you make a reservation.</i> </p>
                        <div class="newpaymentdetails">
                            <label>Fisrt Name</label>
                            <?php echo $form->input('holder_fname',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Last Name</label>
                            <?php echo $form->input('holder_lname',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails" id="ptype">
                            <label>Payment Type</label>
                            <?php 
                                $gateway_options['creditCardTypes'] = array(
                                'Visa' => __l('Visa') ,
                                'MasterCard' => __l('MasterCard') ,
                                'Discover' => __l('Discover') ,
                                'Amex' => __l('Amex')
                                );
                                echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],
								'onchange' =>'paymenttype(this.value);','div'=>false));
                            ?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Card Number</label>
                            <?php echo $form->input('creditCardNumber',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Expiry Date</label>
                                <?php 
                                    $year=date('Y')+2;
                                    $month=date('m');
                                    if(!empty($this->data['User']['expDateMonth']['month']))
                                    $month=null;
                                    if(!empty($this->data['User']['expDateYear']['year']))
                                    $year=null;
                                ?>
                                <?php echo $form->month('User.expDateMonth', $month, array(), false); 
                                     echo $form->year('User.expDateYear', date('Y'), date('Y')+10, $year, array(), false);
                                ?>
                        </div>
                        <div class="newpaymentdetails">
                            <label>Security Code</label>
                            <?php echo $form->input('cvv2Number',array('type'=>'text','label'=>false,'div'=>false));?>
                        </div>
                       <?php if(!empty($offer_id)){
                            	echo $form->hidden('offerId',array('value'=>$offer_id)); 
							} else {
								 echo $form->hidden('offerId',array('value'=>'')); 
							}
                        ?>
                        <div class="storecredit">
                            <?php echo $form->input('store',array('type'=>'checkbox','label'=>'I would like to store my credit card information for future reservation','div'=>false));?>
                        </div>
                        <div class="agreeterms" id="pay_org">
                             <?php echo $form->button('Cancel',array('class'=>'cancel','onclick' => 'return check_login()','value'=>'Cancel')); ?>
                             <?php echo $form->submit('submit',array('class'=>'confirm','onclick'=>'payment();')); ?>
                        </div>
        </div> <?php } ?>
        
         <?php if(empty($offer_id) || empty($party_res) && ((empty($billingKey)&&$billingKey=='NULL')||$user_amount==0) && empty($user_id)){ ?>
		             <?php } ?>
         <?php if(!empty($offer_id) || !empty($party_res) && ((empty($billingKey)&&$billingKey=='NULL')||$user_amount==0) && !empty($user_id)){  ?>
		             <?php } ?>
        </div> 
       
    </div>     <?php echo $form->end();?> 
   
  </div>

</div>
</div>
    
</div>
</div>
