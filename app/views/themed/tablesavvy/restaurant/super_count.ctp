<style>
input {
    margin: 1px;
    width: 74px;
}
#rest_no{ 
	width:414px;
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
}
#rest_no1{ 
	width:350px;
    float: left;
    height: 100%;
	border:none;
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
#rest_no_user1 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 414px;
}
#rest_no_user2 {
    float: left;
    height: 100%;
    width: 250px;
}
.tabl_cont {
    float: left;
    height: 485px;
    margin: 0 0 0 30px;
    width: 94%;
}
.res_tabl .tabl_head {
    background: none repeat scroll 0 0 #3B3B3B;
    float: left;
    height: 48px;
    width: 94%;
	margin:0 0 0 30px;
}
.res_tabl {
    float: left;
    height: 575px;
    margin: 10px 0 0 18px;
    width: 850px;
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
            <li class="active_link"><?php echo $html->link('Count',array('controller'=>'Restaurants','action'=>'count')); ?></li>
            <li><?php echo $html->link('Restaurants',array('controller'=>'Restaurants','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'users','action'=>'index','delete')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'users','action'=>'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'cuisines','action'=>'index')); ?></li>
            <li><?php echo $html->link('Table',array('controller'=>'Restaurants','action'=>'addtable')); ?></li>
        </ul>
    </div>
    <div class="navi_content">
    	<?php  
		if(!empty($restaurant_name)){
			$date = date('Y-m-d');?>
            <div class="res_tabl">
                <div class="tabl_head">
                        <div class="time" id="rest_no_user1"><span id="time">Restaurant Name</span></div>  
                        <div class="time" id="rest_no_user2"><span id="time">Available tables for <?php echo $date; ?></span></div>  	
                </div>
           			 <div class="tabl_cont" id="change_city" style="height:480px; <?php if(count($restaurant_name)>10) echo 'overflow-y:scroll;';?>">
                <?php  
                $class='fist_row';
			foreach($restaurant_name as $data){?>
            <div id="<?php echo $data['Restaurant']['name'];?>" class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
            <?php
				$row=mysql_fetch_array(mysql_query("select count(*) from offers where offers.restaurantId='".$data['Restaurant']['id']."' AND offers.offerDate='".$date."'"));
				?>
                   <div class="time" id="rest_no">
                        <span id="neigh_name1"><?php if(!empty($data['Restaurant']['name'])) echo $data['Restaurant']['name']; ?></span>
                   </div>
                   <div class="time" id="rest_no1">
                        <span id="neigh_name1"><?php 
						if(!empty($row[0])) 
							echo $row[0]; 
						else
							echo 'No Available Tables';
						?></span>
                   </div>
            </div>
                <?php
			}?>
         </div>
		<?php }
		?>
    </div>
    </div>
    <div class="navi_botom"></div>
   	
</div>