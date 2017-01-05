<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $html->charset(), "\n";?>
	<title>Configure::read('website.name') | <?php echo $title_for_layout; ?></title>
	<?php
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
	require_once('_head.ctp');
	echo $asset->scripts_for_layout(); 
?>
<script type="text/javascript">
	$(document).ready(function(){
		var end_date=parseInt($('.js-time').html());
		$("#numbers1").countdown({until:end_date,format:'HM',onTick:timecufon,tickInterval:60});
		//parent.Cufon.replace('#numbers1',{ fontFamily: 'bebas' });
		Cufon.now();
	});
</script>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-297666-1']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();
</script>
<style>
#columns-1-2 {
	width:950px !important;
}
.headercontainer, .content, .footer{
	background-image:none !important;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chicago magazine - Dining, Shopping, Fashion, Entertainment, Real Estate, News and Events</title>
<meta name="robots" content="all" />
<meta name="Description" content="Chicago magazine brings readers the very best of what Chicago has to offer - its people, politics, restaurants, events, culture, news, entertainment, art, real estate, community and travel information for residents and visitors to Chicago. " />
<meta name="Keywords" content="chicago magazine, chicago magazine online, chicago guide, chicago recreation, chicago restaurants, chicago events, chicago entertainment, chicago attractions, chicago outdoor, chicago dining, chicago bars, chicago nightlife, chicago shopping, chicago fashion, chicago arts, chicago culture" />

<link rel="shortcut icon" href="http://www.chicagomag.com/favicon.ico" />


</head>
<body>
<div id="page-container">

<div id="header">
		<div id="branding">
			<a href="http://www.chicagomag.com"><img id="logo" src="http://www.chicagomag.com/images/ChicagoLogo_248x40.gif" alt="Chicago Magazine" /></a>			
			
			<div id="top-links-search">
				<div id="top-links">
					<a target="_parent" href="http://www.chicagomag.com/Chicago-Magazine/My-Account">Log In</a>&nbsp;|&nbsp;<a target="_parent" href="https://www.neodata.com/ITPS2.cgi?ItemCode=CAGO&OrderType=Reply+Only&iResponse=CAGO.INDEX">Customer Service</a>
				</div>
				<div id="sitesearch">
					<form method="get" name="searchformx" id="searchformx" action="http://www.chicagomag.com/Search/index.php">
					<input type="hidden" name="search" value="" /><input type="hidden" name="mod" value="CoreSearch" />
					<input name="query" type="text" class="searchform" value="" />
						<select class="search-select" name="urlprefix">
							<option value="/">All</option>
							<option value="/Chicago-Magazine/">Chicago Mag</option>
							<option value="/Chicago-Home/">Chicago Home</option>
							<option value="/Radar/" >Radar</option>
						</select>	
					<button type="submit" value="Search" name="Search"  target="_parent"></button>						
					</form>
				</div>
			</div>
		</div>
	<div id="navigation-container" style="margin-bottom: 10px;">
		<table id="nav" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td id="nav-home"><a href="http://www.chicagomag.com/Chicago-Magazine/"><img src="http://www.chicagomag.com/images/blank.gif" width="51" height="34" alt="Home" /></a></td>
				<td id="nav-archive"><a href="http://www.chicagomag.com/Chicago-Magazine/archive-index"><img src="http://www.chicagomag.com/images/blank.gif" width="68" height="34" alt="Archive" /></a></td>
				<td id="nav-dining"><a href="http://www.chicagomag.com/Chicago-Magazine/Dining/"><img src="http://www.chicagomag.com/images/blank.gif" width="59" height="34" alt="Dining" /></a></td>
				<td id="nav-going-out"><a href="http://www.chicagomag.com/Chicago-Magazine/Going-Out/"><img src="http://www.chicagomag.com/images/blank.gif" width="83" height="34" alt="Going Out" /></a></td>
				<td id="nav-shopping"><a href="http://www.chicagomag.com/Chicago-Magazine/Shopping/"><img src="http://www.chicagomag.com/images/blank.gif" width="77" height="34" alt="Shopping" /></a></td>
				<td id="nav-fashion"><a href="http://www.chicagomag.com/Chicago-Magazine/Fashion/"><img src="http://www.chicagomag.com/images/blank.gif" width="68" height="34" alt="Fashion" /></a></td>
				<td id="nav-deal-estate"><a href="http://www.chicagomag.com/Chicago-Magazine/Deal-Estate/"><img src="http://www.chicagomag.com/images/blank.gif" width="93" height="34" alt="Deal Estate" /></a></td>
				<td id="nav-news-features"><a href="http://www.chicagomag.com/Chicago-Magazine/News-Features/"><img src="http://www.chicagomag.com/images/blank.gif" width="126" height="34" alt="News &amp; Features" /></a></td>
				<td id="nav-best-of"><a href="http://www.chicagomag.com/Chicago-Magazine/Best-of-Chicago/" ><img src="http://www.chicagomag.com/images/blank.gif" width="120" height="34" alt="Best of Chicago" /></a></td>
				<td id="nav-marketplace"><a "href="http://www.chicagomag.com/Chicago-Magazine/Classifieds/"><img src="http://www.chicagomag.com/images/blank.gif" width="103" height="34" alt="Classifieds" /></a></td>
				<td id="nav-home-garden"><a href="http://www.chicagohomemag.com"><img src="http://www.chicagomag.com/images/blank.gif" width="121" height="34" alt="Home + Garden &raquo;" /></a></td>
			</tr>
		</table>
						
	</div>
</div>
	<div>
		<div id="page-body-right">
		<div id="columns-1-2">
		<div class="header">
		<?php 
		if ($session->check('Message.error')):
			echo $session->flash('error');
		endif;
		if ($session->check('Message.success')):
			echo $session->flash('success');
		endif;
		if ($session->check('Message.flash')):
			echo $session->flash();
		endif;?>
        <div class="headercontainer">
            <div class="homeheader">
                <div class="homeheader1">
                    <div class="fb_twit">
                    	<div class="fb_sign" id='fb_sign' style="font-size:14px;">
                        	<?php $user_id = $this->Auth->user('id');
							 	  //$approved = $this->Auth->user('approved'); 
							 if(!empty($user_id)){
								$row=mysql_fetch_array(mysql_query("select users.Firstname,users.user_amount from users where users.id='".$user_id."' "));
								$user_fname= $row['Firstname'];
								$user_amount= $row['user_amount'];
								//$user_lname= $row['lastName'];
							?>
                            	Welcome, <?php echo $user_fname.'!'?> | My Account $<?php echo $user_amount;?>
                            <?php
							}else{
							?>
                            <a href="<?php echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>"  class="color_sign" style="color:#FFFFFF;padding-left:20px; font-size:14px;">Not a member? Sign up!</a>
                            <?php } ?>
                        </div>
                        <div class="fb_link">
                        	<a href="<?php echo Configure::read('website.facebook');?>" target="_blank"> <?php echo $html->image('/images/new_fb_link_02.png',array('width'=>128,'height'=>39,'border'=>0));?></a>
                        </div>
                        <div class="twit_link">
                        	<a href="<?php echo Configure::read('website.twitter');?>" target="_blank"> <?php echo $html->image('/images/new_twit_link_02.png',array('width'=>140,'height'=>39,'border'=>0));?></a>
                        </div>
                    </div>
                    
                </div> 
                <div class="homeheader1">
                    <div class="logo">
                    	<a href="<?php echo $html->url(array('controller'=>'widgets','action'=>'time'),true); ?>"><?php echo $html->image('/images/logo.png',array('width'=>238,'height'=>58,'border'=>0));?></a>
                    </div>
                    <div class="menu_list"> <?php $user_id = $this->Auth->user('id'); 
						//$approved = $this->Auth->user('approved'); 
					?>
                    	<ul>
                        	<?php 
								 $classactivehelp='';
								 $classactiveprofile='';
								 if($this->params['controller']=='homes'&&$this->params['action']=='help')
								 	$classactivehelp ='id="curent1"';
								 if($this->params['controller']=='profiles'&&$this->params['action']=='index')
								 	$classactiveprofile ='id="curent2"';
							?>
                        	<?php if($user_id==''){ ?>
                            	<li class="first" id="check_log"><a href="<?php if($this->params['controller']=='homes'&&$this->params['action']=='index'):echo $html->url(array('controller'=>'users','action'=>'login',1,'home'),true);else:echo $html->url(array('controller'=>'users','action'=>'login',1),true); endif; ?>"  class="color_login">LOGIN</a></li>
                                <li id="check_login"><a href="<?php echo $html->url(array('controller'=>'users','action'=>'login'),true); ?>"  class="color_login">MY SAVVY DEALS</a></li>
                               <!-- <li><a href="#">HOW IT WORKS</a></li>   -->
                               <li><?php //echo $html->link(__l('HOW IT WORKS'), Router::url('/').'../images/how-it-works.jpg', array('title' => __l('How It Works'),'class'=>'colorbox'));?><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'howitworks'),true); ?>" class="color_how">HOW IT WORKS</a></li> 
                                  <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'faq',1),true); ?>" class="color_privacy">FAQ</a></li>
                                <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'contacts','action'=>'add'),true); ?>" class="color_contact">CONTACT US</a></li>
                            <?php } else {
								if(!empty($fb_logout_url)){
							?>
                            	<li class="first" id="check_log"><a href="<?php echo $fb_logout_url; ?>">LOGOUT</a></li>
                            <?php 
							}else{?>
                                <li class="first" id="check_log"><a href="<?php echo $html->url(array('controller'=>'users','action'=>'logout','chicago_mag'),true); ?>">LOGOUT</a></li>
                            <?php } ?>
                                <li <?php echo $classactiveprofile;?>><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>">MY SAVVY DEALS</a></li>
                                 <li><?php //echo $html->link(__l('HOW IT WORKS'), Router::url('/').'../images/how-it-works.jpg', array('title' => __l('How It Works'),'class'=>'colorbox'));?><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'howitworks'),true); ?>"  class="color_how">HOW IT WORKS</a></li> 
                                  <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'faq',1),true); ?>" class="color_privacy">FAQ</a></li>
                                  <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'contacts','action'=>'add'),true); ?>" class="color_contact">CONTACT US</a></li>
                            <?php } ?> 
                       </ul>     
                    </div>
                </div>
                 <div class="homeheader1">
                 	<div class="dealimage">
                    	<div class="dealimage1">
                            <div class="left_image">
                            	<div class="dealtext">
                            	<span class="text1">What’s the Deal?</span> <br/>
                                <span class="text2">Reserve a Table for $5 and Save 30%!!!</span>  
                                </div>                     
                            </div>
                            <div class="extras">
                            <span class="expires">Deals Expire In</span>
                            <div class="count">
                            	<span class="hrs"><?php echo $html->image('/images/hrs.png',array('width'=>38,'height'=>11,'border'=>0));?></span>
                               <div class="js-time hide" style="display:none;"><?php  $dealtime='22:00:00';  echo $end_time = intval(strtotime(date('Y-m-d').' '.$dealtime) - time()); ?></div>
                                 <span class="number"></span>
                                 <div id="numbers1"></div>
                            </div>
                            <div class="count">
                            	<span class="hrs"><?php echo $html->image('/images/mins.png',array('width'=>28,'height'=>11,'border'=>0));?></span>
                                <span class="number"></span>
                            </div>
                            </div>
                        </div>
                        <div class="corner">
                        </div>
                    	<span class="tonight"><?php echo $html->image('/images/tonight1.png',array('width'=>69,'height'=>68,'border'=>0));?></span>
                    </div>
                 </div>
            </div>
        </div>
    </div>
		 <?php echo $content_for_layout;?>	
		<div class="footercontainer">
    	<div class="footer">
        	<div class="footerborder">
            	<div class="footerinnerborder">
                <div class="bottommenu">
                	<div class="bottommenu">
                    	<ul>
                 <!--       <li><a href="<?php //echo $html->url(array('controller'=>'homes','action'=>'help')); ?>">Help</a> <span>&nbsp;|&nbsp;</span></li>-->
                        <li><a href="<?php echo $html->url(array('controller'=>'contacts','action'=>'add'),true); ?>" class="color_contact">Contact us</a><span>&nbsp;|&nbsp;</span></li>
                        <li><a href="javascript:;">About us</a><span>&nbsp;|&nbsp;</span></li>
                        <li><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'privacypolicy'),true); ?>" class="color_privacy">Privacy Policy</a><span>&nbsp;|&nbsp;</span></li>
                        <li><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'returnpolicy'),true); ?>" class="color_privacy">Return Policy</a><span>&nbsp;|&nbsp;</span></li>
                        <li><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'terms'),true); ?>" class="color_privacy">Terms & Conditions</a><span>&nbsp;|&nbsp;</span></li>
                        <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'contacts','action'=>'add',1),true); ?>" class="color_contact1">Restaurant Inquiries</a><span>&nbsp;|&nbsp;</span></li>
                        <li class="last_list"><a href="<?php echo $html->url(array('controller'=>'homes','action'=>'faq',1),true); ?>" class="color_privacy">FAQ</a></li>
                        </ul>
                        </div>
                        <div class="bottommenu">
                        <div class="copyright">
                        Copyright &copy; 2012. <?php echo Configure::read('website.name');?> all rights reserved
                        </div>
                    </div>
                    </div>
                    <div class="social">
                    <a href="<?php echo Configure::read('website.facebook');?>" target="_blank"><?php echo $html->image('/images/faceb.png',array('width'=>29,'height'=>33,'border'=>0));?></a>
                   <a href="<?php echo Configure::read('website.twitter');?>" target="_blank"><?php echo $html->image('/images/twitter.jpg',array('width'=>29,'height'=>33,'border'=>0));?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
		</div>
