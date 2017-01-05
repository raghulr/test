<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title>
	<?php
		//echo $html->meta('icon'), "\n";
		$browser = $_SERVER['HTTP_USER_AGENT'];
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
		echo $html->css('adminpopup.css');
                $html->css('jquery.alerts.css', null, null, false);
		if(stristr($browser,'IE 7')){
			$html->css('ie7', null, null, false);
		}
		if(stristr($browser,'IE 8')){
			$html->css('ie8', null, null, false);
		}
		if(stristr($browser,'IE 9')){
			$html->css('ie9', null, null, false);
		}
		$javascript->link('jquery-1.6.1.min', false);	
        $javascript->link('jquery.alerts', false);
		$javascript->link('ajax', false);
		echo $asset->scripts_for_layout();
    ?>
</head>
<body class="admin" style="background:none;">

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
echo $content_for_layout;
?>
</body>
</html>