<?php
class Offer extends AppModel{
	var $name = 'Offer';
	var $hasMany = array(
		 'Reservation'=>array(
		 'className'=>'Reservation',
					 'foreignKey'=>'offerId'
		 )
	);
	var $belongsTo = array(
		'Restaurant' => array(
			'className' => 'Restaurant',
			'foreignKey' => 'restaurantId'
		)
	);
	var $validate=array(
	'offerDays'=>array(
			'rule3'=>array(
				'rule'=>array(
					'checkday',
					'daysorweek',
					'offerDays'
				),
				'required'=>true,
				'message'=>'Maximum 52 weeks or 365 days'	
			),
		'rule2'=>array(
			'rule'=>'numeric',
			'required'=>true,
			'message'=>'Must be Numeric'
			),
		'rule1'=>array(
			'rule'=>'notEmpty',
			'required'=>true,
			'message'=>'Required'
			),
		),  
		'Count' => array(
			'maxLength' => array(
			   'rule' => array('maxLength', 2),
			   'message' => 'Maximum 3 digits.',
			   'last' => true
		    ),'rule2'=>array(
			'rule'=>'numeric',
			'required'=>true,
			'message'=>'Must be Numeric'
			),
		)	
								
	  );
	function checkday($field1 = array() , $field2 = null, $field3 = null){
		if ($this->data[$this->name][$field2] == 'Days'&&$this->data[$this->name][$field3]<=1095) {
			return true;
		}
		elseif ($this->data[$this->name][$field2] == 'Weeks'&&$this->data[$this->name][$field3]<=156) {
			return true;
		}
		return false;
	} 
	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null) {
		$conditions[] ="1 = 1 GROUP BY content";
		$recursive = -1;
		$params = array(
			  'conditions' => $conditions,
			  'recursive' => $recursive,
			  'fields' => $fields,
			  'order' => $order,
			  'limit' => $limit,
			  'page' => $page
		 );
		 return $this->find('all', $params);
	}	
	function paginateCount($conditions = null, $recursive = -1) {
		$date = date("Y-m-d");
		App::import('Model', 'CakeSession');
		$session = new CakeSession();
		$id = $session->read('Auth.resid');
		//$id=2;
		$sql = "SELECT count(*) FROM offers where offerDate >='".$date."' AND content IS NOT NULL AND restaurantId = ".$id." AND id not in (SELECT offerId FROM reservations where approved=1) GROUP BY content";
		$this->recursive = $recursive;
		$results = $this->query($sql);
		return count($results);
	}	  
}