<?php
class Restaurantcuisine extends AppModel{
	 var $name = 'Restaurantcuisine';
	 var $belongsTo = array(
	 		'Cuisine'=>array(
				'className'=>'Cuisine',
				'foreignKey'=>'cuisine_id'
			)
	 	);
}

?>