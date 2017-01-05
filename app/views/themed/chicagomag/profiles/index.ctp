<?php 
	$javascript->link('jquery.jcarousel', false);
	$javascript->link('jquery.alerts', false);
	
        echo $html->css('jquery.alerts', null, null, false);
        echo $html->css('skin_new', null, null, false);
?>
<div id="messages"></div>
<div id="page-body-right" class="reservation_details">
   <?php echo $this->element('navigation'); ?>
    <div id="content" class="clearfix">
        <div id="content-header" class="hatched clearfix">
            <ul>
                <li class="on">My Reservation</li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>">Alerts</a></li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>">History</a></li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>">Profile</a></li>
            <ul>
        </div>
        <ul id="mycarousel" class="jcarousel-skin-tango">
        <?php 
            $count=0; 
            if(!empty($restaurant_details)){	
                
                foreach($restaurant_details as $profile_details){
                $res_id = $profile_details['Offer']['Restaurant']['id'];
                $res_name = $profile_details['Offer']['Restaurant']['name'];
        ?>
            <li>
            <div class="content">
                <?php /*<div class='float reservation_left'>
                <?php 
                if(!empty($profile_details['Offer']['Restaurant']['logo'])): 
                    echo $html->image('original/'.$profile_details['Offer']['Restaurant']['logo'],array('border'=>0,'width'=>240,'class'=>'float margin-right'));  
                endif;
                ?> 
                    <p class="smaller" style="padding-top: 135px;text-align: center;float: left;">Thanks for using <?php Configure::read('website.name');?> to make this reservation</p>    
<!--                <a href="<?php echo $html->url('/',true);?>" class='float margin-right reservation_logo'>
                    <?php echo $html->image('/images/TableSavvy_logo.png',array('width'=>150,'height'=>39, 'class'=>'logo', 'alt'=>'[ Powered by TableSavvy ]' ));?>
                </a>-->
                </div>
                 * 
                 */?>
                <div id="confirmation">
                    <p class="smaller reverse no-bottom-margin">Tonight&rsquo;s reservation is confirmed for</p>
                    <?php 
                        $city_id = $profile_details['Offer']['Restaurant']['city'];
                        $row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
                        $city_name= $row['city_name']; 
                        $starttime=strtotime($profile_details['Offer']['offerTime']);
                        ?>    
                    <h1><?php echo $res_name; ?></h1>

                    <p class="data">
                        <?php echo $profile_details['Offer']['Restaurant']['address'];?><br>
                         <span class="smaller"><?php echo ucfirst($city_name).", ".strtoupper($profile_details['Offer']['Restaurant']['state']);?><br>
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
                        <?php $resurl = $profile_details['Offer']['Restaurant']['url']; ?>
                    <?php echo $html->link($resurl,$resurl,array('target'=>'_blank'));  ?></span></p>
                    <table id="confirmationTable">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Party size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="restuaranttime_<?php echo $starttime.'_'.$res_id;?>">
                                    <?php 
                                    echo date('h:i A',$starttime); 
                                    ?>
                                </td>
                                <td id="restuarantsize_<?php echo $starttime.'_'.$res_id;?>"">
                                    <?php if($profile_details['Offer']['seating_custom']!=0)                                            
                                        $party_size = $profile_details['Offer']['seating_custom']; 
                                    else
                                        $party_size = $profile_details['Offer']['seating']; 
                                    echo $party_size;    
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p  class="smaller">Please note that this discount does not include alcohol, tip or tax.</p>
                    <p  class="smaller">No Voucher or Coupon is needed. Just dine and save!</p>
                    <p  class="smaller">Thanks for using TableSavvy to make this reservation.</p>
                    <p class="smaller no-bottom-margin">Share via</p>
                    <?php
                    $share_url = 'www.TableSavvy.com';
					$title = Configure::read('website.name');
					$redirecturl=$html->url(array('controller'=>'profiles','action'=>'index'),true);
                    $text = 'I just got a last minute reservation at '.$res_name.' using TableSavvy! Check out TableSavvy for yourself at www.TableSavvy.com';                    
                    ?>
                    <a href="http://twitter.com/share?url=<?php echo $share_url ?>&amp;text=<?php echo $text;?>&amp;lang=en" target="_blank">
                        <?php echo $html->image('/images/twitter.png',array('width'=>60,'height'=>29));?>
                    </a>
                   <?php /*?> <a href="http://www.facebook.com/sharer.php?s=100&p[title]=<?php echo $title;?>&p[url]=<?php echo urldecode($share_url);?>&p[summary]=<?php echo $text; ?>" target="_blank"><?php */?>
                   <a href="https://www.facebook.com/dialog/feed?app_id=<?php echo Configure::read('website.fbId');?>&link=<?php echo urldecode($share_url);?>&name=<?php echo $title;?>&description=<?php echo $text; ?>&redirect_uri=<?php echo $redirecturl; ?>">
                        <?php echo $html->image('/images/facebook.png',array('width'=>60,'height'=>29));?>
                    </a>

                    <div class="btn-group-wrap">
                        <div id="changeReservation" class="btn-group margin-bottom btn-group-center">
                                <?php 
                                $transactionId = '';
                                $transactionId = $profile_details['Reservation']['transactionId'];
                                $reservation_id=$profile_details['Reservation']['id'];
                                $offerdate = $profile_details['Offer']['offerDate']; 
                                $offer_id = $profile_details['Offer']['id'];
                                $offer_time = date('h:i',$starttime);
                                $ampm = date('A',$starttime);
                            ?>
                            <?php echo $html->link('Send invitations',array('controller'=>'users','action'=>'send',$transactionId),array('class'=>'btn btns-invite'));?>   
                            <?php 
                                $map_url="http://maps.google.co.in/maps?gcx=w&q=".$city_name.", ".$profile_details['Offer']['Restaurant']['state']."+&um=1&ie=UTF-8&hl=en&sa=N&tab=wl";
                                $classmap='';
                                $map_array = array('class'=>'btn '.$classmap, 'target'=>'_blank');
                                if(!empty($user_location)){ 
                                    $map_url=$html->url(array('controller'=>'profiles','action'=>'select_address',$transactionId),true);
                                    $classmap='btn-map';
                                    $map_array = array('class'=>'btn '.$classmap);
                                }
                                echo $html->link('Directions',$map_url,$map_array);  
                        ?>
                            <?php 
                                $change_time_url = $html->url(array('controller'=>'profiles','action'=>'change_reservation'),true);
                                $change_time_url .= '?party='.$party_size.'&offer_id='.$offer_id.'&time='.$offer_time.'&ampm='.$ampm.'&rest_id='.$res_id.'&reservation_id='.$reservation_id.'&count='.$count;
                                echo $html->link('Change reservation',$change_time_url,array('class'=>'btn','onclick'=>'return change_reservation("'.$change_time_url.'")'));
                        ?>
                        <?php
                            $time_url = $html->url(array('controller'=>'profiles','action'=>'cancel',$reservation_id),true); 
                            $red_url = $html->url(array(
								'controller'=>'profiles',
								'action'=>'index',
								'?' => 'cancel=cancel&firstName='.base64_encode($auth->user('firstName')).'&lastName='.base64_encode($auth->user('lastName')).'&offerid='.base64_encode($offer_id)
								),
							true);
                            echo $html->link('Cancel reservation','javascript:;',array('class'=>'btn','onclick'=>'return cancel_reservation("'. $time_url.'","'. html_entity_decode($red_url).'","'.$party_size.'","'.$profile_details['Offer']['seating_custom'].'");'));			
                        ?>
                        </div>
                    </div>
                </div><!--/#confirmation -->

            </div><!--/.content -->
        </li>
                    
        <?php 
            $count++;
				//if(isset($_REQUEST['firstName'])&&isset($_REQUEST['lastName'])&&isset($_REQUEST['offerid'])){
//					$survo_id = 577504; 
//					$ifby->ifbyphone(base64_decode($_REQUEST['firstName']),base64_decode($_REQUEST['lastName']),$offer_times,$restaurant,$survo_id);
//				}
            }
        
            }else{?>
        <li><div class="content" style="height: 300px;">You have no scheduled reservations for tonight</div></li>
        <?php } ?>
        </ul>
    </div><!-- /#content -->
