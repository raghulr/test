<style>
     .export{float: left;margin-left: 2px;margin-top: 27px;font-family: Arial;font-weight: bold;font-size:85%;}
     .export a{color: #595959;}
</style>
<div id="changedate">
    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'))?></li> 
            <li ><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>   
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'users','action'=>'index','delete')); ?></li>
            <li class="active_link"><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
    
    <?php echo $form->create('Restaurants', array('action' => 'index'));?>
    	<div class="navi_content">
        
    <fieldset class="field_statis">
        <legend>Users</legend>
        <div class="statis_user">
        <span>
        <p>
        <?php echo $result."&nbsp;&nbsp;Users"; ?>
        </p>
        </span> 
        </div>               
    </fieldset>
            
    <fieldset class="field_statis1">
        <legend>Restaurants</legend>
        <div class="Statis_rest">
        <span>
        <p><?php echo $tot_rest."&nbsp;&nbsp;Total Restaurants"; ?></p>
        </span>
        <span>
        <p><?php echo $tot_approved_rest."&nbsp;&nbsp;Approved"; ?></p>
        </span>
        <span>
        <p><?php echo $tot_unapproved_rest."&nbsp;&nbsp;Unapproved"; ?></p>
        </span>
        </div>
    </fieldset>
    <fieldset class="field_statis2">
        <legend>Total Number Of Posted Today : <?php echo date('m-d-Y'); ?></legend> 
        <div class="statis_user statis_user1">
        	<?php 
				if(isset($total_tables))
					echo $total_tables.' '.'Tables';
				else
					echo "No Tables Available";
			?>
        </div>                 
    </fieldset>        
    <fieldset class="field_statis2">
        <legend>Reservations</legend>                
        <div class="statis_rese">
        <div class="stat_date" id="date">
            <ul id="cur_date">
                <li>
                	<?php 
                            $min =0;
                            $max =0;
                            $maxdate =0;
                            $minmonth =0;
                            $max_month =0;
                            $maxmonth =0;
                            $min_year = 0;
                            $max_year = 0;
                            if(!empty($min_date) && !empty($max_date)){
					$min_year = date('Y',strtotime($min_date));
					$max_year = date('Y',strtotime($max_date));
					$min_month= date('M Y',strtotime($min_date));
					$minmonth=strtotime($min_month);
					$max_month= date('M Y',strtotime($max_date));
					$maxmonth=strtotime($max_month);
					$datechange=explode('-',$min_date);
					$mindate =$datechange[1].'/'.$datechange[2].'/'.$datechange[0] ;
					$min=strtotime($mindate);
					$datechange1=explode('-',$max_date);
					$maxdate =$datechange1[1].'/'.$datechange1[2].'/'.$datechange1[0] ;
					$max=strtotime($maxdate);
					}
               		?>
                	<?php 
						$yesterday = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
						$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
						$prev = date("Y-m-d",$yesterday);
						$prev_min=strtotime($prev);
						$next = date("Y-m-d",$tomorrow);
						$current = date("m/d/Y");
						$next_max=strtotime($next);
					?>
                    <span class="span1" style="margin-top:8px;">
                     <?php 
					 	if($prev_min<$min){
							echo $this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20)));	
						}else{
					 	echo $ajax->link($this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20))),"static_date/".$prev."",array('escape' => false,'update'=>'cur_date','super'=>true));}?>
                    </span>
                    <span class="span2" id="cur_date">
                    	<?php 
							echo date('m/d/Y');
						?>
                    </span>
                    <span class="span3">
                         <?php
						 if($next_max>$max){
						 	echo $this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20)));
						 }else{
						 echo $ajax->link($this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20))),"static_date/".$next."",array('escape' => false,'update'=>'cur_date','super'=>true));}?>
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
        </div>
        
       <div class="stat_date"> 
        	<ul id="cur_month">
            	<li>
                	<?php 
						$lastmonth = date('m')-1;
						$nextmonth = date('m')+1;
						$dates=date('d-').$lastmonth.date('-Y');
						$last_month = date("M Y", strtotime($dates));
						$dates=date('d-').$lastmonth.date('-Y');
						$next_month = date("M Y", strtotime($dates));
					?>
                    <span class="span1" style="margin-top:8px;">
                    <?php if($minmonth<=$last_month){ 
						echo $this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20)));
					}else{
					echo $ajax->link($this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20))),"static_month/".$lastmonth."",array('escape' => false,'update'=>'cur_month','super'=>true));}?>
                    </span>
                    <span class="span2" id="cur_date" style="margin-left:20px;">
                    	<?php 
							echo date("M Y");
						?>
                    </span>
                    <span class="span3">
                        <?php if($maxmonth>=$next_month){ 
							echo $this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20)));
						}else{
						echo $ajax->link($this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20))),"static_month/".$nextmonth."",array('escape' => false,'update'=>'cur_month','super'=>true));}?>
                    </span>
                </li>
                <li style="float:none;" class="month">
                	<p>
						<?php 
							$i = 0; 
							if(!empty($month_count))
							echo $month_count; 
							else
							echo $i;
                        ?>
                    </p>
                </li>
            </ul>
        </div>
        
        <div class="stat_date">
            <ul id="cur_year">
            	<li>
                	<?php 
						$lastyear = date("Y")-1;
						$nextyear = date("Y")+1;
						//$max_year=date('Y',$maxdate);
					?>
                    <span class="span1" style="margin-top:8px;">
                        <?php if($lastyear<$min_year){
							echo $this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20)));
						}else{echo $ajax->link($this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20))),"static_year/".$lastyear."",array('escape' => false,'update'=>'cur_year','super'=>true));}?>
                    </span>
                    <span class="span2" id="cur_date" style="margin-left:35px;">
                    	<?php 
							echo date("Y");
						?>
                    </span>
                    <span class="span3">
                         <?php if($nextyear>$max_year){
						 	echo $this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20)));
						 }else{ 
						 echo $ajax->link($this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20))),"static_year/".$nextyear."",array('escape' => false,'update'=>'cur_year','super'=>true));}?>
                    </span>
                </li>
                 <li style="float:none;" class="month">
                	<p><?php echo $year_count; ?></p>
                </li>
            </ul>
        </div>
        
        <div class="stat_date" style="border-right:none;">
        	<span class="tot"><p>Total</p></span> 
				<?php 
					if(!empty($min_date) && !empty($max_date)){
					$datechange=explode('-',$min_date);
					$mindate =$datechange[1].'/'.$datechange[2].'/'.$datechange[0] ;
					$datechange1=explode('-',$max_date);
					$maxdate =$datechange1[1].'/'.$datechange1[2].'/'.$datechange1[0] ;
                ?>
            <span class="tot1"><p><?php echo $mindate."&nbsp;&nbsp;-&nbsp;&nbsp;"; echo $maxdate; ?></p></span>
            <?php } ?>
            <span class="tot2"><p><?php  echo $total_count ; ?></p></span>       	
        </div>
        
        
        </div>  
    </fieldset>
        
        
        <div class="view_chart">
            <span class='export'><?php echo $html->link('Export',array('controller'=>'Users','action'=>'exportstat')); ?></span>
        	<a href="<?php echo $html->url(array('controller'=>'users','action'=>'super_zingchart')); ?>" class="colorbox-medimum_chart">
           		<!--<img src="../../images/view_history.png" width="300" height="30" />-->
                <p>View History Chart</p>
            </a>
        </div>
        </div>
    
    <?php echo $form->end(); ?>
    
    <div class="navi_botom"></div>

</div>