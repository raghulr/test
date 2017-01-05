<?php
class HomesController extends AppController {
	var $uses=array('Restaurant');
	var $helpers = array('Html','Ajax','Javascript');
	var $components = array('RequestHandler'); 
function index(){
	//pr($this->params);
	//pr($redirect_url);
	if(!empty($this->params['url']['ampm'])) :
		$redirectUrl = Router::url('/', true)."reservations?party=".$this->params['url']['party']."&time=".$this->params['url']['time']."&ampm=".$this->params['url']['ampm']."&rest_id=".$this->params['url']['rest_id']."&chicagomag=".$this->params['url']['chicagomag'];
			//$this->redirect(Router::url('/', true) . $redirectUrl);
			$this->set('redirectUrl',$redirectUrl);
	endif;	
	
	if(isset($_REQUEST['register'])){
            if( $_REQUEST['register'] == 'credit')
                $this->Session->setFlash(__l('Thanks for signing up for TableSavvy! We have added a $5 credit to your account, so your first reservation is on us!!!') , 'default', null, 'success');
            else                    
                $this->Session->setFlash('You have successfully Registered', 'default', null, 'success');
	}
	$this->layout='home';
	if (!empty($this->params['form']['id'])){ 
	//echo 'case1';
		$this->layout=false;
		$party_size = $this->params['form']['id'];
	}else{
	//echo 'case2';
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
		'conditions'=>array('Neighborhood.city_id'=>Configure::read('website.city_id')),
		'order' => array('name ASC')
	 ));
	$this->set('neighbor_list',$neighbor_list);
		$time_by_testaurant = $this->clear_rest_offer();
		$search_condition['Restaurant.id']=$time_by_testaurant;
	//}else{
		
