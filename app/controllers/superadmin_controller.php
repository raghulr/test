<?php
class SuperController extends AppController{
	var $name = 'Super';
	var $uses = array('User');
	var $components = array(
        'Email'
    );
	function beforeFilter(){
		$this->layout='superadmin';
		parent::beforeFilter();
	}
	function super_index(){
		$this->layout('superadmin');
	}
	
}	