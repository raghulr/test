<style>
.textarea{
	height:119px;
	width:316px;
}

#up_right_but1{
	margin-right:84px;
}
#up_right_but2 {
    margin-right: 56px;
	padding-top:228px;
    padding-bottom: 12px;
}
#up_right_but3 {
    margin-right: 56px;
	padding-top:170px;
    padding-bottom: 12px;
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
</style>
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
    <?php echo $form->input('id'); //echo $form->input('short_description',array('type'=>'hidden'));  echo $form->input('long_description',array('type'=>'hidden'));?>
    <div class="navi_content">
    	<div class="all_content">
        	<div class="sub_all">
           <div class="top_left">
                <div class="top_left_head">
                    <span id="des">Description</span>
                </div>
                <div class="content">
                    <div class="cont">
                        <span id="shot">Short Description </span>
                        <div class="cont_text">
                            <span id="cont_text">
                            	<?php 
								echo $form->input('short_description', array('class'=>'textarea','label'=>false)); 
								 ?>
                            </span>
                        </div>
                        <span id="shot">Long Description</span>
                       
                        <div class="cont_text_two">
                            <span id="cont_text">
                            	<?php 
								echo $form->input('long_description', array('class'=>'textarea','label'=>false)); 
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
                    
                    <div class="left_butn"><a href="<?php echo $html->url(array('controller'=>'slideshows','action'=>'index'),true); ?>" class="colorbox-slide-larger-photo">EDIT PHOTOS</a></div>
                    
                </div>
            </div>
            <div class="top_left">
                <div class="top_time_head">
                    <span id="res_time">Reservation Times</span>
                </div>
                <div class="content">
                	<div class="pro_time">
                    	<div class="time_start">Start Time :</div>
                        <?php echo $form->input('startTime',array('interval'=>30,'class'=>'pp_time','label'=>false,'type'=>'select','options'=>$options,'selected'=>$this->data['Restaurant']['startTime'])); ?>
                    </div> 
                    <div class="pro_time">
                    <div class="time_start">End Time :</div>
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
                        	<div class="lab_text"><?php echo $form->input('name',array('label'=>'Name:','class'=>'left_text','type'=>'text')); ?></div>
                            <div class="lab_text"><?php echo $form->input('address',array('label'=>'Address:','class'=>'left_text','type'=>'text')); ?></div>
                            <div class="lab_text">
							<?php $city_url = $html->url(array('controller'=>'restaurants', 'action'=>'changeneighboor'),true); ?>
						<?php echo $form->input('city',array('label'=>'City:','class'=>'left_text_sel','type'=>'select','empty'=>'Select city','options'=>$city_name,'onchange' =>'changeneighboor(this.value,"'.$city_url.'");')); ?>
                            </div>
                            <div class="lab_text"><?php echo $form->input('state',array('label'=>'State:','class'=>'left_text','type'=>'text')); ?></div>
                            <div class="lab_text"><?php echo $form->input('phone',array('label'=>'Phone:','class'=>'left_text','type'=>'text')); ?></div>
                            <div class="lab_text"><?php echo $form->input('url',array('label'=>'Url:','class'=>'left_text','type'=>'text')); ?></div>
                            <div class="lab_text" id="neigh"><?php echo $form->input('neighborhoodId',array('label'=>'Neighborhood','type'=>'select','class'=>'left_text_sel','empty'=>'Select neighborhood','options'=>$neighboor_name)); ?></div>
                            <div class="cus_name_select">
                                <label class="cusin" id="cusin_title">Cuisine:</label> 
                                <div class="cus_name">
                                    <fieldset id="field">
                               <?php if(!empty($cuisines)):foreach($cuisines as $cuname): ?>
                                <p style="float:left; width:auto;"><legend><?php echo $cuname.",&nbsp;" ;?> </p>
                                 <?php endforeach; endif; ?>
                                     </legend>
                                     <div class="edit_but">
                                      <?php echo $html->link('EDIT',array('controller'=>'cuisines','action'=>'index'),array('class'=>'colorbox-edit'));?>
                                     </div>
                                     </fieldset>
                                    </div>
                            </div>
                            
                            <div class="check_last"><?php echo $form->input('valet',array('label'=>'Valet:','class'=>'left_check','type'=>'checkbox')); ?></div> 
							<div class="check_last1 lab_text">
                            	<?php //echo $form->input('percentage',array('label'=>'Discount Percentage:','class'=>'left_text','type'=>'text')); ?>
                            </div>
							<?php  echo $form->submit('UPDATE PROFILE',array('class'=>'upload_but','label'=>false)); ?>
                        </div>
                    </div>
                    
                    <div class="right">
                        <?php if(!empty($image_path)){echo $html->image('big/'.$image_path,array('border'=>0,'height'=>199,'width'=>300,'class'=>'pro_logo'));}?>
                        <a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'upload_logo'),true); ?>" class="colorbox-slide-larger"><?php echo $html->image('/images/update_logo.png',array('border'=>0,'class'=>'uplod_butn','id'=>'up_right_but'));?></a>
                    <?php if(isset($menu)){?>
                    <div class="uplod_butn" id="up_right_but3">
                		<a target="_blank" href="<?php echo $this->webroot; ?>img/profilemenu/<?php echo $menu;?>">View/Download The Menu</a>
                    </div>
                    <?php }else{ ?>
                    <div class="uplod_butn" id="up_right_but2">
                		<a target="_blank" href="<?php echo $this->webroot; ?>img/profilemenu/<?php echo $menu;?>">View/Download The Menu</a>
                    </div>	
                    <?php } ?>
                     <a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'uploadmenu'),true); ?>" class="colorbox-slide-larger"><?php echo $html->image('/images/upload_menu.png',array('border'=>0,'class'=>'uplod_butn','id'=>'up_right_but1'));?></a>
                       </div>  
                    <?php echo $form->end(); ?>
                    
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="navi_botom"></div>	
</div>