<div class="tabl_cont" id="change_city">
                <div id="change_city1">
                <?php 
                $i = 1;
                $class='fist_row';
                if(!empty($neighbor_name)){
                foreach($neighbor_name as $name){
                ?> 
                    <div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                        <?php /*?><div class="time">
                        	<span id="time_Num"><?php echo $i; ?></span>
                        </div><?php */?>
                        <div class="time" id="neigh_no">
<span id="neigh_name">
    <input type="text" name="city_name" class="add_cuisine_name" id="neighbor_<?php echo $name['Neighborhood']['id']; ?>" value="<?php echo $name['Neighborhood']['name']; ?>" disabled />
    <input type="hidden" name="city_name" class="add_cuisine_name" id="neighbor_<?php echo $name['Neighborhood']['city_id']; ?>" value="<?php echo $name['Neighborhood']['name']; ?>" style="color:#ffffff; border:red 1px solid;" />
    <?php
		if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
			$page = 'page:'.$this->params['named']['page']; 
		else
			$page = 1;
	  ?>
	<?php $ucurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_update_city','super'=>true,$page),true); ?>	
    <?php $dcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_delete_city','super'=>true,$page),true); ?>	
    <?php $rcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_revert_city','super'=>true,$page),true); ?>	
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="return rewrite_city('<?php echo $name['Neighborhood']['id']; ?>','<?php echo $name['Neighborhood']['city_id'];?>','<?php echo $ucurl;?>')">Update</a> 
    <span>|</span>
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="return revert_city('<?php echo $name['Neighborhood']['id']; ?>','<?php echo $name['Neighborhood']['city_id'];?>','<?php echo $rcurl;?>')">Revert</a> 
    <span>|</span>	
    
    <a href="javascript:void(0)" id="cuisine_link" onClick="show_delete_city('form_<?php echo $name['Neighborhood']['id']; ?>')" onMouseOut="hide_cuisine('delete_form')">Delete</a>               
    
    <span id="plus1" onmouseover="show_delete_city('form_<?php echo $name['Neighborhood']['id']; ?>')" onmouseout="hide_cuisine('delete_form')">
        <div class="delete_form" id="form_<?php echo $name['Neighborhood']['id']; ?>">
            <label>Are you sure you want to delete this Neighborhood?</label>
            <?php echo $ajax->submit('Delete', array('url'=> array('controller'=>'neighborhoods', 'action'=>'super_delete_city',$name['Neighborhood']['id'],$page), 'update' => 'change_city1','complete'=>'funcall()','class'=>'city_submit','style'=>'float:left; width:160px; margin:10px 0 0 10px;')); ?>
            <?php echo $ajax->submit('Cancel', array('url'=> array('controller'=>'neighborhoods', 'action'=>'super_cancel_city',$name['Neighborhood']['id']), 'update' => 'change_city1','complete'=>'funcall()','class'=>'city_submit','style'=>'float:right;  width:160px; margin:10px 10px 0 0;')); ?>                     
        </div>	
	</span>

</span>
                        </div>       
                    </div> 
				<?php 
                    $i++; } }
                ?>  
                   </div>
                    
                </div>