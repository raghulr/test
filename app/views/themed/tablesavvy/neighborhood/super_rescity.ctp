<div class="res_tabl_res">
				
                <div class="tabl_head_res">
                    <div class="time" id="neigh_no"><span id="time">City</span></div>     	
                	<a href="#" onclick="parent.$.colorbox.close(); return true;" style="position:absolute;right:20px;top:15px;"><?php echo $html->image('/images/close.png',array('width'=>33,'height'=>34,'border'=>0)); ?></a>	
                <div class="tabl_cont_res" id="change_city">
                <?php 
                $i = 1;
                $class='fist_row';
                if(!empty($city_name)){
                foreach($city_name as $name){
                ?> 
                    <div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                        <?php /*?><div class="time">
                        	<span id="time_Num"><?php echo $i; ?></span>
                        </div><?php */?>
                        <div class="time" id="neigh_no">
<span id="neigh_name">
    <input type="text" name="city_name" class="add_cuisine_name" id="neighbor_<?php echo $name['City']['id']; ?>" value="<?php echo $name['City']['city_name']; ?>" disabled />
    <input type="hidden" name="city_name" class="add_cuisine_name" id="neighbor_<?php echo $name['City']['id']; ?>" value="<?php echo $name['City']['city_name']; ?>" style="color:#ffffff; border:red 1px solid;" />
    
	<?php $ucurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_update_rescity','super'=>true),true); ?>	
    <?php $dcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_delete_rescity','super'=>true),true); ?>	
    <?php $rcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_revert_rescity','super'=>true),true); ?>	
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="return rewrite_rescity('<?php echo $name['City']['id']; ?>','<?php echo $ucurl;?>')">Update</a> 
    <span>|</span>
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="return revert_rescity('<?php echo $name['City']['id']; ?>','<?php echo $rcurl;?>')">Revert</a> 
    <span>|</span>	
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="return delete_rescity('<?php echo $name['City']['id']; ?>','<?php echo $dcurl;?>')">Delete</a>               
        </div>	
	</span>

</span>     
                    </div> 
				<?php 
                    $i++; } }
                ?>         	
                </div>
                </div>
            </div>
            