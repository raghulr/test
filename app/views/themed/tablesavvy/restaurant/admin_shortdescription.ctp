<style type="text/css">
.submit{ float:none;}
</style>
<div class="short_back">
<div class="upload_top">
	<div class="upload_text">
    	<h2>SHORT DESCRIPTION</h2>
    </div>    
    <div class="up_middle" style="width:428px;">
    	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin:10px;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
    </div>
</div>
<?php echo $this->element('js_tiny_mce_setting'); ?>
<div class="formeditor">
<?php echo $form->create();
 	  echo $form->input('Restaurant.id',array('type'=>'hidden'));	?>
      <div class="pop_editor"><?php echo $form->input('Restaurant.short_description',array('class'=>'js-editor','width'=>200,'label'=>false));?></div>      
<?php 	 
	  echo $form->submit('UPDATE',array('class'=>'upload_but','id'=>'up_align','label'=>false));
	  echo $form->end();
?>	  	
</div>
</div>