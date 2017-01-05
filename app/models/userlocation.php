<?php 
class Userlocation extends AppModel{
	var $useTable = 'userlocations';
	var $name = 'Userlocation';
	var $virtualFields = array('full_address' => 'CONCAT(Userlocation.address," ",Userlocation.city," ",Userlocation.state," ",Userlocation.zipcode)');
}
?>