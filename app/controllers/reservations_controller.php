<?php
class ReservationsController extends AppController{
    var $name = 'Reservations';
	var $uses = array('Reservation','User','Offer','EmailTemplate');
	var $components = array('Email');
	
	function admin_index(){
		$rid = $this->get_res_id(); 
		$today = date('Y-m-d');
		$offer = $this->Offer->find('list',array('conditions'=>array('Offer.restaurantId'=>$rid,'Offer.offerDate'=>$today),array('fields'=>'id')));
		$this->paginate = array(
			'conditions' => array(
				'Reservation.offerId'=>$offer
			),
			'order'=>'Offer.offerTime',
			'limit'=>5
		);
		$reserve = $this->paginate();
		$this->set('data',$reserve);
	}
	
	function admin_approved(){
		$this->layout = 'ajax';
		if(empty($this->params['named']['page'])){
			$this->Session->write('resid',$this->params['pass'][0]);
			$this->Session->write('userid',$this->params['pass'][1]);
			$resid = $this->Session->read('resid');
			$userid = $this->Session->read('userid');
			$user = $this->User->find('all',array('conditions'=>array('User.id'=>$userid)));
			$approval = $this->Reservation->find('all',array('conditions'=>array('Reservation.userId'=>$userid,'Reservation.id'=>$resid)));
			foreach($approval as $approve){
				$res_approve = $approve['Reservation']['approved'];
				$reserveid = $approve['Reservation']['id'];
			}
			if($res_approve==1){
				$this->data['Reservation']['approved'] = 0;
				$this->Reservation->id=$reserveid;
				$this->Reservation->save($this->data);
				foreach($user as $data){
					$firstname = $data['User']['firstName'];
					$lastname = $data['User']['lastName'];
					$email = $data['User']['email'];
					$phone = $data['User']['phone'];
				}
				$this->Email->from='support@tablesavvy.com';
				$this->Email->to=$email;
				$this->Email->subject='Reservation detail';
				$this->Email->template = 'reject';
				$this->Email->sendAs = 'html';
				$this->set('username',$firstname);
				$this->Email->send();
				$rid = $this->get_res_id(); 
				$today = date('Y-m-d');
				$offer = $this->Offer->find('list',array('conditions'=>array('Offer.restaurantId'=>$rid,'Offer.offerDate'=>$today),array('fields'=>'id')));
				$this->paginate = array(
					'conditions' => array(
						'Reservation.offerId'=>$offer	
					),
					'limit'=>5
				);
				$reserve = $this->paginate();
				$this->set('data',$reserve);
				unset($paginate);
				$this->Session->setFlash('Cancelled successfully' , 'default', null, 'success');
			}
			else{
				$this->Session->setFlash('Already approved' , 'default', null, 'error');
			}	
	  }
	  else{
	  			$this->layout = 'admin';
	  			$rid = $this->get_res_id(); 
				$today = date('Y-m-d');
				$offer = $this->Offer->find('list',array('conditions'=>array('Offer.restaurantId'=>$rid,'Offer.offerDate'=>$today),array('fields'=>'id')));
				$this->paginate = array(
					'conditions' => array(
						'Reservation.offerId'=>$offer	
					),
					'limit'=>5
				);
				$this->set('paginate','paginate');
				$reserve = $this->paginate();
				$this->set('data',$reserve);
	  }
	}
	
