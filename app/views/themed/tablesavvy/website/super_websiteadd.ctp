<div class="pop_slideshowmain">
<div class="upload_top" style="width:100%;">
	<div class="upload_text">
    	<h2>Add Website</h2>
    </div>    
    <div class="up_middle"></div>
</div>
     <div class="recurringdata_new">
                	<?php
						echo $form->create('Website', array('class' => 'normal','enctype' => 'multipart/form-data')); 
						?>
     </div>
    <div class="loginname">
                        <label>Website Name</label>
                        <?php echo $form->input('website_name',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
	<div class="loginname">
                        <label>Facebook App Id</label>
                        <?php echo $form->input('fb_app_id',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
     <div class="loginname">
                        <label>Facebook Secret Key</label>
                        <?php echo $form->input('fb_app_secret_key',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
       <div class="loginname">
                        <label>Facebook Page Url</label>
                        <?php echo $form->input('fb_url',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
       <div class="loginname">
                        <label>Twitter Page Url</label>
                        <?php echo $form->input('twitter_url',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
     <div class="loginname">
                        <label>Website Logo</label>
                        <?php echo $form->input('website_logo',array('type'=>'file','label'=>false,'div'=>false));?>
     </div>
     <div class="loginname">
                        <label>Email Logo</label>
                        <?php echo $form->input('email_logo',array('type'=>'file','label'=>false,'div'=>false));?>
     </div>     
   <div>
    	<div>
    		<?php 
		   		echo $form->Submit('/images/add_now_03.png'); echo $form->end(); ?></span>
		 <div class="submit1">  
         	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="margin-left:10px;"><?php echo $html->image('/images/cancel.png',array('border'=>0)); ?></a>
          </div>
    	</div>
    </div>
    </div>