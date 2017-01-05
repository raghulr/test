
<div id="changedate">
    
    <div class="cont_navi">
            <ul class="navigation">
            <li><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'))?></li>
            <li ><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>    
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'Users','action'=>'index','delete')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li class="active_link"><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
    
    <!-- --> 
      
    <?php echo $form->create('Neighborhood', array('action' => 'index'));?>   
        <div class="navi_content">
            <div class="neighbor_select">
                <span><h1 style="font-size:28px;">Manage Neighborhoods for</h1></span>
                <span class="drop_down">
					<?php $changeurl=$html->url(array('controller'=>'neighborhoods','action'=>'city','super'=>true),true); ?>
                    <?php 
						echo $form->input('city_id',array('label'=>false, 'class'=>'select_box','type'=>'select','label'=>false,'options'=>array($city_name),'selected'=>'Select','onchange' =>'changecity(this.value,"'.$changeurl.'");')); 
                    ?>
                </span>
                <a href="<?php echo $html->url(array('controller'=>'neighborhoods','action'=>'add_city')); ?>" class="colorbox-slide-larger">
                    <span class="plus" id="plus"></span>
                </a> 
               <span class="edit" id="edit_city">
               <a href="<?php echo $html->url(array('controller'=>'neighborhoods','action'=>'super_rescity')); ?>" class="colorbox-larger_rescity">Edit City</a>
               </span>
            </div>
            
            <div class="res_tabl">
                <div class="tabl_head">
                    <?php /*?><div class="time"><span id="time">S.No</span></div><?php */?>
                    <div class="time neigh_head" id="neigh_no"><span id="time">Neighborhood</span></div>   
                    <div class="time" id="res_time" onmouseover="show_neighbor('add_neighbor')" onmouseout="hide_neighbor('add_neighbor')">	
                    <?php $neighbor_url = $html->url(array('controller'=>'neighborhoods','action'=>'add_city','super'=>false))?>			  	
                    <span id="time">
                        <a href="<?php echo $html->url(array('controller'=>'neighborhoods','action'=>'add')); ?>" class="colorbox-slide-larger">Add a New Neighborhood</a>
                    </span>           
                    </div>     	
                </div>
                
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
            <?php echo $ajax->submit('Delete', array('url'=> array('controller'=>'neighborhoods', 'action'=>'super_delete_city',$name['Neighborhood']['id'],$page), 'update' => 'change_city1','complete'=>'remove_disabled()','class'=>'city_submit','style'=>'float:left; width:160px; margin:10px 0 0 10px;')); ?>
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
                   <div class="pagination" id="paginate">
                    <span style="float:right">  
                        <?php 
                        if($this->Paginator->numbers()){
                            echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
                            echo $this->Paginator->numbers();	?> &nbsp; <?php
                            echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
                        }
                        ?> 
                    </span>
                </div> 
                </div>
                
                
            </div>
            
        </div>  
    <?php echo $form->end(); ?>
    
    <!-- -->
    <div class="navi_botom"></div>
    
    
    
</div>
                  