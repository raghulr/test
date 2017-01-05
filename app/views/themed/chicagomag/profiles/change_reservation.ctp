
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
<h2>Change Reservation</h2>
</div><!--/.modal-header-->
<?php echo $form->create(); ?>
<div id="modal-payment" class="modal-inner modal-inner-with-header clearfix">
    <h4><?php echo $restaurant['Restaurant']['name']; ?></h4>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
        	<tr valign="top" align="center">
                <td class="label02" style="font-weight: normal; text-align:center; padding:12px 6px 0 80px;">Current Time:</td>
                
                <td class="label01"><?php echo $time;?></td>
            </tr>
            <tr valign="top" align="center">
                <td class="label02" style="font-weight: normal; paddding-left:60px;">Current Party Size:</td>
                 
            <td class="label01"><?php echo $reservedsize;?></td>
            </tr>
            <tr valign="top" align="center">
           		<td class="label02" style="font-weight: normal; padding:12px 6px 0 57px;">Please change to:</td>
                 
                <td class="label01" style="padding:8px 10px 0 0;">
                            <?php
                            $submit_form = 0;
                            $change_url = $html->url(array(
                                'controller'=>'profiles',
                                'action'=>'change_size',
                                $restaurant['Restaurant']['id']
                            ));
                            if(!empty($size))
                                echo $form->input('size',array(
                                    'label'=>false,
                                    'id'=>'change',
                                    'class'=>'select_box',
                                    'type'=>'select',
                                    'options'=>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8'),
                                    'selected'=>$size,
                                    'onchange' => 'getpartysize()'
                                )); 
                            ?>
                       
                            <?php 
                            echo $form->input('Offer.time',array('type'=>'hidden','value'=>$time)); 
                            if(!empty($reservation_time)) {
                                $originl_time = array();
                                foreach($reservation_time as $offders_id=>$offers_time){
                                        $select_time = strtotime($offers_time);
                                        $originl_time[$offders_id] = date('h:i a',$select_time);
                                }
                                echo $form->input('time',array(
                                    'label'=>false,
                                    'id'=>'HomeChangeTime',
                                    'class'=>'select_box',
                                    'type'=>'select',
                                    'options'=>array($originl_time),
                                    'selected'=>'select'
                                ));         
                                $submit_form = 1;
                            } else {
                                $submit_form = 0;
                                echo '<p>No times available</p>'; 
                            }    
                            echo $form->input('Restaurant.id',array('type'=>'hidden','value'=>$restaurant['Restaurant']['id'])); 
                            echo $form->input('Offer.id',array('type'=>'hidden','value'=>$offer_id)); 
                            echo $form->input('Reservation.id',array('type'=>'hidden','value'=>$reservation_id)); 
                            echo $form->input('Offer.reserved_size',array('type'=>'hidden','value'=>$reservedsize));
                            echo $form->input('save_offer',array('type'=>'text','label'=>false,'value'=>$submit_form, 'style'=>'display:none'));
                            ?>
                        </td>
            </tr>
            <!--<tr valign="top" align="left">
                <td class="label03" colspan="2">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="width: 280px">
                        <tr>
                            
                        </tr>
                    </table>
                </td>
            </tr>-->
        </tbody>
    </table>
    <div class="btn-group-wrap-top">
        <div class="btn-group-center">
            <?php if($submit_form==0): ?>
            <a class="btn-success button-width btn"><strong>Confirm</strong></a>
            <?php else:?>
            <a class="btn-success button-width btn" onclick="save_reservation()"><strong>Confirm</strong></a>
            <?php endif; ?>
        </div>
    </div>
</div><!-- /.modal-inner -->
<?php echo $form->end(); ?>
</div>