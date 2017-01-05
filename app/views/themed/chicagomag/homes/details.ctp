<?php
    echo $html->css('skin', null, null, false);
    echo $javascript->link('jquery.jcarousel', true);
    echo $javascript->link('chicagomag', false);	
?>

<div id="alert_update"></div>
<?php foreach($rest_detail as $data):?>
<div id="page-body-right">
     <?php echo $this->element('navigation'); ?>
    <div id="restaurantTop" class="clearfix">
        <div id="head" class="clearfix">
            <h1><?php echo strlen($data['Restaurant']['name'] > 35)?substr($data['Restaurant']['name'],0,35).'...':$data['Restaurant']['name'];?></h1>
            <!--<div class="intro">Reserve a table for $5 and save 30%</div>-->
        </div>
        <div class="clearfix" id="reserve">
            <div class="type">Get a table for:</div>
            <div class="input select" id="party-size">
            	 <?php 
                    echo $form->create();  //echo $party_size;
                    $id = $data['Restaurant']['id'];
                    //pr($data);
                    $detail_url = $html->url(array('controller'=>'homes','action'=>'getsize',$id));
                    echo $form->input('id',array('label'=>false, 'class'=>'select_box short','id'=>'change_party_size','type'=>'select','label'=>false,'options'=>array(2=>'2 people',3=>'3 people',4=>'4 people',5=>'5 people',6=>'6 people',7=>'7 people',8=>'8 people'),'selected'=>$party_size)); 
                    echo $form->end();
                ?>
                <div id="hide" class="hide"><?php echo $detail_url;?></div>
            </div><!-- /#party-size -->

            <div class="type">Available seating:</div>
             <div class="btn-group" id="time">
             	<?php
			   	$timeAvailability = $restaurant->Restaurant->tableAvailability($id,$party_size);
				if(!empty($timeAvailability)){
                                        
					foreach($timeAvailability as $party_sizes=>$offers)
						$party_size = !empty($party_size)?$party_size:$party_sizes;
                                        asort(&$offers);
				?>
                	 	<?php $time_url = $html->url(array('controller'=>'homes','action'=>'reservation'),true); ?>
                    	 <?php echo $form->hidden('Party_size',array('value'=>$party_size,'id'=>'selectparty_'.$id)); ?>	
				    	 <?php echo $form->hidden('Party',array('value'=>'','name'=>'selectparty','id'=>'Select_party',                         'class'=>'changeparty')); ?>
                         <div id="change_size">
                          <ul id="mycarousel" class="jcarousel-skin-tango">
							 <?php
                                $exact_match=0;
                                $count=count($offers)-1;
                                $i=0;
                                foreach($offers as $offer_time){ 
                                    $offer = strtotime($offer_time);
                                    $reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('h:i',$offer).'&ampm='.date('A',$offer);
                                    $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true);
                                ?> 
                                    <li><a class="reservation_popup btn-small btn" href="<?php echo $reservation_url;?>"><?php echo date('h:i A',$offer); ?></a></li>
                           	<?php } ?>
                        </ul>
                        </div>
                <?php  }else{?>
                      <div class="tabletitle2">
                   	 	No reservations available for selected party size
                     </div>
                <?php }?>
            </div>
        </div><!-- /#reserve -->
    </div><!-- /#restaurantTop -->
     <?php if(!empty($image)){?>
    <div id="photo-gallery" class="clearfix">
        <ul class="jcarousel-skin-tangos1">
            <?php
                App::import('Component','Images');
                $Images_thumb = new ImagesComponent;
                $Images_thumb->set_paths(WWW_ROOT . 'img/original/', WWW_ROOT . 'img/medium/'); 
                $Images_thumb->width=268;
                $Images_thumb->height=180; 
                foreach($image as $list):
                    $image_url=$html->url('/img/big/'.$list['Slideshow']['path'],true);
                $image_url= 'medium/'.$Images_thumb->thumb($image_url); 
            ?>
            <li><?php echo $html->image($image_url,array('border'=>0,'width'=>300,'height'=>200,'title'=>$list['Slideshow']['description'])); ?></li>
            <?php endforeach;?>
                
        </ul>
    </div>	
    <?php } /*?>else{?>
            	<div id="photo-gallery" class="clearfix">
					<?php echo 'No Image Uploaded'; ?>
                </div>
	<?php } ?><?php */?>
    <div id="content" class="clearfix">
        <div id="content-left" class="clearfix two-thirds">
            <div id="content-header" class="hatched clearfix">
                <ul>
                    <li class="on"><a href="#">Profile</a></li>
                   <?php if(isset($menu)){ ?><li><a  target="_blank" href="<?php echo $this->webroot; ?>img/profilemenu/<?php echo $menu;?>">Menu</a></li><?php } else if(!empty($data['Restaurant']['menu_link'])){?>
            			<li><a  target="_blank" href="<?php echo 'http://'.$data['Restaurant']['menu_link'];?>">Menu Link</a></li> 
             	<?php }?>
                <ul>
            </div>
            <div class="content">
                <h2><?php echo strlen($data['Restaurant']['name'] > 35)?substr($data['Restaurant']['name'],0,35).'...':$data['Restaurant']['name'];?></h2>
                <p><?php echo nl2br($data['Restaurant']['long_description']); ?> </p>
               
            </div><!--/.content -->
        </div><!-- /#content-left -->
        
        <div id="content-right">
            <h4><?php echo strlen($data['Restaurant']['name'] > 35)?substr($data['Restaurant']['name'],0,35).'...':$data['Restaurant']['name'];?></h4>
           <?php $user_id = $this->Auth->user('id'); 
                $currnet_url = $html->url( null, false );
                $currnet_url = str_replace('/tablesavvy/', '', $currnet_url);
                if($user_id==''){
                    echo $html->link('Follow this restaurant',array('controller'=>'users','action'=>'login','?f='.$currnet_url),array('escape'=>false,'class'=>'btn btns-small'));

                }else{
                    echo $ajax->link('Follow this restaurant',array('controller'=>'homes','action' =>'get_alert',$user_id,$id),array('update'=>'alert_update','escape'=>false,'complete'=>'funcall()','id'=>'getalert','class'=>'btn'));
                }
            ?>
           
            <p class="data">
               <?php
                if(!empty($data['Restaurant']['address'])): 
                    $city_id = $data['Restaurant']['city'];
                    $state=!empty($data['Restaurant']['state'])?', '.$data['Restaurant']['state']:'';
                    $row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
                    $city_name= $row['city_name'];
                    echo $data['Restaurant']['address'].',<br/>';
                    ?> 
                    <?php echo $city_name;?> 
                    <?php echo strtoupper($state); 
                            $addr = $data['Restaurant']['address'].','.$city_name.','.strtoupper($state).','.'US'; 
                        echo $form->hidden('address',array('value'=>$addr,'name'=>'address','id'=>'address')); 
                endif;
                $phone_number = '';
                $phone = $data['Restaurant']['phone'];
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
            <?php if(!empty($data['Restaurant']['url'])): ?>
            <p class="data"><a href="<?php echo 'http://'.$data['Restaurant']['url'];?>" target="_blank">Website</a></p>
            <?php endif;?>    
            <div id="map" style=" margin-top:15px; width: 260px; height: 200px; float:left;"></div> 
        </div><!-- /#content-right -->
    </div><!-- /#content -->
