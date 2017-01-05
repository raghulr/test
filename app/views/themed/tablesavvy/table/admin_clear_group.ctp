<style type="text/css">
a:link    {
  text-decoration:  none;
  color: white;
  } 
a:visited {
  text-decoration:  none;
  color: white;
  } 
a:hover   {
  text-decoration:  underline;
  color: white;
  } 
a:active  {
  text-decoration:  underline;
  color: white;
  } 
input{
	width:64px !important;
}
.tabl_cont{
	height:600px;
}
.container_cont .navi_content{
	min-height:648px;
}

.pag_normal a {
  color:#000000;
  font-family:Diavlo, Arial, Helvetica, sans-serif;
  font-weight:bold;
  text-decoration:none;
}
</style>
<div class="cont_navi">
    <ul class="navigation">
        <li><?php echo $html->link('Tables',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
        <li class="active_link"><?php echo $html->link('Table Dashboard',array('controller'=>'table','action'=>'admin_clear_group')); ?></li>
        <li><?php echo $html->link('Reservations',array('controller'=>'reservations','action'=>'index')); ?></li>
        <li><?php echo $html->link('History',array('controller'=>'history','action'=>'index')); ?></li>
        <li><?php echo $html->link('Profile',array('controller'=>'restaurants','action'=>'profile')); ?></li>
    </ul>
</div>
<div class="navi_content">
	<div class="head_group">
        <div class="res_name"><?php echo $restdetail['Restaurant']['name'];?></div>
        <div class="res_name1"><a href="<?php echo $html->url(array('controller'=>'table','action'=>'recurringtable'),true).'?date='.date('Y-m-d'); ?>" class="colorbox-addrec"><?php echo $html->image('/images/addrecurr.png',array('border'=>0,'width'=>174,'height'=>30)); ?></a>
    	</div>
    </div>
    <div class="res_tabl">
    	<div class="tabl_head">
        	<div class="time_reserve_new"><span id="cancel_new">Posted Date & Time Stamp</span></div>
            <div class="phone phone_new"><span id="cancel_new">Party Size</span></div>
            <div class="phone phone_new"><span id="cancel_new">Time</span></div>
            <div class="time_reserve_new1"><span id="cancel_new">Day</span></div>
            <div class="seat"><span id="cancel_new">Start Date</span></div>
            <div class="seat"><span id="cancel_new">End Date</span></div>
            <div class="seat seat_new"><span id="cancel_new">Tables/Day</span></div>
            <div class="seat seat_del"><span id="cancel_new">Delete</span></div>
        </div>
        <div class="tabl_cont">
            <?php 
			$i = 1;
                $class='fist_row';
			foreach($offer as $user){?>
           		<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                    <div class="time_reserve_new"><span id="time_no"><?php echo $user['Offer']['created_time']; ?></span></div>
                    <div class="l_name_new"><span id="pa_no"><?php 
						if($user['Offer']['seating']==2)
							echo $user['Offer']['seating'];
						elseif($user['Offer']['seating']==4)
							echo '3/'.$user['Offer']['seating'];
						elseif($user['Offer']['seating']==6)
							echo '5/'.$user['Offer']['seating'];
						else
							echo '7/'.$user['Offer']['seating'];
					?></span></div>
                    <div class="l_name_new"><span id="pa_no"><?php $off_time=strtotime($user['Offer']['offerTime']); echo date('h:i a',$off_time); ?></span></div>
                    <div class="time_reserve_new1">
                    	<span id="pa_no" style="margin:16px 0 0 8px;">
                    		<?php 
								if($user['Offer']['offer_day']=='Every Day'){
									echo $user['Offer']['offer_day']; 
								}else{
									$new_offer=$offer_day->get_days($user['Offer']['content']);
									foreach( $new_offer as $key => $value ) {
                                                                                if($value['Offer']['offer_day']=='next day'){
                                                                                    $timestamp = strtotime($user[0]['sdate']);
                                                                                    $day = date('D', $timestamp);                                                                                    
                                                                                }
                                                                                if($value['Offer']['offer_day']=='next sunday' || $day=='Sun')
												echo 'Su,';
										elseif($value['Offer']['offer_day']=='next monday' || $day=='Mon')
											echo 'M,';
										elseif($value['Offer']['offer_day']=='next tuesday' || $day=='Tue')
											echo 'Tu,';
										elseif($value['Offer']['offer_day']=='next wednesday' || $day=='Wed')
											echo 'W,';
										elseif($value['Offer']['offer_day']=='next thursday' || $day=='Thu')
											echo 'Th,';
										elseif($value['Offer']['offer_day']=='next friday' || $day=='Fri')
											echo 'F,';
										else
											echo 'Sa,';
									}
								}
							?>
                    	</span>
                    </div>
                    <div class="l_name_new1"><span id="f_name_text"><?php echo $user[0]['sdate']; ?></span></div>
                    <div class="l_name_new1"><span id="f_name_text"><?php echo $user[0]['edate']; ?></span></div>
                    <div class="l_name_new1 l_name_new2"><span id="party_no">
					<?php 
						//echo $user[0]['total'];
						//$date = date("Y-m-d");
						//if($date==$user[0]['sdate']){
							$row=mysql_fetch_array(mysql_query("select count(offers.id) from offers where offers.content='".$user['Offer']['content']."' AND offers.offerDate='".$user[0]['sdate']."' AND offers.restaurantId='".$restdetail['Restaurant']['id']."'"));
							echo $row[0];
						//}else{
							//echo '0';
						//} 
					?></span></div>
                    <div class="l_name_new1 l_name_new3"><span id="party_no"> 
                    <?php $time_url = $html->url(array('controller'=>'table','action'=>'delete_group',$user['Offer']['content']),true); ?>
                <a href="javascript:;" onclick="return delete_con('<?php echo $time_url; ?>');"><?php echo $html->image('/images/close.png',array('width'=>33,'height'=>34,'border'=>0)); ?></a></span></div>    
			</div>
			<?php $i++; } ?>
       
        <div id="nor_page">
            <?php if(!empty($offer)){ // class="pagination" ?>   
             <div style="width:850px; margin:10px 10px 20px 0; float:right;" class="pag_normal">
            <span style="float:right">  
            <?php 
				if($this->Paginator->numbers())
				{
					echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
					echo $this->Paginator->numbers();	?> &nbsp; <?php
					echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
				}
            ?> 
            </span>
            </div>
            <?php }//else{ ?>
				<!-- <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No Restaurant Found
				 </div>-->
			<?php //} ?>
         </div>
          </div>
    </div>
</div>
<div class="navi_botom"></div>