<?php
  $user = $session->read( 'Auth.User' );
  $user_amount= Configure::read('user.user_amount');
?>
<div class="ui body container profile">
  <?php if ($user_amount > 0) { ?>
  <div class="ui icon message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        You have a $<?php echo $user_amount ?> credit in your account
      </div>
      <p>Your next reservation is on us.</p>
    </div>
    <a href="/all_restaurant" class="ui button basic right floated">Book Now</a>
  </div>
  <?php }
  $javascript->link('jquery.jcarousel', false);
  $javascript->link('jquery.alerts', false);
  echo $html->css('jquery.alerts', null, null, false);
    echo $html->css('skin_new', null, null, false);
  $url_home = $html->url(array('controller'=>'homes'),true);
  $url_profile = $html->url(array('controller'=>'profiles'),true);
?>
<script language="javascript1.1" type="text/javascript">
    noBack('<?php echo $url_home; ?>','<?php echo $url_profile; ?>');
</script>
<div id="messages"></div>

<div class="ui grid stackable">
  <div class="four wide column">
    <?php echo $this->element('profile_sidebar', array('active' => 'index')); ?>
  </div>
  <div class="twelve wide column">
    <div>
      <div id="content">

          <div class="ui divided items">
            <?php
              $count=0;
              if(!empty($restaurant_details)){

                foreach($restaurant_details as $profile_details){
                  $res_id = $profile_details['Offer']['Restaurant']['id'];
                  $res_name = $profile_details['Offer']['Restaurant']['slug_name'];
                  $url = $html->url(array('controller'=>'homes', 'action'=>'details',$res_name),true);
                  $res_name = $profile_details['Offer']['Restaurant']['name'];

                  // If custom seating                  
                  if($profile_details['Offer']['seating_custom']!=0)
                    $party_size = $profile_details['Offer']['seating_custom'];
                  else
                    $party_size = $profile_details['Offer']['seating'];
                      
                  // Find city name
                  $city_id = $profile_details['Offer']['Restaurant']['city'];
                  $row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
                  $city_name= $row['city_name'];
                  // start time
                  $starttime=strtotime($profile_details['Offer']['offerTime']);
              ?>
              
              
              
              <div class="item">
                <div class="image">
                  <img src="/img/original/<?php echo $profile_details['Offer']['Restaurant']['logo'] ?>" />
                </div>
                <div class="content">
                  <a class="header"><i class="icon bookmark"></i> Tonight&rsquo;s reservation:</a>
                  <div class="meta">
                    <span class="cinema"><?php echo $party_size; ?> Guests for <?php echo date('g:i A',$starttime); ?> at <a class="profile_res" href="<?php echo $url;?>"><?php echo $res_name; ?></a></span>
                  </div>
                  <div class="description">
                    <p class="data data_new detail-address">
                      <span class="address">
                        <?php echo $profile_details['Offer']['Restaurant']['address'];?>
                      </span>
                      <br/>
                        <?php $phone = $profile_details['Offer']['Restaurant']['phone'];
                          $phone_number = '';
                          $phone = str_replace('(', '', $phone);
                          $phone = str_replace(')', '', $phone);
                          $phone = str_replace('-', '', $phone);
                          $phone = str_replace(' ', '', $phone);
                          $phone_number .= '('.substr($phone,0,3).')';
                          $phone_number .= '-'. substr($phone,3,3).'-';
                          $phone_number .= substr($phone,6,4);
                          echo $phone_number;
                        ?><br>
                        <?php
                          $resurl = parse_url($profile_details['Offer']['Restaurant']['url']);
                          if(!empty($resurl['scheme'])&&!empty($resurl['host'])) {
                            $rest_url = $resurl['scheme'].'://'.$resurl['host'];
                              if(isset($resurl['path'])) {
                              $rest_url = $rest_url.$resurl['path'];
                            }
                          }
                          if(!in_array("http", $resurl)) {
                            $rest_url = "http://".$resurl['path'];
                          }
                        ?>
                      </span>
                    </p>
                    <p class="smaller detail-smaller ">No voucher or coupon is needed. Just give the hostess your name, dine, and save 30%!</p>
                    
                    <?php
                    $share_url = 'www.'.Configure::read('website.name').'.com';
                    $title = Configure::read('website.name');
                    $redirecturl=$html->url(array('controller'=>'profiles','action'=>'index'),true);
                    $text = 'I just got a last minute reservation at '.$res_name.' using @'.Configure::read('website.name').'! Check out '.Configure::read('website.name').' for yourself at www.'.Configure::read('website.name').'.com';
                  ?>
                  <div class="share">Share: 
                    <a href="http://twitter.com/share?url=<?php echo $share_url ?>&amp;text=<?php echo $text;?>&amp;lang=en" target="_blank">
                      <i class="icon twitter square"></i>
                    </a>
                    <?php  $shareurl= $html->url(array('controller'=>'profiles','action'=>'share'),true); ?>
                    <?php if (!preg_match('/iPhone|iPod|iPad|BlackBerry|Android|X11/', $_SERVER['HTTP_USER_AGENT'])){ ?>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('https://www.tablesavvy.com/?invitation='.$text);?>" target="_blank" id="fbshares"> 
                        <i class="icon facebook square"></i>
                      </a>
                      <?php }else{ ?>
                        <a href="https://www.facebook.com/dialog/feed?app_id=<?php echo Configure::read('website.fbId');?>&link=<?php echo urldecode($share_url);?>&picture=<?php echo $image; ?>&name=<?php echo $title;?>&description=<?php echo $text; ?>&redirect_uri=<?php echo $redirecturl; ?>"><?php echo $html->image('/images/facebook.png',array('width'=>60,'height'=>29));?></a>
                        <?php } ?>
                  </div>
                  </div>
                  <div class="extra">
                      <?php
                          $transactionId = '';
                          $transactionId = $profile_details['Reservation']['transactionId'];
                          $reservation_id=$profile_details['Reservation']['id'];
                          $offerdate = $profile_details['Offer']['offerDate'];
                          $offer_id = $profile_details['Offer']['id'];
                          $offer_time = date('h:i',$starttime);
                          $ampm = date('A',$starttime);
                          
                          $change_time_url = $html->url(array('controller'=>'profiles','action'=>'change_reservation'),true);
                          $change_time_url .= '?party='.$party_size.'&offer_id='.$offer_id.'&time='.$offer_time.'&ampm='.$ampm.'&rest_id='.$res_id.'&reservation_id='.$reservation_id.'&count='.$count;
                      ?>
                    <div class="ui label">
                      <?php echo $html->link('Send invitations',array('controller'=>'profile','action'=>'invitation',$transactionId),array('class'=>'btn btns-invite details-btn'));?>
                    </div>
                    <div class="ui label">
                      <?php
                          $map_url="http://maps.google.co.in/maps?gcx=w&q=".$city_name.", ".$profile_details['Offer']['Restaurant']['state']."+&um=1&ie=UTF-8&hl=en&sa=N&tab=wl";
                          $classmap='';
                          $map_array = array('class'=>'btn details-btn'.$classmap, 'target'=>'_blank');
                          if(!empty($user_location)){
                              $map_url=$html->url(array('controller'=>'profile','action'=>'select_address',$offer_id),true);
                              $classmap='btn-map';
                              $map_array = array('class'=>'btn details-btn '.$classmap);
                          }
                          echo $html->link('Directions',$map_url,$map_array);
                      ?>
                    </div>
                    <div class="ui label">
                      <?php echo $html->link('Change reservation',$change_time_url,array('class'=>'btn details-btn')); ?>
                    </div>
                    <div class="ui label">
                      <?php echo $html->link('Website',$rest_url,array('target'=>'_blank'));  ?>
                    </div>
                    <div class="ui label">
                     <?php
                      $time_url = $html->url(array('controller'=>'profiles','action'=>'cancel',$reservation_id),true);
                      $red_url = $html->url(array(
                        'controller'=>'profiles',
                        'action'=>'index',
                        '?' => 'cancel=cancel&firstName='.base64_encode($auth->user('firstName')).'&lastName='.base64_encode($auth->user('lastName')).'&offerid='.base64_encode($offer_id).'&custom_seating='.$party_size
                        ),
                      true);
                      echo $html->link('Cancel reservation','javascript:;',array('class'=>'btn details-btn','onclick'=>'return cancel_reservation("'. $time_url.'","'. html_entity_decode($red_url).'","'.$party_size.'","'.$profile_details['Offer']['seating_custom'].'");'));
                  ?>
                  </div>
                </div>
              </div>
            </div>
            <?php
                $count++;

          }
          ?>
          <p><small>Please note that this discount does not include alcohol, tip or tax.<br /> This discounted reservation is for first available seating only, and is not valid with other offers.</small></p>
          <?php
                }else{?>
            <div class="content" style="height: 300px;">You have no scheduled reservations for tonight</div>
            <?php } ?>
            </div>
        </div>
    </div>
    <?php if($count != 0){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            reservation_details_scroll();
        });
    </script>
    <?php }
      if(isset($_REQUEST['firstName'])&&isset($_REQUEST['lastName'])&&isset($_REQUEST['offerid'])){
        $fname = base64_decode($_REQUEST['firstName']);
        $lname = base64_decode($_REQUEST['lastName']);
        if(isset($cancel)){
          $survo_id = 588354;
          //575244
        }else if(isset($modify)){
          $survo_id = 588344;
          //575254
        }else{
          $survo_id = 587924;
          //575244
        }
        $seating = isset($custom_seating)?$custom_seating:$offer_times['Offer']['seating'];
        $offer_time = base64_encode($offer_times['Offer']['offerTime']);
        $phone = base64_encode($restaurant['Restaurant']['phone']);
        //pr($offer_times);
        $url=$html->url(array('controller'=>'profiles','action'=>'ifbyphone_save',$fname,$lname,$offer_time,$seating,$phone,$survo_id),true);
        //$ifby->ifbyphone(base64_decode($_REQUEST['firstName']),base64_decode($_REQUEST['lastName']),$offer_times,);
      ?>
        <?php /*?><script type="text/javascript">
          $(document).ready(function(){
            $.ajaxSetup({
                            async:true//set a global ajax requests as asynchronus

                        });
            $.ajax({
              url: '<?php echo $url; ?>',
              timeout:3000,
              cache:false,
              global:false,
              success: function(data) {
                //alert(responseText);
              }
            });
          });
        </script><?php */?>
    <?php
      }
    ?>
</div>
</div>
</div>
