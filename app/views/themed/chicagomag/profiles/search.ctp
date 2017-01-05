<?php 
	echo $javascript->link('jquery.jcarousel', false);
	echo $html->css('skin', null, null, false)
?>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.jcarousel-skin-tango').jcarousel({
        start: 1
    });
	setreservationTime();
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		cufon();
	});
	setreservationTime();
</script>
<div class="subinnercontainer" id="select_search">
<div class="prodcucontainer" id="prodcucontainer">
<ul id="rest_product" class="rest_product">
<?php if($count!=0 && $count!=-1){ 
	foreach($result as $data): ?>
	<li class="product" id="prodcucontainer_<?php echo $data['Restaurant']['id']; ?>">
		<span class="product-name"><?php echo $data['Restaurant']['name']; ?></span>
		<div class="prodcut_img">
		<span class="product-image">
			<a href="<?php echo $html->url(array('controller'=>'homes','action'=>'details',$data['Restaurant']['id']),true);?>" >
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
		<span class="rname">Location</span>
		<br/>
			<?php 
				$neighborhoodId = $data['Restaurant']['neighborhoodId'];								 
				$row=mysql_fetch_array(mysql_query("select * from neighborhoods where id='$neighborhoodId' "));
				$neighborhoods_name= $row['name'];
				if(!empty($neighborhoods_name))	:			
					if(strlen($neighborhoods_name)>10): 
						echo '<span class="toolTip" title="'.$neighborhoods_name.'">'.substr($neighborhoods_name,0,10 ).'..</span>';
					else: 
						echo '<span>'.$neighborhoods_name.'</span>';
					endif;
				else:
					echo 'Nil';
				endif;
            ?>
		</span>
		<span class="party-size"><span class="rname">Cuisine</span><br/>
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
					if(strlen($cuisines)>10):
						echo '<span class="toolTip" title="'.$cuisines.'">'.substr($cuisines,0,10).'..</span>';
					else:
						echo $cuisine['Cuisine']['name'];
					endif;
				else:
					echo 'Nil';
				endif;
			?>
		</span>
		<span class="party-size">
			<span class="rname">Party</span>
			<br/>
			<span class="party_size" id="#party">
				<?php echo $party_size; ?>
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
					$resservation = $restaurant->Restaurant->tableAvailability($data['Restaurant']['id'],$starttime,$party_size);
					if($resservation[0][0]['count(offer.id)']>=1):		
				?>
				<?php if($counter==0): ?>
				<ul id="mycarousel" class="jcarousel-skin-tango">
				<?php endif;?>
				<li class="<?php if($i==0) echo "time1"; else if($i == $diff) echo "time5"; else  echo "time3";  ?>">
					<?php $url = $html->url(array('controller'=>'homes','action'=>'index',date('h:i A',$starttime)));?>	
					<a href="javascript:;"><?php echo date('h:i A',$starttime); ?></a>                        
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
			<span>Timing not available</span>
			<?php endif;?>                
		</div>
		<span>
		<?php $time_url = $html->url(array('controller'=>'homes','action'=>'reservation'),true); ?>
			<a href="javascript:;" id="make" class="changehover" onclick="return select_reserve('prodcucontainer_<?php echo $data['Restaurant']['id']; ?>','<?php echo $time_url; ?>','<?php echo $data['Restaurant']['id']; ?>','<?php echo $party_size; ?>');">reservation</a> 
			
		</span>
	</li>
<?php endforeach; ?>  
</ul>
</div>
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
<?php } else if($count==-1) { ?>
	<div class="subinnercontainer" style="float:none;"><!--delepan-->
        <div class="emty" style="">
        <?php echo "Please enter a word to search"; ?>
        </div> 
        <div class="cusineheader"></div>
    </div>
<?php } else { ?>
	<div class="subinnercontainer" style="float:none;"><!--delepan-->
        <div class="emty" style="">
        <?php echo "No Restaurant found for your search"; ?>
        </div> 
        <div class="cusineheader"></div>
    </div>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".more a").click(function(){ 
			$("#select_search").load(this.href);
			return false;
		})
	});
</script>