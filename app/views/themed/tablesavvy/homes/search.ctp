<style>
.home_title{
	padding:0;
}
</style>
<?php 
//if($count!=1){
    echo $javascript->link('jquery.jcarousel', false);
    echo $html->css('home_skin', null, null, false);
?>
<?php 
if(isset($search_all)){
        $message = 'Sorry!! But no results have met your search criteria. Please feel free to check out some of our other upcoming reservations below!';
}?>
<?php if($ajax_scroll==false):?>
<?php  if(!empty($result)){?>
<div style="display:none;">
	<!--For IE8 issue-->
	<?php echo 'hi'; ?>
</div>
<?php if (isset($message)) { ?>
<div class="ui warning message">
  <?php echo $message;?>
</div>
<?php } ?>
<ul class="rest_product clearfix append_data" id="rest_product" style="position:relative; overflow:hidden;">
<?php 
	App::import('model','Neighborhood');
    $neighborhood = new Neighborhood;
    
    //pr($restaurant_detail);
    $j = 1;
    foreach($result as $restaurants){ 
       $id = $restaurants['Restaurant']['id']; 
		$timeAvailability=$restaurant->Restaurant->tableAvailability($id);
		$availabilityTime=array();
		foreach($timeAvailability as $party_sizes=>$offers)
			$party_size = $party_sizes;
	?>              
     <?php if(empty($timeAvailability)){ ?>
        	<li id="prodcucontainer_<?php echo $id;?>" class="product_new product product_backgr <?php if(($j%3)==0) echo 'last';?>">
        <?php }else{ ?>
        	<li id="prodcucontainer_<?php echo $id;?>" class="product_new product <?php if(($j%3)==0) echo 'last';?>">
        <?php } ?>
        <div class="prodcut_img">                 
            <span class="product-image">
            <?php
				$url = $html->url(array('controller'=>'homes', 'action'=>'details',$restaurants['Restaurant']['slug_name']),true);
				$image = $restaurants['Restaurant']['logo'];
				
				if(!empty($image)):
                                    $image_url=$html->url('/img/original/'.$image,true); 
                                    $image_url= 'medium/'.$image;
				else :
                                    $image_url=$html->url('/images/noImage.png',true); 
				endif;
				$image=$html->image($image_url);
                echo $html->link($image,html_entity_decode($url, ENT_QUOTES),array('escape'=>false,'class'=>'restuarant_image','rel'=>$id, 'onclick'=>'return false'));
            ?>
            </span>
        </div>
        <div class="prodcut_details">
            <span class="product-location">
				<?php $restaurant_name = strtoupper($restaurants['Restaurant']['name']);?>
                <span class="product-name" title="<?php echo $restaurant_name;?>">
                    <a href="<?php echo $url;?>" class="res_name" rel="<?php echo $id;?>">
                        <?php 
                        if(strlen($restaurants['Restaurant']['name'])>12)
                            echo substr($restaurant_name,0,12 ).'...';
                        else
                            echo $restaurant_name;
                        ?>
                    </a>
                </span>
            </span>
            <span class="party-size2"> 
                <?php 
                    $neighborhoods= $neighborhood->findById($restaurants['Restaurant']['neighborhoodId']);
                    if(isset($neighborhoods['Neighborhood']['name'])){
                        $neighborhood_name = $neighborhoods['Neighborhood']['name'];
                        if(strlen($neighborhood_name)>22)
                                    $neighborhood_name = substr($neighborhood_name,0,20 ).'...';
                    }    
                    else
                        $neighborhood_name = 'Nil';
                    $restaurantcuisine_name = '';
                    if(isset($restaurants['Restaurantcuisine'][0]['Cuisine']['name'])){
                        $restaurantcuisine_name = $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];
                        if(strlen($restaurantcuisine_name)>18)
                                    $restaurantcuisine_name = substr($restaurantcuisine_name,0,15).'...';
                    }    
                    else
                        $restaurantcuisine_name = 'Nil';
                ?>
                <span title="<?php echo $neighborhoods['Neighborhood']['name'];?>"><?php echo $neighborhood_name;?></span> - 
                <span <?php if($restaurantcuisine_name != 'Nil')?>title="<?php echo $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];?>"><?php echo $restaurantcuisine_name;?></span>               		
            </span>
            <span class="party_size"> 
         <?php if(!empty($timeAvailability)){?>
                <?php
				if(!empty($party_size)){?>
                	<span id="party_<?php echo $id ;?>" class="party_size">Party - <?php echo $party_size; ?></span>
                <?php } ?>
            </span>                    
        </div>
        <div id="wrap" class="prodcut_time_details"> 
            <input type="hidden" id="selectparty_1" value="2" name="data[Home][Party_size]">
             <?php
				if(!empty($party_size)){?>	
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
                $reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('g:i',$offer).'&ampm='.date('A',$offer);
                $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true); 
                ?>
                <div class="time3"><a class="reservation_popup" href="<?php echo $reservation_url; ?>"><?php echo date('g:i A',$offer); ?></a></div>
                <?php 
                $i++;
                if(($i%4==0) || $i>=count($offers))
                echo '</li>';
                ?>
                <?php if($exact_match==1)break; ?> 
                <?php } ?>
            </ul>
             <?php } ?>
        </div>
        <?php }else{ ?>
         <span class="party_size no_res"> 
            <span id="party_<?php echo $id ;?>" class="party_size party_noavail">
                <?php if(empty($party_size1)){ ?>
                    No Availability Tonight
                <?php } ?>
            </span>
        </span>
        <?php } ?>
    </li>
    <?php $j++; } ?>           
