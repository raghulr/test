<style type="text/css">
.profile_photo{height:85px;}
</style>
<ul id="navlist">
	<li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index')); ?></li>
   	<li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
    <li><a href="javascript:;">History</a></li>
    <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile'),array('class'=>'active')); ?></li>
</ul>
<!--<input id="date1" class="date-pick dp-applied" name="date1">-->
<div class="table_container">
	<?php echo $form->create('Restaurant', array('action' => 'profile', 'class' => 'normal ','type' => 'file')); ?>	
    <?php echo $form->input('id'); echo $form->input('short_description',array('type'=>'hidden'));  echo $form->input('long_description',array('type'=>'hidden'));?>
    <div class="inner_table">
    	<div class="profile_left">
            <fieldset class="field">
                <legend>Description</legend>
                <span>Short Description</span>
                <div class="short_discription">
                    <?php if(!empty($this->data['Restaurant']['short_description'])){ echo $this->data['Restaurant']['short_description'];} ?><a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'shortdescription',$id),true); ?>" class="colorbox-slide-larger">Edit</a>
                </div>
                <span>Long Description</span>
                <div class="short_discription">
                    <?php if(!empty($this->data['Restaurant']['long_description'])){ echo $this->data['Restaurant']['long_description'];} ?><a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'longdescription',$id),true); ?>" class="colorbox-slide-larger">Edit</a>
                </div>
            </fieldset>
        </div>
        <div class="profile_right">
        	<fieldset class="field" style="padding-bottom:10px;margin-bottom:10px">
                <legend>Photo</legend>
                <div class="profile_photo"><?php if(!empty($imagelist)): foreach($imagelist as $list): echo $html->image('small/'.$list['Slideshow']['path'],array('border'=>0,'height'=>85)); endforeach; endif;?></div>
                <div class="priview">
                	<a href="#">Preview SlideShow</a><br /><br />

                    <a href="<?php echo $html->url(array('controller'=>'slideshows','action'=>'index'),true); ?>" class="colorbox-slide-larger">Edit Photo</a>
                </div>
                <div class="privNext" style="width:100%;float:left;padding:20px 0;">
                	<a href="#" id="prev"> &laquo; previous</a> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="next">Next &raquo;</a> 
                </div>
            </fieldset>
            <fieldset class="field" id="times" style="padding-bottom:10px;margin-bottom:10px">
                <legend>Reservation Times</legend>
                <?php echo $form->input('startTime',array('label'=>'Start : ','interval'=>30)); ?>
                <?php echo $form->input('endTime',array('label'=>'End : ', 'interval'=>30)); ?>
            </fieldset>
        </div>
        <div class="profile_details">        	
        	<fieldset class="field">
        		<legend>Restaurant Details</legend>
                <div class="details">
                	<?php echo $form->input('Restaurant.name',array('label'=>'Name : ')); ?>
                    <?php echo $form->input('address',array('label'=>'Address : ')); ?>
                    <?php echo $form->input('city',array('label'=>'City : ')); ?>
                    <?php echo $form->input('state',array('label'=>'State : ')); ?>
                    <?php echo $form->input('zipcode',array('label'=>'Zip : ')); ?>
                    <?php echo $form->input('website',array('label'=>'URL : ')); ?>
                </div>
                <div class="neighbor">
                	<div id="neighborhood"><?php echo $form->input('Neighborhood.id',array('label'=>'Neighborhood','options'=>$neighborhood)); ?></div>
                    <label>Cuisine:</label> <span>Asian,Sushi</span> 
					<?php echo $html->link('Edit',array('controller'=>'cuisines','action'=>'index'),array('class'=>'colorbox-min'));?>
                    <?php echo $form->input('avgPrice',array('label'=>'Average Price : ')); ?>
                    <div style="float:left"><?php echo $html->link('Add New Neighborhood',array('controller'=>'neighborhoods','action'=>'add'),array('class'=>'colorbox-min'));?></div>
                </div>
                <div class="logo">
                	<fieldset class="field">
        				<legend>Logo</legend>
                         <?php echo $form->file('file',array('size'=>5,'label'=>false)); ?>
                    </fieldset>
                </div>
            </fieldset> 
        </div>
    </div>
    <?php echo $form->end('Update Profile'); ?>
</div>