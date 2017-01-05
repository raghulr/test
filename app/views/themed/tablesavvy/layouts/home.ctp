<?php

  $user = $session->read( 'Auth.User' );

?><!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">-->
<!--<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xml:lang="en" lang="en">-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="http://rdf.data-vocabulary.org/#" xml:lang="en">
<head>
   <?php echo $html->charset(), "\n";?>
   <title><?php echo $title_for_layout;?> | <?php echo Configure::read('website.name'); ?></title>
    <?php
    echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
    echo $html->meta('description', $meta_for_layout['description']), "\n";
    ?>
    <meta name="apple-itunes-app" content="app-id=845047265"/>
    <meta name="google-play-app" content="app-id=com.food.tablesavvy" />
    <meta name="google-site-verification" content="ziNLvXNQbZyu4eit7s-j1O9GqeRRHordy-clri0pmfk" />
    <meta property='og:site_name' content='<?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?>'/>
    <meta property='og:title' content='<?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?>'/>
    <meta property='og:description' content='<?php if(isset($og_desc)) echo $og_desc; else echo $meta_for_layout['keywords'];?>'/>
    <meta name="imageTag"  content="<?php echo Router::url('/', true).'images/tablesavyyfb.png';?>"/>
    <meta property='og:image' content='<?php echo Router::url('/', true).'images/tablesavyyfb.png';?>'/>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
   <?php
