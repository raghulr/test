<?php

/* * ******************************************
 * Controller Name  : MobilesavvyController *
 * Date Of Creation : 12/31/2013            *
 * Created By       : SIVARAJ.S             *
 * ****************************************** */
// error_reporting(0);
class MobilesavvyController extends AppController {

    var $name = 'Mobilesavvy';
    var $components = array('Email', 'Nmiapp', 'RequestHandler', 'Auth');
    var $uses = array('User', 'EmailTemplate', 'Userlocation', 'Reservation', 'Offer', 'Restaurant', 'Alert', 'Contact', 'City');

    public function beforeFilter() {
        $this->Auth->allow('home', 'login','getLatLong', 'getUserDetails', 'signup', 'userLocation', 'userFavourites', 'facebookAuth', 'filterOptions', 'getRestaurantDetails', 'restaurantSearch', 'searchByName', 'forgetPassword', 'saveCardDetails', 'reserveTable', 'cancelReservation', 'changeReservation', 'getOffers', 'sendInvitation', 'allRestaurants', 'deleteUserFavourites', 'autoComplete', 'contactus', 'updatelatlng', 'deleteCardDetails', 'serverCurrentTime', 'saveUserDetails', 'storeCardDetails', 'androidversion', 'getCardDetails','test');
        //Configure::write('debug',2);
        Configure::write('website.id', 1);
        Configure::write('website.name', 'TableSavvy');
        Configure::write('website.slug', 'tablesavvy');
        Configure::write('website.logo', Router::url('/theme/tablesavvy/images/TS_email_logo.png', true));
        Configure::write('website.city_id', 1);
        Configure::write('website.fbId', '640376349312009');
        Configure::write('website.fb_secret_key', '88c51a4932dc0557b6ff20531bfa8aea');
        Configure::write('website.facebook', 'http://www.facebook.com/TableSAVVY');
        Configure::write('website.twitter', 'http://twitter.com/#!/TableSAVVY');
    }

