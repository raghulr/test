<?php 
echo $html->css('style34', null, null, false);
echo $javascript->link('jquery-1.4.4.min.js', false);
echo $javascript->link('zingchart-html5beta-min.js', false);
echo $javascript->link('license.js', false);
$url = $html->url('/super/users/zingchart/index.json',true);
?>
<script type="text/javascript">
$(document).ready(function() {
	zingchart.render({
		'id' : 'g1',
		'width' : 500,
		'height' : 400,
		'dataurl' : '<?php echo $url;?>'
	});
});
</script>

        <a href="#" style="float:right;" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
<div class="g" id="g1"></div>