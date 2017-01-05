<script language="javascript1.1">
function sample(val){
	var comment = document.getElementsByName('data[Cuisine][id][]');
	for(var i=0;i<comment.length;i++){
		comment[i].checked=false;
	}
	val.checked=true;
}
</script>
<div class="rec_table_back">
<div class="upload_top" style="width:498px;">
	<div class="upload_text">
    	<h2><?php if(!empty($title_for_popup))echo $title_for_popup; ?></h2>
    </div>    
    <div class="up_middle" style="width:228px;">
    	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin:10px;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
    </div>
</div>

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
		 	echo $this->Form->input('Cuisine.id', array('label'=>false,'type' => 'select', 'multiple' => 'checkbox','options' => $options,'selected'=>$data,'class'=>'check_pos','onClick'=>'sample()'));
		 ?>
      </div>   	
     <div class="cusine_but">
     	<?php /*?><div class="add_cuisine">
         <a href="<?php echo $html->url(array('controller'=>'cuisines', 'action'=>'add'),true);?>" class="cus_add"><?php echo $html->image('/images/add_cuisine.png',array('border'=>0,'class'=>'uplod_butn'));?></a>
        </div><?php */?>
        <div class="update_cus">
        <div class="log_button"><?php echo $ajax->submit('UPDATE', array('url'=> array('controller'=>'cuisines', 'action'=>'update_cuisines'), 'update' => 'js-responses', 'complete'=>'funcall()','class'=>'cus_update'));?></div>
        </div> 
     </div>   
    <?php echo $form->end();?>
    </div>    
</div>    
</div>