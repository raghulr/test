<style type="text/css">
.submit{ float:left;}
.upload_but{ margin-top: 30px ; margin-left:131px;}
.loginname1{width: 450px;float: left;margin:5px 0 0 0px;}
.loginname1 label{font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	text-align: left;
	color: #535353;
	float: left;
	line-height: 40px;
	width:114px;
}
.loginname1 input{
	width: 300px;
	float: left;
	border: #CFCFCF 1px solid;
	height: 42px;
	margin-left: 24px;}
	.pop_slideshowmain{padding:104px!important;}
.error-message{
	text-indent:138px;
}
</style>
<div class="short_back">
    <div class="upload_top">
        <div class="upload_text">
            <h2>Update Email Address</h2>
        </div>    
        <div class="pop_up_middle" style="float:right;width:3%; margin-top:5px;">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    </div>
    <div class="pop_slideshowmain">
        <div class="test">
           <?php echo $form->create(''); 
	  echo $form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->Session->read('user_id')));
?>
            <div class="loginname1">
                <label>Update Email</label>
                <?php if(!empty($user_email))
				echo $form->input('User.email',array('type'=>'text','label'=>false,'div'=>false,'value'=>''));
				else
				echo $form->input('User.email',array('type'=>'text','label'=>false,'div'=>false));
		 ?>
            </div>
             <div class="loginname1">
               <label>Password</label>
                <?php echo $form->input('User.passwd',array('type'=>'password','label'=>false,'div'=>false)); ?>
            </div>
            <div class="submit padding_class">    
                <?php echo $form->submit('',array('class'=>'upload_but ie_edit','label'=>false,'div'=>false));
				  echo $form->end();
				 ?> 
            </div>  
            <div class="submit padding_class"> 
                    <a href="#" onclick="parent.$.colorbox.close(); return true;" style="margin-left:10px;float:left;margin-top:34px;" class="ie_edit_a"><?php echo $html->image('/images/cancel.png',array('border'=>0)); ?></a>
                </div>    
        </div>
     </div>
</div>