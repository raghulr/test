<div class="tabl_cont" id="change_city" style="height:450px;">
            	 <?php
					if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
						$page = 'page:'.$this->params['named']['page']; 
					else
						$page = 1;
				  ?>
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($rest)){
                foreach($rest as $data){
                ?>
                	<div id="<?php echo $data['User']['id'];?>" class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else: echo $class; $class='fist_row'; endif;?>">
                         <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['User']['firstName']."&nbsp;,&nbsp;&nbsp;".$data['User']['lastName']; ?></span>
                        </div>  
                        <div class="time" id="rest_no_user">
                        	<span id="neigh_name1"><?php echo $data['User']['email']; ?></span>
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
                                    <a href="javascript:;" onclick="return delete_res('<?php echo $time_url; ?>','<?php echo $data['User']['id'];?>');">
                                        Delete
                                    </a>
                            </span>
                  	  </div>
                      <div class="time" id="rest_no_user4">
                            <span id="neigh_name2">
                                <?php 
								echo $form->input('user_credit', array('id'=>'user_credit'.$i,'type'=>'text','label'=>false,'class'=>'user_credit','value'=>$data['User']['user_amount'],'onkeyup' => 'user_cred(this.value,'.$rest_id.');'));
								//$form->input('user_credit',array(),'onchange' => 'user_credit(this)'); ?>
                            </span>
                  	  </div>
                    </div>
                <?php 
                    $i++; } }
                ?> 
                
            </div>