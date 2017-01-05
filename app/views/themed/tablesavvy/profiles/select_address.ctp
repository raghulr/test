<script>
function checkAll(){
  var address = $('.checkbox-direction').is(':checked');
  if(address==true){
    document.getElementById('UserSelectAddressForm').submit();
  }else{
    alert("please select any one destination address");
  }
}
</script>
<div class="ui body container directions">
  <div class="ui grid stackable">
    <div class="four wide column">
      <?php echo $this->element('profile_sidebar', array('active' => 'index')); ?>
    </div>
    <div class="twelve wide column">
      <div>
        <div id="content">
          <div class="contact-wrapper reservation-space">
            <h2>Directions From</h2>
            <?php echo $form->create(array('class'=>'ui form')); ?>
              <div class="getdirection-form">
              <ul class="getdirection-check">
                <li>
                  <?php 
                    if(!empty($options)){
                      $attributes=array('legend'=>false);
                      //$//attributes=array('legend'=>false); 
                      echo $form->radio('Userlocation.id',$options,array('legend'=>false,'id' => 'getdirectionval','class'=>'checkbox-direction','separator'=>'<div style="float:left;width:100%;">&nbsp;</div>')); 
                    } else {
                  ?>  
                    <li>
                      <?php 
                        $attributes=array('legend'=>false);
                        echo $form->radio('Userlocation.id',$attributes,array('id' => 'getdirectionval','class'=>'checkbox-direction')); 
                      ?>
                    </li>
                  <?php
                    }
                  ?>
                </li>
              </ul>
            </div>
            <div class="getdirection-centre">
              <?php echo $html->link('Cancel','/profile',array('class'=>'ui button default')); ?>
              <input type="button" class="ui button primary" onclick="checkAll()" value="Get Directions" />
            </div>
          </div>
        <?php echo $form->hidden('transactionId',array('value'=>$transactionId));?>
        <?php echo $form->end(); ?>
      </div>
    </div>
  </div>
</div>