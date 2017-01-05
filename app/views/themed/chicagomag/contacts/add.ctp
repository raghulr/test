<div class="popup_min">
<div class="modal-header">
    <h2>Contact Us</h2>
</div><!--/.modal-header-->
<?php echo $form->create('Contact', array('action' => 'add', 'class' => 'normal ','type' => 'file')); ?>
<div id="modal-payment" class="modal-inner modal-inner-with-header clearfix">
    <p class="contact-hd">Have a question that isn't answered on our FAQ page? 
    A suggestion? We'd love to hear from you! </p>
    <div class="spacer">&nbsp;</div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-contact">
    <tbody>
        <tr>
            <td class="label01">Your Name :</td>
            <td class="input-td">
            <?php echo $form->input('name',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Contact type :</td>
            <td>
                <?php echo $form->input('contact',array(
                    'type'=>'select',
                    'selected'=>$inquiries,
                    'label'=>false,
                    'class'=>'input1',
                    'options'=>array('General'=>'General','Support'=>'Support','Restaurant Inquiries'=>'Restaurant Inquiries')
                    ));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Your Email :</td>
            <td>
            <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
            </td>
        </tr>
        <tr>
            <td class="label01">Comment :</td>
            <td>
            <?php echo $form->input('comment',array('type'=>'textarea','class'=>'textarea', 'label'=>false,'div'=>false));?>
            </td>
        </tr>
        </tbody>
    </table>		
    <div class="btn-group-right">
        <a class="btn btn-large btn-success" onclick="document.getElementById('ContactAddForm').submit();">Submit</a>
        <a class="btn btn-large" onclick="parent.jQuery.colorbox.close(); return true;">Cancel</a>
    </div>
</div><!-- /.modal-inner -->
<?php echo $form->end(); ?>
</div>