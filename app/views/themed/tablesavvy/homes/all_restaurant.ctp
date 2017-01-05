<?php if ($ajaxcall==false): ?>
<div class="feature rm_champ page_header">
  <div>
    <h1>Make a reservation</h1>
    <?php echo $this->element('search_form');?>
  </div>
</div>
<div class="ui loading dimmer">
  <div class="ui text loader">Loading</div>
</div>
<div id="rest_search">
  <?php endif ?>
  <input type="hidden" id="curr_url" value=''>
  <div class="restaurant_list">
    <?php if (isset($url_params['time']) && isset($url_params['ampm'])) { ?>
      <h2>Tables at <?php echo $url_params['time']." ".$url_params['ampm']; ?> <a href="/all_restaurant" style="float: right; font-size: 50%">Clear selection and see all</a></h2>
    <?php } ?>
    <?php if(!empty($restaurant_detail)){ ?>
    <div class="grid-padded">
    <div class="grid">
        <?php
        // Neighborhood
        App::import('model','Neighborhood');
        $neighborhood = new Neighborhood;
        //pr($restaurant_detail);
        $j = 1;
        $avail=1;
        $rest_cnt = count($restaurant_detail);
        foreach($restaurant_detail as $restaurants){
          // Rest Name
          $restaurant_name = strtoupper($restaurants['Restaurant']['name']);
          $id = $restaurants['Restaurant']['id'];
    			$slug_name = $restaurants['Restaurant']['slug_name'];
    			if(empty($slug_name))
    				$slug_name = $id;
    			//$timeAvailability=array();
    			//$timeAvailability=$restaurant->Restaurant->tableAvailability($id);
    			$party_size1='';
    			if($avail<=$avail_count){
            $party_size1=1;
    			}
		?>
      <div id="prodcucontainer_<?php echo $id;?>" class="col col-4">
        <?php
            $url = $html->url(array('controller'=>'homes', 'action'=>'details',$slug_name),true);
            $image = $images->find('all',array('conditions'=>array('restaurant_id'=>$restaurants['Restaurant']['id'], 'order_list' => 1),'fields'=>array('path','description')));
          	$image_path = $image[0]['Slideshow']['path'];
        ?>
          <a href="<?php echo $url ?>" onclick="allres_click()">
            <?php if((($j % 3) == 1) && ($rest_cnt == $j)) { ?>
                <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/big/<?php echo $image_path ?>')"></div>
            <?php } else if(((($j % 3) > 1) && ($rest_cnt == $j)) || (((($j % 3) != 0) && ($rest_cnt % 2) == 0) && (($rest_cnt-1) == $j))) { ?>
                <?php if(($rest_cnt % 3) == 0){ ?>
                    <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $image_path ?>')"></div>
                <?php } else{ ?>
                    <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/medium/<?php echo $image_path ?>')"></div>
                <?php }?>
            <?php } else { ?>
                <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $image_path ?>')"></div>
            <?php } ?>
            <span class="name"><?php echo $restaurants['Restaurant']['name']; ?></span>
          </a>
        </div>
        <?php if (($j % 3) == 0) {   ?>
          </div><!-- .grid -->
          <div class="grid">
         <?php
        }
        $j++;
        $avail++;
        }
        ?>
    </div>
    <?php }
	$restaurant_url = $html->url(array('controller'=>'chicagomag'),true);
	?>
    </div>
  </div>
</div>

<?php if ($ajaxcall==false): ?>
<script>
    function allres_click(){
    }
</script>
<?php endif ?>
<script>
        // Set pixelRatio to 1 if the browser doesn't offer it up.
        var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
         
        // Rather than waiting for document ready, where the images
        // have already loaded, we'll jump in as soon as possible.
        $(document).ready(function() {
            if (pixelRatio > 1) {
                $('.restaurant_list .col .over').each(function() {
                    var tmp = $(this).attr('style');
                    tmp = tmp.replace(".jpg","@2x.jpg");
                    tmp = tmp.replace(".JPG","@2x.JPG");
                    tmp = tmp.replace(".png","@2x.png");
                    // Very naive replacement that assumes no dots in file names.
                    $(this).attr('style', tmp);
                });
            }
        });
</script>