<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $html->charset(), "\n";?>
<title>Chicagomag | <?php echo $title_for_layout; ?></title>
<?php
        echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
        echo $html->meta('description', $meta_for_layout['description']), "\n";?>
    <meta name="TableSavvy" content="app-id=845047265"/>
       <?php require_once('widget_head.ctp');
        echo $asset->scripts_for_layout();
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31123799-1']);
  _gaq.push(['_setDomainName', 'tablesavvy.com']);
  _gaq.push(['_setAllowLinker', true]);
 // _gaq.push(['_trackPageview']);
  _gaq.push(['_trackEvent', 'Viewed Widget', 'Chicagomag widget']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body style="padding: 0 !important;overflow:hidden;">
<?php echo $content_for_layout;?>   
</body>
</html>
