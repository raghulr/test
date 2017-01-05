<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...

 */
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'pdf', 'kml', 'xml', 'mobile');

Router::connect('/admin/:controller/:action/', array(
  'controller' => 'table',
  'action' => 'addtable',
  'admin' => true
));
Router::connect('/admin/:controller/:action/', array(
  'controller' => 'table',
  'action' => 'deletetable',
  'admin' => true
));
/************************************************SUPER ADMIN *************************************************************/
Router::connect('/super/:controller/:action/*', array(
  'prefix' => 'super',
  'super' => true
));
/***********************************************SUPER ADMIN***************************************************************/

Router::connect('/search/*', array(
  'controller' => 'homes',
  'action' => 'search'
));
//Router::connect('/contactus', array('controller' => 'contacts', 'action' => 'add', array('id' => '[0-9]+')));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/', array(
  'controller' => 'homes',
  'action' => 'index'
));
//Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
Router::connect('/home', array(
  'controller' => 'homes',
  'action' => 'index'
));
Router::connect('/hoteltonight', array(
  'controller' => 'homes',
  'action' => 'hoteltonight'
));
Router::connect('/available/*', array(
  'controller' => 'homes',
  'action' => 'index'
));
//changes while we use specialoffer page it redirect to index page
Router::connect('/specialoffer', array(
  'controller' => 'homes',
  'action' => 'index'
));
// Router::connect('/ios/mobile', array('controller' => 'homes', 'action' => 'appredirect'));
//Router::connect('/web-email/mobile', array('controller' => 'homes', 'action' => 'appredirect'));
//users
Router::connect('/users/subscribe', array(
  'controller' => 'users',
  'action' => 'subscribe'
));
Router::connect('/register', array(
  'controller' => 'users',
  'action' => 'register'
));
Router::connect('/login/*', array(
  'controller' => 'users',
  'action' => 'login'
));
Router::connect('/forgot_password', array(
  'controller' => 'users',
  'action' => 'forgot_password'
));
Router::connect('/homes/login/*', array(
  'controller' => 'users',
  'action' => 'login'
));
//homes
Router::connect('/howitworks', array(
  'controller' => 'homes',
  'action' => 'howitworks'
));
Router::connect('/faq', array(
  'controller' => 'homes',
  'action' => 'faq'
));
Router::connect('/privacypolicy', array(
  'controller' => 'homes',
  'action' => 'privacypolicy'
));
Router::connect('/returnpolicy', array(
  'controller' => 'homes',
  'action' => 'returnpolicy'
));
Router::connect('/terms', array(
  'controller' => 'homes',
  'action' => 'terms'
));
Router::connect('/all_restaurant', array(
  'controller' => 'homes',
  'action' => 'all_restaurant'
));
Router::connect('/reservations/*', array(
  'controller' => 'homes',
  'action' => 'reservation'
));
//profiles
Router::connect('/profile', array(
  'controller' => 'profiles',
  'action' => 'index'
));
Router::connect('/profile/index/*', array(
  'controller' => 'profiles',
  'action' => 'index'
));
Router::connect('/profile/alerts', array(
  'controller' => 'profiles',
  'action' => 'alerts'
));
Router::connect('/profile/history', array(
  'controller' => 'profiles',
  'action' => 'history'
));
Router::connect('/profile/profile', array(
  'controller' => 'profiles',
  'action' => 'profile'
));
Router::connect('/profile/profile/*', array(
  'controller' => 'profiles',
  'action' => 'profile'
));
Router::connect('/profile/change_reservation', array(
  'controller' => 'profiles',
  'action' => 'change_reservation'
));
Router::connect('/profile/select_address/*', array(
  'controller' => 'profiles',
  'action' => 'select_address'
));
Router::connect('/profile/location', array(
  'controller' => 'users',
  'action' => 'location'
));
Router::connect('/profile/edit_location/*', array(
  'controller' => 'users',
  'action' => 'edit_location'
));
Router::connect('/profile/invitation/*', array(
  'controller' => 'users',
  'action' => 'send'
));
//Contacts
Router::connect('/contactus/*', array(
  'controller' => 'contacts',
  'action' => 'contactus'
));
//users
Router::connect('/details/*', array(
  'controller' => 'homes',
  'action' => 'details'
));
Router::connect('/chicagomag/*', array(
  'controller' => 'homes',
  'action' => 'index'
));
Router::connect('/pages/*', array(
  'controller' => 'pages',
  'action' => 'display'
));

Router::connect('/widgets/time_widget/*', array(
  'controller' => 'widgets',
  'action' => 'time_list'
));
