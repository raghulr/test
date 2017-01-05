<?php
$timeAvailability = $restaurant->Restaurant->tableAvailability($id,$party_size);
if(!empty($timeAvailability)){
    foreach($timeAvailability as $party_sizes=>$offers)
            $party_size = !empty($party_size)?$party_size:$party_sizes;
    asort(&$offers);
?><ul id="mycarousel" class="jcarousel-skin-tango"><?php
    foreach($offers as $offer_time){ 
        $offer = strtotime($offer_time);
        $reservation_details = 'party='.$party_size.'&rest_id='.$id.'&time='.date('h:i',$offer).'&ampm='.date('A',$offer);
        $reservation_url = $html->url(array('controller'=>'homes','action'=>'reservation','?'.$reservation_details),true);
    ?> 
    <li><a class="reservation_popup btn-small btn" href="<?php echo $reservation_url;?>"><?php echo date('h:i A',$offer); ?></a></li>
<?php
    }
	?></ul><?php
}else{
    echo '<li><span>No reservations available for selected party size</span><li>';
}   
?>       
    