<?php if(!empty($result)){ ?>
  
    <?php 
      // Determine Message
      if(!empty($neighborhood)) 
        foreach($neighborhood as $neigh)
          $message = $neigh['name'];
      if(!empty($cuisine))
        foreach($cuisine as $cui)
          $message = $cui['name'];  
      if(isset($search_all))
        $message = 'Sorry! All tables with this search criteria have been reserved. Please feel free to check out some of our other upcoming reservations below.';?>

    
  <div class="restaurant_list">
    <?php if (isset($message)) { ?>
    <div class="ui warning message">
      <?php echo $message;?>
    </div>
    <?php } ?>
  <div class="grid-padded">
    <div class="grid">
      <?php
        // Neighborhood
        App::import('model','Neighborhood');
        $neighborhood = new Neighborhood;
        $j = 1;
        $avail=1;
        foreach($result as $restaurants){
          // Rest Name
          $restaurant_name = strtoupper($restaurants['Restaurant']['name']);
          $id = $restaurants['Restaurant']['id'];
    			$slug_name = $restaurants['Restaurant']['slug_name'];
    			if(empty($slug_name))
    				$slug_name = $id;
    			/*
$party_size1='';
    			if($avail<=$avail_count){
            $party_size1=1;
          }
*/
      ?>
      <div id="prodcucontainer_<?php echo $id;?>" class="col col-4">
        <?php
          $url = $html->url(array('controller'=>'homes', 'action'=>'details',$slug_name),true);
          $image = $images->find('all',array('conditions'=>array('order_list' => 1, 'restaurant_id'=>$restaurants['Restaurant']['id']),'fields'=>array('path','description')));
        	$image_path = $image[0]['Slideshow']['path'];
        ?>
        <a href="<?php echo $url ?>" onclick="allres_click()">
          <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/original/<?php echo $image_path ?>')">
          </div>
          <span class="name"><?php echo $restaurants['Restaurant']['name']; ?></span>
        </a>
      </div>
      <?php
      if (($j % 3) == 0) {
       ?>
        </div><!-- .grid -->
        <div class="grid">
       <?php
      }
      $j++;
      $avail++;
    } ?>
  </div>
  </div>
  </div>
    
  <?/*
  /// TIME DETAILS
  <?php
    $exact_match=0;
    $count=count($offers)-1;
    $i=0;
    foreach($offers as $offer_time){ 
        $offer = strtotime($offer_time);
        $active = "";
        if(!empty($time_select)&&in_array($time_select,$offers)){
                //$offer=strtotime($time_select);
                //$exact_match=1;
        }
        if(!empty($time_select) && ($offer == strtotime($time_select)))
            $active = 'active';
    ?>
    <?php
    if(($i%4==0) || $i==0)
    echo '<li>';
    $reservation_details = 'party='.$party_size1.'&rest_id='.$id.'&time='.date('g:i',$offer).'&ampm='.date('A',$offer);
    $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true); 
    ?>
    <div class="time3"><a class="reservation_popup <?php echo $active;?>"  href="<?php echo $reservation_url; ?>"><?php echo date('g:i A',$offer); ?></a></div>
    <?php 
    $i++;
    if(($i%4==0) || $i>=count($offers))
    echo '</li>';
    ?>
    <?php //if($exact_match==1)break; ?> 
  <?php  } ?>
  ////////////////
  */
  ?>  
   
<?php } else { ?>
    <div class="bordersearch" id="noresfound">
        <?php  echo "All of today's offerings have now expired! Check below for a fresh batch of restaurants for tomorrow!!!"; ?>
    </div>
<?php } ?>     