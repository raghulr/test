<div class="tabl_cont">
	<?php 
		$i = 1;
		$class='fist_row';
		if(!empty($cuisines)){
		foreach($cuisines as $cuisine){
    ?>   
        <div  class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
            <!--<div class="time"><span id="time_Num"><?php //echo $i; ?></span></div> -->
            <div class="time" id="neigh_no1"><span id="neigh_name">
            	<input type="text" name="cuisine_name" class="add_cuisine_name" id="cuisine_<?php echo $cuisine['Cuisine']['id']; ?>" value="<?php echo $cuisine['Cuisine']['name']; ?>" disabled />
                <?php $ucurl = $html->url(array('controller'=>'cuisines','action'=>'super_update_cuisine','super'=>true),true); ?>	
              <?php $dcurl = $html->url(array('controller'=>'cuisines','action'=>'super_delete_cuisine','super'=>true),true); ?>	
              <?php $rcurl = $html->url(array('controller'=>'cuisines','action'=>'super_revert_cuisine','super'=>true),true); ?>	
              <a href="javascript:void(0)" id="cuisine_link" onClick="return remove('<?php echo $cuisine['Cuisine']['id']; ?>','<?php echo $ucurl;?>')">Update</a> <span>|</span>
              <a href="javascript:void(0)" id="cuisine_link" onClick="return revert_cuisine('<?php echo $cuisine['Cuisine']['id']; ?>','<?php echo $rcurl;?>')">Revert</a> <span>|</span>	
              <a href="javascript:void(0)" id="cuisine_link" onClick="show_delete('form_<?php echo $cuisine['Cuisine']['id']; ?>')" onMouseOut="hide_cuisine('delete_form')">Delete</a> 
              
              <span id="plus1" onmouseover="show_delete('form_<?php echo $cuisine['Cuisine']['id']; ?>')" onmouseout="hide_cuisine('delete_form')">
                        <div class="delete_form" id="form_<?php echo $cuisine['Cuisine']['id']; ?>">
                         <form id="submit" method="post">
                            <label>Are you sure you want to delete this cuisine?</label>
                            <input type="button" value="Delete" onclick="return delete_cuisine('<?php echo $cuisine['Cuisine']['id']; ?>','<?php echo $dcurl;?>')"/>
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