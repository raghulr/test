<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <?php echo $html->charset(), "\n";?>  
   <title><?php echo $title_for_layout;?> | <?php echo Configure::read('website.name'); ?></title> 
    <?php
    echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
    echo $html->meta('description', $meta_for_layout['description']), "\n";
    echo $html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=9'));
//	require_once('popup_head.ctp');
//    echo $asset->scripts_for_layout();
    echo $html->css('tableSavvyStructure',null,null,true);
    echo $html->css('tableSavvyWidget_new',null,null,true);
    echo $html->css('common',null,null,true);
    echo $html->css('jquery.smartbanner',null,null,true);
    ?>
    <meta name="apple-itunes-app" content="app-id=845047265"/>
    <meta name="google-play-app" content="app-id=com.food.tablesavvy" />
    <meta name="google-site-verification" content="ziNLvXNQbZyu4eit7s-j1O9GqeRRHordy-clri0pmfk" />
    <meta property="og:site_name" content="<?php echo $title_for_layout;?> | <?php echo Configure::read('website.name'); ?>"/>
    <meta property='og:title' content='<?php echo $title_for_layout;?> | <?php echo Configure::read('website.name'); ?>'/>
    <meta property="og:image" content="<?php echo $image = 'http://www.tablesavvy.com/images/tablesavyyfb.jpg';  ?>"/>
    <meta property='og:description' content='<?php echo $meta_for_layout['keywords'];?>'/>    
    
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/common.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/popup.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery_auto.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery.selectric.min.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery.jcarousel.js"></script>
    <?php if(isset($resetxt)&&($resetxt!='no')){?> 
        <link rel="stylesheet" href="/theme/tablesavvy/css/smothness.css"/>
        <script src="/theme/tablesavvy/js/jquery.ui.js"></script>
        <script>
            $(function() {
              $( "#dialog" ).dialog({maxWidth: 600,minWidth:400,title: "Confirmation Message"});
            });
        </script>
    <?php }?>
    <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/css/ie7.css" />
    <![endif]-->
    <!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/css/ie8.css" />
        <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/css/allie.css" />
    <![endif]-->
    <!--[if IE 9]><style type=type="text/css">.label-signup{width:131px;}</style><![endif]-->
    <!--[if IE]>
        <style type=type="text/css">
        ul.nav-menu li{float:right;border-right:1px solid #FFF;/*background-color:#000;*/padding:0 28px;}
        </style>
    <![endif]-->
    <!--- Facebook Conversion Code for BookingPixel - REGISTRATION --->   
    <?php 
        if(isset($new_user)){
            if($new_user){?>     
            <script>
                (function() { 
                    var _fbq = window._fbq || (window._fbq = []); 
                    if (!_fbq.loaded) { 
                        var fbds = document.createElement('script'); 
                        fbds.async = true; 
                        fbds.src = '//connect.facebook.net/en_US/fbds.js'; 
                        var s = document.getElementsByTagName('script')[0]; 
                        s.parentNode.insertBefore(fbds, s); 
                        _fbq.loaded = true; 
                    }
                })();
                window._fbq = window._fbq || [];
                window._fbq.push(['track', '6021035220780', {'value':'0.01','currency':'USD'}]);
            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6021035220780&cd[value]=0.01&cd[currency]=USD&noscript=1" /></noscript>
    <?php }}?>
</head>
<body class="home-pattern">
    <?php if(isset($resetxt)&&($resetxt!='no')){?> 
    <div id="dialog" title="Basic dialog">
      <p><?php echo $resetxt;?></p>
    </div>
    <?php }?>
    <div class="home-bg">
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
        <div class="home-container" id="page-container">
            <?php echo $this->element('header');?>
            <div class="inner-rounded-wrapper">
            <?php echo $content_for_layout;?>   
            </div>    
            <?php echo $this->element('footer');?> 
            <div class="spacer"></div>
        </div>
        <div class="spacer"></div>
    </div>    
        
    <script src="/theme/tablesavvy/js/jquery.smartbanner.js"></script>
    <script type="text/javascript">
      $(function() { 
          $.smartbanner({
            title: 'TableSavvy', // What the title of the app should be in the banner (defaults to <title>)
            author: 'TableSavvy LLC', // What the author of the app should be in the banner (defaults to <meta name='author'> or hostname)
            price: 'FREE', // Price of the app
            appStoreLanguage: 'us', // Language code for App Store
            inGooglePlay: 'In Google Play', // Text of price for Android
            icon: 'http://www.tablesavvy.com/theme/tablesavvy/images/TS_droid_logo.png', // The URL of the icon (defaults to <link>)
            iconGloss: null, // Force gloss effect for iOS even for precomposed (true or false)
            button: 'View', // Text on the install button
            scale: 1, // Scale based on viewport size (set to 1 to disable)
            speedIn: 300, // Show animation speed of the banner
            speedOut: 400, // Close animation speed of the banner
            daysHidden: 1, // Duration to hide the banner after being closed (0 = always show banner)
            daysReminder: 1, // Duration to hide the banner after 'VIEW' is clicked (0 = always show banner)
            force: null, // Choose 'ios' or 'android'. Don't do a browser check, just always show this banner
            hideOnInstall: true // Hide the banner after 'VIEW' is clicked.
        }); 
    })
    </script>
</body>
</html>
