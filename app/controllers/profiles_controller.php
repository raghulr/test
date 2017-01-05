<?php
class ProfilesController extends AppController
{
  var $uses = array('User', 'Alert', 'Userlocation', 'Reservation', 'Restaurant', 'Offer', 'EmailTemplate');

  var $components = array('Auth', 'Nmiquery', 'Email');

  function index()
  {
    $this->Session->write('reservation', 'unset');
    $this->layout = 'home';
    $this->set('title_for_layout', ' Chicago Dining | Last Minute Restaurant Reservations | My Reservation ');
    $this->set('load_profile', true);
    $user_id = $this->Auth->user('id');

    $user_location = $this->Userlocation->find('first', array(
      'conditions' => array(
        'userId' => $user_id
      ),
      'fields' => array(
        'Userlocation.address',
        'Userlocation.city',
        'Userlocation.state'
      )
    ));
    $this->set('user_location', $user_location);
    $this->loadmodel('Reservation');
    if (isset($_REQUEST['facebook'])) {
      $redirectUrl  = $this->Session->read('Auth.redirectUrl');
      $account_type = $this->Auth->user('account_type');
      if ($account_type == 2) {
        $this->Cookie->delete('User');
        $this->Auth->logout();
        $this->Session->delete('Auth.redirectUrl');
        $this->redirect('/home');
      }
      $this->redirect($redirectUrl);
      $this->set('redirectUrl', $redirectUrl);
    } else {
      $redirectUrl = '';
      $this->set('redirectUrl', $redirectUrl);
    }
    $facebook_user = $this->Session->read('Auth.facebook');
    if (isset($_REQUEST['success']) || !empty($facebook_user)) {
      if (!empty($facebook_user))
        $this->Session->delete('Auth.facebook');
      $this->Session->setFlash('You have successfully logged in', 'default', null, 'success');
    }
    if ((isset($this->params['pass'][0]) && ($this->params['pass'][0] == 'cancel')) || isset($_REQUEST['cancel'])) {
      $this->Session->setFlash(__l('Your Reservation has cancelled successfully.'), 'default', null, 'success');
      $this->set('cancel', 'cancel');
    }
    if (isset($_REQUEST['referencetransaction'])) {
      $this->set('title_for_layout', 'Chicago Dining | Last Minute Restaurant Reservations | Reservation Confirmation');
      $this->set('isOrderConfirmed', 'confirmed');
      $this->Session->setFlash('Thank you for spending your credit on another reservation! Enjoy your dinner!', 'default', null, 'success');
      if (isset($_REQUEST['track_id'])) {
        $tracking_datas = $this->Reservation->find('first', array(
          'conditions' => array(
            'Reservation.id' => $_REQUEST['track_id']
          ),
          'contain' => array(
            'Offer' => array(
              'Restaurant'
            )
          ),
          'recursive' => 2
        ));
        $this->set('tracking_datas', $tracking_datas);
      }
      $this->set('ecommerce_track', '1');
    }
    if (isset($_REQUEST['transaction'])) {
      $this->set('isOrderConfirmed', 'confirmed');
      $this->set('title_for_layout', 'Chicago Dining | Last Minute Restaurant Reservations | Reservation Confirmation');
      $this->Session->setFlash('Your reservation is confirmed. Thanks for Using TableSavvy!', 'default', null, 'success');
      if (isset($_REQUEST['track_id'])) {
        $tracking_datas = $this->Reservation->find('first', array(
          'conditions' => array(
            'Reservation.id' => $_REQUEST['track_id']
          ),
          'contain' => array(
            'Offer' => array(
              'Restaurant'
            )
          ),
          'recursive' => 2
        ));
        $this->set('tracking_datas', $tracking_datas);
      }
      $this->set('ecommerce_track', '1');
    }
    if (isset($_REQUEST['changed']) || isset($_REQUEST['modify'])) {
      $this->Session->setFlash('Your reservation has been modified, thanks!', 'default', null, 'success');
      $this->set('title_for_layout', 'Chicago Dining | Last Minute Restaurant Reservations | Reservation Confirmation');
      $this->set('modify', 'modify');
    }
    if (isset($_REQUEST['error'])) {
      $r_url   = Router::url(array(
        'controller' => 'Profile',
        'action' => 'profile'
      ), true);
      $message = "There was an issue processing your payment. Please update your billing information in <a href='$r_url' onclick='parent.location.href=this.href; return false;'>your profile</a>";
      $this->Session->setFlash(sprintf(__l('%s'), $message), 'default', null, 'error');
    }
    if (isset($_REQUEST['custom_seating'])) {
      $this->set('custom_seating', $_REQUEST['custom_seating']);
    }
    $condtion                         = array();
    $order                            = 'Offer.offerTime';
    $date                             = date('Y-m-d');
    $condtion['Reservation.userId']   = $user_id;
    $condtion['Reservation.approved'] = 1;
    $condtion['Offer.offerDate >=']   = $date;
    $condtion['Offer.offerTime >=']   = date('H:i:s');
    if (!empty($this->params['pass'][0])) {
      $current_res_id             = $this->params['pass'][0];
      $condtion['Reservation.id'] = $current_res_id;
      $profile_reservation_first  = $this->Reservation->find('all', array(
        'conditions' => $condtion,
        'contain' => array(
          'Offer' => array(
            'Restaurant'
          )
        ),
        'order' => $order,
        'recursive' => 2

      ));
      unset($condtion['Reservation.id']);
      $condtion['Reservation.id !='] = $current_res_id;
    }

    //echo date('H:i:s');

    $profile_reservation = $this->Reservation->find('all', array(
      'conditions' => $condtion,
      'contain' => array(
        'Offer' => array(
          'Restaurant'
        )
      ),
      'order' => $order,
      'recursive' => 2

    ));
    if (!empty($profile_reservation_first))
      $profile_reservation = array_merge($profile_reservation_first, $profile_reservation);
    $this->set('restaurant_details', $profile_reservation);
    if (isset($_REQUEST['firstName']) && isset($_REQUEST['lastName']) && isset($_REQUEST['offerid'])) {
      $survo_id    = 577504;
      $offer_times = $this->Offer->find('first', array(
        'conditions' => array(
          'Offer.id' => base64_decode($_REQUEST['offerid'])
        ),
        'fields' => array(
          'Offer.seating',
          'Offer.restaurantId',
          'Offer.offerTime'
        ),
        'recursive' => -1
      ));
      $restaurant  = $this->Restaurant->find('first', array(
        'conditions' => array(
          'Restaurant.id' => $offer_times['Offer']['restaurantId']
        ),
        'fields' => array(
          'Restaurant.name',
          'Restaurant.phone'
        ),
        'recursive' => -1
      ));
      //$this->ifbyphone(base64_decode($_REQUEST['firstName']),base64_decode($_REQUEST['lastName']),$offer_times,$restaurant,$survo_id);
      $this->set('auth', $this->Auth);
      $this->set('offer_times', $offer_times);
      $this->set('restaurant', $restaurant);
    }
  }
  function history()
  {
    $this->layout = 'home';
    $this->set('title_for_layout', ' Chicago Dining | Last Minute Restaurant Reservations | My History ');
    $user_id        = $this->Auth->user('id');
    $this->paginate = array(
      'recursive' => 2,
      'conditions' => array(
        'Reservation.userId' => $user_id,
        'Reservation.approved' => 1
      ),
      'order' => array(
        'Reservation.id DESC'
      ),
      'limit' => 5
    );
    $user           = $this->paginate('Reservation');
    //pr($user);
    $this->set('user_history', $user);
    //$deal=$this->Restaurant->dealtime();
    //$this->set('dealtime',$deal[0][0]['max(offerTime)']);
  }

