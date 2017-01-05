<?php
class AdminController extends AppController{
	var $name = 'Admin';
	var $uses = array('User');
	var $components = array(
        'Email'
    );
	function beforeFilter(){
		$this->layout='admin';
		parent::beforeFilter();
	}
	function index(){
		$this->Session->delete('Auth.redirectUrl');
		$this->layout='admin';
	}
}	