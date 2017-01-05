
<div class="tabl_cont">
	<?php 
		$i = 1;
		$class='fist_row';
		if(!empty($neighbor_name)){
		foreach($neighbor_name as $name){
    ?>   
        <div  class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
            <div class="time"><span id="time_Num"><?php echo $i; ?></span></div>
            <div class="time" id="neigh_no"><span id="neigh_name">
			<input type="text" name="city_name" class="add_cuisine_name" id="neighbor_<?php echo $name['Neighborhood']['id']; ?>" value="<?php echo $name['Neighborhood']['name']; ?>" disabled />
			 <?php $ucurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_update_city','super'=>true),true); ?>	
              <?php $dcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_delete_city','super'=>true),true); ?>	
              <?php $rcurl = $html->url(array('controller'=>'neighborhoods','action'=>'super_revert_city','super'=>true),true); ?>	
              <a href="javascript:void(0)" id="cuisine_link" onClick="return rewrite_city('<?php echo $name['Neighborhood']['id']; ?>','<?php echo $name['Neighborhood']['city_id'];?>','<?php echo $ucurl;?>')">Update</a> <span>|</span>
              <a href="javascript:void(0)" id="cuisine_link"  onClick="return revert_city('<?php echo $name['Neighborhood']['id']; ?>','<?php echo $name['Neighborhood']['city_id'];?>','<?php echo $rcurl;?>')">Revert</a> <span>|</span>	
                <a href="javascript:void(0)" id="cuisine_link" onClick="show_delete_city('form_<?php echo $name['Neighborhood']['id']; ?>')" onMouseOut="hide_cuisine('delete_form')">Delete</a> 
              
              <span id="plus1" onmouseover="show_delete_city('form_<?php echo $name['Neighborhood']['id']; ?>')" onmouseout="hide_cuisine('delete_form')">
                        <div class="delete_form" id="form_<?php echo $name['Neighborhood']['id']; ?>">
                         <form id="submit" method="post">
                            <label>Are you sure you want to delete this Neighborhood?</label>
                            <input type="button" value="Delete" onclick="return delete_city('<?php echo $name['Neighborhood']['id']; ?>','<?php echo $name['Neighborhood']['city_id'];?>','<?php echo $dcurl;?>')"/>
                            <input type="button" value="Cancel" onclick="hide_cuisine('delete_form')"/>
                        </form>
                        </div>
                  </span>
              
             
            </span></div>       
        </div>    
    <?php 
		$i++; } }
	?>       	
</div>
   