	//}
	$this->loadmodel('Cuisine');
	$cuisine_list = $this->Cuisine->find('list',array(
		'fields'=>array(
			'name'
		),
		'order' => array('name ASC')
	));
	//pr($cuisine_list);
	$this->set('cuisine_list',$cuisine_list);
        $limit = 9;
        if(Configure::read('website.id')!=1)
            $limit =9;
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
		'limit'=>$limit,
		'recursive'=>2
	);
	$restr = $this->Restaurant->find('all',array(
		'conditions' => array(
			'Restaurant.approved'=>1,
			'Restaurant.city'=>Configure::read('website.city_id')	
		),
		'fields'=>array(
			'id',
			'min(Restaurant.startTime) as stime',
			'max(Restaurant.endTime) as etime'
		),
		'recursive'=>'-1'
	 ));
	$restaurant_detail = $this->paginate('Restaurant');
	//$this->set($this,'res');
	$this->set('res', $this);
	$dealtime='7:00:00';
	$time = date('H:i:s',time());
	$dealtime=strtotime($dealtime);
	$time=strtotime($time);	
	$this->set('restaurant', $this);
	$this->set('restaurant_detail',$restaurant_detail);
	$deal=$this->Restaurant->dealtime();
	//pr($restaurant);
	$this->set('dealtime',$deal[0][0]['max(offerTime)']);
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
    /*if((empty($restaurant_detail)||$time<=$dealtime)){
		//$this->expired();
		if(!empty($this->params['named']['type'])){
			$this->set('disabled',true);
			//$this->render('expired_new'); 
		 }else{
		 	$this->set('disabled',true);
			//$this->render('expired'); 
		}
	}*/
}
function search_condtions(){
    $this->loadmodel('Reservation');
    $reser_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
    $this->loadmodel('Offer');
    $time=date('H:i:s');
    $offer_date = date('Y-m-d');
    $time_by_testaurant=array();
    $search_condition = array();
    $party=array(2,3,4,5,6,7,8);
    $time_by_testaurant = $this->Offer->find('list',array(
        'conditions' => array(
            'Offer.offerDate' => $offer_date,
            'Offer.offerTime >='=>$time,
            'Offer.seating'=>$party,
            'NOT'=>array(
                'Offer.id'=>$reser_id
            ),
        ),
        'fields'=>array(
            'Offer.restaurantId',
            'Offer.restaurantId'
        ),
        'group'=>'Offer.restaurantId',
        'recursive'=>-1
    ));
    $search_condition['Restaurant.id']=$time_by_testaurant; 
    return $search_condition;
}
function auto_complete() { 
    $string = $_REQUEST['string'];
    if(!empty($string)){
        //$search_condition = $this->search_condtions();
        $search_condition['Restaurant.name LIKE'] ='%'. $string .'%';
        $search_condition['Restaurant.approved'] = 1;
        $search_condition['Restaurant.city'] = Configure::read('website.city_id');
        $restaurants = $this->Restaurant->find('all', array(
            'conditions' => $search_condition,
            'fields' => array('name'),
            'recursive'=>'-1'
        ));
		//pr($restaurants);
        $this->set('restaurants',$restaurants);
    }
	//$this->layout = 'ajax';
}
function search(){
	$this->layout='ajax';
	$this->set('title_for_layout','Search');
	if($this->data){
		$this->Session->write('rest',$this->data['Home']['search']);
		if(!empty($this->data['Home']['page'])){
			$this->set('page',$this->data['Home']['page']);
		}
		else{
			$this->set('page','');
		}
	}
	else{
		$this->set('page','home');
	}
	//pr($party_size);
    //$search_condition = $this->search_condtions();
	//$this->Reservation->unbindModel(array('hasAndBelongsToMany' => array('User', 'Offer')), true);
	//$this->User->unbindModel(array('hasAndBelongsToMany' => array('Reservation')), true);
	$search = $this->Session->read('rest');
        $search_term = trim($search);
        $search_term = html_entity_decode($search_term);
        $search_condition['Restaurant.name LIKE'] ='%'.$search_term .'%';
        $search_condition['Restaurant.approved'] = 1;
        $search_condition['Restaurant.city'] = Configure::read('website.city_id');
		$time_by_testaurant = $this->clear_rest_offer();
		$search_condition['Restaurant.id']=$time_by_testaurant;
	if(empty($search_term))
		unset($search_condition['Restaurant.name LIKE']);
	    $limit = 9;
                if(Configure::read('website.id')!=1)
                    $limit =9;
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
				'Restaurant.neighborhoodId',
				'Restaurant.city',
				'Restaurant.logo',
				'Restaurant.startTime',
				'Restaurant.endTime',
				'Restaurant.slug_name'
			),	
			'order'=>array('Restaurant.rank DESC','Restaurant.name'),	
			'limit'=>$limit,		
			'recursive'=>2
		);
		$result = $this->paginate('Restaurant');
		//pr($result);
		if(empty($result)){
			$this->set('all','all');
			$time_by_testaurant = $this->clear_rest_offer();
			$restaurant_condtion['Restaurant.id']=$time_by_testaurant;
			$result = $this->search_all($restaurant_condtion);
		}
		$count = count($result);
		$this->set('count',$count);
		$this->set('count1',$count);
		$this->set('url_red','');
		if(($count==1)&&(!isset($this->params['named']['page']))){
			foreach($result as $data){
				$redirect_url = Router::url(array('controller' => 'homes','action' => 'details',html_entity_decode($data['Restaurant']['slug_name'])));
				?><script type='text/javascript'>
					window.location.href='<?php echo $redirect_url; ?>';
				</script>
				<?php 
			}
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
		if(stristr($this->params['url']['url'],'page')){
			$this->set('restaurant', $this);
			$this->set('result',$result);
		}
		else{
                    $this->set('restaurant', $this);
                    $this->set('result',$result);
		}
	if($count<=0){
		$this->set('count',-1);
	}
}
function getsize(){
    $this->layout='ajax';
    if(!empty($this->params['pass'][0])):
        $resturant_id = $this->params['pass'][0];
        $party_size = isset($this->params['form']['partysize'])?$this->params['form']['partysize']:'';
        $this->set('id',$resturant_id);
        $this->set('party_size',$party_size);
		$this->set('available','available');
        $this->set('restaurant', $this);
    else:
        $this->autoRender=false;
        return false;
    endif;
}
function select_search(){
    $this->layout='ajax';
    $neighborhood_id = isset($this->params['form']['neighborhood'])?$this->params['form']['neighborhood']:'';
    $cuisine_id = isset($this->params['form']['cuisine'])?$this->params['form']['cuisine']:'';
    $time_select = isset($this->params['form']['time_select'])?$this->params['form']['time_select']:'';
    $party_size = isset($this->params['form']['party'])?$this->params['form']['party']:'';
    
    /******************* Select by Table party size and time  *****************/
    $party_sizes = array('2'=>2,'3'=>4,'4'=>4,'5'=>6,'6'=>6,'7'=>8,'8'=>8);    
    $currentdate = date('Y-m-d'); 
    $conditions['Offer.offerDate'] = $currentdate;    
    $current_time = (!empty($time_select)&&$time_select>=date("H:i:s"))?$time_select:date("H:i:s");
	if(!empty($time_select)){
		$selected_start = date('H:i:s',strtotime($time_select));
        $selected_start_time = date('H:i:s',strtotime($time_select.'-30 MINUTES'));
        if($selected_start_time < date("H:i:s"))
            $selected_start_time = date('H:i:s');        
        $selected_end_time = date('H:i:s',strtotime($time_select.'+30 MINUTES'));
        if($selected_start!='23:30:00'){
			$conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
				$selected_start_time ,
				$selected_end_time
			); 
		}else{
			$conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
				$selected_start_time ,
				$selected_start
			);
		}    
    }else{
        $conditions['Offer.offerTime >='] = date("H:i:s");
    }
    if(!empty($party_size))
        $conditions['Offer.seating'] = $party_sizes[$party_size];
    $this->loadmodel('Reservation');
    $reservation_list = $this->Reservation->find('list',array(
        'fields'=>array(
            'Reservation.offerId','Reservation.offerId'
            ),
        'conditions'=>array(
            'Reservation.approved'=>1
        )
    ));
    
    $conditions['NOT']=array('Offer.id'=>$reservation_list);
    $this->loadmodel('Offer');
    $restaurant_by_table = $this->Offer->find('list', array(
        'fields'=>array(
            'Offer.restaurantId','Offer.restaurantId'
        ),
        'conditions'=>$conditions,
        'group'=>'Offer.restaurantId'
    ));
    //pr($restaurant_by_table);
    
    /******************* Select by Cuisine  *****************/  
    $cuisine_conditions = array();
    $restaurantCuisine = array();
    if(!empty($cuisine_id)){
        $cuisine_conditions['Cuisine.id'] = $cuisine_id;
        //pr($cuisine_conditions);
        $this->loadmodel('Restaurantcuisine');
        $restaurant_by_cuisines = $this->Restaurantcuisine->find('all',array(
            'fields'=>array(
                'Restaurantcuisine.restaurant_id'
            ),
            'conditions'=>$cuisine_conditions,
            'group'=>'Restaurantcuisine.restaurant_id'
        ));
        //pr($restaurant_by_cuisines);
        if(!empty($restaurant_by_cuisines)):
            foreach($restaurant_by_cuisines as $key=>$restaurant_by_cuisine){ 
                $id = $restaurant_by_cuisine['Restaurantcuisine']['restaurant_id'];
                $restaurantCuisine[$id] = $id;
            }    
        endif;
    }
    
    /****************** Find by nieghborhood **************/
    $restaurant_condtion = array();
    $restaurant_condtions['Restaurant.approved'] = 1;
    $restaurant_ids = array();
    if(!empty($neighborhood_id))
        $restaurant_condtion['Restaurant.neighborhoodId'] = $neighborhood_id;
    if(!empty($cuisine_id) &&(!empty($time_select) || !empty($party_size))){ 
       $restaurant_ids = array_intersect($restaurant_by_table,$restaurantCuisine);
       $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
    }elseif(!empty($cuisine_id)){
        $restaurant_ids = array_intersect($restaurant_by_table,$restaurantCuisine);
        $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
    }elseif(!empty($time_select) || !empty($party_size)){
        $restaurant_ids = $restaurant_by_table;
        $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
    }else{
        $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
    }  
    $restaurant_condtion['Restaurant.city'] = Configure::read('website.city_id');
	$restaurant_condtion['Restaurant.approved'] = 1;
    //pr($restaurant_condtion);
    //pr($restaurant_by_table);
    //pr($restaurantCuisine);
    $limit = 9;
    if(Configure::read('website.id')!=1)
        $limit =9;
    $this->paginate = array(
        'conditions'=> $restaurant_condtion,
        'contain'=>array(
            'Neighborhood',
            'Restaurantcuisine'=>array(
                    'order' => array('Restaurantcuisine.id DESC'),
                    'limit' =>1
                )
         ),
		 'order'=>array('Restaurant.rank DESC','Restaurant.name'),	
        'limit'=>$limit
    );
    $restaurant = $this->paginate('Restaurant');
    if(count($restaurant)==0){
        unset($conditions);
        $conditions['Offer.offerDate'] = $currentdate;
        $conditions['NOT']= array('Offer.id'=>$reservation_list);
        if(!empty($party_size))
            $party_sizes = $party_sizes[$party_size];
        else
           $party_sizes =  array(2,4,6,8);
        if(!empty($time_select))
            $conditions['Offer.offerTime >='] = $time_select;
        else
            $conditions['Offer.offerTime >='] = date('H:i:s');
        $conditions['Offer.seating'] = $party_sizes;
        $restaurant_by_table = $this->Offer->find('list',array(
        'conditions' => $conditions,
        'fields'=>array(
            'Offer.restaurantId',
            'Offer.restaurantId'
            ),'group'=>'Offer.restaurantId',
        'recursive'=>-1
        ));
        if(!empty($neighborhood_id))
            $restaurant_condtion['Restaurant.neighborhoodId'] = $neighborhood_id;
        if(!empty($cuisine_id) &&(!empty($time_select) || !empty($party_size))){ 
            $restaurant_ids = array_intersect($restaurant_by_table,$restaurantCuisine);
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        }elseif(!empty($cuisine_id)){
            $restaurant_ids = array_intersect($restaurant_by_table,$restaurantCuisine);
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        }elseif(!empty($time_select) || !empty($party_size)){
            $restaurant_ids = $restaurant_by_table;
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        }else{
            $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
        }         
        $restaurant = $this->search_all($restaurant_condtion);   
		if(count($restaurant)==0){ 
            unset($conditions['Offer.seating']);
            $restaurant_by_table = $this->Offer->find('list',array(
            'conditions' => $conditions,
            'fields'=>array(
                'Offer.restaurantId',
                'Offer.restaurantId'
                ),'group'=>'Offer.restaurantId',
            'recursive'=>-1
            ));
            unset($restaurant_condtion);
            $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
            $restaurant = $this->search_all($restaurant_condtion);
            $time_select = '';
            $party_size = '';
        }  
    }
    if(is_array($party_size))
        $party_size='';
    $this->set('time_select', $time_select);
    $this->set('party_size', $party_size);
    $this->set('restaurant', $this);
    $this->loadmodel('Cuisine');
    $this->set('restaurantcuisine',$this->Cuisine);
    $this->set('result',$restaurant);
}

