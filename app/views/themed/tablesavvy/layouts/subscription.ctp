<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title>
	<?php
		echo $html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n"; 
		require_once('subscripe.ctp');
    	echo $asset->scripts_for_layout();
	?>
     <style type="text/css" media="all">
img, div, a, h1, li, span, p, input, form{
	behavior:url('images/iepngfix.htc');
}
.error-message{
	color:#fff;
	width:100%;
	float:left;
	margin-top:0px;
	line-height:15px;
}
</style>
 <!--[if IE 7]>
	<style type="text/css" media="all">
    	.footer-top ul li {
        	padding-right:8px;
        }
        .footer-top ul li div{
        	padding-right:10px;
        }
    </style>
	<![endif]-->
</head>
<body>
<?php
echo $session->flash('success');
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

<?php echo $content_for_layout;?>
<!--Footer Wrapper-->
<div class="footer">
		<div class="footer-top">
		<ul>
		  <li><a href="<?php echo Configure::read('website.facebook');?>"><div>like us on<span>Facebook</span></div>
	     <?php echo $html->image('/images/sn-f.png',array('width'=>32,'height'=>'32','border'=>0));?></a></li>
		  <li><a href="<?php echo $html->url('/blog',true);?>"><div>read our<span>Blog</span></div><?php echo $html->image('/images/sn-b.png',array('width'=>32,'height'=>'32','border'=>0));?></a></li>
		  <li><a href="<?php echo Configure::read('website.twitter');?>"> <?php echo $html->image('/images/sn-t.png',array('width'=>32,'height'=>'32','border'=>0));?><div class="alignL">follow us on<span>TWITTER</span></div></a></li>
		</ul>
		<div class="spacer"></div>
		</div>
        <?php echo $html->image('/images/logo-chicago.png',array('width'=>247,'height'=>'45','border'=>0)); ?>
<div class="spacer"></div>
</div>
<div class="spacer"></div>
</div>
</body>
</html>

