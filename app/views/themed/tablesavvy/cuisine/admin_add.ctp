<div class="rec_table_back">
<div class="js-responses" id="js-responses">
    <div class="upload_top" style="width:498px;">
	<div class="upload_text">
    	<h2><?php if(!empty($title_for_popup))echo $title_for_popup; ?></h2>
    </div>    
    <div class="up_middle"></div>
</div>
    <div class="neighborhood">
    <?php echo $form->create('Cuisine',array('action'=>'add', 'class'=>'js-ajax-form'));?>
    	<div class="add_new_name">
        	<?php echo $form->input('name',array('label'=>'Name : ','width'=>200)); ?>
        </div>
        <div class="add_new_but">
        <div class="log_button"><?php echo $ajax->submit('Add Cuisine', array('url'=> array('controller'=>'cuisines', 'action'=>'add'), 'update' => 'js-responses', 'complete'=>'funcall()','class'=>'cus_update'));?></div>
        </div>
    <?php echo $form->end();?>
    </div>    
</div>   
</div> 