  function reservation()
  {
    $this->layout = 'home';
    $this->set('title_for_layout', 'reservation');
  }

  function alerts()
  {
    $this->layout = 'home';
    $this->set('title_for_layout', 'Chicago Dining | Last Minute Restaurant Reservations | My Alerts ');
    $user_id = $this->Auth->user('id');
    $alert   = $this->Alert->find('all', array(
      'conditions' => array(
        'Alert.userId' => $user_id
      ),
      'recursive' => 1
    ));
    if (!empty($alert)) {
      foreach ($alert as $alerts) {
        $this->set('sunday', $alerts['Alert']['sunday']);
        $this->set('monday', $alerts['Alert']['monday']);
        $this->set('tuesday', $alerts['Alert']['tuesday']);
        $this->set('wednesday', $alerts['Alert']['wednesday']);
        $this->set('thursday', $alerts['Alert']['thursday']);
        $this->set('friday', $alerts['Alert']['friday']);
        $this->set('saturday', $alerts['Alert']['saturday']);
      }
    }
    $this->set('alert', $alert);
    //$deal=$this->Restaurant->dealtime();
    //$this->set('dealtime',$deal[0][0]['max(offerTime)']);
  }

  function chicago_alerts()
  {
    $this->layout = 'chicagomag';
    $this->set('title_for_layout', 'My Alerts');
    $user_id = $this->Auth->user('id');
    $alert   = $this->Alert->find('all', array(
      'conditions' => array(
        'Alert.userId' => $user_id
      ),
      'recursive' => 1
    ));
    if (!empty($alert)) {
      foreach ($alert as $alerts) {
        $this->set('sunday', $alerts['Alert']['sunday']);
        $this->set('monday', $alerts['Alert']['monday']);
        $this->set('tuesday', $alerts['Alert']['tuesday']);
        $this->set('wednesday', $alerts['Alert']['wednesday']);
        $this->set('thursday', $alerts['Alert']['thursday']);
        $this->set('friday', $alerts['Alert']['friday']);
        $this->set('saturday', $alerts['Alert']['saturday']);
      }
    }
    $this->set('alert', $alert);
    $deal = $this->Restaurant->dealtime();
    //$this->set('dealtime',$deal[0][0]['max(offerTime)']);
    //$this->render('alerts');
  }

  function alert_delete($id)
  {
    $this->layout = 'ajax';
    $user_id      = $this->Auth->user('id');
    $condition    = array(
      'restaurantId' => $id,
      'userId' => $user_id
    );
    if ($this->Alert->deleteAll($condition)) {
      $alert = $this->Alert->find('all', array(
        'conditions' => array(
          'Alert.userId' => $user_id
        ),
        'recursive' => 1
      ));
      foreach ($alert as $alerts) {
        $this->set('sunday', $alerts['Alert']['sunday']);
        $this->set('monday', $alerts['Alert']['monday']);
        $this->set('tuesday', $alerts['Alert']['tuesday']);
        $this->set('wednesday', $alerts['Alert']['wednesday']);
        $this->set('thursday', $alerts['Alert']['thursday']);
        $this->set('friday', $alerts['Alert']['friday']);
        $this->set('saturday', $alerts['Alert']['saturday']);
      }
      $this->set('alert', $alert);
      $this->Session->setFlash('Restaurant deleted successfully', 'default', null, 'success');
    } else {
      $this->Session->setFlash('Restaurant cannot be deleted', 'default', null, 'error');
    }
  }

  function day_select()
  {
    $this->autoRender = false;
    $this->layout     = false;
    if (!empty($this->data)) {
      $this->Alert->create();
      $this->Alert->save($this->data);
      $this->redirect($this->referer());
    }
  }

