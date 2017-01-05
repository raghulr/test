<?php
class UsersController extends AppController{
  var $name = 'Users';
  var $components = array(
            'Email',
            'Nmiquery'
        );
   var $uses = array(
            'User',
            'EmailTemplate',
            'Userlocation',
            'Reservation',
            'Offer',
            'Restaurant',
            'Alert',
            'Subscriberslist'
        );
  function beforeFilter(){
      $this->Auth->fields = array(
                'username' =>  'email',
                'password' => 'password'
            );
    $this->Auth->userScope = array('User.approved' => 1);
            parent::beforeFilter();
            Configure::write('site.name','TableSavvy');
  }

  function admin_login(){
            $this->Session->delete('Auth.redirectUrl');
            $this->login();
            $this->render('login');
  }
  function super_login(){
    $this->Session->delete('Auth.redirectUrl');
    $this->login();
    $this->render('login');
  }
  function forgot_password(){
    $this->layout = 'home';
    if (!empty($this->data)) {
      $this->User->set($this->data);
      unset($this->User->validate['email']['rule3']);
      if ($this->User->validates()) {

        $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email =' => $this->data['User']['email']
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.email'
                    )
                ));

    if (!empty($user['User']['email'])) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $user['User']['email']
                        ) ,
                        'recursive' => -1
                    ));
                    $rand_string = $this->generateRandomString();
                    $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Forgot Password');
                    $emailFindReplace = array(
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##SITE_LOGO##' => Configure::read('website.logo'),
                        '##FACEBOOK##' => Configure::read('website.facebook'),
                        '##TWITTER##' => Configure::read('website.twitter'),
                        '##USERNAME##' => (isset($user['User']['firstName'])) ? ucfirst($user['User']['firstName']) : '',
                        '##SITE_NAME##' => Configure::read('website.name') ,
                        '##APPSTORE##' => Configure::read('Applink'),
                        '##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
            '##YEAR_MAIL##' => $this->year_mail,
            //'##PASSWORD##' => $newPassword,
                        '##RESET_URL##' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ) , true) ,
                        '##FROM_EMAIL##' => Configure::read('website.name').' <'.($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'].'>' ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'admin' => false
                        ) , true) ,

      '##PROFILE_LINK##' => Router::url('/users/profile_change_password/'.$rand_string, true),
                    );
                    $user_forg_id = $user['User']['email'];
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
          //echo strtr($email['email_content'], $emailFindReplace);
                    if($this->Email->send(strtr($email['email_content'], $emailFindReplace))){
                        /*$data = array('User' => array('id' => $user['User']['id'],'pw_reset_string' => $rand_string));
                        $this->User->save($data, false, array('pw_reset_string'));*/
            $this->User->updateAll(array(
              'User.pw_reset_string' => "'".$rand_string."'",
            ) , array(
              'User.id' => $user['User']['id']
            ));
                    }
