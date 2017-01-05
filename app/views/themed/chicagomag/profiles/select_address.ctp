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
    <h2>Get Directions</h2>
</div><!--/.modal-header-->
<?php echo $form->create(); ?>
<div id="modal-login" class="modal-inner modal-inner-with-header clearfix">    
    <div class="clearfix">
        <p class="label center">
        <?php 
        if(!empty($options)){
            $attributes=array('legend'=>false);
            echo $form->radio('Userlocation.id',$options,$attributes,array('id' => 'getdirectionval')); 
        }else{
            $attributes=array('legend'=>false);
            echo $form->radio('Userlocation.id',$attributes,array('id' => 'getdirectionval')); 
        }
        ?>
        </p> 
    </div>
    <p class="label center">Select a starting point</p>
</div>
<div class="btn-group-wrap">
    <div class="btn-group-center  full-width margin-bottom">
        <a class="btn btn-large btn-success" onclick="document.getElementById('UserSelectAddressForm').submit();">Get Directions</a>
    </div>
</div>
<?php echo $form->hidden('transactionId',array('value'=>$transactionId));?>
<?php echo $form->end(); ?>
</div><!-- /.modal-inner -->