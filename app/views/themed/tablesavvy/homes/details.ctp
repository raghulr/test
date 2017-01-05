<?php
				App::import('model','Neighborhood');
				$neighborhood = new Neighborhood;
				App::import('Component','Images');
                $Images_thumb = new ImagesComponent;
                $Images_thumb->set_paths(WWW_ROOT . 'img/original/', WWW_ROOT . 'img/medium/');
                $Images_thumb->width=268;
                $Images_thumb->height=172;
				$k=1;
				//echo $rest_detail[0]['Restaurant']['neighborhoodId'];die;
				$neighborhoods= $neighborhood->findById($rest_detail[0]['Restaurant']['neighborhoodId']);
				//print_r($neighborhoods);die;
	/*  var_dump($rest_detail[0]['Restaurant']['name'],$rest_detail[0]['Restaurant']['id'],$rest_detail[0]['Restaurant']['long_description']);

		die; */
?>
<section class="main restaurant">
	<article>
  	<div class="banner" style="background-image:url('/img/big/<?php echo $image['path'];?>')">
    </div>

		<div class="rest_info">
			<div class="inner ui middle aligned stackable grid">
			  <div class="eight wide column">
			    <div class="ui grid">
    				<div class="five wide column">
    					<div class="logo" style="background-image:url('/img/original/<?php echo $rest_detail[0]['Restaurant']['logo']; ?>')"></div>
    				</div>
    				<div class="eleven wide column">
    					<div class="info">
    						<span class="title">
    							<h2><?php echo $rest_detail[0]['Restaurant']['name']; ?></h2><span class="neighborhood"><?php echo $neighborhoods['Neighborhood']['name']; ?></span>
    						</span>
    						<p><?php echo $rest_detail[0]['Restaurant']['short_description']; ?></p>
    					</div>
    				</div>
          </div>
			  </div>
				<div class="seven wide column">
					<div class="filter_options ui segment">
  					<div class="ui dimmer">
              <div class="ui text mini loader">Searching Availability</div>
            </div>
						<h3><i class="icon bookmark"></i> Reserve your table, <strong>Save 30% Tonight</strong></h3>
						<?php
							echo $this->Form->create(null, array('url' => array('controller' => 'homes', 'action' => 'reservation'),'type'=>'get', 'class' => 'ui form'));
							$id = $rest_detail[0]['Restaurant']['id'];
             	$detail_url = $html->url(array('controller'=>'homes','action'=>'getsize',$id));
              $timeAvailability1=array();
    					$timeAvailability1=$restaurant->Restaurant->tableAvailability($id);
    					$party_size1='';
    					if(!empty( $timeAvailability1)){
    						$availabilityTime=array();
    						foreach($timeAvailability1 as $party_sizes=>$offers)
    							$party_size1 = $party_sizes;
    					}

    					if(empty($party_size))
    						$party_size=$party_size1;

							//var_dump($detail_url,$restaurant->Restaurant->tableAvailability($id,$party_size),'**********');die;
							$timeAvailability = $restaurant->Restaurant->tableAvailability($id,$party_size);
							if(!empty($timeAvailability)){
						?>
		        <div class="three fields">
							<div class="field" id="party_size">
								<?php echo $form->input('party',array('label'=>false, 'class' => 'ui search fluid dropdown','id'=>'change_party_size','type'=>'select','label'=>false,'options'=>array(2=>'2 people',3=>'3 people',4=>'4 people',5=>'5 people',6=>'6 people',7=>'7 people',8=>'8 people'),'selected'=>$party_size,'data-url'=>$detail_url)); ?>
							</div>
			        <div class="field" id="timeAvailability">
			          <?php
									foreach($timeAvailability as $party_sizes=>$offers)

										$party_size = !empty($party_size)?$party_size:$party_sizes;
				            asort($offers);	//var_dump($offers);die;
				            $i=0;
				            $timeArray = array();
										foreach($offers as $offer_time){
											$timeArray[date('h:i',strtotime($offer_time))] = date('h:i A',strtotime($offer_time));
										}

										echo $this->Form->input('time',array('class' => 'ui search fluid dropdown restaurant_time', 'options' =>$timeArray,'label'=>false, 'div'=>false ));

										// get the first offer time
										$offer = strtotime(array_shift(array_slice($offers, 0, 1)));

			              //$reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('h:i',$offer).'&ampm='.date('A',$offer);
			              //$reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true);
				          ?>
									<input name="rest_id" value="<?php echo $id?>" id="time" type="hidden">
									<input name="ampm" value="<?php echo date('A',$offer);?>" id="ampm" type="hidden">
			        </div>
							<div class="field">
									<?php echo $this->Form->submit('Reserve', array('div'=>false, 'class' => 'ui button fluid primary', 'title' => 'Reserve'));?>
							</div>
						</div>
						<?php echo $this->Form->end(); }else{ ?>
						  <div id="change_size"></div>
							<div class="field no-seats">No seats available</div>
						<?php }?>
		      </div>
				</div>
			</div>
		</div>
  		  <div class="content-block-map-img"></div>
    <div class="quick_reserve">
				<div class="about">
					<div class="ui grid stackable">
							<div class="ten wide column">
								<h3>About <?php echo filter_var($rest_detail[0]['Restaurant']['name'], FILTER_SANITIZE_SPECIAL_CHARS); ?></h3>
								<p><?php echo nl2br($rest_detail[0]['Restaurant']['long_description']); ?></p>
							</div>
						<div class="six wide column more_info">
								<h3>Additional Info</h3>
								<p class="hours">OPEN <?php echo date('h:i A',strtotime($rest_detail[0]['Restaurant']['startTime'])).' TO '.date('h:i A',strtotime($rest_detail[0]['Restaurant']['endTime'])) ?></p>
								<p class="data">
		               <?php
		                if(!empty($rest_detail[0]['Restaurant']['address'])):
		                    $city_id = $rest_detail[0]['Restaurant']['city'];
		                    $state=!empty($rest_detail[0]['Restaurant']['state'])?', '.$rest_detail[0]['Restaurant']['state']:'';
		                    $row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
		                    $city_name= $row['city_name'];
		                    echo $rest_detail[0]['Restaurant']['address'].',<br/>';
		                    ?>
		                    <?php echo $city_name;?>
		                    <?php echo strtoupper($state);
		                            $addr = $rest_detail[0]['Restaurant']['address'].','.$city_name.','.strtoupper($state).','.'US';
		                        echo $form->hidden('address',array('value'=>$addr,'name'=>'address','id'=>'address'));
		                endif;
		                $phone_number = '';
		                $phone = $rest_detail[0]['Restaurant']['phone'];
		                $phone = str_replace('(', '', $phone);
		                $phone = str_replace(')', '', $phone);
		                $phone = str_replace('-', '', $phone);
		                $phone = str_replace(' ', '', $phone);
		                $phone_number .= '('.substr($phone,0,3).')';
		                $phone_number .= '-'. substr($phone,3,3).'-';
		                $phone_number .= substr($phone,6,4);
		                echo '<br/>'.$phone_number;
		               ?>
		            </p>
								<p>
									<?php 
  									if(!empty($rest_detail[0]['Restaurant']['url'])): 
              				$resurl = parse_url($rest_detail[0]['Restaurant']['url']);
              				if(!empty($resurl['scheme'])&&!empty($resurl['host'])) {
              					$rest_url = $resurl['scheme'].'://'.$resurl['host'];
              					if (isset($resurl['path'])) {
                					$rest_url = $rest_url.$resurl['path'];
              					}
              				}
              				if(!in_array("http", $resurl)) {
              					$rest_url = "http://".$resurl['path'];
              				}
            			?>
									<a class="ui button inverted" href="<?php echo $rest_url;?>" target="_blank">Website</a>
									<?php endif;?> 
									<?php if(isset($menu)){ ?>
									  <a class="ui button inverted" href="<?php echo $this->webroot; ?>img/profilemenu/<?php echo $menu;?>" target="_blank" >Menu</a>
									<?php } else if(!empty($rest_detail[0]['Restaurant']['menu_link'])){
          				  $resurl = parse_url($rest_detail[0]['Restaurant']['menu_link']);
            				if(!empty($resurl['scheme'])&&!empty($resurl['host']))
            				  $rest_url = $resurl['scheme'].'://'.$resurl['host'].$resurl['path'];
            				if(!in_array("http", $resurl)) {
            				  $rest_url = "https://".$resurl['path'];
                    }
          				?>
                    <a class="ui button inverted" target="_blank" href="<?php echo $rest_url;?>">Menu</a>
                  <?php }?>      
								</p>
								<?php /*
								<ul>
									<li>
										<span class="label">Neighborhood</span>
										<span class="value"><?php echo $neighborhoods['Neighborhood']['name']; ?></span>
									</li>
									<li>
										<span class="label">Take-out</span>
										<span class="value">Yes</span>
									</li>
									<li>
										<span class="label">Accepts Credit Cards</span>
										<span class="value">Yes</span>
									</li>
									<li>
										<span class="label">Good For Dinner</span>
										<span class="value">Yes</span>
									</li>
								</ul>
								*/?>
						</div>
					</div>
				</div>
    	</div>
    </div>
	</div>
