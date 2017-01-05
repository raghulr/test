<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title><?php
/*
 * Print the <title> tag based on what is being viewed.
 */
global $page, $paged;

wp_title('|', true, 'right');

// Add the blog name.
bloginfo('name');

// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && ( is_home() || is_front_page() ))
    echo " | $site_description";

// Add a page number if necessary:
if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'twentyten'), max($paged, $page));
?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link href="<?php bloginfo('template_directory'); ?>/jquery-video-lightning.css" rel="stylesheet" type="text/css" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
                <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-latest.min.js"/></script>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-video-lightning.js"/></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.resizecrop-1.0.3.js"/></script>
     
<script type="text/javascript">
    var $j = jQuery.noConflict();   
            $j(function() {
                $j(".video-link").jqueryVideoLightning({
                autoplay: 1,
                backdrop_color: "#545454",
                backdrop_opacity: 0.6,
                glow: 20,
                glow_color: "#000"
                });
                $j('.post_meta_image').resizecrop({
                    width: 130,
                    height: 130,
                    vertical: "top"
                });
                $j('.wp-post-image').resizecrop({
                    width: 130,
                    height: 130,
                    vertical: "top"
                });                
            });
        </script>
        <!--[if IE 7]>
        <link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/ie7.css" />
        <![endif]-->
        <!--[if IE 8]>
        <link rel="stylesheet" media="screen" href="<?php bloginfo('template_url'); ?>/ie8.css" />
        <![endif]-->
        <?php
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */
        wp_head();
        ?>
</head>

    <body <?php body_class(); ?>>
        <!-- Facebook like -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=646631642018284";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <!-- Twitter tweets-->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <!-- Linked in share -->
        <script src="//platform.linkedin.com/in.js" type="text/javascript">
        lang: en_US
        </script>
        <div class = "home-bg">
            <div class="home-container">
                <!-- #header -->
                <div class="home-top">
                    <div class="home-top-left">
                        <a href="https://www.tablesavvy.com/">
                            <img class="image_header" id="logo" src="<?php bloginfo('template_url'); ?>/images/TS_ChicagoMag_logoDEC_03_03.png" alt="" border="0" />
                        </a>				
                        <div class="spacer"></div>
                    </div>
                    <div class="home-top-right">
                        <div class="login-link">
                            <ul>
                                <li>
                                    <a href="https://www.tablesavvy.com/login">Login</a> 
                                </li> 
                                <li><span>|</span></li>
                                <li>
                                    Not a member? <a href="https://www.tablesavvy.com/register" class="color_sign">Sign Up!</a> 
                                </li>  
                                <a href="https://itunes.apple.com/us/app/tablesavvy/id845047265?ls=1&mt=8">
                                    <img class="tsApp_header" src="<?php bloginfo('template_url'); ?>/images/ts_app_download.png" alt="TSApp" border="0" />
                                </a>
                            </ul>
                            <div class="spacer"></div>
                        </div>
                        <div class="spacer">&nbsp;</div>
                        <!--Navigation-->
                        <div class="nav-home">
                            <ul class="nav-menu">
                                <li><a href="https://www.tablesavvy.com/contactus/1">Contact Us</a></li>
                                <li><span>|</span></li>
                                <li><a href="https://www.tablesavvy.com/faq">FAQ</a></li>
                                <li><span>|</span></li>
                                <li><a href="https://www.tablesavvy.com/howitworks">How it works</a></li>
                                <li><span>|</span></li>
                                <li><a href="https://www.tablesavvy.com/login">My profile</a></li>
                            </ul>
                            <div class="spacer"></div>
                        </div>
                        <div class="spacer"></div>
                    </div>
                    <div class="spacer"></div>
                </div>
                <div id="main">
                    <div class="heading-txt">
                    <?php if(!is_front_page()):?>
                    <span class="news_and_update just_left">News / Updates</span>
                    <span class="back_to_blog_div">
                     <a href="https://www.tablesavvy.com/blog" class="back_to_blog">&Lt; Back</a>
                    </span>
                    <?php else:?>
                    <span class="news_and_update"just_left>News / Updates</span>                    
                    <?php endif;?>
                    </div>
                    <div class="gap04"> </div>