    /*     * ***********************************************************
     * Action Name      : home                                   *
     * Date Of Creation : 12/31/2013                             *
     * Purpose of action: To send response for Homepage Request. *
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    function home() {
        $time_by_testaurant = $this->get_restid();
        $this->layout = false;
        $this->RequestHandler->respondAs('json');
        $search_condition['Restaurant.id'] = $time_by_testaurant;
        $limit = 25;
        $lat = !empty($this->params['form']['latitude']) ? $this->params['form']['latitude'] : '';
        $lng = !empty($this->params['form']['longitude']) ? $this->params['form']['longitude'] : '';
        //$miles = 5;
        if (!empty($lat) && !empty($lng)) {
            //for calculating nearby location distance (in miles)
            $this->Restaurant->virtualFields = array(
                'distance' => "( 6371 * acos( cos( radians($lat) ) * cos( radians( Restaurant.latitude ) ) * cos( radians( Restaurant.longitude ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( Restaurant.latitude ) ) ) )"
                    //'distance' => "ROUND(SQRT( POW(69.1 * (Restaurant.latitude -$lat), 2) + POW(69.1 * ( $lng - Restaurant.longitude) * COS(Restaurant.latitude/ 57.3), 2))* 0.621371192)"			
            );

            $this->paginate = array('conditions' => array('Restaurant.approved' => 1, $search_condition),
                'fields' => array('Restaurant.id',
                    'Restaurant.name',
                    'Restaurant.neighborhoodId',
                    'Restaurant.city',
                    'Restaurant.logo',
                    //'Restaurant.distance',
                    'Restaurant.latitude',
                    'Restaurant.longitude',
                    'Restaurant.address',
                    'Restaurant.startTime',
                    'Restaurant.endTime',
                    'Restaurant.short_description',
                    'Restaurant.long_description',
                    'Restaurant.slug_name'),
                'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                    'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
                'order' => array('Restaurant.distance ASC'), //'Restaurant.rank DESC', 'Restaurant.name'															
                'limit' => $limit,
                'recursive' => 2);
        } else {
            $this->paginate = array('conditions' => array('Restaurant.approved' => 1, $search_condition),
                'fields' => array('Restaurant.id',
                    'Restaurant.name',
                    'Restaurant.neighborhoodId',
                    'Restaurant.city',
                    'Restaurant.logo',
                    //'Restaurant.distance',
                    'Restaurant.latitude',
                    'Restaurant.longitude',
                    'Restaurant.address',
                    'Restaurant.startTime',
                    'Restaurant.endTime',
                    'Restaurant.short_description',
                    'Restaurant.long_description',
                    'Restaurant.slug_name'),
                'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                    'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
                'order' => array('Restaurant.rank DESC', 'Restaurant.name'),
                'limit' => $limit,
                'recursive' => 2);
        }

        $restaurants = $this->paginate('Restaurant');
        $res_no = 0;
        $result = array();
        if (!empty($restaurants)) {
            foreach ($restaurants as $restaurant) {
                $rest = $this->orderRestaurantDetails($restaurant);
                $result[$res_no]['Restaurant'] = $rest['Restaurant'];
                $result[$res_no]['Slideshow'] = $rest['Slideshow'];
                /*                 * *** For fetching offers for todat and arranging in a desired order **** */
                $resoffers = $this->get_resoffer($restaurant['Restaurant']['id']);
                $restaurant['Offer'] = array();
                if (!empty($resoffers)) {
                    $offerSeating = array_keys($resoffers);
                    $offerindex = 0;
                    foreach ($resoffers as $seatingoffers) {
                        if ($offerindex == 0) {
                            $seatIndex = 0;
                            $restaurant['Offer']['size'] = $offerSeating[$offerindex];
                            foreach ($seatingoffers as $seatingoffer => $value) {
                                $restaurant['Offer']['list'][$seatIndex]['offerKey'] = $seatingoffer;
                                $restaurant['Offer']['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value));
                                $seatIndex++;
                            }
                        }
                        $offerindex++;
                    }
                }
                $result[$res_no]['Offer'] = $restaurant['Offer'];
                $res_no++;
            }
            $value = 1;
        } else {
            $value = 0;
            $response['message'] = 'No more available restaurant';
        }

        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ***********************************************************
     * Action Name      : getRestaurantDetails                   *
     * Date Of Creation : 1/7/2014                               *
     * Purpose of action: To get restaurant details into array.  *
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    public function getRestaurantDetails() {
        $restaurantId = !empty($this->params['form']['restaurantId']) ? $this->params['form']['restaurantId'] : '';
        if (!empty($restaurantId)) {
            $this->loadModel('Restaurant');
            /*             * *** To get details of siingel restaurant **** */
            $restaurant = $this->Restaurant->find('all', array('conditions' => array('Restaurant.approved' => 1,
                    'Restaurant.id' => $restaurantId),
                'fields' => array('Restaurant.id',
                    'Restaurant.name',
                    'Restaurant.neighborhoodId',
                    'Restaurant.city',
                    'Restaurant.logo',
                    'Restaurant.address',
                    'Restaurant.latitude',
                    'Restaurant.longitude',
                    'Restaurant.phone',
                    'Restaurant.startTime',
                    'Restaurant.endTime',
                    'Restaurant.short_description',
                    'Restaurant.long_description',
                    'Restaurant.slug_name'),
                'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                    'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
                'recursive' => 2));
            if (!empty($restaurant)) {
                $value = 1;
                $rest = $this->orderRestaurantDetails($restaurant[0]);
                $old_number = str_replace(array(' ', '(', ')', '-', '{', '}', '+'), "", $rest['Restaurant']['phone']);
                $new_number = sprintf("(%s)-%s-%s", substr($old_number, 0, 3), substr($old_number, 3, 3), substr($old_number, 6));
                $rest['Restaurant']['phone'] = $new_number;
                $result[0]['Restaurant'] = $rest['Restaurant'];
                $result[0]['Slideshow'] = $rest['Slideshow'];
                /*                 * *** For fetching offers for todat and arranging in a desired order **** */
                $resoffers = $this->get_resoffer($restaurantId);
                $restaurant['Offer'] = array();
                if (!empty($resoffers)) {
                    $offerSeating = array_keys($resoffers);
                    $offerindex = 0;
                    foreach ($resoffers as $seatingoffers) {
                        if ($offerindex == 0) {
                            $seatIndex = 0;
                            $restaurant['Offer']['size'] = $offerSeating[$offerindex];
                            foreach ($seatingoffers as $seatingoffer => $value) {
                                $restaurant['Offer']['list'][$seatIndex]['offerKey'] = $seatingoffer;
                                $restaurant['Offer']['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value));
                                $seatIndex++;
                            }
                        }
                        $offerindex++;
                    }
                }
                $value = 1;
                $result[0]['Offer'] = $restaurant['Offer'];
            } else {
                $value = 0;
                $result = 'No data found';
            }
        } else {
            $value = 0;
            $result = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ***********************************************************
     * Action Name      : orderRestaurantDetails                 *
     * Date Of Creation : 1/7/2014                               *
     * Purpose of action: To order restaurant details into array.*
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    public function orderRestaurantDetails($restaurant) {
        /*         * *** To set full path of a restaurant logo **** */
        if (!empty($restaurant['Restaurant']['logo']))
            $restaurant['Restaurant']['logo'] = 'https://www.tablesavvy.com/img/medium/' . $restaurant['Restaurant']['logo'];
        else
            $restaurant['Restaurant']['logo'] = 'https://www.tablesavvy.com/images/noImage.png';
        /*         * *** To set full path of a restaurant logo **** */
        if (!empty($restaurant['Restaurant']['neighborhoodId'])) {
            $this->loadModel('Neighborhood');
            $neighborhood_name = $this->Neighborhood->find('first', array('conditions' => array('Neighborhood.id' => $restaurant['Restaurant']['neighborhoodId']),
                'fields' => array('Neighborhood.name')));
            $restaurant['Restaurant']['neighborhoodName'] = $neighborhood_name['Neighborhood']['name'];
        } else {
            $restaurant['Restaurant']['neighborhoodName'] = '';
        }
        /*         * *** To add latitude and Longitude of restaurant **** */
        /* if(!empty($restaurant['Restaurant']['address']))
          $restaurant['Restaurant']['LatLong']=$this->getLatLong($restaurant['Restaurant']['address']);
          else */
        $restaurant['Restaurant']['LatLong'] = '';
        /*         * *** To add cuisine of a restaurant **** */
        if (!empty($restaurant['Restaurantcuisine'][0]['Cuisine']['name']))
            $restaurant['Restaurant']['Cuisine'] = $restaurant['Restaurantcuisine'][0]['Cuisine']['name'];
        else
            $restaurant['Restaurant']['Cuisine'] = 'Nil';
        /*         * *** To set full path for restaurant slideshow images **** */
        $slideshows = $restaurant['Slideshow'];
        $restaurant['Slideshow'] = array();
        foreach ($slideshows as $slideshow) {
            $sliderImageName = $slideshow['path'];
            $slideshow['path'] = 'http://50.57.161.52/img/original/' . $sliderImageName;
            $slideshow['small'] = 'http://50.57.161.52/img/small/' . $sliderImageName;
            $slideshow['medium'] = 'http://50.57.161.52/img/medium/' . $sliderImageName;
            $slideshow['big'] = 'http://50.57.161.52/img/big/' . $sliderImageName;
            $slideshow['application'] = 'http://50.57.161.52/img/TSapplication/' . $sliderImageName;
            $restaurant['Slideshow'][] = $slideshow;
        }
        return $restaurant;
    }

    /*     * ***********************************************************
     * Action Name      : get_restid                             *
     * Date Of Creation : 12/31/2013                             *
     * Purpose of action: To get offer available restaurant id.  *
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    public function get_restid() {
        $offer_date = date('Y-m-d');
        $time = date('H:i:s');
        $reservedate = $offer_date . ' 00:00:00';
        $this->loadmodel('Reservation');
        $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1, 'Reservation.trasaction_time >' => $reservedate), 'fields' => array('Reservation.offerId')));
        $this->loadmodel('Offer');
        $party = array(8, 7, 6, 5, 4, 3, 2);
        $time_by_testaurant = array();
        $search_condition = array();
        $time_by_testaurant = $this->Offer->find('list', array('conditions' => array('Offer.offerDate' => $offer_date,
                'Offer.offerTime >=' => $time,
                'Offer.seating' => $party,
                'NOT' => array('Offer.id' => $reser_id)),
            'fields' => array('Offer.restaurantId'),
            'group' => 'Offer.restaurantId',
            'recursive' => -1));
        return $time_by_testaurant;
    }

    /*     * *****************************************************
     * Action Name      : get_resoffer                     *
     * Date Of Creation : 12/31/2013                       *
     * Purpose of action: To get available offer details.  *
     * Created By       : SIVARAJ.S                        *
     * ***************************************************** */

    public function get_resoffer($resid) {
        $offer_date = date('Y-m-d');
        $time = date('H:i:s');
        $reservedate = $offer_date . ' 00:00:00';
        $this->loadmodel('Reservation');
        $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1, 'Reservation.trasaction_time >' => $reservedate), 'fields' => array('Reservation.offerId')));
        $this->loadmodel('Offer');
        $party = array(8, 7, 6, 5, 4, 3, 2);
        $time_by_testaurant = array();
        $search_condition = array();
        $time_by_testaurant = $this->Offer->find('list', array('conditions' => array('Offer.offerDate' => $offer_date,
                'Offer.offerTime >=' => $time,
                'Offer.seating' => $party,
                'Offer.restaurantId' => $resid,
                'NOT' => array('Offer.id' => $reser_id)),
            'fields' => array('Offer.id', 'Offer.offerTime', 'Offer.seating'),
            'order' => array('Offer.seating', 'Offer.offerTime'),
            'group' => array('Offer.seating', 'Offer.offerTime'),
            'recursive' => -1));
        return $time_by_testaurant;
    }

    /*     * *****************************************************
     * Action Name      : get_resoffer                     *
     * Date Of Creation : 12/31/2013                       *
     * Purpose of action: To get available offer details.  *
     * Created By       : SIVARAJ.S                        *
     * ***************************************************** */

    public function getOffers() {
        $restaurantId = !empty($this->params['form']['restaurantId']) ? $this->params['form']['restaurantId'] : '';
        $selectedSize = !empty($this->params['form']['size']) ? $this->params['form']['size'] : '';
        $offerId = isset($this->params['form']['offerId']) ? $this->params['form']['offerId'] : '';
        if (!empty($restaurantId)) {
            $searchBySizes = array('2' => 2, '3' => 4, '4' => 4, '5' => 6, '6' => 6, '7' => 8, '8' => 8);
            $size = $searchBySizes[$selectedSize];
            $offer_date = date('Y-m-d');
            $time = date('H:i:s');
            $reservedate = $offer_date . ' 00:00:00';
            $this->loadmodel('Reservation');
            $this->loadmodel('Offer');
            if (!empty($offerId)) {
                $reservedOffer = $this->Offer->query('select * from offers where id = ' . $offerId);
                if ($reservedOffer[0]['offers']['seating_custom'] != 0)
                    $reservedSize = $reservedOffer[0]['offers']['seating_custom'];
                else
                    $reservedSize = $reservedOffer[0]['offers']['seating'];
                if ($reservedSize == $selectedSize)
                    $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1,
                            'Reservation.trasaction_time >' => $reservedate),
                        'fields' => array('Reservation.offerId')));
                else
                    $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1,
                            'Reservation.trasaction_time >' => $reservedate,
                            'NOT' => array('Reservation.offerid' => $offerId)),
                        'fields' => array('Reservation.offerId')));
            }else {
                $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1,
                        'Reservation.trasaction_time >' => $reservedate),
                    'fields' => array('Reservation.offerId')));
            }
            $resoffers = $this->Offer->find('list', array('conditions' => array('Offer.offerDate' => $offer_date,
                    'Offer.offerTime >=' => $time,
                    'Offer.seating' => $size,
                    'Offer.restaurantId' => $restaurantId,
                    'NOT' => array('Offer.id' => $reser_id)),
                'fields' => array('Offer.id', 'Offer.offerTime', 'Offer.seating'),
                'order' => array('Offer.seating', 'Offer.offerTime'),
                'group' => array('Offer.seating', 'Offer.offerTime'),
                'recursive' => -1));
            $restaurant['Offer'] = array();
            if (!empty($resoffers)) {
                $offerSeating = array_keys($resoffers);
                $offerindex = 0;
                foreach ($resoffers as $seatingoffers) {
                    $seatIndex = 0;
                    $restaurant['Offer'][$offerindex]['size'] = $selectedSize;
                    foreach ($seatingoffers as $seatingoffer => $value) {
                        $restaurant['Offer'][$offerindex]['list'][$seatIndex]['offerKey'] = $seatingoffer;
                        $restaurant['Offer'][$offerindex]['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value));
                        $seatIndex++;
                    }
                    $offerindex++;
                }
                $value = 1;
                $result['Offer'] = $restaurant['Offer'];
            } else {
                $value = 0;
                $result = 'We are sorry but there is no table available for that selected party size.';
            }
        } else {
            $value = '0';
            $result = 'We are sorry but there is no table available for that selected party size.';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * *************************************************************
     * Action Name      : login                                    *
     * Date Of Creation : 12/31/2013                               *
     * Purpose of action: To get check user details for user login.*
     * Created By       : SIVARAJ.S                                *
     * ************************************************************* */

    public function login() {
        $email = !empty($this->params['form']['email']) ? $this->params['form']['email'] : '';
        $password = !empty($this->params['form']['password']) ? $this->params['form']['password'] : '';
        $password = $this->Auth->password($password);
        $user = array();
        $msg = array();
        $result = array();
        if (!empty($email)) {
            $this->loadModel('User');
            $user = $this->User->find('first', array('conditions' => array('User.email' => $email,
                    'User.password' => $password),
                'contain' => array('Reservation' => array('Offer')),
                'recursive' => 2));
            if (empty($user)) {
                $value = '0';
                $message = 'Email or password does not match TableSavvy records. Please sign up for a new account.';
            } else {
                $value = '1';
                $device_details['devicetoken'] = !empty($this->params['form']['Device_Token']) ? $this->params['form']['Device_Token'] : '';
                $device_details['android_version'] = !empty($this->params['form']['android_version']) ? $this->params['form']['android_version'] : '';
                $device_details['ios_version'] = !empty($this->params['form']['ios_version']) ? $this->params['form']['ios_version'] : '';
                $device_details['source'] = !empty($this->params['form']['source']) ? $this->params['form']['source'] : 'iPhone';
                $this->User->id = $user['User']['id'];
                $this->User->save($device_details);
                $result = $this->getUserDetails($user['User']['id']);
                $message = "Welcome back " . $user['User']['firstName'] . "!";
            }
        } else {
            $value = '0';
            $message = 'Email or password does not match TableSavvy records. Please sign up for a new account.';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * ****************************************************
     * Action Name      : getUserDetails                  *
     * Date Of Creation : 1/3/2014                        *
     * Purpose of action: To get user details to display. *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function getUserDetails($userId = null) {
        if ($userId == null) {
            $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';

            $send_response = 'display';
        } else {
            $send_response = 'return';
        }
        if (!empty($userId)) {
            $result = array();
            $this->loadModel('Reservation');
            $user = $this->User->find('first', array('conditions' => array('User.id' => $userId),
                'recursive' => -1));
            $reservations = $this->Reservation->find('all', array('conditions' => array('Reservation.userId' => $userId, 'NOT' => array('Reservation.approved' => 0)),
                'contain' => array('Offer' => array('order' => array('offerDate DESC')))));
            $user_devicetoken = !empty($this->params['form']['Device_Token']) ? $this->params['form']['Device_Token'] : '';
            $this->User->id = $user['User']['id'];
            $this->User->saveField('devicetoken', $user_devicetoken);
            array_walk_recursive($user['User'], function(& $item, $key) {
                if ($item === null) {
                    $item = '';
                }
            });
            $user['User']['cardExpiaryMonth'] = $user['User']['cardExpiaryYear'] = $user['User']['nameOnCard'] = '';
            if (!empty($user['User']['billingKey'])) {
                $APIresponse = $this->Nmiapp->_getCardDetails($user['User']['billingKey']);
                $cardDetails = json_decode($APIresponse);
                $ccExpDate = $cardDetails->customer_vault->customer->cc_exp;
                $ccFirstName = $cardDetails->customer_vault->customer->first_name;
                $ccLastName = $cardDetails->customer_vault->customer->last_name;
                $user['User']['nameOnCard'] = $ccFirstName . ' ' . $ccLastName;
                $user['User']['cardExpiaryMonth'] = substr($ccExpDate, 0, 2);
                $user['User']['cardExpiaryYear'] = substr($ccExpDate, 2);
            }
            $result[0]['User'] = $user['User'];
            $result[0]['Reservation']['UpcomingReservation'] = array();
            $result[0]['Reservation']['PastReservation'] = array();
            if (!empty($reservations)) {
                $this->loadModel('Restaurant');
                $restaurant_names = $this->Restaurant->find('list', array('fields' => array('Restaurant.name')));
                $result[0]['Reservation'] = array();
                $result[0]['Reservation']['UpcomingReservation'] = array();
                $result[0]['Reservation']['PastReservation'] = array();
                foreach ($reservations as $reservation) {
                    $upcoming = array();
                    $past = array();
                    /*                     * *** To list the upcoing and past reservation details **** */
                    if (!empty($reservation['Offer']['id'])) {
                        if ($reservation['Offer']['offerDate'] == date('Y-m-d') && $reservation['Reservation']['approved'] == 1 && $reservation['Offer']['offerTime'] >= date('H:i:s')) {
                            $upcoming['reservationId'] = $reservation['Reservation']['id'];
                            $upcoming['restaurantId'] = $reservation['Offer']['restaurantId'];
                            $upcoming['offerId'] = $reservation['Offer']['id'];
                            $upcoming['restaurantName'] = $restaurant_names[$reservation['Offer']['restaurantId']];
                            $upcoming['offerDateTime'] = date('l, M d,', strtotime($reservation['Offer']['offerDate'])) . ' ' . date('h:i a', strtotime($reservation['Offer']['offerTime']));
                            if ($reservation['Offer']['seating_custom'] != 0)
                                $upcoming['seating'] = $reservation['Offer']['seating_custom'];
                            else
                                $upcoming['seating'] = $reservation['Offer']['seating'];
                            $result[0]['Reservation']['UpcomingReservation'][] = $upcoming;
                        }else {
                            $past['restaurantId'] = $reservation['Offer']['restaurantId'];
                            $past['restaurantName'] = $restaurant_names[$reservation['Offer']['restaurantId']];
                            $past['offerDateTime'] = date('l, M d,', strtotime($reservation['Offer']['offerDate'])) . ' ' . date('h:i a', strtotime($reservation['Offer']['offerTime']));
                            if ($reservation['Offer']['seating_custom'] != 0)
                                $past['seating'] = $reservation['Offer']['seating_custom'];
                            else
                                $past['seating'] = $reservation['Offer']['seating'];
                            $past['reservationStatus'] = $reservation['Reservation']['approved'];
                            $result[0]['Reservation']['PastReservation'][] = $past;
                        }
                    }
                }
            }
            if ($send_response == 'return')
                return $result;
            else {
                $response['success'] = 1;
                $response['result'] = $result;
                $this->set('response', $response);
            }
        }
    }

    /*     * ****************************************************
     * Action Name      : getLatLong                      *
     * Date Of Creation : 1/4/2014                        *
     * Purpose of action: To get latitude and longitude.  *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    function getLatLong($address) {
        $fget_address = str_replace(',', '', $address);
        $f2get_address = str_replace('.', '', $fget_address);
        $_address = str_replace(" ", "+", $f2get_address);
        //$address = str_replace(" ", "+", $address);
        $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$_address&sensor=false");
        $json = json_decode($json);
        if (!empty($json->{'results'}[0])) {
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            return $lat . ',' . $long;
        } else {
            return '';
        }
    }

    /*     * ****************************************************
     * Action Name      : signup                          *
     * Date Of Creation : 1/4/2014                        *
     * Purpose of action: To save user details on signup. *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function signup() {

        $user['User']['email'] = !empty($this->params['form']['email']) ? $this->params['form']['email'] : '';
        $user['User']['source'] = !empty($this->params['form']['source']) ? $this->params['form']['source'] : '';
        $password = !empty($this->params['form']['password']) ? $this->params['form']['password'] : '';
        $saveCard = !empty($this->params['form']['saveCard']) ? $this->params['form']['saveCard'] : '';
        $user['User']['password'] = $this->Auth->password($password);
        $user['User']['account_type'] = 3;
        $user['User']['approved'] = 1;
        $user['User']['email_subscription'] = 1;
        $user['User']['fb_signup'] = 2;
        $user['User']['from'] = !empty($this->params['form']['from']) ? $this->params['form']['from'] : 'iPhone';
        $user['User']['devicetoken'] = !empty($this->params['form']['Device_Token']) ? $this->params['form']['Device_Token'] : '';
        $isCreditAvailable = $this->checkCreditLimit();
        if ($isCreditAvailable['User']['available']) {
            $user['User']['user_amount'] = 5;
            $user['User']['user_credit'] = $isCreditAvailable['User']['user_credit'];
            $user['User']['used_credit'] = $isCreditAvailable['User']['used_credit'] + 1;
            $this->User->updateAll(array('User.user_credit' => $isCreditAvailable['User']['user_credit'], 'User.used_credit' => $isCreditAvailable['User']['used_credit'] + 1));
        }
        $result = array();
        $message = '';
        $this->loadModel('User');
        $this->User->set($user);
        $userwelcome = 'Hi Customer,';
        /*         * *** To save credit card details (if available) **** */
        if ($this->User->validates()) {
            if ($this->User->save($user['User'], false)) {
                $userId = $this->User->getLastInsertID();
                /*                 * *** To send signup confirmation mail to user **** */
                $emailTemplate = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' New User');
                $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
                    '##SITE_LOGO##' => Configure::read('website.logo'),
                    '##FACEBOOK##' => Configure::read('website.facebook'),
                    '##TWITTER##' => Configure::read('website.twitter'),
                    '##NAME##' => ucfirst($userwelcome),
                    '##SITE_NAME##' => Configure::read('website.name'),
                    '##SIGNUP_IP##' => $this->RequestHandler->getClientIP(),
                    '##EMAIL##' => $user['User']['email'],
                    '##FROM_EMAIL##' => 'support@tablesavvy.com',
                    '##APPSTORE##' => Configure::read('Applink'),
                    '##YEAR_MAIL##' => $this->year_mail,
                    '##SITE_NEW_LINK##' => Router::url('/home', true));
                $this->Email->from = ($emailTemplate['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $emailTemplate['from'];
                $this->Email->replyTo = ($emailTemplate['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $emailTemplate['reply_to'];
                $this->Email->to = $user['User']['email'];
                $this->Email->subject = strtr($emailTemplate['subject'], $emailFindReplace);
                $this->Email->sendAs = ($emailTemplate['is_html']) ? 'html' : 'text';
                $this->Email->send(strtr($emailTemplate['email_content'], $emailFindReplace));
                $value = 1;
                $result = $userId;
                $message = "Thank you for signing up for TableSavvy! We've added a $5 credit to your account, so your first reservation is on us!";
            } else {
                $value = 0;
                $message = 'Failed to Register';
            }
        } else {
            $data_error = array_values($this->User->validationErrors);
            $value = 0;
            $message = $data_error[0];
        }

        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * ****************************************************
     * Action Name      : checkCreditLimit                *
     * Date Of Creation : 1/6/2014                        *
     * Purpose of action: To check user credit limit.     *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    function checkCreditLimit() {
        $this->loadModel('User');
        $userCredit['User']['available'] = false;
        $user_credit = $this->User->find('first', array('recursive' => -1));
        if (!empty($user_credit)) {
            $userCredit['User']['user_credit'] = $user_credit_limit = $user_credit['User']['user_credit'];
            $userCredit['User']['used_credit'] = $used_limit = $user_credit['User']['used_credit'];
            if (($user_credit_limit - $used_limit) > 0)
                $userCredit['User']['available'] = true;
        }
        return $userCredit;
    }

    /*     * ****************************************************
     * Action Name      : userLocation                    *
     * Date Of Creation : 1/4/2014                        *
     * Purpose of action: To save user locatio details.   *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function userLocation() {
        $userLocation['Userlocation']['address'] = !empty($this->params['form']['address']) ? $this->params['form']['address'] : '';
        $userLocation['Userlocation']['city'] = !empty($this->params['form']['city']) ? $this->params['form']['city'] : '';
        $userLocation['Userlocation']['state'] = !empty($this->params['form']['state']) ? $this->params['form']['state'] : '';
        $userLocation['Userlocation']['zipcode'] = !empty($this->params['form']['zipcode']) ? $this->params['form']['zipcode'] : '';
        $requestFor = !empty($this->params['form']['requestFor']) ? $this->params['form']['requestFor'] : '';
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $userName = '';
        $result = array();
        /*         * *** To save user location details (param requestFor == save)**** */
        if ($requestFor == 'save') {
            if (!empty($userId)) {
                $this->loadModel('User');
                $user = $this->User->find('first', array('conditions' => array('id' => $userId), 'fields' => array('firstName')));
                $userName = $user['User']['firstName'];
            }
            if (!empty($userName)) {
                $userLocation['Userlocation']['userId'] = $userId;
                $userLocation['Userlocation']['name'] = $userName;
                $this->loadModel('Userlocation');
                $locationExists = $this->Userlocation->find('first', array('conditions' => array('Userlocation.userId' => $userId),
                    'fields' => array('Userlocation.id')));
                if (!empty($locationExists)) {
                    $userLocation['Userlocation']['id'] = $locationExists['Userlocation']['id'];
                }
                if ($this->Userlocation->save($userLocation['Userlocation'], false)) {
                    $location = $this->Userlocation->find('first', array('conditions' => array('Userlocation.userId' => $userId),
                        'fields' => array('Userlocation.id',
                            'Userlocation.address',
                            'Userlocation.city',
                            'Userlocation.state',
                            'Userlocation.zipcode'),
                        'order' => 'id DESC',));
                    $value = 1;
                    $result = $location;
                } else {
                    $value = 0;
                    $result = 'Failed to save';
                }
            } else {
                $value = 0;
                $result = 'User does not exist';
            }
        }/*         * *** To find user location details (param requestFor == find)**** */ elseif ($requestFor == 'find') {
            $this->loadModel('Userlocation');
            $location = $this->Userlocation->find('first', array('conditions' => array('Userlocation.userId' => $userId),
                'fields' => array('Userlocation.id',
                    'Userlocation.address',
                    'Userlocation.city',
                    'Userlocation.state',
                    'Userlocation.zipcode'),
                'order' => 'id DESC',));
            if (!empty($location)) {
                $value = 1;
                $result[0] = $location;
            } else {
                $value = 0;
                $result = 'No data found';
            }
        } else {
            $value = 0;
            $result = 'No request found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ****************************************************
     * Action Name      : addFavorites                    *
     * Date Of Creation : 1/6/2014                        *
     * Purpose of action: To save favourite restaurants.  *
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function userFavourites() {
        $alerts['Alert']['userId'] = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $favoritRestaurant = !empty($this->params['form']['restaurantName']) ? $this->params['form']['restaurantName'] : '';
        $alerts['Alert']['sitename'] = 'TableSAVVY';
        $requestFor = !empty($this->params['form']['requestFor']) ? $this->params['form']['requestFor'] : '';
        $result = array();
        $message = '';
        if (!empty($alerts['Alert']['userId'])) {
            $this->loadModel('Restaurant');
            $restaurantList = $this->Restaurant->find('list', array('conditions' => array('Restaurant.approved' => 1),
                'fields' => 'Restaurant.name'));
            $approvedRestaurantList = $this->Restaurant->find('list', array('conditions' => array('Restaurant.approved' => 1),
                'fields' => 'Restaurant.id'));
            $this->loadModel('Alert');
            /*             * *** To save user favourit details (param requestFor == save)**** */
            if ($requestFor == 'save') {
                $alerts['Alert']['restaurantId'] = !empty($this->params['form']['restaurantId']) ? $this->params['form']['restaurantId'] : '';
                $alerts['Alert']['sunday'] = $this->params['form']['sunday'];
                $alerts['Alert']['monday'] = $this->params['form']['monday'];
                $alerts['Alert']['tuesday'] = $this->params['form']['tuesday'];
                $alerts['Alert']['wednesday'] = $this->params['form']['wednesday'];
                $alerts['Alert']['thursday'] = $this->params['form']['thursday'];
                $alerts['Alert']['friday'] = $this->params['form']['friday'];
                $alerts['Alert']['saturday'] = $this->params['form']['saturday'];
                $alerts['Alert']['from'] = 'App';
                $checkAlert = $this->Alert->find('first', array('conditions' => array('Alert.userId' => $alerts['Alert']['userId'],
                        'Alert.restaurantId' => $alerts['Alert']['restaurantId'],
                        'Alert.sitename' => 'TableSAVVY'),
                    'contain' => array('Restaurant')));
                if (!empty($checkAlert)) {
                    $alerts['Alert']['id'] = $checkAlert['Alert']['id'];
                } else {
                    $this->Alert->create();
                }
                if ($this->Alert->save($alerts['Alert'])) {
                    $value = 1;
                    $getUserAlerts = $this->Alert->find('all', array('conditions' => array('Alert.userId' => $alerts['Alert']['userId'],
                            'Alert.sitename' => 'TableSAVVY',
                            'Alert.restaurantId' => $approvedRestaurantList),
                        'recursive' => -1));
                    $getUserAlerts = Set::classicExtract($getUserAlerts, '{n}.Alert');
                    if (!empty($getUserAlerts)) {
                        for ($gua = 0; $gua < count($getUserAlerts); $gua++) {
                            $getUserAlerts[$gua]['restaurantName'] = $restaurantList[$getUserAlerts[$gua]['restaurantId']];
                        }
                        $result[0]['favourites'] = $getUserAlerts;
                    }
                    $message = 'You are now following ' . $favoritRestaurant . '.';
                } else {
                    $value = 0;
                    $message = 'Sorry, Try again to follow ' . $favoritRestaurant . '.';
                }
            }/*             * *** To find user favourit details (param requestFor == find)**** */ elseif ($requestFor == 'find') {
                $getUserAlerts = $this->Alert->find('all', array('conditions' => array('Alert.userId' => $alerts['Alert']['userId'],
                        'Alert.sitename' => 'TableSAVVY',
                        'Alert.restaurantId' => $approvedRestaurantList),
                    'recursive' => -1));
                $getUserAlerts = Set::classicExtract($getUserAlerts, '{n}.Alert');
                if (!empty($getUserAlerts)) {
                    $value = 1;
                    for ($gua = 0; $gua < count($getUserAlerts); $gua++) {
                        if (isset($restaurantList[$getUserAlerts[$gua]['restaurantId']]))
                            $getUserAlerts[$gua]['restaurantName'] = $restaurantList[$getUserAlerts[$gua]['restaurantId']];
                    }
                    $result[0]['favourites'] = $getUserAlerts;
                }else {
                    $value = 0;
                    $message = 'No favourit found';
                }
            }
        } else {
            $value = 0;
            $message = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * ****************************************************
     * Action Name      : deleteUserFavourites            *
     * Date Of Creation : 2/13/2014                       *
     * Purpose of action: To delete favourite restaurants.*
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function deleteUserFavourites() {
        $favoriteId = !empty($this->params['form']['favoriteId']) ? $this->params['form']['favoriteId'] : '';
        $favoritRestaurant = !empty($this->params['form']['restaurantName']) ? $this->params['form']['restaurantName'] : '';
        $result = array();
        $message = '';
        if (!empty($favoriteId)) {
            $this->loadModel('Alert');
            /*             * *** To delete user favourit details **** */
            $this->Alert->id = $favoriteId;
            if ($this->Alert->delete()) {
                $value = 1;
                $response['message'] = 'You are no longer following ' . $favoritRestaurant . '.';
            } else {
                $value = 0;
                $response['message'] = 'Failed to remove restaurant from favorite list';
            }
        } else {
            $value = 0;
            $response['message'] = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    
    /*     * ****************************************************
     * Action Name      : facebookAuth                    *
     * Date Of Creation : 1/7/2014                        *
     * Purpose of action: To signup or login via Facebook.*
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function facebookAuth() {
        $user['User']['firstName'] = !empty($this->params['form']['firstName']) ? $this->params['form']['firstName'] : '';
        $user['User']['lastName'] = !empty($this->params['form']['lastName']) ? $this->params['form']['lastName'] : '';
        $user['User']['email'] = !empty($this->params['form']['email']) ? $this->params['form']['email'] : '';
        $user['User']['phone'] = !empty($this->params['form']['phone']) ? $this->params['form']['phone'] : NULL;
        $user['User']['facebookId'] = !empty($this->params['form']['facebookId']) ? $this->params['form']['facebookId'] : '';
        $user['User']['source'] = !empty($this->params['form']['source']) ? $this->params['form']['source'] : '';
        $newPassword = $this->generateRandomString();
        $user['User']['password'] = $this->Auth->password($newPassword);
        $user['User']['new_passoword'] = $newPassword;
        $user['User']['account_type'] = 3;
        $user['User']['approved'] = 1;
        $user['User']['email_subscription'] = 1;
        $user['User']['fb_signup'] = 1;
        $user['User']['from'] = !empty($this->params['form']['from']) ? $this->params['form']['from'] : 'iPhone';
        $user['User']['devicetoken'] = !empty($this->params['form']['Device_Token']) ? $this->params['form']['Device_Token'] : '';
        $isCreditAvailable = $this->checkCreditLimit();
        if ($isCreditAvailable['User']['available']) {
            $user['User']['user_amount'] = 5;
            $user['User']['user_credit'] = $isCreditAvailable['User']['user_credit'];
            $user['User']['used_credit'] = $isCreditAvailable['User']['used_credit'] + 1;
            $this->User->updateAll(array('User.user_credit' => $isCreditAvailable['User']['user_credit'], 'User.used_credit' => $isCreditAvailable['User']['used_credit'] + 1));
        }
        $result = array();
        if (!empty($this->params['form']['facebookId'])) {
            $this->loadModel('User');
            $userExists = $this->User->find('first', array('conditions' => array('User.email' => $user['User']['email']),
                'recursive' => -1));
            //$userExists=$this->User->find('first',array('conditions'=>array('User.facebookId'=>$user['User']['facebookId']),
            //'recursive'=>-1));
            if (empty($userExists)) {
                if ($this->User->save($user['User'], false)) {
                    $userId = $this->User->getLastInsertID();
                    $value = 2;
                    $result = $this->getUserDetails($userId);
                    $result[0]['User']['user_exists']=0;
                    $message = "Thank you for signing up for TableSavvy! For reservation purposes, please add your phone number to your account. We've added a $5 credit to your account, so your first reservation is on us!";
                } else {
                    $value = 0;
                    $message = "Sorry!! Failed to login.";
                }
            } else {
                if (!empty($userExists['User']['id'])) {
                    $value = 1;
                    if (empty($userExists['User']['phone']))
                        $value = 2;
                    $result = $this->getUserDetails($userExists['User']['id']);
                    $result[0]['User']['user_exists']=1;
                    $message = "Welcome back " . $userExists['User']['firstName'] . "!";
                }else {
                    $value = 0;
                    $message = 'Account does not exist.';
                }
            }
        } else {
            $value = 0;
            $message = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * *******************************************************
     * Action Name      : filterOptions                      *
     * Date Of Creation : 1/7/2014                           *
     * Purpose of action: To get list of cuisine/neighbohood.*
     * Created By       : SIVARAJ.S                          *
     * ******************************************************* */

    public function filterOptions() {
        $result = array();
        /*         * *** To list neighborhood options **** */
        $this->loadmodel('Neighborhood');
        $neighborhoodList = $this->Neighborhood->find('all', array('fields' => array('id', 'name'),
            'order' => array('name ASC')));
        $result[0]['neighborhoodList'] = Set::ClassicExtract($neighborhoodList, '{n}.Neighborhood');
        /*         * *** To list cuisine options **** */
        $this->loadmodel('Cuisine');
        $cuisineList = $this->Cuisine->find('all', array('fields' => array('id', 'name'),
            'order' => array('name ASC')));
        $result[0]['cuisineList'] = Set::ClassicExtract($cuisineList, '{n}.Cuisine');
        /*         * *** To list time options **** */
        $restr = $this->Restaurant->find('all', array('conditions' => array('Restaurant.approved' => 1,),
            'fields' => array('id', 'min(Restaurant.startTime) as stime', 'max(Restaurant.endTime) as etime'),
            'recursive' => '-1'));
        $dealtime = strtotime('7:00:00');
        $time = strtotime(date('H:i:s', time()));
        $time2 = strtotime(date('H:i:s'));
        $starttime = strtotime('10:00:00'); //strtotime($restr[0][0]['stime']); 
        $endtime = strtotime($restr[0][0]['etime']);
        $diff = abs(ceil(($endtime - $starttime) / 1800));
        $options = array();
        /* if($endtime>$time2){
          if($starttime>$time2){
          $starttime=strtotime($restr[0][0]['stime']);
          }else{
          $minute = date('i');
          $minute1 = ($minute < 30) ? 30 : (($minute >30)? '00':$minute);
          if($minute1==00){
          $hour=date('H');
          $hour=$hour+1;
          $time2= strtotime($hour.':'.$minute1.':'.'00');
          }else
          $time2= strtotime(date('H').':'.$minute1.':'.'00');
          $starttime=$time2;
          }
          } */
        for ($i = 0; $i <= $diff; $i++) {
            if ($starttime <= $endtime) {
                if ($starttime > 0)
                    $optionsval = date('H:i:s', $starttime);
                else
                    $optionsval = '';
                $options[] = date('h:i A', $starttime);
            }
            $starttime = $starttime + 1800;
        }
        $result[0]['timeList'] = $options;
        /*         * *** To list partysize options **** */
        $result[0]['partySize'] = array(2, 3, 4, 5, 6, 7, 8);
        $response['success'] = 1;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * *******************************************************
     * Action Name      : restaurantSearch                   *
     * Date Of Creation : 1/8/2014                           *
     * Purpose of action: To list restaurant search results. *
     * Created By       : SIVARAJ.S                          *
     * ******************************************************* */

    public function restaurantSearch() {
        $value = 0;
        $result = array();
        $timeAvaialbleRestaurant = array();
        $timeNonAvaialbleRestaurant = array();
        $message = '';
        //pr($this->params['form']);exit;
        $searchByNeighborhood = !empty($this->params['form']['neighborhood']) ? $this->params['form']['neighborhood'] : '';
        $searchByCuisine = !empty($this->params['form']['cuisine']) ? $this->params['form']['cuisine'] : '';
        $isTimeAvailable = $searchByTime = !empty($this->params['form']['time']) ? $this->params['form']['time'] : '';
        $searchBySize = !empty($this->params['form']['size']) ? $this->params['form']['size'] : '';
        $searchByName = !empty($this->params['form']['resName']) ? $this->params['form']['resName'] : '';
        $latitude = isset($this->params['form']['latitude']) ? $this->params['form']['latitude'] : '';
        $longitude = isset($this->params['form']['longitude']) ? $this->params['form']['longitude'] : '';
        //echo 'latitude ------'.$latitude;echo 'longitude  ----'. $longitude;
        /*         * *** Set conditions for searching by selecetd time **** */
        $searchBySizes = array('2' => 2, '3' => 4, '4' => 4, '5' => 6, '6' => 6, '7' => 8, '8' => 8);
        $currentdate = date('Y-m-d');
        $conditions['Offer.offerDate'] = $currentdate;
        $current_time = (!empty($searchByTime) && $searchByTime >= date("H:i:s")) ? $searchByTime : date("H:i:s");
        if (!empty($searchByTime)) {
            $selected_start = date('H:i:s', strtotime($searchByTime));
            $selected_start_time = date('H:i:s', strtotime($searchByTime . '-120 MINUTES'));
//            if($selected_start_time < date("H:i:s"))
//                $selected_start_time = date('H:i:s');        
            $selected_end_time = date('H:i:s', strtotime($searchByTime . '+120 MINUTES'));
            if ($selected_end_time < $selected_start_time) {
                $selected_end_time = '23:30:00';
            }
            if ($selected_start != '23:30:00')
                $conditions['Offer.offerTime BETWEEN ? AND ? '] = array($selected_start_time, $selected_end_time);
            else
                $conditions['Offer.offerTime BETWEEN ? AND ? '] = array($selected_start_time, $selected_start);
        }else {
            $conditions['Offer.offerTime >='] = date("H:i:s");
        }
        /*         * *** Set conditions for searching by selecetd party size **** */
        if (!empty($searchBySize))
            $conditions['Offer.seating'] = $searchBySizes[$searchBySize];

        $this->loadmodel('Reservation');
        $reservation_list = $this->Reservation->find('list', array('fields' => array('Reservation.offerId',
                'Reservation.offerId'),
            'conditions' => array('Reservation.approved' => 1,
                'Reservation.trasaction_time >' => $currentdate . ' 00:00:00')));
        $conditions['NOT'] = array('Offer.id' => $reservation_list);
        $this->loadmodel('Offer');
        $restaurant_by_table = $this->Offer->find('list', array('fields' => array('Offer.restaurantId',
                'Offer.restaurantId'),
            'conditions' => $conditions,
            'group' => 'Offer.restaurantId'));
        /*         * *** Set conditions for searching by selecetd party cuisine **** */
        $cuisine_conditions = array();
        $restaurantCuisine = array();
        if (!empty($searchByCuisine)) {
            $cuisine_conditions['Cuisine.id'] = $searchByCuisine;
            $this->loadmodel('Restaurantcuisine');
            $restaurant_by_cuisines = $this->Restaurantcuisine->find('all', array(
                'fields' => array(
                    'Restaurantcuisine.restaurant_id'
                ),
                'conditions' => $cuisine_conditions,
                'group' => 'Restaurantcuisine.restaurant_id'
            ));
            if (!empty($restaurant_by_cuisines)):
                foreach ($restaurant_by_cuisines as $key => $restaurant_by_cuisine) {
                    $id = $restaurant_by_cuisine['Restaurantcuisine']['restaurant_id'];
                    $restaurantCuisine[$id] = $id;
                }
            endif;
        }
        /*         * *** Set conditions for searching by selecetd neighborhood **** */
        $restaurant_condtion = array();
        $restaurant_condtions['Restaurant.approved'] = 1;
        $restaurant_ids = array();
        if (!empty($searchByNeighborhood))
            $restaurant_condtion['Restaurant.neighborhoodId'] = $searchByNeighborhood;
        if (!empty($searchByCuisine) && (!empty($searchByTime) || !empty($searchBySize))) {
            $restaurant_ids = array_intersect($restaurant_by_table, $restaurantCuisine);
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        } elseif (!empty($searchByCuisine)) {
            $restaurant_ids = array_intersect($restaurant_by_table, $restaurantCuisine);
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        } elseif (!empty($searchByTime) || !empty($searchBySize)) {
            $restaurant_ids = $restaurant_by_table;
            $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
        } else {
            $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
        }
        $restaurant_condtion['Restaurant.approved'] = 1;
        $restaurant = $this->search_all($restaurant_condtion, $latitude, $longitude);
        if (!empty($searchByTime) && $selected_end_time < date("H:i:s"))
            $restaurant = array();
        $value = 1;
        if (count($restaurant) == 0) {
            $value = 2;
            $message = 'We are sorry but no results have matched your search criteria. Please click back to the home screen to browse through our other offers!';
            unset($conditions);
            $conditions['Offer.offerDate'] = $currentdate;
            $conditions['NOT'] = array('Offer.id' => $reservation_list);
            if (!empty($searchBySize))
                $searchBySizes = $searchBySizes[$searchBySize];
            else
                $searchBySizes = array(2, 4, 6, 8);
            if (!empty($searchByTime))
                $conditions['Offer.offerTime >='] = $searchByTime;
            else
                $conditions['Offer.offerTime >='] = date('H:i:s');
            $conditions['Offer.seating'] = $searchBySizes;
            $restaurant_by_table = $this->Offer->find('list', array('conditions' => $conditions,
                'fields' => array('Offer.restaurantId',
                    'Offer.restaurantId'),
                'group' => 'Offer.restaurantId',
                'recursive' => -1));
            if (!empty($searchByNeighborhood))
                $restaurant_condtion['Restaurant.neighborhoodId'] = $searchByNeighborhood;
            if (!empty($searchByCuisine) && (!empty($searchByTime) || !empty($searchBySize))) {
                $restaurant_ids = array_intersect($restaurant_by_table, $restaurantCuisine);
                $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
            } elseif (!empty($searchByCuisine)) {
                $restaurant_ids = array_intersect($restaurant_by_table, $restaurantCuisine);
                $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
            } elseif (!empty($searchByTime) || !empty($searchBySize)) {
                $restaurant_ids = $restaurant_by_table;
                $restaurant_condtion['Restaurant.id'] = $restaurant_ids;
            } else {
                $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
            }
            $restaurant = $this->search_all($restaurant_condtion, $latitude, $longitude); //,$lat,$lng,$miles);            
            if (count($restaurant) == 0) {
                unset($conditions['Offer.seating']);
                $restaurant_by_table = $this->Offer->find('list', array('conditions' => $conditions,
                    'fields' => array('Offer.restaurantId',
                        'Offer.restaurantId'),
                    'group' => 'Offer.restaurantId',
                    'recursive' => -1));
                unset($restaurant_condtion);
                $restaurant_condtion['Restaurant.id'] = $restaurant_by_table;
                $restaurant = $this->search_all($restaurant_condtion, $latitude, $longitude); //,$lat,$lng,$miles);
                $searchByTime = '';
                $searchBySize = '';
            }
        }
        if (count($restaurant) == 0) {
            $value = 2;
            $message = 'We are sorry but no results have matched your search criteria! Please check the home screen for more offers!';
        } else {
            $res_no = 0;
            $non_res_no = 0;
            $restaurants = $restaurant;
            $restaurant = '';
            foreach ($restaurants as $restaurant) {
                $rest = $this->orderRestaurantDetails($restaurant);
                /*                 * *** For fetching offers for todat and arranging in a desired order **** */
                $resoffers = $this->tableAvailability($restaurant['Restaurant']['id'], $searchBySize, $searchByTime);
                $restaurant['Offer'] = array();
                if (!empty($resoffers)) {
                    $offerSeating = array_keys($resoffers);
                    $offerindex = 0;
                    $restaurant['Offer']['isAvailable'] = $restaurantTimeAvaialble = 'No';
                    if (!empty($isTimeAvailable)) {
                        $timeAvaialble = array_search($isTimeAvailable, $resoffers[$offerSeating[$offerindex]]);
                        if (!empty($timeAvaialble))
                            $restaurant['Offer']['isAvailable'] = $restaurantTimeAvaialble = 'Yes';
                    }
                    foreach ($resoffers as $seatingoffers) {
                        if ($offerindex == 0) {
                            $seatIndex = 0;
                            if (!empty($searchBySize))
                                $restaurant['Offer']['size'] = $searchBySize;
                            else
                                $restaurant['Offer']['size'] = $offerSeating[$offerindex];
                            foreach ($seatingoffers as $seatingoffer => $value_time) {
                                $restaurant['Offer']['list'][$seatIndex]['offerKey'] = $seatingoffer;
                                $restaurant['Offer']['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value_time));
                                $seatIndex++;
                            }
                        }
                        $offerindex++;
                    }
                }
                if ($restaurantTimeAvaialble == 'Yes') {
                    $timeAvaialbleRestaurant[$res_no]['Restaurant'] = $rest['Restaurant'];
                    $timeAvaialbleRestaurant[$res_no]['Slideshow'] = $rest['Slideshow'];
                    $timeAvaialbleRestaurant[$res_no]['Offer'] = $restaurant['Offer'];
                    $res_no++;
                } else {
                    $timeNonAvaialbleRestaurant[$non_res_no]['Restaurant'] = $rest['Restaurant'];
                    $timeNonAvaialbleRestaurant[$non_res_no]['Slideshow'] = $rest['Slideshow'];
                    $timeNonAvaialbleRestaurant[$non_res_no]['Offer'] = $restaurant['Offer'];
                    $non_res_no++;
                }
            }
            $result = array_merge($timeAvaialbleRestaurant, $timeNonAvaialbleRestaurant);
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * *******************************************************
     * Action Name      : search_all                         *
     * Date Of Creation : 1/8/2014                           *
     * Purpose of action: To search by passing conditions.   *
     * Created By       : SIVARAJ.S                          *
     * ******************************************************* */

    public function search_all($restaurant_condtion = null, $latitude, $longitude) {
        //for calculating nearby location distance (in miles)
        $orderby = array('Restaurant.rank DESC', 'Restaurant.name');
        if (!empty($latitude) && !empty($longitude)) {
            $this->Restaurant->virtualFields = array(
                'distance' => "( 6371 * acos( cos( radians($latitude) ) * cos( radians( Restaurant.latitude ) ) * cos( radians( Restaurant.longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( Restaurant.latitude ) ) ) )"
                    //'distance' => "ROUND(SQRT( POW(69.1 * (Restaurant.latitude -$latitude), 2) + POW(69.1 * ( $longitude - Restaurant.longitude) * COS(Restaurant.latitude/ 57.3), 2))* 0.621371192)"			
            );
            $orderby = array('Restaurant.distance ASC');
        }
        $restaurant_condtion['Restaurant.approved'] = 1;
        $restaurant = $this->Restaurant->find('all', array('conditions' => array($restaurant_condtion), //,'Restaurant.distance <' => 5),
            'fields' => array('Restaurant.id',
                'Restaurant.name',
                'Restaurant.neighborhoodId',
                'Restaurant.city',
                'Restaurant.logo',
                //'Restaurant.distance',
                'Restaurant.address',
                'Restaurant.latitude',
                'Restaurant.longitude',
                'Restaurant.startTime',
                'Restaurant.endTime',
                'Restaurant.short_description',
                'Restaurant.long_description',
                'Restaurant.slug_name'),
            'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                'Restaurantcuisine' => array('order' => array('Restaurantcuisine.id DESC'),
                    'limit' => 1),
                'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
            'recursive' => 2,
            'order' => $orderby));
        $this->set('search_all', 'nores');
        return $restaurant;
    }

    /*     * *******************************************************
     * Action Name      : tableAvailability                  *
     * Date Of Creation : 1/8/2014                           *
     * Purpose of action: To check available tables for each *  
     *                    restaurants by passing parammeters.*
     * Created By       : SIVARAJ.S                          *
     * ******************************************************* */

    public function tableAvailability($restaurant_id, $party_size = null, $time_select = null) {
        if (!empty($party_size) && $party_size == 3) {
            $party_size = 4;
        } else if (!empty($party_size) && $party_size == 5) {
            $party_size = 6;
        } else if (!empty($party_size) && $party_size == 7) {
            $party_size = 8;
        }
        $restaurant = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $restaurant_id),
            'fields' => array('Restaurant.startTime',
                'Restaurant.endTime'),
            'recursive' => -1));
        $currentdate = date('Y-m-d');
        $current_time = (!empty($time_select) && $time_select >= date('H:i:s')) ? $time_select : date('H:i:s');
        $restaurant_start_time = ($restaurant['Restaurant']['startTime'] > date('H:i:s')) ? $restaurant['Restaurant']['startTime'] : date('H:i:s');
        /*         * *** To get time conditions for search.(+30mins and -30mins from actual saerch time) **** */
        if (isset($time_select)) {
            if ($time_select != '23:30:00') {
                $selected_start_time = date('H:i:s', strtotime($time_select . '-120 MINUTES'));
                if ($selected_start_time < date("H:i:s"))
                    $selected_start_time = date('H:i:s');
                $selected_end_time = date('H:i:s', strtotime($time_select . '+120 MINUTES'));
                if ($selected_end_time < $selected_start_time) {
                    $selected_end_time = '23:30:00';
                }
            } else {
                $selected_start_time = date('H:i:s', strtotime($time_select . '-120 MINUTES'));
                if ($selected_start_time < date("H:i:s"))
                    $selected_start_time = date('H:i:s');
                $selected_end_time = date('H:i:s', strtotime($time_select));
            }
        }
        $re_time = $currentdate . ' 00:00:00';
        $this->loadModel = ('Reservation');
        $reservation_list = $this->Reservation->find('list', array('fields' => array('Reservation.offerId',
                'Reservation.offerId'),
            'conditions' => array('Reservation.approved' => 1,
                'Reservation.trasaction_time >=' => $re_time)));

        $conditions['Offer.restaurantId'] = $restaurant_id;
        $conditions['Offer.offerDate'] = $currentdate;
        $conditions['NOT'] = array('Offer.id' => $reservation_list);
        if (!empty($party_size))
            $conditions['Offer.seating'] = $party_size;
        if (!empty($time_select))
            $conditions['Offer.offerTime BETWEEN ? AND ? '] = array($selected_start_time, $selected_end_time);
        else
            $conditions['Offer.offerTime BETWEEN ? AND ? '] = array($restaurant_start_time, $restaurant['Restaurant']['endTime']);
        $tables = $this->Offer->find('list', array('conditions' => $conditions,
            'fields' => array('Offer.id', 'Offer.offerTime', 'Offer.seating'),
            'order' => array('Offer.seating', 'Offer.offerTime'),
            'group' => array('Offer.seating', 'Offer.offerTime'),
            'recursive' => -1));
        $seating = '';
        if (empty($tables)) {
            unset($conditions['Offer.offerTime BETWEEN ? AND ? ']);
            $conditions['Offer.offerTime >'] = $current_time;
            $tables = $this->Offer->find('list', array('conditions' => $conditions,
                'fields' => array('Offer.id', 'Offer.offerTime', 'Offer.seating'),
                'order' => array('Offer.seating', 'Offer.offerTime'),
                'group' => array('Offer.seating', 'Offer.offerTime'),
                'recursive' => -1));
        }
        return $tables;
    }

    /*     * *******************************************************
     * Action Name      : searchByName                       *
     * Date Of Creation : 1/10/2014                          *
     * Purpose of action: To list restaurant search results. *
     *                    (Based on restaurant name.)        *
     * Created By       : SIVARAJ.S                          *
     * ******************************************************* */

    public function searchByName() {
        $search = !empty($this->params['form']['restaurantName']) ? $this->params['form']['restaurantName'] : '';
        $latitude = isset($this->params['form']['latitude']) ? $this->params['form']['latitude'] : '';
        $longitude = isset($this->params['form']['longitude']) ? $this->params['form']['longitude'] : '';
        $result = array();
        $message = '';
        if (!empty($search)) {
            $searchResult = 0;
            $result = array();
            $search_term = trim($search);
            $search_term = html_entity_decode($search_term);
            $search_condition['Restaurant.approved'] = 1;
            $search_condition['Restaurant.name LIKE'] = '%' . $search_term . '%';
            $time_by_testaurant = $this->get_restid();
            $search_condition['Restaurant.id'] = $time_by_testaurant;
            $restaurant = $this->search_all($search_condition, $latitude, $longitude);
            /*             * *** To get suggestion for search results.(If actual search return empty result) **** */
            if (empty($restaurant)) {
                $searchResult = 1;
                $this->set('all', 'all');
                $time_by_testaurant = $this->get_restid();
                $restaurant_condtion['Restaurant.id'] = $time_by_testaurant;
                $restaurant = $this->search_all($restaurant_condtion, $latitude, $longitude);
            }
            if (count($restaurant) == 0) {
                $value = 0;
                $message = 'We are sorry but no results have matched your search criteria. Please click back to the home screen to browse through our other offers!';
            } else {
                $res_no = 0;
                $restaurants = $restaurant;
                $restaurant = '';
                foreach ($restaurants as $restaurant) {
                    /*                     * *** To order restaurant details **** */
                    $rest = $this->orderRestaurantDetails($restaurant);
                    $result[$res_no]['Restaurant'] = $rest['Restaurant'];
                    $result[$res_no]['Slideshow'] = $rest['Slideshow'];
                    /*                     * *** For fetching offers for today and arranging in a desired order **** */
                    $resoffers = $this->tableAvailability($restaurant['Restaurant']['id']);
                    $restaurant['Offer'] = array();
                    if (!empty($resoffers)) {
                        $offerSeating = array_keys($resoffers);
                        $offerindex = 0;
                        foreach ($resoffers as $seatingoffers) {
                            if ($offerindex == 0) {
                                $seatIndex = 0;
                                $restaurant['Offer']['size'] = $offerSeating[$offerindex];
                                foreach ($seatingoffers as $seatingoffer => $value) {
                                    $restaurant['Offer']['list'][$seatIndex]['offerKey'] = $seatingoffer;
                                    $restaurant['Offer']['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value));
                                    $seatIndex++;
                                }
                            }
                            $offerindex++;
                        }
                    }
                    $result[$res_no]['Offer'] = $restaurant['Offer'];
                    $res_no++;
                }
                $value = 1;
                if ($searchResult == 1) {
                    $value = 2;
                    $message = 'We are sorry but no results have matched your search criteria. Please click back to the home screen to browse through our other offers!';
                }
            }
        } else {
            $value = 0;
            $message = 'No data Found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * ********************************************************
     * Action Name      : forgetPassword                      *
     * Date Of Creation : 1/11/2014                           *
     * Purpose of action: To send forgetPassword link to user.*
     *                    (Based on restaurant name.)         *
     * Created By       : SIVARAJ.S                           *
     * ******************************************************** */

    public function forgetPassword() {
        $emailId = !empty($this->params['form']['email']) ? $this->params['form']['email'] : '';
        if (!empty($emailId)) {
            $this->loadModel('User');
            $user = $this->User->find('first', array('conditions' => array('User.email =' => $emailId),
                'fields' => array('User.id',
                    'User.email'),
                'recursive' => -1));

            if (!empty($user['User']['email'])) {
                $rand_string = $this->generateRandomString();
                $this->loadModel('EmailTemplate');
                $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Forgot Password');
                $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
                    '##SITE_LOGO##' => Configure::read('website.logo'),
                    '##FACEBOOK##' => Configure::read('website.facebook'),
                    '##TWITTER##' => Configure::read('website.twitter'),
                    '##USERNAME##' => (isset($user['User']['firstName'])) ? ucfirst($user['User']['firstName']) : '',
                    '##SITE_NAME##' => Configure::read('website.name'),
                    '##SUPPORT_EMAIL##' => Configure::read('site.contact_email'),
                    '##YEAR_MAIL##' => $this->year_mail,
                    '##APPSTORE##' => Configure::read('Applink'),
                    '##RESET_URL##' => Router::url(array('controller' => 'users', 'action' => 'login'), true),
                    '##FROM_EMAIL##' => Configure::read('website.name') . ' <' . ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'] . '>',
                    '##CONTACT_URL##' => Router::url(array('controller' => 'contacts', 'action' => 'add', 'admin' => false), true),
                    '##PROFILE_LINK##' => Router::url('/users/profile_change_password/' . $rand_string, true));
                $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? 'support@tablesavvy.com' : $email['from'];
                $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? 'support@tablesavvy.com' : $email['reply_to'];
                $this->Email->to = $user['User']['email'];
                $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
                    $this->User->updateAll(array('User.pw_reset_string' => "'" . $rand_string . "'",), array('User.id' => $user['User']['id']));
                }
                $value = 1;
                $result = 'A password link was sent to your email address. Thanks!';
            } else {
                $value = 0;
                $result = 'Not a valid email id or admin deactivated account';
            }
        } else {
            $value = 0;
            $result = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * **************************************************
     * Action Name      : Nmiapp_key                  *
     * Date Of Creation : 1/11/2014                     *
     * Purpose of action: To get NMI gateway crdential. *
     * Created By       : SIVARAJ.S                     *
     * ************************************************** */

    function Nmiapp_key() {
        $sender_info['is_testmode'] = 1;
        $sender_info['API_UserName'] = 'c.mahe_1301923521_biz_api1.yahoo.com';
        $sender_info['API_Password'] = '1301923531';
        $sender_info['API_Signature'] = 'AOJLm2qaQZXvoa4AI7KBtezDk4e8ASH09ugd4FTFc2TmZ-EdGxBxPyT8';
        return $sender_info;
    }

    /*     * ********************************************************
     * Action Name      : saveCardDetails                     *
     * Date Of Creation : 1/11/2014                           *
     * Purpose of action: To save user credit card detils.    *
     * Created By       : SIVARAJ.S                           *
     * ******************************************************** */

    public function saveCardDetails() {
        $sender_info = $this->Nmiapp_key();
        $data_credit_card['customer_vault_id'] = '';
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $data_credit_card['firstName'] = !empty($this->params['form']['nameOnCard']) ? $this->params['form']['nameOnCard'] : '';
        $data_credit_card['lastName'] = '';
        $data_credit_card['creditCardType'] = !empty($this->params['form']['cardType']) ? $this->params['form']['cardType'] : '';
        $data_credit_card['creditCardNumber'] = !empty($this->params['form']['creditCardNumber']) ? $this->params['form']['creditCardNumber'] : '';
        $data_credit_card['expDateMonth']['month'] = !empty($this->params['form']['expMonth']) ? $this->params['form']['expMonth'] : '';
        $data_credit_card['expDateYear']['year'] = !empty($this->params['form']['expYear']) ? $this->params['form']['expYear'] : '';
        $data_credit_card['cvv2Number'] = !empty($this->params['form']['cvvNumber']) ? $this->params['form']['cvvNumber'] : '';
        $data_credit_card['store'] = !empty($this->params['form']['store']) ? $this->params['form']['store'] : '';
        if (!empty($this->params['form'])) {
            $sender_info = $this->Nmiapp_key();
            /*             * *** To save card in NMI andget billing for next upcoming transaction **** */
            $payment_responses = $this->Nmiapp->doVaultPost($data_credit_card);
            if (!empty($payment_responses) && $payment_responses['response'] == 1) {
                
                if($data_credit_card['creditCardType'] == 'Amex' || $data_credit_card['creditCardType'] == 'American Express'):
                                $void_responses = $this->Nmiapp->doVoidTransaction($payment_responses);
                            endif;
                
                if (isset($data_credit_card['store']) && $data_credit_card['store'] == 0) {
                    $payment_responses['customer_vault_id'] = 'NULL';
                }
                
                
                $user['User']['billingKey'] = $payment_responses['customer_vault_id'];
                $user['User']['card_number'] = substr($data_credit_card['creditCardNumber'], -4, 4);
                $user['User']['card_type'] = $data_credit_card['creditCardType'];
                $this->loadModel('User');
                $this->User->id = $userId;
                $this->User->save($user, false);
                $value = 1;
                $result = 'Your credit card details have been saved successfully.';
            } else {
                $value = 1;
                $result = 'Failed to save card details';
            }
        } else {
            $value = 0;
            $result = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ********************************************************
     * Action Name      : storeCardDetails                    *
     * Date Of Creation : 1/11/2014                           *
     * Purpose of action: To save user credit card detils.    *
     * Created By       : SIVARAJ.S                           *
     * ******************************************************** */

    public function storeCardDetails() {
        $sender_info = $this->Nmiapp_key();
        $data_credit_card['customer_vault_id'] = '';
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $data_credit_card['firstName'] = !empty($this->params['form']['nameOnCard']) ? $this->params['form']['nameOnCard'] : '';
        $data_credit_card['lastName'] = '';
        $data_credit_card['creditCardType'] = !empty($this->params['form']['cardType']) ? $this->params['form']['cardType'] : '';
        $data_credit_card['creditCardNumber'] = !empty($this->params['form']['creditCardNumber']) ? $this->params['form']['creditCardNumber'] : '';
        $data_credit_card['expDateMonth']['month'] = !empty($this->params['form']['expMonth']) ? $this->params['form']['expMonth'] : '';
        $data_credit_card['expDateYear']['year'] = !empty($this->params['form']['expYear']) ? $this->params['form']['expYear'] : '';
        $data_credit_card['cvv2Number'] = !empty($this->params['form']['cvvNumber']) ? $this->params['form']['cvvNumber'] : '';
        $data_credit_card['store'] = !empty($this->params['form']['store']) ? $this->params['form']['store'] : '';
        if (!empty($this->params['form'])) {
            $sender_info = $this->Nmiapp_key();
            /*             * *** To save card in NMI andget billing for next upcoming transaction **** */
            $payment_responses = $this->Nmiapp->doVaultPost($data_credit_card);
            if (!empty($payment_responses) && $payment_responses['response'] == 1) {
                
                if($data_credit_card['creditCardType'] == 'Amex' || $data_credit_card['creditCardType'] == 'American Express'):
                                $void_responses = $this->Nmiapp->doVoidTransaction($payment_responses);
                            endif;
                
                if (isset($data_credit_card['store']) && $data_credit_card['store'] == 0) {
                    $payment_responses['customer_vault_id'] = 'NULL';
                }
                
                $user['User']['billingKey'] = $payment_responses['customer_vault_id'];
                $user['User']['card_number'] = substr($data_credit_card['creditCardNumber'], -4, 4);
                $user['User']['card_type'] = $data_credit_card['creditCardType'];
                $this->loadModel('User');
                $this->User->id = $userId;
                $this->User->save($user, false);
                $value = 1;
                $result = 'Your credit card details have been saved successfully.';
            } else {
                $value = 0;
                $result = 'Invalid credit card. Please recheck your credit card data';
            }
        } else {
            $value = 0;
            $result = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ******************************************************
     * Action Name      : deleteCardDetails                 *
     * Date Of Creation : 03/05/2013                        *
     * Purpose of action: To delete customer card details.  *
     * Created By       : SIVARAJ.S                         *
     * ****************************************************** */

    public function deleteCardDetails() {
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '482';
        if (!empty($userId)) {
            $deleteCard = 1;
            $result = array();
            $sender_info = $this->Nmiapp_key();
            $this->loadModel('User');
            $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $userId),
                'recursive' => -1));
            /*             * *** To delete card in NMI Payment gateway **** */
            if (!empty($userDetails['User']['billingKey']) && $userDetails['User']['billingKey'] != 'NULL') {
                $payment_responses = $this->Nmiapp->deleteVault($userDetails['User']['billingKey']);
                if (!empty($payment_responses) && $payment_responses['response'] == 1) {
                    $deleteCard = 1;
                } else {
                    $deleteCard = 0;
                }
            }
            if ($deleteCard == 1) {
                $user['User']['billingKey'] = '';
                $user['User']['card_number'] = '';
                $user['User']['card_type'] = '';
                $this->User->id = $userId;
                $this->User->save($user, false);
                $value = 1;
                $response['message'] = 'Your credit card details have been deleted successfully';
            } else {
                $value = 0;
                $response['message'] = 'Sorry, Try again to delete your card details';
            }
        } else {
            $value = 0;
            $response['message'] = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ********************************************************
     * Action Name      : reserveTable                        *
     * Date Of Creation : 1/13/2014                           *
     * Purpose of action: To reserve table based on selection.*
     * Created By       : SIVARAJ.S                           *
     * ******************************************************** */

    public function reserveTable() {

        $this->loadModel('Restaurant');
        $this->loadModel('Reservation');
        $this->loadModel('User');
        $this->loadModel('Offer');
       // $this->params['form']['userId'] ='7383';
//        $this->params['form']['offerId'] ='4557399';
//        $this->params['form']['size'] = '2';
        //$this->params['form']['application'] ='';
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $offerId = !empty($this->params['form']['offerId']) ? $this->params['form']['offerId'] : '';
        $size = !empty($this->params['form']['size']) ? $this->params['form']['size'] : '';
        $action_from = !empty($this->params['form']['application']) ? $this->params['form']['application'] : 'iPhone';
        
        //Added the CC details and few new field save process.
//        $this->params['form']['firstName'] = "rakesh";
//        $this->params['form']['lastName'] = "wiliam";
//        $this->params['form']['phone'] = '8608476423';
//        $this->params['form']['cardType'] = 'VISA';
//        $this->params['form']['creditCardNumber'] ='4111111111111111';
//        $this->params['form']['expMonth'] = '12';
//        $this->params['form']['expYear'] = '2017';
//        $this->params['form']['cvvNumber'] = '123';
//        $this->params['form']['store'] = '1';
        $user['User']['firstName'] = !empty($this->params['form']['firstName']) ? $this->params['form']['firstName'] : '';
        $user['User']['lastName'] = !empty($this->params['form']['lastName']) ? $this->params['form']['lastName'] : '';
        $user['User']['phone'] = !empty($this->params['form']['phone']) ? $this->params['form']['phone'] : '0123463';
        
        $result = array();
        $message = '';
        $checkValidation = 0;
        
        $this->loadModel('User');
        $this->User->set($user);
        
        $userDetails = $this->User->find('first', array('conditions' => array('id' => $userId), 'fields' => array('user_amount','card_type'),'recursive' => -1));
        
        if (!$this->User->validates()) {
                  $data_error = array_values($this->User->validationErrors);
                    $value = 0;
                    $checkValidation = 1;
                    $message = $data_error[0];
        }
        
        
        if($userDetails['User']['user_amount'] == 0){
            //if(empty($this->params['form']['cardType']) || empty($userDetails['User']['card_type'])){
            if(empty($this->params['form']['cardType']) && empty($userDetails['User']['card_type'])){
                $value = 0;
                $checkValidation = 1;
                $message = "Please fill in necessary credit card details below";
            }
        }
        
        // echo $message;
        // exit;
        
        if (!empty($this->params['form']) && $checkValidation != 1) {
            $this->loadModel('User');
            $this->User->set($user);
            /*             * *** To save credit card details (if available) **** */
            $data_credit_card['firstName'] = !empty($this->params['form']['firstName']) ? $this->params['form']['firstName'] : '';
            $data_credit_card['lastName'] = !empty($this->params['form']['lastName']) ? $this->params['form']['lastName'] : '';
            $data_credit_card['creditCardType'] = !empty($this->params['form']['cardType']) ? $this->params['form']['cardType'] : '';
            $data_credit_card['creditCardNumber'] = !empty($this->params['form']['creditCardNumber']) ? $this->params['form']['creditCardNumber'] : '';
            $data_credit_card['expDateMonth']['month'] = !empty($this->params['form']['expMonth']) ? $this->params['form']['expMonth'] : '';
            $data_credit_card['expDateYear']['year'] = !empty($this->params['form']['expYear']) ? $this->params['form']['expYear'] : '';
            $data_credit_card['cvv2Number'] = !empty($this->params['form']['cvvNumber']) ? $this->params['form']['cvvNumber'] : '';
            $data_credit_card['store'] = !empty($this->params['form']['store']) ? $this->params['form']['store'] : '';
            $sender_info = $this->Nmiapp_key();
            $payment_responses = $this->Nmiapp->doVaultPost($data_credit_card);
            
            $result_set = $this->User->updateAll(array('User.firstName' => "'" . $user['User']['firstName'] . "'",
                        'User.lastName' => "'" . $user['User']['lastName'] . "'",
                        'User.phone' => "'" . $user['User']['phone'] . "'"), array('User.id' => $userId));
            
            if (!empty($payment_responses) && $payment_responses['response'] == 1) {
                
                if($data_credit_card['creditCardType'] == 'Amex' || $data_credit_card['creditCardType'] == 'American Express'):
                                $void_responses = $this->Nmiapp->doVoidTransaction($payment_responses);
                            endif;
                
                $user['User']['billingKey'] = $payment_responses['customer_vault_id'];
                $user['User']['card_number'] = substr($data_credit_card['creditCardNumber'], -4, 4);
                $user['User']['card_type'] = $data_credit_card['creditCardType'];
                if ($this->User->validates()) {
                    $this->User->id = $userId;
                    if (isset($data_credit_card['store']) && $data_credit_card['store'] == 0) {
                        $payment_responses['customer_vault_id'] = 'NULL';
                    }
                    $result_set = $this->User->updateAll(array('User.firstName' => "'" . $user['User']['firstName'] . "'",
                        'User.lastName' => "'" . $user['User']['lastName'] . "'",
                        'User.phone' => "'" . $user['User']['phone'] . "'",
                        'User.billingKey' => $payment_responses['customer_vault_id'],
                        'User.card_number' => substr($data_credit_card['creditCardNumber'], -4, 4),
                        'User.card_type' => "'" . $data_credit_card['creditCardType'] . "'"), array('User.id' => $userId));
                    $value = 1;
                    $result = $userId;
                    // pr($result_set); exit;
                } else {
                    $data_error = array_values($this->User->validationErrors);
                    $value = 0;
                    $message = $data_error[0];
                }
            } else if ($payment_responses['response'] != 1) {
                $value = 0;
                //$msg = $payment_responses['responsetext'];
                //$resmsg = strstr($msg, ' REFID', true);							
                $message = 'There was an error in the payment process. Please try again.';
            }
            
        }
        //Ending the save process.     

        $result = array();
        if (!empty($this->params['form']) && $checkValidation != 1) {
            /*             * *** To check Table availabilty **** */
            $already_reserved = $this->Restaurant->check_table($offerId);
            $no_offer = $this->Restaurant->check_offer($offerId);
            $resid = $this->Restaurant->check_rest($offerId);
            $result = array();
            if ($no_offer == 0 || $resid == 0 || $already_reserved > 0) {
                $value = 2;
                $response['message'] = 'Sorry, but the table you selected is no longer available.';
            } else {
                $user = $this->User->find('first', array('conditions' => array('User.id' => $userId),
                    'fields' => array('id',
                        'billingKey',
                        'firstName',
                        'lastName',
                        'email',
                        'email_subscription',
                        'user_amount',
                        'phone'),
                    'recursive' => -1));
                $username = $this->User->find('first', array('conditions' => array('id' => $userId), 'fields' => array('firstName', 'lastName')));
                $this->loadmodel('Offer');
                $offer = $this->Offer->find('first', array('conditions' => array('id' => $offerId), 'fields' => array('offerTime', 'offerDate', 'seating_custom', 'seating', 'restaurantId'), 'recursive' => -1));
                $normal_party_size = array(2, 4, 6, 8);
                $cutom_size = $size;
                if (in_array($cutom_size, $normal_party_size))
                    $cutom_size = 0;
                $this->data['Offer']['seating_custom'] = $cutom_size;
                $this->loadmodel('Restaurant');
                $res = $this->Restaurant->find('first', array('conditions' => array('id' => $offer['Offer']['restaurantId']), 'fields' => array('name', 'phone'), 'recursive' => -1));

                $name = ucfirst($username['User']['firstName']) . ucfirst($username['User']['lastName']);
                if (!empty($user)) {
                    //***** To charge amount or credit from customer *****/							
                    if ($user['User']['user_amount'] != 0) {
                        $amount = 'available';
                        $user_amnt = $user['User']['user_amount'] - 5;
                        $data = array('User' => array('id' => $user['User']['id'], 'user_amount' => $user_amnt));
                        $this->User->save($data, false, array('user_amount'));
                    } else {
                        $data_credit_card['customer_vault_id'] = $user['User']['billingKey'];
                        $payment_responses = $this->Nmiapp->doReferenceTransaction($data_credit_card);
                    }

                    /*                     * *** To save reservation details based on user credit **** */
                    if (!empty($payment_responses) && $payment_responses['response'] == 1 || isset($amount)) {
                        $value = 1;
                        $this->Offer->updateAll(array('Offer.seating_custom' => $cutom_size), array('Offer.id' => $offerId));
                        $this->loadmodel('Reservation');
                        $this->Reservation->create();
                        date_default_timezone_set('America/Chicago');
                        $convet_reserve_time = date('Y-m-d H:i:s');
                        if (!isset($amount)) {
                            $confirmed_reservation = $this->Reservation->save(array('offerId' => $offerId,
                                'userId' => $userId,
                                'transactionId' => $payment_responses['transactionid'],
                                'approved' => 1,
                                'from' => $action_from,
                                'credit_info' => 1,
                                'chicagomag' => Configure::read('website.id'),
                                'trasaction_time' => $convet_reserve_time));
                            $result = $this->Reservation->getLastInsertId();
                            $response['message'] = 'Thank you for booking through TableSavvy! Your table has been successfully reserved!';
                        } else {
                            $confirmed_reservation = $this->Reservation->save(array('offerId' => $offerId,
                                'userId' => $userId,
                                'approved' => 1,
                                'credit_info' => 0,
                                'from' => $action_from,
                                'chicagomag' => Configure::read('website.id'),
                                'trasaction_time' => $convet_reserve_time));
                            $result = $this->Reservation->getLastInsertId();
                            $response['message'] = 'Thank you for booking through TableSavvy! Your table has been successfully reserved!';
                        }
                        $offer_details = $this->Offer->find('first', array('conditions' => array('Offer.id' => $offerId),
                            'fields' => array('offerDate',
                                'offerTime',
                                'seating',
                                'restaurantId')));
                        $name = $user['User']['firstName'];
                        $seating = ($cutom_size != 0) ? $cutom_size : $offer_details['Offer']['seating'];
                        $date = strtotime($offer_details['Offer']['offerDate']);
                        $reserve_time = strtotime($offer_details['Offer']['offerTime']);
                        $day = date('l', $date);
                        $month1 = date('F', $date);
                        $year = date('Y', $date);
                        $dat = date('l, F dS', $date);
                        $time = date('h:i a', $reserve_time);
                        $day = strftime('%d', strtotime($offer_details['Offer']['offerDate']));
                        $month = strftime('%m', strtotime($offer_details['Offer']['offerDate']));
                        $year = strftime('%Y', strtotime($offer_details['Offer']['offerDate']));
                        $mail_date = $month . '/' . $day . '/' . $year;
                        $restaurantId = $offer_details['Offer']['restaurantId'];
                        $resname = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $restaurantId),
                            'fields' => array('name',
                                'phone',
                                'address',
                                'state',
                                'id',
                                'user_id',
                                'approved')));
                        $phone = $resname['Restaurant']['phone'];
                        $phone = str_replace('(', '', $phone);
                        $phone = str_replace(')', '', $phone);
                        $phone = str_replace('-', '', $phone);
                        $phone = str_replace(' ', '', $phone);
                        $phone_number = '';
                        $phone_number .= '(' . substr($phone, 0, 3) . ')';
                        $phone_number .= '-' . substr($phone, 3, 3) . '-';
                        $phone_number .= substr($phone, 6, 4);
                        /*                         * *** To send reservation confirmation mail to user **** */
                        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' New Reservation');
                        $rand_string = $this->generateRandomString();
                        if (!empty($size))
                            $seating = $size;
                        for ($i = 0; $i < 1; $i++) {
                            $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
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
                                '##TIME##' => $time,
                                '##PHONE##' => $phone_number,
                                '##YEAR_MAIL##' => $this->year_mail,
                                '##ADDRESS##' => $resname['Restaurant']['address'] . ',<br>' . 'Chicago, ' . ' ' . $resname['Restaurant']['state'],
                                '##TNO##' => $offerId,
                                '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true));
                            $sub = Configure::read('website.name') . " Reservation Confirmation for " . $resname['Restaurant']['name'] . " - Chicago";
                            $this->Email->from = Configure::read('website.name') . ' <support@tablesavvy.com>';
                            $this->Email->replyTo = 'support@tablesavvy.com';
                            $this->Email->to = $user['User']['email'];
                            $this->Email->subject = $sub;
                            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                            $sub_email = $user['User']['email_subscription'];
                            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                            $name = ucfirst($user['User']['firstName']) . ' ' . ucfirst($user['User']['lastName']);
                            $phone = $user['User']['phone'];
                            $email = $user['User']['email'];
                            $res_id = $this->Reservation->getLastInsertID();
                            if ($resname['Restaurant']['approved'] == 1)
                                $this->send_reservation_mail($resname, $name, $seating, $time, $dat, $phone, $email, $res_id);
                        }
                        $survo_id = 587924;
                        $first_name = $user['User']['firstName'];
                        $last_name = $user['User']['lastName'];
                        $offer_time = base64_encode($offer_details['Offer']['offerTime']);
                        $phone = base64_encode($resname['Restaurant']['phone']);
                    } else {
                        $value = 0;
                        //$msg = $payment_responses['responsetext'];
                        //$resmsg = strstr($msg, ' REFID', true);
                        $response['message'] = 'There was an error in the payment process. Please try again.';
                    }
                }
            }
        } else {
            $value = 0;
            $message = ($checkValidation == 1) ? $message : 'No data found';
            $response['message'] = $message;
        }
        
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ************************************************************
     * Action Name      : send_reservation_mail                   *
     * Date Of Creation : 1/17/2014                               *
     * Purpose of action: To send confirmation mail to restaurant.*
     * Created By       : SIVARAJ.S                               *
     * ************************************************************ */

    public function send_reservation_mail($resname, $name, $seating, $time, $dat, $phone1, $email1, $offer_id) {
        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' New Restaurant owner');
        $rand_string = $this->generateRandomString();
        $phone = $resname['Restaurant']['phone'];
        $phone1 = str_replace('(', '', $phone1);
        $phone1 = str_replace(')', '', $phone1);
        $phone1 = str_replace('-', '', $phone1);
        $phone1 = str_replace(' ', '', $phone1);
        $phoneno = '';
        $phoneno .= '(' . substr($phone1, 0, 3) . ')';
        $phoneno .= '-' . substr($phone1, 3, 3) . '-';
        $phoneno .= substr($phone1, 6, 4);
        $link = Router::url('/homes/receipt/' . $offer_id, true);
        $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
            '##SITE_LOGO##' => Configure::read('website.logo'),
            '##FACEBOOK##' => Configure::read('website.facebook'),
            '##TWITTER##' => Configure::read('website.twitter'),
            '##SITE_NAME##' => Configure::read('website.name'),
            '##NAME##' => ucfirst($name),
            '##APPSTORE##' => Configure::read('Applink'),
            '##EMAIL##' => $email1,
            '##PHONE##' => $phone,
            '##link##' => $link,
            '##SIZE##' => $seating,
            '##RESNAME##' => $resname['Restaurant']['name'],
            '##DATE##' => $dat,
            '##TIME##' => $time,
            '##YEAR_MAIL##' => $this->year_mail,
            '##PHONE##' => $phoneno,
            '##ADDRESS##' => $resname['Restaurant']['address'] . ',<br>' . 'Chicago, ' . ' ' . $resname['Restaurant']['state']);
        $this->loadmodel('Recipient');
        $rec = $this->Recipient->find('all', array('conditions' => array('resId' => $resname['Restaurant']['id'])));
        //$recipient_mail = 'reservations@tablesavvy.com';
        $recipient_mail = 'fspsaravanan123@gmail.com';
        foreach ($rec as $recipient) {
            $recipient_mail = $recipient_mail . ',' . $recipient["Recipient"]["email"];
        }
        $user = $this->User->findById($resname['Restaurant']['user_id']);
        if (Configure::read('website.name') == "Chicago Magazine")
            $sub = "A Reservation has been made via " . Configure::read('website.name') . '/TableSavvy';
        else
            $sub = "A Reservation has been made via " . Configure::read('website.name');
        $this->Email->from = 'TableSavvy Reservations <support@tablesavvy.com>';
        $this->Email->replyTo = 'support@tablesavvy.com';
        $this->Email->to = $user['User']['email'];
        $this->Email->cc = $recipient_mail;
        $this->Email->readReceipt = 'fspsaravanan123@gmail.com';
        $this->Email->subject = $sub;
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }

    /*     * ************************************************
     * Action Name      : cancelReservation           *
     * Date Of Creation : 1/17/2014                   *
     * Purpose of action: To cancel table reservation.*
     * Created By       : SIVARAJ.S                   *
     * ************************************************ */

    public function cancelReservation() {
        $reservation_id = !empty($this->params['form']['reservationId']) ? $this->params['form']['reservationId'] : '';
        $action_from = !empty($this->params['form']['application']) ? $this->params['form']['application'] : 'iPhone';
        if (!empty($reservation_id)) {
            date_default_timezone_set('America/Chicago');
            $this->loadModel('Reservation');
            $reservation = $this->Reservation->find('first', array('conditions' => array('Reservation.id' => $reservation_id,
                    'Reservation.approved' => 1),
                'contain' => array('Offer' => array('Restaurant'),
                    'User'),
                'fields' => array('offerId'),
                'recursive' => 2));
            if (empty($reservation)) {
                $value = 0;
                $result = 'Reservation Already Cancelled.';
            } elseif (strtotime(date('H:i:s')) >= strtotime($reservation['Offer']['offerTime'])) {
                $value = 0;
                $result = "You Can't cancel the past reservation.";
            } else {
                /*                 * *** To update reservation details **** */
                $user_id = $reservation['User']['id'];
                $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id),
                    'fields' => array('id',
                        'billingKey',
                        'firstName',
                        'lastName',
                        'email',
                        'user_amount',
                        'phone'),
                    'recursive' => -1));
                $res_id = $reservation_id;
                $offer_id = $reservation['Reservation']['offerId'];
                $reserve_time = strtotime($reservation['Offer']['offerTime']) - 1800;
                $last_time = strtotime(date('H:i:s'));
                $convert_time = date('H:i', $last_time);
                $convet_reserve_time = date('H:i', $reserve_time);
                if ($reservation['Offer']['seating_custom'] != 0)
                    $cancel_custom = $reservation['Offer']['seating_custom'];
                else
                    $cancel_custom = 0;
                $cancelledtime = date('Y-m-d H:i:s');
                $this->Reservation->id = $reservation_id;
                $this->data['Reservation']['approved'] = 0;
                $this->data['Reservation']['receipt'] = 0;
                $this->data['Reservation']['from'] = $action_from;
                $this->data['Reservation']['cancel_custom'] = $cancel_custom;
                $this->data['Reservation']['trasaction_time'] = $cancelledtime;
                $reservation_cancled = $this->Reservation->save($this->data['Reservation']);
                if ($reservation_cancled) {
                    /*                     * *** To update offer and user details **** */
                    $amount = $user['User']['user_amount'] + 5;
                    $data = array('User' => array('id' => $user['User']['id'], 'user_amount' => $amount));
                    $this->User->save($data, false, array('user_amount'));

                    $seating = $reservation['Offer']['seating'];
                    if ($reservation['Offer']['seating_custom'] != 0)
                        $seating = $reservation['Offer']['seating_custom'];

                    $this->Offer->updateAll(array('Offer.seating_custom' => 0), array('Offer.id' => $reservation['Offer']['id']));
                    $date = strtotime($reservation['Offer']['offerDate']);
                    $time = date('H:i A');
                    $day = date('l', $date);
                    $month = date('F', $date);
                    $year = date('Y', $date);
                    $dat = date('l, F dS', $date);
                    $rand_string = $this->generateRandomString();
                    $resturant_name['Restaurant']['name'] = $reservation['Offer']['Restaurant']['name'];
                    $resturant_name['Restaurant']['id'] = $reservation['Offer']['Restaurant']['id'];
                    $resturant_name['Restaurant']['user_id'] = $reservation['Offer']['Restaurant']['user_id'];
                    /*                     * *** To send cancel mmail to user **** */
                    $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Cancel Reservation');
                    $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
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
                        '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true));
                    $sub = "Reservation Cancellation via " . Configure::read('website.name');
                    $this->Email->from = Configure::read('website.name') . ' <support@tablesavvy.com>';
                    $this->Email->replyTo = 'support@tablesavvy.com';
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = $sub;
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    $offer_times['Offer']['offerTime'] = $reservation['Offer']['offerTime'];
                    $offer_times['Offer']['seating'] = $seating;
                    $restaurant['Restaurant']['name'] = $resturant_name;
                    $restaurant['Restaurant']['phone'] = $reservation['Offer']['Restaurant']['phone'];
                    $offer_time = base64_encode($offer_times['Offer']['offerTime']);
                    $phone = base64_encode($restaurant['Restaurant']['phone']);
                    $first_name = $user['User']['firstName'];
                    $last_name = $user['User']['lastName'];
                    $this->set(compact('seating', 'offer_time', 'phone', 'survo_id', 'fname', 'lname'));
                    if ($reservation['Offer']['Restaurant']['approved'] == 1)
                        $this->send_cancel_email($first_name, $last_name, $reservation, $seating, $resturant_name, $dat, $res_id);
                    $value = 1;
                    $result = 'Your reservation has been canceled.';
                }else {
                    $value = 0;
                    $result = 'Failed to cancel reservation.';
                }
            }
        } else {
            $value = 0;
            $result = 'No data found.';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * *************************************************
     * Action Name      : send_cancel_email            * 
     * Date Of Creation : 1/17/2014                    *
     * Purpose of action: To cancel mail to restaurant.*
     * Created By       : SIVARAJ.S                    *
     * ************************************************* */

    public function send_cancel_email($first_name, $last_name, $reservation, $seating, $resturant_name = array(), $dat, $offer_id) {
        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' cancel owner');
        $rand_string = $this->generateRandomString();
        $res_email = $this->User->findById($resturant_name['Restaurant']['user_id']);
        $link = Router::url('/homes/receipt/' . $offer_id, true);
        $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
            '##SITE_LOGO##' => Configure::read('website.logo'),
            '##FACEBOOK##' => Configure::read('website.facebook'),
            '##TWITTER##' => Configure::read('website.twitter'),
            '##SITE_NAME##' => Configure::read('website.name'),
            '##NAME##' => ucfirst($first_name) . ' ' . ucfirst($last_name),
            '##APPSTORE##' => Configure::read('Applink'),
            '##SIZE##' => $seating,
            '##link##' => $link,
            '##RESNAME##' => $resturant_name['Restaurant']['name'],
            '##DATE##' => $dat,
            '##YEAR_MAIL##' => $this->year_mail,
            '##TIME##' => date('h:i A', strtotime($reservation['Offer']['offerTime'])),
            '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true));
        $this->loadmodel('Recipient');
        $rec = $this->Recipient->find('all', array('conditions' => array('resId' => $resturant_name['Restaurant']['id'])));
        $recipient_mail = 'fspsaravanan123@gmail.com';
        foreach ($rec as $recipient) {
            $recipient_mail = $recipient_mail . ',' . $recipient["Recipient"]["email"];
        }
        $sub = "Reservation Cancellation via " . Configure::read('website.name');
        $this->Email->from = Configure::read('website.name') . ' <support@tablesavvy.com>';
        $this->Email->replyTo = 'support@tablesavvy.com';
        $this->Email->cc = $recipient_mail;
        $this->Email->readReceipt = 'fspsaravanan123@gmail.com';
        $this->Email->to = $res_email['User']['email'];
        $this->Email->subject = $sub;
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }

    /*     * ****************************************************
     * Action Name      : changeReservation               *
     * Date Of Creation : 1/20/2014                       *
     * Purpose of action: To change reservation time/size.*
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function changeReservation() {
            
        $reservationId = !empty($this->params['form']['reservationId']) ? $this->params['form']['reservationId'] : '';
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $offerId = !empty($this->params['form']['offerId']) ? $this->params['form']['offerId'] : '';
        $size = !empty($this->params['form']['size']) ? $this->params['form']['size'] : '';
        $action_from = !empty($this->params['form']['application']) ? $this->params['form']['application'] : 'iPhone';
        if ($action_from == "AndroidApp") {
            $action_from = "Droid";
        }
        $result = array();
        if (!empty($reservationId)) {
            $this->loadModel('Restaurant');
            $this->loadModel('Reservation');
            $reservedOffer = $this->Reservation->query('select * from reservations where id = ' . $reservationId);
            if ($reservedOffer[0]['reservations']['offerId'] != $offerId) {
                $offerAvailable = $this->Restaurant->check_offer($offerId);
                $reservationAvailable = $this->Restaurant->check_reservation($offerId);
            } else {
                $offerAvailable = 1;
                $reservationAvailable = 0;
            }
            if ($offerAvailable == 0) {
                $value = 2;
                $response['message'] = 'Sorry, but the table you selected is no longer available..';
            } elseif ($reservationAvailable != 0) {
                $value = 2;
                $response['message'] = 'Sorry, but the table you selected is no longer available..';
            } else {
                $this->data['Reservation']['id'] = $reservationId;
                $this->data['Reservation']['offerId'] = $offerId;
                $this->data['Reservation']['chicagomag'] = Configure::read('website.id');
                date_default_timezone_set('America/Chicago');
                $modified_time = date('Y-m-d H:i:s');
                $normal_party_size = array(2, 4, 6, 8);
                $customsize = $size;
                if (in_array($size, $normal_party_size))
                    $customsize = 0;
                $this->data['Reservation']['cancel_custom'] = $customsize;
                $this->data['Reservation']['receipt'] = 0;
                $this->data['Reservation']['trasaction_time'] = $modified_time;
                $this->data['Reservation']['from'] = $action_from;
                $this->Reservation->set($this->data['Reservation']);
                /*                 * *** To update reservation details. ***** */
                if ($this->Reservation->save()) {
                    $res_id = $reservationId;
                    $reservation = $this->Reservation->find('first', array('conditions' => array('Reservation.id' => $res_id,
                            'Reservation.approved' => 1),
                        'contain' => array('Offer' => array('Restaurant'),
                            'User'),
                        'fields' => array('offerId'),
                        'recursive' => 2));
                    $this->data['Offer']['seating_custom'] = $customsize;
                    $this->Offer->updateAll(array('Offer.seating_custom' => $customsize), array('Offer.id' => $offerId));
                    $this->Session->setFlash(__l('Your Reservation changed successfully.'), 'default', null, 'success');
                    $user = $this->User->find('first', array('conditions' => array('User.id' => $userId),
                        'fields' => array('billingKey',
                            'firstName',
                            'lastName',
                            'email',
                            'email_subscription'),
                        'recursive' => -1));
                    $phone1 = $reservation['Offer']['Restaurant']['phone'];
                    $phone1 = str_replace('(', '', $phone1);
                    $phone1 = str_replace(')', '', $phone1);
                    $phone1 = str_replace('-', '', $phone1);
                    $phone1 = str_replace(' ', '', $phone1);
                    $phoneno = '';
                    $phoneno .= '(' . substr($phone1, 0, 3) . ')';
                    $phoneno .= '-' . substr($phone1, 3, 3) . '-';
                    $phoneno .= substr($phone1, 6, 4);
                    /*                     * *** To send invitation mail to user **** */
                    $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Modify Reservation');
                    $rand_string = $this->generateRandomString();
                    $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
                        '##SITE_LOGO##' => Configure::read('website.logo'),
                        '##FACEBOOK##' => Configure::read('website.facebook'),
                        '##TWITTER##' => Configure::read('website.twitter'),
                        '##SITE_NAME##' => Configure::read('website.name'),
                        '##NAME##' => ucfirst($user['User']['firstName']),
                        '##SIZE##' => $size,
                        '##RESNAME##' => $reservation['Offer']['Restaurant']['name'],
                        '##DAY##' => date('l'),
                        '##MONTH##' => date('F'),
                        '##DATE##' => date('l, F dS'),
                        '##YEAR##' => date('Y'),
                        '##APPSTORE##' => Configure::read('Applink'),
                        '##YEAR_MAIL##' => $this->year_mail,
                        '##TIME##' => date('h:i a', strtotime($reservation['Offer']['offerTime'])),
                        '##PHONE##' => $phoneno,
                        '##ADDRESS##' => $reservation['Offer']['Restaurant']['address'] . '<br>' . 'Chicago, ' . $reservation['Offer']['Restaurant']['state'],
                        '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true),
                        '##LOGO##' => Router::url('/images/logo.png', true));
                    $sub = "Your " . "'" . $reservation['Offer']['Restaurant']['name'] . "'" . " Reservation Modification";
                    $this->Email->from = Configure::read('website.name') . ' <support@tablesavvy.com>';
                    $this->Email->replyTo = 'support@tablesavvy.com';
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = $sub;
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    $dat = date('l, F dS');
                    $name = $user['User']['firstName'] . ' ' . $user['User']['lastName'];
                    $seating = $reservation['Offer']['seating'];
                    $offer_time = base64_encode($reservation['Offer']['offerTime']);
                    $phone = base64_encode($reservation['Offer']['Restaurant']['phone']);
                    $fname = $user['User']['firstName'];
                    $lname = $user['User']['lastName'];
                    if ($reservation['Offer']['Restaurant']['approved'] == 1)
                        $this->send_change_eamil($user, $reservation['Offer']['offerTime'], $size, $reservation['Offer'], $dat, $res_id);
                    $survo_id = 588344;
                    $first_name = $user['User']['firstName'];
                    $last_name = $user['User']['lastName'];
                    $value = 1;
                    $result = $res_id;
                    $response['message'] = 'Your reservation has been successfully modified!';
                }
            }
        }else {
            $value = 0;
            $response['message'] = 'No data found.';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    public function test(){
        $response = $this->params;
        // pr($this->params);
        // exit;
        $this->set('response', $response);
    }

    /*     * *************************************************
     * Action Name      : send_change_eamil            * 
     * Date Of Creation : 1/20/2014                    *
     * Purpose of action: To change reservation mail to*
     *                    restaurant.                  *
     * Created By       : SIVARAJ.S                    *
     * ************************************************* */

    function send_change_eamil($user, $reservation, $seating, $resturant_name, $dat, $offer_id) {
        $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' change owner');
        $rand_string = $this->generateRandomString();
        $res_email = $this->User->findById($resturant_name['Restaurant']['user_id']);
        $link = Router::url('/homes/receipt/' . $offer_id, true);
        $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
            '##SITE_LOGO##' => Configure::read('website.logo'),
            '##FACEBOOK##' => Configure::read('website.facebook'),
            '##TWITTER##' => Configure::read('website.twitter'),
            '##SITE_NAME##' => Configure::read('website.name'),
            '##NAME##' => ucfirst($user['User']['firstName']) . ' ' . ucfirst($user['User']['lastName']),
            '##SIZE##' => $seating,
            '##APPSTORE##' => Configure::read('Applink'),
            '##link##' => $link,
            '##RESNAME##' => $resturant_name['Restaurant']['name'],
            '##DATE##' => $dat,
            '##YEAR_MAIL##' => $this->year_mail,
            '##TIME##' => date('h:i A', strtotime($reservation)),
            '##Unsubscribe_email##' => Router::url('alerts/subscribe_email/' . $rand_string, true));
        if (Configure::read('website.name') == "Chicago Magazine")
            $sub = "Reservation Modification via " . Configure::read('website.name') . '/TableSavvy';
        else
            $sub = "Reservation Modification via " . Configure::read('website.name');
        $this->loadmodel('Recipient');
        $rec = $this->Recipient->find('all', array('conditions' => array('resId' => $resturant_name['Restaurant']['id'])));
        $recipient_mail = 'fspsaravanan123@gmail.com';
        foreach ($rec as $recipient) {
            $recipient_mail = $recipient_mail . ',' . $recipient["Recipient"]["email"];
        }
        $this->Email->from = Configure::read('website.name') . ' <support@tablesavvy.com>';
        $this->Email->replyTo = 'support@tablesavvy.com';
        $this->Email->cc = $recipient_mail;
        $this->Email->to = $res_email['User']['email'];
        $this->Email->readReceipt = 'fspsaravanan123@gmail.com';
        $this->Email->subject = $sub;
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }

    /*     * *********************************************
     * Action Name      : sendInvitation           * 
     * Date Of Creation : 1/24/2014                *
     * Purpose of action: To send invitation mail. *
     * Created By       : SIVARAJ.S                *
     * ********************************************* */

    public function sendInvitation() {
        $userId = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $reservationId = !empty($this->params['form']['reservationId']) ? $this->params['form']['reservationId'] : '';
        $recepientMail = !empty($this->params['form']['recepientEmail']) ? $this->params['form']['recepientEmail'] : '';
        $subject = !empty($this->params['form']['subject']) ? $this->params['form']['subject'] : '';
        $content = !empty($this->params['form']['content']) ? $this->params['form']['content'] : '';
        if (!empty($reservationId)) {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $userId),
                'fields' => array('User.firstName', 'User.lastName', 'User.email')));
            $reservationDetails = '';
            $reservationDetails = $this->Reservation->find('first', array('conditions' => array('Reservation.id' => $reservationId,
                    'Reservation.userId' => $userId,
                    'Reservation.approved' => 1),
                'contain' => array('Offer' => array('Restaurant')),
                'fields' => array('offerId'),
                'recursive' => 2));
            if (!empty($reservationDetails)) {
                /*                 * *** Restautrant Details **** */
                $phone = strip_tags($reservationDetails['Offer']['Restaurant']['phone']);
                $res_id = strip_tags($reservationDetails['Offer']['Restaurant']['id']);
                $res_name = strip_tags($reservationDetails['Offer']['Restaurant']['name']);
                $address = strip_tags($reservationDetails['Offer']['Restaurant']['address']);
                $city = strip_tags($reservationDetails['Offer']['Restaurant']['city']);
                $city_id = $city;
                $row = mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
                $city_name = $row['city_name'];
                $state = strip_tags($reservationDetails['Offer']['Restaurant']['state']);
                /*                 * *** Offer Details **** */
                $date = strtotime($reservationDetails['Offer']['offerDate']);
                $day = date('l', $date);
                $month = date('F', $date);
                $year = date('Y', $date);
                $dat = date('l, F dS', $date);
                $time = date('H:i A', strtotime($reservationDetails['Offer']['offerTime']));
                $off_time = strtotime($time);
                $original_time = date('h:i a', $off_time);
                if ($reservationDetails['Offer']['seating_custom'] != 0) {
                    $seating = strip_tags($reservationDetails['Offer']['seating_custom']);
                } else {
                    $seating = strip_tags($reservationDetails['Offer']['seating']);
                }
                $res_url = Router::url(array('controller' => 'homes', 'action' => 'details'), true);
                $restaurant_url = $res_url . "/" . $res_id;
                $phone1 = $reservationDetails['Offer']['Restaurant']['phone'];
                $phone1 = str_replace('(', '', $phone1);
                $phone1 = str_replace(')', '', $phone1);
                $phone1 = str_replace('-', '', $phone1);
                $phone1 = str_replace(' ', '', $phone1);
                $phoneno = '';
                $phoneno .= '(' . substr($phone1, 0, 3) . ')';
                $phoneno .= '-' . substr($phone1, 3, 3) . '-';
                $phoneno .= substr($phone1, 6, 4);
                $url = Router::url('/homes', true);
                $mail = explode(",", $recepientMail);
                $count = count($mail);
                $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Send Invitation');
                $emailSent = 0;
                /*                 * *** To send email to recpients **** */
                for ($i = 0; $i < $count; $i++) {
                    $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
                        '##SITE_LOGO##' => Configure::read('website.logo'),
                        '##FACEBOOK##' => Configure::read('website.facebook'),
                        '##TWITTER##' => Configure::read('website.twitter'),
                        '##SITE_NAME##' => Configure::read('website.name'),
                        '##RESTARUANT_LINK##' => $restaurant_url,
                        '##RESTARUANT_NAME##' => $res_name,
                        '##PARTY_SIZE##' => $seating,
                        '##SIGN_UP##' => $url,
                        '##ADDRESS##' => $address . ',<br>' . $city_name . ', ' . $state,
                        '##TIME##' => $original_time,
                        '##DAY##' => $day,
                        '##MONTH##' => $month,
                        '##DATE##' => $dat,
                        '##YEAR## ' => $year,
                        '##APPSTORE##' => Configure::read('Applink'),
                        '##NAME##' => ucfirst($user['User']['firstName']),
                        '##SUPPORT_EMAIL##' => Configure::read('site.contact_email'),
                        '##SUBJECT##' => $subject,
                        '##FROM_EMAIL##' => $user['User']['email'],
                        '##EMAIL##' => $mail[$i],
                        '##PHONENUMBER##' => $phoneno,
                        '##YEAR_MAIL##' => $this->year_mail,
                        '##comment##' => $content);
                    $this->Email->from = (isset($user['User']['senderemail'])) ? $user['User']['senderemail'] : '';
                    $this->Email->replyTo = (isset($user['User']['senderemail'])) ? $user['User']['senderemail'] : '';
                    $this->Email->to = $mail[$i];
                    $this->Email->subject = $subject;
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    if ($this->Email->send(strtr($email['email_content'], $emailFindReplace)))
                        $emailSent = 1;
                    else
                        $emailSent = 0;
                    $this->Email->reset();
                }
                if ($emailSent == 1) {
                    $value = 1;
                    $result = 'Invitation sent successfully.';
                } else {
                    $value = 0;
                    $result = 'Failed to send invitation.';
                }
            } else {
                $value = 0;
                $result = 'Reservation details not found';
            }
        } else {
            $value = 0;
            $result = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ******************************************************
     * Action Name      : allRestaurant                     *
     * Date Of Creation : 01/24/2013                        *
     * Purpose of action: To list all approved restaurants. *
     * Created By       : SIVARAJ.S                         *
     * ****************************************************** */

    function allRestaurants() {
        $allRestaurantsId = $this->getApprovedRestaurantId();
        $availableRestaurantIds = $this->Restaurant->find('all', array('conditions' => array('Restaurant.approved' => 1,
                'Restaurant.id' => $allRestaurantsId['availableRestaurantIds']),
            'fields' => array('Restaurant.id',
                'Restaurant.name',
                'Restaurant.neighborhoodId',
                'Restaurant.city',
                'Restaurant.logo',
                'Restaurant.address',
                'Restaurant.startTime',
                'Restaurant.endTime',
                'Restaurant.short_description',
                'Restaurant.long_description',
                'Restaurant.slug_name'),
            'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
            'order' => array('Restaurant.rank DESC', 'Restaurant.name'),
            'recursive' => 2));
        $approvedRestaurantIds = $this->Restaurant->find('all', array('conditions' => array('Restaurant.approved' => 1,
                'Restaurant.id' => $allRestaurantsId['approvedRestaurantIds']),
            'fields' => array('Restaurant.id',
                'Restaurant.name',
                'Restaurant.neighborhoodId',
                'Restaurant.city',
                'Restaurant.logo',
                'Restaurant.address',
                'Restaurant.startTime',
                'Restaurant.endTime',
                'Restaurant.short_description',
                'Restaurant.long_description',
                'Restaurant.slug_name'),
            'contain' => array('Slideshow' => array('fields' => array('Slideshow.path', 'Slideshow.order_list')),
                'Restaurantcuisine' => array('Cuisine' => array('fields' => array('Cuisine.name')))),
            'order' => array('Restaurant.rank DESC', 'Restaurant.name'),
            'recursive' => 2));
        $restaurants = array_merge($availableRestaurantIds, $approvedRestaurantIds);
        $res_no = 0;
        $result = array();
        if (!empty($restaurants)) {
            foreach ($restaurants as $restaurant) {
                $rest = $this->orderRestaurantDetails($restaurant);
                $result[$res_no]['Restaurant'] = $rest['Restaurant'];
                $result[$res_no]['Slideshow'] = $rest['Slideshow'];
                /*                 * *** For fetching offers for todat and arranging in a desired order **** */
                $resoffers = $this->get_resoffer($restaurant['Restaurant']['id']);
                $restaurant['Offer'] = array();
                if (!empty($resoffers)) {
                    $offerSeating = array_keys($resoffers);
                    $offerindex = 0;
                    foreach ($resoffers as $seatingoffers) {
                        if ($offerindex == 0) {
                            $seatIndex = 0;
                            $restaurant['Offer']['size'] = $offerSeating[$offerindex];
                            foreach ($seatingoffers as $seatingoffer => $value) {
                                $restaurant['Offer']['list'][$seatIndex]['offerKey'] = $seatingoffer;
                                $restaurant['Offer']['list'][$seatIndex]['offerTime'] = date('h:i a', strtotime($value));
                                $seatIndex++;
                            }
                        }
                        $offerindex++;
                    }
                }
                $result[$res_no]['Offer'] = $restaurant['Offer'];
                $res_no++;
            }
            $value = 1;
        } else {
            $value = 0;
            $response['message'] = 'No more available restaurant';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ***********************************************************
     * Action Name      : getApprovedRestaurantId                *
     * Date Of Creation : 12/31/2013                             *
     * Purpose of action: To get offer available restaurant id.  *
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    public function getApprovedRestaurantId() {
        $offer_date = date('Y-m-d');
        $time = date('H:i:s');
        $reservedate = $offer_date . ' 00:00:00';
        $this->loadmodel('Reservation');
        $reser_id = $this->Reservation->find('list', array('conditions' => array('Reservation.approved' => 1, 'Reservation.trasaction_time >' => $reservedate), 'fields' => array('Reservation.offerId')));
        $this->loadmodel('Offer');
        $party = array(8, 7, 6, 5, 4, 3, 2);
        $availableRestaurantIds = $this->Offer->find('list', array('conditions' => array('Offer.offerDate' => $offer_date,
                'Offer.offerTime >=' => $time,
                'Offer.seating' => $party,
                'NOT' => array('Offer.id' => $reser_id)),
            'fields' => array('Offer.restaurantId'),
            'group' => 'Offer.restaurantId',
            'recursive' => -1));
        $approvedRestaurantIds = $this->Restaurant->find('list', array('conditions' => array('Restaurant.approved' => 1,
                'NOT' => array('Restaurant.id' => $availableRestaurantIds)),
            'fields' => array('Restaurant.id'),
            'order' => array('Restaurant.rank DESC', 'Restaurant.name')));

        $allRestaurantsId['availableRestaurantIds'] = $availableRestaurantIds;
        $allRestaurantsId['approvedRestaurantIds'] = $approvedRestaurantIds;
        return $allRestaurantsId;
    }

    /*     * ***********************************************************
     * Action Name      : autoComplete                           *
     * Date Of Creation : 02/18/2013                             *
     * Purpose of action: To send restaurant names based on key. *
     * Created By       : SIVARAJ.S                              *
     * *********************************************************** */

    public function autoComplete() {
        $searchString = !empty($this->params['form']['searchString']) ? $this->params['form']['searchString'] : 'dev';
        $result = array();
        if (!empty($searchString)) {
            $restaurants_name = '';
            $search_condition['Restaurant.name LIKE'] = '%' . $searchString . '%';
            $search_condition['Restaurant.approved'] = 1;
            $restaurants = $this->Restaurant->find('all', array('conditions' => $search_condition,
                'fields' => array('id', 'name'),
                'recursive' => '-1'));
            if (!empty($restaurants)) {
                $resNo = 0;
                foreach ($restaurants as $restaurant) {
                    $restaurants_name[$resNo]['id'] = $restaurant['Restaurant']['id'];
                    $restaurants_name[$resNo]['restaurantName'] = $restaurant['Restaurant']['name'];
                    $resNo++;
                }
                $value = 1;
                $result = $restaurants_name;
                $response['message'] = "Restaurants found";
            } else {
                $value = 0;
                $response['message'] = 'No restaurants found';
            }
        } else {
            $value = 0;
            $response['message'] = 'No restaurants found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ******************************************************
     * Action Name      : contactus                         *
     * Date Of Creation : 03/05/2013                        *
     * Purpose of action: To send email to tablesavvy team. *
     * Created By       : BALA SUBRAMANIAN                  *
     * ****************************************************** */

    public function contactus() {
        $this->data['Contact']['name'] = !empty($this->params['form']['name']) ? $this->params['form']['name'] : '';
        $this->data['Contact']['email'] = !empty($this->params['form']['email']) ? $this->params['form']['email'] : '';
        $this->data['Contact']['contact'] = !empty($this->params['form']['contact']) ? $this->params['form']['contact'] : '';
        $this->data['Contact']['comment'] = !empty($this->params['form']['comment']) ? $this->params['form']['comment'] : '';
        $result = array();
        if (!empty($this->data['Contact']['email'])) {
            $this->Contact->set($this->data);
            $email = $this->EmailTemplate->selectTemplate(Configure::read('website.slug') . ' Contact Us');
            $emailFindReplace = array('##SITE_LINK##' => Router::url('/', true),
                '##SITE_LOGO##' => Configure::read('website.logo'),
                '##FACEBOOK##' => Configure::read('website.facebook'),
                '##TWITTER##' => Configure::read('website.twitter'),
                '##USERNAME##' => 'Admin',
                '##NAME##' => (isset($this->data['Contact']['name'])) ? $this->data['Contact']['name'] : '',
                '##EMAIL##' => (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '',
                '##SITE_NAME##' => Configure::read('website.name'),
                '##SUPPORT_EMAIL##' => Configure::read('site.contact_email'),
                '##MESSAGE##' => $this->data['Contact']['comment'],
                '##SUBJECT##' => 'Contact form',
                '##YEAR_MAIL##' => $this->year_mail,
                '##CONTACTTYPE##' => $this->data['Contact']['contact'],
                '##RESET_URL##' => Router::url(array('controller' => 'users',
                    'action' => 'login'), true),
                '##FROM_EMAIL##' => 'TableSavvy <' . ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'] . '>',
                '##CONTACT_URL##' => Router::url(array('controller' => 'contacts',
                    'action' => 'add',
                    'admin' => false), true),
                '##SITE_LOGO##' => Router::url(array('controller' => 'img',
                    'action' => 'blue-theme',
                    'logo-email.png',
                    'admin' => false), true));
            $this->Email->from = (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '';
            $this->Email->replyTo = (isset($this->data['Contact']['email'])) ? $this->data['Contact']['email'] : '';
            $this->Email->to = 'support@tablesavvy.com';
            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
                $this->Contact->save();
                $redirect_url = Router::url(array('controller' => 'homes',
                            'action' => 'index',
                            'admin' => false));
                $value = 1;
                $result = $this->data['Contact']['name'];
                $response['message'] = "Your comment has been sent.";
            } else {
                $value = 0;
                $response['message'] = 'Your comment has not been sent. please try again';
            }
        } else {
            $value = 0;
            $response['message'] = 'Your comment has not been sent. please try again';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $this->set('response', $response);
    }

    /*     * ************************************************
     * Action Name      : serverCurrentTime           *
     * Date Of Creation : 03/12/2013                  *
     * Purpose of action: To get current server time. *
     * Created By       : SIVARAJ.S                   *
     * ************************************************ */

    public function serverCurrentTime() {
        $response['success'] = 1;
        $response['result']['servertime'] = date('d-m-y h:i:s a');
        $this->set('response', $response);
    }

    /*     * ******************************************************
     * Action Name      : updatelatlng                      *
     * Date Of Creation : 03/05/2013                        *
     * Purpose of action: To update lat/long of restaurant. *
     * Created By       : BALA SUBRAMANIAN                  *
     * ****************************************************** */

    public function updatelatlng() {
        $this->layout = false;
        $this->render = false;
        $allusers = $this->Restaurant->find('all', array('conditions' => array('Restaurant.latitude =' => '',
                'Restaurant.longitude =' => '',
                'Restaurant.address !=' => ''),
            'recursive' => -1));
        foreach ($allusers as $rests) {
            $cityname = $this->City->find('first', array('conditions' => array('City.id' => $rests['Restaurant']['city']))); //print_r($cityname);exit;
            $get_address = $rests['Restaurant']['address'] . ' ' . $cityname['City']['city_name'] . ' ' . $rests['Restaurant']['state'];
            $fget_address = str_replace(',', '', $get_address);
            $f2get_address = str_replace('.', '', $fget_address);
            $address = str_replace(" ", "+", $f2get_address);
            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json = json_decode($json);
            if (!empty($json->{'results'}[0])) {
                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            } else {
                $lat = '';
                $long = '';
            }
            $this->Restaurant->id = $rests['Restaurant']['id'];
            $this->data['Restaurant']['latitude'] = $lat;
            $this->data['Restaurant']['longitude'] = $long;
            if ($this->Restaurant->save($this->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" restaurant profile is updated successfully'), $this->data['Restaurant']['name']), 'default', null, 'success');
                $this->redirect($this->referer());
            }
        }
    }

    /*     * *****************************************************
     * Action Name      : listAPPUsers                     *
     * Date Of Creation : 03/20/2013                       *
     * Purpose of action: To list users with device token. *
     * Created By       : SIVARAJ S                        *
     * ***************************************************** */

    public function listSubscribedUsers() {
        Configure::write('debug', 2);
        $this->autoRender = false;
        $this->loadModel('User');
        $users = $this->User->find('list', array('conditions' => array('User.devicetoken !=' => ''),
            'fields' => array('email', 'devicetoken'),
            'recursive' => -1));
        pr($users);
    }

    /*     * ****************************************************
     * Action Name      : saveUserDetails                 *
     * Date Of Creation : 3/28/2014                       *
     * Purpose of action: To update existing user detils .*
     * Created By       : SIVARAJ.S                       *
     * **************************************************** */

    public function saveUserDetails() {
        $user['User']['id'] = !empty($this->params['form']['userId']) ? $this->params['form']['userId'] : '';
        $user['User']['firstName'] = !empty($this->params['form']['firstName']) ? $this->params['form']['firstName'] : '';
        $user['User']['lastName'] = !empty($this->params['form']['lastName']) ? $this->params['form']['lastName'] : '';
        $user['User']['phone'] = !empty($this->params['form']['phone']) ? $this->params['form']['phone'] : '0123463';
        $result = array();
        if (!empty($user['User']['phone'])) {
            $this->loadModel('User');
            $userExists = $this->User->find('first', array('conditions' => array('User.id' => $user['User']['id']),
                'recursive' => -1));
            if (!empty($userExists)) {
                unset($this->User->validate['firstName']);
                unset($this->User->validate['lastName']);
                unset($this->User->validate['old_password']);
                unset($this->User->validate['confirm_password']);
                unset($this->User->validate['password']);
                unset($this->User->validate['passwd']);
                unset($this->User->validate['email']);
                $this->User->set($user);
                if ($this->User->validates()) {
                    if ($this->User->save($user['User'])) {
                        $value = 1;
                        $message = "Thank you for signing up for TableSavvy! For reservation purposes, please add your phone number to your account. We've added a $5 credit to your account, so your first reservation is on us!";
                    } else {
                        $value = 0;
                        $message = "Sorry!! Please try again to add your phone number to your account.";
                    }
                } else {
                    $errors = $this->User->validationErrors;
                    $value = 0;
                    $message = $errors['phone'];
                }
            }
        } else {
            $value = 0;
            $message = 'No data found';
        }
        $response['success'] = $value;
        $response['result'] = $result;
        $response['message'] = $message;
        $this->set('response', $response);
    }

    /*     * **********************************************************
     * Action Name      : androidversion                        *
     * Date Of Creation : 8/5/2014                              *
     * Purpose of action: To get current version of android app.*
     * Created By       : SIVARAJ.S                             *
     * ********************************************************** */

    public function androidversion() {
        $this->loadModel('User');
        $userExists = $this->User->find('first', array('fields' => array('android_version'),
            'recursive' => -1));
        $response['success'] = 1;
        $response['result'] = $userExists['User'];
        $response['message'] = 'Current android version';
        $this->set('response', $response);
    }

    public function getCardDetails() {
        Configure::write('debug', 2);
        $response = $this->Nmiapp->doReferenceTransaction('419260356');
        pr($response);
        $this->autoRender = FALSE;
    }

}

?>