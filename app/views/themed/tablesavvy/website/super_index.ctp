<div id="message_update"></div>
<div id="changedate">

    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'users','action'=>'index')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
    <?php $serach =''; 
			if(!empty($res_searc)){
				$serach = $res_searc;
			} ?>
    <?php echo $form->create('Restaurants', array('action' => 'index', 'name' => 'restaurants'));?>  
    
    <div class="navi_content">
        <div class="neighbor_select" id="rest_select">
        <div style="margin-left:5px;"><a href="<?php echo $html->url(array('controller'=>'websites','action'=>'super_websiteadd')); ?>" class="colorbox-website-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;"><?php echo "Add New Website"; ?></a> </div>
        	<h3>View</h3>
            <span class="drop_down_rest">
                <?php 
					 $website_url = $html->url(array('controller'=>'websites','action'=>'super_websitestatus','super'=>true),true);
					 echo $form->input('status_url',array('type'=>'hidden','id'=>'status_url','value'=>$website_url));
					echo $form->input('Websites',array('label'=>false, 'class'=>'select_box','type'=>'select','id'=>'website_status','label'=>false,'options'=>array(2=>'All',1=>'Approved',0=>'Cancelled'),'selected'=>'Select'));
                ?>
               <?php echo $form->end(); ?> 
            </span>
        </div>   
        
        <div class="res_tabl" id="website_list">
            <div class="tabl_head">
                    <div class="time"><span id="time">Name</span></div>
                    <div class="time" id="rest_no1"><span id="time">City</span></div> 
                     <div class="time" id="rest_no5"><span id="time">Edit</span></div> 
                    <div class="time" id="rest_no3"><span id="time">Approved</span></div> 
                    <div class="time" id="rest_no4"><span id="time">Remove</span></div> 
                         	
            </div>
            
            <div class="tabl_cont" id="change_city">
            
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($websites)){
                foreach($websites as $data){
                ?>
                	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                        <div class="time">
                        	<span id="neigh_name1"><?php echo $data['Website']['website_name']; ?></span>
                        </div>  
                        <div class="time" id="rest_no1">
                        	<span id="neigh_name1">
                            	<?php 
									$city_id = $data['Website']['city_id'];
									$row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
									$city_name= $row['city_name']; 
									echo $city_name;
								?>
							</span>
                        </div>
                        <div class="time" id="rest_no5">
                        	<span id="neigh_name2" style="margin:20px 0 0 20px"> 
                            <?php $website_id = $data['Website']['id']; ?>
							 <a href="<?php echo $html->url(array('controller'=>'websites','action'=>'super_websiteedit',$website_id)); ?>" class="colorbox-website-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;">
							 	<?php echo $html->image("/images/Edit.gif",array("width"=>20,"height"=>17));?>
                             </a>
                            </span>
                        </div>
                        <div class="time" id="rest_no3">
                        	<span id="neigh_name1">
							<?php 
								
								$approve_id = $data['Website']['active'];
								$checked='';
								if($approve_id == 1)
									$checked='checked';
									$approved_url=$html->url(array('controller'=>'websites','action'=>'super_websiteapproved'));
								echo $form->input('active', array('label'=>false,'type'=>'checkbox','class'=>'rest_check','checked'=>$checked,'complete'=>'funcall()', 'id'=>'website_check_'.$website_id,'onchange' =>'changeWebsite_status(this.value,"'.$website_id.'","'.$approved_url.'");'));
								
							?>
                            </span>
                        </div> 
                        <div class="time" id="rest_no4">
                        	<span id="neigh_name1">
                                    <?php echo $html->link('Delete',array('controller'=>'websites','action'=>'super_websitedelete',$website_id),array('onclick'=>'if(confirm("Are you sure want to delete"))return true;else return false;')); ?>
                            </span>
                        </div>
                    </div>
                
                <?php 
                    $i++; } }
                ?> 
              </div> 
		<div id="nor_page">
            <?php if(!empty($websites)){ // class="pagination" ?>   
             <div style="width:886px; margin:10px 10px 20px 0; float:right;">
            <span style="float:right">  
            <?php 
				if($this->Paginator->numbers())
				{
					echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
					echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
				}
            ?> 
            </span>
            </div>
            <?php }else{ ?>
				 <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No Websites can be Found
				 </div>
			<?php } ?>
                        </div>
       </div>
    
    
    </div>
    <div class="navi_botom"></div>
   	
</div>