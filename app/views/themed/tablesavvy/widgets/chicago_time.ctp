<?php 
	echo $javascript->link('jquery.jcarousel', false);
	echo $html->css('skin', null, null, false)
?>
<style>
#change{
    width: 100%;
}

</style>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.jcarousel-skin-tango').jcarousel({
        start: 1
    });
	setreservationTime();
});
function change_party(party,id){
	$('#party_'+id).html(party);
}
function change_url(url,id){
	//alert(url);
	var party=$('#party_'+id).text();
	var url = url+'/'+id+'/'+party;
	window.location.href = url;
}
</script>
<?php if(!empty($redirectUrl)) { ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		time_url = "<?php echo $redirectUrl;?>";
		//alert(time_url);
		$.colorbox({href:time_url,iframe:true,innerWidth:470,innerHeight:570});
	});
</script>
<?php } ?>
<style type="text/css">
.jcarousel-prev-disabled
{
	background:url(images/left_dis.png) no-repeat 0 0 transparent !important;
	height:15px !important;
}
.jcarousel-next-disabled{
	background:url(images/right_dis.png) no-repeat 0 0 transparent !important;
	height:15px !important;
}
.toolTip{
	display:inline !important;
}

</style>
<?php 
	echo $html->css('chi-publication', null, null, false);
	echo $html->css('chi', null, null, false);
	echo $html->css('chi-nav', null, null, false);
	echo $html->css('headersprites', null, null, false);
	echo $html->css('ads', null, null, false);
?>
<div class="contentcontainer" id="contentcontainer">
 
