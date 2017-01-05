<?php
class Recipient extends AppModel{
	 var $name = 'Recipient';
          function __construct($id = false, $table = null, $ds = null){
              parent::__construct($id, $table, $ds);
         $this->validate = array(
			'email' => array(				
				'rule2' => array(
					'rule' => 'email',
					'message' => 'Email Must be a valid email'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Email field should not be Empty!'
				)
			));
          }
}