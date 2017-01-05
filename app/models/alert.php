<?php 
class Alert extends AppModel{
	var $name = 'Alert';
	var $belongsTo = array(
        'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'restaurantId',
        ) 
	);	
}
?>