<?php 
	$javascript->link('jquery.cycle.all', false);
?>
<script type="text/javascript">
	$(document).ready(function($) {
		$('.profile_photo').cycle({
			fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			pager:'#slidenav',
			
		});
	});	
</script>

<div style="width:400px;margin:0 auto; background:#FFFFFF;">
    <div class="profile_photo" id="slideshow" style="margin-top:5px; margin-left:15px;">
		<?php if(!empty($imagelist)): foreach($imagelist as $list): echo $html->image('big/'.$list['Slideshow']['path'],array('border'=>0,'height'=>250,'width'=>350)); endforeach; endif;?>
    </div>
    <div id="slidenav"></div>
</div>