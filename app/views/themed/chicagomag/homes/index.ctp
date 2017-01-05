<?php 
    echo $javascript->link('jquery.jcarousel', false);
    echo $html->css('home_skin', null, null, false)
?>
<script type="text/javascript">
jQuery(document).ready(function(){
    home_scroll();
});
</script>
<div id="page-body-right">
    <?php echo $this->element('search_form');?>

    <div id="select_search" class="prodcucontainer clearfix">
        <?php if(!empty($restaurant_detail)){ ?>
        <ul class="rest_product clearfix" id="rest_product">
            <?php 
            App::import('model','Neighborhood');
            $neighborhood = new Neighborhood;
            App::import('Component','Images');
            $Images_thumb = new ImagesComponent;
            $Images_thumb->set_paths(WWW_ROOT . 'img/original/', WWW_ROOT . 'img/medium/'); 
            $Images_thumb->width=150;
            $Images_thumb->height=107;
            //pr($restaurant_detail);
            $j = 1;
            foreach($restaurant_detail as $restaurants){ 
                $id = $restaurants['Restaurant']['id'];                
            ?>
            <li id="prodcucontainer_<?php echo $id;?>" class="product <?php if(($j%3)==0) echo 'last';?>">
                <div class="prodcut_img">                 
                    <span class="product-image">
                    <?php
                        $url = $html->url(array('controller'=>'homes', 'action'=>'details',$id),true);
                        $image = $restaurants['Restaurant']['logo'];
						
                        if(!empty($image)):
                            $image_url=$html->url('/img/original/'.$image,true);
                            $image_url= 'medium/'.$Images_thumb->thumb($image_url);
                        else :
                            $image_url=$html->url('/images/noImage.png',true); 
                        endif;
			$image=$html->image($image_url,array('align'=>'center'));
                        echo $html->link($image,$url,array('escape'=>false,'class'=>'restuarant_image','rel'=>$id, 'onclick'=>'return false'));
                    ?>
                    </span>
                </div>
                <div class="prodcut_details">
                    <span class="product-location">
                    <?php $restaurant_name = strtoupper($restaurants['Restaurant']['name']);?>
                    <span class="product-name" title="<?php echo $restaurant_name;?>">
                        <a href="<?php echo $url;?>" class="res_name" rel="<?php echo $id;?>" onclick="return false" >
                            <?php 
                            if(strlen($restaurants['Restaurant']['name'])>12)
                                echo substr($restaurant_name,0,12 ).'...';
                            else
                                echo $restaurant_name;
                            ?>
                        </a>
                    </span>
                    <span class="party-size2"> 
                        <?php 
                            $neighborhoods= $neighborhood->findById($restaurants['Restaurant']['neighborhoodId']);
                            if(isset($neighborhoods['Neighborhood']['name'])){
                                $neighborhood_name = $neighborhoods['Neighborhood']['name'];
                                if(strlen($neighborhood_name)>10)
                                    $neighborhood_name = substr($neighborhood_name,0,10 );
                            }    
                            else
                                $neighborhood_name = 'Nil';
                            $restaurantcuisine_name = '';
                            if(isset($restaurants['Restaurantcuisine'][0]['Cuisine']['name'])){
                                $restaurantcuisine_name = $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];
                                if(strlen($restaurantcuisine_name)>10)
                                    $restaurantcuisine_name = substr($restaurantcuisine_name,0,10 );
                            }    
                            else
                                $restaurantcuisine_name = 'Nil';
                        ?>
                        <span><?php echo $neighborhood_name;?></span> - <?php echo $restaurantcuisine_name;?>               		
                    </span>
                    <span class="party_size"> 
                        <?php 
							$timeAvailability=array();
                            $timeAvailability=$restaurant->Restaurant->tableAvailability($id );
                            $availabilityTime=array();
                            foreach($timeAvailability as $party_sizes=>$offers)
                                $party_size1 = $party_sizes;
                        ?>
                        <span id="party_<?php echo $id ;?>" class="party_size">Party - <?php echo $party_size1; ?></span>
                    </span>                    
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
                        $reservation_details = 'party='.$party_size1.'&rest_id='.$id.'&time='.date('h:i',$offer).'&ampm='.date('A',$offer);
                        $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true); 
                        ?>
                        <div class="time3"><a class="reservation_popup" href="<?php echo $reservation_url; ?>"><?php echo date('h:i A',$offer); ?></a></div>
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
        <div class="more" style="width:100%;">
            <?php 
            if($this->Paginator->numbers()){
                    echo $paginator->prev(' Previous ', null, null, array('class' => 'disabled','id'=>'paginate_prev'));
                    echo $paginator->next(' Next ', null, null, array('class' => 'disabled','id'=>'paginate_more')); 
            }
            ?>
        </div>
        <?php }else { ?>
            <div class="bordersearch" id="noresfound"><?php  echo "All of today's offerings have now expired! Check below for a fresh batch of restaurants for tomorrow!!!"; ?></div>
        <?php } ?>     
    </div>    
</div>    