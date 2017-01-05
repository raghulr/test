<?php
class WidgetsController extends AppController{
    var $uses = array('Alert','Reservation','Offer','User','AlertResponse','Restaurant','EmailTemplate');
	//var $components = array('Email');
	function time_list(){
		$this->layout = 'widget';
		//echo 'hi';
		Configure::write('debug',2);
	//$user_id = $this->Auth->user('id');
	//echo date('e');
	if(!empty($this->params['url']['ampm'])) :
            //Added additional param to know reservation is through the widgets
		$redirectUrl = Router::url('/', true)."homes/reservation?party=".$this->params['url']['party']."&time=".$this->params['url']['time']."&ampm=".$this->params['url']['ampm']."&rest_id=".$this->params['url']['rest_id']."&wid=wid";
		//$this->redirect(Router::url('/', true) . $redirectUrl);
		$this->set('redirectUrl',$redirectUrl);	
	endif;	
	
	if(isset($_REQUEST['register'])){
		$this->Session->setFlash('You have successfully Registered', 'default', null, 'success');
	}
	//$this->layout='home';
	
	if (!empty($this->params['form']['id'])){ 
		$this->layout=false;
		$party_size = $this->params['form']['id'];
	}else{
		$party_size = '';
	}
	$this->loadmodel('Slideshow');
	$this->set('slideshow', $this->Slideshow);
	$this->set('party_size', $party_size);
	$this->Session->delete('rest');
	$this->set('title_for_layout','Home');
	$this->loadmodel('Neighborhood');
	$neighbor_list = $this->Neighborhood->find('list',array(
		'fields'=>array(
				'name'
		),
		'order' => array('name ASC')
	 ));
	$this->set('neighbor_list',$neighbor_list);
	$this->loadmodel('Reservation');
	//$reser_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
	$this->loadmodel('Offer');
	$time=date('H:i:s');
	$party=array(2,3,4,5,6,7,8);
	$offer_date = date('Y-m-d');
	$time_by_testaurant=array();
	$search_condition = array();
        $query = "select `restaurantId`,`restaurantId` from offers Offer left join reservations r on Offer.id = r.offerid";
        $query = $query ." where (r.id is null OR r.approved = 0) and offerDate = '".$offer_date."' and offerTime>= '".$time."' GROUP BY `Offer`.`restaurantId`";
        $time_by_testaurant = $this->Offer->query($query);
        $time_by_testaurant = Set::classicExtract($time_by_testaurant,'{n}.Offer.restaurantId');
        /************
	$time_by_testaurant = $this->Offer->find('list',array('conditions' => array(
					'Offer.offerDate' => $offer_date,
					'Offer.offerTime >='=>$time,
					'Offer.seating'=>$party,
					'NOT'=>array(
						'Offer.id'=>$reser_id
					),
				), 'fields'=>array('Offer.restaurantId','Offer.restaurantId'),'group'=>'Offer.restaurantId','recursive'=>-1));
	*******/
        //if(!empty($time_by_testaurant)){
		$search_condition['Restaurant.id']=$time_by_testaurant;
	 //}
	
	$this->loadmodel('Cuisine');
	$cuisine_list = $this->Cuisine->find('list',array(
		'fields'=>array(
			'name'
		),
		'order' => array('name ASC')
	));
	$this->set('cuisine_list',$cuisine_list);
	$this->paginate = array(
		'conditions' => array(
			'Restaurant.approved'=>1,
			'Restaurant.city'=>Configure::read('website.city_id'),
			$search_condition	
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
			'Restaurant.neighborhoodId',
			'Restaurant.city',
			'Restaurant.logo',
			'Restaurant.startTime',
			'Restaurant.endTime',
			'Restaurant.slug_name'
		),
                'order'=>array('Restaurant.rank DESC','Restaurant.name'),
		'limit'=>50,		
		'recursive'=>2
	);
	$restr = $this->Restaurant->find('all',array(
		'conditions' => array(
			'Restaurant.approved'=>1,
			'Restaurant.city'=>Configure::read('website.city_id')	
		),
		'fields'=>array(
			'min(Restaurant.startTime) as stime',
			'max(Restaurant.endTime) as etime'
		),
		'recursive'=>'-1'
	 ));
	$restaurant_detail = $this->paginate('Restaurant');
	//echo count($this->paginate('Restaurant'));
	//pr($restaurant_detail);
	$this->set('restaurant', $this);
	$this->set('restaurant_detail',$restaurant_detail);
	//$deal=$this->Restaurant->dealtime();
	//$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	$start = $restr[0][0]['stime'];
	$end = $restr[0][0]['etime'];
	$starttime=strtotime($start); 
	$endtime=strtotime($end); 
	$diff=abs(ceil(($endtime-$starttime)/1800));
	$options=array();
	$starttime=strtotime($restr[0][0]['stime']);
	$time2=strtotime(date('H:i:s'));
	$endtime=strtotime($restr[0][0]['etime']);
	if($endtime>$time2){
		if($starttime>$time2){
			$starttime=strtotime($restr[0][0]['stime']);
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
	for($i=0;$i<=$diff;$i++){
		if($starttime<=$endtime){
			if($starttime>0)
				$optionsval=date('H:i:s',$starttime);
			else
				$optionsval='';
			$options[$optionsval]=date('h:i A',$starttime);
		}
		$starttime=$starttime+1800; 
	} 
	$this->set('options',$options);
        $this->loadModel('Widgetloadevents');
        $this->request->data['Widgetloadevents']['Datetime']=$access_time=date('Y-m-d H:i:s');
        $this->Widgetloadevents->save($this->request->data);
	}
	function chicago_time(){
		$account_type = $this->Auth->user('account_type'); 
		if($account_type==2){
			$this->Cookie->delete('User');
			$this->Auth->logout();
			if(!empty($this->params['url']['ampm'])) :
				$redirectUrl = Router::url('/', true)."chicago/homes/reservation?party=".$this->params['url']['party']."&time=".$this->params['url']['time']."&ampm=".$this->params['url']['ampm']."&rest_id=".$this->params['url']['rest_id'];
				//$this->redirect(Router::url('/', true) . $redirectUrl);
				$this->set('redirectUrl',$redirectUrl);	
			endif;
		}
		if(!empty($this->params['url']['ampm'])) :
			$redirectUrl = Router::url('/', true)."chicago/homes/reservation?party=".$this->params['url']['party']."&time=".$this->params['url']['time']."&ampm=".$this->params['url']['ampm']."&rest_id=".$this->params['url']['rest_id'];
			//$this->redirect(Router::url('/', true) . $redirectUrl);
			$this->set('redirectUrl',$redirectUrl);
		endif;	
		$this->layout = 'chicagomag';
		//echo 'hi';	
	
	if(isset($_REQUEST['register'])){
		$this->Session->setFlash('You have successfully Registered', 'default', null, 'success');
	}
	//$this->layout='home';
	
	if (!empty($this->params['form']['id'])){ 
		$this->layout=false;
		$party_size = $this->params['form']['id'];
	}else{
		$party_size = '';
	}
	$this->set('party_size', $party_size);
	$this->Session->delete('rest');
	$this->set('title_for_layout','Home');
	$this->loadmodel('Neighborhood');
	$neighbor_list = $this->Neighborhood->find('list',array(
		'fields'=>array(
				'name'
		),
		'order' => array('name ASC')
	 ));
	$this->set('neighbor_list',$neighbor_list);
	$this->loadmodel('Reservation');
	$reser_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
	$this->loadmodel('Offer');
	$time=date('H:i:s');
	$party=array(2,3,4,5,6,7,8);
	$offer_date = date('Y-m-d');
	$time_by_testaurant=array();
	$search_condition = array();
	$time_by_testaurant = $this->Offer->find('list',array('conditions' => array(
					'Offer.offerDate' => $offer_date,
					'Offer.offerTime >='=>$time,
					'Offer.seating'=>$party,
					'NOT'=>array(
						'Offer.id'=>$reser_id
					),
				), 'fields'=>array('Offer.restaurantId','Offer.restaurantId'),'group'=>'Offer.restaurantId','recursive'=>-1));
	//if(!empty($time_by_testaurant)){
		$search_condition['Restaurant.id']=$time_by_testaurant;
	 //}
	
	$this->loadmodel('Cuisine');
	$cuisine_list = $this->Cuisine->find('list',array(
		'fields'=>array(
			'name'
		),
		'order' => array('name ASC')
	));
	$this->set('cuisine_list',$cuisine_list);
	$this->paginate = array(
		'conditions' => array(
			'Restaurant.approved'=>1,
			'Restaurant.city'=>Configure::read('website.city_id'),
			$search_condition	
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
			'Restaurant.neighborhoodId',
			'Restaurant.city',
			'Restaurant.logo',
			'Restaurant.startTime',
			'Restaurant.endTime'
		),	
		'limit'=>16,		
		'recursive'=>2
	);
	$restr = $this->Restaurant->find('all',array(
		'conditions' => array(
			'Restaurant.approved'=>1,
			'Restaurant.city'=>Configure::read('website.city_id')	
		),
		'fields'=>array(
			'min(Restaurant.startTime) as stime',
			'max(Restaurant.endTime) as etime'
		),
		'recursive'=>'-1'
	 ));
	$restaurant_detail = $this->paginate('Restaurant');
	//pr($restaurant_detail);
	$this->set('restaurant', $this);
	$this->set('restaurant_detail',$restaurant_detail);
	//$deal=$this->Restaurant->dealtime();
	//$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	$start = $restr[0][0]['stime'];
	$end = $restr[0][0]['etime'];
	$starttime=strtotime($start); 
	$endtime=strtotime($end); 
	$diff=abs(ceil(($endtime-$starttime)/1800));
	$options=array();
	$starttime=strtotime($restr[0][0]['stime']);
	$time2=strtotime(date('H:i:s'));
	$endtime=strtotime($restr[0][0]['etime']);
	if($endtime>$time2){
		if($starttime>$time2){
			$starttime=strtotime($restr[0][0]['stime']);
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
	for($i=0;$i<=$diff;$i++){
		if($starttime<=$endtime){
			if($starttime>0)
				$optionsval=date('H:i:s',$starttime);
			else
				$optionsval='';
			$options[$optionsval]=date('h:i A',$starttime);
		}
		$starttime=$starttime+1800; 
	} 
	$this->set('options',$options);
	}
	function time_widget(){
		$this->layout = 'widget';
	}
        function widgetsload(){
            $yeardata='';
            Configure::write('debug',2);
            $this->loadModel('Widgetloadevents');                
            $this->layout = 'widgetload';
            if(!empty($this->data['Alert']['logdate'])){
                $logdate=$this->data['Alert']['logdate'].' 00:00:00';
                $next_date=date('Y-m-d', strtotime('+1 day',strtotime($this->data['Alert']['logdate']))).' 00:00:00';
                $list=$this->Widgetloadevents->find('all',array('fields'=>array('count(id) as total','DATE_FORMAT(MIN(Datetime),"%Y/%m/%d %H:%i:00") AS tmstamp'),
                                                            'group'=>'ROUND(UNIX_TIMESTAMP(Datetime) DIV 1800)',
                                                            'conditions' => array('Widgetloadevents.Datetime >=' => $logdate,'Widgetloadevents.Datetime <' => $next_date)));
            //pr($list);exit;
            $this->set('logdate',$this->data['Alert']['logdate']);
            }else{
            $next_date=date('Y-m-d', strtotime(' +1 day')).' 00:00:00';
            $logdate=date('Y-m-d').' 00:00:00';
            $list=$this->Widgetloadevents->find('all',array('fields'=>array('count(id) as total','DATE_FORMAT(MIN(Datetime),"%Y/%m/%d %H:%i:00") AS tmstamp'),
                                                            'group'=>'ROUND(UNIX_TIMESTAMP(Datetime) DIV 1800)',
                                                            'conditions' => array('Widgetloadevents.Datetime >=' => $logdate,'Widgetloadevents.Datetime <' => $next_date)));
            //pr($list);exit;
            $this->set('logdate',date('Y-m-d'));
            }
            $list_count=count($list);
            for ($y = 0; $y <$list_count ;$y++) {
                if ($y < ($list_count-1))
                    $yeardata = $yeardata . $list[$y][0]['total'] . ',';
                else
                    $yeardata = $yeardata . $list[$y][0]['total'];
            }
            $this->set('yeardata',$yeardata);
        }
        function changelogdate(){
            $yeardata='';
            Configure::write('debug',2);
            $this->loadModel('Widgetloadevents');
            if(!empty($this->params['form']['logdate'])){
                $logdate=$this->params['form']['logdate'].' 00:00:00';
                $next_date=$this->params['form']['logdate'].' 23:59:59';
                $list=$this->Widgetloadevents->find('all',array('fields'=>array('count(id) as total','DATE_FORMAT(MIN(Datetime),"%Y/%m/%d %H:%i:00") AS tmstamp'),
                                                            'group'=>'ROUND(UNIX_TIMESTAMP(Datetime) DIV 1800)',
                                                            'conditions' => array('Widgetloadevents.Datetime >=' => $logdate,'Widgetloadevents.Datetime <' => $next_date)));
            //pr($list);exit;
            }
            $list_count=count($list);
            for ($y = 0; $y <$list_count ;$y++) {
                if ($y < ($list_count-1))
                    $yeardata = $yeardata . $list[$y][0]['total'] . ',';
                else
                    $yeardata = $yeardata . $list[$y][0]['total'];
            }
            echo $yeardata;exit;
        }
        /*function time_static(){ 
            $this->layout = 'widget';
        }*/
}
?>
