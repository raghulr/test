<div class="tabl_cont" id="change_city">
            
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($rest)){
                foreach($rest as $data){
                ?>
                	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                        <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['Restaurant']['name']; ?></span>
                        </div>  
                        <div class="time" id="rest_no1">
                        	<span id="neigh_name1"><?php if(array_key_exists($data['Restaurant']['city'],$cities)):echo $cities[$data['Restaurant']['city']];endif; ?></span>
                        </div>
                        <div class="time" id="rest_no2">
                        	<span id="neigh_name2">  
                            <a href="<?php echo $html->url(array('controller'=>'homes','action'=>'details',$data['Restaurant']['slug_name'],'super'=>false),true);?>" target="_blank" >                          
                            	<?php echo $html->image("/images/zoom.png",array("width"=>15,"height"=>15));?>
                           	</a>
                            </span>
                        </div>
                        <div class="time" id="rest_no5">
                        	<span id="neigh_name2" style="margin:20px 0 0 20px"> 
                            <?php $rest_id = $data['Restaurant']['id']; ?>
							 <a href="<?php echo $html->url(array('controller'=>'Users','action'=>'super_editrestraunt',$data['Restaurant']['id'])); ?>" class="colorbox-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;">
							 	<?php echo $html->image("/images/Edit.gif",array("width"=>20,"height"=>17));?>
                             </a>
                            </span>
                        </div>
                        <div class="time" id="rest_no3">
                        	<span id="neigh_name1">
                             <?php
								if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
									$page = 'page:'.$this->params['named']['page']; 
								else
									$page = 1;
							  ?>
							<?php
							$approve_url = $html->url(array('controller'=>'restaurants','action'=>'super_approvefield','super'=>true,$sel_id,$ser_term,$page),true);
								$rest_id = $data['Restaurant']['id'];
								$approve_id = $data['Restaurant']['approved'];
								$checked='';
								if($approve_id == 1)
									$checked='checked';
								echo $form->input('approved', array('label'=>false,'type'=>'checkbox','class'=>'rest_check','checked'=>$checked,'complete'=>'funcall()','onchange' =>'change_appropvefield(this.value,"'.$approve_url.'","'.$rest_id.'","'.$approve_id.'");'));
							?>
                            </span>
                        </div>
                        <div class="time" id="rest_no4">
                        	<span id="neigh_name1">
                        	 	<?php 
									$rest_id = $data['Restaurant']['id'];
									$time_url = $html->url(array('controller'=>'restaurants','action'=>'super_res_del',$rest_id,$sel_id),true); ?>
                                    <a href="javascript:;" onclick="return delete_res('<?php echo $time_url; ?>');">
                                        Delete
                                    </a>
                            </span>
                        </div>
                         <div class="time" id="rest_no6">
                         	<span id="rank">
                            	<?php 
									$rankValue = !empty($data['Restaurant']['rank'])?$data['Restaurant']['rank']:'';
									$rank=array();
									for($i=1;$i<=5;$i++){
										$rank[$i]=$i;
									}
									echo $form->input('rank',array('label'=>false,'id'=>'rankid_'.$rest_id,'type' => 'select','options' =>$rank ,'empty'=>'Select Rank','class'=>'changeval','selected'=>$rankValue));
								?>
                            </span>
                         </div> 
                    </div>
                
                <?php 
                    $i++; } }
                ?> 
             
            </div>