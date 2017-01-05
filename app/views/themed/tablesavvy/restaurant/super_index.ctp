<style>
input {
    margin: 1px;
    width: 74px;
}
#rest_no{ width:210px;}
#rest_no1 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 154px;
}
#rest_no3 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 98px;
}
#rest_no5{
	border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 92px;
}
#rest_no4 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 98px;
}
#rest_no6 {
    border-right: 0 ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 85px;
}
.sear_rest {
    float: left;
    height: 22px;
    margin: -10px 0 15px 0;
    width: 145px;
}
.submit{
	float: left;
	margin: -10px 0 15px 0;
}
.time select{
	margin-top:10px!important;
	width:82px!important;
}
</style>
<?php
if(isset($this->params['named']['page'])&&!empty($this->params['named']['page']))
	$page = 'page:'.$this->params['named']['page']; 
else
	$page = 'page:1';
?>
<script>
var mainurl = jQuery('#site_url').val();
var page = '<?php echo $page; ?>';
function delete_res(change_url){
	jConfirm('Are you sure to delete the restaurant?', 'Confirmation Box',function(r) {
    if(r==true){
		var pathArray = window.location.pathname.split( '/page:' );
		$.ajax({
		   	type:'POST',
			url:change_url+'&page='+pathArray[1],
			success: function(responseText) {
				$('#change_city').html(responseText);
				funcall();
                                $(".colorbox-add").colorbox({iframe:true,innerWidth:600,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
			}
		  })
	}else{
		return false;
	}
	});
}
function change_rank(){
	$('.changeval').change(function(){
		var value=$(this).val();
		var id=$(this).attr('id');
		var spiltid=id.split('_');
		var restId=spiltid[1];
		var page = '<?php echo $page; ?>';
		var href =mainurl+'super/restaurants/restaurant_rank/'+page;
		$.ajax({
				url:href,
				type:'POST',
				data:'rank_value='+value+'&restId='+restId,
				success: function(responseText) {
					$('.success_message_class').html(responseText);
					funcall();
				}
		});
	});
}

$(document).ready(function(){
	$(".pagination a").click(function(){
			this.href=this.href.replace('index', 'restaurant_change');
                        $(".tabl_cont").load(this.href);
                        
            return false;
        });
		
	$('.changeval').change(function(){
		var value=$(this).val();
		var id=$(this).attr('id');
		var spiltid=id.split('_');
		var restId=spiltid[1];
		var href =mainurl+'super/restaurants/restaurant_rank';
		$.ajax({
				url:href,
				type:'POST',
				data:'rank_value='+value+'&restId='+restId,
				success: function(responseText) {
					$('.success_message_class').html(responseText);
					funcall();
				}
		});
	});
	$('.select_box').change(function(){
			//e.preventDefault();
			var page = '<?php echo $page; ?>';
			var href =mainurl+'super/restaurants/restaurant_change/'+$('.select_box').val()+'/'+$('.sear_rest').val();
			var url = href
			$.ajax({
				url:url,
				type:"POST",
				success: function(responseText) {
					$('#change_city').html(responseText);
					//$('#nor_page').hide();
                                        $(".colorbox-add").colorbox({iframe:true,innerWidth:600,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
					change_rank();
				}
		});
	});
	
	$('#RestaurantsIndexForm').submit(function(e){
			e.preventDefault();
			var href =mainurl+'super/restaurants/restaurant_change/'+$('.select_box').val()+'/'+$('.sear_rest').val();
			var url = href
			$.ajax({
				url:url,
				type:"POST",
				success: function(responseText) {
					$('#change_city').html(responseText);
					 $(".colorbox-add").colorbox({iframe:true,innerWidth:600,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
					//$('#nor_page').hide();
					change_rank();
				}
		});
	});
});
</script>
<div id="changedate">

<div class="success_message_class"></div>
    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Dashboard ',array('controller'=>'users','action'=>'dashboard'))?></li>
            <li><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>
            <li class="active_link"><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'users','action'=>'index','delete')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
    <?php $serach =''; 
			if(!empty($res_searc)){
				$serach = $res_searc;
			} ?>
    <?php echo $form->create('Restaurants', array('action' => 'index', 'name' => 'restaurants'));?>  
    
    <div class="navi_content">
        <div class="neighbor_select" id="rest_select">
        <div style="margin-left:5px;"><a href="<?php echo $html->url(array('controller'=>'Users','action'=>'super_addrestraunt')); ?>" class="colorbox-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;"><?php echo "Add Restaurant"; ?></a> </div>
        	<h3>View</h3>
            <span class="drop_down_rest">
                <?php 
					$rest_url = $html->url(array('controller'=>'restaurants','action'=>'super_restaurant_change','super'=>true),true);
                	/*echo $form->input('Restaurants',array('label'=>false, 'class'=>'select_box','type'=>'select','label'=>false,'options'=>array(2=>'All',1=>'Approved',0=>'Cancelled'),'selected'=>'Select','onchange' =>'change_restaurant(this.value,"'.$rest_url.'","'.$serach.'");')); */
					echo $form->input('Restaurants',array('label'=>false, 'class'=>'select_box','type'=>'select','label'=>false,'options'=>array(2=>'All',1=>'Approved',0=>'Cancelled'),'selected'=>'Select'));
                ?>
                
            </span>
            
            <span class="serach_rest">
                <?php echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'sear_rest')); ?>
                <?php echo $form->submit('Search',array('id'=>'search_but')); ?>
            </span>
        
        </div>   
        
        <div class="res_tabl">
        	
            <div class="tabl_head">
               
                    <div class="time" id="rest_no"><span id="time">Name</span></div>  
                    <div class="time" id="rest_no1"><span id="time">City</span></div>
                    <div class="time" id="rest_no2"><span id="time">View</span></div>
                     <div class="time" id="rest_no5"><span id="time">Edit</span></div> 
                    <div class="time" id="rest_no3"><span id="time">Approved</span></div> 
                    <div class="time" id="rest_no4"><span id="time">Remove</span></div> 
                     <div class="time" id="rest_no6"><span id="time">Rank</span></div>
                         	
            </div>
            
            <div class="tabl_cont" id="change_city">
            
            	<?php 
                $i = 1;
                $class='fist_row';
                if(!empty($rest)){
                foreach($rest as $data){
                ?>
                	<div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
                        <div class="time" id="rest_no">
                        	<span id="neigh_name1"><?php echo $data['Restaurant']['name']; ?></span>
                        </div>  
                        <div class="time" id="rest_no1">
                        	<span id="neigh_name1">
                            	<?php 
									$city_id = $data['Restaurant']['city'];
									$row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
									$city_name= $row['city_name']; 
									echo $city_name;
								?>
							</span>
                        </div>
                        <div class="time" id="rest_no2">
                        	<span id="neigh_name2">                            
                            <a href="<?php echo $html->url(array('controller'=>'homes','action'=>'details',$data['Restaurant']['slug_name'],'super'=>false),true);?>" target="_blank" >
								<?php echo $html->image("/images/zoom.png",array("width"=>15,"height"=>15));?>
                            </a>
                            </span>
                        </div>
                        <div class="time" id="rest_no5">
                        	<span id="neigh_name2" style="margin:20px 0 0 20px"> 
                            <?php $rest_id = $data['Restaurant']['id']; ?>
							 <a href="<?php echo $html->url(array('controller'=>'Users','action'=>'super_editrestraunt',$rest_id)); ?>" class="colorbox-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;">
							 	<?php echo $html->image("/images/Edit.gif",array("width"=>20,"height"=>17));?>
                             </a>
                            </span>
                        </div>
                        <div class="time" id="rest_no3">
                        	<span id="neigh_name1">
                            
							<?php 
								$approve_url = $html->url(array('controller'=>'restaurants','action'=>'super_approvefield','super'=>true,$page),true);
								$rest_id = $data['Restaurant']['id'];
								$approve_id = $data['Restaurant']['approved'];
								$checked='';
								if($approve_id == 1)
									$checked='checked';
								echo $form->input('approved', array('label'=>false,'type'=>'checkbox','class'=>'rest_check','checked'=>$checked,'complete'=>'funcall()','onchange' =>'change_appropvefield(this.value,"'.$approve_url.'","'.$rest_id.'","'.$approve_id.'");'));
								
							?>
                            </span>
                        </div> 
                        <div class="time" id="rest_no4">
                        	<span id="neigh_name3">
                        	 	<?php 
									$rest_id = $data['Restaurant']['id'];
									$time_url = $html->url(array('controller'=>'restaurants','action'=>'super_res_del',$rest_id,$page),true); ?>
                                    <a href="javascript:;" onclick="return delete_res('<?php echo $time_url; ?>');">
                                        Delete
                                    </a>
                            </span>
                        </div>
                         <div class="time" id="rest_no6">
                         	<span id="rank">
                            	<?php 
									$rankValue = !empty($data['Restaurant']['rank'])?$data['Restaurant']['rank']:'';
									$rank=array();
									for($i=1;$i<=5;$i++){
										$rank[$i]=$i;
									}
									echo $form->input('rank',array('label'=>false,'id'=>'rankid_'.$rest_id,'type' => 'select','options' =>$rank ,'empty'=>'Select Rank','class'=>'changeval','selected'=>$rankValue));
								?>
                            </span>
                         </div>
                    </div>
                
                <?php 
                    $i++; } }
                ?> 
              </div> 
		<div id="nor_page">
            <?php if(!empty($rest)){ // class="pagination" ?>   
             <div style="width:850px; margin:10px 10px 20px 0; float:right;">
            <span style="float:right">  
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
            <?php }else{ ?>
				 <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                 	No Offer Found
				 </div>
			<?php } ?>
                        </div>
       </div>
    
    
    </div>
    

    
    
      <?php echo $form->end(); ?>
    
    <div class="navi_botom"></div>
   	
</div>