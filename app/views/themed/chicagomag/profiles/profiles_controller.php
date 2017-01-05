<?php
class ProfilesController extends AppController{
	var $uses=array(
					'User',
					'Alert',
					'Userlocation',
					'Reservation',
					'Restaurant',
					'Offer',
					'EmailTemplate'
				   );
	var $components = array('Auth','Paypal','Email');
 
	function index(){
		$this->layout='home';
		$this->set('title_for_layout','My Reservation');
		$user_id = $this->Auth->user('id');
		$this->loadmodel('Reservation');
		if(!empty($this->params['pass'][0]))
		{
			$id = $this->params['pass'][0];
		}
		else 
		{
			$reservation_id = $this->Reservation->find('first',array(
				'conditions'=>array(
					'userId'=>$user_id,
					'Reservation.approved'=>1
				),
				'fields'=>array(
					'Reservation.id'
				),
				'order'=>'Reservation.id Desc'
			));
			$id = $reservation_id['Reservation']['id'];
		}	
		$profile_reservation='';		
		$profile_reservation = $this->Reservation->find('all',array(
			'conditions'=>array(
				'Reservation.id'=>$id,
				'Reservation.userId'=>$user_id,
				'Reservation.approved'=>1
			),
			'fields'=>array(
				'Offer.id',
				'Offer.seating',
				'Offer.offerTime',
				'Offer.offerDate',
				'Offer.restaurantId'
			)
		));
		$restaurant_details = '';
		if(!empty($profile_reservation)):
			$restaurant_id = $profile_reservation[0]['Offer']['restaurantId'];
			$this->set('profile_reservation',$profile_reservation);
			$this->loadmodel('Restaurant');
			$restaurant_details = $this->Restaurant->find('all',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Restaurant.id'=>$restaurant_id,
					'Restaurant.approved'=>1
				),
				'fields'=>array(
					'Restaurant.id',
					'Restaurant.name',
					'Restaurant.phone',
					'Restaurant.short_description',
					'Restaurant.logo',
					'Restaurant.address',
					'Restaurant.city',
					'Restaurant.state'
				)
			));
		endif;
		if(!empty($restaurant_details)){
			$restaurants['keywords'] = strip_tags($restaurant_details[0]['Restaurant']['short_description']);
			$restaurants['description'] = strip_tags($restaurant_details[0]['Restaurant']['short_description']);	
			$this->set('meta_for_layout', $restaurants);	
			$this->set('title_for_layout', $restaurant_details[0]['Restaurant']['name']);
		}
		if(!empty($profile_reservation)){
			$offer_id = $profile_reservation[0]['Offer']['id'];
			$this->set('offer_id',$offer_id);
		}
		$this->set('reservation_id',$id);
		$this->set('restaurant_details',$restaurant_details);
	}
	
	function history(){
		$this->layout='home';
		$this->set('title_for_layout','My History');
		$user_id = $this->Auth->user('id');
		$this->paginate = array(
					'recursive'=>2,
					'conditions'=>array(
						'Reservation.userId'=>$user_id
						),
						'limit'=>5
					);
		$user = $this->paginate('Reservation');
		$this->set('user_history',$user);
	}
	
	function reservation(){
		$this->layout='popup';
		$this->set('title_for_layout','reservation');
	}
	
	function send($time,$date,$res_name,$res_id){
		$this->layout='popup';
		$this->set('title_for_layout','Send Invitation');
		$user_id = $this->Auth->user('id');
		$user = $this->User->find('all',array('conditions'=>array('User.id'=>$user_id)),array('fields'=>array('User.firstName','User.lastName','User.email')));
			$this->set('sender',$user);
			$res_url = Router::url(array(
					'controller' => 'homes',
					'action' => 'details',
				),true);
			$restaurant_url = $res_url."/".$res_id;
		if(!empty($this->data)):			
				$email = $this->EmailTemplate->selectTemplate('Send Invitation');
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,					
					'##SITE_NAME##' => Configure::read('site.name') ,
					'##RESTARUANT_LINK##' => $restaurant_url,
					'##RESTARUANT_NAME##' => $res_name,
					'##TIME##' => $time,
					'##DATE##' => $date,
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
					'##MESSAGE##' => $this->data['Profile']['content'],
					'##SUBJECT##' => $this->data['Profile']['subject'],
					'##FROM_EMAIL##' => $this->data['Profile']['name'],
				);
				$this->Email->from = (isset($this->data['Profile']['name'])) ? $this->data['Profile']['name'] : '';
				$this->Email->replyTo = (isset($this->data['Profile']['senderemail'])) ? $this->data['Profile']['senderemail'] : '';
				$this->Email->to = $this->data['Profile']['receiveremail'];
				$this->Email->subject = $this->data['Profile']['subject'];
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				if($this->Email->send(strtr($email['email_content'], $emailFindReplace))):
					$this->Session->setFlash('Your invitation sent successfully' , 'default', null, 'success');
				else:	
					$this->Session->setFlash('Your invitation doesn\'t send successfully. please try agian' , 'default', null, 'error');
				endif;
		endif;
	
	}
	
	function alerts(){
		$this->layout='home';
		$this->set('title_for_layout','My Alerts');
		$user_id = $this->Auth->user('id');
		$alert = $this->Alert->find('all',array('conditions'=>array('Alert.userId'=>$user_id),'recursive'=>1));
		if(!empty($alert)){
			foreach($alert as $alerts){
				$this->set('sunday',$alerts['Alert']['sunday']);
				$this->set('monday',$alerts['Alert']['monday']);
				$this->set('tuesday',$alerts['Alert']['tuesday']);
				$this->set('wednesday',$alerts['Alert']['wednesday']);
				$this->set('thursday',$alerts['Alert']['thursday']);
				$this->set('friday',$alerts['Alert']['friday']);
				$this->set('saturday',$alerts['Alert']['saturday']);
			}
		}
		$this->set('alert',$alert);
	}
	
	function alert_delete($id){
		$this->layout = 'ajax';
		if($this->Alert->delete($id)){
		    $user_id = $this->Auth->user('id');
			$alert = $this->Alert->find('all',array('conditions'=>array('Alert.userId'=>$user_id),'recursive'=>1));
			foreach($alert as $alerts){
				$this->set('sunday',$alerts['Alert']['sunday']);
				$this->set('monday',$alerts['Alert']['monday']);
				$this->set('tuesday',$alerts['Alert']['tuesday']);
				$this->set('wednesday',$alerts['Alert']['wednesday']);
				$this->set('thursday',$alerts['Alert']['thursday']);
				$this->set('friday',$alerts['Alert']['friday']);
				$this->set('saturday',$alerts['Alert']['saturday']);
			}
			$this->set('alert',$alert);
			$this->Session->setFlash('Restaurant deleted successfully' , 'default', null, 'success');
		}
		else{
			$this->Session->setFlash('Restaurant cannot be deleted' , 'default', null, 'error');
		}
	}
	
	function day_select(){
		$this->autoRender=false;
		$this->layout=false;
		if(!empty($this->data)){
		    $this->Alert->create();
			$this->Alert->save($this->data);
			$this->redirect($this->referer());
		}
	}
	
	function profile(){
		$this->layout='home';
		$this->set('title_for_layout','My Profiles');
		$this->update();
		$user_id = $this->Auth->user('id');
		$this->loadmodel('User');
		if(empty($this->data))
			$this->data = $this->User->read(null,$user_id);	
		$location = $this->Userlocation->find('all',array(
			'conditions'=>array(
				'userId'=>$user_id
			)
		));	
		$this->set('location',$location);
	}
	function update(){
		$this->User->set($this->data);
		if(!empty($this->data)){
			$this->User->validate = array();
			if($this->data['User']['card_type'] != '')
					$this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
			if ($this->User->validates()) {	
				if($this->data['User']['card_type'] != ''){
					$sender_info['is_testmode'] = 1;
					$sender_info['API_UserName'] = 'c.mahe_1301923521_biz_api1.yahoo.com';
					$sender_info['API_Password'] = '1301923531';
					$sender_info['API_Signature'] = 'AOJLm2qaQZXvoa4AI7KBtezDk4e8ASH09ugd4FTFc2TmZ-EdGxBxPyT8';
					
					$data_credit_card['firstName'] 				= $this->data['User']['holder_fname'];
					$data_credit_card['lastName'] 				= $this->data['User']['holder_lname'];
					$data_credit_card['creditCardType'] 		= $this->data['User']['card_type'];
					$data_credit_card['creditCardNumber'] 		= $this->data['User']['creditCardNumber'];
					$data_credit_card['expDateMonth']['month'] 	= $this->data['User']['expDateMonth']['month'];
					$data_credit_card['expDateYear']['year'] 	= $this->data['User']['expDateYear']['year'];
					$data_credit_card['cvv2Number'] 			= $this->data['User']['cvv2Number'];
					$data_credit_card['address'] 				= '648 Lake view';
					$data_credit_card['city'] 					= 'New york';
					$data_credit_card['state'] 					= 'Alaska';
					$data_credit_card['zip'] 					= '10005';
					$data_credit_card['country'] 				=  'US';
					
					$data_credit_card['paymentType'] = 'Authorization';
					$data_credit_card['amount'] = 1;
					$payment_response = $this->Paypal->doDirectPayment($data_credit_card, $sender_info);
					
					if(!empty($payment_response) && $payment_response['ACK'] == 'Success'):
						$this->data['User']['billingKey']=$payment_response['TRANSACTIONID'];
						$post_info['authorization_id'] = $payment_response['TRANSACTIONID'];
						$post_info['note'] = 'User registration';
						$payment_responses = $this->Paypal->doVoid($post_info, $sender_info);
					else:	
						$message=$payment_response['L_LONGMESSAGE0'];
						$this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error');
						return;
					endif;	
					
				}
				$card_number = $this->data['User']['creditCardNumber'];
				$this->data['User']['card_number'] = substr($card_number,-4,4);	
				if ($this->User->save($this->data, false)) {
					$this->Session->setFlash(__l('You have successfully updated with our site.') , 'default', null, 'success');
				}	
			} else {				
				if($this->data['User']['hidden_payment']==''){
					if ($this->User->save($this->data, false)) {
						$this->Session->setFlash(__l('You have successfully updated with our site.') , 'default', null, 'success');
					}
				}			
			}	
		}
	}
	
	function cancel() {
		$this->layout = 'ajax';
		$user_id = $this->Auth->User('id');
		$user = $this->User->find('all',array(
			'conditions'=>array(
				'User.id'=>$user_id
			)
		));
		if(!empty($this->params['pass'][0])){
			$reserv_id = $this->params['pass'][0];			
			$change_approved = $this->Reservation->find('first',array(
				'conditions'=>array(
					'Reservation.id'=>$reserv_id
				),
				'fields'=>array(
					'approved'
				)
			));
			$approved = $change_approved['Reservation']['approved'];
			if($approved==1){
				$this->Reservation->updateAll(array(
						'Reservation.approved'=>0
						),array(
							'Reservation.id' => $reserv_id
				));
				$this->Session->setFlash(__l('Your Reservation has cancelled successfully.') , 'default', null, 'success');
			} else {
				$this->Session->setFlash(__l('Your Reservation cancelled process is not completed. Please, try again.') , 'default', null, 'error');
			}
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
		}
	}
	
	function search(){
		$this->layout='ajax';
		$party_size = 2;
		if (!empty($this->params['form']['id'])){ 
			$this->layout=false;
			$party_size = $this->params['form']['id'];
		}
		$this->set('party_size', $party_size);
		$this->set('title_for_layout','Search');
		$this->loadmodel('Neighborhood');
		$neighbor_list = $this->Neighborhood->find('list',array(
			'fields'=>array(
					'name'
			)
		 ));
		$this->set('neighbor_list',$neighbor_list);
		$this->loadmodel('Cuisine');
		$cuisine_list = $this->Cuisine->find('list',array(
			'fields'=>array(
				'name'
			)
		));
		$this->set('cuisine_list',$cuisine_list);
		if($this->data){
			$this->Session->write('rest',$this->data['Profile']['search']);
		}
		$search_term = $this->Session->read('rest');
		$this->paginate = array(
			'conditions' => array(
				'Restaurant.approved'=>1,
				'Restaurant.name LIKE'=> "%".$search_term."%"
			),
			'contain' => array(			
				'Restaurantcuisine' =>array(
					'Cuisine' => array(
						'fields' => array(
							'Cuisine.name',
						)
					)
				)
			 ),	
			 'fields' => array(
				'Restaurant.id',
				'Restaurant.name',
				'Restaurant.city',
				'Restaurant.logo',
				'Restaurant.startTime',
				'Restaurant.endTime'
			),	
			'limit'=>10,		
			'recursive'=>2
		);
		$result = $this->paginate('Restaurant');
		$count = count($result);
		$this->set('count',$count);
		if($count==1){
			foreach($result as $data){
				$redirect_url = Router::url(array('controller' => 'homes','action' => 'details',$data['Restaurant']['id']));
				echo "<script>window.parent.location.href='$redirect_url'</script>";
			}
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
		else{
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
	}
	
	function change_reservation(){
		$this->layout='popup';
		if(!empty($this->params['url'])) {
			$name = $this->params['url']['name'];
			$time = $this->params['url']['time'].$this->params['url']['ampm'];
			$size = $this->params['url']['party'];
			$offer_id = $this->params['url']['offer_id'];
			$rest_id = $this->params['url']['rest_id'];			
			$date = date('Y-m-d');			
			$reservationtime = strtotime($time);			
			$select_time = date('H:i:s',$reservationtime);			
			$change_reservation_time = $this->Offer->find('all',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Offer.offerDate'=>$date,
					'Offer.restaurantId'=>$rest_id,
					'Offer.seating'=>$size,
					'NOT'=>array(
						'Offer.id'=>$offer_id,
						'Offer.offerTime'=>$select_time
					)
				),
				'fields'=>array(
					'offerTime'
				)				
			));
			$this->set('change_reservation_time',$change_reservation_time);
			$this->set('time',$time);
			$this->set('size',$size);
			$this->set('name',$name);
			$this->set('rest_id',$rest_id);
			$this->set('offer_id',$offer_id);
		}
	}
	
	function change_size(){
		if(!empty($this->params['form'])){
			$size = $this->params['form']['id'];
			$reservation_time = $this->params['form']['reservation_time'];
			$rest_id = $this->params['form']['rest_id'];
			$offer_id = $this->params['form']['offer_id'];
			$date = date('Y-m-d');			
			$reservationtime = strtotime($reservation_time);			
			$select_time = date('H:i:s',$reservationtime);			
			$change_reservation_time = $this->Offer->find('all',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Offer.offerDate'=>$date,
					'Offer.restaurantId'=>$rest_id,
					'Offer.seating'=>$size,
					'NOT'=>array(
						'Offer.offerTime'=>$select_time
					)
				),
				'fields'=>array(
					'offerTime'
				)				
			));	
			$this->set('change_reservation_time',$change_reservation_time);	
		} 
	}
	
	function update_changetime(){
		$this->layout = 'ajax';
		$user_id = $this->Auth->User('id');
		if(!empty($this->params['form'])){
			$time = $this->params['form']['reservation_time'];
			$select_time = date('H:i:s',$time);
			$date = date('Y-m-d');		
			$size = $this->params['form']['size'];
			$this->loadmodel('Offer');
			$reservation_id = $this->Reservation->find('first',array(
				'conditions'=>array(
					'userId'=>$user_id,
					'Reservation.approved'=>1
				),
				'fields'=>array(
					'Reservation.id',
					'Reservation.offerId'
				),
				'order'=>'Reservation.id Desc'
			));
			$offerId = $reservation_id['Reservation']['offerId'];
			$reser_id = $reservation_id['Reservation']['id'];
			$offerid = $this->Offer->find('first',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Offer.offerTime'=>$select_time,
					'Offer.offerDate'=>$date,
					'Offer.seating'=>$size
				),
				'fields'=>array(
					'Offer.id'
				)
			));
			$id = $offerid['Offer']['id'];
			$this->Reservation->updateAll(array('offerId' =>$id), array('Reservation.offerId' => $offerId, 'Reservation.id' => $reser_id));
			$profile_reservation = $this->Reservation->find('all',array(
				'conditions'=>array(
					'Reservation.id'=>$reser_id,
					'Reservation.userId'=>$user_id,
					'Reservation.approved'=>1
				),
				'fields'=>array(
					'Offer.id',
					'Offer.seating',
					'Offer.offerTime',
					'Offer.restaurantId'
				)
			));
			$starttime=strtotime( $profile_reservation[0]['Offer']['offerTime']);
			echo "TIME : ".date('h:i A',$starttime)."<br /> PARTY: ".$profile_reservation[0]['Offer']['seating']."<span id='timming'>".date('h:i A',$starttime)."$".$profile_reservation[0]['Offer']['seating']."$".$profile_reservation[0]['Offer']['id'];
		} 
		$this->autoRender = false;
	}
	
	
}
?>