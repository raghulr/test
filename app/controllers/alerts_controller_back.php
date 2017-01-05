<?php
class AlertsController extends AppController{
    var $uses = array('Alert','Reservation','Offer','User','AlertResponse','Restaurant','EmailTemplate');
	var $components = array('Email');
	function day_select(){
		$this->layout = 'ajax';
		$user_id = $this->Auth->user('id');
			$update_day = $this->Alert->updateAll(array('Alert.sunday' =>"'".$this->data['Alert']['sunday']."'",'Alert.monday' =>"'".$this->data['Alert']['monday']."'",'Alert.tuesday' =>"'".$this->data['Alert']['tuesday']."'",'Alert.wednesday' =>"'".$this->data['Alert']['wednesday']."'",'Alert.thursday' =>"'".$this->data['Alert']['thursday']."'",'Alert.friday' =>"'".$this->data['Alert']['friday']."'",'Alert.saturday' =>"'".$this->data['Alert']['saturday']."'"),array('Alert.userId' => $user_id));
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
			$this->set('alert',$alert);
			if($update_day){
				$this->Session->setFlash('Days updated successfully' , 'default', null, 'success');
			}
			else{
				$this->Session->setFlash('Days cannot be updated' , 'default', null, 'error');
			}
		}
		else{
			$this->Session->setFlash('Restaurant not found' , 'default', null, 'error');
		}
	}
	function alert_response(){
		$this->autoRender=false;
		if(isset($_REQUEST['actions'])&&isset($_REQUEST['callerid'])){
				$callactions=$_REQUEST['actions'];
				$callerid=$_REQUEST['callerid'];
				$this->AlertResponse->create();
				$alert = $this->AlertResponse->save(array(
					'actions'=>$callactions,
					'callerid'=>$callerid
				));
		}
	}
	function call_user(){
		$this->autoRender = false;
		$date = date('Y-m-d');
		$weekday = date('l', strtotime($date)); 
		$user_id = $this->Alert->find('list',array('conditions'=>array($weekday=>1),'recursive'=>-1,'fields'=>array('userId')));
		$allres=$this->Alert->find('all',array('conditions'=>array($weekday=>1),'recursive'=>-1,'fields'=>array('restaurantId','userId')));
		$user_phone=$this->User->find('all',array('conditions'=>array('id'=>$user_id),'recursive'=>-1,'fields'=>array('phone')));
		$reser_id = $this->Reservation->find('list',array('recursive'=>-1,'fields'=>array('offerId')));
		$result = $this->Offer->find('all',array(
			'recursive'=>-2,
			'fields'=>array('restaurantId','seating','offerDate','offerTime'),
			'conditions'=>array(
				'Offer.restaurantId'=>$ale,
				
			'NOT'=>array(
					'Offer.id'=>$reser_id
				),
			)
		));
						foreach($user_phone as $user) {
							$url = "https://secure.ifbyphone.com/click_to_xyz.php"; 
							$postvalue = 'app=cts&phone_to_call="'.$user['User']['phone'].'"&survo_id=376011&key=ac9e1ae41b9e459d7b14101fa13dc2b5569a87f6';
							$ch=curl_init();
							curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
							curl_setopt($ch,CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_POST,1);
							curl_setopt($ch, CURLOPT_POSTFIELDS,$postvalue);
							curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							$json=curl_exec($ch);
							//pr($json);
						}	
	}
	
	function change_day(){
		$userid=$this->Auth->user('id');
		if($this->params['form']['id'] == 0){
			$approved=1;
			$this->Session->setFlash('Alert days was selected successfully' , 'default', null, 'success');
		} else {
			$approved=0;	
			$this->Session->setFlash('Alert days was unselected successfully ' , 'default', null, 'error');
		}				
		$this->Alert->updateAll(array(
			'Alert.dayselect' =>$approved),
			array('Alert.userid' => $userid)
		);
		$alert = $this->Alert->find('all',array(
			'conditions'=>array(
				'Alert.userId'=>$userid
			),
			'recursive'=>1
		));
		$this->set('alert',$alert);
	}
	
	
	
	function alert_mail(){ 
		$this->autoRender = false;
		$date = date('Y-m-d');
		//$date = '2011-11-19';
		$weekday = date('l', strtotime($date));
		//exit; 
		$user = $this->Alert->find('list',array('conditions'=>array($weekday=>1),'recursive'=>-1,'fields'=>array('userId')));
		$user=array_unique($user);
		$reser_id = $this->Reservation->find('list',array('recursive'=>-1,'fields'=>array('offerId')));
		//pr($user);
		if(!empty($user)){
		$i =0;
		$j=0;
			foreach($user as $use) {
				$users = $this->Alert->find('all',array('conditions'=>array('userId'=>$use),'recursive'=>-1,'fields'=>array('restaurantId')));
				//echo $use;
				if(!empty($users)){
					foreach($users as $uses) {
						$result = $this->Offer->find('all',array(
							'recursive'=>2,
							'fields'=>array('restaurantId','seating','offerDate','offerTime'),
							'conditions'=>array(
							'Offer.restaurantId'=>$uses['Alert']['restaurantId'],
							'Offer.offerDate'=>$date,
							'NOT'=>array(
								'Offer.id'=>$reser_id
								)
							),
							'contain'=>array(
							'Restaurant'=>array(
							'fields'=>array(
							'name'
										   )
										)
									)
							));
						if(!empty($result)){
							foreach($result as $res){
							$user_details=$this->User->find('first',array('conditions'=>array('id'=>$use,'account_type'=>3),'recursive'=>-1,'fields'=>array('email','id','email_subscription')));
							//pr($user_details);
									if($user_details['User']['email_subscription']==1){
										$time=date("h:i a",strtotime($res['Offer']['offerTime']));
										$rand_string = $this->generateRandomString();
										//$email = $this->EmailTemplate->selectTemplate('Alerts mail');
										$res[]=$res['Restaurant']['name'];
										$offer[]=$res['Offer']['offerDate'];
										$offer_time[]=$time;
										$seat[]=$res['Offer']['seating'];
										//$j++;
									}
							}
							$alert_mail=array_merge($res,$offer,$offer_time,$seat);
							pr($alert_mail);
							$this->Email->from = 'support@tablesavvy.com';
							$this->Email->replyTo = 'support@tablesavvy.com';
							$this->Email->to = $user_details['User']['email'];
							//$this->Email->to='mathiseelan88@gmail.com';
							//$this->Email->cc  = 'rkssaravanan12@gmail.com';
							$this->Email->subject = 'Reservation alerts';
							$this->Email->template = 'alert_mail';
							$this->Email->sendAs = 'html';
							$this->set('result',$result);
							$this->set('res',$res);
							$this->set('offer',$offer);
							$this->set('offer_time',$offer_time);
							$this->set('seat',$seat);
							$this->set('rand_string',$rand_string);
							//$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
							//$j++;	
							/*if($this->Email->send()){
											
											$data = array('User' => array('id' => $user_details['User']['id'],'subscribe_email' => $rand_string));
											$this->User->save($data, false, array('subscribe_email'));
							}*/
						}
					}
				}
			}
			//pr($users);
			//echo $i;
		}
	}	
	function subscribe_email($string=null) {
		$this->layout='home';
			if (!empty($string)) { 
					$count = $this->User->find('count', array(
								'conditions' => array(
									'subscribe_email' => $string
								) ,
								'recursive' => -1
								));
					
					if($count>0){
						$userid = $this->User->find('first', array(
								'conditions' => array(
									'subscribe_email' => $string
								) ,
								'recursive' => -1
								));
						$this->User->updateAll(array('email_subscription'=>0), array('User.id'=>$userid['User']['id']));
						//$this->set('sub','success');
						$this->Session->setFlash('You have unsubscribed successfully.' , 'default', null, 'success');
					 }else{
					 	 //$this->set('sub1','unsuccess');
						 $this->Session->setFlash('Invalid Email id' , 'default', null, 'error');
					 }
			}
	}
	function clear_offerdate(){
		$this->autoRender = false;
		echo $date = date('Y-m-d');
		
	}
}
?>