</article>
</section>
   <script>
        // Set pixelRatio to 1 if the browser doesn't offer it up.
        var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
         
        // Rather than waiting for document ready, where the images
        // have already loaded, we'll jump in as soon as possible.
        $(document).ready(function() {
            if (pixelRatio > 1) {
                var tmp = $('.banner').attr('style');
                tmp = tmp.replace(".jpg","@2x.jpg");
                tmp = tmp.replace(".JPG","@2x.JPG");
                tmp = tmp.replace(".png","@2x.png");
                $('.banner').attr('style', tmp);
            }
        });
</script>
<style type="text/css">
  
/*
//maps.google.com/maps/api/staticmap?
center=25.7924630%2C-80.135621
&size=772x136
&zoom=15&scale=2&maptype=roadmap&format=jpg
&markers=icon%3Ahttp%3A%2F%2Fmedia.otstatic.com%2Fimg%2Fmap-marker-blue-1ee72fb9a8c7f8afbf74899c1052924f.png%7C25.7924630%2C-80.1306210
&sensor=false
&style=feature:landscape|element:all|hue:0xe5e1df|saturation:-62|lightness:0|visibility:on
&style=feature:poi.school|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:poi.medical|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:poi.attraction|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:poi.government|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:poi.place_of_worship|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:administrative.locality|element:all|hue:0xffffff|saturation:0|lightness:100|visibility:off
&style=feature:road.local|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:poi.business|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off
&style=feature:water|element:geometry|hue:0x82b4ff|saturation:100|lightness:-1|visibility:on
&style=feature:road.highway|element:geometry|hue:0xfcb04d|saturation:-3|lightness:1|visibility:simplified
&style=feature:poi.park|element:all|hue:0xc9e3a8|saturation:15|lightness:-1|visibility:on
&channel=opentable-restprofile
&signature=0565UD2rosLYa9sh9eY_zXjmuaA=


http://maps.googleapis.com/maps/api/staticmap?
  center=Brooklyn+Bridge,New+York,NY
  &zoom=14&size=512x512&maptype=roadmap
  &markers=color:blue%7Clabel:S%7C40.702147,-74.015794
  &markers=color:green%7Clabel:G%7C40.711614,-74.012318
  &markers=color:red%7Ccolor:red%7Clabel:C%7C40.718217,-73.998284
  &sensor=false
  &key=AIzaSyDCyBF1hBPKOnlmVKH3nS7rWBIixTRUWLw
*/

