<div id="wrapper">
    <div id="tsWidget" class="module-hatched clearfix">
        <h3>
            <span>30% off</span><br>
            Chicago fine dining tonight
        </h3>
        <div class="tsSubmit">
            <a href="<?php echo $html->url('/homes?theme=tablesavvy',true);?>" target="_blank" class="searchs">Search available restaurants</a>
        </div>
        <div class="featuredLabel">Featured restaurant</div>
        <div class="featured clearfix">
            <div class="prodcucontainer" id="select_search">
                <ul id="mycarousel1 rest_product" class="jcarousel1-skin-tangos">
                    <?php 
                    App::import('model','Neighborhood');
                    $neighborhood = new Neighborhood;
                    App::import('Component','Images');
                    $Images_thumb = new ImagesComponent;
                    $Images_thumb->set_paths(WWW_ROOT . 'img/original/', WWW_ROOT . 'img/medium/'); 
                    $Images_thumb->width=120;
                    $Images_thumb->height=104;
                    $j = 1;
                    foreach($restaurant_detail as $restaurants){ 
                        $id = $restaurants['Restaurant']['id'];                
                    ?>
                    <li class="product" id="prodcucontainer_<?php echo $id;?>" class="product <?php if(($j%3)==0) echo 'last';?>">
                        <div class="prodcut_img">                 
                            <span class="product-image">
                            <?php
                                $url = $html->url(array('controller'=>'homes', 'action'=>'details',$id.'?theme=tablesavvy'),true);
                                $image = $restaurants['Restaurant']['logo'];

                                if(!empty($image)):
                                        $image_url=$html->url('/img/original/'.$image,true); 
                                        //$image_url= 'medium/'.$Images_thumb->thumb($image_url);
                                else :
                                        $image_url=$html->url('/images/noImage.png',true); 
                                endif;
                                $image=$html->image($image_url,array('align'=>'center'));
                                echo $html->link($image,$url,array('escape'=>false,'target'=>'_blank','class'=>'restuarant_image','rel'=>$id));
                            ?>
                            </span>
                        </div>
                        <div class="prodcut_details">
                            <?php $restaurant_name = strtoupper($restaurants['Restaurant']['name']);?>
                            <span class="product-name" title="<?php echo $restaurant_name;?>">
                                <a target="_blank" href="<?php echo $url;?>" class="res_name" rel="<?php echo $id;?>">
                                    <?php 
                                    if(strlen($restaurants['Restaurant']['name'])>19)
                                        echo substr($restaurant_name,0,19 ).'...';
                                    else
                                        echo $restaurant_name;
                                    ?>
                                </a>
                            </span>
                            <div class="party-size2"> 
                                <?php 
                                    $neighborhoods= $neighborhood->findById($restaurants['Restaurant']['neighborhoodId']);
                                    if(isset($neighborhoods['Neighborhood']['name'])){
                                        $neighborhood_name = $neighborhoods['Neighborhood']['name'];
                                        if(strlen($neighborhood_name)>15)
                                            $neighborhood_name = substr($neighborhood_name,0,15 );
                                    }    
                                    else
                                        $neighborhood_name = 'Nil';
                                    $restaurantcuisine_name = '';
                                    if(isset($restaurants['Restaurantcuisine'][0]['Cuisine']['name'])){
                                        $restaurantcuisine_name = $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];
                                        if(strlen($restaurantcuisine_name)>15)
                                            $restaurantcuisine_name = substr($restaurantcuisine_name,0,15 );
                                    }    
                                    else
                                        $restaurantcuisine_name = 'Nil';
                                ?>
                                <span><?php echo $neighborhood_name;?> - <?php echo $restaurantcuisine_name;?> </span>           		
                            </div>
                            <div class="party_size"> 
                                <?php 
                                    $timeAvailability=$restaurant->Restaurant->tableAvailability($id );
                                    $availabilityTime=array();
                                    foreach($timeAvailability as $party_sizes=>$offers)
                                        $party_size = $party_sizes;
                                ?>
                                <span id="party_<?php echo $id ;?>" class="party_size">Party -<?php echo $party_size; ?></span>
                            </div>                    
                        </div>
                        <div id="wrap" class="prodcut_time_details"> 
                            <input type="hidden" id="selectparty_1" value="2" name="data[Home][Party_size]">	
                            <ul class="jcarousel-skin-tango-home" id="mycarousel">        
                                <?php
                                $exact_match=0;
                                $count=count($offers)-1;
                                $i=0;
                                foreach($offers as $offer_time){ 
                                    $offer = strtotime($offer_time);
                                    if(!empty($time_select)&&in_array($time_select,$offers)){
                                            $offer=strtotime($time_select);
                                            $exact_match=1;
                                    }
                                ?>
                                <?php
                                if(($i%4==0) || $i==0)
                                echo '<li>';
                                $reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('h:i',$offer).'&ampm='.date('A',$offer).'&theme=tablesavvy';
                                $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true); 
                                ?>
                                <div class="time3">
                                    <a class="reservation_popup" target="_blank" href="<?php echo $reservation_url; ?>"><?php echo date('h:i A',$offer); ?></a>
                                </div>
                                <?php 
                                $i++;
                                if(($i%4==0) || $i>=count($offers))
                                echo '</li>';
                                ?>
                                <?php if($exact_match==1)break; ?> 
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php $j++; } ?>           
                </ul>
            </div>
        </div>
        <div class="poweredby">Powered by TableSavvy</div>
    </div>
</div>
