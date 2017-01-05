<?php
class Restaurant extends AppModel{
	var $name = 'Restaurant';
	function __construct($id = false, $table = null, $ds = null){
        parent::__construct($id, $table, $ds);
        $this->validate = array(
			'name' => array(
				'rule2' => array(
					'rule' => 'isUnique',
					'message' => __l('This Restaurant name already exists')
				) ,
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'address' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'message' => __l('Required')
				)
			),
			'state' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'phone' => array(
				'rule2' => array(
					'rule' => array('phone', null, 'us'),
					'message' => 'Please enter correct format (xxx) xxx-xxxx'
				),
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Required'
				)
			),
			'url' => array(
				'rule2' => array(
					'rule' => 'url',
					'message' => __l('Enter a valid URL')
				),
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'percentage' => array(
				'rule2' => array(
					'rule' => 'numeric',
					'message' => __l('Enter numbers only')
				),
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			)
		);
	}
	
	var $belongsTo = array(
        'Neighborhood' => array(
            'className' => 'Neighborhood',
            'foreignKey' => 'neighborhoodId',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) 
	);	
	var $hasMany=array(
        'Slideshow'=>array(
                'className' => 'Slideshow',            
                'foreignKey'=> 'restaurant_id',
                'dependent'=> true
                ),
                'Restaurantcuisine'=>array(
                        'foreignKey'=> 'restaurant_id' 
                ),
                'Offer'=>array(
                        'foreignKey'=> 'restaurantId' 
                ),
                'Alert'=>array(
                        'foreignKey'=> 'restaurantId' 
                )
        );
        function check_table($offerid){
            App::import('model','Reservation');
            $this->Reservation = new Reservation;
            $already_reserved = $this->Reservation->find('count',array(
                'conditions'=>array(
                    'Reservation.approved'=>1,
                    'Reservation.offerId'=>$offerid
                ),
                'recursive'=>-1
            ));
            return $already_reserved;
        }
        function check_offer($offerid){
            App::import('model','Offer');
            
            $time = date('H:i:s',time());
            $this->Offer = new Offer;
            $already_reserved = $this->Offer->find('count',array(
                'conditions'=>array(
                    'Offer.Id'=>$offerid,
                    'Offer.offerTime >='=>$time,
                ),
            ));
            return $already_reserved;
        }
        function check_reservation($offerid){
            App::import('model','Reservation');
            $this->Reservation = new Reservation;
            $already_reserved = $this->Reservation->find('count',array(
                'conditions'=>array(
                    'Reservation.offerId'=>$offerid,
                    'Reservation.approved'=>1
                ),
            ));
            return $already_reserved;
        }
         function check_rest($offerid){
            App::import('model','Offer');
            $time = date('H:i:s',time());
            $this->Offer = new Offer;
            $resid = $this->Offer->find('first',array(
                'conditions'=>array(
                    'Offer.Id'=>$offerid,
                    'Offer.offerTime >='=>$time,
                ),
                'fields'=>array('restaurantId'),
                'recursive'=>-1
            ));
            App::import('model','Offer');
             $this->Restaurant = new Restaurant;
            $approved=$this->Restaurant->find('count',array(
                'conditions'=>array(
                    'Restaurant.Id'=>$resid['Offer']['restaurantId'],
                    'Restaurant.approved'=>1
                ),'recursive'=>-1
            ));
            return $approved;
        }
	function check_availability($restaurant_id, $party_size, $time_select=null){
            $party_sizes =  array(2=>2,3=>4,4=>4,5=>6,6=>6,7=>8,8=>8);
            if(!empty($party_size)){
               $party_size = $party_sizes[intval($party_size)];
			}
            App::import('model','Reservation');
            $this->Reservation = new Reservation;
            $reservation_list = $this->Reservation->find('list',array(
                'fields'=>array(
                    'Reservation.offerId','Reservation.offerId'
                 ),
                'conditions'=>array(
                    'Reservation.approved'=>1
                )
            ));
            $currentdate = date('Y-m-d');
            $conditions['Offer.restaurantId']= $restaurant_id;
            $conditions['Offer.offerDate'] = $currentdate;
            $conditions['NOT']=array('Offer.id'=>$reservation_list);
            if(!empty($party_size)) //select offer by party size
                $conditions['Offer.seating']= $party_size;
            $current_time = date('H:i:s');
            $conditions['Offer.offerTime >'] = $current_time;
            $available_count = $this->Offer->find('count', array(
                'contain'=>array(
                    'Reservation'
                ),
                'conditions'=>$conditions
            ));
            return $available_count;
        }	
        function widget_check_availability($restaurant_id, $party_size, $time_select=null){
            $party_sizes =  array(2=>2,3=>4,4=>4,5=>6,6=>6,7=>8,8=>8);
            $re_time=date('Y-m-d').' 00:00:00';
            if(!empty($party_size)){
               $party_size = $party_sizes[intval($party_size)];
			}
            App::import('model','Reservation');
            $this->Reservation = new Reservation;
            $reservation_list = $this->Reservation->find('list',array(
                'fields'=>array(
                    'Reservation.offerId','Reservation.offerId'
                 ),
                'conditions'=>array(
                    'Reservation.approved'=>1,
                    'Reservation.trasaction_time >='=>$re_time,
                    
                )
            ));
            $currentdate = date('Y-m-d');
            $conditions['Offer.restaurantId']= $restaurant_id;
            $conditions['Offer.offerDate'] = $currentdate;
            $conditions['NOT']=array('Offer.id'=>$reservation_list);
            if(!empty($party_size)) //select offer by party size
                $conditions['Offer.seating']= $party_size;
            $current_time = date('H:i:s');
            $conditions['Offer.offerTime'] = $time_select;
            $available_count = $this->Offer->find('count', array(
                'contain'=>array(
                    'Reservation'
                ),
                'conditions'=>$conditions
            ));
            return $available_count;
        }	
	function tableAvailability($restaurant_id, $party_size=null, $time_select=null){
            if(!empty($party_size)&&$party_size==3){
                    $party_size=4;
            }else if(!empty($party_size)&&$party_size==5){
                    $party_size=6;
            }else if(!empty($party_size)&&$party_size==7){
                    $party_size=8;
            }	            
            $restaurant = $this->find('first',array(
                'conditions'=>array('Restaurant.id'=>$restaurant_id),
                'fields' => array(
                    'Restaurant.startTime',
                    'Restaurant.endTime'
		),
                'recursive'=>-1
            ));
            $currentdate = date('Y-m-d');
            $current_time = (!empty($time_select)&&$time_select>=date('H:i:s'))?$time_select:date('H:i:s');
            $restaurant_start_time =($restaurant['Restaurant']['startTime'] > date('H:i:s'))?$restaurant['Restaurant']['startTime']:date('H:i:s');
            if(isset($time_select)){
				 if($time_select!='23:30:00'){
                    $selected_start_time = date('H:i:s',strtotime($time_select.'-30 MINUTES'));
                    if($selected_start_time < date("H:i:s"))
                        $selected_start_time = date('H:i:s'); 
                    $selected_end_time = date('H:i:s',strtotime($time_select.'+30 MINUTES'));
				}else{
					$selected_start_time = date('H:i:s',strtotime($time_select.'-30 MINUTES'));
                    if($selected_start_time < date("H:i:s"))
                        $selected_start_time = date('H:i:s'); 
                    $selected_end_time = date('H:i:s',strtotime($time_select));
				}
            }
            $re_time=$currentdate.' 00:00:00';
            App::import('model','Reservation');
            $this->Reservation = new Reservation;
            $reservation_list = $this->Reservation->find('list',array(
                'fields'=>array(
                    'Reservation.offerId','Reservation.offerId'
                 ),
                'conditions'=>array(
                    'Reservation.approved'=>1,
                    'Reservation.trasaction_time >='=>$re_time,
                )
            ));
            
            $conditions['Offer.restaurantId']= $restaurant_id;
            $conditions['Offer.offerDate'] = $currentdate;
            $conditions['NOT']=array('Offer.id'=>$reservation_list);
            if(!empty($party_size)) //select offer by party size
                $conditions['Offer.seating']= $party_size;
            
            if(!empty($time_select)) //select offer by selected time
                $conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
                    $selected_start_time ,
                    $selected_end_time
                );
            else
                $conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
                    $restaurant_start_time,
                    $restaurant['Restaurant']['endTime']
                );
            $tables = $this->Offer->find('all', array(
                'contain'=>array(
                    'Reservation'
                ),
                'conditions'=>$conditions,
                'order' => 'seating',
                'group'=>array('Offer.seating','Offer.offerTime')
            ));
			//pr($tables);
            $available_tables = array();
            $seating = '';
            if(empty($tables)){
                    unset($conditions['Offer.offerTime BETWEEN ? AND ? ']);
                    $conditions['Offer.offerTime >'] = $current_time;

                    $tables = $this->Offer->find('all', array(
                            'contain'=>array(
                                    'Reservation'
                            ),
                            'conditions'=>$conditions,
                            'order' => array('seating,offerTime'),
                            'group'=>'Offer.offerTime'

                    ));
            }
            //pr($tables);
            //exit;
            foreach($tables as $table){
                if($seating == $table['Offer']['seating'] || $seating =='')
                    $available_tables[$table['Offer']['seating']][]=$table['Offer']['offerTime']; 
                else
                    break;
                $seating = $table['Offer']['seating'];
            }
            //pr($available_tables);
            return $available_tables;
		
	}
        function widgetTableAvailablity($restaurant_id, $party_size=null, $time_select=null){
            if(!empty($party_size)&&$party_size==1){
                    $party_size=2;
            }else if(!empty($party_size)&&$party_size==3){
                    $party_size=4;
            }else if(!empty($party_size)&&$party_size==5){
                    $party_size=6;
            }else if(!empty($party_size)&&$party_size==7){
                    $party_size=8;
            }	            
            $restaurant = $this->find('first',array(
                'conditions'=>array('Restaurant.id'=>$restaurant_id),
                'fields' => array(
                    'Restaurant.startTime',
                    'Restaurant.endTime'
		),
                'recursive'=>-1
            ));
            $currentdate = date('Y-m-d');
            $current_time = (!empty($time_select)&&$time_select>=date('H:i:s'))?$time_select:date('H:i:s');
            $restaurant_start_time =($restaurant['Restaurant']['startTime'] > date('H:i:s'))?$restaurant['Restaurant']['startTime']:date('H:i:s');
            if(isset($time_select)){
				 if($time_select!='23:30:00'){
                    $selected_start_time = date('H:i:s',strtotime($time_select.'-30 MINUTES'));
                    if($selected_start_time < date("H:i:s"))
                        $selected_start_time = date('H:i:s'); 
                    $selected_end_time = date('H:i:s',strtotime($time_select.'+30 MINUTES'));
				}else{
					$selected_start_time = date('H:i:s',strtotime($time_select.'-30 MINUTES'));
                    if($selected_start_time < date("H:i:s"))
                        $selected_start_time = date('H:i:s'); 
                    $selected_end_time = date('H:i:s',strtotime($time_select));
				}
            }
            $re_time=$currentdate.' 00:00:00';
            $query = "select * from offers Offer left join reservations r on Offer.id = r.offerid";
            $query = $query ." where (r.id is null OR r.approved = 0) and Offer.restaurantId = '".$restaurant_id."' and Offer.offerDate = '".$currentdate."' and Offer.offerTime BETWEEN '".$restaurant_start_time."' AND  '".$restaurant['Restaurant']['endTime']."' GROUP BY `Offer`.`seating`,`Offer`.`offerTime` ORDER BY `Offer`.`seating`";
            $tables = $this->Offer->query($query);
            //$time_by_testaurant = Set::classicExtract($time_by_testaurant,'{n}.Offer.restaurantId');
            //pr($time_by_testaurant);exit;
            $available_tables = array();
            $seating = '';
            if(empty($tables)){
                    unset($conditions['Offer.offerTime BETWEEN ? AND ? ']);
                    $conditions['Offer.offerTime >'] = $current_time;
                    $query = "select * from offers Offer left join reservations r on Offer.id = r.offerid";
                    $query = $query ." where (r.id is null OR r.approved = 0) and Offer.restaurantId = '".$restaurant_id."' and Offer.offerDate = '".$currentdate."' and Offer.offerTime > '".$current_time."' GROUP BY `Offer`.`offerTime` ORDER BY `Offer`.`seating` AND `Offer`.`offerTime`";
                    $tables = $this->Offer->query($query);
            }
            //pr($tables);
            //exit;
            foreach($tables as $table){
                if($seating == $table['Offer']['seating'] || $seating =='')
                    $available_tables[$table['Offer']['seating']][]=$table['Offer']['offerTime']; 
                else
                    break;
                $seating = $table['Offer']['seating'];
            }
            //pr($available_tables);
            return $available_tables;
		
	}
	function dealtime(){
		$currentdate = date('Y-m-d');
		$sql = "select max(offerTime) from offers as offer,reservations as reserve,restaurants as rest where offer.offerDate='".$currentdate."' and offer.id NOT IN (select offerId from reservations) and offer.restaurantId IN (select id from restaurants where approved=1)";
		$deal_result = $this->query($sql);
		return $deal_result;
	}	
}		