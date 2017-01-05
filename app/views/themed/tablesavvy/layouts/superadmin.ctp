<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	<title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title>
	<?php
		//echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
?>
       <meta name="apple-itunes-app" content="app-id=845047265"/>
        <?php 
		require_once('_superadmin_head.ctp');
		echo $asset->scripts_for_layout();
	?>
     <script type="text/javascript">
	$(document).ready(function(){
	Date.firstDayOfWeek = 0;
	Date.format = 'mm/dd/yyyy';
	 $('.date-pick').datePicker();
	});
	</script>
</head>
<body class="admin" onload="startTime()">
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
	<div class="header_cont">
    <?php 
    if($this->params['url']['url']=='admin' || $this->params['url']['url']=='users/forget_password'){
        
    }else{
        if(isset($superdashbaord)){
            if($superdashbaord=='yes'){?>
            <p class="button-back">
                <?php 
                    if($back=='yes'){
                        echo $html->link('Back',array('controller'=>'Restaurants','action'=>'index'));                        
                    }else{ ?>                       
                        <a onclick="window.history.back()">Back</a> 
                <?php }?>
            </p>
            <p class="button-login">
               <?php echo $html->link('Logout',array('controller'=>'users','action'=>'logout','super'=>true),array('escape' => false));
            }?>
        <?php }else{
        echo $html->link($html->image('/images/log_out.png',array('class'=>'log_out')),
             array('controller'=>'users','action'=>'logout','super'=>true),array('escape' => false));
        }
    }?> 
	<div class="logo" style='margin:35px 0px 25px 300px'><?php echo $html->image('/theme/tablesavvy/images/TS_email_logo.png');?></div>
    <div class="admin_head">
    	<div class="ad_text"><span id="admin_text">SUPER ADMINISTRATION</span></div>
    </div>
    <?php if($this->params['url']['url']=='admin'||$this->params['url']['url']=='users/forget_password'){}else{
?>
    <?php }?>
    </div>
</div>
 <div style="display:none">
      <input type="hidden" id="site_url" value="<?php 
					echo $rest_url = $html->url('/',true);
					?>" />  	 
 </div>
<div class="container">
	<div class="container_cont">
    	
         <?php echo $content_for_layout;?>	
    </div>
</div>
<?php /*?><div class="footer">
	<div class="footer_logo"><?php echo $html->image('footer_logo.png');?></div>
</div><?php */?>
<?php echo $this->element('sql_dump');?>
</body>
</html>
