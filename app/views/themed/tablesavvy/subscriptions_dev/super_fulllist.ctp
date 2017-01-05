<style>
input {
    margin: 1px;
    width: 74px;
}
.checkbox {
    float: left;
    margin: 18px 0 0 40px;
    width: 410px;
}
#rest_no {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 110px;
}

#rest_no_user1 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    line-height: 43px;
    text-align: center;
    width: 144px;
}
#rest_no_user4 {
    float: left;
    height: 100%;
    width: 75px;
}
#rest_no_user {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 234px;
}
#rest_no_user2 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 128px;
	line-height: 45px;
	text-align:center;
}
#rest_no_user3 {
  	border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 98px;
}
.sear_rest {
    float: left;
    height: 22px;
    margin: 0px 0 5px 18px;
    width: 145px;
}
.submit{
	float: left;
	margin: 0px 0 5px 8px;
}
.container_cont .navi_content {
	min-height: 648px;
}
.checkbox {
	width: 372px;
}
.user_credit {
  float:left;
  height:16px;
  margin:0 0 5px 18px;
  width:40px;
}

.Uers_pro {
    float: left;
    height: auto;
    margin: 10px 0 10px 10px;
    width: 266px;
}
#neigh_name2 {
	margin: 5px 0 0 0px;
	text-align: center;
	width:100%;
}
</style>

<div id="credit_message"></div>
<div id="changedate">
   
    <div class="navi_content" id="change">
    
        <div class="res_tabl">
            <style>
			.res_tabl {
					float: left;
					height: 575px;
					margin: 10px 0 0 18px;
					width: 866px;
				}
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
                <div class="user_left">
                     <span class="Uers_pro"><h1>Subscriptions List</h1></span>  
                </div>
                
            </div>
            
            <div class="tabl_head">
               
                    <div class="time" id="rest_no"><span id="time">First Name</span></div>  
                     <div class="time" id="rest_no"><span id="time">Last Name</span></div> 
                    <div class="time" id="rest_no_user"><span id="time">Email</span></div>
                    <div class="time" id="rest_no_user1"><span id="time">Phone</span></div>
                    <div class="time" id="rest_no_user2"><span id="time">Created</span></div>
                    <div class="time" id="rest_no_user2"><span id="time">Status</span></div>
            </div>
            
            <div class="tabl_cont" id="change_city" style="height:450px;">
            
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($list)){
                foreach($list as $data){
                ?>
                	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['Subscription']['firstName']; ?></span>
                        </div>  
                        <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['Subscription']['lastName']; ?></span>
                        </div> 
                        <div class="time" id="rest_no_user">
                        	<span id="neigh_name1"><?php echo $data['Subscription']['email']; ?></span>
                        </div>
                        <div class="time" id="rest_no_user1">
                        	<span id="neigh_name2">                            
                            	<?php echo $data['Subscription']['phone']; ?>
                            </span>
                        </div> 
                        <div class="time" id="rest_no_user2">
                        	<span id="neigh_name2">
							<?php echo date('Y-m-d',strtotime($data['Subscription']['created'])); ?>
                            </span>
                        </div> 
                        <div class="time" id="rest_no_user2">
                        	<span id="neigh_name2">
							<?php echo $data['Subscription']['status']; ?>
                            </span>
                        </div> 
                    </div>
                <?php 
                    $i++; } }else{ ?>
				 <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No List can be  Found
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
        
        </div> 
        
    
    
    </div>
    

    
    
      <?php echo $form->end(); ?>
    
    <div class="navi_botom"></div>


 	
</div>
