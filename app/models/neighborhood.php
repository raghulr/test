<?php
class Neighborhood extends AppModel{
	var $name = 'Neighborhood';
	function __construct($id = false, $table = null, $ds = null){
        parent::__construct($id, $table, $ds);
        $this->validate = array(
			'name' => array(
                'rule4' => array(
                    'rule' => array(
                        'between',
                        3,
                        20
                    ) ,
                    'message' => __l('Must be between of 3 to 64 characters')
                ) ,
				'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Neighborhood is already exist')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[a-zA-Z]/'
                    ) ,
                    'message' => __l('Must be start with an alphabets')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
		);
	}			
}