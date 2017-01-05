<style type="text/css">
.cont_navi{
	color:#fff!important;
	padding-top:10px!important;
	font-family:arial!important; 
	font-size:14px!important;
	padding-left:10px;
	width:874px!important;
}
</style><div class="cont_navi">
   Subscribers List
</div>
<div class="navi_content">
    <div class="res_tabl">
    	<div class="tabl_head">
        	<div class="time"><span id="time">S.No</span></div>
            <div class="email"><span id="party">EMAIL</span></div>
        </div>
        <div class="tabl_cont" style="overflow-y:scroll;">
        <?php $class='fist_row';$i=1; if(!empty($list)):foreach($list as $lt): ?>
        	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
            	<div class="time" style="border:none;text-align:center;padding-top:15px;"><?php echo $i; ?></div>
                <div class="email" style="border:none;"><span id="party_no"><?php echo $lt; ?></span></div>
            </div>
           <?php $i++; endforeach; endif;?> 
        </div>
    </div>
</div>
<div class="navi_botom"></div>