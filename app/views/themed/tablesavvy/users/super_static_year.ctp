<ul id="cur_year">
<li>
<?php 
if(!empty($min_date) && !empty($max_date)){
$min_year = date('Y',strtotime($min_date));
$max_year = date('Y',strtotime($max_date));
}
?>
<?php 
$lastyear = $currentyear-1;
$nextyear = $currentyear+1;
?>
<span class="span1" style="margin-top:8px;">
<?php if($lastyear<$min_year){
							echo $this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20)));}else{
							echo $ajax->link($this->Html->image("../images/back-arrow.png",array('style'=>array('width'=>20,'height'=>20))),"static_year/".$lastyear."",array('escape' => false,'update'=>'cur_year','super'=>true));}?>
</span>
<span class="span2" id="cur_date" style="margin-left:35px;">
<?php 
echo $currentyear;
?>
</span>
<span class="span3">
<?php if($nextyear>$max_year){
						 	echo $this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20)));
						 }else{ echo $ajax->link($this->Html->image("../images/forward-arr.png",array('style'=>array('width'=>20,'height'=>20))),"static_year/".$nextyear."",array('escape' => false,'update'=>'cur_year','super'=>true));}?>
</span>
</li>
<li style="float:none;" class="month">
<p><?php echo $year_count; ?></p>
</li>
</ul>