//    require_once('_head.ctp');
//    echo $asset->scripts_for_layout();
/*
    echo $html->css('chi-publication',null,null,true);
    if($this->params['controller']!='subscription')
        echo $html->css('chi',null,null,true);
    echo $html->css('chi-nav',null,null,true);
    echo $html->css('headersprites',null,null,true);
    echo $html->css('colorbox',null,null,true);
    echo $html->css('tableSavvyWidget',null,null,true);
    echo $html->css('chicagoRevisions',null,null,true);
    echo $html->css('jquery-ui',null,null,true);
    echo $html->css('common',null,null,true);
    echo $html->css('fonts',null,null,true);
    echo $html->css('jquery.smartbanner',null,null,true);
    if(isset($load_profile)){
        echo $html->css('jquery.alerts',null,null,true);
        echo $html->css('skin_new',null,null,true);
    }else{
        echo $html->css('skin',null,null,true);
    }
    */
    ?>
    <!-- <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/css/home_skin.css" />
    <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/css/jquery.smartbanner.css" /> -->
    
    <script type="text/javascript" src="/js/retina.min.js"></script>
    
    
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/common.js"></script>
    
    <!-- <script type="text/javascript" src="/theme/tablesavvy/js/popup.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery_auto.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery.selectric.min.js"></script>
    <script type="text/javascript" src="/theme/tablesavvy/js/jquery.jcarousel.js"></script> -->

    <link href='//fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="/theme/tablesavvy/semantic/semantic.min.css">
	<link rel="stylesheet" href="/theme/tablesavvy/css/site.css">
	<link rel="stylesheet" href="/theme/tablesavvy/css/subscribe_popup.css">
    <script type="text/javascript" src="/theme/tablesavvy/semantic/semantic.min.js"></script>
    
    <script> 
    // Browser Update Banner
    var $buoop = {c:2}; 
    function $buo_f(){ 
     var e = document.createElement("script"); 
     e.src = "//browser-update.org/update.min.js"; 
     document.body.appendChild(e);
    };
    try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
    catch(e){window.attachEvent("onload", $buo_f)}
    </script> 
    	
    
    <script>
      jQuery(function ($) {
        // $('.home .restaurant_list .over').dimmer({
        //   on: 'hover'
        // });
           if(typeof(Storage) !== "undefined") {
                    if (localStorage.clickcount) {
                        localStorage.clickcount = Number(localStorage.clickcount)+1;
                    } else {
                        localStorage.clickcount = 1;
                        localStorage.flag = 0;
                        localStorage.pflag = 0;
                        localStorage.success = 0;
                        localStorage.popCnt = 0;
                    }
                }
        
        // Show email capture
        <?php if (!$user) { ?>
              
                var isDesktop = 0;
                var amNag = 0;
                
                $('#UserEmail').on('blur',function(){
                   localStorage.flag = 1;
                });
                
                $('#UserSubscribeEmail').on('blur',function(){
                   localStorage.flag = 1;
                });

                setTimeout(function () {
                  if($('.mobile').is(":visible")){
                       $cookie_nag = $('.cookie.nag.email-list');
                       $cookie_nag.nag('show');
                  }else{
                       isDesktop = 1;
                       
                       if(localStorage.success){
                           $('.cookie.nag.subscriptionList').nag('dismiss');
                           $cookie_nag = 0;
                       }
                       // console.log('localStorage.pflag: ',localStorage.pflag);
                       if(localStorage.clickcount > 2){
                           if(localStorage.clickcount < 4){
                               if(localStorage.pflag == 0){
                                   $cookie_nag = $('.cookie.nag.subscriptionList');
                                   $cookie_nag.nag('show');
                               }else{
                                   $('#subscribe').attr('style',"display:none");
                               }
                           }else{
                               $('#subscribe').attr('style',"display:none");
                           }
                       }else{
                           $('#subscribe').attr('style',"display:block");
                       }
                       
                       var pop_id = document.getElementById('subscribe');
                       var style = window.getComputedStyle(pop_id,null).getPropertyValue('display');
                       if(style == "block"){
                          amNag = 1;
                          localStorage.popCnt = Number(localStorage.popCnt)+1;
                          $('.spopup, .subscribeClose').delay(1000).fadeIn(800);
                          $('.subscriptionList').parent().addClass('wrapperContainer');
                       }
                       else if((localStorage.clickcount > 1) && (localStorage.flag == 0) && (amNag == 0)){
                           $('.email-list').attr('style',"display:block");
                           $cookie_nag = $('.cookie.nag.email-list');
                           $cookie_nag.nag('show');
                       }
                  }
                  
                  
                  $('.cookie.nag.subscriptionList form').form({
                    fields: {
                      empty: {
                        identifier  : 'SubscribeEmail',
                        rules: [
                          {
                            type   : 'email',
                            prompt : 'Please enter a valid email'
                          }
                        ]
                      }
                    },
                    onSuccess: function (event, fields) {
                        setTimeout(function(){
                            if(isDesktop){
                               $('.desktop').removeClass('wrapperContainer');
                            }
                       },800);
                    }
                  });
                  
                  $('.cookie.nag.email-list form, .main.home .mobile form').form({
                    fields: {
                      empty: {
                        identifier  : 'Email',
                        rules: [
                          {
                            type   : 'email',
                            prompt : 'Please enter a valid email'
                          }
                        ]
                      }
                    },
                    onSuccess: function (event, fields) {
                        $cookie_nag.nag('dismiss');
                        localStorage.flag = 1;
                    }
                  });
                  
                }, 1800);
                
                $('.subscribeClose').on('click',function(){
                   $('#subscribe').removeAttr('style');
                   $('.desktop').removeClass('wrapperContainer');
                });
                
                $('.emailClose').on('click',function(){
                   $('.email-list').hide();
                });
                
            
            <?php } ?> 
            $('.hamburger').on('click', function() {
              var $this = $(this);
              $this.toggleClass('open');
              $this.next('nav').toggleClass('open');
              var openclose = $this.hasClass('open') ? 'Close' : 'Open';
              $this.attr("title", openclose + ' Menu');
            });
            // open
            var $how_it_works_div = $('.how_it_works');
            $('a.how-it-works').on('click', function () {
              $('.how_it_works').modal('show');
            });
            // close
            $('.close', $how_it_works_div).on('click', function() {
              $how_it_works_div.modal('hide');
            });
    
            <?php if (!$user) { ?>
            $('.signup_trigger').on('click', function () {
              $('.signup.modal').modal('show');
              return false;
            });
            $('.signin_trigger').on('click', function () {
              $('.signin.modal').modal('show');
              return false;
            });
            $('.signin.modal .close, .signup.modal .close').on('click', function() {
              $('.signin.modal, .signup.modal').modal('hide');
            });
        <?php } ?>
        
        // Make Dropdowns a bit better
/*         $('.ui.dropdown').dropdown(); */
      });
      </script>

  </head>
