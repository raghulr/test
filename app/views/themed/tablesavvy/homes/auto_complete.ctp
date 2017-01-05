 <?php 
 //$restaurant=array();
 foreach($restaurants as $key=>$val): ?>
    <?php $restaurant[] = $restaurants[$key]['Restaurant']['name'];?>
 <?php endforeach;
 if(!empty($restaurant))
	 $availableTags = json_encode($restaurant);
 else
 	$availableTags = 'No Restaurant Found';
echo $availableTags;?>
