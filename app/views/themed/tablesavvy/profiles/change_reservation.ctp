<div class="ui body container">
  <div class="ui grid stackable">
    <div class="four wide column">
      <?php echo $this->element('profile_sidebar', array('active' => 'index')); ?>
    </div>

    <div class="twelve wide column">
      <div>
        <div id="content">
          <!--Change Reservation-->

          <div class="contact-wrapper">
            <h2>
              Change Reservation
            </h2>
            <?php echo $form->create(); ?>

            <div class="change-reservation">
              <h4><?php echo $restaurant['Restaurant']['name']; ?></h4>

              <label class="label-change-reserv">Current Time:</label>

              <label class="label-change-reserv">Current party size:</label>

              <div class="change-right">
                <p><?php echo $reservedsize;?></p>

                <div class="spacer"></div>
              </div>

              <div class="gap02">
                &nbsp;
              </div><label class="label-change-reserv">Please change
              to:</label>

              <div class="change-right">
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
                          'class'=>'select-reservation02',
                          'type'=>'select',
                          'options'=>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8'),
                          'selected'=>$size,
                          'onchange' => 'getpartysize()'
                      )); 
                  ?><?php 
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
                          'class'=>'select-reservation',
                          'type'=>'select',
                          'options'=>array($originl_time),
                          'selected'=>'select'
                      ));         
                      $submit_form = 1;
                  } else {
                      $submit_form = 0;
                      echo '<div class="text-change-wrapper">No times available</div>'; 
                  }    
                  echo $form->input('Restaurant.id',array('type'=>'hidden','value'=>$restaurant['Restaurant']['id'])); 
                  echo $form->input('Offer.id',array('type'=>'hidden','value'=>$offer_id)); 
                  echo $form->input('Reservation.id',array('type'=>'hidden','value'=>$reservation_id)); 
                  echo $form->input('Offer.reserved_size',array('type'=>'hidden','value'=>$reservedsize));
                  echo $form->input('save_offer',array('type'=>'text','label'=>false,'value'=>$submit_form, 'style'=>'display:none'));
                  ?>

              </div>

              <?php if($submit_form==0): ?>
              <input class="ui button primary" type="button" value="Confirm">
              <?php else:?> 
              <input class="ui button primary" onclick="save_reservation()" type="button" value="Confirm"> 
              <?php endif; ?>
              <?php echo $html->link('Back','/profile',array('class'=>'button-confirm button-hover button-hover_text')); ?>

              <div class="spacer"></div>
            </div>

            <div class="spacer"></div>
          </div>

          <div class="spacer"></div><?php echo $form->end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>