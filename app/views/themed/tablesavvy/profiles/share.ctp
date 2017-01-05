<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Configure::read('website.name');?></title>
<link rel="shortcut icon" href="<?php echo $html->url('/img/favicon.ico');?>" />
<?php
	$share_url = 'www.'.Configure::read('website.name').'.com';
	$title = Configure::read('website.name');
	$redirecturl=$html->url(array('controller'=>'profiles','action'=>'index'),true);
	$text = 'I just got a last minute reservation at '.$res_name.' using '.Configure::read('website.name').'! Check out '.Configure::read('website.name').' for yourself at www.'.Configure::read('website.name').'.com';                    
?>
 <?php  $shareurl= $html->url(array('controller'=>'profiles','action'=>'share',$res_name),true); ?>
<meta property="og:title" content="<?php echo $title;?>"/>
<meta property="og:image" content="<?php echo $image = 'http://www.tablesavvy.com/images/tablesavyyfb.jpg';  ?>"/>
<meta property='og:description' content='<?php echo $text;?>'/> 


<script type="text/javascript">
window.location.href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($shareurl); ?>&p[url]=<?php echo urlencode('http://tablesavvy.com');?>";
</script>
</head>
<body>
</body>
</html>
