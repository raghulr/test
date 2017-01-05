<?php
class  SubscriptionsController extends AppController {
 var $name ='Subscriptions';
 var $components = array(
	'Email'
 );
 var $uses = array(
 	'Subscription',
	'EmailTemplate',
	'User'
 );
function index(){
	$this->layout='subscription';
	Configure::write('debug', 1);
	if(!empty($this->data)){
		$this->data['Subscription']['firstName']= isset($this->data['Subscription']['firstName'])?trim($this->data['Subscription']['firstName']):'';
		$this->data['Subscription']['lastName']=isset($this->data['Subscription']['lastName'])?trim($this->data['Subscription']['lastName']):'';
		$this->Subscription->create();
		$slug=trim(Configure::read('website.slug'));
		if($slug!='tablesavvy'){
			unset($this->validate['Subscription']['phone']);
			unset($this->validate['Subscription']['lastName']);
			unset($this->validate['Subscription']['firstName']);
			unset($this->validate['Subscription']['passwd']);
			unset($this->validate['Subscription']['confirm_password']);
		}
		
		$this->Subscription->set($this->data);
		unset($this->validate['Subscription']['email']['rule3']);
			if($this->Subscription->validates()){
				$emailcheck=$this->Subscription->find('first',array('conditions'=>array('email' => $this->data['Subscription']['email'])));
				if(empty($emailcheck['Subscription']['email'])){
				if(isset($this->data['Subscription']['passwd']) && !empty($this->data['Subscription']['passwd'])){
					$this->data['Subscription']['password'] = md5($this->data['Subscription']['passwd']);
				}
				$this->Subscription->save($this->data);
				$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Subscription Mail');
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,
					'##SITE_NAME##' => Configure::read('site.name') ,
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
					'##EMAIL##' => $this->data['Subscription']['email'],
					'##RESET_URL##' => Router::url(array(
						'controller' => 'users',
						'action' => 'login'
					) , true) ,
					'##FROM_EMAIL##' => 'TableSavvy <'.($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'].'>' ,
					'##CONTACT_URL##' => Router::url(array(
						'controller' => 'contacts',
						'action' => 'add',
						'admin' => false
					) , true) ,
					'##SITE_LOGO##' => Router::url(array(
						'controller' => 'img',
						'action' => 'blue-theme',
						'logo-email.png',
						'admin' => false
					) , true) ,
				);
				$this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
				$this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
				$this->Email->to = 'jerklein@gmail.com';
				//this->Email->cc  = 'sivraj.it@gmail.com';
				$this->Email->subject = strtr($email['subject'], $emailFindReplace);
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				$this->Email->send(strtr($email['email_content'], $emailFindReplace));
				$this->Session->setFlash(__l("Thanks for signing up! We'll let you know when we launch!") , 'default', null, 'success');
				 
				$this->set('subscribe',1);
				}else{
				$this->Session->setFlash(__l("You have previously signed up for an account.. We will email you as soon as we go live!") , 'default', null, 'success');
				}
			}else{
			$this->set('subscribe',0);
			}
		
	}
}
function blog_sub(){
	$this->layout='subscription';
	$this->Subscription->create();
	$this->data['Subscription']['email']=$this->params['form']['mail'];
	if(!empty($this->data)){
		$this->Subscription->set($this->data);
		if($this->Subscription->validates()){
			$this->Subscription->save($this->data);
			$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Subscription Mail');
			$emailFindReplace = array(
				'##SITE_LINK##' => Router::url('/', true) ,
				'##SITE_NAME##' => Configure::read('site.name') ,
				'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
				'##EMAIL##' => $this->data['Subscription']['email'],
				'##RESET_URL##' => Router::url(array(
					'controller' => 'users',
					'action' => 'login'
				) , true) ,
				'##FROM_EMAIL##' => 'TableSavvy <'.($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'].'>' ,
				'##CONTACT_URL##' => Router::url(array(
					'controller' => 'contacts',
					'action' => 'add',
					'admin' => false
				) , true) ,
				'##SITE_LOGO##' => Router::url(array(
					'controller' => 'img',
					'action' => 'blue-theme',
					'logo-email.png',
					'admin' => false
				) , true) ,
			);
			$this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
			$this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
			$this->Email->to = 'jerklein@gmail.com';
			$this->Email->subject = strtr($email['subject'], $emailFindReplace);
			$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
			$this->Email->send(strtr($email['email_content'], $emailFindReplace));
			$this->set('subscribe',1);
			echo 'Thanks for Subscription';
			exit;
		}else{
			$this->set('subscribe',0);
			echo 'This email address already exists';
			exit;
		}
	}
	$this->autoRender = false;
	exit;
}
function admin_list(){
	$list=$this->Subscription->find('list',array('fields'=>array('email')));
	$this->set(compact('list'));
}
function super_list(){
	$this->layout = 'superadmin';
	$list=$this->Subscription->find('list',array('conditions'=>array('Subscription.firstName'=>NULL),'fields'=>array('email')));
	$this->set(compact('list'));
}
function super_fulllist(){
	$this->layout = 'superadmin';
	$list=$this->Subscription->find('all',array('conditions'=>array('Subscription.firstName !='=>NULL),'order' => array('created' => 'asc')));
	$this->set(compact('list'));
}	


}?>