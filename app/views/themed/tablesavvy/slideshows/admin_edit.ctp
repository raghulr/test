 <div class="titlepopup">
        <div class="lefttitlepopup"></div>
        <div class="midtitlepopup"><?php if(!empty($title_for_popup))echo $title_for_popup; ?></div>
        <div class="righttitlepopup"></div>
    </div>
<div class="slideshowmain1">
<?php echo $form->create('',array('type'=>'file')); 
	  echo $form->input('id',array('type'=>'hidden','value'=>$imagedetails['Slideshow']['id']));
	   echo $form->input('restaurant_id',array('type'=>'hidden','value'=>$imagedetails['Slideshow']['restaurant_id']));	?>
	  <div class="imagedeletecontent"><?php echo $html->image('small/'.$imagedetails['Slideshow']['path'],array('border'=>0,'height'=>100)); ?></div><?php
	  echo $form->input('path',array('type'=>'file','label'=>'Upload image:'));	
	  echo $form->input('description',array('type'=>'textarea','label'=>'Caption:','value'=>$imagedetails['Slideshow']['description']));
	  echo $form->submit('Upload');
	  echo $form->end();
	 ?> 
	
</div>