	function admin_select(){
		if(!empty($this->params['form']['val'])){
			$this->Session->write('val',$this->params['form']['val']);
			$this->set('val',$this->Session->read('val'));
			unset($paginate);
		}
		else{
			$this->set('paginate','paginate');
			$this->set('val',$this->Session->read('val'));
		}
		$rid = $this->get_res_id(); 
		$today = date('Y-m-d');
		$offer = $this->Offer->find('list',array('conditions'=>array('Offer.restaurantId'=>$rid,'Offer.offerDate'=>$today),array('fields'=>'id')));
		if($this->Session->read('val')==1){
			$this->paginate = array(
				'conditions' => array(
					'Reservation.offerId'=>$offer,	
				),
				'limit'=>5
			);
		}
		else if($this->Session->read('val')==2){
			$this->paginate = array(
				'conditions' => array(
					'Reservation.offerId'=>$offer,	
					'Reservation.approved'=>1
				),
				'limit'=>5
			);
		}
		else{
			$this->paginate = array(
				'conditions' => array(
					'Reservation.offerId'=>$offer,	
					'Reservation.approved'=>0
				),
				'limit'=>5
			);
		}
		$reserve = $this->paginate();
		$this->set('data',$reserve);
	}
	function admin_supportmail(){
		$this->layout=false;
		$this->autoRender=false;
		$reservation_id = intval($this->params['form']['resid']);
		//$reservation_id = 263;
		if(is_numeric($reservation_id)){
			$reservation = $this->Reservation->find('first',array(
                    'conditions'=>array(
                        'Reservation.id'=>$reservation_id,
                        'Reservation.approved'=>1
                    ),
                    'contain'=>array(
                        'Offer'=>array(
                            'Restaurant'
                        ),
                        'User'
                    ),
                    'recursive'=>2
                ));
				$reservation['Reservation']['no_show']=1;
			if($this->params['form']['statusNum']=='true'){
				$reservation['Reservation']['no_show']=0;
				$this->Session->setFlash('Thanks. We will contact the customer.' , 'default', null, 'success');
			}else{
				$reservation['Reservation']['no_show']=1;
			}
			if($reservation['Reservation']['no_show']!=1):
				$seating = $reservation['Offer']['seating'];
				if($reservation['Offer']['seating_custom']!=0)
					$seating = $reservation['Offer']['seating_custom'];
				$date   = strtotime($reservation['Offer']['offerDate']);
				$time   = date('H:i A');
				$day    = date('l',$date);
				$month  = date('F',$date);
				$year   = date('Y',$date);
				$dat    = date('l, F dS',$date);
				$resturant_name['Restaurant']['name'] = $reservation['Offer']['Restaurant']['name'];
				$resturant_name['Restaurant']['id'] = $reservation['Offer']['Restaurant']['id'];
				 $rand_string = $this->generateRandomString();
				$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Support Mail');
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,					
					'##SITE_LOGO##' => Configure::read('website.logo'),
					'##FACEBOOK##' => Configure::read('website.facebook'),
					'##TWITTER##' => Configure::read('website.twitter'),
					'##SITE_NAME##' => Configure::read('website.name'),
					'##NAME##' => (!empty($reservation['User']['firstName'])&&!empty($reservation['User']['lastName']))?$reservation['User']['firstName'].' '.$reservation['User']['lastName']:'User',
					'##SIZE##' => $seating,
					'##RESNAME##' =>  $resturant_name['Restaurant']['name'],
					'##DAY##' => $day,
					'##MONTH##' => $month,
					'##DATE##' => $dat,
					'##YEAR##' => $year,
					'##TIME##'=>date('h:i A',strtotime($reservation['Offer']['offerTime'])),
					'##Unsubscribe_email##' =>Router::url('alerts/subscribe_email/'.$rand_string, true)
				);
				//$sub="Your "."'".$reservation['Offer']['Restaurant']['name']."'"." Reservation Cancellation";
				$sub= "Support Mail via ".Configure::read('website.name');
				$this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
				$this->Email->replyTo = 'support@tablesavvy.com';
				$this->Email->to = 'support@tablesavvy.com';
				$this->Email->cc = 'ssivaraj@farshore.com';
				$this->Email->subject =$sub;
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				$this->Email->send(strtr($email['email_content'], $emailFindReplace));
				$fields = array();
				$conditions = array();
				$conditions['Reservation.id'] = $reservation_id;
				$fields['Reservation.no_show']=1;
				$this->Reservation->updateAll($fields,$conditions);
			endif;
		}
	}
}
?>