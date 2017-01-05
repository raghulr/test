<style>
body {
    margin: 5px;
}
.contactcontainer {
    width: 596px;
}
</style>
<script type="text/javascript">
function validate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   return reg.test(email);
   alert(reg.test(email));
}

function trim(str){
	var	str = str.replace(/^\s\s*/,''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

function checkAll(){
	//var status = true;
	var i = 0;
	var emails = document.getElementById('mail').value.split(",");
	for(i=0; i<emails.length; i++){
		if(!validate(trim(emails[i]))){			
			alert("Please enter valid email: "+emails[i]);
			return false;
			break;
		}
	}
	return true;
}
</script>
<div id="content-header" class="hatched clearfix">
    <ul>
        <li class="on"><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>">My reservation</a></li>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>">Alerts</a></li>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>">History</a></li>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>">My Profile</a></li>
    <ul>
</div>
<div class="popup_min">
<div class="modal-header">
<h2>Send Invitations to Your Friends</h2>
</div><!--/.modal-header-->
<?php echo $form->create('User', array('controller'=>'profiles','action' => 'send','onsubmit'=>'return checkAll()')); ?>
<div id="modal-payment" class="modal-inner modal-inner-with-header clearfix">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-contact">
    <tbody>
        <tr>
            <td class="label01">Sender Name :</td>
            <td class="input-td">
            <?php foreach($sender as $send) ?>
            <?php echo $form->input('name',array('type'=>'text','value'=>$send['User']['firstName'],'label'=>false,'div'=>false,'readonly' => 'readonly'));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Sender Email :</td>
            <td>
            <?php foreach($sender as $send) ?>    
            <?php echo $form->input('senderemail',array('type'=>'text','value'=>$send['User']['email'],'label'=>false,'div'=>false,'readonly' => 'readonly'));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Receiver Email :</td>
            <td>
            <?php echo $form->input('receiveremail',array('type'=>'text','id'=>'mail','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Subject :</td>
            <td>
            <?php echo $form->input('subject',array('type'=>'text','value'=>$subject,'label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Content :</td>
            <td>
            <?php if(empty($transactionId)) 
                    $transactionId ='';
                echo $form->hidden('transactionId',array('value'=>$transactionId));
            ?>    
            <?php echo $form->input('content1',array('type'=>'textarea','label'=>false, 'class'=>'textarea', 'div'=>false));?>   
            </td>
        </tr>
    </tbody>
    </table>
    <div class="btn-group-right">
        <?php echo $form->submit('Submit',array('label'=>false,'div'=>false,'class'=>'btn btn-large btn-success'));?>
        <?php echo $form->button('Cancel',array('type'=>'reset','class'=>'btn btn-large'));?>
    </div>
    <?php echo $form->end(); ?>
</div><!-- /.modal-inner -->
</div>
