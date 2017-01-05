<ul id="cur_date">
                <li>
                	<?php 
					if(!empty($min_date) && !empty($max_date)){
					$datechange=explode('-',$min_date);
					$mindate =$datechange[1].'/'.$datechange[2].'/'.$datechange[0] ;
					$min=strtotime($mindate);
					$datechange1=explode('-',$max_date);
					$maxdate =$datechange1[1].'/'.$datechange1[2].'/'.$datechange1[0] ;
					$max=strtotime($maxdate);
					}
               		?>
                	<?php 
						$prevstrtime=strtotime($current_date)-86400;
						$prevcheckdate=date('Y-m-d',$prevstrtime);
						$nextstrtime=strtotime($current_date)+86400;
			 			$nextcheckdate=date('Y-m-d',$nextstrtime);
						$current = date("m/d/Y");
						$datechange=explode('-',$current_date);
						$currentdate1 =$datechange[1].'/'.$datechange[2].'/'.$datechange[0] ;
					?>
                    <span class="span1" style="margin-top:8px;">
                      <?php 
					 	if($prevstrtime<$min){
							echo $this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20)));	
						}else{
					 	echo $ajax->link($this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20))),"static_date/".$prevcheckdate."",array('escape' => false,'update'=>'cur_date','super'=>true));}?>
                    </span>
                    <span class="span2" id="cur_date">
                    	<?php 
							if(isset($currentdate1)){
								echo $currentdate1;
							}else { 
								echo date('m/d/Y');
							}
						?>
                    </span>
                    <span class="span3">
                 
                       <?php 
					   if($nextstrtime>$max){
					   	echo $this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20)));
					   }else{
					   	echo $ajax->link($this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20))),"static_date/".$nextcheckdate."",array('escape' => false,'update'=>'cur_date','super'=>true));}?>
                    </span>
                </li>
                <li style="float:none;" class="month">
                	<div class="user_cnt">
                        <p id="userone">
							<?php 
								$i = 0; 
								if(!empty($count))
									echo $count; 
								else
									echo $i;
                            ?>
                        </p>
                    </div>
                </li>
            </ul>