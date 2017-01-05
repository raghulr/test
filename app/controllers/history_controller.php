<?php
class HistoryController extends AppController{
	var $name = 'History';
	var $uses = array('Reservation','User','Offer');
	
	function admin_index(){
		$this->layout='admin';
		$id = $this->get_res_id(); 
		$date = date('Y-m-d');
		$offer = $this->Offer->find('list',array('conditions'=>array('Offer.offerDate'=>$date,'Offer.restaurantId '=>$id),array('fields'=>'id')));
		$this->paginate = array(
			'conditions' => array(
				'Reservation.offerId'=>$offer
			),
			'limit'=>5
		);
		$user = $this->paginate();
		$this->set('data',$user);
	}
	
	function admin_date_display(){
		if(!empty($this->params['form']['date'])){
			$this->Session->write('date',$this->params['form']['date']);
			unset($paginate);
		}
		else{
			$this->set('paginate','paginate');
			$this->set('currentdate',$this->Session->read('date'));
		}
		$date = $this->Session->read('date');
		$id = $this->get_res_id(); 
		$offer = $this->Offer->find('list',array('conditions'=>array('Offer.offerDate'=>$date,'Offer.restaurantId '=>$id),array('fields'=>'id')));
		$this->paginate = array(
			'conditions' => array(
				'Reservation.offerId'=>$offer
			),
			'limit'=>5
		);
		$user = $this->paginate();
		$this->set('data',$user);
	}
}	