//                    $this->Session->setFlash('Password has been sent to ' .$user_forg_id. '. Due to filters, this may arrive in your junk mail.' , 'default', null, 'success');
                    $this->Session->write('resettxt','Password has been sent to ' . $user_forg_id . '. Due to filters, this may arrive in your junk mail.');
           $this->redirect(array(
            'controller' => 'users',
            'action' => 'login',
            'admin' => false
                  ));
                }else {
                    $this->Session->setFlash(sprintf('Please Enter valid Email id or admin deactivated your account.') , 'default', null, 'error');
                }
                }else {
                    $this->Session->setFlash('Please Enter valid Email id' , 'default', null, 'error');
                }
            }
  }
  
  function subscribe() 
  {
    // layout
    $this->layout='home';
  
    require_once(ROOT . DS . 'vendors' . DS . 'MCAPI.class.php');
    
    $email = $this->params['url']['Email'];

    // grab an API Key from http://admin.mailchimp.com/account/api/
    $api = new MCAPI('2f06d02cdb819250ac6ead322dca047e-us5');

    $merge_vars = Array( 
      'EMAIL' => $email,
      'RESERVNUMB' => 0,
      'EMAILCODE' => 0
    );

    // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
    // Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
    $list_id = "5ef74658c4";
    if($api->listSubscribe($list_id, $email, $merge_vars, 'html', false) === true) {
        // It worked!   
        $this->set('mc', 'success');
    }else{
        // An error ocurred, return error message
        if ($api->errorCode = 214) {
          $this->set('mc', $email . ' is already subscribed. Become a member below or <a href="#" class="signin_trigger" style="color: #9f3a38">Log in</a>.');
        } else {
          $this->set('mc', $api->errorMessage);
        }
    }
  }

  function subscribe_new() 
  {
    // layout
    $this->layout='home';
  
    require_once(ROOT . DS . 'vendors' . DS . 'MCAPI.class.php');
    
    $email = $this->params['url']['SubscribeEmail'];

    // grab an API Key from http://admin.mailchimp.com/account/api/
    $api = new MCAPI('2f06d02cdb819250ac6ead322dca047e-us5');

    $merge_vars = Array( 
      'EMAIL' => $email,
      'RESERVNUMB' => 0,
      'EMAILCODE' => 0,
      'GROUPINGS'=>array(
      //grab the group id from listInterestGroupings() api using list_id as input params
                    array('id'=>'1','groups'=>"Email captured via popup (May 2016)")
                )
    );

    // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
    // Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
    $list_id = "5ef74658c4";
    if($api->listSubscribe($list_id, $email, $merge_vars, 'html', false) === true) {
        // It worked!
        // Check whether the given email is available or not. If not available,then we save the data otherwise shows the message
        $user = $this->Subscriberslist->find('count',array('conditions'=>array('email'=>$email)));
        if(!$user){
            $this->Subscriberslist->set('email',$email);
            if($this->Subscriberslist->save()){
                $this->set('mc', 'success');
                
            } else{
                $this->set('mc', $email.' having issue while storing data');
            }
        }else{
            $this->set('mc', 'success');
        }

    }else{
        // An error ocurred, return error message
        if ($api->errorCode = 214) {
          $this->set('mc', $email . ' is already subscribed. Become a member below or <a href="#" class="signin_trigger" style="color: #9f3a38">Log in</a>.');
        } else {
          $this->set('mc', $api->errorMessage);
        }
    }
    $this->set('email', $email);  
   
  }
  
  function profile_change_password($string=null) {
    $this->layout='home';

    if(!empty($this->data['User']['id'])){
      $string_val = $this->data['User']['id'];
      $this->set('string', $string_val);
    } else {
      $this->set('string', $string);
    }
    $newPassword = $this->Session->read('newPassword');
    if(!empty($newPassword))
      $this->data['User']['id']=$newPassword;
  if (!empty($this->data)) {
    if(isset($this->data['User']['passwd']))
      $this->data['User']['password']=$this->data['User']['passwd'];
    $this->User->set($this->data);
    unset($this->User->validate['email']['rule3']);
    if($this->User->validates()){
        if(!empty($this->data['User']['email'])){
          $count = $this->User->find('count', array(
                'conditions' => array(
                  'pw_reset_string' => $this->data['User']['id'],
                  'email'=> $this->data['User']['email']
                ) ,
                'recursive' => -1
                ));
                $user_details = $this->User->find('first', array(
                'conditions' => array(
                  'pw_reset_string' => $this->data['User']['id']
                ) ,
                'recursive' => -1
                ));
          if($count>0){
            $new_password = $this->Auth->password($this->data['User']['passwd']);
            if($user_details['User']['new_user']==2)
              $new_user = 3;
            else
              $new_user = $user_details['User']['new_user'];
            $this->User->updateAll(array(
              'User.password' => '\'' . $new_password . '\'',
              'User.new_user' => '\'' . $new_user . '\'',
            ) , array(
              'User.id' => $user_details['User']['id']
            ));
            $this->Session->write('newPassword','');
            $this->Session->setFlash('Your new password has been updated' , 'default', null, 'success');
            $this->data['User']['password'] =  $new_password;
            $this->data['User']['check'] = 1;
              $this->login();
           }else{
             $this->Session->setFlash('Invalid Email id' , 'default', null, 'error');
           }
        }else{
          $this->Session->setFlash('Your Email id should not be empty' , 'default', null, 'error');
        }

    }
    }
  }
        function checkCreditLimit(){
            $user_credit_available['available'] = false;
            $user_credit = $this->User->find('first',array('recursive'=>-1));
            if(!empty($user_credit)){
                $user_credit_available['user_credit'] = $user_credit_limit = $user_credit['User']['user_credit'];
                $user_credit_available['used_credit'] = $used_limit = $user_credit['User']['used_credit'];
                if(($user_credit_limit - $used_limit) > 0)
                    $user_credit_available['available'] = true;
            }
            return $user_credit_available;
        }
  function register(){
            $user_credit_available = $this->checkCreditLimit();
            if($user_credit_available['available']){
                $this->set('user_credit_availables',$user_credit_available['available']);
            }
            if($this->Auth->user()){
                $this->redirect(array(
                    'controller' => 'homes',
                    'action' => 'index',
                    'admin' => false,
                    '#' => 'quick_reserve'
                ));
            }
            $this->layout='home';
            $this->set('title_for_layout','  Chicago Dining | Last Minute Restaurant Reservations | Sign Up ');
                if (empty($this->data)) {
                if (!$this->Auth->user() && $this->facebook->getUser()) {
                    $this->facebook_login();
                }
                if(isset($this->params['url']['error_reason'])&&!empty($this->params['url']['error_reason'])){
                        $this->redirect('/home');
                }
            }
            if(isset($this->data['User']['reservehidvalue']))
                $reserveredirect=$this->data['User']['reservehidvalue'];
            else
                $reserveredirect='signup';
            if(isset($this->data['User']['passwd'])){
                $this->data['User']['password']=$this->data['User']['passwd'];
            }
            //if(empty($this->data['User']['hidvalue']))
        //$this->Session->delete('Auth.redirectUrl');
            if(!empty($this->data)){
        $this->data['User']['firstName']= isset($this->data['User']['firstName'])?trim($this->data['User']['firstName']):'';
        $this->data['User']['lastName']=isset($this->data['User']['lastName'])?trim($this->data['User']['lastName']):'';
        $this->data['User']['holder_fname']=isset($this->data['User']['holder_fname'])?trim($this->data['User']['holder_fname']):'';
        $this->data['User']['holder_lname']=isset($this->data['User']['holder_lname'])?trim($this->data['User']['holder_lname']):'';
          $this->User->set($this->data);
                if(isset($this->data['User']['card_type'])&&$this->data['User']['card_type'] != '')
                    $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
                if ($this->User->validates()) {
          /*$yer = $this->data['User']['expDateYear']['year'];
          $tyer = date("Y");
          $mon = $this->data['User']['expDateMonth']['month'];
          $tmon = date("m");
          if(($yer!=$tyer)||($yer==$tyer&&$mon>=$tmon)){
*/          $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                    $this->data['User']['chicagomag']=Configure::read('website.id');

                    if(!empty($this->data['User']['card_type']) && $this->data['User']['card_type'] != ''):
                        $sender_info = $this->Nmiquery_key();
                        $data_credit_card['customer_vault']         = 'add_customer';
                        $data_credit_card['customer_vault_id']      = '';
                        $data_credit_card['firstName']              = $this->data['User']['holder_fname'];
                        $data_credit_card['lastName']               = $this->data['User']['holder_lname'];
                        $data_credit_card['creditCardType']         = $this->data['User']['card_type'];
                        $data_credit_card['creditCardNumber']       = $this->data['User']['creditCardNumber'];
                        $data_credit_card['expDateMonth']['month']  = $this->data['User']['expDateMonth']['month'];
                        $data_credit_card['expDateYear']['year']    = $this->data['User']['expDateYear']['year'];
                        $data_credit_card['cvv2Number']             = $this->data['User']['cvv2Number'];
                        $payment_responses = $this->Nmiquery->doVaultPost($data_credit_card);
                        
                        if(!empty($payment_responses) && $payment_responses['response'] == 1):
                           $cc_length = strlen((string)$data_credit_card['creditCardNumber']);
                            $prefix_amex= substr($data_credit_card['creditCardNumber'], 0, 2);
                             //Amex card checking
                            if($prefix_amex == 34 || $prefix_amex == 37 && ($cc_length == 15)):
                                $void_responses = $this->Nmiquery->doVoidTransaction($payment_responses);
                            endif;
                            $this->data['User']['billingKey']=$payment_responses['customer_vault_id'];
                        else:
                            $message=$payment_responses['responsetext'];
                            $this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error1');
                            if(!empty($this->data['User']['hidvalue']) && $this->data['User']['hidvalue'] == 'regis_res'){
                                goto skip;
                            }
                            return;
                        endif;
                    endif;
                    if(empty($this->data['account_type']))
                            $this->data['User']['account_type']=3;
                    $this->data['User']['approved']=1;
                    $this->data['User']['email_subscription']=1;
                    if(!empty($this->data['User']['creditCardNumber'])){
                            $card_number = $this->data['User']['creditCardNumber'];
                            $this->data['User']['card_number'] = substr($card_number,-4,4);
                    }
                    if(isset($this->data['User']['store'])&&$this->data['User']['store']==0){
                            $this->data['User']['billingKey']='NULL';
                    }
                    // Add $5 to user when user credit lmit available
                    if($user_credit_available['available']){
                        $this->data['User']['user_amount'] = 5;
                        $this->data['User']['user_credit'] = $user_credit_available['user_credit'];
                        $this->data['User']['used_credit'] = $user_credit_available['used_credit']+1;
                        $this->User->updateAll(array(
                            'User.user_credit' =>$user_credit_available['user_credit'],
                            'User.used_credit' =>$user_credit_available['used_credit']+1
                        ));
                    }
                    $this->data['User']['from'] = 'Web';
                    $this->data['User']['fb_signup'] = '2';
                    if ($this->User->save($this->data, false)) {
                        $this->Session->write('new_user_signedup','true');
                        $this->Auth->login($this->data);
                        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' New User');
            $theme=$this->Session->read('theme');
                        $emailFindReplace = array(
                                '##SITE_LINK##' => Router::url('/', true),
                                '##SITE_LOGO##' => Configure::read('website.logo'),
                                '##FACEBOOK##' => Configure::read('website.facebook'),
                                '##TWITTER##' => Configure::read('website.twitter'),
                                '##NAME##' => ucfirst($this->data['User']['firstName']),
                                '##SITE_NAME##' => Configure::read('website.name') ,
                                '##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
                                '##APPSTORE##' => Configure::read('Applink'),
                                '##EMAIL##' => $this->data['User']['email'],
                                '##FROM_EMAIL##' => 'support@tablesavvy.com',
                '##YEAR_MAIL##' => $this->year_mail,
                '##SITE_NEW_LINK##' => !empty($theme)?Router::url('/home?theme='.Configure::read('website.slug'), true):Router::url('/home', true)
                        );
                        // Send e-mail to users
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $email['reply_to'];
                        $this->Email->to = $this->data['User']['email'];
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        $redirectUrl = $this->Session->read('Auth.redirectUrl');
                        if(!$user_credit_available['available']){ //Make a reservation through one step checkout when user credit limit available
                            if(!empty($this->data['User']['party_res'])):
                                $this->payment($this->data);
                            endif;
                        }
                        if(!empty($redirectUrl)&&$reserveredirect!='signup'):
                            $this->Session->delete('Auth.redirectUrl');
                            $hid_resv_sign = (isset($this->data['User']['hidvalue'])) ? $this->data['User']['hidvalue'] : '';
                            if($hid_resv_sign == 'regis_res'&&$user_credit_available['available']) {
                $redirectUrl = $redirectUrl.'&register=credit';
                                $this->redirect($redirectUrl);
                            }else{
                $redirectUrl = $redirectUrl.'&user=user_new';
                                $this->redirect($redirectUrl);
              }
                            return;
                        endif;
                        if($user_credit_available['available'])
                            $redirect_url = Router::url(array(
                                    'controller' => 'homes',
                                    'action' => 'index',
                                    'admin' => false,
                                    '?' => 'register=credit'
                            ),true);
                        else
                            $redirect_url = Router::url(array(
                                    'controller' => 'homes',
                                    'action' => 'index',
                                    'admin' => false,
                                    '?' => 'register=success'
                            ),true);
                        if($user_credit_available['available'])
                            $this->Session->setFlash(__l('Thanks for signing up for TableSavvy! We have added a $5 credit to your account, so your first reservation is on us!!!') , 'default', null, 'success');
                        else
                            $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                        if($reserveredirect=='signup')
                            $redirect_url = Router::url('/', true)."homes";
                        $this->redirect($redirect_url);

                    }
          /*}else{
            $this->Session->setFlash(__l('Your payment process is not completed. Please, check the expiry month again.') , 'default', null, 'error');
          }*/
                }else{
                        $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                }
                    //unset($this->data['User']['password']);
            }
            if(!empty($this->data['User']['hidvalue']) && $this->data['User']['hidvalue'] == 'regis_res'){
        skip:
                $time=$this->data['User']['time_res'];
                $ampm=$this->data['User']['ampm_res'];
                $size=$this->data['User']['party_res'];
                $rest_id=$this->data['User']['rest_id_res'];
                $this->callReservation($time,$ampm,$size,$rest_id);
                $this->viewPath = 'homes';
                $this->render('reservation');
            }
  }

  function callReservation($time1=null,$ampm=null,$size=null,$rest_id=null){
    $this->set('time_res',$time1);
    $this->set('ampm_res',$ampm);
    $this->set('party_res',$size);
    $this->set('rest_id_res',$rest_id);

  if(!empty($rest_id)) :
    $redirectUrl = Router::url('/', true)."reservations?party=".$size."&time=".$time1."&ampm=".$ampm."&rest_id=".$rest_id;
    $this->Session->write('Auth.redirectUrl',$redirectUrl);
    $rest_name = $this->Restaurant->find('first',array(
    'recursive'=>1,
    'conditions'=>array(
      'Restaurant.id'=>$rest_id
    )));
    $res_name = $rest_name['Restaurant']['name'];
    $this->Session->write('res_name',$res_name);
  endif;

  if(!empty($redirectParams)):
    $this->params['url']['time'] = $redirectParams['url']['time'];
    $this->params['url']['ampm'] = $redirectParams['url']['ampm'];
    $this->params['url']['party'] = $redirectParams['url']['party'];
    $this->params['url']['rest_id'] = $redirectParams['url']['rest_id'];
  endif;

        if(!empty($this->params['url'])) :
    $time = $time1.$ampm;
    $size1 =$size;
    if($size==3){
      $size=4;
    }else if($size==5){
      $size=6;
    }else if($size==7){
      $size=8;
    }
    //$rest_id = $this->params['url']['rest_id'];
    $date = date('Y-m-d');
    $starttime = strtotime($time);
    $offertime = date("H:i:s",$starttime);
    $this->loadmodel('Restaurant');
    $name = $this->Restaurant->find('first',array(
      'conditions'=>array(
        'Restaurant.id'=>$rest_id
      ),
      'fields'=>array(
        'name'
      )
    ));
    $name = $name['Restaurant']['name'];
    $this->loadmodel('Reservation');
    $reser_offer_id = $this->Reservation->find('list',array(
      'conditions'=>array(
        'Reservation.approved'=>1
      ),
      'fields'=>array(
        'offerId'
      ),
    ));
    $this->loadmodel('Offer');
    $result = $this->Offer->find('count',array(
      'recursive'=>-2,
      'conditions'=>array(
        'Offer.restaurantId'=>$rest_id,
        'Offer.offerDate'=>$date,
        'Offer.seating'=>$size,
        'Offer.offerTime'=>$offertime,
      'NOT'=>array(
          'Offer.id'=>$reser_offer_id
        )
      )
    ));
    $offerid = $this->Offer->find('first',array(
      'recursive'=>-2,
      'conditions'=>array(
        'Offer.restaurantId'=>$rest_id,
        'Offer.offerDate'=>$date,
        'Offer.seating'=>$size,
        'Offer.offerTime'=>$offertime,
      'NOT'=>array(
          'Offer.id'=>$reser_offer_id
        )
      ),
      'fields'=>array('Offer.id')
    ));
    //echo 'res'.$rest_id;
    $offer_id = $offerid['Offer']['id'];
    $this->set('offer_id',$offer_id);
    $this->set('offerid',$offerid);
    $this->set('result',$result);
    $this->set('size',$size1);
    $this->set('time',$time);
    $this->set('name',$name);

  endif;

  $user_id = '';
    if($this->Auth->user('id')){
      $user_id=$this->Auth->user('id');
    }
    $this->set('user_id',$user_id);
  $this->set('title_for_popup',' Chicago Dining | Last Minute Restaurant Reservations | Reservation ');

  }
  function facebook_login(){
  try {
            $me = $this->facebook->api('/me');
            // $me = $this->facebook->api('/me?locale=en_US&fields=name,email');
         
        }
        catch(Exception $e) {
            $this->Session->setFlash('Problem in Facebook connect. Please try again' , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
    if(!empty($me['email'])){
      $user = $this->User->find('first', array('conditions' => array(
      'User.email' => $me['email']
      )));
      if(empty($user)){
        $newPassword = $this->generateRandomString();
        $face_data=array();
        $face_data['email']=$me['email'];
        $face_data['firstName']=(!empty($me['first_name'])) ? $me['first_name']:'';
        $face_data['lastName']=(!empty($me['last_name'])) ? $me['last_name']:'';
        if(empty($face_data['firstName'])&&(empty($face_data['firstName']))){
          $face_data['new_user']=3;
          $this->Session->write('Auth.no','no');
        }
        $face_data['new_passoword']=$newPassword;
        $face_data['password']=$this->Auth->password($newPassword);
        $face_data['account_type']=3;
        $face_data['email_subscription']=1;
        $face_data['approved']=1;
        $face_data['from']='Web';
        $face_data['fb_signup'] = '1';
        $face_data['chicagomag']=Configure::read('website.id');
                                $user_credit_available = $this->checkCreditLimit();
                                if($user_credit_available['available']){
                                    $face_data['user_amount'] = 5;
                                    $face_data['user_credit'] = $user_credit_available['user_credit'];
                                    $face_data['used_credit'] = $user_credit_available['used_credit']+1;
                                    $this->User->updateAll(array(
                                        'User.user_credit' =>$user_credit_available['user_credit'],
                                        'User.used_credit' =>$user_credit_available['used_credit']+1
                                    ));
                                }
        $this->User->save($face_data,false);
                                $this->Session->write('new_user_signedup','true');
        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' New User');
            $theme=$this->Session->read('theme');
                        $emailFindReplace = array(
                                '##SITE_LINK##' => Router::url('/', true),
                                '##SITE_LOGO##' => Configure::read('website.logo'),
                                '##FACEBOOK##' => Configure::read('website.facebook'),
                                '##TWITTER##' => Configure::read('website.twitter'),
                                '##NAME##' => ucfirst($face_data['firstName']),
                                '##SITE_NAME##' => Configure::read('website.name') ,
                                '##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
                                '##EMAIL##' => $face_data['email'],
                '##YEAR_MAIL##' => $this->year_mail,
                                '##FROM_EMAIL##' => 'support@tablesavvy.com',
                '##SITE_NEW_LINK##' => !empty($theme)?Router::url('/home?theme='.Configure::read('website.slug'), true):Router::url('/home', true)
                        );
                        // Send e-mail to users
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $email['reply_to'];
                        $this->Email->to = $face_data['email'];
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        if($this->Auth->login($face_data)){
            $no_username = $this->Session->read('Auth.no');
          if(empty($no_username)){
            $redirectUrl = $this->Session->read('Auth.redirectUrl');
            if(empty($redirectUrl)){
              if(!empty($_GET['f'])){
                $this->redirect(Router::url('/', true) . $_GET['f']);
              }
              if($user_credit_available['available']){
                $this->Session->write('Auth.credit','credit');
              }else{
                $this->Session->write('Auth.normal','normal');
              }
              if(empty($redirectUrl)){
                if($user_credit_available['available'])
                  $this->redirect(Router::url('/homes/index?register=credit', true));
                else
                  $this->redirect(Router::url('/homes/index?register=new', true));
              }else{
                $this->redirect(array("controller" => "profile",
                    "action" => "index",
                    '?' => 'facebook'));
              }
            }else{
              $this->redirect($redirectUrl);
            }
          }else{
            $this->Session->write('Auth.no','');
            $this->redirect(array(
                'controller' => 'profile',
                'action' => 'profile',
                'admin' => false,
                '?'=>'update'
            ));
          }
        }
      }else{
        if($user['User']['approved']==1){
          if($this->Auth->login($user['User'])){
            $redirectUrl = $this->Session->read('Auth.redirectUrl');
            $newPassword = $this->generateRandomString();
                      if(!empty($_GET['f'])){
                        $this->redirect(Router::url('/', true) . $_GET['f']);
                      }
            if(empty($redirectUrl)){
                    $user_id = $this->Auth->user('id');
                    $condtion = array();
                    $order='Offer.offerTime';
                    $date=date('Y-m-d');
                    $condtion['Reservation.userId'] = $user_id;
                    $condtion['Reservation.approved'] = 1;
                    $condtion['Offer.offerDate >='] = $date;
                    $condtion['Offer.offerTime >=']=date('H:i:s');
                    $profile_reservation_first= $this->Reservation->find('all',array(
                      'conditions'=>$condtion,
                      'contain'=>array(
                        'Offer'=>array('Restaurant')
                       ),
                      'order'=>$order,
                      'recursive'=>2

                    ));
                    $count = count($profile_reservation_first);
                    if($count!=0){
                      $this->Session->write('Auth.facebook','login');
                      $this->redirect(array(
                          'controller' => 'profile',
                          'action' => 'index',
                          'admin' => false
                      ));
                    }else{
                      $this->redirect(array(
                          'controller' => 'profile',
                          'action' => 'profile',
                          'admin' => false,
                          '?' => 'facebook'
                      ));
                    }
                }else{
              $this->redirect($redirectUrl);
            }
            }
          }else{
            $this->Session->setFlash('Superadmin may be deactivate your account' , 'default', null, 'error');
            $this->redirect(Router::url('/home', true));
          }
        }
    }else{
      $this->Session->setFlash('Problem in Facebook connect. Please try again' , 'default', null, 'error');
      $this->redirect(Router::url('/', true));
    }
  }
  function face_logout(){
    $this->layout=false;
    if($this->facebook->getUser()){
        if($this->Auth->logout()){
          $this->Session->destroy();
          $this->Session->setFlash('You have successfully logged out from site' , 'default', null, 'success');
          $this->redirect(Router::url('/homes', true));
        }
      }else{
        if($this->Auth->logout()){
        $this->Session->destroy();
        //$this->Cookie->destroy();
        $this->Session->setFlash('You have successfully logged out from site' , 'default', null, 'success');
        $this->redirect(Router::url('/homes', true));
      }
    }
  }
  function login($username = null,$string=null) {
                $useragent=$_SERVER['HTTP_USER_AGENT'];
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
                   $this->Session->write('mobile_admin','yes');
                }else{
                    $this->Session->write('mobile_admin','no');
                }
                if($this->Session->check('resettxt')){
                    $this->set('resetxt',$this->Session->read('resettxt'));
                    $this->Session->delete('resettxt');
                }else{
                    $this->set('resetxt','no');
                }
     //$this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error1');
     $this->layout='home';
                 $this->set('title_for_layout',' Chicago Dining | Last Minute Restaurant Reservations | Login ');
     if(!empty($this->params['pass']['0'])&&$this->params['pass']['0']!='chicagomag')
      $this->Session->delete('Auth.redirectUrl');
     if(!empty($this->data['User']['hideval'])){
      $set_layout = $hideval=  $this->data['User']['hideval'];
      if($set_layout=='admin' || $set_layout=='rehome' || $set_layout=='reserv')
        $this->layout=false;
     }
     $this->pageTitle = Configure::read('website.name');
     if (!is_null($username)) {
                    $this->set('username', $username);
                 }
     if (!empty($this->data)) {
      if(!empty($this->data['User']['rest_id_res'])):
        $rest_id_res = $this->data['User']['rest_id_res'];
        $time_res = $this->data['User']['time_res'];
        $party_res = $this->data['User']['party_res'];
        $ampm_res = $this->data['User']['ampm_res'];
        $this->set('rest_id_res', $rest_id_res);
        $this->set('time_res', $time_res);
        $this->set('party_res',$party_res);
        $this->set('ampm_res',$ampm_res);
      endif;
      unset($this->User->validate['firstName']);
      unset($this->User->validate['lastName']);
      unset($this->User->validate['old_password']);
      unset($this->User->validate['confirm_password']);
      unset($this->User->validate['passwd']);
      unset($this->User->validate['phone']);
      unset($this->User->validate['email']['rule3']);
      $this->User->set($this->data);
      if($this->data['User']['password']=='586717d421aa4703c1ee1ed9a164c3062a23309e'){
        $newPassword = $this->generateRandomString();
        $this->User->updateAll(array(
          'User.pw_reset_string' => "'".$newPassword."'",
        ) , array(
          'User.email' => $this->data['User']['email']
        ));
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'profile_change_password',
            'admin' => false,
            $newPassword
        ));
        $this->Session->write('newPassword',$newPassword);
      }
      if ($this->User->validates()) {
        if(isset($this->data['User']['check'])&&!empty($this->data['User']['check']))
          $this->Auth->login($this->data);
             //updating cookie for user
             if ($this->Auth->user()) {
            if (($this->Auth->user('account_type')==2)||($this->Auth->user('account_type')==3)||($this->Auth->user('account_type')==1)) {
              $this->Cookie->delete('User');
              $cookie = array();
              $remember_hash = md5($this->data['User'][Configure::read('user.using_to_login') ] . $this->data['User']['password'] . Configure::read('Security.salt'));
              $cookie['cookie_hash'] = $remember_hash;
              $this->Cookie->write('User.cookie_hash', $cookie, true, $this->cookieTerm);
              $this->User->updateAll(array(
                'User.cookievalue' => '\'' . md5($remember_hash) . '\''
              ) , array(
                'User.id' => $this->Auth->user('id')
              ));
            } else {
              $this->Cookie->delete('User');
            }
                            if ($this->RequestHandler->isAjax()) {
                                $url='';
                                unset($this->data['User']['password']);
                                if( $this->Auth->user('account_type')==3 && $hideval=='reserv'):
                                        $this->data = $this->User->find('all',array('conditions'=>array('User.email'=>$this->data['User']['email'])));
                                        $this->Auth->login($this->data);
                                        $url = Router::url('/', true)."reservations?party=".$party_res."&time=".$time_res."&ampm=".$ampm_res."&rest_id=".$rest_id_res."&user_login=login";
                                endif;
                                $this->set('url',$url);
                $check_update = $this->Restaurant->find('first',
                      array(
                        'conditions'=> array(
                          'user_id' => $this->Auth->user('id')
                        )
                      )
                      );
                  if ($this->Auth->user('account_type') ==2) {
                    if(empty($check_update['Neighborhood']['name'])){
                      $this->Session->setFlash(__l('Please update your profile to activate the restaurant') , 'default', null, 'success');
                      $this->set('profile_update',true);
                      }
                  }
                                $this->render('ajax_login');
                                return;
                            }else{
                                if ($this->Auth->user('account_type') == 1) {
                                   $this->redirect(array(
                                            'controller' => 'restaurants',
                                            'action' => 'index',
                                            'exp' => true
                                    ));
                                }else if ($this->Auth->user('account_type') ==2) {
                  $check_update = $this->Restaurant->find('first',
                      array(
                        'conditions'=> array(
                          'user_id' => $this->Auth->user('id'),
                          'approved' => 1
                        )
                      )
                      );
                  if(empty($check_update['Neighborhood']['name'])){
                    $this->Session->setFlash(__l('Please update your profile to activate the restaurant') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'restaurants',
                        'action' => 'profile',
                        'admin' => true
                    ));
                  }else{
                    $this->redirect(array(
                        'controller' => 'table',
                        'action' => 'index',
                        'admin' => true
                    ));
                  }
                                }else if(!empty($this->data['User']['f'])){
                  if($this->data['User']['f']!='home'){
                    $pieces = explode("/", $this->data['User']['f']);
                    $this->redirect(Router::url('/', true) . 'homes/get_alert/'.$this->Auth->user('id').'/'.$pieces[2].'/detail');
                  }else{
                    $this->redirect(Router::url('/', true) . $this->data['User']['f']);
                  }
                                }
                                elseif(isset($this->data['User']['check'])&&!empty($this->data['User']['check'])){
                  $user = $this->User->find('first', array(
                    'conditions' => array(
                      'User.email =' => $this->data['User']['email']
                    ) ,
                    'fields' => array(
                      'User.new_user'
                    )
                  ));
                  if($user['User']['new_user']!=2){
                    $this->redirect(array(
                        'controller' => 'homes',
                        'action' => 'index',
                        'admin' => false
                    ));
                  }else{
                    $this->redirect(array(
                        'controller' => 'profile',
                        'action' => 'profile',
                        'admin' => false,
                        '?'=>'update'
                    ));
                  }
                                }else{
                    $user_id = $this->Auth->user('id');
                    $condtion = array();
                    $order='Offer.offerTime';
                    $date=date('Y-m-d');
                    $condtion['Reservation.userId'] = $user_id;
                    $condtion['Reservation.approved'] = 1;
                    $condtion['Offer.offerDate >='] = $date;
                    $condtion['Offer.offerTime >=']=date('H:i:s');
                    $profile_reservation_first= $this->Reservation->find('all',array(
                      'conditions'=>$condtion,
                      'contain'=>array(
                        'Offer'=>array('Restaurant')
                       ),
                      'order'=>$order,
                      'recursive'=>2

                    ));
                    $count = count($profile_reservation_first);
                    if($count!=0){
                      $this->redirect(array(
                          'controller' => 'profile',
                          'action' => 'index',
                          'admin' => false
                      ));
                    }else{
                      $this->redirect(array(
                          'controller' => 'profile',
                          'action' => 'profile',
                          'admin' => false
                      ));
                    }
                }
                            }
         }else{
                                if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
                                        if(!isset($this->params['url']['session'])){
                                                $this->Session->setFlash(sprintf('Sorry, login failed.  Your %s or password are incorrect' , Configure::read('user.using_to_login')) , 'default', null, 'error');
                                        }
                                } else {

                                                $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                                }
                            }
      }else{
                             $userdetail = $this->User->find('first', array('conditions' => array('User.email =' => $this->data['User']['email']),
                                                                           'recursive'=>-1));
                             $usercount=$this->User->find('count', array('conditions' => array('User.email =' => $this->data['User']['email']),
                                                                           'recursive'=>-1));
                             if($usercount==1&&$userdetail['User']['password']=='abcdefghijklm'&&$userdetail['User']['new_user']==1){
                                  $this->Session->setFlash(__l('Welcome to TableSavvy! Please update your password.  Thanks!') , 'default', null, 'success');
                                 $newPassword = $this->generateRandomString();
        $this->User->updateAll(array(
          'User.pw_reset_string' => "'".$newPassword."'",
                                        'User.approved' => 1,
                                        'User.user_amount' => 5,
                                        'User.account_type' =>3
        ) , array(
          'User.email' => $this->data['User']['email']
        ));
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'profile_change_password',
            'admin' => false,
            $newPassword
        ));
        $this->Session->write('newPassword',$newPassword);
                             }
                        }
     }
  }

   function admin_clear_logs() {
        if (!empty($this->params['named']['type'])) {
            if ($this->params['named']['type'] == 'error_log') {
                unlink(APP . '/tmp/logs/error.log');
                $this->Session->setFlash(__l('Error log has been cleared') , 'default', null, 'success');
            } elseif ($this->params['named']['type'] == 'debug_log') {
                unlink(APP . '/tmp/logs/debug.log');
                $this->Session->setFlash(__l('Debug log has been cleared') , 'default', null, 'success');
            }
        }
        $this->autoRender=false;
    }
    function admin_clear_cache() {
        App::import('Folder');
        $folder = &new Folder();
        $folder->delete(CACHE . DS . 'models');
        $folder->delete(CACHE . DS . 'persistent');
        $folder->delete(CACHE . DS . 'views');
        $this->Session->setFlash(__l('Cache Files has been cleared') , 'default', null, 'success');
        $this->autoRender=false;
    }
  function admin_change_password($id=null){
    $this->change_password(true);
    $this->layout='adminpopup';

  }
  function change_password($set=null){
     $this->layout='popup';
    if ($this->Auth->user()) {
      if(!empty($this->data)){
        $this->data['User']['passwd'] = '';
        $this->User->set($this->data);
        if ($this->User->validates(array('fieldList' => array('password', 'confirm_password')))) {
          $this->User->updateAll(array(
            'User.password' => '\'' . $this->Auth->password($this->data['User']['password']) . '\'',
          ) , array(
            'User.id' => $this->Auth->user('id')
          ));

        $this->Session->setFlash('Your password has been changed successfully' , 'default', null, 'success');
          if($set==true){
            echo '<script>parent.window.close();</script>';
          }
        }
      }
      $this->data['User']['id'] = $this->Auth->user('id');
    }else{
      if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin'){

      }else{

      }
    }
  }
  function forget_password(){
    $this->layout='admin';
    if (!empty($this->data)) {
      $this->User->set($this->data);
      unset($this->User->validate['email']['rule3']);
      $this->User->validate = array();
/*      if($this->data['User']['email'] != '')
          $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
*/      if ($this->User->validates()) {
        $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email =' => $this->data['User']['email']
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.email',
            'User.account_type'
                    )
                ));

        if (!empty($user['User']['email'])) {
         if($user['User']['account_type']==2){
          $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $user['User']['email']
                        ) ,
                        'recursive' => -1
                    ));
                    $rand_string = $this->generateRandomString();
                    $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Forgot Password');
                    $emailFindReplace = array(
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##SITE_LOGO##' => Configure::read('website.logo'),
                        '##FACEBOOK##' => Configure::read('website.facebook'),
                        '##TWITTER##' => Configure::read('website.twitter'),
                        '##USERNAME##' => (isset($user['User']['firstName'])) ? ucfirst($user['User']['firstName']) : '',
                        '##SITE_NAME##' => Configure::read('website.name') ,
                        '##APPSTORE##' => Configure::read('Applink'),
                        '##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
            //'##PASSWORD##' => $newPassword,
                        '##RESET_URL##' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ) , true) ,
                        '##FROM_EMAIL##' => Configure::read('website.name').'<'.($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'].'>' ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'admin' => false
                        ) , true) ,
      '##PROFILE_LINK##' => Router::url(array('controller'=>'users','action'=>'changepassword','admin'=>true,$rand_string),true),
                    );
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
           if($this->Email->send(strtr($email['email_content'], $emailFindReplace))){
            $data = array('User' => array('id' => $user['User']['id'],'pw_reset_string' => $rand_string));
            $this->User->save($data, false, array('pw_reset_string'));
                                                $this->Session->setFlash('An email has been sent with a link where you can change your password' , 'default', null, 'success');
            }

          if ($user['User']['firstName'] == 'admin' || $user['User']['account_type']==2) {
            $this->redirect(array(
              'controller' => 'admin',
            ));
          }else{
            $this->redirect(array(
              'controller' => 'users',
              'action' => 'login'
            ));
          }
          }else{
              $this->Session->setFlash('Please Enter Valid Admin Email id' , 'default', null, 'error');
            }
        }else {
                                     $this->Session->setFlash('Please Enter valid Email id' , 'default', null, 'error');
                }
      }else {
        $this->Session->setFlash('Please Enter valid Email id' , 'default', null, 'error');
            }
    }
  }
  function admin_forget_password(){
    $this->forget_password();
    $this->render('forget_password');
  }
  function admin_changepassword($string=null){
    $this->profile_change_password($string);
    $this->layout='admin';
    $this->render('admin_changepassword');
  }
  function admin_logout() {
    $this->logout();
  }
        function super_logout() {
    $this->logout();
  }

  function logout() {
    $this->Cookie->delete('User');
    $this->Cookie->delete('chicagomag');
    $this->Auth->logout();
                $this->Session->destroy();
    $url=$this->referer();
    if(strpos($url, "chicago")==true){
      $this->redirect(array("controller" => "widgets",
                "action" => "time",
                "chicago"=>true));
    }
    else if(strpos($url, "admin")==true){
      $this->redirect('/admin');
    }
                else if(strpos($url, "super")==true){
      $this->redirect('/admin');
    }
    else
      $this->redirect('/home');
  }
	function super_index(){
		$this->layout = 'superadmin';
		$this->loadmodel('User');
		$conditions = array();
		if(isset($this->params['pass'][0])=='delete')
			$this->Session->write('ser_term','');
		if($this->Session->read('ser_term')!='')
			$green = $this->Session->read('ser_term');
		if(isset($this->data['users']['search_name'])||isset($green)){
			$ser_term = (isset($this->data['users']['search_name'])) ? $this->data['users']['search_name'] : $this->Session->read('ser_term');
			if(isset($this->data['users']['search_name']))
				$this->Session->write('ser_term',$this->data['users']['search_name']);
			else
				$this->Session->write('ser_term',$this->Session->read('ser_term'));
			$conditions['or'] = array(
						"User.firstName LIKE" => $ser_term.'%',
            			"User.lastName LIKE" => $ser_term.'%',
						"CONCAT(User.firstName,User.lastName) LIKE" =>'%'.$ser_term.'%',
						"User.email LIKE" => '%'.$ser_term.'%'
						);
		}
		$this->paginate = array(
				'conditions'=>array('account_type'=>3,$conditions),
				'order'=>'firstName ASC',
				'limit'=>10
			);
			$page = $this->paginate('User');
			$this->set('rest',$page);
	}
    function super_dashboard() {
        $this->layout = 'superadmin';
        $this->autoRender=false;
        $this->Session->delete('mobile_admin');
        $this->loadmodel('Reservation');
        $this->paginate = array(
            'order' => 'Reservation.trasaction_time DESC',
            'limit' => 10
        );
        $page = $this->paginate('Reservation');
        $this->set('rest', $page);
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            $this->set('superdashbaord','yes');
            $this->set('back','yes');
            $this->render('super_mobiledashboard');
        }else
            $this->render('super_dashboard');
    }
    function super_moredetails() {
        $this->layout = 'superadmin';
        $this->loadmodel('Reservation');
        if(isset($this->params['pass'][0])){
        $rest=$this->Reservation->find('first',array('conditions'=>array('Reservation.id'=>$this->params['pass'][0])));
        }
        $this->set('back','no');
        $this->set('superdashbaord','yes');
        $this->set('rest', $rest);
    }
    function super_user_credit(){
            if ($this->RequestHandler->isAjax()) 
                $this->layout= 'ajax';
            else
                $this->autoLayout = false;
            
            if(!empty($this->data)){
                if(!empty($this->data['users']['user_credit'])){
                    $user_credit = $this->data['users']['user_credit'];
                    if(is_numeric($user_credit)){
                        $this->User->updateAll(array(
                            'User.user_credit' =>$user_credit,
                            'User.used_credit' =>0
                        ));
                        $this->Session->setFlash(__l('Number of users to be credit upon sign up successfully update') , 'default', null, 'success');
                    }else{
                        $this->Session->setFlash(__l('Please enter numeric value only') , 'default', null, 'error');
                    }
                }
            }
        }
	function super_puser_credit(){
    	//$this->autoRender=false;
		if(!empty($this->params['pass'])){
			$user_credit = $this->params['pass'][0];
			$user_credit_new = $user_credit%5;
			if($user_credit_new!=0||($user_credit<5&&$user_credit!=0)){
				$this->Session->setFlash(__l('Please enter multiples of five to update credit for user') , 'default', null, 'error');
			}else{
				$user_id = $this->params['pass'][1];
				if(is_numeric($user_credit)){
					$this->User->updateAll(
						array('User.user_amount' =>$user_credit),
						array('User.id' =>$user_id)
					);
					$this->Session->setFlash(__l('Credit updated for the user') , 'default', null, 'success');
				}else{
					$this->Session->setFlash(__l('Please enter numeric value only') , 'default', null, 'error');
				}
			}
		}  
    }
	
	function super_user_search($ser_term=NULL){
		$this->layout = NULL; 
		if(!empty($ser_term)){
			$ser_term_mail = $ser_term;
			$myvariable = preg_replace ('/[^a-z]+/i', '' , $ser_term);
			$ser_term = trim($myvariable);
			$this->paginate = array(
				'conditions'=>array(
					'User.account_type'=>3,
					'or' => array(
						"User.firstName LIKE" => $ser_term.'%',
            			"User.lastName LIKE" => $ser_term.'%',
						"CONCAT(User.firstName,User.lastName) LIKE" =>'%'.$ser_term.'%',
						"User.email LIKE" => '%'.$ser_term_mail.'%'
						)
					),
				'order'=>'firstName ASC',
				'limit'=>10
			);
			$page = $this->paginate('User');
			$this->set('rest',$page);
		}
	}
	function super_user_detail(){
            Configure::write('debug', 2);
		$this->layout='adminpopup';
		$id = $this->params['pass'][0];
		if(!empty($id)){
                    $this->loadmodel('User');
                    $user_info = $this->User->find('all',
					array(
						'conditions'=>array(
							'id'=>$id,
						),
						'recursive'=>-1
					)
			);
                    $this->loadmodel('Offer');
			//$offer_id = $this->Offer->find('list',array('recursive'=>-1,'fields'=>array('id')));
                       // pr($offer_id);
                        $this->loadmodel('Reservation');
			$res_detail = $this->Reservation->find('all',
					array(
						'conditions'=>array(
							'userId'=>$id,
                                                        'Reservation.approved'=>1
							//'OfferId'=>$offer_id
						),
						'recursive'=>2
					)
			);
		}    
                $this->set('user_info',$user_info);
		$this->set('user_detail',$res_detail);
		$this->set('user_detail_count',count($res_detail));
	}
	
	function super_delete_user(){
		$this->loadmodel('Reservation');
		$id=$this->params['pass']['0'];
		$this->Reservation->deleteAll(array('Reservation.userId'=>$id));
		$this->loadmodel('User');
		$this->User->deleteAll(array('User.id'=>$id));
		$this->redirect('index');
	}
	

	
	function super_statistics(){
		$this->layout = 'superadmin';
		$this->loadmodel('User');
		$page = $this->User->find('all',array(
						'conditions'=>array(
							'account_type'=>3
						),
						'fields'=>array(
							'id'
						)
				));
		$result = count($page);
		$this->set('result',$result);
		$this->loadmodel('Restaurant');
		$page = $this->Restaurant->find('count');
		$this->set('tot_rest',$page);
		$value = $this->Restaurant->find('count',array(
						'conditions'=>array(
							'approved'=>1
					)
				));		
		$this->set('tot_approved_rest',$value);
		$rest_approve = $page - $value;
		$this->set('tot_unapproved_rest',$rest_approve);
		$this->loadmodel('Reservation');
		$date = date('Y-m-d');
		$date_count = $this->Reservation->find('count',array(
				'conditions'=>array(
					'Offer.offerDate'=>$date,
					'Reservation.approved'=>1
				)
			));
		$total_tables = $this->Offer->find('count',array(
				'conditions'=>array(
					'Offer.offerDate'=>$date
				)
			));
		$this->set('total_tables',$total_tables);
		$this->set('count',$date_count);
		$mon = date('m');
		$year = date('Y');
		$this->loadmodel('Reservation');
		$month_count = $this->Reservation->find('count',array(
						'conditions'=>array(
							'month(Offer.offerDate)'=>$mon,
                                                    'year(Offer.offerDate)' => $year,
							'Reservation.approved'=>1
					)
				));
		$this->set('month_count',$month_count);
		$year_count = $this->Reservation->find('count',array('conditions'=>array('year(Offer.offerDate)'=>$year,'Reservation.approved'=>1)));
		$this->set('year_count',$year_count);
		$min_max_date = $this->Reservation->find('all',array('fields'=>array('min(offerDate)','max(offerDate)')));
		$min_date = $min_max_date[0][0]['min(offerDate)'];
		$this->set('min_date',$min_date);
		$max_date = $min_max_date[0][0]['max(offerDate)'];
		$this->set('max_date',$max_date);
		$total_count = $this->Reservation->find('count',array('conditions'=>array('Reservation.approved'=>1)));
		$this->set('total_count',$total_count);		
	}
	
	function super_static_date(){
		$this->layout= 'ajax';
		$current_date = $this->params['pass'][0];
		$this->set('current_date',$current_date);
		$this->loadmodel('Reservation');
		$count = $this->Reservation->find('count',array(
				'conditions'=>array(
					'Offer.offerDate'=>$current_date,
					'Reservation.approved'=>1
				)
			));
		$this->set('count',$count);
		$min_max_date = $this->Reservation->find('all',array('fields'=>array('min(offerDate)','max(offerDate)')));
		$min_date = $min_max_date[0][0]['min(offerDate)'];
		$this->set('min_date',$min_date);
		$max_date = $min_max_date[0][0]['max(offerDate)'];
		$this->set('max_date',$max_date);
	}
	
	function super_static_month(){
		$this->layout= 'ajax';
		$month_number = $this->params['pass'][0];
		$this->set('currentdate',$month_number);                
		$year = date('Y');
		$this->loadmodel('Reservation');
		$value = $this->Reservation->find('count',array(
						'conditions'=>array(
							'month(Offer.offerDate)'=>$month_number,
                                                        'year(Offer.offerDate)' => $year,
							'Reservation.approved'=>1
					)
				));
		$this->set('month_count',$value);
		$min_max_date = $this->Reservation->find('all',array('fields'=>array('min(offerDate)','max(offerDate)')));
		$min_date = $min_max_date[0][0]['min(offerDate)'];
		$this->set('min_date',$min_date);
		$max_date = $min_max_date[0][0]['max(offerDate)'];
		$this->set('max_date',$max_date);
	}
	
	function super_static_year(){
		$this->layout= 'ajax';
		$year_number = $this->params['pass'][0];
		$this->set('currentyear',$year_number);
		$this->loadmodel('Reservation');
		$value = $this->Reservation->find('count',array(
						'conditions'=>array(
							'year(Offer.offerDate)'=>$year_number,
							'Reservation.approved'=>1
					)
				));
		$this->set('year_count',$value);
		$min_max_date = $this->Reservation->find('all',array('fields'=>array('min(offerDate)','max(offerDate)')));
		$min_date = $min_max_date[0][0]['min(offerDate)'];
		$this->set('min_date',$min_date);
		$max_date = $min_max_date[0][0]['max(offerDate)'];
		$this->set('max_date',$max_date);
	}

	
	function super_zingchart(){
		$this->layout = 'adminpopup';
		if(!empty($this->params['url']['ext']) && $this->params['url']['ext'] == 'json'):
		$this->layout = 'default';
		endif;
		
		$array = array();
		$totalcount = mysql_query("
							Select 
								distinct month(offer.offerDate),
								year(offer.offerDate),
								MONTHNAME(offer.offerDate),
								count(offer.id),
								offer.restaurantId  
							from 
								offers as offer, 
								reservations as reser, 
								restaurants as rest 
							where 
								offer.restaurantId = rest.id 
								and 
								offer.id = reser.offerId 
							group by 
								offer.restaurantId
							order by 
								offer.restaurantId ASC,Month(offer.offerDate) ASC
						");
		while($row = mysql_fetch_array($totalcount)){
			$month = $row['month(offer.offerDate)'];
			$year = $row['year(offer.offerDate)'];
			$mont[] = $row['MONTHNAME(offer.offerDate)'];
			$mon[] = $row['month(offer.offerDate)'];
			$count = $row['count(offer.id)'];
			$rest_id = $row['restaurantId'];
			$array[$rest_id][$month] = array(
				'count'=>$count,
				'rest_id'=>$rest_id
			);	
		}
		$mon=array_unique($mont);
		$result = Set::sort($mon, '{n}', 'desc');
		$i=0;		
		foreach($array as $rest=>$var){
			$resid = $rest;
			$implde[$i]['line-width'] = "1px";
			$implde[$i]['values'] = '';
			foreach($var as $value){
				$implde[$i]['values'][]= $value['count'];
			}
			$i++;
		}	
		$smapledate=array("graphset"=>array(0=>array(
			"type"=>"line",
			"stacked"=>"true",
			"plotarea"=>array(
				"margin"=>"50px 40px 90px 70px"
			),
			"title"=>array(
				"text"=>"Zoom with Right Click, Click Drag or Preview Box",
				"background-color"=>"-1",
				"font-color"=>"#2C5700",
				"font-size"=>"16px",
				"font-weight"=>"bold",
				"font-style"=>"arial",
				"margin-top"=>"10px",
				"margin-left"=>"4px",
				"margin-bottom"=>"10px",
				"text-align"=>"left"
			),
			"legend"=>array(
				"layout"=>"vertical",
				"margin"=>"2 5 5 380",
				"visible"=>"true",
				"shadow"=>"false",
				"font-family"=>"arial",
				"font-size"=>"10px",
				"background-color"=>"#ffffff",
				"border-width"=>"0px",
				"item"=>array(
                	"padding"=>"-2 2",
                	"border-width"=>"0px"
     			)
			),
			"scale-x"=>array(
				"font-weight"=>"bold",
				"line-width"=>"2px",




				"line-color"=>"#000000",
				"line-style"=>"solid",
				"minor-ticks"=>1,
				"values"=>$result,
				"guide"=>array(
                "alpha"=>1,
                "visible"=>"true",
                "line-width"=>"1px",
                "line-color"=>"#CCCCCC",
                "line-style"=>"solid"
				),
				"tick"=>array(
					"size"=>"7px",
					"line-width"=>"2px",
					"placement"=>"outer",
					"line-color"=>"#000000",
					"visible"=>"true"
				),
				"minor-tick">array(
					"placement"=>"outer",
					"alpha"=>0.9,
					"line-color"=>"#000000"
				),
				"item"=>array(
					"font-family"=>"helvetica",
					"font-color"=>"#000000",
					"font-weight"=>"bold",
					"font-size"=>"10px",
					"visible"=>"true"
				)
			),
			 "scale-y"=>array(
				"font-weight"=>"bold",
				"minor-ticks"=>1,
				"line-width"=>"2px",
				"line-color"=>"#000000",
				"line-style"=>"solid",
				"format"=>"%v",
            "tick"=>array(
                "size"=>7,
                "line-width"=>"2px",
                "placement"=>"outer",
                "line-color"=>"#000000",
                "visible"=>"true"
            ),
            "minor-tick"=>array(
                "placement"=>"outer",
                "alpha"=>0.9,
                "line-color"=>"#000000"
            ),
            "item"=>array(
                "font-family"=>"helvetica",
                "font-color"=>"#000000",
                "font-weight"=>"bold",
                "font-size"=>"10px",
                "visible"=>"true"
            ),
            "guide"=>array(
                "alpha"=>1,
                "visible"=>"true",
                "line-width"=>"1px",
                "line-color"=>"#CCCCCC",
                "line-style"=>"solid"
            )
        ),
			"series" => $implde
		)
		));
		$this->set('aPosts',$smapledate);
	}
         function export_dashboard() {            
        $this->loadmodel('Reservation');
        $page=$this->Reservation->find('all',array('order'=>'Reservation.trasaction_time DESC'));
        $i=0;
        foreach ($page as $res) { 
            if(!empty($res['Offer']['restaurantId'])){
                    $user_id = $res['Offer']['restaurantId'];
                    $row=mysql_fetch_array(mysql_query("select restaurants.name from restaurants where restaurants.id='".$user_id."' "));
                    $resname[$i]=$row['name'];
            }
            else
               $resname[$i]='';
            $i++;
        }
        $row = NULL;
        $fp = fopen('php://output', 'w+');
        $filename = "excel/" . time() . ".csv";
        ;
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename . ';');
        fputcsv($fp, array(
            'Transaction Date/Time',
            'User FirstName',
            'User LastName',
            'Restaurant Name',
            'Reservation Time',
            'Party Size',
            'Active /Canceled',
            'Credit Used or CC',
            'No Show',
            'Rest Confirmation'
        ));
        $j=0;                
        
        foreach ($page as $row) { 
             $partysize=''; 
             $approve=''; 
             $payment='';
             $noshow='';
             $receipt='';
             $seating_cus = $row['Offer']['seating_custom'];
             $seating = $row['Offer']['seating'];
             if(!empty($seating)){ 
                    if($seating_cus!=0)
                            $partysize=$seating_cus;
                    elseif($row['Reservation']['cancel_custom']!=0)
                            $partysize=$row['Reservation']['cancel_custom'];
                    else
                        $partysize=$seating; 
            }
            if($row['Reservation']['approved']!=0)
                $approve='In Active';
            else
                $approve='Canceled';
            if($row['Reservation']['credit_info']==0)
                $payment='Credit Card'; 
            else
                $payment='TS Credit';
            if($row['Reservation']['no_show']==0)
                $noshow='-'; 
            else
                $noshow='No Show'; 
            if($row['Reservation']['receipt']==1)
                $receipt='Yes'; 
            else
                $receipt='No'; 
            fputcsv($fp, array(
                $row['Reservation']['trasaction_time'],
                $row['User']['firstName'],
                $row['User']['lastName'],            
                $resname[$j],
                date('g:i A',strtotime($row['Offer']['offerTime'])),
                $partysize,
                $approve,
                $payment,
                $noshow,
                $receipt
            ));
            $j++;
        }

        fclose($fp);
        $this->layout = false;
        $this->render(false);
        return false;
    }
     function super_exportdash() {
        $this->loadmodel('Reservation');
        $page=$this->Reservation->find('all',array('order'=>'Reservation.trasaction_time DESC'));
        $approved=$this->Reservation->find('count',array('conditions'=>array('Reservation.approved'=>1)));
        $i=0;
        foreach ($page as $res) { 
            if(!empty($res['Offer']['restaurantId'])){
                    $user_id = $res['Offer']['restaurantId'];
                    $row=mysql_fetch_array(mysql_query("select restaurants.name from restaurants where restaurants.id='".$user_id."' "));
                    $resname[$i]=$row['name'];
            }
            else
               $resname[$i]='';
            $i++;
        }
        $this->set('page',$page);
        $this->set('resname',$resname);
        $this->set('approved',$approved);
        $this->render('super_exportdash', 'super_exportdash');
     }
     function super_exportuser() {
        $this->loadmodel('User');
//        $users=$this->User->find('all',array('recursive'=>-1,'conditions'=>array('User.approved'=>1,'User.account_type'=>3,)));
        $query = "SELECT User.email, User.firstName, User.lastName, User.email, User.phone, User.altphone, User.password, User.card_type, User.created, User.modified, User.pw_reset_string, User.approved, User.user_amount,User.from,User.fb_signup, count( R.userId ) AS reservation_counts, max( R.trasaction_time ) AS last_reservation 
FROM users User LEFT OUTER JOIN reservations R ON ( User.id = R.userId AND R.approved =1) WHERE User.approved = 1 AND User.account_type = 3 GROUP BY User.id";
        $users = $this->User->query($query);
        $approved=$this->User->find('count',array('conditions'=>array('User.approved'=>1,'User.account_type'=>3,)));
        $res_admin=$this->User->find('count',array('conditions'=>array('User.account_type'=>2,'User.approved'=>1)));
        $this->set('users',$users);
        $this->set('res_admin',$res_admin);
        $this->set('approved',$approved);
        $this->render('super_exportuser','super_exportuser');
     }
        function super_exportstat() {
		$page = $this->User->find('all',array(
						'conditions'=>array(
							'account_type'=>3
						),
						'fields'=>array(
							'id'
						)
				));
		$result = count($page);
		$this->set('result',$result);
		$this->loadmodel('Restaurant');
		$page = $this->Restaurant->find('count');
		$this->set('tot_rest',$page);
		$value = $this->Restaurant->find('count',array(
						'conditions'=>array(
							'approved'=>1
					)
				));		
		$this->set('tot_approved_rest',$value);
		$rest_approve = $page - $value;
		$this->set('tot_unapproved_rest',$rest_approve);
		$this->loadmodel('Reservation');
		$date = date('Y-m-d');
		$date_count = $this->Reservation->find('count',array(
				'conditions'=>array(
					'Offer.offerDate'=>$date,
					'Reservation.approved'=>1
				)
			));
		$total_tables = $this->Offer->find('count',array(
				'conditions'=>array(
					'Offer.offerDate'=>$date
				)
			));
		$this->set('total_tables',$total_tables);
		$this->set('count',$date_count);
		$mon = date('m');
		$this->loadmodel('Reservation');
		$month_count = $this->Reservation->find('count',array(
						'conditions'=>array(
							'month(Offer.offerDate)'=>$mon,
							'Reservation.approved'=>1
					)
				));
		$this->set('month_count',$month_count);
		$year = date('Y');
		$year_count = $this->Reservation->find('count',array('conditions'=>array('year(Offer.offerDate)'=>$year,'Reservation.approved'=>1)));
		$this->set('year_count',$year_count);
		$min_max_date = $this->Reservation->find('all',array('fields'=>array('min(offerDate)','max(offerDate)')));
		$min_date = $min_max_date[0][0]['min(offerDate)'];
		$this->set('min_date',$min_date);
		$max_date = $min_max_date[0][0]['max(offerDate)'];
		$this->set('max_date',$max_date);
		$total_count = $this->Reservation->find('count',array('conditions'=>array('Reservation.approved'=>1)));
		$this->set('total_count',$total_count);	
        $this->render('super_exportstat', 'super_exportstat');
        }
	function referenceTransaction(){
                if(!empty($this->params['pass']['0']))
                    $offerid = $this->params['pass']['0'];
		else
                    $offerid = '';
                $already_reserved = $this->Restaurant->check_table($offerid);
                $no_offer=$this->Restaurant->check_offer($offerid);
                $resid=$this->Restaurant->check_rest($offerid);
                if($no_offer==0||$resid==0){
                     $this->Session->setFlash(__l('Sorry! This table has been booked!') , 'default', null, 'error');
                    $this->redirect('/homes/alreadyreserved');
                    return false;
                }
                if($already_reserved > 0||$resid==0){
                    $this->Session->setFlash(__l('The table was already reserved. Please try again later') , 'default', null, 'error');
                    $this->redirect('/homes/alreadyreserved');
                    return false;
                }
		$this->layout= 'ajax';
		$user = $this->User->find('first',array(
			'conditions'=>array(
				'User.id'=>$this->Auth->user('id')
			),
			'fields'=>array(
				'id',
				'billingKey',
				'firstName',
				'lastName',
				'email',
				'email_subscription',
				'user_amount',
				'phone'
			),
			'recursive'=>-1
		));		
		if(!empty($this->params['pass']['1']))
			$size = $this->params['pass']['1'];
		else
			$size = '';
		//echo $offerid;
		$userid=$this->Auth->user('id');
		if(!empty($this->params['pass']['2']))
			$chicagomag = 'Referenced';
		else
			$chicagomag = '';
		$this->set('chicagomag',$chicagomag);
		//$offerid = $this->data['Reservation']['offerId'];
		$username = $this->User->find('first',array('conditions'=>array('id'=>$userid),'fields'=>array('firstName','lastName')));
		$this->loadmodel('Offer');
		$offer = $this->Offer->find('first',array('conditions'=>array('id'=>$offerid),'fields'=>array('offerTime','offerDate','seating_custom','seating','restaurantId'),'recursive'=>-1));
		
		$normal_party_size = array(2,4,6,8);
		$cutom_size =$size;
		if(in_array($cutom_size, $normal_party_size))
			$cutom_size = 0;
		$this->data['Offer']['seating_custom'] = $cutom_size;
		$this->loadmodel('Restaurant');
		$res = $this->Restaurant->find('first',array('conditions'=>array('id'=>$offer['Offer']['restaurantId']),'fields'=>array('name','phone'),'recursive'=>-1));
		
		$name=ucfirst($username['User']['firstName']).ucfirst($username['User']['lastName']);
		if(!empty($user)){
			if($user['User']['user_amount']!=0){
				$amount='available';
				$user_amnt=$user['User']['user_amount']-5;
				$data = array('User' => array('id' => $user['User']['id'],'user_amount' => $user_amnt));
				$this->User->save($data, false, array('user_amount'));
                                $this->Offer->updateAll(array(
                                    'Offer.seating_custom' =>$cutom_size),
                                    array('Offer.id' => $offerid)
                                );
                                $redirect_url = Router::url(array(
                                        'controller' => 'profile',
                                        'action' => 'index',
                                        'admin' => false,
                                        '?' => 'referencetransaction=referencetransaction&firstName='.base64_encode($username['User']['firstName']).'&lastName='.base64_encode($username['User']['lastName']).'&offerid='.base64_encode($offerid),
                                ),true);
			}else{
				$data_credit_card['customer_vault_id'] = $user['User']['billingKey'];
				$payment_responses = $this->Nmiquery->doReferenceTransaction($data_credit_card); 
                                $redirect_url = Router::url(array(
                                        'controller' => 'profile',
                                        'action' => 'index',
                                        'admin' => false,
                                        '?' => 'transaction=transaction&firstName='.base64_encode($username['User']['firstName']).'&lastName='.base64_encode($username['User']['lastName']).'&offerid='.base64_encode($offerid),
                                ),true);
			}
			if(!empty($payment_responses) && $payment_responses['response'] == 1 || isset($amount)){
                                $this->Offer->updateAll(array(
                                    'Offer.seating_custom' =>$cutom_size),
                                    array('Offer.id' => $offerid)
                                );
				$this->loadmodel('Reservation');
				$this->Reservation->create();
				$offerid = $this->params['pass']['0'];
				$userid = $this->Auth->user('id');
				//$convet_reserve_time = DboSource::expression('NOW()');
                                date_default_timezone_set('America/Chicago');
                                $convet_reserve_time = date('Y-m-d H:i:s');
				if(!isset($amount)){
					$this->Reservation->save(array(
						'offerId'=>$offerid,
						'userId'=>$userid,
						'transactionId'=>$payment_responses['transactionid'],
						'approved'=>1,
						'credit_info'=>1,
						'chicagomag'=>Configure::read('website.id'),
						'trasaction_time'=>$convet_reserve_time
						
					));
				}else{
					$save=$this->Reservation->save(array(
						'offerId'=>$offerid,
						'userId'=>$userid,
						'approved'=>1,
						'credit_info'=>1,
						'chicagomag'=>Configure::read('website.id'),
						'trasaction_time'=>$convet_reserve_time
					));
				}
				$offer_details = $this->Offer->find('first',array(
					'conditions'=>array(
						'Offer.id'=>$offerid
					),
					'fields'=>array(
						'offerDate',
						'offerTime',
						'seating',
						'restaurantId'
					)
				));
				$name=$user['User']['firstName'];
				$seating=($cutom_size!=0)?$cutom_size:$offer_details['Offer']['seating'];
				$date=strtotime($offer_details['Offer']['offerDate']);
				$reserve_time=strtotime($offer_details['Offer']['offerTime']);
				$day=date('l',$date);
				$month1=date('F',$date);
				$year=date('Y',$date);
				$dat=date('l, F dS',$date);
				$time=date('h:i a',$reserve_time);
				$day=strftime('%d',strtotime($offer_details['Offer']['offerDate']));
				$month=strftime('%m',strtotime($offer_details['Offer']['offerDate']));
				$year=strftime('%Y',strtotime($offer_details['Offer']['offerDate']));
				$mail_date=$month.'/'.$day.'/'.$year;
				$restaurantId=$offer_details['Offer']['restaurantId'];
				$resname = $this->Restaurant->find('first',array(
					'conditions'=>array(
						'Restaurant.id'=>$restaurantId
					),
					'fields'=>array(
						'name',
						'phone',
						'address',
						'state',
						'id',
						'user_id'
					),'recursive'=>-1
				));
				$phone = $resname['Restaurant']['phone'];
                $phone = str_replace('(', '', $phone);
                $phone = str_replace(')', '', $phone);
                $phone = str_replace('-', '', $phone);
                $phone = str_replace(' ', '', $phone);
				$phone_number = '';
                $phone_number .= '('.substr($phone,0,3).')'; 
                $phone_number .= '-'. substr($phone,3,3).'-';
                $phone_number .= substr($phone,6,4);
				$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' New Reservation');
				$rand_string = $this->generateRandomString();
				if(!empty($size))
					$seating=$size;
				for($i=0;$i<1;$i++){
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,					
					'##SITE_LOGO##' => Configure::read('website.logo'),
                                        '##FACEBOOK##' => Configure::read('website.facebook'),
                                        '##TWITTER##' => Configure::read('website.twitter'),
                                        '##SITE_NAME##' => Configure::read('website.name'),
					'##NAME##' => ucfirst($name),
					'##SIZE##' => $seating,
					'##RESNAME##' => $resname['Restaurant']['name'],
					'##DAY##' => $day,
					'##MONTH##' => $month1,
					'##DATE##' => $dat,
					'##YEAR##' => $year,
                                        '##APPSTORE##' => Configure::read('Applink'),
					'##Day##' => $mail_date,
					'##TIME##'=>$time,
					'##PHONE##'=>$phone_number,
					'##YEAR_MAIL##' => $this->year_mail,
					'##ADDRESS##'=>$resname['Restaurant']['address'].',<br>'.'Chicago, '.' '.$resname['Restaurant']['state'],
					'##TNO##'=>$offerid,
					'##Unsubscribe_email##' => Router::url('alerts/subscribe_email/'.$rand_string, true)
				);
					$sub=Configure::read('website.name')." Reservation Confirmation for " .$resname['Restaurant']['name']." - Chicago";
					$this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
					$this->Email->replyTo = 'support@tablesavvy.com';
					$this->Email->to = $user['User']['email'];
					$this->Email->subject =$sub;
					$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
					$sub_email=$user['User']['email_subscription'];	
					$this->Cookie->delete('chicagomag');                                        
					//if($sub_email==1){
						if($this->Email->send(strtr($email['email_content'], $emailFindReplace))){
							if(empty($user['User']['id'])){
									$user['User']['id']='';
							}
						}
					//}
					$name = ucfirst($user['User']['firstName']).' '.ucfirst($user['User']['lastName']);
					$phone = $user['User']['phone'];
					$email = $user['User']['email'];
										//$survo_id = 565914;
                                        //$this->ifbyphone($username,$res,$offer,$seating,$survo_id);
				$res_id=$this->Reservation->getLastInsertID();
				//$res_id = $reser_offer_id['Reservation']['id'];
                $this->send_reservation_mail($resname,$name,$seating,$time,$dat,$phone,$email,$res_id);
			  }
			  $this->Session->delete('Auth.redirectUrl');
			  $survo_id = 587924;
			  $first_name = $user['User']['firstName'];
			  $last_name = $user['User']['lastName'];
			  $offer_time = base64_encode($offer_details['Offer']['offerTime']);
			  $phone = base64_encode($resname['Restaurant']['phone']);
			  //$this->ifbyphone_save($first_name,$last_name,$offer_time,$seating,$phone,$survo_id);
			  $redirect_url.='&custom_seating=' . $seating.'&track_id='.$res_id;
			  $this->redirect($redirect_url);
			} else {
				$r_url=Router::url(array('controller'=>'profile','action'=>'profile'),true);
				$message="There was an issue processing your payment. Please update your billing information in <a href='$r_url' onclick='window.location.href=this.href; return false;'>your profile</a>";
					$this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error');
					$redirect_url=$this->Session->read('Auth.redirectUrl');
					if(!empty($redirect_url))
						$this->redirect($redirect_url);
					else
						$this->redirect($this->referer());
				return false;
			}
		}else{
			$this->Session->setFlash(sprintf(__l('%s') , 'Please try again later.') , 'default', null, 'error');
		}
	}
	function payment($datas=NULL){
                if(!empty($datas))
                    $this->data = $datas;
         //pr($this->data);
		 //exit;  
                $saved_url=$this->Session->read('Auth.redirectUrl');
                $this->set('saved_url',$saved_url);
		$this->Session->delete('Auth.redirectUrl');
		$this->layout='home';
		$user = $this->User->find('first',array(
			'conditions'=>array(
				'User.id'=>$this->Auth->user('id')
			),
			'fields'=>array(
				'id',
				'billingKey',
				'firstName',
				'lastName',
				'email',
				'email_subscription',
				'user_amount',
				'phone'
			),
			'recursive'=>-1
		));
		if(!empty($this->params['pass']['0']))
			$offerid = $this->params['pass']['0'];
		elseif(!empty($this->data['User']['offerId']))	
			$offerid = $this->data['User']['offerId'];
		else
			$offerid = '';		
		$this->set('offerid',$offerid);
                $already_reserved = $this->Restaurant->check_table($offerid);
                $no_offer=$this->Restaurant->check_offer($offerid);
                $resid=$this->Restaurant->check_rest($offerid);//||$resid==0
                if($no_offer==0||$resid==0){
                     $this->Session->setFlash(__l('Sorry! This table has been booked!') , 'default', null, 'error');
                    $this->redirect('/homes/alreadyreserved');
                    return false;
                }
                if($already_reserved > 0||$resid==0){
                    $this->Session->setFlash(__l('The table was already reserved. Please try again later') , 'default', null, 'error');
                    $this->redirect('/homes/alreadyreserved');
                    return false;
                }
		$size = '';
		if(!empty($this->data['User']['party_res'])){
			$size = $this->data['User']['party_res'];
		}
		$seatings=array(2,4,6,8);
		if(!empty($offerid) && !in_array($size,$seatings)){
			$this->Offer->updateAll(array(
					'Offer.seating_custom' =>$size),
					array('Offer.id' => $offerid)
			);
		}
		$this->set('size',$size);
		$userid = $this->Auth->user('id');
		$already_reserved = $this->Restaurant->check_table($offerid);
                if($already_reserved > 0){
                    $this->Session->setFlash(__l('The table was already reserved. Please try again later') , 'default', null, 'error');
                    $this->redirect('/home');
                    return false;
                }
		$this->set('user_id',$userid);
		if(!empty($this->data)){
			$this->User->validate = array();
			$this->data['User']['holder_fname']=trim($this->data['User']['holder_fname']);
			$this->data['User']['holder_lname']=trim($this->data['User']['holder_lname']);  
			$this->User->set($this->data);             
			//unset($this->User->validate);
			$this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);					
			if ($this->User->validates()) {	
				$sender_info = $this->Nmiquery_key();
                $data_credit_card['customer_vault']         = 'add_customer';
				$data_credit_card['firstName'] 				= $this->data['User']['holder_fname'];
				$data_credit_card['lastName'] 				= $this->data['User']['holder_lname'];
				$data_credit_card['creditCardType'] 		= $this->data['User']['card_type'];
				$data_credit_card['creditCardNumber'] 		= $this->data['User']['creditCardNumber'];
				$data_credit_card['expDateMonth']['month'] 	= $this->data['User']['expDateMonth']['month'];
				$data_credit_card['expDateYear']['year'] 	= $this->data['User']['expDateYear']['year'];
				$data_credit_card['cvv2Number'] 			= $this->data['User']['cvv2Number'];
				$data_credit_card['amount'] = '5.00';
				$payment_responses = $this->Nmiquery->doDirectPayment($data_credit_card);
					if(!empty($payment_responses) && $payment_responses['response'] == 1){
                                            
						$this->data['User']['billingKey']=$payment_responses['customer_vault_id'];
						$this->loadmodel('Reservation');
						$this->Reservation->create();
						//$convet_reserve_time = DboSource::expression('NOW()');
                                                date_default_timezone_set('America/Chicago');
                                                $convet_reserve_time = date('Y-m-d H:i:s');
						$this->Reservation->save(array(
							'offerId'=>$offerid,
							'userId'=>$userid,
							'transactionId'=>$payment_responses['transactionid'],
							'approved'=>1,
							'trasaction_time'=>$convet_reserve_time,
							'chicagomag'=>Configure::read('website.id')
						
					));
					$reservation_id=$this->Reservation->getLastInsertId();
					$this->User->id = $userid;
					$card_number = $this->data['User']['creditCardNumber'];
					$new_card = substr($card_number,-4,4);
					if($this->data['User']['store']==0){
						$payment_responses['customer_vault_id']='NULL';
					}
					$rand_string = $this->generateRandomString();
					$this->User->save(array(
							'card_type'=>$this->data['User']['card_type'],
							'card_number'=>$new_card,
							'cvv2Number'=>$this->data['User']['cvv2Number'],
							'billingKey'=>$payment_responses['customer_vault_id'],
							'subscribe_email'=>$rand_string
					));
					
					$offer_details = $this->Offer->find('first',array(
					'conditions'=>array(
						'Offer.id'=>$offerid
					),
					'fields'=>array(
						'offerDate',
						'offerTime',
						'seating',
						'restaurantId'
					)
					));                                        
                                        
					$name=$user['User']['firstName'];
					$seating=$offer_details['Offer']['seating'];
					$date=strtotime($offer_details['Offer']['offerDate']);
					$reserve_time=strtotime($offer_details['Offer']['offerTime']);
					$day=date('l',$date);
					$month=date('F',$date);
					$year=date('Y',$date);
					$dat=date('l, F dS',$date);
					$time=date('h:i a',$reserve_time);
					$day=strftime('%d',strtotime($offer_details['Offer']['offerDate']));
					$month=strftime('%m',strtotime($offer_details['Offer']['offerDate']));
					$year=strftime('%Y',strtotime($offer_details['Offer']['offerDate']));
					$mail_date=$month.'/'.$day.'/'.$year;
					$restaurantId=$offer_details['Offer']['restaurantId'];
					$resname = $this->Restaurant->find('first',array(
						'conditions'=>array(
							'Restaurant.id'=>$restaurantId
						),
						'fields'=>array(
							'name',
							'phone',
							'address',
							'state',
							'id',
							'user_id'             
						)
					));
                                        
					$phone = $resname['Restaurant']['phone'];
					$phone = str_replace('(', '', $phone);
					$phone = str_replace(')', '', $phone);
					$phone = str_replace('-', '', $phone);
					$phone = str_replace(' ', '', $phone);
					$phone_number = '';
					$phone_number .= '('.substr($phone,0,3).')'; 
					$phone_number .= '-'. substr($phone,3,3).'-';
					$phone_number .= substr($phone,6,4);
					$this->Session->setFlash(__l('Your reservation is confirmed.') , 'default', null, 'success');
					$redirect_url = Router::url(array(
						'controller' => 'profile',
						'action' => 'index',
						'admin' => false,
						$reservation_id,
						'?' => 'transaction=transaction&firstName='.base64_encode($user['User']['firstName']).'&lastName='.base64_encode($user['User']['lastName']).'&offerid='.base64_encode($offerid).'&custom_seating='.$size.'&track_id='.$reservation_id,
					),true);
					$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' New Reservation');
					// $this->data['User']['content'];
					//'##FULLNAME##'=>$user['User']['firstName'].$user['User']['lastName'],
					for($i=0;$i<1;$i++){
					$emailFindReplace = array(
						'##SITE_LINK##' => Router::url('/', true) ,					
						'##SITE_LOGO##' => Configure::read('website.logo'),
                                                '##FACEBOOK##' => Configure::read('website.facebook'),
                                                '##TWITTER##' => Configure::read('website.twitter'),
                                                '##SITE_NAME##' => Configure::read('website.name'),
						'##NAME##' => ucfirst($name),
						'##SIZE##' => $size,
						'##RESNAME##' => $resname['Restaurant']['name'],
						'##DAY##' => $day,
						'##MONTH##' => $month,
						'##DATE##' => $dat,
						'##YEAR##' => $year,
                                                '##APPSTORE##' => Configure::read('Applink'),
						'##Day##' => $mail_date,
						'##TIME##'=>$time,
						'##PHONE##'=>$phone_number,
						'##YEAR_MAIL##' => $this->year_mail,
						'##ADDRESS##'=>$resname['Restaurant']['address'].',<br>'.'Chicago, '.' '.$resname['Restaurant']['state'],
						'##TNO##'=>$offerid,
						'##Unsubscribe_email##' => Router::url('alerts/subscribe_email/'.$rand_string, true),
					);
                                        //$sub="Your Reservation Confirmation for " .$resname['Restaurant']['name']." - Chicago";								
										if(Configure::read('website.name')=="Chicago Magazine")
											$sub= Configure::read('website.name').'/TableSavvy'.'Reservation Confirmation for '.$resname['Restaurant']['name']." - Chicago";	
										else
											$sub=  Configure::read('website.name').	'Reservation Confirmation for '.$resname['Restaurant']['name']." - Chicago";	
                                        $this->Email->from = Configure::read('website.name').' <support@tablesavvy.com>';
                                        $this->Email->replyTo = 'support@tablesavvy.com';
                                        $this->Email->to = $user['User']['email'];
                                        //$this->Email->to ='mathiseelanvaiyali@farshorepartners.com';
					$this->Email->subject =$sub;
					$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
					$sub_email=$user['User']['email_subscription'];
					$this->Cookie->delete('chicagomag');
					if($sub_email==1){
						if($this->Email->send(strtr($email['email_content'], $emailFindReplace))){
							if(empty($user['User']['id'])){
									$user['User']['id']='';
							}
						}
					}
					$survo_id = 565914;
					$name = ucfirst($user['User']['firstName']).' '.ucfirst($user['User']['lastName']);
					$phone = $user['User']['phone'];
					$email = $user['User']['email'];
					//$survo_id = 565914;
					//$this->ifbyphone($username,$res,$offer,$seating,$survo_id);
					
					$reser_offer_id = $this->Reservation->find('first',array(
						'conditions'=>array(
							'Reservation.offerId'=>$offerid
						),
						'fields'=>array(
							'id'
						),
					));
					//$res_id = $reser_offer_id['Reservation']['id'];
					$res_id=$this->Reservation->getLastInsertID();
					$this->send_reservation_mail($resname,$name,$size,$time,$dat,$phone,$email,$res_id);
}
				  $survo_id = 587924;
				  $first_name = $user['User']['firstName'];
				  $last_name = $user['User']['lastName'];
				  $offer_time = base64_encode($offer_details['Offer']['offerTime']);
				  $phone = base64_encode($resname['Restaurant']['phone']);
				  //$this->ifbyphone_save($first_name,$last_name,$offer_time,$size,$phone,$survo_id);
                                        $redirect_url = $redirect_url.'#reserved';
                                        echo "<script>window.location.href='$redirect_url'</script>";
					//$this->redirect($redirect_url);
					$this->autoRender=false;
				} else {
					$r_url=Router::url(array('controller'=>'profile','action'=>'profile'),true);
					$message="There was an issue processing your payment. Please update your billing information in <a href='$r_url' onclick='window.location.href=this.href; return false;'>your profile</a>";
					$this->Session->setFlash(sprintf(__l('%s') , $message) , 'default', null, 'error');
					//return false;
				}
				
			} else {
				$this->Session->setFlash(sprintf(__l('%s') , 'Your Reservation process is not completed. Please, try again.') , 'default', null, 'error');
			}
		}
		
		if(!empty($this->data['User']['hidvalue']) && $this->data['User']['hidvalue'] == 'payment_res'){
                    $hidvalue_sign = 'payment_res';
                    $time=$this->data['User']['time_res'];
                    $ampm=$this->data['User']['ampm_res'];
                    $size=$this->data['User']['party_res'];
                    $rest_id=$this->data['User']['rest_id_res'];
                    $this->callReservation($time,$ampm,$size,$rest_id);                    
                    $this->viewPath = 'homes';	
                    $this->render('reservation');
		}
                

	}
	function location($loc=null){
		if(!empty($loc)){
			$this->set('loc',$loc);
		}else{
			$loc='';
			$this->set('loc',$loc);
		}	
		$this->layout = 'popup';
		$user_id = $this->Auth->user('id');
		$username = $this->User->find('first',array('conditions'=>array('id'=>$user_id),'fields'=>array('firstName')));
		$name = $username['User']['firstName'];
		$this->User->set($this->data);
		if(!empty($this->data)){
			//$this->User->validate = array();
			unset($this->User->validateCreditCard['holder_fname']);
			unset($this->User->validateCreditCard['holder_lname']);
			unset($this->User->validateCreditCard['creditCardNumber']);
			unset($this->User->validateCreditCard['cvv2Number']);
			unset($this->User->validateCreditCard['country']);
			unset($this->User->validateCreditCard['subject']);
			unset($this->User->validateCreditCard['content']);
			unset($this->User->validateCreditCard['card_type']);
			$this->User->validate = $this->User->validateCreditCard;
			if ($this->User->validates()) {		
				$this->Userlocation->create();
				$location = $this->Userlocation->save(array(
					'userId'=>$user_id,
					'name'=>$name,
					'address'=>$this->data['User']['address'],
					'city'=>$this->data['User']['city'],
					'state'=>$this->data['User']['state'],
					'zipcode'=>$this->data['User']['zipcode'],
					'location_type'=>$this->data['User']['location_type']			
				));
				$this->Session->setFlash(__l('Your Address is saved') , 'default', null, 'success');
				if(!isset($loc))
					$redirect_url = Router::url(array(
						'controller' => 'profile',
						'action' => 'profile',
						'chicago' => true
					));
				else
					$redirect_url = Router::url(array(
						'controller' => 'profile',
						'action' => 'profile',
						'admin' => false
					));
				echo "<script>window.location.href='$redirect_url'</script>";
			} else {
				$this->Session->setFlash(sprintf(__l('%s') , 'Your address is not saved. Please, try again.') , 'default', null, 'error');
			}
		}
	}
	
	function edit_location($loc=null){
		$this->layout = 'popup';
                 $this->set('title_for_layout','Chicago Dining | Last Minute Restaurant Reservations | My Location ');
		if(!empty($loc)){
			$this->set('loc',$loc);
		}else{
			$loc='';
			$this->set('loc',$loc);
		}	
		if(!empty($this->data)){
			$user_id = $this->Auth->user('id');
			$this->data['Userlocation'] = $this->data['User'];
			//$this->User->validate = array();
			unset($this->User->validateCreditCard['holder_fname']);
			unset($this->User->validateCreditCard['holder_lname']);
			unset($this->User->validateCreditCard['creditCardNumber']);
			unset($this->User->validateCreditCard['cvv2Number']);
			unset($this->User->validateCreditCard['country']);
			unset($this->User->validateCreditCard['subject']);
			unset($this->User->validateCreditCard['content']);
			unset($this->User->validateCreditCard['card_type']);
			$this->User->validate = $this->User->validateCreditCard;
			$this->User->set($this->data);
			if ($this->User->validates()) { 
				$location = $this->Userlocation->save($this->data);
				$this->Session->setFlash(__l('Your Address is saved') , 'default', null, 'success');
				if(isset($loc)&&$loc=='chicago_mag')
					$redirect_url = array(
						'controller' => 'profile',
						'action' => 'chicagoprofile',
						'admin' => false
					);
				else
					$redirect_url = array(
						'controller' => 'profile',
						'action' => 'profile',
						'admin' => false
					);
				$this->redirect($redirect_url);
			}	
		}else{
			if(!empty($this->params['pass'][0])){
				$location = $this->Userlocation->read(null,$this->params['pass'][0]);
				$this->data['User'] = $location['Userlocation'];
			}	
		}
	}
	
	function delete_location($id){
		$this->autoRender=false;
		$this->layout = false;
		$this->Userlocation->id = $id;
		$this->Userlocation->delete($id);
		$this->redirect($this->referer());
		exit;
	}
	function send($transactionId=null){
		if(isset($transactionId)){
			$this->set('transactionId',$transactionId);
			$transaction=$transactionId;
		}
		$user_id = $this->Auth->user('id');
		if(!empty($this->data))	{
			$transaction=$this->data['User']['transactionId'];
		}
		//'transactionId'=>$transaction,
		$reservation_id = $this->Reservation->find('first',array(
				'conditions'=>array(
					'userId'=>$user_id,
					
					'Reservation.approved'=>1
				),
				'fields'=>array(
					'Reservation.id'
				),
				'order'=>'Reservation.id Desc'
			));
		
		$id = $reservation_id['Reservation']['id'];
		$profile_reservation='';		
		$profile_reservation = $this->Reservation->find('all',array(
			'conditions'=>array(
				'Reservation.id'=>$id,
				'Reservation.userId'=>$user_id,
				'Reservation.approved'=>1
			),
			'fields'=>array(
				'Offer.id',
				'Offer.seating',
				'Offer.offerTime',
				'Offer.offerDate',
				'Offer.seating_custom',
				'Offer.restaurantId'
			)
		));
		$restaurant_details = '';
		if(!empty($profile_reservation)):
			$restaurant_id = $profile_reservation[0]['Offer']['restaurantId'];
			$this->set('profile_reservation',$profile_reservation);
			$this->loadmodel('Restaurant');

			$restaurant_details = $this->Restaurant->find('all',array(
				'recursive'=>-1,
				'conditions'=>array(
					'Restaurant.id'=>$restaurant_id,
					'Restaurant.approved'=>1
				),
				'fields'=>array(
					'Restaurant.id',
					'Restaurant.name',
					'Restaurant.phone',
					'Restaurant.short_description',
					'Restaurant.logo',
					'Restaurant.address',
					'Restaurant.city',
					'Restaurant.state'
				)
			));
		endif;	
		if(!empty($restaurant_details)){
			$phone=strip_tags($restaurant_details[0]['Restaurant']['phone']);
			$res_id = strip_tags($restaurant_details[0]['Restaurant']['id']);
			$res_name = strip_tags($restaurant_details[0]['Restaurant']['name']);
			$address=strip_tags($restaurant_details[0]['Restaurant']['address']);
			$city=strip_tags($restaurant_details[0]['Restaurant']['city']);
			$city_id = $city;
			$state=!empty($data['Restaurant']['state'])?', '.$data['Restaurant']['state']:'';
			$row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
			$city_name= $row['city_name'];
			$state=strip_tags($restaurant_details[0]['Restaurant']['state']);
		}
		if(!empty($profile_reservation)){
			$time = strip_tags($profile_reservation[0]['Offer']['offerTime']);
			$off_time=strtotime($time);
			$original_time= date('h:i a',$off_time);
			$date = strip_tags($profile_reservation[0]['Offer']['offerDate']);
			$day=strftime('%d',strtotime($profile_reservation[0]['Offer']['offerDate']));
			$month=strftime('%m',strtotime($profile_reservation[0]['Offer']['offerDate']));
			$year=strftime('%Y',strtotime($profile_reservation[0]['Offer']['offerDate']));
			$mail_date=$month.'/'.$day.'/'.$year;
			if($profile_reservation[0]['Offer']['seating_custom']!=0){
				$seating = strip_tags($profile_reservation[0]['Offer']['seating_custom']);
			}else{
				$seating = strip_tags($profile_reservation[0]['Offer']['seating']);
			}
		}
		$this->set('restaurant_details',$restaurant_details);
		$this->layout='popup';
		$this->set('title_for_layout','Chicago Dining | Last Minute Restaurant Reservations | Send Invitation ');
		$sub='Reservation at'.' '.$res_name;
                if(Configure::read('website.id') !=1)
                $sub .= ' using TableSavvy through '.Configure::read('website.name');
		$this->set('subject',$sub);
		$this->set('Seating',$seating);
		$this->set('Time',$original_time);
		$this->set('RestaurantName',$res_name);
		$this->set('Address',$address);
		$this->set('State',$state);
		$user = $this->User->find('all',array('conditions'=>array('User.id'=>$user_id)),array('fields'=>array('User.firstName','User.lastName','User.email')));
			$this->set('sender',$user);
			$res_url = Router::url(array(
					'controller' => 'homes',
					'action' => 'details',
				),true);
		$restaurant_url = $res_url."/".$res_id;
		$this->User->set($this->data);
		    $phone1 = $restaurant_details[0]['Restaurant']['phone'];
			$phone1 = str_replace('(', '', $phone1);
			$phone1 = str_replace(')', '', $phone1);
			$phone1 = str_replace('-', '', $phone1);
			$phone1 = str_replace(' ', '', $phone1);
			$phoneno = '';
			$phoneno .= '('.substr($phone1,0,3).')'; 
			$phoneno .= '-'. substr($phone1,3,3).'-';
			$phoneno .= substr($phone1,6,4);
		   $url=Router::url('/homes',true);
		if(!empty($this->data))	{
			if($this->data['User']['name'] != '')
					$date=strtotime($profile_reservation[0]['Offer']['offerDate']);
					$day=date('l',$date);
					$month=date('F',$date);
					$year=date('Y',$date);
					$dat=date('l, F dS',$date);
					$time=date('H:i A',strtotime($profile_reservation[0]['Offer']['offerTime']));
				$mail = explode(",", $this->data['User']['receiveremail']);
				$count=count($mail);
				$email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' Send Invitation');
				for($i=0;$i<$count;$i++){
				$emailFindReplace = array(
					'##SITE_LINK##' => Router::url('/', true) ,					
					'##SITE_LOGO##' => Configure::read('website.logo'),
                                        '##FACEBOOK##' => Configure::read('website.facebook'),
                                        '##TWITTER##' => Configure::read('website.twitter'),
                                        '##SITE_NAME##' => Configure::read('website.name'),
					'##RESTARUANT_LINK##' => $restaurant_url,
					'##RESTARUANT_NAME##' => $res_name,
					'##PARTY_SIZE##' => $seating,
					'##SIGN_UP##' => $url,
					'##ADDRESS##' => $address.',<br>'.$city_name.', '.$state,
					'##TIME##' => $original_time,
					'##DAY##'=>$day,
					'##MONTH##'=>$month,
					'##DATE##'=>$dat,
					'##YEAR## '=>$year,
					'##NAME##'=>ucfirst($this->data['User']['name']), 
					'##SUPPORT_EMAIL##' => Configure::read('site.contact_email'),
					'##SUBJECT##' => $this->data['User']['subject'],
					'##FROM_EMAIL##' => $user[0]['User']['email'],
					'##EMAIL##'=>$mail[$i],
					'##PHONENUMBER##'=>$phoneno,
					'##YEAR_MAIL##' => $this->year_mail,
					'##comment##'=>$this->data['User']['content1']
				);
					$this->Email->from = (isset($this->data['User']['senderemail'])) ? $this->data['User']['senderemail'] : '';
					$this->Email->replyTo = (isset($this->data['User']['senderemail'])) ? $this->data['User']['senderemail'] : '';
					$this->Email->to = $mail[$i];
					$this->Email->subject =$sub;
					$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
					if($this->Email->send(strtr($email['email_content'], $emailFindReplace))):
						$this->Session->setFlash('Your invitation sent successfully' , 'default', null, 'success');
					else:	
						$this->Session->setFlash('Your invitation doesn\'t send successfully. please try agian' , 'default', null, 'error');
					endif;
				$this->Email->reset();
				$this->redirect('/profile');
				
			}	
		}
	}
	function Nmiquery_key(){
		$sender_info['is_testmode'] = 1;				
		$sender_info['API_UserName'] = 'c.mahe_1301923521_biz_api1.yahoo.com';
		$sender_info['API_Password'] = '1301923531';
		$sender_info['API_Signature'] = 'AOJLm2qaQZXvoa4AI7KBtezDk4e8ASH09ugd4FTFc2TmZ-EdGxBxPyT8';
		return $sender_info;
	}
	
	function super_addrestraunt(){
            $this->layout = 'adminpopup';
            if(!empty($this->data)) {
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['passwd']);
                $this->data['User']['approved'] = 1;
				$this->User->set($this->data);
                $this->Restaurant->set($this->data);
                $this->loadModel('Restaurant');
                if ($this->Restaurant->validates() && $this->User->validates()) {
                    $this->User->save($this->data);
                    $id=$this->User->getLastInsertID();
					$data=str_replace(" -","-",$this->data['Restaurant']['name']);
					$data=str_replace("&","",$data);
					$data=str_replace("'","",$data);
					$output = preg_replace("/[^[pace:]a-zA-Z0-9]/e", "", $data);
					$output = trim($output);
					$output = preg_replace('/\s/', '-', $output);
					$name = $output;
                    $res_name=$this->data['Restaurant']['name'];
                    $this->Restaurant->save(array(
                        'user_id'=>$id,
                        'name'=>$res_name,
                        'startTime'=> '20:00:00',
                        'endTime' => '23:00:00',
                        'approved'=>1,
						'percentage'=>1,
						'slug_name'=>$name
                    ));
                    $this->Session->setFlash('Your restaurant added successfully' , 'default', null, 'success');
                    echo "<script> setTimeout(parent.$.colorbox.close, 500) </script>";
                }else{
                    $this->Session->setFlash('Your Restaurant doesn\'t add successfully. please try again' , 'default', null, 'error'); 
                }
            }	
	}
	function super_editrestraunt($id=null){            
            $this->layout = 'adminpopup';   
            
            if(!empty($this->data)) {
                $password = trim($this->data['User']['passwd']);
				if(!empty($password))
                    $this->data['User']['password'] = $this->Auth->password($password);
                else{
                    unset($this->validate['User']['passwd']);
                    unset($this->data['User']['passwd']);
                }
                $user_id = $this->Restaurant->find('first',array(
                    'conditions'=>array(
                        'Restaurant.id'=>$this->data['Restaurant']['id']
                    ),
                    'fields'=>array(
                        'Restaurant.user_id'
                    ),
                    'recursive'=>-1
                    ));
                $this->data['User']['id'] = $user_id['Restaurant']['user_id'];
                $this->User->set($this->data);
                $this->Restaurant->set($this->data);
                if($user['User']['email'] = $this->data['User']['email'])
                    unset($this->validate['User']['email']['rule3']);
                if ($this->Restaurant->validates() && $this->User->validates()) {
					$data=str_replace(" -","-",$this->data['Restaurant']['name']);
					$data=str_replace("&","",$data);
					$data=str_replace("'","",$data);
					$output = preg_replace("/[^[pace:]a-zA-Z0-9]/e", "", $data);
					$output = trim($output);
					$output = preg_replace('/\s/', '-', $output);
					$name = $output;
					$this->data['User']['approved']=1;
                    $this->User->save($this->data);
                    $res_name=$this->data['Restaurant']['name'];
                    $this->Restaurant->save(array(
                        'name'=>$res_name,
						'slug_name'=>$name
                    ));
                    $this->Session->setFlash('Your Restaurant updated successfully' , 'default', null, 'success');
                    echo "<script> setTimeout(parent.$.colorbox.close, 500) </script>";
                }else{
                    $this->Session->setFlash('Your Restaurant doesn\'t updated successfully. please try again' , 'default', null, 'error'); 
                }
                unset($this->data['User']['id']);
            }else{ 
                $resturant = $this->Restaurant->read(null,$id);
                $user = $this->User->read(null,$resturant['Restaurant']['user_id']);
                $this->data['Restaurant']['id'] = $resturant['Restaurant']['id'];
                $this->data['Restaurant']['name'] = $resturant['Restaurant']['name'];
                $this->data['User']['email'] = $user['User']['email'];
            }
	}
	function super_res_del($id=null){
                //Configure::write('debug', 0);
				if(!empty($id)){
                    $this->loadmodel('Reservation'); 
					$user_res=$this->Reservation->find('list', array(
						'conditions' => array(
							'Reservation.userId' => $id,
							'Reservation.approved'=>1
						 ) ,
						'fields' => array(
								'Reservation.id',
							)
						,'recursive'=>-1
						));
/*					$user_offer=$this->Offer->find('list', array(
						'conditions' => array(
							'Offer.id' => $id,
							'Reservation.approved'=>1
						 ) ,
						'fields' => array(
								'Offer.id',
							)
						,'recursive'=>-1
						));*/
					//if(empty($user_res)){   
						/*$Userloc=$this->Userlocation->find('list', array(
							'conditions' => array(
								'Userlocation.userId' => $id
							 ) ,
							'fields' => array(
									'Userlocation.id'
								)
							,'recursive'=>-1
							));	
						$Useralert=$this->Alert->find('list', array(
							'conditions' => array(
								'Alert.userId' => $id
							 ) ,
							'fields' => array(
									'Alert.id'
								)
							,'recursive'=>-1
							));					
							$this->Alert->deleteAll(array('Alert.id'=>$Useralert));
							$this->Userlocation->deleteAll(array('Userlocation.id'=>$Userloc));
							$this->User->deleteAll(array('User.id'=>$id));*/
							$this->User->updateAll(array(
								'User.approved' =>0),
								array('User.id' => $id)
							);
							$this->Session->setFlash(sprintf(__l('User deactivated successfully')) , 'default', null, 'success');		
						}else{
							$this->Session->setFlash(sprintf(__l('User Has Reservation Active So User Can\'t Be Deleted')) , 'default', null, 'error');
						}
					//}else{
						//$this->Session->setFlash(sprintf(__l('User can\'t be deleted successfully')) , 'default', null, 'error');
					//}
		$this->loadmodel('User');
		$this->paginate = array(
			'conditions'=>array('account_type'=>3),
			'order'=>'firstName ASC',
			'limit'=>10
		);
		$page = $this->paginate('User');
		$this->set('rest',$page);
	}
	function super_user_change($id=null,$rest_id=null){
		if($id == 0){
			$approved=1;
			$this->Session->setFlash('User was approved successfully' , 'default', null, 'success');
		} else {
			$approved=0;	
			$this->Session->setFlash('User was unapproved successfully ' , 'default', null, 'error');
		}				
		$this->User->updateAll(array(
					'User.approved' =>$approved),
					array('User.id' => $rest_id)
				);
		$this->paginate = array(
			'conditions'=>array('account_type'=>3),
			'order'=>'firstName ASC',
			'limit'=>10
		);
		$page = $this->paginate('User');
		$this->set('rest',$page);
	}
        function send_reservation_mail($resname,$name,$seating,$time,$dat,$phone1,$email1,$offer_id){
            $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug').' New Restaurant owner');
            $rand_string = $this->generateRandomString();
			$phone = $resname['Restaurant']['phone'];
			$phone1 = str_replace('(', '', $phone1);
			$phone1 = str_replace(')', '', $phone1);
			$phone1 = str_replace('-', '', $phone1);
			$phone1 = str_replace(' ', '', $phone1);
			$phoneno = '';
			$phoneno .= '('.substr($phone1,0,3).')'; 
			$phoneno .= '-'. substr($phone1,3,3).'-';
			$phoneno .= substr($phone1,6,4);
			$link=Router::url('/homes/receipt/'.$offer_id, true);  
			$emailFindReplace = array(
                    '##SITE_LINK##' => Router::url('/', true) ,					
                    '##SITE_LOGO##' => Configure::read('website.logo'),
                    '##FACEBOOK##' => Configure::read('website.facebook'),
                    '##TWITTER##' => Configure::read('website.twitter'),
                    '##SITE_NAME##' => Configure::read('website.name'),
                    '##NAME##' => ucfirst($name),
					'##EMAIL##' => $email1,
					'##PHONE##' => $phone,
					'##link##' => $link,
                            '##APPSTORE##' => Configure::read('Applink'),
                    '##SIZE##' => $seating,
                    '##RESNAME##' => $resname['Restaurant']['name'],
                    '##DATE##' => $dat,
                    '##TIME##'=>$time,
					'##YEAR_MAIL##' => $this->year_mail,
                    '##PHONE##'=>$phoneno,
                    '##ADDRESS##'=>$resname['Restaurant']['address'].',<br>'.'Chicago, '.' '.$resname['Restaurant']['state']
            );
            $user = $this->User->findById($resname['Restaurant']['user_id']);
            $this->loadmodel('Recipient');
                        $rec=$this->Recipient->find('all',array('conditions'=>array('resId'=>$resname['Restaurant']['id'])));
                        //$recipient_mail='reservations@tablesavvy.com';
                        $recipient_mail='saravananviswa@farshore.com';
                        foreach($rec as $recipient){
                            $recipient_mail=$recipient_mail.','.$recipient["Recipient"]["email"];
                        }
            if(Configure::read('website.name')=="Chicago Magazine")
            	$sub= "A Reservation has been made via ".Configure::read('website.name').'/TableSavvy';
			else
				$sub= "A Reservation has been made via ".Configure::read('website.name');
			$this->Email->from = 'TableSavvy Reservations <support@tablesavvy.com>';
            $this->Email->replyTo = 'support@tablesavvy.com';
            $this->Email->to  = $user['User']['email'];
            $this->Email->cc  = $recipient_mail;
            $this->Email->readReceipt = 'reservations@tablesavvy.com';
            $this->Email->subject =$sub;
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        }
	function ifbyphone_save($firstname,$lastname,$offer_time,$seating,$phone,$survo_id){
				$offer_time = base64_decode($offer_time);
				$phone = base64_decode($phone);
				$phone1='';
               	$phone1 = str_replace('(', '',$phone);
                $phone1 = str_replace(')', '', $phone1);
                $phone1 = str_replace('-', '', $phone1);
                $phone1 = str_replace(' ', '', $phone1);
                $off_time = date("h:i a",strtotime($offer_time));
		//$url = "https://secure.ifbyphone.com/click_to_xyz.php"; 
		$postvalue = 'app=cts&phone_to_call='.$phone1.'&survo_id='.$survo_id.'&key=91d569d7f1d1504a2bb214d0942bbfb4909a38ea&user_parameters=partysize%7C'
                    .$seating.'%7C%7Ctime%7C'.$off_time.
                    '%7C%7Cfirstname%7C'.$firstname.
                    '%7C%7Clastname%7C'.$lastname;
		$this->loadModel('Ifbyphonecall');
		$this->data['Ifbyphonecall']['postvalue'] = $postvalue;
		$this->Ifbyphonecall->create();
		$this->Ifbyphonecall->save($this->data);
		//return true;
	}
