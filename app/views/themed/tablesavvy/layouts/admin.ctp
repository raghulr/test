<?php
/* SVN FILE: $Id: admin.ctp 17695 2010-08-05 12:30:01Z siva_063at09 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(), "\n";?>
	<title>TableSavvy | <?php echo $title_for_layout; ?></title>
	<?php
		//echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";?>
        <meta name="TableSavvy" content="app-id=845047265"/>
        <?php 
		echo $html->css('tableSavvyAdmin.css', null, null, false)?>
        <meta name="apple-itunes-app" content="app-id=845047265"/>
        <?php ;
		require_once('_head.includes.ctp');
		echo $asset->scripts_for_layout();
		//echo $javascript->link('vtip.js', true);
		echo $javascript->link('jquery.datePicker', true);
		echo $javascript->link('superadmin_common_new', true);
	?>
<script type="text/javascript">
	$(document).ready(function(){
		Date.firstDayOfWeek = 0;
		Date.format = 'mm/dd/yyyy';
		var myDate = new Date();
        var year = myDate.getFullYear();
		var date = myDate.getDate();
		var month = myDate.getMonth()+1;
		var nextyear = year+3;
		var prevyear = year-1;
		<?php if($this->params['controller']=='history'&&$this->params['action']=='admin_index'){ ?>
			$('.date-pick').datePicker({startDate:month+'/01/'+prevyear,endDate:new Date});
		<?php } else { ?>
			$('.date-pick').datePicker({startDate:month+'/'+date+'/'+year,endDate:month+'/'+date+'/'+nextyear});
//                        $('.date-pick').datePicker({startDate:'04/01/2014',endDate:month+'/'+date+'/'+nextyear});
		<?php } ?>	
	});
	var auto_refresh = setInterval(
	function()
	{
	$('#ad_time').fadeIn("slow");
	}, 20000);
	var timecount=<?php echo date('s');?>;
	var currentHours = <?php echo date('H');?>;
	var currentMinutes =<?php echo date('i');?>;
	function startTime(){
		if(timecount==59){
			currentMinutes=parseInt(currentMinutes)+1;
			timecount=0;
			
		}
		if(currentMinutes==60){
			currentHours=parseInt(currentHours)+1;
			currentMinutes=0;
		}
		if(parseInt(currentHours)==24){
			currentHours=0;
		}
		//alert(currentMinutes);
		currentMinutes1 = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
		var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
		currentHours1 = ( parseInt(currentHours) > 12 ) ? parseInt(currentHours) - 12 : currentHours;
		currentHours1 = ( currentHours == 0 ) ? 12 : currentHours1;
		var currentTimeString = currentHours1 + ":" + currentMinutes1 + " " + timeOfDay;
		document.getElementById('ad_time').innerHTML=currentTimeString;
		timecount=parseInt(timecount)+1;
		//alert(currentTimeString);
		t=setTimeout('startTime()',1000);
	}
</script>
<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="/tablesavvy/theme/tablesavvy/css/ie7_admin.css" />
	<![endif]-->
</head>
<body class="admin pattern" onload="startTime()">
<?php
if ($session->check('Message.error')):
		echo $session->flash('error');
endif;
if ($session->check('Message.success')):
		echo $session->flash('success');
endif;
if ($session->check('Message.flash')):
		echo $session->flash();
endif;
?>
</div>
<div class="header">
	<div class="logo-wrapper">
		<?php echo $html->image('/theme/tablesavvy/images/TS_email_logo.png');?>
        <div class="spacer"></div>
    </div>
    
	<div class="header_cont">
   <?php if($this->params['url']['url']=='admin'||$this->params['url']['url']=='users/forget_password'){
       
   }else{
       echo $html->link($html->image('/images/log_out.png',array('class'=>'log_out')),array('controller'=>'users','action'=>'logout','admin'=>false),array('escape' => false));
	?>
     <a href="<?php echo $html->url(array('controller'=>'Users','action'=>'change_password')); ?>" class="log_out colorbox-change cboxElement" style="color:#000000; text-decoration:none; font-size:18px; font-weight:bold; margin-top:2px!important;"><?php echo "Change Password"."&nbsp;"."|"."&nbsp;"; ?></a>
    <?php
	}?>
    <div class="gap01">&nbsp;</div>
    	<?php 	
				$id = $this->Auth->user('id');						 
				$row=mysql_fetch_array(mysql_query("select restaurants.name from restaurants where restaurants.user_id='".$id."' "));
				$restaurant_name= $row['name'];
		 ?>
    	<h2 class="head-text"><?php echo $restaurant_name."&nbsp;ADMINISTRATION"; ?></h2>
    <?php if($this->params['url']['url']=='admin'||$this->params['url']['url']=='users/forget_password'){}else{
?>
	<div class="tim_div">
    <?php //echo date('h:i A');?>
    <span id="ad_time"><?php //echo date('h:i A');?></span></div>
    <?php }?>
    </div>
</div>
<div style="display: none" id="hours"><?php echo date('H');?></div>   
<div style="display: none" id="mins"><?php echo date('i');?></div> 
<div class="container">
	<div class="container_cont">
    	
         <?php echo $content_for_layout;?>	
    </div>
</div>
<?php /*?><div class="footer">
	<div class="footer_logo"><?php echo $html->image('footer_logo.png');?></div>
</div><?php */?>
</body>
</html>
