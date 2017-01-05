<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php echo $html->charset(), "\n";?>
	<title>TableSavvy | <?php echo $title_for_layout; ?></title>
	<?php
		echo $html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));
		echo $html->css(array('style1.css','colorbox.css'));
		echo $javascript->link('jquery-1.6.min', false);
		echo $javascript->link('jquery.colorbox-min', false);	
		echo $javascript->link('cufon-yui', false);
		echo $javascript->link('diavlo_light', false);
		echo $javascript->link('diavlo_bold', false);
		echo $javascript->link('bebas', false);
		echo $javascript->link('Heavenetica', false);
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
		//require_once('_head.includes.ctp');
		echo $asset->scripts_for_layout();
	?>
     <script type="text/javascript">
		Cufon.replace('.titlesavvay2',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.text2',{ fontFamily: 'diavlo light' });
		</script>
</head>
<body>
<?php
if ($session->check('Message.error')):
		$session->flash('error');
endif;
if ($session->check('Message.success')):
		$session->flash('success');
endif;
if ($session->check('Message.flash')):
		$session->flash();
endif;
?>

<?php echo $content_for_layout;?>
</body>
</html>
