<?php
class Slideshow extends AppModel{
	var $name = 'Slideshow';
	var $useTable='slideshows';
	var $validate=array(
					'path'=>array(
						'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')), 
						'required'=>true,      
						'message' => 'Please supply a valid image.'
						)
						
						
					);	
}	