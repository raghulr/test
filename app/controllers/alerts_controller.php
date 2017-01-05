<?php

class AlertsController extends AppController {

    var $uses = array('Alert', 'Reservation', 'Offer', 'User', 'AlertResponse', 'Restaurant', 'EmailTemplate');
    var $components = array('Email');
    function day_select() {
        $this->layout = 'ajax';
        $user_id = $this->Auth->user('id');
        $update_day = $this->Alert->updateAll(array('Alert.sunday' => "'" . $this->data['Alert']['sunday'] . "'", 'Alert.monday' => "'" . $this->data['Alert']['monday'] . "'", 'Alert.tuesday' => "'" . $this->data['Alert']['tuesday'] . "'", 'Alert.wednesday' => "'" . $this->data['Alert']['wednesday'] . "'", 'Alert.thursday' => "'" . $this->data['Alert']['thursday'] . "'", 'Alert.friday' => "'" . $this->data['Alert']['friday'] . "'", 'Alert.saturday' => "'" . $this->data['Alert']['saturday'] . "'"), array('Alert.userId' => $user_id));
        $alert = $this->Alert->find('all', array('conditions' => array('Alert.userId' => $user_id), 'recursive' => 1));
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
            $this->set('alert', $alert);
            if ($update_day) {
                $this->Session->setFlash('Days updated successfully', 'default', null, 'success');
            } else {
                $this->Session->setFlash('Days cannot be updated', 'default', null, 'error');
            }
        } else {
            $this->Session->setFlash('no alerts set', 'default', null, 'error');
        }
    }

    function alert_response() {
        $this->autoRender = false;
        if (isset($_REQUEST['actions']) && isset($_REQUEST['callerid']) && isset($_REQUEST['number'])) {
            $callactions = $_REQUEST['actions'];
            $callerid = $_REQUEST['callerid'];
            $calledno = $_REQUEST['number'];
            $this->AlertResponse->create();
            $alert = $this->AlertResponse->save(array(
                'actions' => $callactions,
                'callerid' => $callerid,
                'number' => $calledno
                    ));
        }
    }

    function call_user() {
        $this->autoRender = false;
        $date = date('Y-m-d');
        $weekday = date('l', strtotime($date));
        $user_id = $this->Alert->find('list', array('conditions' => array($weekday => 1), 'recursive' => -1, 'fields' => array('userId')));
        $allres = $this->Alert->find('all', array('conditions' => array($weekday => 1), 'recursive' => -1, 'fields' => array('restaurantId', 'userId')));
        $user_phone = $this->User->find('all', array('conditions' => array('id' => $user_id), 'recursive' => -1, 'fields' => array('phone')));
        $reser_id = $this->Reservation->find('list', array('recursive' => -1, 'fields' => array('offerId')));
        $result = $this->Offer->find('all', array(
            'recursive' => -2,
            'fields' => array('restaurantId', 'seating', 'offerDate', 'offerTime'),
            'conditions' => array(
                'Offer.restaurantId' => $ale,
                'NOT' => array(
                    'Offer.id' => $reser_id
                ),
            )
                ));
        /* foreach($user_phone as $user) {
          $url = "https://secure.ifbyphone.com/click_to_xyz.php";
          $postvalue = 'app=cts&phone_to_call="'.$user['User']['phone'].'"&survo_id=376011&key=ac9e1ae41b9e459d7b14101fa13dc2b5569a87f6';
          $ch=curl_init();
          curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
          curl_setopt($ch,CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_POST,1);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$postvalue);
          curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $json=curl_exec($ch);
          //pr($json);
          } */
    }

    function change_day() {
        $userid = $this->Auth->user('id');
        $alert = $this->Alert->find('all', array(
            'conditions' => array(
                'Alert.userId' => $userid
            ),
            'recursive' => 1
                ));
        if (!empty($alert)) {
            if ($this->params['form']['id'] == 0) {
                $approved = 1;
                $this->Session->setFlash('Alert days was selected successfully', 'default', null, 'success');
            } else {
                $approved = 0;
                $this->Session->setFlash('Alert days was unselected successfully ', 'default', null, 'error');
            }
            $this->Alert->updateAll(array(
                'Alert.dayselect' => $approved), array('Alert.userid' => $userid)
            );
            $alert = $this->Alert->find('all', array(
                'conditions' => array(
                    'Alert.userId' => $userid
                ),
                'recursive' => 1
                    ));
            $this->set('alert', $alert);
        } else {
            $this->Session->setFlash('Restaurant not found', 'default', null, 'error');
        }
    }

    function alert_mail() {
        $this->autoRender = false;
        //$this->autoLayout=false;
        $date = date('Y-m-d');
        //$date = '2011-11-19';
        $weekday = date('l', strtotime($date));
        $user = $this->Alert->find('all', array('conditions' => array($weekday => 1,'from'=>'Web'), 'recursive' => -1, 'fields' => array('DISTINCT userId')));
        $sitename = Configure::read('website.name');
        //$user=array_unique($user);
        $reser_id = $this->Reservation->find('list', array('conditions' => array('approved' => 1), 'recursive' => -1, 'fields' => array('offerId')));
        if (!empty($user)) {
            $i = 0;
            $j = 0;
            foreach ($user as $use) {
                $users = $this->Alert->find('all', array('conditions' => array($weekday => 1,'from'=>'Web'), 'recursive' => -1, 'fields' => array('DISTINCT userId')));
                $time = date("H:i:s");
                if (!empty($users)) {
                    foreach ($users as $uses) {
                        /* $rand_string = $this->generateRandomString();
                          $this->set('rand_string',$rand_string); */
                        $res = $this->Alert->find('list', array('conditions' => array('userId' => $use['Alert']['userId'], 'sitename' => $sitename, $weekday => 1,'from'=>'Web'), 'recursive' => -1, 'fields' => array('restaurantId')));
                        $coun = count($res);
                        if ($coun >= 5) {
                            $this->set('count', $coun);
                        }
                        $seat = array(2 => 2, 3 => 4, 4 => 4);
                        $result = $this->Offer->find('all', array(
                            'recursive' => 2,
                            'fields' => array('id', 'restaurantId', 'seating', 'offerDate', 'offerTime'),
                            'conditions' => array(
                                'Offer.restaurantId' => $res,
                                'Offer.offerTime >=' => date("H:i:s"),
                                'Offer.offerDate' => $date,
                                'Offer.seating' => $seat,
                                'NOT' => array(
                                    'Offer.id' => $reser_id
                                ),
                                'Restaurant.approved'=>1
                            ),
                            'contain' => array(
                                'Restaurant' => array(
                                    'fields' => array(
                                        'name', 'slug_name'
                                    )
                                )
                            ),
                            'group' => 'Offer.restaurantId',
                            'order'=>array('Offer.offerTime DESC')
                                ));
                        $user_details = $this->User->find('all', array('conditions' => array('id' => $use['Alert']['userId'], 'account_type' => 3), 'recursive' => -1, 'fields' => array('email', 'id', 'email_subscription', 'devicetoken')));
                        $rand_string = '';
                        $alert_mail = array();
                        if (!empty($user_details) && !empty($result)) {
                            foreach ($result as $res) {
                                if ($user_details[0]['User']['email_subscription'] == 1) {
                                    //$restorent=$this->Restaurant->find('all',array('conditions'=>array('Restaurant.id'=>$res['Offer']['restaurantId'])));
                                    $time = date("h:i", strtotime($res['Offer']['offerTime']));
                                    $time_am = date("h:i a", strtotime($res['Offer']['offerTime']));
                                    $ampm = date("a", strtotime($res['Offer']['offerTime']));
                                    //$resservation = $this->Restaurant->tableAvailability($res['Offer']['restaurantId'],$time_am,$res['Offer']['seating']);
                                    $rand_string = $this->generateRandomString();
                                    //$email = $this->EmailTemplate->selectTemplate('Alerts mail');
                                    $alert_mail[$j]['id'] = $res['Restaurant']['slug_name'];
                                    $alert_mail[$j]['name'] = $res['Restaurant']['name'];
                                    $alert_mail[$j]['offdate'] = $res['Offer']['offerDate'];
                                    $alert_mail[$j]['time'] = $time;
                                    $alert_mail[$j]['time_am'] = $time_am;
                                    $alert_mail[$j]['seat'] = $res['Offer']['seating'];
                                    $alert_mail[$j]['am'] = $ampm;
                                }
                                $j++;
                            }
                        }
                    }
                    if (!empty($alert_mail)) {
                        $this->Email->from = 'support@tablesavvy.com';
                        $this->Email->replyTo = 'support@tablesavvy.com';
                        $this->Email->to = $user_details[0]['User']['email'];
                        $this->Email->subject = 'Reservation alerts';
                        $this->Email->template = 'alert_mail';
                        $this->Email->sendAs = 'html';
                        $this->set('alert_mail', $alert_mail);
                        $this->set('rand_string', $rand_string);
                        $num = count($alert_mail);
                        if ($this->Email->send()) {
                            $data = array('User' => array('id' => $user_details[0]['User']['id'], 'subscribe_email' => $rand_string));
                            $this->User->save($data, false, array('subscribe_email'));
                        }
                    }
                }
                $i++;
            }
        }
    }
    function testnotification(){
        Configure::write('debug', 2);
        $this->autoRender = false;
        $user_id = $_GET['user_id'];
        $user_details = $this->User->find('first', array('conditions' => array('id' => $user_id, 'account_type' => 3), 'recursive' => -1, 'fields' => array('email', 'id', 'email_subscription', 'devicetoken','source')));
        $devicetoken = $user_details['User']['devicetoken'];
        if (!empty($devicetoken)) {
                            
                            if($user_details['User']['source']=="Android"){
                                echo $this->gcm_push($devicetoken, 'test','');
                            }else{
                                echo $this->apns_push($devicetoken, 'test','');
                            }
//                            
    }else{
        echo 'Device token empty';
    }
        
        
    }
    function setPushNotification() {
        Configure::write('debug', 2);
        $this->autoRender = false;
        $date = date('Y-m-d');
//        echo $this->Auth->password('test');
//        $inf = $this->apns_push('9b55f75897d0ffa78d46319492848661feb83dbf12f8bf2ab952fdb5fb95dc30', 'test message','');
//          $inf = $this->gcm_push('APA91bEvQtDGLHcJlinNZQPeypYP1kuuMa-Vd_W9aXb5nMqlO0cHV0qpT5RJw2EKXfJQ6PH8wquxKlAhjAtIFAgg1z4_AF2OLkvCtW_bGUZL59jOaewxN2i1Jy0nbLOeAKbjPn5Rl0cS', 'test message','');
//        echo $inf;
        $weekday = date('l', strtotime($date));
        $user = $this->Alert->find('all', array('conditions' => array($weekday => 1,'from'=>'App'), 'recursive' => -1, 'fields' => array('DISTINCT userId')));
//        pr($user);
        $sitename = Configure::read('website.name');
        $reser_id = $this->Reservation->find('list', array('conditions' => array('approved' => 1), 'recursive' => -1, 'fields' => array('offerId')));
        if (!empty($user)) {
            $i = 0;
            $j = 0;
            foreach ($user as $use) {
                $users = $this->Alert->find('all', array('conditions' => array($weekday => 1,'from'=>'App'), 'recursive' => -1, 'fields' => array('DISTINCT userId')));
                $time = date("H:i:s");
                if (!empty($users)) {
                    foreach ($users as $uses) {
                        $res = $this->Alert->find('list', array('conditions' => array('userId' => $use['Alert']['userId'], 'sitename' => $sitename, $weekday => 1,'from'=>'App'), 'recursive' => -1, 'fields' => array('restaurantId')));
                        $coun = count($res);
                        if ($coun >= 5) {
                            $this->set('count', $coun);
                        }
                        $seat = array(2 => 2, 3 => 4, 4 => 4);
                        $result = $this->Offer->find('all', array('fields' => array('id', 'restaurantId', 'seating', 'offerDate', 'offerTime'),
                                                                  'conditions' => array('Offer.restaurantId' => $res,
                                                                                        'Offer.offerTime >' => date("H:i:s"),
                                                                                        'Offer.offerDate' => $date,
                                                                                        'Offer.seating' => $seat,
                                                                                        'NOT' => array('Offer.id' => $reser_id),
                                                                                        'Restaurant.approved'=>1),
                                                                  'recursive' => 2,
                                                                  'contain' => array('Restaurant' => array('fields' => array('name', 'slug_name'))),
                                                                  'group' => 'Offer.restaurantId'));
                        $user_details = $this->User->find('all', array('conditions' => array('id' => $use['Alert']['userId'], 'account_type' => 3), 'recursive' => -1, 'fields' => array('email', 'id', 'email_subscription', 'devicetoken','source')));
                        $rand_string = '';
                        $alert_mail = array();
                        if (!empty($user_details) && !empty($result)) {
                            foreach ($result as $res) {                                
                                    $alert_mail[] = $res['Restaurant']['name'];
                            }
                        }
                    }
                    if (!empty($alert_mail)) {
                        $rest_names = implode(',', $alert_mail);
                        $devicetoken = $user_details[0]['User']['devicetoken']; //'1ae223372c45bdd6ce6a73e17d6e17556a267bd5da81f94d67137e1a925c42b2';
                        if (!empty($devicetoken)) {
                            //To check the push notification users list
//                            echo 'Email   ' . $user_details[0]['User']['id'];
                            $message = 'Great news! We have last minute tables tonight for 30% off at ' . $rest_names;
//                            echo $user_details[0]['User']['id'];
//                             echo $user_details[0]['User']['source'];
//                             echo '<br>';
                            if($user_details[0]['User']['source']=="Android"){
                                $sender_info = $this->gcm_push($devicetoken, $message,'');
                            }else{
                                $sender_info = $this->apns_push($devicetoken, $message,'');
                            }
//                            echo $user_details[0]['User']['email'].'------> '.$message.'----> '.$user_details[0]['User']['source'].'-----> '.$sender_info.'<br/>';
                        }
                        $data = array('User' => array('id' => $user_details[0]['User']['id'], 'subscribe_email' => $rand_string));
                        $this->User->save($data, false, array('subscribe_email'));
                    }
                }
                $i++;
            }
        }
    }
    public function gcm_push($deviceToken,$message,$page=null){
        /*Project ID: development-application-44
        Project Number: 366328924362
        DEV API Key : AIzaSyDNYgSHoHU5Xcq9MD6vUpozezUOAwJr9kA
        PROD API Key :AIzaSyBLj_4n5YTiFAz49sWcXQA3ZZ8LUbaHhAA */
//        echo $deviceToken.'---';
//        echo $message.'<br>';
//        exit;
        $data = array( 'm' => $message );
        $ids = array( $deviceToken);
        $apiKey = 'AIzaSyBLj_4n5YTiFAz49sWcXQA3ZZ8LUbaHhAA';
        $url = 'https://android.googleapis.com/gcm/send';
        $post = array('registration_ids'=>$ids,'data'=>$data);
        $headers = array('Authorization: key=' . $apiKey,
                         'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
        $result = curl_exec( $ch );
        if ( curl_errno( $ch ) )
        {
            echo 'GCM error: ' . curl_error( $ch );
            $message = 'Message not delivered' . PHP_EOL;
        }else{
            $message = 'Message successfully delivered' . PHP_EOL;
        }
        curl_close( $ch );
//        if($page == 'page')
//            return $message;
//        else
            return $message;
    }
    
    public function apns_push($deviceToken,$message, $notificationType){
//        Configure::write('debug',0);
       /*** DEV configuration ***/
//        $passphrase = '';
//        $ctx = stream_context_create();
//        stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/html/tablesavvy/Certificates-TS-Dev-cert-key.pem');
//        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
//        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
//        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        /*** End DEV Configuration ***/
        
        /*** PROD configuration ***/
        $passphrase = '';
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/tablesavvy.com/html/tablesavvyprodpushcertificate-cert-key.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        /*** End PROD Configuration ***/
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
//        echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body
        $body['aps'] = array('alert' => $message,'sound' => 'default','notification_type'=>$notificationType);
        // Encode the payload as JSON 
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
        if (!$result)
            $message = 'Message not delivered' . PHP_EOL;
        else
            $message = 'Message successfully delivered' . PHP_EOL;
        // Close the connection to the server
        fclose($fp);
        return $message;
    }
    function subscribe_email($string = null) {
        $this->layout = 'home';
        if (!empty($string)) {
            $count = $this->User->find('count', array(
                'conditions' => array(
                    'subscribe_email' => $string
                ),
                'recursive' => -1
                    ));

            if ($count > 0) {
                $userid = $this->User->find('first', array(
                    'conditions' => array(
                        'subscribe_email' => $string
                    ),
                    'recursive' => -1
                        ));
                $this->User->updateAll(array('email_subscription' => 0), array('User.id' => $userid['User']['id']));
                //$this->set('sub','success');
                $this->Session->setFlash('You have unsubscribed successfully.', 'default', null, 'success');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                //$this->set('sub1','unsuccess');
                $this->Session->setFlash('Invalid Email id', 'default', null, 'error');
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            }
        }
    }

    function clear_offerdate() {
        $this->autoRender = false;
        echo $date = date('Y-m-d');
    }

    public function sendpush($device_tokens, $message) {
        define('APPKEY', 'mVmZzNSWT_mYTtwBiTpccw');      // Test PROD APPKEY - TN4CoPYCSV6CfdmUAaE9TA	
        define('PUSHSECRET', 'lGvMKbmHQjGbMo9Z6wuYhA'); // Test PROD App Master Secret - VHBmKUVLSw2G4alQicQLMg
        define('PUSHURL', 'https://go.urbanairship.com/api/push/');

        $contents = array();

        //$contents['badge'] = $awaitingCount;
        $contents['alert'] = $message;
        //$contents['type'] = $type;
        //$contents['id'] = $id;
        $push = array("aps" => $contents, "device_tokens" => array($device_tokens));

        $json = json_encode($push);

        $session = curl_init(PUSHURL);
        curl_setopt($session, CURLOPT_USERPWD, APPKEY . ':' . PUSHSECRET);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $json);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $content = curl_exec($session);
        //echo $content; // just for testing what was sent
        // Check if any error occured
        $response = curl_getinfo($session);

        /* if($response['http_code'] != 200) {
          return "Got negative response from server, http code: ".$response['http_code'] . "\n";
          }else{
          return "Wow, it worked!\n";
          } */
    } 
        public function sendpush_android($devicetoken, $message){
//        Configure::write('debug',2);
	define('DROID_APPKEY', 'mVmZzNSWT_mYTtwBiTpccw');        //	//c72_tFsjTEO4snIuZxkFfg	
	define('DROID_PUSHSECRET', 'lGvMKbmHQjGbMo9Z6wuYhA'); // App Master Secret	//	//OmDG2UDeQi-KWU8ldRVYOw
	define('DROID_PUSHURL', 'https://go.urbanairship.com/api/push/');

	$contents = array();

	//$contents['badge'] = $awaitingCount;
	$contents['alert'] = $message;
	$push = array("apids" => array($devicetoken), "android" => $contents);

	$json = json_encode($push);
	$session = curl_init(DROID_PUSHURL);
	curl_setopt($session, CURLOPT_USERPWD, DROID_APPKEY . ':' . DROID_PUSHSECRET);
	curl_setopt($session, CURLOPT_POST, true);
	curl_setopt($session, CURLOPT_POSTFIELDS, $json);
	curl_setopt($session, CURLOPT_HEADER, false);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	$content = curl_exec($session);
	
	// Check if any error occured
	$response = curl_getinfo($session); 
	if($response['http_code'] != 200) {
		return "Got negative response from server, http code: ".$response['http_code'] . "\n";
	}else{
		return  "Wow, it worked!\n";
	} 
    }
}
/*
if (!empty($alert_mail)) {
    $devicetoken = $user_details[0]['User']['devicetoken']; //'1ae223372c45bdd6ce6a73e17d6e17556a267bd5da81f94d67137e1a925c42b2';
    $done=0;
    if(empty($devicetoken)){
        $this->Email->from = 'support@tablesavvy.com';
        $this->Email->replyTo = 'support@tablesavvy.com';
        $this->Email->to = $user_details[0]['User']['email'];
        $this->Email->subject = 'Reservation alerts';
        $this->Email->template = 'alert_mail';
        $this->Email->sendAs = 'html';
        $this->set('alert_mail', $alert_mail);
        $this->set('rand_string', $rand_string);
        $num = count($alert_mail);
        if ($this->Email->send()){
            $done = 1;
        }    
    }else{
        //To check the push notification users list
        $alt = array();
        foreach ($alert_mail as $alert) {
            $alt[] = $alert['name'];
        }
        $rest_names = implode(',', $alt);
        echo 'Email   ' . $user_details[0]['User']['email'];
        $message = 'Great news! We have last minute tables tonight for 30% off at ' . $rest_names;
        echo '    ---   ' . $message;
        echo '<br>';
        $sender_info = $this->sendpush($devicetoken, $message);
        $done = 1;
    }
    if($done == 1){
        $data = array('User' => array('id' => $user_details[0]['User']['id'], 'subscribe_email' => $rand_string));
        $this->User->save($data, false, array('subscribe_email'));
    }
}
*/
?>