</ul>
<?php }else { ?>
    <div class="bordersearch" id="noresfound">
        <?php  echo "All of today's offerings have now expired! Check below for a fresh batch of restaurants for tomorrow!!!"; ?>
    </div>
<?php } ?>     
<?php else:?>
<?php 
	App::import('model','Neighborhood');
    $neighborhood = new Neighborhood;
	App::import('Component','Images');
    //pr($restaurant_detail);
    $j = 1;
    foreach($result as $restaurants){ 
       $id = $restaurants['Restaurant']['id']; 
		$timeAvailability=$restaurant->Restaurant->tableAvailability($id);
		$availabilityTime=array();
		foreach($timeAvailability as $party_sizes=>$offers)
			$party_size = $party_sizes;
	?>              
     <?php if(empty($timeAvailability)){ ?>
        	<li id="prodcucontainer_<?php echo $id;?>" class="product_new product product_backgr <?php if(($j%3)==0) echo 'last';?>">
        <?php }else{ ?>
        	<li id="prodcucontainer_<?php echo $id;?>" class="product_new product <?php if(($j%3)==0) echo 'last';?>">
        <?php } ?>
        <div class="prodcut_img">                 
            <span class="product-image">
            <?php
				$url = $html->url(array('controller'=>'homes', 'action'=>'details',$restaurants['Restaurant']['slug_name']),true);
				$image = $restaurants['Restaurant']['logo'];
				
				if(!empty($image)):
                                    $image_url=$html->url('/img/original/'.$image,true); 
                                    $image_url= 'medium/'.$image;
				else :
                                    $image_url=$html->url('/images/noImage.png',true); 
				endif;
				$image=$html->image($image_url);
                echo $html->link($image,html_entity_decode($url, ENT_QUOTES),array('escape'=>false,'class'=>'restuarant_image','rel'=>$id, 'onclick'=>'return false'));
            ?>
            </span>
        </div>
        <div class="prodcut_details">
            <span class="product-location">
				<?php $restaurant_name = strtoupper($restaurants['Restaurant']['name']);?>
                <span class="product-name" title="<?php echo $restaurant_name;?>">
                    <a href="<?php echo $url;?>" class="res_name" rel="<?php echo $id;?>">
                        <?php 
                        if(strlen($restaurants['Restaurant']['name'])>12)
                            echo substr($restaurant_name,0,12 ).'...';
                        else
                            echo $restaurant_name;
                        ?>
                    </a>
                </span>
            </span>
            <span class="party-size2"> 
                <?php 
                    $neighborhoods= $neighborhood->findById($restaurants['Restaurant']['neighborhoodId']);
                    if(isset($neighborhoods['Neighborhood']['name'])){
                        $neighborhood_name = $neighborhoods['Neighborhood']['name'];
                        if(strlen($neighborhood_name)>22)
                                    $neighborhood_name = substr($neighborhood_name,0,20 ).'...';
                    }    
                    else
                        $neighborhood_name = 'Nil';
                    $restaurantcuisine_name = '';
                    if(isset($restaurants['Restaurantcuisine'][0]['Cuisine']['name'])){
                        $restaurantcuisine_name = $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];
                        if(strlen($restaurantcuisine_name)>18)
                                    $restaurantcuisine_name = substr($restaurantcuisine_name,0,15).'...';
                    }    
                    else
                        $restaurantcuisine_name = 'Nil';
                ?>
                <span title="<?php echo $neighborhoods['Neighborhood']['name'];?>"><?php echo $neighborhood_name;?></span> - 
                <span <?php if($restaurantcuisine_name != 'Nil')?>title="<?php echo $restaurants['Restaurantcuisine'][0]['Cuisine']['name'];?>"><?php echo $restaurantcuisine_name;?></span>               		
            </span>
            <span class="party_size"> 
         <?php if(!empty($timeAvailability)){?>
                <?php
				if(!empty($party_size)){?>
                	<span id="party_<?php echo $id ;?>" class="party_size">Party - <?php echo $party_size; ?></span>
                <?php } ?>
            </span>                    
        </div>
        <div id="wrap" class="prodcut_time_details"> 
            <input type="hidden" id="selectparty_1" value="2" name="data[Home][Party_size]">
             <?php
				if(!empty($party_size)){?>	
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
                $reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('g:i',$offer).'&ampm='.date('A',$offer);
                $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true); 
                ?>
                <div class="time3"><a class="reservation_popup" href="<?php echo $reservation_url; ?>"><?php echo date('g:i A',$offer); ?></a></div>
                <?php 
                $i++;
                if(($i%4==0) || $i>=count($offers))
                echo '</li>';
                ?>
                <?php if($exact_match==1)break; ?> 
                <?php } ?>
            </ul>
             <?php } ?>
        </div>
        <?php }else{ ?>
         <span class="party_size no_res"> 
            <span id="party_<?php echo $id ;?>" class="party_size party_noavail">
                <?php if(empty($party_size1)){ ?>
                    No Availability Tonight
                <?php } ?>
            </span>
        </span>
        <?php } ?>
    </li>
    <?php $j++; } ?>    
<?php endif;?>
<div class="subinnercontainer" id="paginationsearch">
    <div class="more" style="width:100%;">
        <?php 
        if($this->Paginator->numbers()){
            echo $paginator->prev(' Previous ', null, null, array('class' => 'prev disabled','id'=>'paginate_prev'));
            echo $paginator->next(' Next ', null, null, array('class' => 'next disabled','id'=>'paginate_more')); 
        }else{?>
            <input type='hidden' value=0 id='pages_next'/>
        <?php }?>
    </div>
</div>