</div>
<?php endforeach; ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyCZk7mvkYvCAihFZinXF8W7yVIxnLTxOQ8" type="text/javascript"></script>
<script type="text/javascript">
    //fixie('#reserve','#restaurantTop');
	function map(){
	if (GBrowserIsCompatible()) { 
      var map = new GMap(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(20,0),2);
		var search = document.getElementById("address").value;
        var s = search.toUpperCase();
        s = s.replace(/\W+/g, " ");
        s = s.replace(/^ /, "");
        s = s.replace(/ $/, "");
        var match = s.match(/^[A-Z]{1,2}[0-9R][0-9A-Z]? [0-9][ABD-HJLNP-UW-Z]{2}$/);
        if (!match) {
	  	 var geo = new GClientGeocoder(); 
		  var reasons=[];
		  reasons[G_GEO_SUCCESS]            = "Success";
		  reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
		  reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
		  reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
		  reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
		  reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
		  reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";
			geo.getLocations(search, function (result)
			  { 
				if (result.Status.code == G_GEO_SUCCESS) {
				  for (var i=0; i<result.Placemark.length; i++) {
					var p = result.Placemark[i].Point.coordinates;
					var marker = new GMarker(new GLatLng(p[1],p[0]));
					map.addOverlay(marker);
				  }
				  var p = result.Placemark[0].Point.coordinates;
				  map.setCenter(new GLatLng(p[1],p[0]),15);
				}
				else {
				  var reason="Code "+result.Status.code;
				  if (reasons[result.Status.code]) {
					reason = reasons[result.Status.code]
				  } 
				  alert('Could not find "'+search+ '" ' + reason);
				}
			  }
			);
        } 
      var gdir = new GDirections(null); 
	}
}
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        reservation_scroll();
        reservation_size_scroll();
        map();
        reservation_popup();
    });
</script>