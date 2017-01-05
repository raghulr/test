<style>
.all{width:593px;}
.loginname{margin:10px 0 10px 50px;}
.loginname select{ border:none;}
.paymentmain{ width:593px; margin:0 0 0 0px; padding:0 0 10px 0;}
#ptype select{ width:300px;}
.agreeterms {
    margin: 10px 0 15px 0px !important;
}
.agreeterms .submit{
	padding-left:0px;
}
.storecredit {
    float: left;
    margin: 10px 0 15px 10px;
    width: 100%;
}
.storecredit label {
    color: #535353;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 14px;
}
.newpaymentpolicy {
    color: #515151;
    float: left;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 16px;
    padding: 30px 0 23px 176px;
    text-align: left;
}
.continue {
    color: #515151;
    float: left;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 14px;
    padding: 5px 0 18px 204px;
    text-align: left;
}
.or {
    color: #515151;
    float: left;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 14px;
    padding: 2px 0 18px 138px;
    text-align: left;
}
.newpaymentdetails{
	width:100%;
	float:left;
	margin:10px 0 10px 76px;
	height:48px;
}
.newpaymentdetails label{
 width:112px;
 float:left;
 text-align:left;
 color:#535353;
 font-family:Helvetica,Arial,sans-serif;
 line-height:40px;
 font-size:14px;
}
.newpaymentdetails input{
	width:300px;
	float:left;
	border:#cfcfcf 1px solid;
	height:42px;
	margin-left:24px;
}
.newpaymentdetails select,.newpaymentdetails #UserExpDateYearYear{
	width:150px;
	float:left;
	border:#5794bf 1px solid;
	padding:15px 15px 15px 15px;
	margin-left:24px;
}
.newpaymentdetails #UserExpDateYearYear{
	width:90px;
}
.error-message{
	text-indent:136px !important;
}
</style>
<script type="text/javascript">
function loader(){
	//parent.$.colorbox.close();
	document.getElementById("loader").style.display='block';
	document.getElementById("all").style.display='none';
}
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
<div style="display:none; margin:200px 0 0 300px;" id="loader">
    <?php echo $html->image('/images/loader.gif',array("width"=>48,"height"=>48)); ?>
</div>
<div class="all" id="all">
<?php  echo $form->create('User', array('action' => 'payment', 'class' => 'normal'));  ?>
<div class="paymenthead">
<div class="pay_text"></div>
</div>
<div class="paymentmain">
<?php 
	$row=mysql_fetch_array(mysql_query("select users.billingKey,users.user_amount from users where users.id='".$user_id."' "));
	$billingKey= $row['billingKey'];
	$user_amount= $row['user_amount'];
	//echo $billingKey = $this->Auth->user('billingKey');
	if(!empty($billingKey)&&$billingKey!='NULL'||$user_amount!=0){
?>
        <div class="newpaymentpolicy">
      	  	Use stored credit card information
        </div>
        <div class="continue">
        	<?php if(!isset($size)){
				$size=0;
			}
			$chic=explode('/',$this->params['url']['url']);
			if($chic[0]=='chicago'){
				$chicagomag='Referenced';
			}else{
				$chicagomag='';
			} 
			?>
        	<a  href="<?php echo $html->url(array('controller'=>'users','action'=>'referenceTransaction',$offerid,$size,$chicagomag),true); ?>"><?php echo $html->image("/images/continue.png",array('alt' => "continue",'border'=>0,'height'=>42,'width'=>184)); ?></a>
        </div>
        <div class="or">
        	<a href="#" style="float:left; margin:10px 0 0 0px;"><?php echo $html->image('/images/credit_or.png',array('width'=>320,'height'=>15,'border'=>0)); ?></a>
        </div>
    <?php } ?>
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
	echo $form->input('card_type',array('type'=>'select','label'=>false,'options' => $gateway_options['creditCardTypes'],'onchange' =>'paymenttype(this.value);','div'=>false));
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


</div>
<?php 
	echo $form->hidden('offerId',array('value'=>$offerid)); 
?>
<div class="storecredit">
	<?php echo $form->input('store',array('type'=>'checkbox','label'=>'I would like to store my credit card information for future reservation','div'=>false));?>
</div>
<div class="agreeterms">
<?php echo $form->submit('CONFIRM',array('class'=>'reserve_confirm','onclick'=>'payment();')); ?>
<a href="#" onclick="return check_login()" style="float:left; margin:6px;"><?php echo $html->image('/images/cancel.png',array('border'=>0)); ?></a>
<?php //echo $form->button('Reset', array('type'=>'reset')); ?>
</div>

<?php echo $form->end();?>
</div>