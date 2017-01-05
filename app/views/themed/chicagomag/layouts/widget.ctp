<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $html->charset(), "\n";?>
<title>Chicagomag | <?php echo $title_for_layout; ?></title>
<?php
        echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
        echo $html->meta('description', $meta_for_layout['description']), "\n";
        require_once('widget_head.ctp');
        echo $asset->scripts_for_layout();
?>
</head>
<body>
<?php echo $content_for_layout;?>   
</body>
</html>
