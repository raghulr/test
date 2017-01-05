<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <?php echo $html->charset(), "\n";?>  
   <title>Chicagomag | <?php echo $title_for_layout; ?></title> 
    <?php
    echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
    echo $html->meta('description', $meta_for_layout['description']), "\n";
    require_once('_head.ctp');
    echo $asset->scripts_for_layout();
    ?>
    <link rel="shortcut icon" href="<?php echo $html->url('/img/'.Configure::read('website.slug').'.ico');?>" />
    <meta property="ogite_name" content="TableSavvy | <?php echo $title_for_layout; ?>"/>
    <meta property='og:title' content='TableSavvy | <?php echo $title_for_layout; ?>'/>
    <meta property='og:description' content='<?php echo $meta_for_layout['keywords'];?>'/> 
</head>
<body>
<?php

if ($session->check('Message.error')):
	echo $session->flash('error');
endif;
if ($session->check('Message.success')):
	echo $session->flash('success');
endif;
if ($session->check('Message.error1')):
	echo $session->flash('error1');
endif;
if ($session->check('Message.flash')):
	echo $session->flash();
endif;
?>
<div id="page-container">
    <div id="header" class="no-phone">
        <div id="branding">
            <a href="<?php echo $html->url('/home',true);?>"><img id="logo" src="http://www.chicagomag.com/images/ChicagoLogo_248x40.gif" width="248" height="80" alt="Chicago Magazine" /></a>
            <div id="top-links-search">
                <div id="top-links">
                &nbsp;
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
                <td id="nav-home">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/"><img src="http://www.chicagomag.com/images/blank.gif" width="51" height="34" alt="Home" /></a>
                </td>
                <td id="nav-archive">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/archive-index"><img src="http://www.chicagomag.com/images/blank.gif" width="68" height="34" alt="Archive" /></a>
                </td>
                <td id="nav-dining">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Dining/"><img src="http://www.chicagomag.com/images/blank.gif" width="59" height="34" alt="Dining" /></a>
                </td>
                <td id="nav-going-out">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Going-Out/"><img src="http://www.chicagomag.com/images/blank.gif" width="83" height="34" alt="Going Out" /></a>
                </td>
                <td id="nav-shopping">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Shopping/"><img src="http://www.chicagomag.com/images/blank.gif" width="77" height="34" alt="Shopping" /></a>
                </td>
                <td id="nav-fashion">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Fashion/"><img src="http://www.chicagomag.com/images/blank.gif" width="68" height="34" alt="Fashion" /></a>
                </td>
                <td id="nav-deal-estate">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Deal-Estate/"><img src="http://www.chicagomag.com/images/blank.gif" width="93" height="34" alt="Deal Estate" /></a>
                </td>
                <td id="nav-news-features">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/News-Features/"><img src="http://www.chicagomag.com/images/blank.gif" width="126" height="34" alt="News &amp; Features" /></a>
                </td>
                <td id="nav-best-of">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Best-of-Chicago/" ><img src="http://www.chicagomag.com/images/blank.gif" width="120" height="34" alt="Best of Chicago" /></a>
                </td>
                <td id="nav-marketplace">
                    <a href="http://www.chicagomag.com/Chicago-Magazine/Classifieds/"><img src="http://www.chicagomag.com/images/blank.gif" width="103" height="34" alt="Classifieds" /></a>
                </td>
                <td id="nav-home-garden">
                    <a href="http://www.chicagohomemag.com"><img src="http://www.chicagomag.com/images/blank.gif" width="121" height="34" alt="Home + Garden &raquo;" /></a>
                </td>
            </tr>
            </table>	
        </div>
    </div>
         
	<?php echo $content_for_layout;?>
        <?php echo $this->element('footer_navigation'); ?>
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
</div>	
</body>
</html>