function search_all($restaurant_condtion=null){  
	//$db =& ConnectionManager::getDataSource('default');
	//$db->showLog(); 
    $restaurant_condtion['Restaurant.city'] = Configure::read('website.city_id');
	$restaurant_condtion['Restaurant.approved'] = 1;
    $limit = 9;
    if(Configure::read('website.id')!=1)
        $limit =9;
	//$this->Reservation->unbindModel(array('hasAndBelongsToMany' => array('User', 'Offer')), true);
	//$this->User->unbindModel(array('hasAndBelongsToMany' => array('Reservation')), true);
	$this->paginate = array(
        'conditions'=> $restaurant_condtion,
        'contain'=>array(
            'Neighborhood',
            'Restaurantcuisine'=>array(
                'order' => array('Restaurantcuisine.id DESC'),
                'limit' =>1
            ),		
			'Restaurantcuisine' =>array(
				'Cuisine' => array(
					'fields' => array(
						'Cuisine.name',
					)
				)
			),	
        ),
		'order'=>array('Restaurant.rank DESC','Restaurant.name'),	
        'limit'=>$limit
    );
    $restaurant = $this->paginate('Restaurant');    
    $this->set('search_all','nores');
    return $restaurant;
}

function contact(){
	$this->layout='popup';
	$this->set('title_for_layout','Contact us');
}
function receipt(){
	$this->set('title_for_layout','receipt');
	$this->loadmodel('Reservation');
	$this->Reservation->updateAll(array(
		'Reservation.receipt'=>1
	),array(
		'Reservation.id' => $this->params['pass'][0]
	));
}

