<style type="text/css">

.pop_slideshowmain .submit{ float:right;padding:0px 0px 0px 0px;margin-top:-31px;}
.upload_but{ margin-top: 30px ; margin-left:131px;}
.loginname1{width: 450px;float: left;margin:5px 0 0 0px;}
.loginname1 label,label{font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	text-align: left;
	color: #535353;
	float: left;
	line-height: 40px;
	width:478px;
}
.loginname1 input{
	width: 300px;
	float: left;
	border: #CFCFCF 1px solid;
	height: 33px;
	margin-left: 24px;}
	.pop_slideshowmain{padding:104px!important;}
.error-message{
	text-indent:138px;
}
.update_a{
            text-decoration: none;
            font-size: 17px;
            font-weight: bold;
            padding: 3px 18px 3px 18px;
            border: 1px solid lightgreen;
            margin: 0px 0px 0px 45px;
            background-color: lightgreen;
            color: green;
            border-radius: 4px;
        }
label{
font-family:Arial;
font-weight:bold;
margin-top:5px;
}
.pop_slideshowmain .test{
padding:0px 0px 0px;
}
.tbl_head1{
float:left;
width:376px;
height:20px;
padding:7px;
text-align:center;
background-color:#3b3b3b;
border:1px solid white;
color:white;
font:bold 14px Arial;
}
.tbl_head2{
float:left;
width:72px;
height:20px;
padding:7px;
text-align:center;
background-color:#3b3b3b;
border:1px solid white;
color:white;
font:bold 14px Arial;
}
.tbl_body1{
float:left;
width:376px;
height:20px;
padding:7px;
border:1px solid #dedede;
}
.tbl_body2{
float:left;
width:72px;
height:20px;
padding:7px;
text-align:center;
border:1px solid #dedede;
}

</style>
<div class="short_back">
    <div class="upload_top">
        <div class="upload_text">
            <h2>Add Email Recipient</h2>
        </div>    
        <div class="pop_up_middle" style="float:right;width:3%; margin-top:5px;">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    </div>
    <div class="pop_slideshowmain" style='padding:61px !important;l'>
        <div class="test">
           <?php echo $form->create('');?> 
            <div class="loginname1">
                <label>Update Email Recipients List</label>
                <?php 
			echo $form->input('Recipient.email',array('type'=>'text','label'=>false,'div'=>false));
		 ?>
            </div>
            <div class="submit padding_class">    
                <?php echo $form->submit('Add',array('class'=>'update_a','label'=>false,'div'=>false));
				  echo $form->end();
				 ?> 
            </div>                
        </div>
 <div class="upload_text">
            <label>Email Recipient List</label>
        </div>
<div style='width:480px;float:left;margin-left:24px;'>
<div style='width:480px;'><div class='tbl_head1'>Recipient Mail</div><div class='tbl_head2'>Action</div></div>
</div>
<div style='width:495px;float:left;margin-left:24px;overflow-x:hidden;overflow-y:auto;height:145px;'>
<?php foreach($recipient as $rec){?>
    <div style='width:480px;'>
    <div class='tbl_body1'><span style='padding-left:20px;'><?php echo $rec['Recipient']['email'];?></span></div>
    <div class='tbl_body2'><a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'remove_email',$rec['Recipient']['id'])); ?>" target="_self">Delete</a> </div>
    </div>         
<?php }?>  
</div>
</div>
<script type='text/javascript'>
$(document).ready(function(){  
$('#RecipientEmail').val('');

});
</script>