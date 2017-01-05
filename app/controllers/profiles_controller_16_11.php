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
	var $components = array('Auth','Nmiquery','Email');
 
	function index(){
		$this->layout='home';
		$this->set('title_for_layout','My Reservation');
		$user_id = $this->Auth->user('id');
		$user_location = $this->Userlocation->find('first',array(
				'conditions'=>array(
					'userId'=>$user_id
				),
				'fields'=>array(
					'Userlocation.address',
					'Userlocation.city',
					'Userlocation.state'
				),
			));
		$this->set('user_location',$user_location);
		$this->loadmodel('Reservation');
		if(isset($_REQUEST['facebook'])){
			$redirectUrl = $this->Session->read('Auth.redirectUrl');
			$account_type = $this->Auth->user('account_type'); 
			if($account_type==2){
				$this->Cookie->delete('User');
				$this->Auth->logout();
				$this->Session->delete('Auth.redirectUrl');
				$this->redirect('/home');
			}
			$this->set('redirectUrl',$redirectUrl);
		}else{
			$redirectUrl='';
			$this->set('redirectUrl',$redirectUrl);
		}
		if(isset($_REQUEST['success'])){
			$this->Session->setFlash('You have successfully logged in', 'default', null, 'success');
		}
		if(isset($_REQUEST['referencetransaction'])){
			$this->Session->setFlash('Thank you for spending your credit on another reservation! Enjoy your dinner!', 'default', null, 'success');
		}
		if(isset($_REQUEST['transaction'])){
			$this->Session->setFlash('Thank you for your new reservation! Enjoy your dinner!', 'default', null, 'success');
		}
		if(isset($_REQUEST['changed'])){
			$this->Session->setFlash('Your reservation has been modified, thanks!', 'default', null, 'success');
		}
		if(isset($_REQUEST['error'])){
			$r_url=Router::url(array('controller'=>'profiles','action'=>'profile'),true);
			$message="There was an issue processing your payment. Please update your billing information in <a href='$r_url' onclick='parent.location.href=this.href; return false;'>your profile</a>";
			$this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error');
		}
		$condtion = array();
		$order='Offer.offerTime';
		$date=date('Y-m-d');
		$condtion['Reservation.userId'] = $user_id;
		$condtion['Reservation.approved'] = 1;
		$condtion['Offer.offerDate >='] = $date;	
		$condtion['Offer.offerTime >=']=date('H:i:s');
		if(!empty($this->params['pass'][0])){
			$current_res_id=$this->params['pass'][0];
			$condtion['Reservation.id']=$current_res_id;
			$profile_reservation_first= $this->Reservation->find('all',array(
				'conditions'=>$condtion,
				'contain'=>array(
					'Offer'=>array('Restaurant')
				 ),
				'order'=>$order,
				'recursive'=>2
					
			));
			unset($condtion['Reservation.id']);
			$condtion['Reservation.id !=']=$current_res_id;
		}
		
		//echo date('H:i:s');
		
		$profile_reservation= $this->Reservation->find('all',array(
			'conditions'=>$condtion,
			'contain'=>array(
				'Offer'=>array('Restaurant')
			 ),
			'order'=>$order,
			'recursive'=>2
				
		));
		if(!empty($profile_reservation_first))
			$profile_reservation=array_merge($profile_reservation_first,$profile_reservation);
			
		$this->set('restaurant_details',$profile_reservation);

	}
	function history(){
		$this->layout='home';
		$this->set('title_for_layout','My History');
		$user_id = $this->Auth->user('id');
		$this->paginate = array(
					'recursive'=>2,
					'conditions'=>array(
						'Reservation.userId'=>$user_id,
						'Reservation.approved'=>1
						),
						'order'=>array('Reservation.id DESC'),
						'limit'=>5
					);
		$user = $this->paginate('Reservation');
		//pr($user);
		$this->set('user_history',$user);
		$deal=$this->Restaurant->dealtime();
		$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	}
	
	function reservation(){
		$this->layout='popup';
		$this->set('title_for_layout','reservation');
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
		$deal=$this->Restaurant->dealtime();
		$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	}
	
	function chicago_alerts(){
		$this->layout='chicagomag';
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
		$deal=$this->Restaurant->dealtime();
		$this->set('dealtime',$deal[0][0]['max(offerTime)']);
		$this->render('alerts');
	}
	
	function alert_delete($id){
		$this->layout = 'ajax';
                $user_id = $this->Auth->user('id');
                $condition = array('restaurantId'=>$id,'userId'=>$user_id);
		if($this->Alert->deleteAll($condition)){		    
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
			unset($this->data['User']['cvv2Number']);
		$location = $this->Userlocation->find('all',array(
			'conditions'=>array(
				'userId'=>$user_id
			)
		));	
		$this->set('location',$location);
		$deal=$this->Restaurant->dealtime();
		$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	}
	
	function select_address($transactionId=null){
		$this->layout='popup';
		$this->set('title_for_layout','Get Direction');
		$user_id = $this->Auth->user('id');
		$this->set('transactionId',$transactionId);
		if(isset($transactionId)){
			$transaction=$transactionId;
		}
		if(!empty($this->data['Userlocation']['id'])){
			$transaction=$this->data['User']['transactionId'];
			$user_location=$this->Userlocation->findById($this->data['Userlocation']['id']);
			$this->loadmodel('City');
			$profile_reservation = $this->Reservation->find('first',array(
			'conditions'=>array(
				'Reservation.userId'=>$user_id,
				'Reservation.transactionId'=>$transaction,
				'Reservation.approved'=>1
			)
			));
			$restaurant_details = $this->Restaurant->find('first',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Restaurant.id'=>$profile_reservation['Offer']['restaurantId'],
					'Restaurant.approved'=>1
				)
			));
				$city_name=$this->City->findById($restaurant_details['Restaurant']['city']);
				echo '<script type="text/javascript">parent.window.open("http://maps.google.com/maps?saddr='.$user_location["Userlocation"]["address"].','.$user_location["Userlocation"]["city"].'+'.$user_location["Userlocation"]["state"].'&daddr='.$restaurant_details["Restaurant"]["address"].','.$city_name["City"]["city_name"].'+'.$restaurant_details["Restaurant"]["state"].'","_new");parent.$.colorbox.close();</script>';
		}else{
			$locations = $this->Userlocation->find('all',array(
				'conditions'=>array(
					'userId'=>$user_id
				)
			));	
			$options=array();
			foreach($locations as $location){
				$options[$location['Userlocation']['id']]=$location['Userlocation']['full_address'];
			}
			$this->set('options',$options);
		}
	}
	function check_login(){
		$this->layout=false;
		$user_id = '';
		if($this->Auth->user('id')){
			$user_id=$this->Auth->user('id');
		}
		$this->set('user_id',$user_id);
	}
	
	function Payscape_key(){
		$sender_info['is_testmode'] = 1;				
		$sender_info['API_UserName'] = 'c.mahe_1301923521_biz_api1.yahoo.com';
		$sender_info['API_Password'] = '1301923531';
		$sender_info['API_Signature'] = 'AOJLm2qaQZXvoa4AI7KBtezDk4e8ASH09ugd4FTFc2TmZ-EdGxBxPyT8';
		return $sender_info;
	}
	
	function update(){
		$this->User->set($this->data);
		if(!empty($this->data)){
			//$this->User->validate = array();
			if($this->data['User']['card_type'] != '' && $this->data['User']['hidden_payment'] == 1) 
					$this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
			/*else{
				unset($this->data['User']['holder_fname']);
				unset($this->data['User']['holder_lname']);
				unset($this->data['User']['card_type']);
				unset($this->data['User']['creditCardNumber']);
				unset($this->data['User']['expDateMonth']);
				unset($this->data['User']['expDateYear']);
				unset($this->data['User']['cvv2Number']);
				unset($this->data['User']['hidden_payment']);
				$this->User->set($this->data);
				pr($this->User->validate);
				pr($this->data);
			}*/	
			$last_user_id = $this->Auth->User('id');
			if ($this->User->validates()) {	
				if($this->data['User']['card_type'] != '' && $this->data['User']['hidden_payment'] == 1) {
					if(!empty($last_user_id))
						$last_user_id= $last_user_id+1;
					else
						$last_user_id = rand(1,99999);
					$last_user_id ='9789432110'.rand(10,99999).$last_user_id;
					
					$data_credit_card['customer_vault_id'] = '';	
					$data_credit_card['firstName'] 				= $this->data['User']['holder_fname'];
					$data_credit_card['lastName'] 				= $this->data['User']['holder_lname'];
					$data_credit_card['creditCardType'] 		= $this->data['User']['card_type'];
					$data_credit_card['creditCardNumber'] 		= $this->data['User']['creditCardNumber'];
					$data_credit_card['expDateMonth']['month'] 	= $this->data['User']['expDateMonth']['month'];
					$data_credit_card['expDateYear']['year'] 	= $this->data['User']['expDateYear']['year'];
					$data_credit_card['cvv2Number'] 			= $this->data['User']['cvv2Number'];
					$payment_responses = $this->Nmiquery->doVaultPost($data_credit_card);
					if(!empty($payment_responses) && $payment_responses['response'] == 1):
						$this->data['User']['billingKey']=$payment_responses['customer_vault_id'];
					else:	
						//$message=$payment_response['result'];
						$message="There was an issue processing your payment. Please update your billing information in your profile";
						$this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error');
						return;
					endif;	
					$card_number = $this->data['User']['creditCardNumber'];
					$this->data['User']['card_number'] = substr($card_number,-4,4);	
				}
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__l('You have successfully updated with our site.') , 'default', null, 'success');
					$this->data = $this->User->read(null,$this->Auth->User('id'));
				}	
			} else {	
				if($this->data['User']['hidden_payment']==''){
					if ($this->User->save($this->data)) {
						$this->Session->setFlash(__l('You have successfully updated with our site.') , 'default', null, 'success');
						$this->data = $this->User->read(null,$this->Auth->User('id'));
					}
				}			
			}	
		}
	}
	function cancel() {
            $this->layout = 'ajax';
            $reservation_id = '';
            if(!empty($this->params['pass'][0])){
                $reservation_id = $this->params['pass'][0];
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
                if(empty($reservation)){
                    $this->Session->setFlash(__l("Your Reservation already cancelled.") , 'default', null, 'error');
                    return true;
                }
                $reserve_time = strtotime($reservation['Offer']['offerTime'])-1800;
                $last_time=strtotime(date('H:i:s'));
                $convert_time = date('H:i',$last_time);
                $convet_reserve_time = date('H:i',$reserve_time);
                if($reserve_time>=$last_time){
                    //cancel the reservation
                    $reservation_canled = $this->Reservation->updateAll(array(
                        'Reservation.approved'=>0
                    ),array(
                        'Reservation.id' => $reservation_id
                    ));
                    if($reservation_canled){  
                        //save user amount
                        $amount = $reservation['User']['user_amount'] + 5;
                        $data = array('User' => array('id' => $reservation['User']['id'],'user_amount' => $amount));
                        $this->User->save($data, false, array('user_amount'));

                        $seating = $reservation['Offer']['seating'];
                        if($reservation['Offer']['seating_custom']!=0)
                            $seating = $reservation['Offer']['seating_custom'];
							
							$offer_update = $this->Offer->updateAll(array(
								'Offer.seating_custom'=>0
							),array(
								'Offer.id' => $reservation['Offer']['id']
							));

                        $date   = strtotime($reservation['Offer']['offerDate']);
                        $time   = date('H:i A');
                        $day    = date('l',$date);
                        $month  = date('F',$date);
                        $year   = date('Y',$date);
                        $dat    = date('l, F dS',$date);
                        $rand_string = $this->generateRandomString();
                        $resturant_name = $reservation['Offer']['Restaurant']['name'];
                        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Cancel Reservation');
                        $emailFindReplace = array(
                            '##SITE_LINK##' => Router::url('/', true) ,					
                            '##SITE_LOGO##' => Configure::read('website.logo'),
                            '##FACEBOOK##' => Configure::read('website.facebook'),
                            '##TWITTER##' => Configure::read('website.twitter'),
                            '##SITE_NAME##' => Configure::read('website.name'),
                            '##NAME##' => $reservation['User']['firstName'],
                            '##SIZE##' => $seating,
                            '##RESNAME##' => $resturant_name,
                            '##DAY##' => $day,
                            '##MONTH##' => $month,
                            '##DATE##' => $dat,
                            '##YEAR##' => $year,
                            '##TIME##'=>date('h:i A',strtotime($reservation['Offer']['offerTime'])),
                            '##Unsubscribe_email##' =>Router::url('alerts/subscribe_email/'.$rand_string, true)
                        );
                        $sub="Your "."'".$reservation['Offer']['Restaurant']['name']."'"." Reservation Cancellation";
                        $this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
                        $this->Email->replyTo = 'support@tablesavvy.com';
                        //$this->Email->cc  = 'rkssaravanan12@gmail.com';
                        $this->Email->to = $reservation['User']['email'];
                        $this->Email->subject =$sub;
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        $this->send_cancel_email($reservation,$seating,$resturant_name,$dat) ;   
                        $this->Session->setFlash(__l('Your Reservation has cancelled successfully.') , 'default', null, 'success');

                    }else{
                        $this->Session->setFlash(__l("Your Reservation doesn't cancelled successfully.") , 'default', null, 'error');
                    }
                }else{
                    $this->Session->setFlash(__l('Your Reservation time is passed. You cannot cancel the reservation.') , 'default', null, 'error');
                }
            }
            $redirect_url = Router::url(array('controller' => 'profiles','action' => 'index',$reservation_id));
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
			if(!empty($this->data['Profile'])){
				$this->Session->write('rest',$this->data['Profile']['search']);
			}
			else{
				$this->Session->write('rest',$this->data['User']['search']);
			}
		}
		$search = $this->Session->read('rest');
		$search_term = trim($search);
		if(!empty($search_term)){
                $search_condition['Restaurant.name LIKE'] ='%'.$search_term .'%';
                $search_condition['Restaurant.approved'] = 1;
                $search_condition['Restaurant.city'] = Configure::read('website.city_id');    
		$this->paginate = array(
			'conditions' => $search_condition,
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
				'Restaurant.neighborhoodId',
				'Restaurant.logo',
				'Restaurant.startTime',
				'Restaurant.endTime'
			),	
			'limit'=>8,		
			'recursive'=>2
		);
		$result = $this->paginate('Restaurant');
		$count = count($result);
		$this->set('count',$count);
		if($count==1){
			foreach($result as $data){
				$redirect_url = Router::url(array('controller' => 'homes','action' => 'details',$data['Restaurant']['id']));
				echo "<script>window.parent.location.href='$redirect_url'</script>";
				$this->autoRender=false;
			}
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
		else{
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
		}
		else{
			$this->set('count',-1);
		}
	}
	function change_reservation(){
            $this->layout = 'popup';
            if(!empty($this->params['url']['rest_id']))                
                $restuarant_id = $this->params['url']['rest_id'];
            if(!empty($this->data['Restaurant']['id']))
                $restuarant_id = $this->data['Restaurant']['id'];
            $restaurant = $this->Restaurant->find('first',array(
                'recursive'=>-1,
                'conditions'=>array(
                        'Restaurant.id'=>$restuarant_id
                ),
                'fields'=>array(
                    'id',
                    'name',
                    'startTime',
                    'endTime',
                    'phone',
                    'address',
                    'state',
                    'city'
                )				
            ));
            $party_sizes = array('2'=>2,'3'=>4,'4'=>4,'5'=>6,'6'=>6,'7'=>8,'8'=>8);
            if(!empty($this->params['url']['rest_id'])){
                $restuarant_id = $this->params['url']['rest_id'];
                $reservation_id = $this->params['url']['reservation_id'];
                $reservedsize = $this->params['url']['party'];
                $party_size = $party_sizes[$this->params['url']['party']];
                $offer_id = $this->params['url']['offer_id'];
                $time = $this->params['url']['time'];
                $ampm = $this->params['url']['ampm'];
                $reservationtime = $time.' '.$ampm; 
                $conditions['Offer.seating'] = $party_size;
                $party_size = $reservedsize;
                
            }else{    
                $restuarant_id = $this->data['Restaurant']['id'];
                $reservationtime = $this->data['Offer']['time']; 
                $offer_id = $this->data['Offer']['id']; 
                $party_size = $this->data['User']['size'];
                $conditions['Offer.offerTime >'] = date('H:i A');
                $conditions['Offer.seating'] = $party_sizes[$party_size];
                $reservedsize = $this->data['Offer']['reserved_size'];
                $reservation_id = $this->data['Reservation']['id'];
            }
            /*$starttime=strtotime($restaurant['Restaurant']['startTime']);
            $select_time = strtotime($reservationtime);
            $current_time = time('H i A');
            if($select_time>$current_time)
                $start_time = date('H:i:s', $select_time);
            else
                $start_time = date('H:i:s', $current_time);
            $selected_end_time ='';
            $conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
                $start_time ,
                $restaurant['Restaurant']['endTime']
            );*/
            
            $conditions['Offer.offerTime >'] = date('H:i:s');
            
            $reservation_list = $this->Reservation->find('list',array(
                'fields'=>array(
                    'Reservation.offerId','Reservation.offerId'
                    ),
                'conditions'=>array(
                    'Reservation.approved'=>1
                )
            ));
            $conditions['NOT']=array('Offer.id'=>$reservation_list);
            //pr($conditions);
            $currentdate = date('Y-m-d'); 
            $conditions['Offer.offerDate'] = $currentdate; 
            $conditions['Offer.restaurantId'] = $restuarant_id;
            $reservation_time = $this->Offer->find('list',array(
                'recursive'=>-1,
                'conditions'=> $conditions,
                'fields'=>array(
                        'id',
                        'offerTime'
                ),
                'group'=> 'offerTime',
                'order'=> 'offerTime'
            ));
            
            if(isset($this->data['User']['save_offer']) && $this->data['User']['save_offer']==2){
                $this->data['Offer']['id'] = $this->data['Reservation']['offerId'] = $this->data['User']['time'];
                $this->data['Reservation']['chicagomag'] = Configure::read('website.id');
                
                $normal_party_size = array(2,4,6,8);
                $cutom_size = $this->data['User']['size'];
                if(in_array($cutom_size, $normal_party_size))
                        $cutom_size = 0;
                $this->data['Offer']['seating_custom'] = $cutom_size;
                
                $this->Reservation->set($this->data['Reservation']);
                $this->Reservation->save();
                
                $this->Offer->updateAll(
                        array('Offer.seating_custom' => $cutom_size),
                        array('Offer.id' => $this->data['Offer']['id'])
                );
                
                
                $this->send_mail($this->data['Reservation']['offerId'],$this->data['User']['size'],$restaurant);
                $this->Session->setFlash(__l('Your Reservation changed successfully.') , 'default', null, 'success');
                $profile_url = $this->redirect(array('controller'=>'profiles','action'=>'index',$this->data['Reservation']['id']));
                
            }
            
            $this->set('time',$reservationtime);
            $this->set('size',$party_size);
            $this->set('offer_id',$offer_id);
            $this->set('restaurant',$restaurant);
            $this->set('reservation_time',$reservation_time);
            $this->set('reservedsize',$reservedsize);
            $this->set('reservation_id',$reservation_id);
            
            
        }
        function send_mail($offerId,$cutom_size,$restaurant){
            $offer_times = $this->Offer->find('first',array(
                'conditions'=>array(
                    'Offer.id'=> $offerId
                ),
                'fields'=>array(
                    'Offer.offerTime',
                    'Offer.offerDate'
                )
            ));
            $user_id = $this->Auth->User('id');
            $user = $this->User->find('first',array(
                'conditions'=>array(
                        'User.id'=>$user_id
                ),
                'fields'=>array(
                        'billingKey',
                        'firstName',
                        'lastName',
                        'email',
                        'email_subscription'
                ),
                'recursive'=>-1
            ));
            $phone = $restaurant['Restaurant']['phone'];
            $first = substr($phone,0,3); 
            $middle = substr($phone,3,3);
            $last = substr($phone,6,4);
            
            $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Modify Reservation');
            $rand_string = $this->generateRandomString();
            $emailFindReplace = array(
				'##SITE_LINK##' => Router::url('/', true) ,					
				'##SITE_LOGO##' => Configure::read('website.logo'),
				'##FACEBOOK##' => Configure::read('website.facebook'),
				'##TWITTER##' => Configure::read('website.twitter'),
				'##SITE_NAME##' => Configure::read('website.name'),
                '##NAME##' => $user['User']['firstName'],
                '##SIZE##' => $cutom_size,
                '##RESNAME##' => $restaurant['Restaurant']['name'],
                '##DAY##' => date('l'),
                '##MONTH##' => date('F'),
                '##DATE##' => date('l, F dS'),
                '##YEAR##' => date('Y'),
                '##TIME##'=> date('h:i a',strtotime($offer_times['Offer']['offerTime'])),
                '##PHONE##'=>"(".$first.")"." ".$middle."-".$last,
                '##ADDRESS##'=>$restaurant['Restaurant']['address'].'<br>'.'Chicago, '.$restaurant['Restaurant']['state'],
                '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/'.$rand_string, true),
				'##LOGO##'=>Router::url('/images/logo.png',true)
            );
            $sub="Your "."'".$restaurant['Restaurant']['name']."'"." Reservation Change";
            $this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
            $this->Email->replyTo = 'support@tablesavvy.com';
			$this->Email->cc  = 'shahul@farshore.com';
            //$this->Email->cc  = 'rkssaravanan12@gmail.com';
            $this->Email->to = $user['User']['email'];
            $this->Email->subject =$sub;
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
            
        }	
        function send_cancel_email($reservation,$seating,$resturant_name,$dat){
            $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' cancel owner');
            $rand_string = $this->generateRandomString();
            $emailFindReplace = array(
                '##SITE_LINK##' => Router::url('/', true) ,					
                '##SITE_LOGO##' => Configure::read('website.logo'),
                '##FACEBOOK##' => Configure::read('website.facebook'),
                '##TWITTER##' => Configure::read('website.twitter'),
                '##SITE_NAME##' => Configure::read('website.name'),
                '##NAME##' => $reservation['User']['firstName'],
                '##SIZE##' => $seating,
                '##RESNAME##' => $resturant_name,
                '##DATE##' => $dat,
                '##TIME##'=>date('h:i A',strtotime($reservation['Offer']['offerTime'])),
                '##Unsubscribe_email##' =>Router::url('alerts/subscribe_email/'.$rand_string, true)
            );
            $sub= "Reservation Cancelation via ".Configure::read('website.name');
            $this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
            $this->Email->replyTo = 'support@tablesavvy.com';
            $this->Email->cc  = 'shahul@farshore.com';
            $this->Email->to = $reservation['User']['email'];
            $this->Email->subject =$sub;
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        }
}

?>