function details(){
	$this->layout='home';
	$this->loadmodel('Userlocation');
	$this->set('title_for_layout','Details');
	$party_size = 2;
	//pr($this->params);
	if (!empty($this->params['form']['id'])){ 
		$this->layout=false;
		$party_size = $this->params['form']['id'];
		$party_size1 = $this->params['form']['id'];
		if($party_size==3){
			 $party_size=4;
		}else if($party_size==5){
			 $party_size=6;
		}else if($party_size==7){
			 $party_size=8;
		}	
	}
	if(!empty($this->params['pass'][1])&&empty($this->params['pass'][2])){
		$party_size = $this->params['pass'][1];
	}
	if(!empty($this->params['pass'][2])){
		$time = $this->params['pass'][2];
		$time = date("H:i:s",$time);
		$tod=date("Y-m-d");
		$this->loadmodel('Reservation');
		$this->loadmodel('Offer');
		$reser_offer_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
		if(empty($this->params['pass'][0]))
		$this->params['pass'][0]='';
		$party_size = $this->Offer->find('all',array('conditions' => array(
				'Offer.restaurantId'=>$this->params['pass'][0],
				'Offer.offerDate'=>$tod,
				'Offer.offerTime'=>$time
			), 
			'NOT'=>array(
				'Offer.id'=>$reser_offer_id
			),
			'fields'=>array('Offer.seating'),'recursive'=>-1)
		);
		if(empty($party_size)){
			$party_size = $this->Offer->find('all',array('conditions' => array(
				'Offer.restaurantId'=>$this->params['pass'][0],
				'Offer.offerDate'=>$tod,
				'Offer.offerTime >='=>$time
			), 
			'NOT'=>array(
				'Offer.id'=>$reser_offer_id
			),
			'fields'=>array('Offer.seating'),'recursive'=>-1)
		);
		}
		if(empty($party_size[0]['Offer']['seating']))
			$party_size[0]['Offer']['seating']='';
		$this->set('party_size',$party_size[0]['Offer']['seating']);
	}
	
	$user_id='';
	if($this->Auth->user('id')){
		$user_id = $this->Auth->user('id');
	}
	$this->set('user_id',$user_id);
	$user_location='';
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
	
	if(!empty($this->params['pass'][0])){
		$id = $this->params['pass'][0];
	}else{
		$id='';
	}
	$this->loadmodel('Restaurant');
	$rest_detail = $this->Restaurant->find('all',array(
		'recursive'=>1,
		'conditions'=>array(
			'Restaurant.slug_name'=>$id,
			'Restaurant.approved'=> 1
		),
		'contain' => array(			
			'Offer' =>array(
					'fields' => array(
						'Offer.offerTime',
					),
			)
		 ),	
		'fields'=>array(
			'Restaurant.name',
			'Restaurant.slug_name',
			'Restaurant.url',
			'Restaurant.address',
			'Restaurant.city',
			'Restaurant.logo',
			'Restaurant.menu',
			'Restaurant.menu_link',
			'Restaurant.percentage',
			'Restaurant.state',
			'Restaurant.short_description',
			'Restaurant.long_description',
			'Restaurant.phone',
			'Restaurant.startTime',
			'Restaurant.endTime',
			'min(Restaurant.startTime) as stime',
			'max(Restaurant.endTime) as etime'																				
		)
	));
	if(empty($rest_detail[0]['Restaurant']['name'])){
		$this->redirect('/home');
	}
	//pr($rest_detail);
	if(!empty($rest_detail[0]['Restaurant']['menu']))
		$this->set('menu',$rest_detail[0]['Restaurant']['menu']);
	$starttime=strtotime($rest_detail[0]['Restaurant']['startTime']); 
	$endtime=strtotime($rest_detail[0]['Restaurant']['endTime']); 
	$diff=abs(ceil(($endtime-$starttime)/1800));
	$this->set('interval',$diff);
	$this->set('starttime',$starttime);
	$this->set('endtime',$endtime);
	$restaurants['keywords'] = $rest_detail[0]['Restaurant']['name'].', TableSavvy, Chicago Magazine, Last minute dining made easy';
	$restaurants['description'] = 'Last minute Chicago dining at '.$rest_detail[0]['Restaurant']['name'].' made easy';	
	$this->set('meta_for_layout', $restaurants);	
	$this->set('title_for_layout', $rest_detail[0]['Restaurant']['name']);
	$this->set('restaurant_logo',$rest_detail[0]['Restaurant']['logo']);	
	$this->set('rest_detail',$rest_detail);
	$this->set('restaurant', $this);
	$this->loadmodel('Slideshow');
	$rest_detail = $this->Restaurant->find('first',array(
		'recursive'=>-1,
		'conditions'=>array(
			'Restaurant.slug_name'=>$id,
			'Restaurant.approved'=> 1
		),
		'fields'=>array(
			'Restaurant.id'
		)
	));
	$image = $this->Slideshow->find('all',array('conditions'=>array('restaurant_id'=>$rest_detail['Restaurant']['id']),'fields'=>array('path','description'),'order'=>'order_list'));
	//pr($image);
	$this->set('image',$image);	
	$deal=$this->Restaurant->dealtime();
	$this->set('dealtime',$deal[0][0]['max(offerTime)']);
	if(!empty($party_size1)){
		$this->set('party_size', $party_size1);
		$this->set('party_size1', $party_size1);
	}else{
		$this->set('party_size', $party_size);
	}
}

