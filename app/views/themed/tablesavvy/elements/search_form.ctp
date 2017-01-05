<?php
  $url = $html->url(array('controller'=>'homes', 'action'=>'select_search'),true);
  $neighborhood_id = '';
  $cuisine_id = '';
  $time_select = '';
  $party_size = '';
  $party_sizes = array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8')
?>

<div class="contentcontainer clearfix" id="contentcontainer">
    <div class="ui form" id="content_search">
      <?php echo $form->create('Home',array('action'=>'select_search')); ?>
      <div class="four fields">
        <div class="field">
          <label>Neighborhood</label>
            <?php
							$setdisable='';
							if(isset($disabled)){
								$setdisable='disabled';
							}
              echo $form->input('Restaurant.neighborhoodId',array(
                'label'=>false,
                'class'=>'ui search fluid dropdown',
                'type'=>'select',
                'options'=>array($neighbor_list),
                'empty'=>'Any',
                'id'=>'neighborhood_id',
                'selected'=>$neighborhood_id,
  							'disabled'=>$setdisable
              ));
            ?>
        </div>
        <div class="field">
          <label>Time</label>
          <?php
              if (isset($url_params['time']) && isset($url_params['ampm'])) {
                $time = $url_params['time']." ".$url_params['ampm']; 
              } else {
                $time = 'Any';
              }
              echo $time_select;
              echo $form->input('Offer.offerTime',array(
                'label'=>false,
                'class'=>'ui search fluid dropdown',
                'type'=>'select',
                'label'=>false,
                'options'=>$options,
                'id'=>'time_id',
                'empty'=> $time,
                'selected'=>$time_select,
                'disabled'=>$setdisable
              ));
          ?>
          </div>
          <div class="field">
              <label>Cuisine</label>
              <?php echo $form->input('Restaurantcuisine.cuisine_id',array(
                'label'=>false,
                'class'=>'ui search fluid dropdown',
                'type'=>'select',
                'options'=>array($cuisine_list),
                'id'=>'cuisine_id',
                'empty'=>'Any',
                'selected'=>$cuisine_id,
  							'disabled'=>$setdisable
              )); ?>
          </div>
          <div class="field">
            <label>People</label>
            <?php
              echo $form->input('Offer.seating',array(
                'label'=>false,
                'id'=>'change',
                'class'=>'ui search fluid dropdown',
                'type'=>'select',
                'label'=>false,
                'options'=>$party_sizes,
                'empty'=>'Any',
                'id'=>'party_id',
                'selected'=>$party_size,
                'disabled'=>$setdisable
              ));
            ?>
          </div>
        </div>
        <?php echo $form->end(); ?>
      </div><!-- /.ui.form -->


        <?php /*
        <div class="or"><div>or</div></div>
        <div class="spacer">&nbsp;</div>
        <div class="search" id="search">
            <span>Search by restaurant name</span>
			<?php //echo $form->create('Home'); ?>
             <div class="ui-widget">
                <input type="text" class="input-text" onkeydown="auto_complete(this.value)" id="HomeSearch">
              </div>
                <!--<div class="auto_response" id="auto_complete_response"></div>-->
                <?php $url = $html->url(array('controller'=>'homes', 'action'=>'details'),true);?>
                 <input type="hidden" onclick="res_name()" value="<?php echo $url; ?>" id="auto_ser">
                <div class="search_btn">
                  <input type="button" onclick="res_name()" value="" id="ajax_submit">
                </div>
            <?php //echo $form->end();?>
        </div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'auto_complete'),true);?>
        <div id="auto_complete_url" style="display: none;"><?php echo $url;?></div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'details'),true);?>
        <div id="auto_red_url" style="display: none;"><?php echo $url;?></div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'auto_com_red'),true);?>
        <div id="auto_comp_res_url" style="display: none;"><?php echo $url;?></div>
        <?php $res_url = $html->url(array('controller'=>'homes', 'action'=>'search'),true);?>
        <div id="res_url" style="display: none;"><?php echo $res_url;?></div>
    </div>
    */?>
</div>
<div class="more-spacer">&nbsp;</div>
