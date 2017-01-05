<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
   <?php echo $html->charset(), "\n";?>  
   <title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title> 
    <?php
    require_once('_head.ctp');
    echo $asset->scripts_for_layout();
    ?>
    <link rel="shortcut icon" href="<?php echo $html->url('/img/favicon.ico');?>" />
</head>
<body class="home-pattern">
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
    <div class="home-bg <?php echo strtolower($title_for_layout); ?>">
    <div class="home-container">
        <?php echo $this->element('header');?>
        <div class="more-spacer">&nbsp;</div>
        <div id="content" class="clearfix"> 
        <?php echo $content_for_layout;?>   
        </div>    
        <?php echo $this->element('footer');?> 
    </div> 
</div>    
</body>
</html>