function login(){
        if($this->Auth->user()){
            $this->redirect(array(
                'controller' => 'homes',
                'action' => 'index',
                'admin' => false
            ));
        }
	$this->layout='home';
	$this->set('title_for_popup','Login');
	$deal=$this->Restaurant->dealtime();
	$this->set('dealtime',$deal[0][0]['max(offerTime)']);
}
function account(){
	$this->layout='popup';
	$this->set('title_for_popup','New Account');
}
function help(){
	$this->layout='home';
	$this->set('title_for_layout','Help');
	$deal=$this->Restaurant->dealtime();
	$this->set('dealtime',$deal[0][0]['max(offerTime)']);
}
function checkCreditLimit(){
    $this->loadmodel('User');
    $user_credit_available['available'] = false;
    $user_credit = $this->User->find('first',array('recursive'=>-1));
    if(!empty($user_credit)){
        $user_credit_available['user_credit'] = $user_credit_limit = $user_credit['User']['user_credit'];
        $user_credit_available['used_credit'] = $used_limit = $user_credit['User']['used_credit'];                
        if(($user_credit_limit - $used_limit) > 0)
            $user_credit_available['available'] = true;
    } 
    return $user_credit_available;
}
function reservation(){
          
        $user_credit_available = $this->checkCreditLimit();
        if($user_credit_available['available'])
            $this->set('user_credit_availables',$user_credit_available['available']);
           
	//pr($this->params);
	//if(!empty($this->params)){
		$this->set('time_res',$this->params['url']['time']);
		$this->set('ampm_res',$this->params['url']['ampm']);
		$this->set('party_res',$this->params['url']['party']);
		$this->set('rest_id_res',$this->params['url']['rest_id']);
	//}
        $rest_id = $this->params['url']['rest_id']; 
        $party_size = $this->params['url']['party'];
        $time = $this->params['url']['time'].' '.$this->params['url']['ampm'];
        $selected_time = date('H:i:s',strtotime($time));
        $available_count = $this->Restaurant->check_availability($rest_id,$party_size,$selected_time); 
        if($available_count <=0){
            $this->Session->setFlash(__l('The table was already reserved. Please try again later') , 'default', null, 'error');
            $this->redirect('/home');
            return false;
        }    
	$account_type = $this->Auth->user('account_type'); 
	if($account_type==2){
		$this->Cookie->delete('User');
		$this->Auth->logout();
		$this->redirect('/home');
	}
	$this->layout='popup';
	//$time ='' ; $size =''; $size1 =''; $rest_id = ''; $date ='' ; $starttime='';$offertime='';
	// set the login redirection URL
	if(!empty($this->params['url'])) :
		//if(!empty($this->params['party']) && !empty($this->params['rest_id']) &&  !empty($this->params['time']) &&  !empty($this->params['ampm'])){
		//echo 'hello';
		$credit = $this->Session->read('Auth.credit');
		if(isset($this->params['url']['register'])||!empty($credit)){
			if(!empty($credit))
				$this->Session->delete('Auth.credit');
			$this->Session->setFlash(__l('Thanks for signing up for TableSavvy! We have added a $5 credit to your account, so your first reservation is on us!!!') , 'default', null, 'success');
		}
		$normal = $this->Session->read('Auth.normal');
		if(isset($this->params['url']['user'])||!empty($normal)){
			if(!empty($normal))
				$this->Session->delete('Auth.normal');
			$this->Session->setFlash('You have successfully Registered', 'default', null, 'success');
		}
		if(isset($this->params['url']['user_login']))
			$this->Session->setFlash('You have successfully logged into our site' , 'default', null, 'success');
		$redirectUrl = Router::url('/', true)."reservations?party=".$this->params['url']['party']."&time=".$this->params['url']['time']."&ampm=".$this->params['url']['ampm']."&rest_id=".$this->params['url']['rest_id'];
		//$this->redirect(Router::url('/', true) . $redirectUrl);
		$this->Session->write('Auth.redirectUrl',$redirectUrl);	
		$rest_name = $this->Restaurant->find('first',array(
		'recursive'=>1,
		'conditions'=>array(
			'Restaurant.id'=>$this->params['url']['rest_id']
		)));
		$res_name = $rest_name['Restaurant']['name'];
		$this->Session->write('res_name',$res_name);	
		/*} else {
			echo 'hi';
			$redirectUrl = Router::url('/', true)."homes/reservation?party="."&rest_id=".$this->params['url']['rest_id'];
		//$this->redirect(Router::url('/', true) . $redirectUrl);
		$this->Session->write('Auth.redirectUrl',$redirectUrl);	
		$rest_name = $this->Restaurant->find('first',array(
		'recursive'=>1,
		'conditions'=>array(
			'Restaurant.id'=>$this->params['url']['rest_id']
		)));
		$res_name = $rest_name['Restaurant']['name'];
		$this->Session->write('res_name',$res_name);	
		}*/
	endif;	
	
	if(!empty($redirectParams)):
		$this->params['url']['time'] = $redirectParams['url']['time'];
		$this->params['url']['ampm'] = $redirectParams['url']['ampm'];
		$this->params['url']['party'] = $redirectParams['url']['party'];
		$this->params['url']['rest_id'] = $redirectParams['url']['rest_id'];
	endif;
		//pr($this->params['url']); 
		//$this->params['party']='' ; $this->params['rest_id']='' ; $this->params['time']='' ;  $this->params['ampm'] ='';
	if(!empty($this->params['url'])) :
		$time = $this->params['url']['time'].$this->params['url']['ampm'];
		$size = $this->params['url']['party'];
		$size1 = $this->params['url']['party'];
		if(isset($this->params['url']['chicagomag'])){
			$chicagomag = $this->params['url']['chicagomag'];
		}else{
			$chicagomag='';
			$this->Cookie->delete('chicagomag');
		}
		$this->set('chicagomag',$chicagomag);
		if($size==3){
			$size=4;
		}else if($size==5){
			$size=6;
		}else if($size==7){
			$size=8;
		}
		$rest_id = $this->params['url']['rest_id'];
		$date = date('Y-m-d');
		$starttime = strtotime($time); 
		$offertime = date("H:i:s",$starttime);
		$this->loadmodel('Restaurant');
		$name = $this->Restaurant->find('first',array(
			'conditions'=>array(
				'Restaurant.id'=>$rest_id
			),
			'fields'=>array(
				'name'
			)
		));
		$name = $name['Restaurant']['name'];
		$this->loadmodel('Reservation');
		$reser_offer_id = $this->Reservation->find('list',array(
			'conditions'=>array(
				'Reservation.approved'=>1
			),
			'fields'=>array(
				'offerId'
			),
		));
		$this->loadmodel('Offer');
		$result = $this->Offer->find('count',array(
			'recursive'=>-2,
			'conditions'=>array(
				'Offer.restaurantId'=>$rest_id,
				'Offer.offerDate'=>$date,
				'Offer.seating'=>$size,
				'Offer.offerTime'=>$offertime,
			'NOT'=>array(
					'Offer.id'=>$reser_offer_id
				)
			)
		));
		$offerid = $this->Offer->find('first',array(
			'recursive'=>-2,
			'conditions'=>array(
				'Offer.restaurantId'=>$rest_id,
				'Offer.offerDate'=>$date,
				'Offer.seating'=>$size,
				'Offer.offerTime'=>$offertime,
			'NOT'=>array(
					'Offer.id'=>$reser_offer_id
				)
			),
			'fields'=>array('Offer.id')
		));
		//echo 'res'.$rest_id;
		$offer_id = $offerid['Offer']['id'];
		$this->set('offer_id',$offer_id);
		$this->set('offerid',$offerid);
		$this->set('result',$result);
		$this->set('size',$size1);
		$this->set('time',$time);
		$this->set('name',$name);
		
	endif;
	
	$user_id = '';
		if($this->Auth->user('id')){
			$user_id=$this->Auth->user('id');
			$user_amount = $this->User->find('first',array('conditions'=>array('id'=>$user_id),'fields'=>array('user_amount')));
			$name = $user_amount['User']['user_amount'];
			$this->set('user_amount',$user_amount);
		}
		$this->set('user_id',$user_id);
	$this->set('title_for_popup','Reservation');
}

