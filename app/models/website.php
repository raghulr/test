<?php
class Website extends AppModel{
	var $name = 'Website';
	function __construct($id = false, $table = null, $ds = null){
        parent::__construct($id, $table, $ds);
		 $this->validate = array(
			'website_name' => array(
				'rule2' => array(
					'rule' => 'isUnique',
					'message' => __l('This Website name already exists')
				) ,
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'fb_app_id' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'fb_app_secret_key' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				)
			),
			'email_logo' => array(
				'rule2' => array(
					'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
					'message' => __l('Please supply a valid image.')
				)
			),
			'website_logo' => array(
				'rule2' => array(
					'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
					'message' => __l('Please supply a valid image.')
				)
			),
			'fb_url' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				),
				'rule2' => array(
					'rule' => 'url',
					'message' => __l('Please supply a valid URL.')
				)
			),
			'twitter_url' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => __l('Required')
				),
				'rule2' => array(
					'rule' => 'url',
					'message' => __l('Please supply a valid URL.')
				)
			)
			
			);
	}
}
?>