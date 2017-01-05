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
    width: 200px;
}
#rest_no_user1 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 100px;
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
    width: 256px;
}
#rest_no_user2 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 104px;
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
  margin:12px 0px 5px 18px;
  width:40px;
}
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
            <li><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'))?></li>
            <li ><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>
            <li ><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li class="active_link"><?php echo $html->link('Users',array('controller'=>'users','action'=>'index','delete')); ?></li>
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
                <div class="user_left">
                     <span class="Uers_pro"><h1>Users</h1></span>        	
                    <span class="serach_rest">
                   
                    	 <?php echo $form->create('users', array('action' => 'index'));?>  
                        <?php echo $form->input('search_name',array('type'=>'text','value'=>'','label'=>false,'class'=>'sear_rest')); ?>
                        <?php echo $form->submit('Search',array('id'=>'search_but')); ?>
                          
                        <?php echo $form->end(); ?>
                    </span>
                </div>
                 <?php echo $form->create('users', array('action' => 'index'));?>  
                
                <div class="user_right">
                    <?php
					$user_credit='';
					$used_credit='';
					$remaining_count='';
                    foreach($rest as $data){
                        $user_credit = $data['User']['user_credit'];
						$used_credit = $data['User']['used_credit'];
						$remaining_count= $data['User']['user_credit']-$data['User']['used_credit'];
                        break;
                    }
                    ?>
                     <div><label style="width:100%"> Used credit:<?php echo $used_credit; ?></label> </div>
                    <div id="credit_update"><label style="width:100%"> Remaining credit: <?php echo $remaining_count; ?></label></div>
                    <?php echo $form->input('user_credit',array('type'=>'text','value'=>$user_credit,'label'=>'Number of users to be credit upon sign up:','class'=>'sear_rest')); ?>
                    <?php echo $ajax->submit('Submit', array('url'=> array('controller'=>'users', 'action'=>'user_credit'), 'update' => 'credit_message','complete'=>'credit_update()'));?>
                </div>
            </div>
            
            <div class="tabl_head">
               
                    <div class="time" id="rest_no"><span id="time">Name</span></div>  
                    <div class="time" id="rest_no_user"><span id="time">Email</span></div>
                    <div class="time" id="rest_no_user1"><span id="time">View</span></div>
                    <div class="time" id="rest_no_user2"><span id="time">Approved</span></div> 
                    <div class="time" id="rest_no_user3"><span id="time">Remove</span></div> 
                    <div class="time" id="rest_no_user4"><span id="time">Credit</span></div>   	
            </div>
            
            <div class="tabl_cont" id="change_city" style="height:450px;">
            
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($rest)){
                foreach($rest as $data){
                ?>
                	<div id="<?php echo $data['User']['id'];?>" class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['User']['firstName']."&nbsp;,&nbsp;&nbsp;".$data['User']['lastName']; ?></span>
                        </div>  
                        <div class="time" id="rest_no_user">
                        	<span id="neigh_name1">
                                <?php
									echo (strlen($data['User']['email']) > 30)?substr($data['User']['email'],0,30).'...':$data['User']['email'];?>
                            </span>
                        </div>
                        <div class="time" id="rest_no_user1">
                        	<span id="neigh_name2">                            
                            	<?php $id = $data['User']['id']; ?>
                            	<a href="<?php echo $html->url(array('controller'=>'users','action'=>'super_user_detail',$id)); ?>" class="colorbox-larger_user"><?php echo $html->image("/images/zoom.png",array("width"=>15,"height"=>15));?></a> 
                            </span>
                        </div> 
                        <div class="time" id="rest_no_user2">
                        	<span id="neigh_name2">
							<?php 
								
								$rest_id = $data['User']['id'];
								$approve_id = $data['User']['approved'];
								$approve_url = $html->url(array('controller'=>'users','action'=>'super_user_change',$approve_id,$rest_id,'super'=>true,$page),true);
								$checked='';
								if($approve_id == 1)
									$checked='checked';
								echo $form->input('approved', array('label'=>false,'type'=>'checkbox','class'=>'rest_check','checked'=>$checked,'complete'=>'funcall()','onchange' =>'change_approvefield(this.value,"'.$approve_url.'");'));
								
							?>
                            </span>
                        </div> 
                      	<div class="time" id="rest_no_user3">
                            <span id="neigh_name3">
                                <?php 
                                    $rest_id = $data['User']['id'];
                                    $time_url = $html->url(array('controller'=>'users','action'=>'super_res_del',$rest_id),true); ?>
                                    <a href="javascript:;" onClick="return delete_res('<?php echo $time_url; ?>','<?php echo $data['User']['id'];?>');">
                                        Delete
                                    </a>
                            </span>
                  	  </div>
                      <div class="time" id="rest_no_user4">
                            <span id="neigh_name4">
                                <?php 
								echo $form->input('user_credit1', array('id'=>'user_credit'.$i,'type'=>'text','label'=>false,'class'=>'user_credit','value'=>$data['User']['user_amount'],'onkeyup' => 'user_cred(this.value,'.$rest_id.');'));
								//$form->input('user_credit',array(),'onchange' => 'user_credit(this)'); ?>
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
            <span style='margin-left:30px;'><?php echo $html->link('Export',array('controller'=>'Users','action'=>'exportuser')); ?></span>
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