function get_alert($user_id,$restaurant_id){
	$this->layout = 'ajax';
	$this->loadModel('Alert');
	$rest_detail = $this->Restaurant->find('first',array(
		'recursive'=>-1,
		'conditions'=>array(
			'Restaurant.slug_name'=>$restaurant_id,
			'Restaurant.approved'=> 1
		),
		'fields'=>array(
			'Restaurant.id'																			
		)
	));
	$res_name=$restaurant_id;
	$this->set('restaurant_id',$rest_detail['Restaurant']['id']);
	$restaurant_id = $rest_detail['Restaurant']['id'];
	$site_name = Configure::read('website.name');
	$check = $this->Alert->find('all',array('conditions'=>array('Alert.userId'=>$user_id,'Alert.restaurantId'=>$restaurant_id,'Alert.sitename'=>$site_name)));
	$check_user = $this->Alert->find('first',array('conditions'=>array('Alert.userId'=>$user_id,'Alert.sitename'=>$site_name),'recursive'=>-1));
	if($check_user){
		$sunday = $check_user['Alert']['sunday'];
		$monday = $check_user['Alert']['monday'];
		$tuesday = $check_user['Alert']['tuesday'];
		$wednesday = $check_user['Alert']['wednesday'];
		$thursday = $check_user['Alert']['thursday'];
		$friday = $check_user['Alert']['friday'];
		$saturday = $check_user['Alert']['saturday'];
	}
	if($check){
		$this->Session->setFlash(__l('Restaurant already selected for alert') , 'default', null, 'error');
        $this->set('hide',1);
		if(!empty($this->params['pass'][2]))
				$this->redirect(Router::url('/', true) . 'details/'.$res_name);
	}
	else{
		if($check_user){
			$this->Alert->create();
			$alert = $this->Alert->save(array(
				'userId'=>$user_id,
				'restaurantId'=>$restaurant_id,
				'sunday'=>$sunday,
				'monday'=>$monday,
				'tuesday'=>$tuesday,
				'wednesday'=>$wednesday,
				'thursday'=>$thursday,
				'friday'=>$friday,
				'saturday'=>$saturday,
				'sitename'=>$site_name
			));
		}	
		else{
			$this->Alert->create();
			$alert = $this->Alert->save(array(
				'userId'=>$user_id,
				'restaurantId'=>$restaurant_id,
				'sunday'=>1,
				'monday'=>1,
				'tuesday'=>1,
				'wednesday'=>1,
				'thursday'=>1,
				'friday'=>1,
				'saturday'=>1,
				'sitename'=>$site_name
			));
		}
		if($alert){
			$this->Session->setFlash(__l('Your Alert for this restaurant saved successfully') , 'default', null, 'success');
			$this->set('hide',1);
			if(!empty($this->params['pass'][2]))
				$this->redirect(Router::url('/', true) . 'details/'.$res_name);
		}
		else{
			$this->Session->setFlash(__l('Your Alert for this restaurant cannot be saved') , 'default', null, 'error');
			$this->set('hide',1);
			if(!empty($this->params['pass'][2]))
				$this->redirect(Router::url('/', true) . 'details/'.$res_name);
		}
	}
}

	function howitworks(){
		$this->layout = 'popup';
		$this->set('title_for_layout','How it works');
	}
	function privacypolicy(){
		$this->layout = 'popup';
		$this->set('title_for_layout','Privacy Policy');
	}
	function returnpolicy(){
		$this->layout = 'popup';
		$this->set('title_for_layout','Return Policy');
	}
	function terms(){
		$this->layout = 'popup';
		$this->set('title_for_layout','Terms &amp; Conditions');
	}
	function faq(){
		$this->layout = 'popup';
		$this->set('title_for_layout','FAQ');
	}
	function expired(){
            if(isset($_REQUEST['register'])){
                if( $_REQUEST['register'] == 'credit')
                    $this->Session->setFlash(__l('Thanks for signing up for TableSavvy! We have added a $5 credit to your account, so your first reservation is on us!!!') , 'default', null, 'success');
                else                    
                    $this->Session->setFlash('You have successfully Registered', 'default', null, 'success');
            }
            $this->layout='home';
            $this->paginate = array(
                    'conditions' => array(
                            'Restaurant.approved'=>1,
                            'Restaurant.city'=>Configure::read('website.city_id')
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
                    'limit'=>9,		
                    'recursive'=>2,
                    'order' => array('Restaurant.name ASC')
            );
            $restaurant_detail = $this->paginate('Restaurant');
            $this->set('restaurant_detail',$restaurant_detail);	
	}
	function noimage(){
		
	}
	function all_restaurant(){	
		$this->layout='home';
		$this->Session->delete('rest');
		$this->set('title_for_layout','BrowseAllRestaurants');
		$this->loadmodel('Neighborhood');
		$neighbor_list = $this->Neighborhood->find('list',array(
			'fields'=>array(
					'name'
			),
			'conditions'=>array('Neighborhood.city_id'=>Configure::read('website.city_id')),
			'order' => array('name ASC')
		 ));
		$this->set('neighbor_list',$neighbor_list);
		$this->loadmodel('Reservation');
		$reser_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
		//pr($reser_id);
		$this->loadmodel('Offer');
		$time=date('H:i:s');
		$party=array(8,7,6,5,4,3,2);
		$this->loadmodel('Cuisine');
		$cuisine_list = $this->Cuisine->find('list',array(
			'fields'=>array(
				'name'
			),
			'order' => array('name ASC')
		));
		//pr($cuisine_list);
		$this->set('cuisine_list',$cuisine_list);
			$limit = 9;
			if(Configure::read('website.id')!=1)
				$limit =9;
		$reser_offer_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
		$date = date('Y-m-d');
		$result = $this->Offer->find('all',array(
			'conditions'=>array(
				'Offer.offerDate'=>$date,
			'NOT'=>array(
					'Offer.id'=>$reser_offer_id
				)
			),
			'fields'=>array(
				'Offer.restaurantId'
			),
			'order'=>'count(Offer.restaurantId)',
			'group'=>'Offer.restaurantId','recursive'=>-1
		));
		$res1 = array();
		foreach($result as $res){
			$res1[]=$res['Offer']['restaurantId'];
		}
		$restr = $this->Restaurant->find('all',array(
			'conditions' => array(
				'Restaurant.approved'=>1,
				'Restaurant.city'=>Configure::read('website.city_id')	
			),
			'fields'=>array(
				'id'
			),
			'recursive'=>'-1'
	 	));
		foreach($restr as $res){
			$res2[]=$res['Restaurant']['id'];
		}
		$restaurant_detail = $this->Restaurant->find('all',array(
			'conditions' => array(
				'Restaurant.id'=>$res1,
				'Restaurant.approved'=>1,
				'Restaurant.city'=>Configure::read('website.city_id')	
			),
			'contain' => array(			
				'Restaurantcuisine' =>array(
					'Cuisine' => array(
						'fields' => array(
							'Cuisine.name',
						)
					)
				),
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
			'recursive'=>2
		));
		$res3 = array_diff($res2, $res1);
		$restaurant_detail1 = $this->Restaurant->find('all',array(
			'conditions' => array(
				'Restaurant.id'=>$res3,
				'Restaurant.approved'=>1,
				'Restaurant.city'=>Configure::read('website.city_id')	
			),
			'contain' => array(			
				'Restaurantcuisine' =>array(
					'Cuisine' => array(
						'fields' => array(
							'Cuisine.name',
						)
					)
				),
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
			'recursive'=>2
		));
		$restaurant_detail3=array_merge($restaurant_detail,$restaurant_detail1);
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
		//$restaurant_detail = $this->paginate('Restaurant');
		$dealtime='7:00:00';
		$time = date('H:i:s',time());
		$dealtime=strtotime($dealtime);
		$time=strtotime($time);	
		$this->set('restaurant', $this);
		$this->set('restaurant_detail',$restaurant_detail3);
		$deal=$this->Restaurant->dealtime();
		//pr($restaurant);
		$this->set('dealtime',$deal[0][0]['max(offerTime)']);
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
		//$this->set('disabled','disabled');
	}
	public function clear_rest_offer(){
		$this->loadmodel('Reservation');
		$reser_id = $this->Reservation->find('list',array('conditions'=>array('Reservation.approved'=>1),'fields'=>array('Reservation.offerId')));
		//pr($reser_id);
		$this->loadmodel('Offer');
		$time=date('H:i:s');
		$party=array(8,7,6,5,4,3,2);
		//pr($party);
		$offer_date = date('Y-m-d');
		$time_by_testaurant=array();
		$search_condition = array();
		//pr($search_condition);
		$time_by_testaurant = $this->Offer->find('all',array('conditions' => array(
			'Offer.offerDate' => $offer_date,
			'Offer.offerTime >='=>$time,
			'Offer.seating'=>$party,
			'NOT'=>array(
				'Offer.id'=>$reser_id
			),
		), 'fields'=>array('Offer.restaurantId','Offer.restaurantId'),'group'=>'Offer.restaurantId','recursive'=>-1));
		foreach($time_by_testaurant as $restaurants){ 
		$restr = $this->Restaurant->find('first',array(
			'conditions' => array(
				'Restaurant.id'=>$restaurants['Offer']['restaurantId']
			),
			'fields'=>array(
				'startTime',
				'endTime'
			),
			'recursive'=>'-1'
		 ));
		 $this->loadmodel('Table');
         $this->Table->delete_offer_time($restr['Restaurant']['startTime'],$restr['Restaurant']['endTime'],$restaurants['Offer']['restaurantId']);
		} 
		$time_by_testaurant = $this->Offer->find('list',array('conditions' => array(
			'Offer.offerDate' => $offer_date,
			'Offer.offerTime >='=>$time,
			'Offer.seating'=>$party,
			'NOT'=>array(
				'Offer.id'=>$reser_id
			),
		), 'fields'=>array('Offer.restaurantId','Offer.restaurantId'),'group'=>'Offer.restaurantId','recursive'=>-1));
		return $time_by_testaurant;
	}
	public function auto_com_red($id=null){
		$this->layout = 'ajax';
		$this->autoRender=false;
		$search_condition['Restaurant.name LIKE'] =$id .'%';
        $search_condition['Restaurant.approved'] = 1;
        $search_condition['Restaurant.city'] = Configure::read('website.city_id');
       	$restaurants = $this->Restaurant->find('first', array(
            'conditions' => $search_condition,
            'fields' => array('name','id','slug_name'),
            'recursive'=>'-1'
        ));
		if(empty($restaurants['Restaurant']['slug_name']))
			echo $restaurants['Restaurant']['id'];
		else
			echo $restaurants['Restaurant']['slug_name'];
	}
}
?>