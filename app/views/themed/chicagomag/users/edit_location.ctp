<div id="content-header" class="hatched clearfix">
    <ul>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>">My reservation</a></li>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>">Alerts</a></li>
        <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>">History</a></li>
        <li class="on"><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>">My Profile</a></li>
    <ul>
</div>
<div class="popup_min">
<div class="modal-header">
    <h2>Edit Location</h2>
</div><!--/.modal-header-->
<?php echo $form->create('User', array('action' => 'edit_location', 'class' => 'normal'));  ?>
  <?php echo $form->input('id');?>
<div id="modal-payment" class="modal-inner modal-inner-with-header clearfix">
    <div class="spacer">&nbsp;</div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-contact">
    <tbody>
        <tr>
            <td class="label01">Address :</td>
            <td class="input-td">
             <?php echo $form->input('address',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">City :</td>
            <td class="input-td">
               <?php echo $form->input('city',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">State :</td>
            <td>
            <?php echo $form->input('state',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">ZipCode : </td>
            <td>
             <?php echo $form->input('zipcode',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        </tbody>
    </table>		
    <div class="btn-group-right">
        <?php echo $form->submit('Update',array('label'=>false,'div'=>false,'class'=>'btn btn-large btn-success'));?>
        <?php echo $form->button('Cancel',array('type'=>'reset','class'=>'btn btn-large'));?>
    </div>
</div><!-- /.modal-inner -->
<?php echo $form->end(); ?>
</div>