.content-block-map-img {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  width: 100%;
  max-width: 955px;
  margin: 0px auto 10px;
  height: 0;
  border-radius: 0 0 5px 5px;
}
@media(min-width: 641px) {
  /* place?q=Nellcôte,+West+Randolph+Street,+Chicago,+IL,+United+States&key=AIzaSyC-AoUreetWa_6bxdO680g6r7XJ_PxyMZY */
  .content-block-map-img {
    background-image: url("http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $rest_detail[0]['Restaurant']['latitude'] ?>,<?php echo $rest_detail[0]['Restaurant']['longitude'] ?>&scale=2&markers=icon|<?php echo $rest_detail[0]['Restaurant']['latitude'] ?>,<?php echo $rest_detail[0]['Restaurant']['longitude'] ?>&zoom=15&size=1072x276&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&markers=color:red%7Ccolor:red%7Clabel:C%7C40.718217,-73.998284&sensor=false&key=AIzaSyDCyBF1hBPKOnlmVKH3nS7rWBIixTRUWLw&style=feature:landscape|element:all|hue:0xe5e1df|saturation:-62|lightness:0|visibility:on&style=feature:poi.school|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.medical|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.attraction|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.government|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.place_of_worship|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:administrative.locality|element:all|hue:0xffffff|saturation:0|lightness:100|visibility:off&style=feature:road.local|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.business|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:water|invert_lightness:true|element:geometry|hue:0x82b4ff|saturation:100|lightness:-1|visibility:on&style=feature:road.highway|element:geometry|hue:0xfcb04d|saturation:-3|lightness:1|visibility:simplified&style=feature:poi.park|element:all|hue:0xc9e3a8|saturation:15|lightness:-1|visibility:on");
    padding-top: 14.62%;/*image width/height * 100*/
  }
}
@media (max-width: 640px) {
  .content-block-map-img {
    background-image: url("http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $rest_detail[0]['Restaurant']['latitude'] ?>,<?php echo $rest_detail[0]['Restaurant']['longitude'] ?>&scale=2&markers=icon|<?php echo $rest_detail[0]['Restaurant']['latitude'] ?>,<?php echo $rest_detail[0]['Restaurant']['longitude'] ?>&zoom=15&size=600x140&maptype=roadmap&markers=color:blue%7Clabel:S%7C40.702147,-74.015794&markers=color:green%7Clabel:G%7C40.711614,-74.012318&markers=color:red%7Ccolor:red%7Clabel:C%7C40.718217,-73.998284&sensor=false&key=AIzaSyDCyBF1hBPKOnlmVKH3nS7rWBIixTRUWLw&style=feature:landscape|element:all|hue:0xe5e1df|saturation:-62|lightness:0|visibility:on&style=feature:poi.school|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.medical|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.attraction|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.government|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.place_of_worship|element:all|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:administrative.locality|element:all|hue:0xffffff|saturation:0|lightness:100|visibility:off&style=feature:road.local|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:poi.business|element:labels|hue:0xffffff|saturation:-100|lightness:100|visibility:off&style=feature:water|invert_lightness:true|element:geometry|hue:0x82b4ff|saturation:100|lightness:-1|visibility:on&style=feature:road.highway|element:geometry|hue:0xfcb04d|saturation:-3|lightness:1|visibility:simplified&style=feature:poi.park|element:all|hue:0xc9e3a8|saturation:15|lightness:-1|visibility:on");
    padding-top: 30%;
  }
}
</style>
