<?php
class Table extends AppModel{
	 var $name = 'Table';
	 var $useTable = 'offers';
	function getRestaurantId(){
		App::import('Model','Restaurant'); 
		$instance = new Restaurant();
		$userid=$this->Auth->user('id');
		$restaurantdetails=$instance->findByuser_id($userid);
		return $restaurantdetails['Restaurant']['id'];
	} 	  
	function getoffer($resid,$offerDate,$offerTime,$seating){
		$sql = "SELECT Offer.id FROM offers AS Offer WHERE Offer.restaurantId = ".$resid." AND Offer.offerDate = '".$offerDate."' AND Offer.offerTime = '".$offerTime."' AND Offer.seating = ".$seating." and Offer.id NOT IN(select offerId from reservations where approved=1) LIMIT 1 ";
		$offer_result = $this->query($sql);
		return $offer_result;
	}
   function delete_offer_time($stime,$endtime,$restuarant_id){
		$get_tables = mysql_query("SELECT id FROM offers where restaurantId=".$restuarant_id." 
				AND offerTime NOT BETWEEN '".$stime."' AND '".$endtime."'   
				AND id NOT IN(select offerId from reservations where approved = 1)"
		);
		while($q=mysql_fetch_array($get_tables)){
				$id=$q['id'];
				$sql="delete from reservations where offerId=".$id;
				$offer_result = $this->query($sql);
				$sql = "delete from offers where id=".$id;
				$offer_result = $this->query($sql);
		}            
	}
}
?>