<body class="home-pattern">

  <?php if (!$user) { ?>
      
  <!-- Subscription Nag -->
      <div class="desktop">
          <div id="subscribe" class="ui cookie nag subscriptionList">
                <div class="spopup">
                    <div class="content">
                        <!-- <div class="center"> -->
                          <h3>BECOME A TABLESAVVY MEMBER</h3>
                          <p class="claim">Sign up and receive a <b>$5.00</b> credit towards your first booking</p>
                          <p class="meals"><img src="/theme/tablesavvy/images/vector_right.png" width="18" /> PLUS 30% OFF YOUR BILL </p>
                          <!-- <div class="subscriptionList"> -->
                            <?php echo $form->create('User', array('action' => 'subscribe_new', 'type' => 'get', 'class' => 'ui form')); ?>
                                      <div class="field">
                                        <?php echo $this->Form->input('SubscribeEmail', array('placeholder' => 'Your Email', 'autocomplete'=>'off','label'=>FALSE, 'div'=>FALSE)); ?>
                                      </div>
                                      <div class="field">
                                        <?php echo $this->Form->submit('Sign up', array('class' => 'ui button primary signup')); ?>
                                      </div>
                                      <div class="ui error message"></div>
                                    <?php echo $form->end();?>  
                          <!-- </div> -->
                          <div class="note"> * First Time Customers Only</div>
                        <!-- </div> -->
                  </div>
                </div>
                <i class="close icon subscribeClose"></i>  
            </div>
      
    <!-- Subscription ends -->
        
  <!-- Email List Nag -->
  <div class="ui inline cookie nag email-list" id="emailList">
    <span class="title">
      <div class="label">Save 30% with every reservation</div>
        <?php echo $form->create('User', array('action' => 'subscribe', 'type' => 'get', 'class' => 'ui form')); ?>
        <div class="inline fields">
          <div class="inline field">
            <label>Save 30% with every reservation</label>
            <?php echo $this->Form->input('Email', array('placeholder' => 'Email Address', 'label'=>FALSE, 'div'=>FALSE)); ?>
          </div>
          <div class="field">
            <?php echo $this->Form->submit('GO', array('class' => 'ui button primary')); ?>
          </div>
          <div class="ui error message"></div>
        </div>
        <?php echo $form->end();?>  
      </span>
    <i class="close icon emailClose"></i>
  </div>
  <!-- Email List Nag End -->
  </div>
  
  <?php } ?>
  

<div class="home-container">
  <?php echo $this->element('header');?>
  
  <?php
    if ($session->check('Message.error')):
  ?>
    <div class="ui negative message">
      <?php echo $session->flash('error'); ?>
    </div>
  <?php
    endif;
    if ($session->check('Message.success')):
  ?>
    <div class="ui positive message">
      <?php echo $session->flash('success'); ?>
    </div>
  <?php
    endif;
    if ($session->check('Message.flash')):
  ?>
    <div class="ui message">
      <?php echo $session->flash(); ?>
    </div>
  <?php
    endif;
  ?>
  
  <?php if(isset($resetxt)&&($resetxt!='no')){?> 
    <div class="ui message">
      <p><?php echo $resetxt;?></p>
    </div>
  <?php }?>
  
  <?php echo $content_for_layout;?>
  <?php echo $this->element('footer');?>
</div>

<!-- SIGNUP MODAL -->
<div class="signup ui basic modal">
  <div class="content">
    <div class="center">
      <div class="logo mark"></div>
      <h3>Become a member</h3>
      <p class="claim">Create an account and unlock 30% off with every reservation</p>
      <div class="ui segment">
        <p>Already a member? <a href="#" class="signin_trigger">Sign in</a></p>
        <?php echo $this->element('sign_up', array('reservation' => FALSE));?>
      </div>
    </div>
    <a href="#" class="close"><i class="icon close"></i> Close</a>
  </div>
</div>
<!-- END SIGNUP MODAL -->

<!-- SIGN IN MODAL -->
<div class="signin ui basic modal">
  <div class="content">
    <div class="center">
      <div class="logo mark"></div>
      <h3>Log In</h3>
      <div class="ui segment log-in">
        <p>New to TableSavvy? <a href="#" class="signup_trigger">Sign Up</a></p>
        <?php echo $this->element('log_in', array('reservation' => FALSE));?>
      </div>
    </div>
    <a href="#" class="close"><i class="icon close"></i> Close</a>
  </div>