  function profile()
  {
    $this->layout = 'home';
    $this->set('title_for_layout', ' Chicago Dining | Last Minute Restaurant Reservations | My Profile ');
    $redirectUrl = Router::url('/', true) . "profile/profile";
    $this->Session->write('ProfileredirectUrl', $redirectUrl);
    $this->update();
    $user_id = $this->Auth->user('id');
    $this->loadmodel('User');
    if (isset($_REQUEST['update'])) {
      $this->User->updateAll(array(
        'User.new_user' => 3
      ), array(
        'User.id' => $user_id
      ));
      $this->Session->setFlash('Please add your first and last name so our restaurants recognize you when you dine with them.', 'default', null, 'success');
      $this->set('update', 'update');
    }

    if (isset($_REQUEST['facebook'])) {
      $this->Session->setFlash('You have successfully logged in', 'default', null, 'success');
    }
    if (!empty($this->data['User']['card_number']))
      $this->set('card_number', $this->data['User']['card_number']);
    //$user =
    //pr($user);
    if (empty($this->data))
      $this->data = $this->User->read(null, $user_id);
    unset($this->data['User']['cvv2Number']);
    $location = $this->Userlocation->find('all', array(
      'conditions' => array(
        'userId' => $user_id
      )
    ));
    $count    = count($location);
    $this->set('count', $count);
    $this->set('location', $location);
    //$deal=$this->Restaurant->dealtime();
    //$this->set('dealtime',$deal[0][0]['max(offerTime)']);
  }

  function select_address($transactionId = null)
  {
    $this->layout = 'home';
    $this->set('title_for_layout', 'Get Direction');
    $user_id = $this->Auth->user('id');
    $this->set('transactionId', $transactionId);
    if (isset($transactionId)) {
      $transaction = $transactionId;
    }
    if (!empty($this->data['Userlocation']['id'])) {
      $transaction   = $this->data['User']['transactionId'];
      $user_location = $this->Userlocation->findById($this->data['Userlocation']['id']);
      $this->loadmodel('City');
      $profile_reservation = $this->Reservation->find('first', array(
        'conditions' => array(
          'Reservation.userId' => $user_id,
          'Reservation.offerId' => $transaction,
          'Reservation.approved' => 1
        )
      ));
      $restaurant_details  = $this->Restaurant->find('first', array(
        'recursive' => -1,
        'conditions' => array(
          'Restaurant.id' => $profile_reservation['Offer']['restaurantId'],
          'Restaurant.approved' => 1
        )
      ));
      $city_name           = $this->City->findById($restaurant_details['Restaurant']['city']);
      echo '<script type="text/javascript">parent.window.open("http://maps.google.com/maps?saddr=' . $user_location["Userlocation"]["address"] . ',' . $user_location["Userlocation"]["city"] . '+' . $user_location["Userlocation"]["state"] . '&daddr=' . $restaurant_details["Restaurant"]["address"] . ',' . $city_name["City"]["city_name"] . '+' . $restaurant_details["Restaurant"]["state"] . '","_blank");parent.window.location.href=parent.window.location.href+"/"+"' . $transaction . '"</script>';
    }
    $locations = $this->Userlocation->find('all', array(
      'conditions' => array(
        'userId' => $user_id
      )
    ));
    $options   = array();
    foreach ($locations as $location) {
      $options[$location['Userlocation']['id']] = $location['Userlocation']['full_address'];
    }
    $this->set('options', $options);
  }
  function check_login()
  {
    $this->layout = false;
    $user_id      = '';
    if ($this->Auth->user('id')) {
      $user_id = $this->Auth->user('id');
    }
    $this->set('user_id', $user_id);
  }

  function Payscape_key()
  {
    $sender_info['is_testmode']   = 1;
    $sender_info['API_UserName']  = 'c.mahe_1301923521_biz_api1.yahoo.com';
    $sender_info['API_Password']  = '1301923531';
    $sender_info['API_Signature'] = 'AOJLm2qaQZXvoa4AI7KBtezDk4e8ASH09ugd4FTFc2TmZ-EdGxBxPyT8';
    return $sender_info;
  }

