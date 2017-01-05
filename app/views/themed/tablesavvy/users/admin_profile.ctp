<style>
.textarea{
	height:119px;
	width:316px;
}

#up_right_but1 {
    float: left;
    margin-left: 100px;
    margin-top: 30px;
}
#up_right_but2 {
    margin-right: 82px;
    padding-top: 30px;
}
#par{
overflow-x: hidden;
overflow-y: auto;
}
.check_last1 label {
    color: #595959;
    float: left;
    font: 12px Arial;
    margin: 6px 0 0;
    width: 30px;
}
.sample {
    border-top: 1px solid black;
    float: left;
    height: 54px;
    width: 748px;
	margin-top:66px;
}
</style>
<script>
function showFields(value)
{
	if(value != ''){
		//alert(value);
		var flag = $("#flag").val();
		$("#flag").attr('value','1');
		//alert(flag);
	} 
}
function edit_p(event){
	var flag = $("#flag").val();
	if(flag == '1'){
		$("#errorMessage").css('display','block');
		event.preventDefault();
		alert("Please click the Update Profile button");
		//$("#errorMessage").fadeOut(5000);
	}
	else {
		$(".colorbox-slide-larger").colorbox({iframe:true,innerWidth:700,innerHeight:400,onClosed:function(){
                        //parent.window.location.reload();
                    }});
		$(".colorbox-slide-larger-photo").colorbox({iframe:true,innerWidth:762,innerHeight:340,scrolling:false,onClosed:function(){
                        //parent.window.location.reload();
                    }});
	} 
}
</script>
<!--<div id="errorMessage" class="message" style="display:none;"> Please click the Update Profile button.. </div>-->
<div id="changedate">
<?php /*?><?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
<div class="date_set"><span></span><input id="date1" class="date-pick dp-applied" name="date1" onChange="changedate(this.value,'<?php echo $changedateurl; ?>')" value="<?php echo date('m/d/Y'); ?>"></div><?php */?>
    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
            <li><?php echo $html->link('History',array('controller'=>'history','action'=>'index')); ?></li>
            <li class="active_link"><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
        </ul>
    </div>
     <?php echo $form->create('Restaurant', array('action' => 'profile', 'class' => 'normal ','type' => 'file')); ?>
    <?php echo $form->input('id'); 
	//echo $form->input('flag', array('type'=>'hidden','label'=>false,'value'=>0,'id'=>'flag')); 
	 //echo $form->input('short_description',array('type'=>'hidden'));  echo $form->input('long_description',array('type'=>'hidden'));?>
    <div class="navi_content">
    	<div class="all_content">
        	<div class="sub_all">
           <div class="top_left">
                <div class="top_left_head">
                    <span id="des">Description</span>
                </div>
                <div class="content">
                    <div class="cont" style="height:350px">
                        <!--<span id="shot">Short Description </span>
                        <div class="cont_text">
                            <span id="cont_text">
                            	<?php 
								//echo $form->input('short_description', array('class'=>'textarea','label'=>false,'onchange'=>'return showFields(value)')); 
								 ?>
                            </span>
                        </div>-->
                        <span id="shot">Long Description</span>
                       
                        <div class="cont_text_two" style="height:294px;">
                            <span id="cont_text">
                            	<?php 
								echo $form->input('long_description', array('class'=>'textarea','label'=>false,'onchange'=>'return showFields(value)','style'=>'height:261px')); 
								 ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top_left">
                <div class="top_left_head">
                    <span id="phot">Photos</span>
                </div>
                <div class="content">
                	
                    <div class="profile_photo" style="width:375px; height:220px; margin:10px 15px;"> 
					<?php if(!empty($imagelist)): foreach($imagelist as $list): echo $html->image('big/'.$list['Slideshow']['path'],array('border'=>0,'height'=>220,'width'=>'375')); endforeach; endif;?> 
                    </div>
                    
                    <div class="left_butn"><a id="sub_rem" href="<?php echo $html->url(array('controller'=>'slideshows','action'=>'index'),true); ?>" class="colorbox-slide-larger-photo" onclick="return edit_p(event);">EDIT PHOTOS</a></div>
                    
                </div>
            </div>
            <div class="top_left">
                <div class="top_time_head">
                    <span id="res_time">Reservation Times</span>
                </div>
                <div class="content">
                	<div class="pro_time">
                    	<div class="time_start">Start Time </div>
                        <?php echo $form->input('startTime',array('interval'=>30,'class'=>'pp_time','label'=>false,'type'=>'select','options'=>$options,'selected'=>$this->data['Restaurant']['startTime'])); ?>
                    </div> 
                    <div class="pro_time">
                    <div class="time_start">End Time </div>
                    <?php  echo $form->input('endTime',array('class'=>'pp_time','type'=>'select','label'=>false,'options'=>$options,'selected'=>$this->data['Restaurant']['endTime'])); ?>
                    
                    </div>
                </div>
            </div> 
                    </div>
                </div>
            </div>
            <div class="bot_cont">
                <div class="bot_head">
                    <span id="res_deta">Restaurant Details</span>
                </div>
                <div class="content_bot">
                	<div class="left">
                    	<div class="left_cont">
                        	<div class="lab_text"><?php echo $form->input('name',array('label'=>'Name:','class'=>'left_text','type'=>'text','onchange'=>'return showFields(value)')); ?></div>
                            <div class="lab_text"><?php echo $form->input('address',array('label'=>'Address:','class'=>'left_text','type'=>'text','onchange'=>'return showFields(value)')); ?></div>
                            <div class="lab_text">
							<?php $city_url = $html->url(array('controller'=>'restaurants', 'action'=>'changeneighboor'),true); ?>
						<?php echo $form->input('city',array('label'=>'City:','class'=>'left_text_sel','type'=>'select','empty'=>'Select city','options'=>$city_name,'onchange' =>'changeneighboor(this.value,"'.$city_url.'");')); ?>
                            </div>
                            <div class="lab_text"><?php echo $form->input('state',array('label'=>'State:','class'=>'left_text','type'=>'text','onchange'=>'return showFields(value)')); ?></div>
                            <div class="lab_text"><?php echo $form->input('phone',array('label'=>'Phone:','class'=>'left_text','type'=>'text','onchange'=>'return showFields(value)','error' => array('rule1'=>'Required','rule2'=>'Enter numbers only'))); ?></div>
                            <div class="lab_text"><?php echo $form->input('url',array('label'=>'Url:','class'=>'left_text','type'=>'text','onchange'=>'return showFields(value)')); ?></div>
                            <div class="lab_text" id="neigh"><?php echo $form->input('neighborhoodId',array('label'=>'Neighborhood','type'=>'select','class'=>'left_text_sel','empty'=>'Select neighborhood','options'=>$neighboor_name)); ?></div>
                            <div class="cus_name_select">
                                <label class="cusin" id="cusin_title">Cuisine:</label> 
                                <div class="cus_name">
                                    <fieldset id="field">
                               <?php if(!empty($cuisines)):foreach($cuisines as $cuname): ?>
                                <p style="float:left; width:auto;"><legend id="change_cusine"><?php echo $cuname;?> </p>
                                 <?php endforeach; endif; ?>
                                     </legend>
                                     <div class="edit_but">
                                      <?php echo $html->link('EDIT',array('controller'=>'cuisines','action'=>'index'),array('class'=>'colorbox-edit'));?>
                                     </div>
                                     </fieldset>
                                    </div>
                            </div>
                            
                            <div class="check_last"><?php echo $form->input('valet',array('label'=>'Valet:','class'=>'left_check','type'=>'checkbox')); ?></div> 
							<?php /*?><div class="check_last1 lab_text">
                            	<?php echo $form->input('percentage',array('label'=>'Discount Percentage:','class'=>'left_text','type'=>'text')); ?><?php */?>
                            </div>
                          <div class="sample">
                            <div class="uplod_butn" id="up_right_but2">
							<?php if(isset($menu)){?>
                            <a target="_blank" href="<?php echo $this->webroot; ?>img/profilemenu/<?php echo $menu;?>"><?php echo $html->image('/images/view_menu.png',array('border'=>0));?></a>
                            <?php }else{ ?>
							  <a target="_blank" href="javascript:;"><?php echo $html->image('/images/view_menu.png',array('border'=>0));?></a>	
							 <?php } ?>
                            </div>
                            <a id="sub_rem" onclick="return edit_p(event);" href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'uploadmenu'),true); ?>" class="colorbox-slide-larger"><?php echo $html->image('/images/upload_menu.png',array('border'=>0,'class'=>'uplod_butn','id'=>'up_right_but1'));?></a>
                          	</div>
							<?php  echo $form->submit('UPDATE PROFILE',array('class'=>'upload_but','id'=>'updat_prof','label'=>false)); ?>
                        </div>
                        <div class="right">
                         <div id="update_image_logo">
                            <?php 
                            //, 'height'=>435, 'width'=>400
                            if(!empty($image_path)){echo $html->image('big/'.$image_path,array('border'=>0,'class'=>'pro_logo', 'width'=>300,'height'=>321));}?>
                            </div>
                            <a id="sub_rem" onclick="return edit_p(event);" href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'upload_logo'),true); ?>" class="colorbox-slide-larger"><?php echo $html->image('/images/update_logo.png',array('border'=>0,'class'=>'uplod_butn','id'=>'up_right_but'));?></a>
                            
                            <div id="up_right_but" style="width:122px; height:14px; color:#fff; border-radius:5px; background-color:#81B309;
                            padding:12px 34px 13px 50px; font-size:15px; margin:30px 54px 0 54px;float:left"> 
                             <a style="text-decoration:none; color:#fff;" id="sub_rem" onclick="return edit_p(event);" href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'edit_email'),true); ?>" class="colorbox-add"><b>EDIT ACCOUNT</b> </a> </div> 
                    
                        </div> 
                       </div>
                    <?php echo $form->end(); ?>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="navi_botom"></div>	
</div>