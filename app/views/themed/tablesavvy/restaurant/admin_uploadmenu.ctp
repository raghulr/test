<style type="text/css">
.submit{ float:none;}
</style>
<?php if(isset($filename)&&!empty($filename)){ 
	$file_url=$html->url('/img/profilemenu/'.$filename,true);
	$link=$html->link($html->image('/images/view_menu.png',array('border'=>0)), $file_url,array('escape'=>false,'target'=>'_blank'));?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		parent.jQuery('#up_right_but2').html('<?php echo $link; ?>');
	});
</script>
<?php } ?>
<div class="short_back">
<div class="upload_top">
	<div class="upload_text">
    	<h2>UPLOAD MENU</h2>
    </div>    
    <div class="up_middle" style="width:428px;">
    	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin:10px;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
    </div>
</div>
<div class="slideshowmain1">
<div class="test" style="float:left;width:341px; height:100px; margin-left:75px; margin-top:50px;">
<?php echo $form->create('',array('type'=>'file')); 
	  echo $form->input('pdfpath',array('type'=>'file','label'=>'Upload menu:  ','class'=>'up_text'));	
	  echo $form->submit('UPLOAD',array('class'=>'upload_but_add','label'=>false));
	  echo $form->end();
	 ?> 
</div>
</div>
</div>