</div>
<?php if($count!=0){ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        reservation_details_scroll();
    });
</script>
<?php } if(isset($_REQUEST['firstName'])&&isset($_REQUEST['lastName'])&&isset($_REQUEST['offerid'])){
		$fname = base64_decode($_REQUEST['firstName']);
		$lname = base64_decode($_REQUEST['lastName']);
		if(isset($cancel)){
			$survo_id = 575244;
		}else if(isset($modify)){
			$survo_id = 575254;
		}else{
			$survo_id = 577504;
		}
		$seating = $offer_times['Offer']['seating'];
		$offer_time = base64_encode($offer_times['Offer']['offerTime']);
		$phone = base64_encode($restaurant['Restaurant']['phone']);
		//pr($offer_times);
		$url=$html->url(array('controller'=>'profiles','action'=>'ifbyphone',$fname,$lname,$offer_time,$seating,$phone,$survo_id),true);
		//$ifby->ifbyphone(base64_decode($_REQUEST['firstName']),base64_decode($_REQUEST['lastName']),$offer_times,);
	?>
		<script type="text/javascript">
			$(document).ready(function(){
				$.ajax({
					url: '<?php echo $url; ?>',
					success: function(data) {
						//alert(data);
					}
				});
			});
		</script>
<?php
	}
?>