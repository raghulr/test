<?php 
class Reservation extends AppModel
{
	var $name = 'Reservation';
	var $primaryKey = 'id';
	var $belongsTo = array(
		'User'=>array(	
			'className' => 'User',
			'foreignKey' => 'userId'
		),
		'Offer'=>array(
			'className' => 'Offer',
			'foreignKey' => 'offerId'
		)
	);
}