</div>
<!-- END SIGNUP MODAL -->

<!-- HOW IT WORKS MODAL -->
<div class="how_it_works ui basic modal">
  <div class="content">
    <div class="center">
      <div class="inner">
        <h3>Our exclusive network gives you last minute tables at Chicago's finest restaurants</h3>
        <div class="ui grid stackable">
          <div class="three column row">
            <div class="column">
              <h4><i class="icon browser"></i> Browse Reservations</h4>
              <p>As a TableSavvy member, you have access to last minute tables in our premium network of restaurants.</p>
            </div>
            <div class="column">
              <h4><i class="bookmark icon"></i> Choose a Table</h4>
              <p>Pick a restaurant. Whether you choose noon or night, a party size big or small, we have you covered. Act quick!</p>
            </div>
            <div class="column">
              <h4><i class="trophy icon"></i> Enjoy &amp; Save</h4>
              <p>As an added TableSavvy perk to our members, we make sure you always receive 30% off your meal!</p>
            </div>
          </div>
        </div>
        <a href="/home#quick_reserve" class="book_now ui button inverted primary">Book Now</a>
      </div>
      <a href="#" class="close"><i class="icon close"></i> Close</a>
    </div>
  </div>
</div>
<!-- END HOW IT WORKS MODAL -->



<?php
    if(isset($new_user)){
        if($new_user){?>
<!--- Facebook Conversion Code for BookingPixel - REGISTRATION --->
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
    <noscript><img height="1" width="1" alt="" style="display:none" src="//www.facebook.com/tr?ev=6021035220780&cd[value]=0.01&cd[currency]=USD&noscript=1" /></noscript>
    <?php }}?>
<?php if(isset($isOrderConfirmed)){
if($isOrderConfirmed=='confirmed'){?>
    <!-- Google Code for Confirmation Page -->
    <script type="text/javascript">
    /* <![CDATA[ /
    var google_conversion_id = 986261424;
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "JChyCOjy8QkQsM-k1gM";
    var google_conversion_value = 5.00;
    var google_remarketing_only = false;
    / ]]> */
    </script>
    <script type="text/javascript"
    src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt=""
    src="//www.googleadservices.com/pagead/conversion/986261424/?value=5.00&label=JChyCOjy8QkQsM-k1gM&guid=ON&script=0"/>
    </div>
    </noscript>
    <script type="text/javascript">
      var fb_param = {};
      fb_param.pixel_id = '6008948371479';
      fb_param.value = '0.00';
      fb_param.currency = 'USD';
      (function(){
        var fpw = document.createElement('script');
        fpw.async = true;
        fpw.src = '//connect.facebook.net/en_US/fp.js';
        var ref = document.getElementsByTagName('script')[0];
        ref.parentNode.insertBefore(fpw, ref);
      })();
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="//www.facebook.com/offsite_event.php?id=6008948371479&value=0&currency=USD" /></noscript>
    <!-- Facebook Conversion Code for BookingPixel - CHECKOUT -->
    <script>
        (function() {
            var _fbq = window._fbq || (window._fbq = []);
            if (!_fbq.loaded) {
                var fbds = document.createElement('script');
                fbds.async = true;
                fbds.src = '//connect.facebook.net/en_US/fbds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(fbds, s); _fbq.loaded = true;
            }
        })();
        window._fbq = window._fbq || [];
        window._fbq.push(['track', '6021035214380', {'value':'5.0','currency':'USD'}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="//www.facebook.com/tr?ev=6021035214380&cd[value]=0.01&cd[currency]=USD&noscript=1" /></noscript>
<?php }}?>

<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31123799-1']);
  _gaq.push(['_setDomainName', 'tablesavvy.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
  
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PR2RW7" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>
  (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;
  j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-PR2RW7');
</script>
<!-- End Google Tag Manager -->



    <?php /* Mobile banner
      // Removing for now to focus on the primary CTA: email capture
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
    */?>
    
    <script type="text/javascript">
        $('#UserSubscribeEmail').on('blur', function () {
            setTimeout(function () {
                window.scrollTo(document.body.scrollLeft, document.body.scrollTop);
            }, 0);
        });
        $(window).on('unload',function(){
           $('.desktop').removeClass('wrapperContainer');
        });
    </script>
</body>
</html>
