
<div id="changedate">

    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'))?></li>
            <li ><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'Users','action'=>'index','delete')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li class="active_link"><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
  <div class="navi_content">
    <div class="neighbor_select">
 		<span><h1>Manage Cuisines</h1></span>
          
    </div>
    <div class="res_tabl" id="change_city">
    	<div class="tabl_head">
        	<!--<div class="time"><span id="time">S.No</span></div> -->
            <div class="time" id="neigh_no"><span id="time">Cuisines</span></div>   
            <div class="time" id="res_time" style="width:180px;" >
                <span id="time">
                    <a href="<?php echo $html->url(array('controller'=>'cuisines','action'=>'add')); ?>" class="colorbox-slide-larger">Add a New Cuisine</a>
                </span>           
            </div>     	
        </div>
        <div class="tabl_cont" id="form">
        <?php $i=1; $class='fist_row'; foreach($cuisines as $key=>$cuisine): ?>
        	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
            	
            		<!--<div class="time"><span id="time_Num"><?php //echo $i; ?></span></div> -->
                	<div class="time" id="neigh_no1"><span id="neigh_name">
							<input type="text" name="cuisine_name" class="add_cuisine_name" id="cuisine_<?php echo $cuisine['Cuisine']['id']; ?>" value="<?php echo $cuisine['Cuisine']['name']; ?>" disabled  />
              <?php
			  	if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
			  		$page = 'page:'.$this->params['named']['page']; 
				else
					$page = 1;
			  ?>
			  <?php $ucurl = $html->url(array('controller'=>'cuisines','action'=>'super_update_cuisine','super'=>true,$page),true); ?>	
              <?php $dcurl = $html->url(array('controller'=>'cuisines','action'=>'super_delete_cuisine','super'=>true,$page),true); ?>	
              <?php $rcurl = $html->url(array('controller'=>'cuisines','action'=>'super_revert_cuisine','super'=>true,$page),true); ?>	
              <a href="javascript:void(0)" id="cuisine_link" onClick="return update_cus('<?php echo $cuisine['Cuisine']['id']; ?>','<?php echo $ucurl;?>')">Update</a> <span>|</span>
              <a href="javascript:void(0)" id="cuisine_link" onClick="return revert_cuisine('<?php echo $cuisine['Cuisine']['id']; ?>','<?php echo $rcurl;?>')">Revert</a> 	<span>|</span>
              <a href="javascript:void(0)" id="cuisine_link" onClick="show_delete('form_<?php echo $cuisine['Cuisine']['id']; ?>')" onMouseOut="hide_cuisine('delete_form')">Delete </a> 
              
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
                <?php $i++; endforeach; ?>   
        	
        </div>
        
        
        
        <div style="width:845px; float:left; margin:15px 0 0 0">  
        <span class="pagination">   
        <?php 
        if($this->Paginator->numbers())
        {
        echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
        echo $this->Paginator->numbers();	?> &nbsp; <?php
        echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
        }
        ?> 
        </span>
        </div> 
        
        
        
    </div>
</div>  
    <div class="navi_botom"></div>	
</div>