<div class="edit_cus_back">
<div class="js-responses" id="js-responses">
    <div class="neighborhood">
    <?php echo $form->create('Cuisine',array('action'=>'update_cuisines', 'class'=>'js-ajax-form'));?>
         <div class="check_position">
         <?php  
		 	$options = array(); 
			foreach($cuisines as $value => $label) { 
			  $options[] = array( 
				'name' => $label, 
				'value' => $value, 
				'onClick' => 'sample(this)' 
			 ); 
			}
		 	echo $this->Form->input('Cuisine.id', array('label'=>false,'type' => 'select', 'multiple' => 'checkbox','options' => $options,'class'=>'check_pos','onClick'=>'sample()'));
		 ?>
      </div>  
        <div class="cusine_but">
     	<?php /*?><div class="add_cuisine">
         <a href="<?php echo $html->url(array('controller'=>'cuisines', 'action'=>'add'),true);?>" class="cus_add"><?php echo $html->image('/images/add_cuisine.png',array('border'=>0,'class'=>'uplod_butn'));?></a>
        </div><?php */?>
        <div class="update_cus">
        <div class="log_button"><?php echo $ajax->submit('Update', array('url'=> array('controller'=>'cuisines', 'action'=>'update_cuisines'), 'update' => 'js-responses', 'complete'=>'funcall()','class'=>'cus_update'));?></div>
        </div> 
     </div>   
    <?php echo $form->end();?>
   
    </div>    
</div>    
</div>
