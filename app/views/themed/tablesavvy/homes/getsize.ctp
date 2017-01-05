<?php
$timeAvailability = $restaurant->Restaurant->tableAvailability($id,$party_size);
if(!empty($timeAvailability)){

  foreach($timeAvailability as $party_sizes=>$offers)
    $party_size = !empty($party_size)?$party_size:$party_sizes;
  asort(&$offers);

  foreach($timeAvailability as $party_sizes=>$offers) {
    $party_size = !empty($party_size)?$party_size:$party_sizes;
    $timeArray = array();
		foreach($offers as $offer_time){
      $timeArray[date('h:i',strtotime($offer_time))] = date('h:i A',strtotime($offer_time));
	  }
  
    ob_start();
    echo $this->Form->input('time',array('name' => 'time', 'class' => 'ui search fluid dropdown restaurant_time', 'options' =>$timeArray,'label'=>false, 'div'=>false ));
    $offer = strtotime($offers[0]);
    ?>
      <input name="rest_id" value="<?php echo $id?>" id="time" type="hidden">
			<input name="ampm" value="<?php echo date('A',$offer);?>" id="ampm" type="hidden">
		<?php
		
		echo json_encode(array("html" => ob_get_clean()));
  }

}else{
    
    echo json_encode(array('error' => 'no_tables', 'html' => '<div class="no-table">No reservations available for selected party size</div>'));
}   
?>