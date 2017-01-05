<style>
.submit{
	float:left;
	margin:10px 0 0 74px;
}
.error-message{font-size:12px;color:red;text-indent:124px;float:right;font-family:Helvetica, arial, sans-serif;margin:0 168px 0 0;}
.recurringdata2 .error-message{  margin:32px 0 0 232px; text-indent:0; float:none; width:106px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	jQuery("#OfferDaysNextSunday").removeAttr("checked");
	jQuery("#OfferDaysNextMonday").removeAttr("checked");
	jQuery("#OfferDaysNextTuesday").removeAttr("checked");
	jQuery("#OfferDaysNextWednesday").removeAttr("checked");
	jQuery("#OfferDaysNextThursday").removeAttr("checked");
	jQuery("#OfferDaysNextFriday").removeAttr("checked");
	jQuery("#OfferDaysNextSaturday").removeAttr("checked");
	jQuery("#ModalName1").removeAttr("checked");
	disable_everyday();
});
function disable_dayblock() {
 if(jQuery('#ModalName1').is(':checked')) { 
  	//jQuery('#days_block').hide();
	jQuery("#OfferDaysNextSunday").removeAttr("checked");
	jQuery("#OfferDaysNextMonday").removeAttr("checked");
	jQuery("#OfferDaysNextTuesday").removeAttr("checked");
	jQuery("#OfferDaysNextWednesday").removeAttr("checked");
	jQuery("#OfferDaysNextThursday").removeAttr("checked");
	jQuery("#OfferDaysNextFriday").removeAttr("checked");
	jQuery("#OfferDaysNextSaturday").removeAttr("checked");
	$("#OfferDaysorweek option[value='Days']").detach();
	var o = new Option("option text", "Days");
	$(o).html("Days");
	$("#OfferDaysorweek").append(o);
	$("#OfferDaysorweek option[value='Weeks']").detach();
	jQuery('#OfferDaysorweek').val('Days');
	//jQuery('#OfferDaysorweek').attr('disabled', 'disabled');
	}
 else {
 	//jQuery('#days_block').show();
	$("#OfferDaysorweek option[value='Weeks']").detach();
	var o = new Option("option text", "Weeks");
	$(o).html("Weeks");
	$("#OfferDaysorweek").append(o);
	$("#OfferDaysorweek option[value='Days']").detach();
	jQuery('#OfferDaysorweek').val('Weeks');
	//jQuery('#OfferDaysorweek').attr('disabled', 'disabled');
 }
}
function disable_everyday(){
	$(".days_block input").click(function(){
		if(jQuery('#OfferDaysNextSunday').is(':checked') || jQuery('#OfferDaysNextMonday').is(':checked') || jQuery('#OfferDaysNextTuesday').is(':checked') || jQuery('#OfferDaysNextWednesday').is(':checked') || jQuery('#OfferDaysNextThursday').is(':checked') || jQuery('#OfferDaysNextFriday').is(':checked') || jQuery('#OfferDaysNextSaturday').is(':checked'))
		var anyonechecked=1;
		else
		var anyonechecked=0;
		if(anyonechecked){
			//jQuery('#day').hide();
			jQuery("#ModalName1").removeAttr("checked");
			jQuery('#days_block').show();
			$("#OfferDaysorweek option[value='Weeks']").detach();
			var o = new Option("option text", "Weeks");
			$(o).html("Weeks");
			$("#OfferDaysorweek").append(o);
			$("#OfferDaysorweek option[value='Days']").detach();
			jQuery('#OfferDaysorweek').val('Weeks');
		}
		else{
			//jQuery('#day').show();
			jQuery('#days_block').show();
			$("#OfferDaysorweek option[value='Days']").detach();
			var o = new Option("option text", "Days");
			$(o).html("Days");
			$("#OfferDaysorweek").append(o);
			$("#OfferDaysorweek option[value='Weeks']").detach();
			jQuery('#OfferDaysorweek').val('Days');		
		}
	});
}/*
function disable_everyday() {
  if(jQuery('.ModelName2').is(':checked')) 
  	jQuery('#day').hide();
  else
 	jQuery('#day').show();
}*/
function validate(){
	if(jQuery('#OfferDaysNextSunday').is(':checked') || jQuery('#OfferDaysNextMonday').is(':checked') || jQuery('#OfferDaysNextTuesday').is(':checked') || jQuery('#OfferDaysNextWednesday').is(':checked') || jQuery('#OfferDaysNextThursday').is(':checked') || jQuery('#OfferDaysNextFriday').is(':checked') || jQuery('#OfferDaysNextSaturday').is(':checked') || jQuery('#ModalName1').is(':checked')){
		var val = document.getElementById("OfferOfferDays").value;
		if(val==0){
			alert('please enter valid duration');
			return false;
		}else{
			return true;
		}
	}else{
		alert('select days or week');
		return false;
	}
}
</script>
<div class="rec_table_back">
    <div class="upload_top" style="width:498px;">
         <a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin: 7px 4px 0 0;"><?php echo $html->image('/images/close.png',array('width'=>33,'height'=>34,'border'=>0)); ?></a>
        <div class="upload_text"><h2>ADD RECURRING TABLE</h2></div>    
        <div class="up_middle"></div>
    </div>
     <?php echo $form->create('',array('onsubmit'=>'return validate()'));?>
    <div class="recurringdata">
    	<?php echo $form->input('Offer.seating',array('type'=>'select','options'=>array(2=>2,4=>4,6=>6,8=>8),'label'=>'Top:'));?>
        <?php echo $form->input('Offer.offerDate',array('type'=>'hidden','value'=>$assigndate)); ?>
         <?php echo $form->input('Offer.recurring',array('type'=>'hidden','value'=>1)); ?>
    </div>	
    <span style="margin-left: 134px;position: relative;top: 10px;">when:</span>
    <div style="float: left;margin-left: 230px;width: 100%; margin-bottom:10px;">
        <div  id="day">
        			<?php echo $form->checkbox('Offer.EveryDay',array('id'=>'ModalName1','onclick'=>'disable_dayblock()','value' => 'next day')); ?>
               		<label for="ModelName">Every Day</label>
        </div>
        <div id="days_block" class="days_block">
        	<?php $weeks = array(
				'next sunday' => 'Every Sunday',
				'next monday' => 'Every Monday',
				'next tuesday' => 'Every Tuesday',
				'next wednesday' => 'Every Wednesday',
				'next thursday' => 'Every Thursday',
				'next friday' => 'Every Friday',
				'next saturday' => 'Every Saturday'
				);
			?>
        	<?php echo $form->input('Offer.days',array('class'=>'ModelName2', 'label'=>false,'div'=>false,  'multiple' => 'checkbox','options'=>$weeks)); ?>
         </div>
     </div> 
     <div class="recurringdata1">
       <?php echo $form->input('Offer.offerTime',array('type'=>'select','options'=>$options,'label'=>'Time:'));?>
       <?php echo $form->input('Offer.Count',array('type'=>'text','label'=>'No of tables:'));?>
       <?php $current=strtotime(date("Y-m-d H:i:s")); ?>
       <?php echo $form->input('Offer.content',array('type'=>'hidden','label'=>false,'value'=>$current));?>
     </div>
     <div class="recurringdata2">
	 <?php echo $form->input('Offer.offerDays',array('type'=>'text','label'=>'Duration:'));?>
     <?php echo $form->input('Offer.daysorweek',array('type'=>'select','options'=>array('Days'=>'Days','Weeks'=>'Weeks'),'label'=>false));?>
     </div>
   	<div class="butn">
    	<div class="but_ad">
    	<?php 
		   echo $form->Submit('/images/add_now_03.png',array('class'=>'add'));  ?>
        </div>
        <div class="but_ca">
			<?php echo $form->end();?>
        </div> 
    </div>
</div>