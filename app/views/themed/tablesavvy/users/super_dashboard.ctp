<style>
input {margin: 1px;width: 74px;}
.checkbox {float: left;margin: 18px 0 0 40px;width: 410px;}
#rest_no {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 90px;}
#rest_no7{float: left;height: 100%;width:49px;border-right: 2px ridge #FFFFFF;}
#rest_no8{float: left;height: 100%;width: 60px;}
#rest_no_user1 {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 90px;}
#rest_no_user2 {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width:49px;}
#rest_no_user5 {float: left;height: 100%;width: 60px;}
#rest_no_user {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 78px;}
#rest_no_user4 {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 94px;}
#rest_no_user3 {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 98px;}
.sear_rest {float: left;height: 22px;margin: 0px 0 5px 18px;width: 145px;}
.submit{float: left;margin: 0px 0 5px 8px;}
.container_cont .navi_content {min-height: 648px;}
.checkbox {width: 372px;}
.user_credit {float:left;height:16px;margin:12px 0px 5px 18px;width:40px;}
.container_cont .navi_content{padding:16px 0 0 0;}
#time{margin:8px 0 0 5px;}
#neigh_name1{margin:12px 0 0 10px;}
#neigh_name2{margin:12px 0 0 16px;}
#rest_no_new {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 78px;}
#rest_no_new6 {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 45px;}
#rest_no_cred {border-right: 2px ridge #FFFFFF;float: left;height: 100%;width: 94px;}
</style>
<div id="credit_message"></div>
<div id="changedate">
	 <?php
		if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
			$page = 'page:'.$this->params['named']['page']; 
		else
			$page = 1;
	  ?>
    <div class="cont_navi">
        <ul class="navigation">
            <li class="active_link"><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'),array('class'=>'active')); ?></li>    
            <li><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'users','action'=>'index','delete')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
   
    
    <div class="navi_content" id="change">
    
        <div class="res_tabl">
            <style>
                .user_head{
                    width: 100%;
                    float: left
                }
                .user_left{
                    width: 34%;
                    float: left
                }
                .user_right{
                    width: 65%;
                    float: right;
                    padding-top: 0px;
                }
                .user_right label{
                    float: left;
                    width: 50%;
                    font-size: 14px;
                }
            </style>
            
            <div class="user_head">
            </div>
            
            <div class="tabl_head">
               
                    <div class="time" id="rest_no_user1"><span id="time">Transaction Date/Time</span></div>  
                    <div class="time" id="rest_no_user1"><span id="time">User First Name</span></div>
                    <div class="time" id="rest_no_user1"><span id="time">User Last Name</span></div>
                    <div class="time" id="rest_no_user1"><span id="time">Restaurant</span></div> 
                    <div class="time" id="rest_no_user1"><span id="time">Reservation Time</span></div> 
                    <div class="time" id="rest_no_user" style="width:45px;"><span id="time">Party Size</span></div>
                    <div class="time" id="rest_no_user"><span id="time">Active /Canceled</span></div>
                    <div class="time" id="rest_no_user4"><span id="time">Credit Used or CC</span></div> 
                    <div class="time" id="rest_no_user2"><span id="time">No Show</span></div> 
                    <div class="time" id="rest_no_user2"><span id="time">By using</span></div> 
                    <div class="time" id="rest_no_user5"><span id="time">Rest Confirm</span></div>   	
            </div>
            
            <div class="tabl_cont" id="change_city" style="height:480px; overflow:hidden;">
            
            	<?php 
                $i = 1;
                $class='fist_row';
				if(!empty($rest)){
                foreach($rest as $data){
                ?>
                	<div id="<?php echo $data['Reservation']['id'];?>" class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                    	<div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php 
							$offerTime= date('g:i A',strtotime($data['Offer']['offerTime']));
							$offerDate= $data['Offer']['offerDate'];
							$seating_cus = $data['Offer']['seating_custom'];
							$seating = $data['Offer']['seating'];
							if(!empty($data['Reservation']['trasaction_time'])) echo $data['Reservation']['trasaction_time']; ?></span>
                        </div>
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php 
							$user_fname= $data['User']['firstName'];
							$user_lname= $data['User']['lastName'];
							if(!empty($user_fname)) echo $user_fname; ?></span>
                        </div>
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php if(!empty($user_lname)) echo $user_lname; ?></span>
                        </div>  
                        <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php 
								if(!empty($data['Offer']['restaurantId'])){
									$user_id = $data['Offer']['restaurantId'];
									$row=mysql_fetch_array(mysql_query("select restaurants.name from restaurants where restaurants.id='".$user_id."' "));
									 if(strlen($row['name'])>8)
										echo substr($row['name'],0,8 ).'...';
									 else
										echo $row['name'];
								}
							?></span>
                        </div>   
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php if(!empty($offerTime)) echo $offerTime; ?></span>
                        </div>   
                         <div class="time" id="rest_no_new6">
                        	<span id="neigh_name1"><?php if(!empty($seating)){ 
								if($seating_cus!=0)
									echo $seating_cus;
								elseif($data['Reservation']['cancel_custom']!=0)
									echo $data['Reservation']['cancel_custom'];
								else
									echo $seating; 
							}?></span>
                        </div> 
                        <div class="time" id="rest_no_new">
                        	<span id="neigh_name2"><?php 
								if($data['Reservation']['approved']!=0)
									echo $html->image('/images/ad_select.png',array('class'=>'approve'));
								else
									echo $html->image('/images/ad_cancel.png',array('class'=>'reject'));
							?></span>
                        </div>   
                        <div class="time" id="rest_no_cred">
                        	<span id="neigh_name1"><?php 
                                        if(isset($data['Reservation']['transactionId'])&&!empty($data['Reservation']['transactionId']))
                                                echo 'Credit Card'; 
                                        else
                                                echo 'TS Credit'; ?>
                                </span>
                        </div>                   
                        <div class="time" id="rest_no7">
                        	<span id="neigh_name1"><?php 
							if($data['Reservation']['no_show']==0)
									echo '-'; 
								else
									echo 'No Show'; ?>
                             </span>
                        </div> 
                        <div class="time" id="rest_no7">
                        	<span id="neigh_name1"><?php echo $data['Reservation']['from']; ?></span>
                        </div>  
                        <div class="time" id="rest_no8">
                        	<span id="neigh_name1"><?php 
							if($data['Reservation']['receipt']==1)
									echo 'Yes'; 
								else
									echo 'No'; ?>
                             </span>
                        </div> 
                    </div>
                <?php 
                    $i++; } }else{ ?>
				 <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No User Found
				 </div>
			<?php } ?>
            </div>
            
            <?php /*?><?php if(!empty($rest)) {?>    
             
            <?php } ?><?php */?>
            <!--<div style="width:845px; float:left; margin-top:34px;">  
            <span class="pagination">  
            <?php 
           /* if($this->Paginator->numbers())
            {
            echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
            echo $this->Paginator->numbers();	?> &nbsp; <?php
            echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
            }*/
            ?> 
            </span>
            </div>--> 
            
             <?php if(!empty($rest)){ // class="pagination" ?>   
             <div style="width:850px; margin:38px 10px 20px 0; float:right; font-size:14px;" class="pag_normal">
                <span style='margin-left:30px;'><?php echo $html->link('Export',array('controller'=>'Users','action'=>'exportdash')); ?></span>
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
            <?php }/*else{ ?>
				 <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No Restaurant Found
				 </div>
			<?php }*/ ?>
        
        </div> 
        
    
    
    </div>
    

    
    
      <?php echo $form->end(); ?>
    
    <div class="navi_botom"></div>


 	
</div>