<script>
$(document).ready(function($) {
	$("#dayweek option[value='Weeks']").hide();
	$('.date-pick').datePicker();

});
</script>
<style>
.table_field_rest .recurringdata2 .error-message{
	float:left;
	width:75px;
	color:red;
}
.dp-choose-date{
float:left!important;
}
</style>
<div id="navi_content">
   <?php echo $form->create('');?>
    <fieldset class="table_field_rest">
    	<legend>Restaurants</legend>
        <div class="recurring_rest">
        	<span>
				<?php 
					foreach($restaurant_name as $name){
                    	$checked[$name['Restaurant']['id']]=$name['Restaurant']['name'];
                    }
                    echo $form->input('checked',array('label'=>false,'id'=>'restid','type' => 'select','multiple' => 'checkbox','options' =>$checked));
                ?>
            </span>
 
        </div>
       
        
    </fieldset>
    
     <fieldset class="table_field_rest">
    	<legend>Tables</legend>
        <div class="recurringdata">
        	<?php echo $form->input('Offer.seating',array('type'=>'select','options'=>array(2=>2,4=>4,6=>6,8=>8),'label'=>false));?>
        </div>
    </fieldset>
      <fieldset class="table_field_rest">
    	<legend>Date</legend>
        <div class="recurringdata">
        	<?php  echo $form->input('Offer.offerDate',array('type'=>'text','value'=>'','class'=>'date-pick','label'=>false)); ?>
        </div>
    </fieldset>
    
    <fieldset class="table_field_rest">
    	<legend>Days</legend>
        <div class="recurringdata_new">
			<?php echo $form->input('Offer.days',array('type'=>'select','options'=>array('next day'=>'Every Day','next sunday'=>'Every Sunday','next monday'=>'Every Monday','next tuesday'=>'Every Tuesday','next wednesday'=>'Every Wednesday','next thrusday'=>'Every Thrusday','next friday'=>'Every Friday','next saturday'=>'Every Saturday'),'label'=>false,'onchange'=>"dayorweek(this.value);")); ?>
        </div>
    </fieldset>
    
    <fieldset class="table_field_rest">
    	<legend>Time</legend>
       <div class="time_dis"><?php echo $form->input('Offer.offerTime', array('type' => 'time', 'interval' => 30 ,'label'=>false)); ?></div>
    </fieldset>  
      
    <fieldset class="table_field_rest">
    	<legend>Duration</legend>
        <div class="recurringdata2">
			<?php echo $form->input('Offer.offerDays',array('type'=>'text','label'=>false));?>
            <?php echo $form->input('Offer.daysorweek',array('type'=>'select','options'=>array('Days'=>'Days','Weeks'=>'Weeks'),'label'=>false,'id'=>'dayweek'));?>
        </div>
    </fieldset>
    
	<?php 
		echo $ajax->submit('', array('url'=> array('controller'=>'restaurants', 'action'=>'super_recurringtable','super'=>true), 'update' => 'navi_content','complete'=>'funcall()','class'=>'add_table'));  echo $form->end();
		//echo $form->Submit('/images/delete_now_03.png',array('class'=>'cancel'));
    ?>
    
    
    </div>