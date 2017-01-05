<script>
window.location.reload();
</script>
<?php /*?><script>
Cufon.replace('#title',{ fontFamily: 'diavalo-book' });
</script>
                            	<div class="right_top" onmouseover="showalert('explain_cont')" onmouseout="hidealert('explain_cont')">
                                	<?php
										if(!empty($alert)){ 
										foreach($alert as $alerts){  
											if(!empty($alerts['Alert']['dayselect'])){
												$approve_id = $alerts['Alert']['dayselect'];
											}
											else{
												$approve_id = 0;
											}
											if($approve_id == 1){
												$checked='checked';
											}
											else{
												$checked='unchecked';
											}
										  }
										}else{
											$checked='unchecked';
										}
									$change_day_url = $html->url(array('controller'=>'alerts','action'=>'change_day')); ?>
                                	<?php echo $form->input('send',array('type'=>'checkbox','id'=>'check','label'=>'Send me Daily TableSavvy listings','checked'=>$checked,'div'=>false,'onchange'=>'change_day("'.$change_day_url.'", this.value);'));?>
                                    <div class="explain_cont" onmouseover="showalert('explain_cont')" onmouseout="hidealert('explain_cont')">
                                		<span id="exp">Receive a daily update of all TableSavvy listings.  This will not remove your current alerts.</span>
                                	</div>
                                </div>
                            	<span id="title">My Current Alerts</span>                                
                                <span id="alert_text">You will be notified daily if the following restaurants have reservations available.</br>
                                <a id="click_alert" href="javascript:;" onclick="showalert('tooltip')">Click here</a> to change how often we send you alerts.
                                </span>
                               <div id="alert_days" class="drop_down tooltip" onmouseover="showalert('tooltip')" onmouseout="hidealert('tooltip')">
                                	<span id="drop_top">only send me alerts on</span>
                                    
                                    <?php echo $form->create('Alert');?>
                            <ul>
                              <?php if(isset($sunday)&&isset($monday)&&isset($monday)&&isset($tuesday)&&isset($wednesday)&&isset($thursday)&&isset($friday)&&isset($saturday)){?>
                              		<li><?php echo $form->input('Alert.sunday',array('label'=>'Sunday','checked'=>$sunday,'div'=>false));?></li>
                                    <li><?php echo $form->input('Alert.monday',array('label'=>'Monday','checked'=>$monday,'div'=>false));?></li>
                                  <li><?php echo $form->input('Alert.tuesday',array('label'=>'Tuesday','checked'=>$tuesday,'div'=>false));?></li>
                                  <li><?php echo $form->input('Alert.wednesday',array('label'=>'Wednesday','checked'=>$wednesday,'div'=>false));?></li>
                                  <li><?php echo $form->input('Alert.thursday',array('label'=>'Thursday','checked'=>$thursday,'div'=>false));?></li>
                                  <li><?php echo $form->input('Alert.friday',array('label'=>'Friday','checked'=>$friday,'div'=>false));?></li>
                                  <li><?php echo $form->input('Alert.saturday',array('label'=>'Saturday','checked'=>$saturday,'div'=>false));?></li>
                              <?php } else { ?>
                              	    <li><?php echo $form->input('Alert.sunday',array('label'=>'Sunday','div'=>false));?></li>
                                    <li><?php echo $form->input('Alert.monday',array('label'=>'Monday','div'=>false));?></li>
                              <li><?php echo $form->input('Alert.tuesday',array('label'=>'Tuesday','div'=>false));?></li>
                              <li><?php echo $form->input('Alert.wednesday',array('label'=>'Wednesday','div'=>false));?></li>
                              <li><?php echo $form->input('Alert.thursday',array('label'=>'Thursday','div'=>false));?></li>
                              <li><?php echo $form->input('Alert.friday',array('label'=>'Friday','div'=>false));?></li>
                              <li><?php echo $form->input('Alert.saturday',array('label'=>'Saturday','div'=>false));?></li>
                              <?php } ?>
                            </ul>
                             <?php echo $ajax->submit('', array('url'=>array('controller'=>'alerts','action'=>'day_select'),'class'=>'drop_butn','update'=>'post','complete'=>'funcall()','escape'=>false)); ?>
                             <?php echo $form->end(); ?>
                                </div>
                                <?php 
								if(!empty($alert)){
									foreach($alert as $alerts){  
											$rid = $alerts['Alert']['id']; 
								?>
                                <div class="alerts_bar">
                                	<!--<?php /*?><div class="cross"><?php echo $html->link($this->Html->image("/images/cross.png",array('border'=>0)),array('controller'=>'profiles','action'=>'alert_delete',$rid),array('escape'=>false,'onclick'=>"return sample();"))?></div><?php */?>
                                  <?php /*?> <div class="cross">
                                    <?php $time_url = $html->url(array('controller'=>'profiles','action'=>'alert_delete',$rid),true); ?>
                                        <a href="javascript:;" onclick="return sample('<?php echo $time_url; ?>');">
                                        <?php echo $this->Html->image("/images/close.png",array('border'=>0),array('escape'=>false)); ?>
                                        </a>
                                    </div>
                                	<a href="javascript:;" style="width:340px;"><?php echo $alerts['Restaurant']['name']; ?></a>
                                </div>
                                <?php } 
								}?>    
                                </div><?php */?>