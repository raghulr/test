<style>
.loginname1{
 width:440px;
 float:left;
  margin:26px 0 0 82px; height:50px;}
.loginname1 label{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	text-align:left;
	color:#535353;
	float:left;
	line-height:40px;
	width:113px;
} 	
.loginname1 input{
	width:300px;
	float:right; margin:0px;
	border:#cfcfcf 1px solid;
	height:42px;
}	
.submit{
	margin:28px 0 0 200px !important;
}
.submit1{
	margin:28px 0 0 16px !important;
}

.error-message{ text-indent:145px;}
</style>
<div class="rec_table_back">
<div class="upload_top" style="width:598px;">
	<div class="upload_text">
    	<h2>ADD RESTAURANT</h2>
    </div>    
    <div class="pop_up_middle">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    <div class="up_middle"></div>
</div>
     <div class="recurringdata_new">
                	<?php
						echo $form->create('', array('class' => 'normal')); 
						//echo $form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->Session->read('id')));
						?>
     </div>
    <div class="loginname1">
                        <label>Restaurant name:</label>
                        <?php echo $form->input('Restaurant.name',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
	<div class="loginname1">
                        <label>Email:</label>
                        <?php echo $form->input('User.email',array('type'=>'text','label'=>false,'div'=>false));?>
     </div>
     <div class="loginname1">
                        <label>Password:</label>
                       <?php echo $form->input('User.passwd',array('type'=>'password','label'=>false,'div'=>false));?>
                        <?php echo $form->input('account_type',array('type'=>'hidden','value'=>'2','label'=>false,'div'=>false));?>
     </div>      
   <div style="width:600px;">
    	<div style="width:592px;">
    		<?php 
		   		echo $form->Submit('/images/add_now_03.png'); echo $form->end(); ?></span>
		 <div class="submit1">  
         	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="margin-left:10px;"><?php echo $html->image('/images/cancel.png',array('border'=>0)); ?></a>
          </div>
    	</div>
    </div>
    </div>