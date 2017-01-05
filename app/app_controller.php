<?php
/* SVN FILE: $Id: app_controller.php 22380 2010-09-02 13:22:12Z aravindan_111act10 $ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

   var $view = 'Theme';
   var $theme = 'tablesavvy';
   var $year_mail = '2013';
   var $components = array(
        'RequestHandler',
	'Session',
        'Security',
        'Auth',
        'XAjax',
        'Cookie',
        'Pdf',
		'Images'
		//'DebugKit.Toolbar'
    );
	//var $components = array('DebugKit.Toolbar' => array('history' => 10, 'historyStorage' => 'file'));

    var $helpers = array(
	'Ajax',
        'Html',
        'Javascript',
	'Session',
        'Form',
	'Asset',
        'Auth',
        'Time',
    );

    var $cookieTerm = '+53 weeks';
    //var $cookieTerm = '+1 Days';
	function beforeRender()  {
        $this->set('js_vars_for_layout', (isset($this->js_vars)) ? $this->js_vars : '');
        $user_profile = $this->Auth->user('id');
        if(!empty($user_profile)){
        $this->loadmodel('User');
        $user = $this->User->find('first', array(
                'conditions' => array(
                        'User.id =' => $user_profile
                ) ,
                'fields' => array(
                        'User.new_user',
                        'User.account_type',
                        'User.firstName',
                        'User.lastName',
                        'User.user_amount'
                ),
                'recursive'=>-1
        ));

        Configure::write('user.firstName', $user['User']['firstName']);
        Configure::write('user.lastName', $user['User']['lastName']);
        Configure::write('user.user_amount', $user['User']['user_amount']);
        }else{
            Configure::write('user.firstName', '');
            Configure::write('user.user_amount', 0);
        }
      	parent::beforeRender();
    }
    function _setTheme(){
        $url = Router::url( $this->here, true );
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);
        $subdomain_name = '';
        if(!empty($host[0])){
            $subdomain_name = $host[0];
        }
	$this->loadModel('Website');
        $subdomain = $this->Website->find('first',array(
            'conditions'=>array(
                'Website.active'=>1,
                'Website.website_slug'=>$subdomain_name
            )
        ));
        if(!empty($subdomain)){
            $this->theme = $subdomain['Website']['website_slug'];
            Configure::write('website.name', $subdomain['Website']['website_name']);
            Configure::write('website.slug', $subdomain['Website']['website_slug']);
            Configure::write('website.id', $subdomain['Website']['id']);
            Configure::write('website.city_id', $subdomain['Website']['city_id']);
            Configure::write('website.fbId',$subdomain['Website']['fb_app_id']);
            Configure::write('website.fb_secret_key',$subdomain['Website']['fb_app_secret_key']);
            Configure::write('website.logo',Router::url("/theme/tablesavvy/images/TS_email_logo2.png",true));
            Configure::write('website.facebook',$subdomain['Website']['fb_url']);
            Configure::write('website.twitter',$subdomain['Website']['twitter_url']);
        } else{
            $theme = $this->Session->read('theme');
            if(!empty($_GET['theme'])){
                $this->Session->write('theme', $_GET['theme']);
                $this->theme = $this->Session->read('theme');
            }
            elseif(!empty($theme)){
                $this->Session->read('theme');
                $this->theme = $this->Session->read('theme');
            }else{
                $this->theme = 'tablesavvy';
            }
            if($this->theme == 'tablesavvy'){
                Configure::write('website.id', 1);
                Configure::write('website.name', 'TableSavvy');
                Configure::write('website.slug', 'tablesavvy');
                Configure::write('website.logo',Router::url('/theme/tablesavvy/images/TS_email_logo2.png',true));
            }
            else{
                Configure::write('website.id', 2);
                Configure::write('website.name', 'Chicago Magazine');
                Configure::write('website.slug', $this->theme);
                Configure::write('website.logo',Router::url('/theme/tablesavvy/images/TS_email_logo2.png',true));
            }
            if((isset($this->params['prefix']) && ($this->params['prefix']=='admin' || $this->params['prefix']=='super'))||($this->params['controller']=='admin'))
                $this->theme = 'tablesavvy';
            //Configure::write('website.name', Configure::read('website.id'));
            //Configure::write('website.slug', 'tablesavvy');
            //Configure::write('website.id', Configure::read('website.id'));
            if($this->params['controller'] != 'profile')
                $this->Session->write('reservation','set');
            $read_session = $this->Session->read('reservation');
            if($read_session == 'unset'){
                $this->Session->write('reservation','set');
                $this->redirect('/chicagomag');
            }

            Configure::write('website.city_id', 1);
            Configure::write('website.fbId','258393347647827');
            Configure::write('website.fb_secret_key','16d61153021c11b61c89d92db939dda0');
            //Configure::write('website.logo',Router::url('/images/logo.png',true));
            Configure::write('website.facebook','http://www.facebook.com/TableSavvy');
            Configure::write('website.twitter','http://twitter.com/#!/TableSavvy');
            Configure::write('Applink','https://itunes.apple.com/us/app/tablesavvy/id845047265?ls=1&mt=8');
        }
    }
	//function __construct(){}
	function beforeFilter(){
                // set theme for different sub domain
		$this->_setTheme();
		App::import('Vendor', 'facebook/src/facebook');
		/*$this->facebook = new Facebook(array(
		  'appId'  => '	281661408582189',
		  'secret' => 'a661a91191a1c7f99359a9e09221f56d',
		));*/
		$user_profile = $this->Auth->user('id');
		$this->loadmodel('User');
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id =' => $user_profile
			) ,
			'fields' => array(
				'User.new_user',
				'User.account_type'
			),
            'recursive'=>-1
		));


		if(($user['User']['new_user']==2||($user['User']['new_user']==3&&$this->params['action']!='profile'))&&$this->params['action']!='logout'&&$this->params['action']!='update'){
			if($user['User']['new_user']!=2){
				$this->redirect(array(
						'controller' => 'profiles',
						'action' => 'profile',
						'admin' => false,
						'?'=>'update'
				));
			}elseif($this->params['action']!='profile_change_password'){
				$this->redirect(array(
						'controller' => 'users',
						'action' => 'profile_change_password',
						'admin' => false
				));
			}
		}
		$this->facebook = new Facebook(array(
		  'appId'  => Configure::read('website.fbId'),
		  'secret' =>  Configure::read('website.fb_secret_key'),
		));
		$this->set('facebookObj', $this->facebook);
		$url=$this->params['url']['url'];
		if(!empty($this->params['url']['party'])&&!empty($this->params['url']['rest_id'])&&!empty($this->params['url']['time'])){
			$url=$url.'?party='.$this->params['url']['party'].'&rest_id='.$this->params['url']['rest_id'].'&time='.$this->params['url']['time'].'&ampm='.$this->params['url']['ampm'];
		}
		$this->set('fb_login_url',$this->facebook->getLoginUrl((array(
						'redirect_uri' => Router::url(array(
							'controller' => 'users',
							'action' => 'register',
							'admin' => false
						) , true),

					   'scope' => 'email,user_education_history,user_birthday'
					))));
		if($this->facebook->getUser()){
			$this->set('fb_logout_url',$this->facebook->getLogoutUrl(array('next'=>Router::url(array(
							'controller' => 'users',
							'action' => 'face_logout',
							'admin' => false
						) ,true),'access_token' => $this->facebook->getAccessToken())));
		}
		$this->set('meta_for_layout', Configure::read('meta'));
		$this->log('Js vars');
        $this->js_vars['cfg']['icm'] = 0;
        $this->js_vars['cfg']['path_relative'] = Router::url('/');
        $this->js_vars['cfg']['path_absolute'] = Router::url('/', true);
        $this->js_vars['cfg']['date_format'] = 'M d, Y';
        $this->js_vars['cfg']['today_date'] = date('Y-m-d');
        $this->js_vars['cfg']['site_name'] = strtolower(Inflector::slug(Configure::read('site.name')));

		Configure::write('site.name', 'TableSavvy');
		Configure::write('EmailTemplate.from_email', 'support@tablesavvy.com');
		Configure::write('EmailTemplate.reply_to_email', 'info@tablesavvy.com');

        $this->pageTitle = 'TableSavvy';

		Configure::write('user.using_to_login', 'email');
		$this->_checkAuth();
		$this->set('check_res', $this->check_user_reservation());
		parent::beforeFilter();
	}
	function _checkAuth(){
		Configure::write('user.using_to_login', 'email');
		Configure::write('user.approved', 'approved');
		$this->Auth->fields = array(
		 	'username' =>  Configure::read('user.using_to_login'),
			'password' => 'password',
			'approved'=>   Configure::read('user.approved')
		);
	 	$exception_array = array(
	 	     'users_new/login',
	 	     'users_new/referenceTransaction',
	 	     'users_new/test',
			'users/register',
			'users/login',
			'users/admin_login',
			'users/forget_password',
			'users/forgot_password',
			'users/admin_forget_password',
			'users/profile_change_password',
			'users/subscribe',
			'users/subscribe_new',
			'contacts/contactus',
			'admin/index',
			'users/admin_changepassword',
			'homes/index',
      'homes/hoteltonight',
      'homes/alreadyreserved',
			'homes/search',
			'homes/howitworks',
			'homes/select_search',
			'homes/contact',
			'homes/help',
			'homes/terms',
			'homes/all_restaurant',
			'homes/privacypolicy',
			'homes/returnpolicy',
			'homes/reservation',
			'homes/auto_complete',
                        'homes/specialoffer',
			'subscriptions/index',
			'homes/login',
      'homes/appredirect',
      'homes/restaurantdetails',
			'homes/details',
			'chicago/homes/details',
			'chicago/users/login',
			'chicago/widgets/time',
			'chicago/users/register',
			'chicago/homes/index',
			'chicago/homes/search',
			'chicago/homes/howitworks',
			'chicago/homes/select',
			'chicago/homes/contact',
			'chicago/contacts/add',
			'chicago/homes/help',
			'chicago/homes/terms',
			'chicago/homes/privacypolicy',
			'chicago/homes/returnpolicy',
			'chicago/homes/reservation',
			'chicago/homes/auto_complete',
			'chicago/homes/account',
			'chicago/homes/expired',
			'chicago/users/forget',
			'chicago/users/forgot',
			'chicago/homes/faq',
			'restraunts/super_addrestraunt',
			'restraunts/super_newrestraunt',
			'alerts/alert_response',
			'alerts/alert_mail',
			'alerts/clear_offerdate',
			'alerts/subscribe_email',
			'alerts/setPushNotification',
			'widgets/time_list',
                        'widgets/widgetsload',
                        'widgets/changelogdate',
			'widgets/time_chicago',
			'homes/faq',
			'homes/receipt',
			'homes/expired',
			'subscriptions/blog_sub',
			'homes/getsize',
			'profiles/share',
			'profiles/ifbyphone',
			'homes/auto_com_red',
			'widgets/time_widget',
			'profiles/error_log1'
		);
		$page=explode('_',$this->params['action']);
		if(!isset($page[1]))
			$page[1]='';
		$cur_page = $this->params['controller'] . '/' . $this->params['action'];
		$chicago_page = $page[0] . '/' . $this->params['controller']. '/' . $page[1];
		//exit;
		if (!in_array($cur_page, $exception_array)&&!in_array($chicago_page, $exception_array)) {
			 if (!$this->Auth->user('id')) {
			 	//$this->Session->setFlash('Authorization Required');
			 	  $cookie_hash = $this->Cookie->read('User.cookie_hash');
				  if (!empty($cookie_hash)) {
                    if (is_integer($this->cookieTerm) || is_numeric($this->cookieTerm)) {
                        $expires = time() +intval($this->cookieTerm);
                    } else {
                        $expires = strtotime($this->cookieTerm, time());
                    }
                    App::import('Model', 'User');
                    $user_model_obj = new User();
                    $this->data = $user_model_obj->find('first', array(
                        'conditions' => array(
                            'User.cookievalue =' => md5($cookie_hash['cookie_hash']),
                        ) ,
                        'fields' => array(
                            'User.email' ,
                            'User.password'
                        ) ,
                        'recursive' => -1
                    ));
                    // auto login if cookie is present
                    if ($this->Auth->login($this->data)) {
						if($this->Auth->user('account_type')==3){
							$this->redirect('/homes');
						}else if($this->Auth->user('account_type')==2) {
							$this->redirect(array(
								'controller' => 'table',
								'action' => 'index',
								'admin' => true
							));
						}else{
							$this->redirect(array(
								'controller' => 'restaurants',
								'action' => 'index',
								'super' => true,
								'admin' => false
							));

                    	}
                	}
                	}
				$is_admin = false;
				if($page[0]=='chicago')
                	$this->redirect('/chicago/widgets/time');
				else
					$this->redirect('/homes/login');
			 } else {
				$account_type = $this->Auth->user('account_type');
				if(($account_type == 1)&&(isset($this->params['prefix'])&&$this->params['prefix']!='super')){
					$this->Auth->logout();
					$this->redirect('/admin');
				} else if(($account_type == 2)&&(isset($this->params['prefix'])&&$this->params['prefix']!='admin')){
					$this->Auth->logout();
					$this->redirect('/admin');
				} else if(($account_type == 3)&&($cur_page=='users/logout')){
					if($this->facebook->getUser()){
						$this->set('fb_logout_url',$this->facebook->getLogoutUrl(array('next'=>Router::url(array(
										'controller' => 'users',
										'action' => 'face_logout',
										'admin' => false
									) ,true),'access_token' => $this->facebook->getAccessToken())));
					}
					$this->Cookie->delete('User');
					$this->Auth->logout();
          $this->redirect('/home');
					// if($this->params['prefix'] == 'chicago')
					// 	$this->redirect('chicago/widgets/time');
					// else
					// 	$this->redirect('/home');
				}
			 }
		}else {
            $this->Auth->allow('*');
			$account_type = $this->Auth->user('account_type');
			if($account_type == 2 && ($cur_page!='users/profile_change_password') && (($cur_page!='widgets/time_list')) && (($cur_page!='homes/details')) && (($cur_page!='homes/reservation')) && (($cur_page!='widgets/time_list')) && (($cur_page!='homes/index')) && (($chicago_page!='chicago/widgets/time'))){
					$this->Auth->logout();
					$this->redirect('/admin/table/index');
			}
        }
        $this->Auth->autoRedirect = false;

        if (isset($this->Auth)) {
            $this->Auth->loginError = sprintf('Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', Configure::read('user.using_to_login'));
        }
        $this->layout = 'default';
        if ((isset($this->params['prefix']) and $this->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }

	 }
	 function get_restaurant_id(){
	 	$userid = $this->Auth->user('id');
		if(empty($userid))
			return false;
		App::import('Model','Restaurant');
		$restaurant = new Restaurant();
		$restaurantdetails=$restaurant->findByuser_id($userid);
		if(!empty($restaurantdetails['Restaurant']['id']))
			return $restaurantdetails['Restaurant']['id'];
		else
			return false;

	 }
         function get_res_id(){
		$this->loadmodel('Restaurant');
		$userid=$this->Auth->user('id');
                $restdetail=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.user_id'=>$userid),'fields'=>'id','recursive'=>-1));
		return $restdetail['Restaurant']['id'];
	}
	 function generateRandomString ($length = 8, $possible = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		// initialize variables
		$password = "";
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length) {
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
	function check_user_reservation() {
		$user_id = $this->Auth->user('id');
		if(!empty($user_id)){
			$date=date('Y-m-d');
			$order='Offer.offerTime';
			$condtion['Reservation.userId'] = $user_id;
			$condtion['Reservation.approved'] = 1;
			$condtion['Offer.offerDate >='] = $date;
			$condtion['Offer.offerTime >=']=date('H:i:s');
			$this->loadmodel('Reservation');
			$profile_reservation= $this->Reservation->find('all',array(
				'conditions'=>$condtion,
				'contain'=>array(
					'Offer'=>array('Restaurant')
				 ),
				'order'=>$order,
				'recursive'=>2

			));
			return($profile_reservation);
		}
	}
}
