 <?php	echo $html->css('adminpopup.css');?>
<style>
    .user_det_left #button_submit img {
float: right;
margin: -4px 19px 0 0;
}.user_det_left #button_submit{
margin:-28px 0px 0px 154px;
}
.update_a{
            text-decoration: none;font-size: 19px;font-weight: bold;padding: 3px 16px 3px 18px;border: 1px solid lightgreen;margin: 80px 0px 0px 45px;background-color: lightgreen;color: green;border-radius: 4px;
        }
.update_d{
            text-decoration: none;font-size: 19px;font-weight: bold;padding: 4px 16px 5px 18px;border: 1px solid #9f0101;margin: 0px 0px 0px 45px;background-color: #9f0101;color: white;border-radius: 4px;
        }
    </style>
  <?php if($user_detail_count>=8){ ?>
  <style>
  	.tabl_cont{
		overflow-y:scroll;
		height:281px;
	}
	.user_det_right .tabl_head{
		width:450px;
	}
	.user_det{
		height:330px;
	}
        
  </style>
  <?php } ?><div class="upload_top" style="width:848px;">
	<div class="upload_text">
    	<h2>USER DETAILS</h2>
    </div>    
    <div class="pop_up_middle">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    <div class="up_middle"></div>
</div>
<div class="user_det">
	<div class="user_det_close"></div>
    <?php if(!empty($user_detail)){?>
	<div class="user_det_left">
		<?php foreach($user_detail as $data):// pr($data); ?>
        
            <span><?php echo $data['User']['firstName']."&nbsp;".$data['User']['lastName']; ?></span>
            
            <span id="left_span"><a href="mailto:<?php echo $data['User']['email']; ?>"><?php echo $data['User']['email']; ?></a></span>
            
            <span id="left_span1"><?php echo $data['User']['phone']; ?></span>
            
            <?php $id = $data['User']['id']; ?>            
                <?php 
                    echo $form->create('User', array('action' => 'super_user_change_password'));?>

               <span id="left_span1">New Password :<?php echo $form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$id));
echo $form->input('User.password',array('type'=>'password','label'=>false,'div'=>false));echo $form->submit('Update',array('class'=>'update_a','label'=>false,'div'=>false));
				  echo $form->end();
				 ?></span>	
            <span id="button_submit"> 				<?php //echo $ajax->submit('Delete User Account', array('url'=> array('controller'=>'users', 'action'=>'delete_user',$id))); ?>
                <a href="<?php echo $html->url(array('controller'=>'users','action'=>'delete_user',$id)); ?>" target="_parent" class='update_d'>Delete</a>  
            </span>
            
        <?php break; endforeach; ?>
    
    </div>
    
    <div class="user_det_right">
    
    	<span>Reservation History</span>
    
    	<div class="tabl_head">
        	
            <div class="tabl_sub"><span id="time">Restaurant</span></div>
            <div class="tabl_sub1"><span id="time">Date</span></div>
            <div class="tabl_sub2"><span id="time">Time</span></div>
            
        </div>
        
        <div class="tabl_cont" id="change_city">
        
		<?php 
        $i = 1;
        $class='fist_row';
        if(!empty($user_detail)):
		//print_r($user_detail);
        foreach($user_detail as $data): 
        ?>
        	<div class="<?php if($class=='fist_row'):
				echo $class;
				$class='sec_row';
			else:
				echo $class;
				$class='fist_row';
			endif;?>">
            	<div class="tabl_sub">
                	<?php if(!isset($data['Offer']['Restaurant']['name'])){?>
                    <span id="time" style="margin:4px 0 0 18px !important;"> 
                         <?php echo "Restaurant no longer part of TableSAVVY network"; ?>
                    </span>
                    <?php }else{ ?>
                     <span id="time"> 
                    	 <?php echo $data['Offer']['Restaurant']['name']; ?>
                      </span>
                    <?php } ?>
                </div>
            	<div class="tabl_sub1">
                	<?php if(!empty($data['Offer']['offerDate'])){?>
                    	<span id="time"><?php echo $data['Offer']['offerDate']; ?></span>
                     <?php } ?>
                </div>
            	<div class="tabl_sub2">
                	<?php if(!empty($data['Offer']['offerTime'])){?>
                    	<span id="time"><?php echo $data['Offer']['offerTime']; ?></span></div>
                     <?php } ?>
            </div>
        <?php endforeach; endif; ?>
        </div> 	
    </div>
	<?php } else { ?>
        <div class="user_det_left">
		<?php foreach($user_info as $data):// pr($data); ?>
        
            <span><?php echo $data['User']['firstName']."&nbsp;".$data['User']['lastName']; ?></span>
            
            <span id="left_span"><a href="mailto:<?php echo $data['User']['email']; ?>"><?php echo $data['User']['email']; ?></a></span>
            
            <span id="left_span1"><?php echo $data['User']['phone']; ?></span>
            
            <?php $id = $data['User']['id']; ?>            
                <?php 
                    echo $form->create('User', array('action' => 'super_user_change_password'));?>

               <span id="left_span1">New Password :<?php echo $form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$id));
echo $form->input('User.password',array('type'=>'password','label'=>false,'div'=>false));echo $form->submit('Update',array('class'=>'update_a','label'=>false,'div'=>false));?>
<a href="<?php echo $html->url(array('controller'=>'users','action'=>'delete_user',$id)); ?>" target="_parent" class='update_d'>Delete</a> 
				  <?php echo $form->end();
				 ?></span>	
            <span id="button_submit"> 				<?php //echo $ajax->submit('Delete User Account', array('url'=> array('controller'=>'users', 'action'=>'delete_user',$id))); ?>
                  
            </span>
            
        <?php break; endforeach; ?>
    
    </div>
    
    <div class="user_det_right" style="margin-top:98px;font-size: 20px;">    
    	<span style="margin-left: 120px;"> No Reservation Result</span>
    </div>
    <?php } ?>
</div>

<script type='text/javascript'>
$(document).ready(function(){  
    $(".tabl_cont").css('min-height','281px');
  $(".update_a").click(function(){
var href=$(this).attr('href')+'/'+$('#UserPassword').val();
$(this).attr('href',href);
  });  
});
</script>