  function update()
  {
    $this->User->set($this->data);
    if (!empty($this->data)) {
      //$this->User->validate = array();
      if ($this->data['User']['card_type'] != '' && $this->data['User']['hidden_payment'] == 1)
        $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
      /*else{
      unset($this->data['User']['holder_fname']);
      unset($this->data['User']['holder_lname']);
      unset($this->data['User']['card_type']);
      unset($this->data['User']['creditCardNumber']);
      unset($this->data['User']['expDateMonth']);
      unset($this->data['User']['expDateYear']);
      unset($this->data['User']['cvv2Number']);
      unset($this->data['User']['hidden_payment']);
      $this->User->set($this->data);

      pr($this->data);
      }*/
      $last_user_id = $this->Auth->User('id');
      if ($this->User->validates()) {
        if ($this->data['User']['card_type'] != '' && $this->data['User']['hidden_payment'] == 1) {

          if (!empty($last_user_id))
            $last_user_id = $last_user_id + 1;
          else
            $last_user_id = rand(1, 99999);
          $last_user_id = '9789432110' . rand(10, 99999) . $last_user_id;

          $data_credit_card['customer_vault']        = 'add_customer';
          $data_credit_card['customer_vault_id']     = '';
          $data_credit_card['firstName']             = $this->data['User']['holder_fname'];
          $data_credit_card['lastName']              = $this->data['User']['holder_lname'];
          $data_credit_card['creditCardType']        = $this->data['User']['card_type'];
          $data_credit_card['creditCardNumber']      = $this->data['User']['creditCardNumber'];
          $data_credit_card['expDateMonth']['month'] = $this->data['User']['expDateMonth']['month'];
          $data_credit_card['expDateYear']['year']   = $this->data['User']['expDateYear']['year'];
          $data_credit_card['cvv2Number']            = $this->data['User']['cvv2Number'];
          $payment_responses                         = $this->Nmiquery->doVaultPost($data_credit_card);
          if (!empty($payment_responses) && $payment_responses['response'] == 1):
             $cc_length = strlen((string)$data_credit_card['creditCardNumber']);
              $prefix_amex= substr($data_credit_card['creditCardNumber'], 0, 2);
               //Amex card checking
              if($prefix_amex == 34 || $prefix_amex == 37 && ($cc_length == 15)):
               $void_responses = $this->Nmiquery->doVoidTransaction($payment_responses);
               endif;
            $this->data['User']['billingKey'] = $payment_responses['customer_vault_id'];
          else:
            //$message=$payment_response['result'];
            $message = "There was an issue processing your payment. Please update your billing information in your profile";
            $this->Session->setFlash(sprintf(__l('%s'), $message), 'default', null, 'error');
            return;
          endif;
          $card_number                       = $this->data['User']['creditCardNumber'];
          $this->data['User']['card_number'] = substr($card_number, -4, 4);
        }

        if ($this->User->save($this->data)) {
          $user_id = $this->Auth->User('id');
          $user    = $this->User->find('first', array(
            'conditions' => array(
              'User.id' => $user_id
            ),
            'fields' => array(
              'new_user'
            ),
            'recursive' => -1
          ));
          if ($user['User']['new_user'] == 3) {
            $this->User->updateAll(array(
              'User.new_user' => 4
            ), array(
              'User.id' => $user_id
            ));
          }
          $redirectUrl        = $this->Session->read('Auth.redirectUrl');
          $profileredirectUrl = $this->Session->read('ProfileredirectUrl');
          $this->Session->delete('ProfileredirectUrl');
          $this->Session->setFlash(__l('You have successfully updated with our site.'), 'default', null, 'success');
          if (!empty($profileredirectUrl))
            $this->redirect($profileredirectUrl);
          else if (!empty($redirectUrl) && empty($profileredirectUrl))
            $this->redirect($redirectUrl);
          $this->data = $this->User->read(null, $this->Auth->User('id'));
        }
      } else {
        if ($this->data['User']['hidden_payment'] == '') {
          if ($this->User->save($this->data)) {
            $this->Session->setFlash(__l('You have successfully updated with our site.'), 'default', null, 'success');
            $this->data = $this->User->read(null, $this->Auth->User('id'));
          }
        }
      }
    }
  }
  function cancel()
  {
    $this->layout   = 'ajax';
    $reservation_id = '';
    if (!empty($this->params['pass'][0])) {
      $reservation_id = $this->params['pass'][0];
      $reservation    = $this->Reservation->find('first', array(
        'conditions' => array(
          'Reservation.id' => $reservation_id,
          'Reservation.approved' => 1
        ),
        'contain' => array(
          'Offer' => array(
            'Restaurant'
          ),
          'User'
        ),
        'fields' => array(
          'offerId'
        ),
        'recursive' => 2
      ));
      $user_id        = $reservation['User']['id'];
      $user           = $this->User->find('first', array(
        'conditions' => array(
          'User.id' => $user_id
        ),
        'fields' => array(
          'id',
          'billingKey',
          'firstName',
          'lastName',
          'email',
          'user_amount',
          'phone'
        ),
        'recursive' => -1
      ));
      $res_id         = $reservation_id;
      $offer_id       = $reservation['Reservation']['offerId'];

      if (empty($reservation)) {
        $this->Session->setFlash(__l("Your Reservation already cancelled."), 'default', null, 'error');
        return true;
      }
      $reserve_time        = strtotime($reservation['Offer']['offerTime']) - 1800;
      $last_time           = strtotime(date('H:i:s'));
      $convert_time        = date('H:i', $last_time);
      $convet_reserve_time = date('H:i', $reserve_time);
      // if($reserve_time>=$last_time){
      //cancel the reservation
      if ($reservation['Offer']['seating_custom'] != 0)
        $cancel_custom = $reservation['Offer']['seating_custom'];
      else
        $cancel_custom = 0;
      date_default_timezone_set('America/Chicago');
      $cancelledtime                                = date('Y-m-d H:i:s');
      $this->Reservation->id                        = $reservation_id;
      $this->data['Reservation']['approved']        = 0;
      $this->data['Reservation']['receipt']         = 0;
      $this->data['Reservation']['cancel_custom']   = $cancel_custom;
      $this->data['Reservation']['trasaction_time'] = $cancelledtime;
      $reservation_canled                           = $this->Reservation->save($this->data['Reservation']);
      if ($reservation_canled) {
        //save user amount
        $amount = $user['User']['user_amount'] + 5;
        $data   = array(
          'User' => array(
            'id' => $user['User']['id'],
            'user_amount' => $amount
          )
        );
        $this->User->save($data, false, array(
          'user_amount'
        ));

        $seating = $reservation['Offer']['seating'];
        if ($reservation['Offer']['seating_custom'] != 0)
          $seating = $reservation['Offer']['seating_custom'];
        $created_time = $cancelledtime;
        $offerdata    = array(
          'Offer' => array(
            'id' => $reservation['Offer']['id'],
            'created_time' => $created_time
          )
        );
        $this->Offer->save($offerdata, false, array(
          'created_time'
        ));
        $this->Offer->updateAll(array(
          'Offer.seating_custom' => 0
        ), array(
          'Offer.id' => $reservation['Offer']['id']
        ));

        // $offer_update = $this->Offer->updateAll(array('Offer.seating_custom'=>0),
        //array('Offer.id' => $reservation['Offer']['id']));

        $date                                    = strtotime($reservation['Offer']['offerDate']);
        $time                                    = date('H:i A');
        $day                                     = date('l', $date);
        $month                                   = date('F', $date);
        $year                                    = date('Y', $date);
        $dat                                     = date('l, F dS', $date);
        $rand_string                             = $this->generateRandomString();
        $resturant_name['Restaurant']['name']    = $reservation['Offer']['Restaurant']['name'];
        $resturant_name['Restaurant']['id']      = $reservation['Offer']['Restaurant']['id'];
        $resturant_name['Restaurant']['user_id'] = $reservation['Offer']['Restaurant']['user_id'];
        $email                                   = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Cancel Reservation');
        $emailFindReplace                        = array(
          '##SITE_LINK##' => Router::url('/', true),
          '##SITE_LOGO##' => Configure::read('website.logo'),
          '##FACEBOOK##' => Configure::read('website.facebook'),
          '##TWITTER##' => Configure::read('website.twitter'),
          '##SITE_NAME##' => Configure::read('website.name'),
          '##NAME##' => ucfirst($user['User']['firstName']),
          '##SIZE##' => $seating,
          '##RESNAME##' => $resturant_name['Restaurant']['name'],
          '##DAY##' => $day,
          '##MONTH##' => $month,
          '##DATE##' => $dat,
          '##YEAR##' => $year,
          '##APPSTORE##' => Configure::read('Applink'),
          '##YEAR_MAIL##' => $this->year_mail,
          '##TIME##' => date('h:i A', strtotime($reservation['Offer']['offerTime'])),
          '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true)
        );
        //$sub="Your "."'".$reservation['Offer']['Restaurant']['name']."'"." Reservation Cancellation";
        $sub                                     = "Reservation Cancellation via " . Configure::read('website.name');
        $this->Email->from                       = Configure::read('website.name') . ' <support@tablesavvy.com>';
        $this->Email->replyTo                    = 'support@tablesavvy.com';
        $this->Email->to                         = $user['User']['email'];
        $this->Email->subject                    = $sub;
        $this->Email->sendAs                     = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        //$survo_id = 575244;
        $offer_times['Offer']['offerTime'] = $reservation['Offer']['offerTime'];
        $offer_times['Offer']['seating']   = $seating;
        $restaurant['Restaurant']['name']  = $resturant_name;
        $restaurant['Restaurant']['phone'] = $reservation['Offer']['Restaurant']['phone'];
        //$this->set('ifby',$this);
        $offer_time                        = base64_encode($offer_times['Offer']['offerTime']);
        $phone                             = base64_encode($restaurant['Restaurant']['phone']);
        $first_name                        = $user['User']['firstName'];
        $last_name                         = $user['User']['lastName'];
        $this->set(compact('seating', 'offer_time', 'phone', 'survo_id', 'fname', 'lname'));
        $survo_id = 588354;
        //$this->ifbyphone_save($first_name,$last_name,$offer_time,$seating,$phone,$survo_id);
        //$this->ifbyphone($reservation['User']['firstName'],$reservation['User']['lastName'],$offer_times,$restaurant,$survo_id);
        //$this->ifbyphone($reservation['User']['firstName'],$reservation['User']['lastName'],$offer_time,$seating,$phone,$survo_id);
        //exit;
        $this->send_cancel_email($first_name, $last_name, $reservation, $seating, $resturant_name, $dat, $res_id);
        $this->Session->setFlash(__l('Your Reservation has been cancelled successfully.'), 'default', null, 'success');

      } else {
        $this->Session->setFlash(__l("Your Reservation doesn't cancelled successfully."), 'default', null, 'error');
      }
      // }else{
      // $this->Session->setFlash(__l('Your Reservation time is passed. You cannot cancel the reservation.') , 'default', null, 'error');
      //}
    }
    $redirect_url = Router::url(array(
      'controller' => 'Profile',
      'action' => 'index',
      $reservation_id
    ));
  }
  function search()
  {
    $this->layout = 'ajax';
    $party_size   = 2;
    if (!empty($this->params['form']['id'])) {
      $this->layout = false;
      $party_size   = $this->params['form']['id'];
    }
    $this->set('party_size', $party_size);
    $this->set('title_for_layout', 'Search');
    $this->loadmodel('Neighborhood');
    $neighbor_list = $this->Neighborhood->find('list', array(
      'fields' => array(
        'name'
      )
    ));
    $this->set('neighbor_list', $neighbor_list);
    $this->loadmodel('Cuisine');
    $cuisine_list = $this->Cuisine->find('list', array(
      'fields' => array(
        'name'
      )
    ));
    $this->set('cuisine_list', $cuisine_list);
    if ($this->data) {
      if (!empty($this->data['Profile'])) {
        $this->Session->write('rest', $this->data['Profile']['search']);
      } else {
        $this->Session->write('rest', $this->data['User']['search']);
      }
    }
    $search      = $this->Session->read('rest');
    $search_term = trim($search);
    if (!empty($search_term)) {
      $search_condition['Restaurant.name LIKE'] = '%' . $search_term . '%';
      $search_condition['Restaurant.approved']  = 1;
      $search_condition['Restaurant.city']      = Configure::read('website.city_id');
      $this->paginate                           = array(
        'conditions' => $search_condition,
        'contain' => array(
          'Restaurantcuisine' => array(
            'Cuisine' => array(
              'fields' => array(
                'Cuisine.name'
              )
            )
          )
        ),
        'fields' => array(
          'Restaurant.id',
          'Restaurant.name',
          'Restaurant.city',
          'Restaurant.neighborhoodId',
          'Restaurant.logo',
          'Restaurant.startTime',
          'Restaurant.endTime'
        ),
        'limit' => 8,
        'recursive' => 2
      );
      $result                                   = $this->paginate('Restaurant');
      $count                                    = count($result);
      $this->set('count', $count);
      if ($count == 1) {
        foreach ($result as $data) {
          $redirect_url = Router::url(array(
            'controller' => 'homes',
            'action' => 'details',
            $data['Restaurant']['id']
          ));
          echo "<script>window.parent.location.href='$redirect_url'</script>";
          $this->autoRender = false;
        }
        $this->set('restaurant', $this);
        $this->set('result', $result);
      } else {
        $this->set('restaurant', $this);
        $this->set('result', $result);
      }
    } else {
      $this->set('count', -1);
    }
  }
  function change_reservation()
  {
    $this->layout = 'home';
    $this->set('title_for_layout', 'Chicago Dining | Last Minute Restaurant Reservations | Modify Reservation ');
    if (!empty($this->params['url']['rest_id']))
      $restuarant_id = $this->params['url']['rest_id'];
    if (!empty($this->data['Restaurant']['id']))
      $restuarant_id = $this->data['Restaurant']['id'];
    $restaurant  = $this->Restaurant->find('first', array(
      'recursive' => -1,
      'conditions' => array(
        'Restaurant.id' => $restuarant_id
      ),
      'fields' => array(
        'id',
        'name',
        'user_id',
        'startTime',
        'endTime',
        'phone',
        'address',
        'state',
        'city'
      )
    ));
    $party_sizes = array(
      '2' => 2,
      '3' => 4,
      '4' => 4,
      '5' => 6,
      '6' => 6,
      '7' => 8,
      '8' => 8
    );
    if (!empty($this->params['url']['rest_id'])) {
      $restuarant_id               = $this->params['url']['rest_id'];
      $reservation_id              = $this->params['url']['reservation_id'];
      $reservedsize                = $this->params['url']['party'];
      $party_size                  = $party_sizes[$this->params['url']['party']];
      $offer_id                    = $this->params['url']['offer_id'];
      $time                        = $this->params['url']['time'];
      $ampm                        = $this->params['url']['ampm'];
      $reservationtime             = $time . ' ' . $ampm;
      $conditions['Offer.seating'] = $party_size;
      $party_size                  = $reservedsize;

    } else {
      $restuarant_id                   = $this->data['Restaurant']['id'];
      $reservationtime                 = $this->data['Offer']['time'];
      $offer_id                        = $this->data['Offer']['id'];
      $party_size                      = $this->data['User']['size'];
      $conditions['Offer.offerTime >'] = date('H:i A');
      $conditions['Offer.seating']     = $party_sizes[$party_size];
      $reservedsize                    = $this->data['Offer']['reserved_size'];
      $reservation_id                  = $this->data['Reservation']['id'];
      $check_timing                    = $this->data['User']['time'];
    }
    /*$starttime=strtotime($restaurant['Restaurant']['startTime']);
    $select_time = strtotime($reservationtime);
    $current_time = time('H i A');
    if($select_time>$current_time)
    $start_time = date('H:i:s', $select_time);
    else
    $start_time = date('H:i:s', $current_time);
    $selected_end_time ='';
    $conditions['Offer.offerTime BETWEEN ? AND ? '] = array(
    $start_time ,
    $restaurant['Restaurant']['endTime']
    );*/

    $conditions['Offer.offerTime >'] = date('H:i:s');
    $reservesize                     = (isset($this->data['User']['size'])) ? $this->data['User']['size'] : $reservedsize;
    if ($reservedsize == $reservesize) {
      $reservation_list = $this->Reservation->find('list', array(
        'fields' => array(
          'Reservation.offerId',
          'Reservation.offerId'
        ),
        'conditions' => array(
          'Reservation.approved' => 1
        )
      ));
    } else {
      $reservation_list = $this->Reservation->find('list', array(
        'fields' => array(
          'Reservation.offerId',
          'Reservation.offerId'
        ),
        'conditions' => array(
          'Reservation.approved' => 1,
          'NOT' => array(
            'Reservation.OfferId' => $offer_id
          )
        )
      ));
    }
    $conditions['NOT']                = array(
      'Offer.id' => $reservation_list
    );
    //pr($conditions);
    $currentdate                      = date('Y-m-d');
    $conditions['Offer.offerDate']    = $currentdate;
    $conditions['Offer.restaurantId'] = $restuarant_id;
    $reservation_time                 = $this->Offer->find('list', array(
      'recursive' => -1,
      'conditions' => $conditions,
      'fields' => array(
        'id',
        'offerTime'
      ),
      'group' => 'offerTime',
      'order' => 'offerTime'
    ));
    if (isset($this->data['User']['save_offer']) && $this->data['User']['save_offer'] == 2) {
      if ($check_timing != $offer_id) {
        $table_deleted   = $this->Restaurant->check_offer($check_timing);
        $available_count = $this->Restaurant->check_reservation($check_timing);
        //echo "check_timing".$table_deleted;
        //echo "available_count".$available_count;&&$available_count!=0
        if ($table_deleted == 0) {
          $this->Session->setFlash(__l('Sorry! This table has been booked!'), 'default', null, 'error');
          $this->redirect('/homes/alreadyreserved');
          return false;
        }
        if ($available_count != 0) {
          $this->Session->setFlash(__l('Sorry! This table has been booked!'), 'default', null, 'error');
          $this->redirect('/homes/alreadyreserved');
          return false;
        }
      }
      $this->data['Offer']['id']               = $this->data['Reservation']['offerId'] = $this->data['User']['time'];
      $this->data['Reservation']['chicagomag'] = Configure::read('website.id');

      $normal_party_size = array(
        2,
        4,
        6,
        8
      );
      $cutom_size        = $this->data['User']['size'];
      if (in_array($cutom_size, $normal_party_size))
        $cutom_size = 0;
      $this->data['Offer']['seating_custom'] = $cutom_size;
      date_default_timezone_set('America/Chicago');
      $modified_time                                = date('Y-m-d H:i:s');
      $this->data['Reservation']['cancel_custom']   = $cutom_size;
      $this->data['Reservation']['receipt']         = 0;
      $this->data['Reservation']['trasaction_time'] = $modified_time;
      $this->Reservation->set($this->data['Reservation']);
      $this->Reservation->save();
      $res_id = $this->Reservation->getLastInsertID();
      if (empty($res_id))
        $res_id = $this->data['Reservation']['id'];
      $offerdata = array(
        'Offer' => array(
          'id' => $this->data['Offer']['id'],
          'created_time' => $modified_time
        )
      );
      $this->Offer->save($offerdata, false, array(
        'created_time'
      ));
      $this->Offer->updateAll(array(
        'Offer.seating_custom' => $cutom_size
      ), array(
        'Offer.id' => $this->data['Offer']['id']
      ));

      $this->Session->setFlash(__l('Your Reservation changed successfully.'), 'default', null, 'success');
      $this->send_mail($this->data['Reservation']['offerId'], $this->data['User']['size'], $restaurant, $res_id);


      // $profile_url = $this->redirect(array('controller'=>'Profile','action'=>'index',$this->data['Reservation']['id']));

    }

    $this->set('time', $reservationtime);
    $this->set('size', $party_size);
    $this->set('offer_id', $offer_id);
    $this->set('restaurant', $restaurant);
    $this->set('reservation_time', $reservation_time);
    $this->set('reservedsize', $reservedsize);
    $this->set('reservation_id', $reservation_id);


  }
  function send_mail($offerId, $cutom_size, $restaurant, $res_id)
  {
    $offer_times    = $this->Offer->find('first', array(
      'conditions' => array(
        'Offer.id' => $offerId
      ),
      'fields' => array(
        'Offer.offerTime',
        'Offer.offerDate',
        'Offer.seating'
      )
    ));
    $reser_offer_id = $this->Reservation->find('first', array(
      'conditions' => array(
        'Reservation.offerId' => $offerId
      ),
      'fields' => array(
        'id'
      )
    ));
    //$res_id = $reser_offer_id['Reservation']['id'];

    $user_id = $this->Auth->User('id');
    $user    = $this->User->find('first', array(
      'conditions' => array(
        'User.id' => $user_id
      ),
      'fields' => array(
        'billingKey',
        'firstName',
        'lastName',
        'email',
        'email_subscription'
      ),
      'recursive' => -1
    ));
    $phone1  = $restaurant['Restaurant']['phone'];
    $phone1  = str_replace('(', '', $phone1);
    $phone1  = str_replace(')', '', $phone1);
    $phone1  = str_replace('-', '', $phone1);
    $phone1  = str_replace(' ', '', $phone1);
    $phoneno = '';
    $phoneno .= '(' . substr($phone1, 0, 3) . ')';
    $phoneno .= '-' . substr($phone1, 3, 3) . '-';
    $phoneno .= substr($phone1, 6, 4);
    $email                = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Modify Reservation');
    $rand_string          = $this->generateRandomString();
    $emailFindReplace     = array(
      '##SITE_LINK##' => Router::url('/', true),
      '##SITE_LOGO##' => Configure::read('website.logo'),
      '##FACEBOOK##' => Configure::read('website.facebook'),
      '##TWITTER##' => Configure::read('website.twitter'),
      '##SITE_NAME##' => Configure::read('website.name'),
      '##NAME##' => ucfirst($user['User']['firstName']),
      '##SIZE##' => $cutom_size,
      '##RESNAME##' => $restaurant['Restaurant']['name'],
      '##DAY##' => date('l'),
      '##MONTH##' => date('F'),
      '##DATE##' => date('l, F dS'),
      '##YEAR##' => date('Y'),
      '##APPSTORE##' => Configure::read('Applink'),
      '##YEAR_MAIL##' => $this->year_mail,
      '##TIME##' => date('h:i a', strtotime($offer_times['Offer']['offerTime'])),
      '##PHONE##' => $phoneno,
      '##ADDRESS##' => $restaurant['Restaurant']['address'] . '<br>' . 'Chicago, ' . $restaurant['Restaurant']['state'],
      '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true),
      '##LOGO##' => Router::url('/images/logo.png', true)
    );
    $sub                  = "Your " . "'" . $restaurant['Restaurant']['name'] . "'" . " Reservation Modification";
    $this->Email->from    = Configure::read('website.name') . ' <support@tablesavvy.com>';
    $this->Email->replyTo = 'support@tablesavvy.com';
    $this->Email->to      = $user['User']['email'];
    $this->Email->subject = $sub;
    $this->Email->sendAs  = ($email['is_html']) ? 'html' : 'text';
    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    $dat        = date('l, F dS');
    $name       = $user['User']['firstName'] . ' ' . $user['User']['lastName'];
    //$survo_id = 575254;
    $seating    = $offer_times['Offer']['seating'];
    $offer_time = base64_encode($offer_times['Offer']['offerTime']);
    $phone      = base64_encode($restaurant['Restaurant']['phone']);
    $fname      = $user['User']['firstName'];
    $lname      = $user['User']['lastName'];
    //$this->ifbyphone($fname,$lname,$offer_time,$seating,$phone,$survo_id);
    $this->send_change_eamil($user, $offer_times, $cutom_size, $restaurant, $dat, $res_id);
    $survo_id   = 588344;
    $first_name = $user['User']['firstName'];
    $last_name  = $user['User']['lastName'];
    //$this->ifbyphone_save($first_name,$last_name,$offer_time,$cutom_size,$phone,$survo_id);
    $this->redirect(array(
      'controller' => 'profile',
      'action' => 'index',
      '?' => 'modify=modify&firstName=' . base64_encode($fname) . '&lastName=' . base64_encode($lname) . '&offerid=' . base64_encode($offerId) . '&custom_seating=' . $cutom_size
    ));
  }
  function ifbyphone_save($firstname, $lastname, $offer_time, $seating, $phone, $survo_id)
  {
    $offer_time = base64_decode($offer_time);
    $phone      = base64_decode($phone);
    $phone1     = '';
    $phone1     = str_replace('(', '', $phone);
    $phone1     = str_replace(')', '', $phone1);
    $phone1     = str_replace('-', '', $phone1);
    $phone1     = str_replace(' ', '', $phone1);
    $off_time   = date("h:i a", strtotime($offer_time));
    //$url = "https://secure.ifbyphone.com/click_to_xyz.php";
    $postvalue  = 'app=cts&phone_to_call=' . $phone1 . '&survo_id=' . $survo_id . '&key=91d569d7f1d1504a2bb214d0942bbfb4909a38ea&user_parameters=partysize%7C' . $seating . '%7C%7Ctime%7C' . $off_time . '%7C%7Cfirstname%7C' . $firstname . '%7C%7Clastname%7C' . $lastname;
    $this->loadModel('Ifbyphonecall');
    $this->data['Ifbyphonecall']['postvalue'] = $postvalue;
    $this->log($postvalue, 'trace');
    $this->Ifbyphonecall->create();
    $this->Ifbyphonecall->save($this->data);
    return true;
  }
  function error_log1()
  {
    $error_log_path = APP . '/tmp/logs/trace.log';
    $error_log      = $debug_log = '';
    //if (file_exists($error_log_path)) {
    $handle         = fopen($error_log_path, "r");
    $error_log      = file_get_contents($error_log_path, FILE_USE_INCLUDE_PATH);
    fclose($handle);
    //}
    $this->set('error_log', $error_log);
  }
  function ifbyphone()
  {
    $this->layout     = false;
    $this->autoRender = false;
    $this->loadModel('Ifbyphonecall');
    $url              = "https://secure.ifbyphone.com/click_to_xyz.php";
    $postvalueDatafor = $this->Ifbyphonecall->find('all', array(
      'conditions' => array(
        'status' => 0
      ),
      'order' => 'id',
      'recursive' => -1
    ));
    if (!empty($postvalueDatafor)) {
      foreach ($postvalueDatafor as $postvalueData) {
        $postvalue = $postvalueData['Ifbyphonecall']['postvalue'];
        $this->Ifbyphonecall->updateAll(array(
          'status' => 1
        ), array(
          'id' => $postvalueData['Ifbyphonecall']['id']
        ));
        if (isset($postvalue) && !empty($postvalue)) {
          $url = "https://secure.ifbyphone.com/click_to_xyz.php";
          /*$postvalue = 'app=cts&phone_to_call='.$phone1.'&survo_id='.$survo_id.'&key=91d569d7f1d1504a2bb214d0942bbfb4909a38ea&user_parameters=partysize%7C'
          .$seating.'%7C%7Ctime%7C'.$off_time.
          '%7C%7Cfirstname%7C'.$firstname.
          '%7C%7Clastname%7C'.$lastname;*/

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $postvalue);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $json = curl_exec($ch);
        }
      }
    }
    //exit;
    return true;
  }
  function send_change_eamil($user, $reservation, $seating, $resturant_name, $dat, $offer_id)
  {
    $email            = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' change owner');
    $rand_string      = $this->generateRandomString();
    $res_email        = $this->User->findById($resturant_name['Restaurant']['user_id']);
    $link             = Router::url('/homes/receipt/' . $offer_id, true);
    $emailFindReplace = array(
      '##SITE_LINK##' => Router::url('/', true),
      '##SITE_LOGO##' => Configure::read('website.logo'),
      '##FACEBOOK##' => Configure::read('website.facebook'),
      '##TWITTER##' => Configure::read('website.twitter'),
      '##SITE_NAME##' => Configure::read('website.name'),
      '##NAME##' => ucfirst($user['User']['firstName']) . ' ' . ucfirst($user['User']['lastName']),
      '##SIZE##' => $seating,
      '##link##' => $link,
      '##APPSTORE##' => Configure::read('Applink'),
      '##RESNAME##' => $resturant_name['Restaurant']['name'],
      '##DATE##' => $dat,
      '##YEAR_MAIL##' => $this->year_mail,
      '##TIME##' => date('h:i A', strtotime($reservation['Offer']['offerTime'])),
      '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true)
    );
    if (Configure::read('website.name') == "Chicago Magazine")
      $sub = "Reservation Modification via " . Configure::read('website.name') . '/TableSavvy';
    else
      $sub = "Reservation Modification via " . Configure::read('website.name');
    $this->loadmodel('Recipient');
    $rec            = $this->Recipient->find('all', array(
      'conditions' => array(
        'resId' => $resturant_name['Restaurant']['id']
      )
    ));
    // $recipient_mail = 'reservations@tablesavvy.com';
    $recipient_mail = 'saravananviswa@farshore.com';
    foreach ($rec as $recipient) {
      $recipient_mail = $recipient_mail . ',' . $recipient["Recipient"]["email"];
    }
    $this->Email->from        = Configure::read('website.name') . ' <support@tablesavvy.com>';
    $this->Email->replyTo     = 'support@tablesavvy.com';
    $this->Email->cc          = $recipient_mail;
    $this->Email->to          = $res_email['User']['email'];
    $this->Email->readReceipt = 'saravananviswa@farshore.com';
    $this->Email->subject     = $sub;
    $this->Email->sendAs      = ($email['is_html']) ? 'html' : 'text';
    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
  }
  function send_cancel_email($first_name, $last_name, $reservation, $seating, $resturant_name = array(), $dat, $offer_id)
  {
    $email            = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' cancel owner');
    $rand_string      = $this->generateRandomString();
    $res_email        = $this->User->findById($resturant_name['Restaurant']['user_id']);
    $link             = Router::url('/homes/receipt/' . $offer_id, true);
    $emailFindReplace = array(
      '##SITE_LINK##' => Router::url('/', true),
      '##SITE_LOGO##' => Configure::read('website.logo'),
      '##FACEBOOK##' => Configure::read('website.facebook'),
      '##TWITTER##' => Configure::read('website.twitter'),
      '##SITE_NAME##' => Configure::read('website.name'),
      '##NAME##' => ucfirst($first_name) . ' ' . ucfirst($last_name),
      '##SIZE##' => $seating,
      '##link##' => $link,
      '##APPSTORE##' => Configure::read('Applink'),
      '##RESNAME##' => $resturant_name['Restaurant']['name'],
      '##DATE##' => $dat,
      '##YEAR_MAIL##' => $this->year_mail,
      '##TIME##' => date('h:i A', strtotime($reservation['Offer']['offerTime'])),
      '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true)
    );
    $this->loadmodel('Recipient');
    $rec            = $this->Recipient->find('all', array(
      'conditions' => array(
        'resId' => $resturant_name['Restaurant']['id']
      )
    ));
    // $recipient_mail = 'reservations@tablesavvy.com';
    $recipient_mail = 'saravananviswa@farshore.com';
    foreach ($rec as $recipient) {
      $recipient_mail = $recipient_mail . ',' . $recipient["Recipient"]["email"];
    }
    $sub                      = "Reservation Cancellation via " . Configure::read('website.name');
    $this->Email->from        = Configure::read('website.name') . ' <support@tablesavvy.com>';
    $this->Email->replyTo     = 'support@tablesavvy.com';
    $this->Email->cc          = $recipient_mail;
    $this->Email->readReceipt = 'saravananviswa@farshore.com';
    $this->Email->to          = $res_email['User']['email'];
    $this->Email->subject     = $sub;
    $this->Email->sendAs      = ($email['is_html']) ? 'html' : 'text';
    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
  }
  function share($res_name = null)
  {
    $this->set('res_name', $res_name);
    $this->layout = false;
  }
}

?>
