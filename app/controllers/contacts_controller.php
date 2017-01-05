<?php
class ContactsController extends AppController{
	var $components = array(
        'Email'
    );
	var $uses = array(
        'Contact',
        'EmailTemplate'
    );
	function beforeFilter(){
		parent::beforeFilter();
	}
	function chicago_add($id=null){
		$this->add();
		$this->render('add');
	}
	function contactus($id=null){
		$this->set('inquiries','');
		if(!empty($this->params['pass'][0])&&$this->params['pass'][0]==1){
			$this->set('inquiries','Restaurant Inquiries');
			}
		$this->layout= "home";
                $this->set('title_for_layout',' Chicago Dining | Last Minute Restaurant Reservations | Contact Us  ');
		if(!empty($this->data)):
			$this->Contact->set($this->data);
			if ($this->Contact->validates()):
				$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Contact Us');
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,
					'##SITE_LOGO##' => Configure::read('website.logo'),
					'##FACEBOOK##' => Configure::read('website.facebook'),
					'##TWITTER##' => Configure::read('website.twitter'),
					'##USERNAME##' => 'Admin',
					'##NAME##' => (isset($this->data['Contact']['name'])) ? $this->data['Contact']['name'] : '',
					'##EMAIL##' => (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '',
					'##SITE_NAME##' => Configure::read('website.name') ,
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
					'##MESSAGE##' => $this->data['Contact']['comment'],
					'##SUBJECT##' => 'Contact form',
					'##YEAR_MAIL##' => $this->year_mail,
					'##CONTACTTYPE##' => $this->data['Contact']['contact'],
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
				$this->Email->from = (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '';
				$this->Email->replyTo = (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '';
				$this->Email->to = 'support@tablesavvy.com';
				$this->Email->subject = strtr($email['subject'], $emailFindReplace);
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				$this->Contact->save();
				if($this->Email->send(strtr($email['email_content'], $emailFindReplace))):
					$this->Contact->save();
					$redirect_url = Router::url(array(
						'controller' => 'homes',
						'action' => 'index',
						'admin' => false
					));
					$this->Session->setFlash('Your comment sent successfully' , 'default', null, 'success');
					$this->redirect('/homes');
				else:
					$this->Session->setFlash('Your comment doesn\'t send successfully. please try agian' , 'default', null, 'error');
				endif;
			endif;
		endif;
	}
}
