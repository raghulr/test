<?php
class TableController extends AppController {
    var $name = 'Table';
	var $uses=array('Restaurant','Reservation','Table','Offer');
	var $paginate = array(
    'Offer' => array('limit' => 10,
                           'order' => array('content' => 'desc'),
                           'group' => array('content'))
                          );
	var $helpers = array('Auth','Paginator');
	function admin_index() {
		$this->loadModel('Restaurant');
                $reservedate = date('Y-m-d'); 
		$id = $this->get_res_id(); 
		$this->set('res_id',$id);
		$restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id),
                    'contain' => array(			
			'Offer' =>array(
					'conditions' => array(
						'Offer.offerDate'=>$reservedate,
					)
				
			)
		 ),));
		//print_r($restdetail);exit;
		if(!empty($restdetail['Restaurant']['startTime']) && !empty($restdetail['Restaurant']['endTime'])){
			$starttime=strtotime($restdetail['Restaurant']['startTime']);
			$time2=strtotime(date('H:i:s'));
			$endtime=strtotime($restdetail['Restaurant']['endTime']);
			if($endtime>$time2){
				if($starttime>$time2){
					$starttime=strtotime($restdetail['Restaurant']['startTime']);
				}else{
					$minute = date('i');
					$minute1 = ($minute < 30) ? 30 : (($minute >30)? '00':$minute);
					if($minute1==00){
						$hour=date('H');
						$hour=$hour+1;
						$time2= strtotime($hour.':'.$minute1.':'.'00');
					}else
						$time2= strtotime(date('H').':'.$minute1.':'.'00');
					$starttime=$time2;
				}
				$diff=abs(ceil(($endtime-$starttime)/1800));
				$this->set('interval',$diff);
				$this->set('starttime',$starttime);
				$this->set('res_id',$id);
				$this->set('endtime',$endtime);
				$this->set('tables',$this);
				//$this->set('neigh_name',$restdetail['Neighborhood']['name']);
			}else{
				$this->set('interval','');
			}
		}
		else{
			$this->set('interval','');
		}
	}
	function admin_clear_group(){
		$id = $this->get_res_id();
		$this->Session->write('Auth.resid',$id);	
		$restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id),'recursive'=>-1));
		$this->set('restdetail',$restdetail);
		$date = date("Y-m-d");
		$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
		$this->loadModel('Offer');
		$conditions = array('restaurantId'=>$id,'offerDate >='=>$date,'NOT'=>array('Offer.id'=>$res_id)); 
		$feilds = array('seating','content','offer_day','COUNT(Offer.id) as total','created_time','offerDate','offerTime','min(Offer.offerDate) as sdate','max(Offer.offerDate) as edate');
		$order = array('Offer.content'=>'DESC');
		$recursive=-1;
		$this->paginate = array(
			  'conditions' => $conditions,
			  'recursive' => $recursive,
			  'fields' => $feilds,
			  'order' => $order,
			  'limit' => 10
		 );
                $offerCount=$this->Offer->find('count',array('conditions'=>array('restaurantId'=>$id,'offerDate'=>$date,'NOT'=>array('Offer.id'=>$res_id))));
		$page = $this->paginate('Offer');
		$this->set('offer_day',$this);
		$this->set('offer',$page);
                $this->set('offerCount',$offerCount);
	}
	function get_days($content){
		$this->layout=false;
		if(!empty($content)){
			$id = $this->get_res_id();
			$date = date("Y-m-d");
			$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
			$offers=$this->Offer->find('all',array('conditions'=>array('restaurantId'=>$id,'offerDate >='=>$date,'content'=>$content,'NOT'=>array('Offer.id'=>$res_id)),'recursive'=>-1,'fields'=>array('offer_day'),'group'=>array('content','offer_day'),'order'=>'offerDate'));
			return $offers;
		}
	}
         function getRestaurantReservation($date){            
            $transaction_time=$date.' 00.00.00';
            $res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1,'trasaction_time >='=>$transaction_time),'fields'=>'Offerid','recursive'=>-1));
            return $res_id;
        }
        function getAvilableTables($id,$res_id,$date){
		//$id = $this->get_res_id(); 		
		$offers=$this->Offer->find('all',array('conditions'=>array('restaurantId'=>$id,'offerDate'=>$date,'NOT'=>array('Offer.id'=>$res_id)),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'group'=>array('seating','offerTime','offerDate'),'order'=>'seating','recursive'=>-1));
		return $offers;
		
	}
       function getPurchased($id,$res_id,$date){
		 //$id = $this->get_res_id();
                $offers=$this->Offer->find('all',array('conditions'=>array('Offer.restaurantId'=>$id,'Offer.id'=>$res_id,'offerDate'=>$date),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'group'=>array('seating','offerTime','offerDate'),'order'=>'seating','recursive'=>-1));
		return $offers;
		
	}	
	function getTables($time,$date,$seat){
		$id = $this->get_res_id(); 
		$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
		$offers=$this->Offer->find('first',array('conditions'=>array('restaurantId'=>$id,'offerDate'=>$date,'offerTime'=>$time,'seating'=>$seat,'NOT'=>array('Offer.id'=>$res_id)),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'group'=>array('seating','offerTime','offerDate'),'order'=>'seating'));
		return $offers;
		
	}	
	function getPur($time,$date,$seat){
		 $id = $this->get_res_id(); 
		$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
		$offers=$this->Offer->find('first',array('conditions'=>array('Offer.restaurantId'=>$id,'Offer.id'=>$res_id,'offerDate'=>$date,'offerTime'=>$time,'seating'=>$seat),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'order'=>'seating'));
		return $offers;
		
	}	
	function admin_addtable(){
		$this->Offer->create();
		unset($this->Offer->validate['offerDays']);
		unset($this->Offer->validate['Count']);
		$current=strtotime(date("Y-m-d H:i:s")); 
		$this->data['Offer']['offer_day']='Every Day';
		$this->data['Offer']['content']=$current;                                            
                date_default_timezone_set('America/Chicago');
                $offer_create_time = date('Y-m-d H:i:s');
		$this->data['Offer']['created_time'] = $offer_create_time;
		$save=$this->Offer->save($this->data);
		if($save){
		$del='saved';
		$this->set('del',$del);
		}else{
		$del='nsaved';
		$this->set('del',$del);
		}
		$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
		$getdata1=$this->Offer->find('first',array('conditions'=>array('restaurantId'=>$this->data['Offer']['restaurantId'],'offerDate'=>$this->data['Offer']['offerDate'],'offerTime'=>$this->data['Offer']['offerTime'],'seating'=>$this->data['Offer']['seating'],'NOT'=>array('Offer.id'=>$res_id)),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'group'=>array('seating','offerTime','offerDate')));
		echo $del.'*'.$getdata1[0]['total'];
		$this->autoRender=false;
	}
	
	function admin_deletetable(){
		$this->layout=false;
		if(!empty($this->data['Offer']['offerTime'])&&!empty($this->data['Offer']['seating'])&&!empty($this->data['Offer']['restaurantId'])&&!empty($this->data['Offer']['offerDate']))
		{
			$getoffer = $this->Table->getoffer($this->data['Offer']['restaurantId'],$this->data['Offer']['offerDate'],$this->data['Offer']['offerTime'],$this->data['Offer']['seating']);
			if(!empty($getoffer[0]['Offer']['id'])){
				$total=$getoffer[0]['Offer']['id'];
			}
			else{
				$total = '';
			}
			if(!empty($total)){
				$del='deleted';
				$this->Offer->delete($total);
				$this->set('del',$del);
			}else{
				$del='Cannot be deleted';
			 	$this->set('del',$del);
			}
			$res_id=$this->Reservation->find('list',array('conditions'=>array('approved'=>1),'fields'=>'Offerid','recursive'=>-1));
			$getdata1=$this->Offer->find('first',array('conditions'=>array('restaurantId'=>$this->data['Offer']['restaurantId'],'offerDate'=>$this->data['Offer']['offerDate'],'offerTime'=>$this->data['Offer']['offerTime'],'seating'=>$this->data['Offer']['seating'],'NOT'=>array('Offer.id'=>$res_id)),'fields'=>array('seating','COUNT(seating) as total','offerTime','offerDate'),'group'=>array('seating','offerTime','offerDate')));
			echo $del.'*'.$getdata1[0]['total'];
			$this->autoRender=false; 
		}
	}
	
	function admin_changedate($date=null) {
		$this->layout=false;
		$id = $this->get_res_id(); 
		$this->loadModel('Restaurant');
		$restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id),'recursive'=>-1));
                $date1=isset($this->params['form']['date']) ? explode('/',$this->params['form']['date']) :  $date;
		$date=isset($this->params['form']['date']) ? $date1[2].'-'.$date1[0].'-'.$date1[1]: $date;
		$starttime=strtotime($restdetail['Restaurant']['startTime']);
		if($date==date('Y-m-d')){
		
			$time2=strtotime(date('H:i:s'));
			if($starttime>$time2){
				$starttime=strtotime($restdetail['Restaurant']['startTime']);
			}else{
				$minute = date('i');
				$minute1 = ($minute < 30) ? 30 : (($minute >30)? '00':$minute);
				if($minute1=='00')
					$time2= strtotime(date('H+1').':'.$minute1.':'.'00');
				else
					$time2= strtotime(date('H').':'.$minute1.':'.'00');
				$starttime=$time2;
			}
		}
		$endtime=strtotime($restdetail['Restaurant']['endTime']);
		$diff=abs(ceil(($endtime-$starttime)/1800)); 
		
		$date2=date('M.d, Y',strtotime($date));
		$date2=date('Y-m-d',strtotime($date));
		$date3=date('m/d/Y',strtotime($date));
		$today = date('Y-m-d');
		$this->set('today',$today);
		$this->set('date3',$date3);
		$this->set('date2',$date2);
		$this->set('interval',$diff);
		$new_date = isset($this->params['form']['date']) ? $this->params['form']['date'] : $date;
		$this->set('date1',$new_date);
		$this->set('starttime',$starttime);
		$this->set('res_id',$id);
		$this->set('endtime',$endtime);
		$this->set('tables',$this);

	}
	function admin_recurringtable(){
		$this->layout='adminpopup';
		if(!empty($this->params['url']['date']))
			$date=strtotime($this->params['url']['date']);
		else
			$date='';
		$tod_date=strtotime(date('Y-m-d'));
		$this->set('title_for_popup','Add Recurring Table');
		$id = $this->get_res_id(); 
		$restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id)));
		$starttime=strtotime($restdetail['Restaurant']['startTime']); 
		$endtime=strtotime($restdetail['Restaurant']['endTime']); 
		$diff=abs(ceil(($endtime-$starttime)/1800));
		$options=array();
		//for($i=0;$i<$this->data['Offer']['Count'];$i++){
		if($date==$tod_date){
			$starttime=strtotime($restdetail['Restaurant']['startTime']);
			$time2=strtotime(date('H:i:s'));
			$endtime=strtotime($restdetail['Restaurant']['endTime']);
			if($endtime>$time2){
				if($starttime>$time2){
					$starttime=strtotime($restdetail['Restaurant']['startTime']);
				}else{
					$minute = date('i');
					$minute1 = ($minute < 30) ? 30 : (($minute >30)? '00':$minute);
					if($minute1==00){
						$hour=date('H');
						$hour=$hour+1;
						$time2= strtotime($hour.':'.$minute1.':'.'00');
					}else
						$time2= strtotime(date('H').':'.$minute1.':'.'00');
					$starttime=$time2;
				}
			}
		}
		for($i=0;$i<=$diff;$i++){
			if($starttime<=$endtime){
				$optionsval=date('H:i:s',$starttime);
				$options[$optionsval]=date('h:i A',$starttime);
			}
				$starttime=$starttime+1800; 
		} 
		$this->set('options',$options);
		if(!empty($this->data)){ 
			$this->set('assigndate','');
			if(!empty($this->data['Offer']['offerDate'])){
					//$convet_reserve_time = DboSource::expression('NOW()');					                                            
                                        date_default_timezone_set('America/Chicago');
                                        $offer_create_time = date('Y-m-d H:i:s');
                                        $this->data['Offer']['created_time'] = $offer_create_time;
					$this->set('assigndate',$this->data['Offer']['offerDate']);
					$this->Offer->set($this->data);
					if($this->Offer->validates()){ 
						if(empty($this->data['Offer']['Count']))
							$this->data['Offer']['Count']=1;
						$this->data['Offer']['restaurantId']=$id;
						if(!empty($this->data['Offer']['offerDays'])&&$this->data['Offer']['daysorweek']=='Days'){ 
							if(!empty($this->data['Offer']['days'])){
								$this->Session->setFlash('Please select the duration as weeks' , 'default', null, 'error');
								return;
							}
							$enddate=date('Y-m-d',strtotime($this->data['Offer']['offerDate'].'+'.$this->data['Offer']['offerDays'].'day'));
								if($this->data['Offer']['EveryDay']=='next day'){
									for($i=0;$i<$this->data['Offer']['Count'];$i++){
										if($this->data['Offer']['offerDate']>=date('Y-m-d')){
												$this->data['Offer']['offer_day']='Every Day';
												$this->Offer->create();
												$this->Offer->save($this->data);
										}
									}
								}else{
									$day=strstr($this->data['Offer']['EveryDay'],strtolower(date('l',strtotime($this->data['Offer']['offerDate']))));
									if(!empty($day)){
										for($i=0;$i<$this->data['Offer']['Count'];$i++){
											if($this->data['Offer']['offerDate']>=date('Y-m-d')){
												$this->Offer->create();
												$this->data['Offer']['offer_day']='Every Day';
												$this->Offer->save($this->data);
											}
										}
									}
							}
							$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($this->data['Offer']['EveryDay'],strtotime($this->data['Offer']['offerDate'])));
								while($date<$enddate){
									for($i=0;$i<$this->data['Offer']['Count'];$i++){
										if($this->data['Offer']['offerDate']>=date('Y-m-d')){
											$this->data['Offer']['offer_day']='Every Day';
											$this->Offer->create();
											$this->Offer->save($this->data);
										}
									}
									$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($this->data['Offer']['EveryDay'],strtotime($date)));
								}
						}elseif(!empty($this->data['Offer']['days'])&&$this->data['Offer']['daysorweek']=='Weeks'){
							if($this->data['Offer']['offerDays'] == 'Days'){
								$this->Session->setFlash('Please select the duration as days' , 'default', null, 'error');
								break;
							}				
							if(!empty($this->data['Offer']['days'])){
								for($i=0;$i<$this->data['Offer']['Count'];$i++){
								foreach($this->data['Offer']['days'] as $offer_days){
									$offerDate = $this->data['Offer']['offerDate'];
									$day=strstr($offer_days,strtolower(date('l',strtotime($this->data['Offer']['offerDate']))));
									if(!empty($day)){
										if($this->data['Offer']['offerDate']>=date('Y-m-d')){
											$this->data['Offer']['offer_day']=$offer_days;
											$this->Offer->create();
											$this->Offer->save($this->data);
										  }
									}
									if(!empty($offerDate))
										$enddate=date('Y-m-d',strtotime($offerDate.'+'.$this->data['Offer']['offerDays'].'week'));
									else
										$enddate=date('Y-m-d',strtotime('+'.$this->data['Offer']['offerDays'].'week'));
									$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($offer_days,strtotime($this->data['Offer']['offerDate'])));						
									while($date<$enddate){
										if($this->data['Offer']['offerDate']>=date('Y-m-d')){
											$this->Offer->create();
											$this->data['Offer']['offer_day']=$offer_days;
											$this->Offer->save($this->data);
										}
										$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($offer_days,strtotime($date)));
									}
									$this->data['Offer']['offerDate'] = $offerDate;
									flush();
								}
							}
								flush();
							}
						}			
						$this->Session->setFlash('Recurring date added successfully' , 'default', null, 'success');
						echo "<script>parent.$.fn.colorbox.close(); parent.window.location.reload(); </script>";
					}
			}	 
		} else{
			$this->set('assigndate',$this->params['url']['date']);
		}
	}
	
	function admin_add_table() {
		
	}
	function admin_delete_group($content=null) {
		$this->layout=false;
		$id = $this->get_res_id();
		$reser_offer_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId','Reservation.offerId')));
		$restdetail=$this->Offer->find('list',array(
			'conditions'=>array(
					'Offer.content'=>$content,
					'Offer.restaurantId'=>$id,
				'NOT'=>array(
					'Offer.id'=>$reser_offer_id
				)
			),
            'fields'=>array(
				'Offer.id'
			)));
		$this->Offer->deleteAll(array('Offer.id'=>$restdetail));
		echo 'hi';
	}
	function admin_cleartable($date=null){
		$this->layout=false;
		//$this->autoRender=false;
		$id = $this->get_res_id();
		$this->loadModel('Restaurant');
		$clear_all = $this->clear_all($date,$id);
		$restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id)));
		$this->admin_changedate($date);
	}
	function clear_all($date,$resid){
		$date1 = date("Y-m-d");
		$reser_offer_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId','Reservation.offerId')));
		$restdetail=$this->Offer->find('list',array(
			'conditions'=>array(
					'Offer.restaurantId	'=>$resid,
				'NOT'=>array(
					'Offer.id'=>$reser_offer_id
				)
			),
            'fields'=>array(
				'Offer.id'
			)));
		$this->Offer->deleteAll(array('Offer.id'=>$restdetail));
		//exit;
	}
} 
?>