<div class="content" id="content_search">
    <div class="subcontainer">
         <div class="subinnercontainer">
           <div class="finddeal">
             <div class="greenhead">Find Your Deal</div>
               <div class="greencontent">
                 <div class="titledeal">
                 	<?php echo $form->create('Home',array('controller'=>'homes','action'=>'select_search')); ?>
                   <div class="neignbourhood">
                        <span>By Neighborhood</span>    
                        <?php 
						$url = $html->url(array('controller'=>'homes', 'action'=>'select_search'),true);						
                        echo $form->input('Restaurant.neighborhoodId',array('label'=>false, 'class'=>'select_box','type'=>'select','label'=>false,'options'=>array($neighbor_list),'selected'=>'Select','id'=>'nid','empty'=>'Any','onchange'=>"search_restaurant(this.value,'".$url."');"));
                        ?>                  
                    </div>
                    <div class="cuisine">
                        <span>By Cuisine</span>
                        <?php 
                        echo $form->input('Restaurantcuisine.cuisine_id',array('label'=>false, 'class'=>'select_box','type'=>'select','label'=>false,'options'=>array($cuisine_list),'selected'=>'Select','id'=>'cid','empty'=>'Any','onchange'=>"search_restaurant(this.value,'".$url."');")); 
                        ?>                                
                    </div>
                    <div class="cuisine">
                        <span>By Time</span>
                        <?php 
                        echo $form->input('Offer.offerTime',array('label'=>false,'id'=>'change','class'=>'select_box','type'=>'select','label'=>false,'selected'=>'Select','options'=>$options,'id'=>'tid','empty'=>'Any','onchange'=>"search_restaurant(this.value,'".$url."');")); 
                        ?>                                
                    </div>
                    <div class="cuisine_new">
                        <span>By Party</span>   
                         <?php /*?><?php 
							$home_url = $html->url(array('controller'=>'homes','action'=>'select_search'));
                        	echo $form->input('',array('label'=>false,'class'=>'select_box','type'=>'select','label'=>false,'options'=>array(2=>'2',4=>'4',6=>'6',8=>'8'),'empty'=>'Any','selected'=>$party_size,'onchange' =>'passparty(this.value,"'.$home_url.'");changeparty(this.value);'));
							echo $form->end();
                        ?>    <?php */?>
                        <?php 
						$home_url = $html->url(array('controller'=>'homes','action'=>'select_search'));
                        	echo $form->input('',array('label'=>false,'class'=>'select_box','type'=>'select','label'=>false,'options'=>array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8'),'empty'=>'Any','selected'=>$party_size,'id'=>'party_id','onchange'=>"search_restaurant(this.value,'".$url."');"));
							echo $form->end();
							?>
                    </div>
                    </div>
                       <div class="search">
                    <?php $res = $this->Session->read('rest'); ?>
						<?php echo $form->create('Home'); ?>
                        <?php if(isset($res)){
						echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','autocomplete'=>'off','div'=>false,'value'=>$res,'onfocus'=>'javascript:if(this.value=="Enter Restaurant Name"){ this.value=""}','onblur'=>'javascript:if(this.value==""){ this.value="Enter Restaurant Name"; jQuery("#response_result").hide();}','onkeyup' => 'auto_complete(this.value)'));
						 echo $form->input('page',array('type'=>'hidden','value'=>'home'));
						} else {
						         echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','autocomplete'=>'off','div'=>false,'value'=>'Enter Restaurant Name','onfocus'=>'javascript:if(this.value=="Enter Restaurant Name"){ this.value=""}','onblur'=>'javascript:if(this.value==""){ this.value="Enter Restaurant Name"; jQuery("#response_result").hide();}','onkeyup' => 'auto_complete(this.value)'));   ?>
                                 <div id = 'response_result' style="border: 1px solid #CFCFCF; background-color:#ffffff; float: left;height: auto;margin-left: -3px;margin-top: 7px;position: relative; width: 343px;z-index: 1000; display:none;"><span id="auto_complete_response"></span></div>
								 <?php
								  echo $form->input('page',array('type'=>'hidden','value'=>'home'));
							   } ?>	
                        <?php echo $ajax->submit('',array('url'=>array('controller'=>'homes','action'=>'search'),'update'=>'select_search','complete' =>'jcarousel()')); 
						      echo $form->end();?>
                    </div>
                </div>
            </div>
            <div class="load">    
			 	<?php echo $html->image('/images/load.gif',array("width"=>250,"height"=>400,'id'=>'loading'));  ?>  
             </div> 
        </div>
    </div>
      

<?php echo $form->create('Home', array('action' => 'index'));?>       
    <div class="prodcucontainer" id="select_search">
        <ul id="rest_product" class="rest_product">
        <?php if(!empty($restaurant_detail)):foreach($restaurant_detail as $data): ?>
            <li class="product" id="prodcucontainer_<?php echo $data['Restaurant']['id']; ?>">
                
                <div class="prodcut_img">
                <span class="product-image">
               <?php /*?> <?php echo $html->url(array('controller'=>'homes','action'=>'details'),true);?><?php */?>
               <?php $url = $html->url(array('controller'=>'homes', 'action'=>'details','chicago'=>true),true);?>
                	<a href="javascript:;" onclick="change_url('<?php echo $url; ?>','<?php echo $data['Restaurant']['id']; ?>')">
                <?php 
                $image = $data['Restaurant']['logo']; 
                if(!empty($image)):
                	echo $html->image('/img/small/'.$image,array("width"=>156,"height"=>107)); 
                else :
                	echo $html->image('/images/noImage.png',array("width"=>156,"height"=>107)); 
                endif;
                ?>
                </a>
                </span>
                </div>
                <div class="prodcut_details">
                <span class="product-location">
                <span class="product-name">
                 <?php $url = $html->url(array('controller'=>'homes', 'action'=>'details','chicago'=>true),true);?>
                	<a class="res_name" href="javascript:;" onclick="change_url('<?php echo $url; ?>','<?php echo $data['Restaurant']['id']; ?>')">
				<?php if(strlen($data['Restaurant']['name'])>10)
								echo substr(strtoupper($data['Restaurant']['name']),0,25 ).'.....';
							else
								echo strtoupper($data['Restaurant']['name']);
				?></a></span>
                </span>
                <span class="party-size2">
					<?php 
						$neighborhoodId = $data['Restaurant']['neighborhoodId'];								 
						$row=mysql_fetch_array(mysql_query("select * from neighborhoods where id='$neighborhoodId' "));
						$neighborhoods_name= $row['name'];
						if(!empty($neighborhoods_name))	:			
							if(strlen($neighborhoods_name)>10): 
								echo '<span title="'.$neighborhoods_name.'">'.substr($neighborhoods_name,0,10 ).'..</span>';
							else: 
								echo '<span>'.$neighborhoods_name.'</span>';
							endif;
						else:
							echo 'Nil';
						endif;
                    ?>
               
					<?php 
						if(!empty($data['Restaurantcuisine'])):
							$cuisines='';
							$j=1;
							foreach($data['Restaurantcuisine'] as $cuisine):
								$cuisines.=$cuisine['Cuisine']['name'];
								if($j != count($data['Restaurantcuisine']))
								$cuisines.=', ';
								$j++;
							endforeach;
							if(strlen($cuisines)>16):
								echo '-'.' '.'<span class="toolTip" title="'.$cuisines.'">'.substr($cuisines,0,16).'..</span>';
							else:
								echo '-'.' '.$cuisine['Cuisine']['name'];
							endif;
						else:
							echo '- Nil';
						endif;
                    ?>
               		</span>
                	<span>Party -</span>
                    <span class="party_size" id="party_<?php echo $data['Restaurant']['id'];?>">
						Nil 
					</span>
                   <?Php echo $form->hidden('Party',array('value'=>'','name'=>'selectparty','id'=>'Select_party',
				   		'class'=>'changeparty'	
						)); ?>
                </span>            
                </div>
                <div class="prodcut_time_details" id="wrap">     
					   
				<?php
					$counter=0;
					$starttime=strtotime($data['Restaurant']['startTime']); 
					$endtime=strtotime($data['Restaurant']['endTime']); 
					$diff=abs(ceil(($endtime-$starttime)/1800));
					if($diff!=0): 
					for($i=0;$i<=$diff;$i++){
					//$party_size;
					$resservation = $restaurant->Restaurant->tableAvailability_any($data['Restaurant']['id'],$starttime,$party_size);
					//pr($resservation);
					if($resservation[0][0]['count(offer.id)']>=1):		
				?>
                <script language="javascript1.1">
					change_party("<?php echo $resservation[0]['offer']['seating'];?>","<?php echo $data['Restaurant']['id'];?>");
                </script>
                 <?Php echo $form->hidden('Party_size',array('value'=>$resservation[0]['offer']['seating'],'id'=>'selectparty_'.$data['Restaurant']['id'])); ?>	
				<?php if($counter==0): ?>
				<ul id="mycarousel" class="jcarousel-skin-tango">
				<?php endif;?>
				<li class="<?php if($i==0) echo "time1"; else if($i == $diff) echo "time5"; else  echo "time3";  ?>">
					<?php $url = $html->url(array('controller'=>'homes','action'=>'index',date('h:i',$starttime)));?>	
                     <?php $time_url = $html->url(array('controller'=>'homes','action'=>'reservation'),true); ?>
                     
					<a class="changehover" id="time_<?php echo $data['Restaurant']['id'].'_'.$starttime;?>" onmouseover="mouseover('<?php echo $starttime; ?>','<?php echo $data['Restaurant']['id']; ?>')" onmouseout="mouseout('<?php echo $starttime; ?>','<?php echo $data['Restaurant']['id']; ?>')" href="javascript:;" onclick="return select_reservation('prodcucontainer_<?php echo $data['Restaurant']['id']; ?>','<?php echo $time_url; ?>','<?php echo $data['Restaurant']['id']; ?>','<?php echo date('h:i A',$starttime); ?>');"><?php echo date('h:i A',$starttime); ?></a>                      
				</li>
				<?php 
					$counter++;
					endif;
					$starttime=$starttime+1800;  
					}
					endif; 
				?>
			<?php if($counter!=0): ?>    
			</ul>
			<?php else: ?>
			<span style="padding-left:4px;">Timing not available</span>
			<?php endif;?>                
		</div>
               <?php /*?> <span>
                <?php $time_url = $html->url(array('controller'=>'homes','action'=>'reservation'),true); ?>
                    <a href="javascript:;" id="make" class="changehover" onclick="return select_reservation('prodcucontainer_<?php echo $data['Restaurant']['id']; ?>','<?php echo $time_url; ?>','<?php echo $data['Restaurant']['id']; ?>');">reservation</a> 
                    
                </span><?php */?>
            </li>
        <?php endforeach;else: ?> <div class="bordersearch"><?php  echo "No Restaurant can be found"; ?></div><?php endif; ?>  
        </ul>
        <div class="subcontainer">
    <div class="subinnercontainer">
    <div class="more" style="width:100%;">
		<?php 
        	if($this->Paginator->numbers()){
        		echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled','id'=>'paginate_prev'));
        		echo $paginator->next(' Next >>', null, null, array('class' => 'disabled','id'=>'paginate_more')); 
        	}
        ?>
    </div>
    </div>
    </div>
</div>
<?php $form->end(); ?> 
</div>
</div>