</div>
	</div>
	<div id="footer">
	<div id="bottom-menu">
		<a href="http://www.chicagomag.com/Chicago-Magazine/">Home</a> |
		<a href="http://www.chicagomag.com/Chicago-Magazine/archive-index">Archive</a> |
		<a href="http://www.chicagomag.com/Chicago-Magazine/Dining">Dining</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/Going-Out">Going Out</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/Fashion">Fashion</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/Shopping/">Shopping</a> |
		<a href="http://www.chicagomag.com/Chicago-Magazine/Deal-Estate">Deal Estate</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/News-Features">News &amp; Features</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/Best-of-Chicago">Best of Chicago</a> | 
		<a href="http://www.chicagomag.com/Chicago-Magazine/Classifieds">Classifieds</a> |  
		<a href="http://www.chicagohomemag.com/">Chicago Home</a> | 
		<a href="http://www.bringithomechicago.com/">Bring It Home</a><br>
		<br>
		<a href="http://www.chicagomag.com/Chicago-Magazine/My-Account">Log In</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="http://www.chicagomag.com/Chicago-Magazine/My-Account">Manage Online Preferences</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="https://www.neodata.com/ITPS2.cgi?ItemCode=CAGO&iResponse=CAGO.NEW&OrderType=Reply+Only&SourceCode=7&KeyCode=AAC">Subscribe</a>
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/Chicago-Magazine/Sitemap">Sitemap</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/Chicago-Magazine/Advertise">Advertise</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/Chicago-Magazine/About-Us">About Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/Chicago-Magazine/Contact-Us">Contact Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.chicagomag.com/Chicago-Magazine/The-Wire/">Press</a>
		<br>
		<br>
		Connect: 
		<a href="https://www.facebook.com/ChicagoMagazine">Facebook</a> |
		<a href="https://twitter.com/#!/chicagomag">Twitter</a> | 
		<a href="https://plus.google.com/u/0/b/102988035409615397453/102988035409615397453/posts">Google+</a> | 
		<a href="http://www.youtube.com/user/chicagomag">YouTube</a> | 
		<a href="https://foursquare.com/chicagomag">Foursquare</a> |
		<a href="http://www.foodspotting.com/chicagomag">Foodspotting</a>
		<br>
		<br>
		Local Tribune sites: 
		<a href="http://www.chicagotribune.com">Chicago Tribune</a> |
		<a href="http://www.metromix.com">Metromix</a> | 
		<a href="http://www.redeyechicago.com">RedEye</a> | 
		<a href="http://www.hoyinternet.com/noticias/localidades/chicago/">Hoy Chicago</a> | 
		<a href="http://www.triblocal.com/">TribLocal</a> |	
		<a href="http://www.cltv.com">CLTV</a> | 
		<a href="http://www.wgnradio.com">WGN Radio</a> | 
		<a href="http://wgntv.trb.com">WGN TV</a> |
    <a href="http://www.tribuneeventsgroup.com">Tribune Events Group</a>

	</div>
	<p>Copyright 2012 Chicago Magazine - A Chicago Tribune website</p>
</div>

<!-- Tracking -->
</body>
</html>