function super_user_change_password() {
	 	$this->layout='popup';
	if (isset($this->data)) {
                    $user_details = $this->User->find('first', array(
                    'conditions' => array(
                            'id' =>$this->data['User']['id']
                    ) ,
                    'recursive' => -1
                    ));
                    if (!empty($this->data['User']['password'])) {
                        if(strlen($this->data['User']['password'])>5){
                    $new_password = $this->Auth->password($this->data['User']['password']);
                    if($user_details['User']['new_user']==2)
                            $new_user = 3;
                    else
                            $new_user = $user_details['User']['new_user'];
                    $this->User->updateAll(array(
                            'User.password' => '\'' . $new_password . '\'',
                            'User.new_user' => '\'' . $new_user . '\'',
                    ) , array(
                            'User.id' => $user_details['User']['id']
                    ));
                    $this->Session->write('newPassword','');
                    $this->Session->setFlash('Your new password has been updated' , 'default', null, 'success');
                    $this->redirect(array('controller'=>'users','action'=>'super_user_detail',$user_details['User']['id']));
                        }else{
                            $this->Session->setFlash(sprintf(__l('Password Must be at least 6 characters') , $this->data) , 'default', null, 'error');
                        $this->redirect(array('controller'=>'users','action'=>'super_user_detail',$user_details['User']['id']));
                        }
                    } else{
                        $this->Session->setFlash(sprintf(__l('Password field  should not be empty. Please Enter New Password') , $this->data) , 'default', null, 'error');
                        $this->redirect(array('controller'=>'users','action'=>'super_user_detail',$user_details['User']['id']));

                    }
		}
	}
        function super_detail($resId){
            $this->loadmodel('Restaurant');
            $userId=$this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$resId),'fields'=>'user_id','recursive'=>-1));
            $this->loadmodel('User');
            $userDetails=$this->User->find('first',array('conditions'=>array('User.id'=>$userId['Restaurant']['user_id']),'recursive'=>-1));
            $this->Session->write('Auth.User.id',$userDetails['User']['id']);
            $this->Session->write('Auth.User.firstName',$userDetails['User']['firstName']);
            $this->Session->write('Auth.User.lastName',$userDetails['User']['lastName']);
            $this->Session->write('Auth.User.email',$userDetails['User']['email']);
            $this->Session->write('Auth.User.phone',$userDetails['User']['phone']);
            $this->Session->write('Auth.User.altphone',$userDetails['User']['altphone']);
            $this->Session->write('Auth.User.new_passoword',$userDetails['User']['new_passoword']);
            $this->Session->write('Auth.User.billingKey',$userDetails['User']['billingKey']);
            $this->Session->write('Auth.User.account_type',$userDetails['User']['account_type']);
            $this->Session->write('Auth.User.card_type',$userDetails['User']['card_type']);
            $this->Session->write('Auth.User.card_number',$userDetails['User']['card_number']);
            $this->Session->write('Auth.User.cvv2Number',$userDetails['User']['cvv2Number']); 
            $this->Session->write('Auth.User.created',$userDetails['User']['created']);
            $this->Session->write('Auth.User.modified',$userDetails['User']['modified']);
            $this->Session->write('Auth.User.cookievalue',$userDetails['User']['cookievalue']);
            $this->Session->write('Auth.User.pw_reset_string',$userDetails['User']['pw_reset_string']);
            $this->Session->write('Auth.User.approved',$userDetails['User']['approved']);
            $this->Session->write('Auth.User.subscribe_email',$userDetails['User']['subscribe_email']);
            $this->Session->write('Auth.User.email_subscription',$userDetails['User']['email_subscription']);
            $this->Session->write('Auth.User.user_amount',$userDetails['User']['user_amount']);
            $this->Session->write('Auth.User.chicagomag',$userDetails['User']['chicagomag']);
            $this->Session->write('Auth.User.user_credit',$userDetails['User']['user_credit']);
            $this->Session->write('Auth.User.used_credit',$userDetails['User']['used_credit']);
            $this->Session->write('Auth.User.new_user',$userDetails['User']['new_user']);
            $this->Session->write('navigate','true');
            if ($this->Auth->user('account_type') ==2) {
                 $check_update = $this->Restaurant->find('first',array('conditions'=> array('user_id' => $this->Auth->user('id'),
                                                                                            'approved' => 1)));
                if(empty($check_update['Neighborhood']['name'])){
                    $this->Session->setFlash(__l('Please update your profile to activate the restaurant') , 'default', null, 'success');
                    $this->redirect(array('controller' => 'restaurants','action' => 'profile','admin' => true));
                }else{
                    $this->redirect(array('controller' => 'table', 'action' => 'index','admin' => true));
                }
            }
    }
    function admin_admindetail(){
            $this->loadmodel('User');
            $userDetails=$this->User->find('first',array('conditions'=>array('User.account_type'=>1),'recursive'=>-1));
            pr($this->Auth->user());
            $this->Session->write('Auth.User.id',$userDetails['User']['id']);
            $this->Session->write('Auth.User.firstName',$userDetails['User']['firstName']);
            $this->Session->write('Auth.User.lastName',$userDetails['User']['lastName']);
            $this->Session->write('Auth.User.email',$userDetails['User']['email']);
            $this->Session->write('Auth.User.phone',$userDetails['User']['phone']);
            $this->Session->write('Auth.User.altphone',$userDetails['User']['altphone']);
            $this->Session->write('Auth.User.new_passoword',$userDetails['User']['new_passoword']);
            $this->Session->write('Auth.User.billingKey',$userDetails['User']['billingKey']);
            $this->Session->write('Auth.User.account_type',$userDetails['User']['account_type']);
            $this->Session->write('Auth.User.card_type',$userDetails['User']['card_type']);
            $this->Session->write('Auth.User.card_number',$userDetails['User']['card_number']);
            $this->Session->write('Auth.User.cvv2Number',$userDetails['User']['cvv2Number']); 
            $this->Session->write('Auth.User.created',$userDetails['User']['created']);
            $this->Session->write('Auth.User.modified',$userDetails['User']['modified']);
            $this->Session->write('Auth.User.cookievalue',$userDetails['User']['cookievalue']);
            $this->Session->write('Auth.User.pw_reset_string',$userDetails['User']['pw_reset_string']);
            $this->Session->write('Auth.User.approved',$userDetails['User']['approved']);
            $this->Session->write('Auth.User.subscribe_email',$userDetails['User']['subscribe_email']);
            $this->Session->write('Auth.User.email_subscription',$userDetails['User']['email_subscription']);
            $this->Session->write('Auth.User.user_amount',$userDetails['User']['user_amount']);
            $this->Session->write('Auth.User.chicagomag',$userDetails['User']['chicagomag']);
            $this->Session->write('Auth.User.user_credit',$userDetails['User']['user_credit']);
            $this->Session->write('Auth.User.used_credit',$userDetails['User']['used_credit']);
            $this->Session->write('Auth.User.new_user',$userDetails['User']['new_user']);
            $this->Session->write('navigate','false');
            if ($this->Auth->user('account_type') == 1) {
                $this->redirect(array('controller' => 'restaurants','action' => 'index', 'super' => true));
            }
    }

    
}
