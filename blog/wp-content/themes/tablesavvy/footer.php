<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
</div>
<div class="footer_wrap">
    <div class="footer_left">
        <ul class="footer-links">
            <li><a href="https://www.tablesavvy.com/blog/" class='btns-small-new'>News / Updates</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/contactus/" class='btns-small-new'>Contact Us</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/privacypolicy/" class='btns-small-new'>Privacy Policy</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/returnpolicy/" class='btns-small-new'>Return Policy</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/terms/" class='btns-small-new us'>Terms & Conditions</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/contactus/1" class='btns-small-new us'>Restaurant Inquiries</a></li>
            <li><span>|</span></li>
            <li><a href="https://www.tablesavvy.com/faq/" class='btns-small-new us'>FAQ</a></li>
            <li><span>|</span></li>
            <li>
                <a href="http://www.chicagomag.com/Chicago-Magazine/Dining/" class="btn-small-new us" onclick="window.open('http://www.chicagomag.com/Chicago-Magazine/Dining/');return false;">Chicago Magazine Dining</a>
            </li>
        </ul>
        <div class="spacer">&nbsp;</div>
        <p>Copyright &copy; 2013. TableSavvy all rights reserved</p>
        <div class="spacer"></div>
    </div>
    <ul class="footer-sn-links">
        <li>
            <a onclick="window.open('http://twitter.com/#!/TableSavvy');return false;" href="http://twitter.com/#!/TableSavvy">
                <img src='<?php bloginfo('template_url'); ?>/images/sn-twt-new_03.png' alt='Twitter' width=35 height=35 class='img_header'/>
            </a>
        </li>
        <li>
            <a onclick="window.open('http://www.facebook.com/TableSavvy');return false;" href="http://www.facebook.com/TableSavvy">
                <img src='<?php bloginfo('template_url'); ?>/images/sn-fb-new_03.png' alt='Facebook'  width=35 height=35 class='img_header'/>
            </a>
        </li>
        <li>
            <a href="https://itunes.apple.com/us/app/tablesavvy/id845047265?ls=1&mt=8">
                <img src='<?php bloginfo('template_url'); ?>/images/ts_app_download.png' alt='TSApp' lass='img_header'/></a>

        </li>
        <li>
            <a href="http://www.1871.com">
                <img src='<?php bloginfo('template_url'); ?>/images/Member-badge.png' alt='1871member' width=46 height=40 class='img_header'/></a>

        </li>
    </ul>
</div>
</div>
</div><!-- #main -->
<?php
/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */

wp_footer();
?>
</body>
</html>
