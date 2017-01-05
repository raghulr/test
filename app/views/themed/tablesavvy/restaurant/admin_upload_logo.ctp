<style type="text/css">
.submit{ float:none;}
.upload_but{
	background:url("../images/button_back.png") no-repeat scroll 0 0 transparent;
	width:
}
</style>
<?php if(isset($image_path1)&&!empty($image_path1)){ 
	$image=$html->image('big/'.$image_path1,array('border'=>0,'class'=>'pro_logo', 'width'=>300));?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		parent.jQuery('#update_image_logo').html('<?php echo $image; ?>');
	});
</script>
<?php } ?>
<div class="short_back">
<div class="upload_top">
	<div class="upload_text">
    	<h2>UPLOAD LOGO</h2>
    </div>    
    <div class="up_middle" style="width:428px;">
    	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin:10px;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
    </div>
</div>
<div class="slideshowmain1">
<div class="test" style="float:left;width:341px; height:100px; margin-left:75px; margin-top:50px;">
<?php echo $form->create('',array('type'=>'file')); 
	  echo $form->input('path',array('type'=>'file','label'=>'Upload image :  ','class'=>'up_text'));	
	  echo $form->submit('UPLOAD',array('class'=>'upload_but_add','label'=>false));
	  echo $form->end();
	 ?> 
</div>
</div>
</div>