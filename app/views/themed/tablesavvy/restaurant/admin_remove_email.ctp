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
}th{
background-color:#3b3b3b;
border-color:white;
font:bold 14px Arial;
color:white;
height:30px;
}
td,th{
border:1px solid #dedede;
}
</style>
<div class="short_back">
    <div class="upload_top">
        <div class="upload_text">
            <h2>Email Recipients</h2>
        </div>    
        <div class="pop_up_middle" style="float:right;width:3%; margin-top:5px;">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    </div>
    <div class="pop_slideshowmain">
<div style='width:460px;'>
<table style='border:1px solid #dedede;border-collapse:collapse;'>
<tr><th>Recipient Mail</th><th style='padding:0px 20px;'>Action</th></tr>
<tbody style='overflow:scroll;'>
<?php foreach($recipient as $rec){?>
<tr><td>
<span style='font-size:18px;font-family:Arial;padding:0px 88px 0px 52px;'><?php echo $rec['Recipient']['email'];?></span></td>

  <td style='padding:0px 20px;'><span><a href="<?php echo $html->url(array('controller'=>'restaurants','action'=>'remove_email',$rec['Recipient']['id'])); ?>" target="_parent">Delete</a> <span></td>
</tr>
          
       <?php }?>   
</tbody>  
</table>

     </div>
</div>