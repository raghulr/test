<?php
class SuperController extends AppController{
	var $name = 'Super';
	var $uses = array('User');
	var $components = array(
        'Email'
    );
	function beforeFilter(){
		parent::beforeFilter();
	}
	function index(){	
		$this->redirect('/admin');
	}
	
}	