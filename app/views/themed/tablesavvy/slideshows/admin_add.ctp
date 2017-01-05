<style>
.slideshowmain1 .textarea{
	margin-top:0px;
}
</style>
<div class="test1" style="width:752px; height:420px; background:#FFFFFF;">
<div class="upload_top" style="width:750px;">
	<div class="upload_text">
    	<h2>ADD PHOTO</h2>
    </div>    
    <div class="up_middle"></div>
</div>
<div class="slideshowmain1">
<div class="test" style="float:left;width:315px; height:100px; margin-left:75px; margin-top:20px;">
<?php 
	  echo $form->create('',array('type'=>'file')); 
	  echo $form->input('path',array('type'=>'file','label'=>'Upload image:'));	
	  echo $form->input('description',array('type'=>'textarea','label'=>'Caption:','id'=>'text_align'));
	  echo $form->submit('UPLOAD',array('class'=>'upload_but_add','label'=>false));
	  echo $form->submit('CANCEL',array('class'=>'upload_can','label'=>false,'onclick'=>'parent.$.colorbox.close();'));
	  echo $form->end();
?>   
</div>	
</div>
</div>