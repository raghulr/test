<?php 
	//$javascript->link('jquery-1.6.1.min', false);
	$javascript->link('ajax.js', false);
	$javascript->link('jquery.ui.core', false);
	$javascript->link('jquery.ui.widget', false);
	$javascript->link('jquery.ui.mouse', false);
	$javascript->link('jquery.ui.draggable', false);
	$javascript->link('jquery.ui.sortable', false);
	$javascript->link('jquery.cycle.all', false);
	echo $html->css('skin', null, null, false)
?>
<script type="text/javascript">
	function sample(change_url){
		jConfirm('Are you sure you want to delete it?', 'Confirmation Box',function(r) {
		if(r==true){
			$.ajax({
				type:'POST',
				url:change_url,
				success: function(responseText) {
					 window.location.reload();
					funcall();
				}
			  })
		}else{
			return false;
		}
		});
	}
   $(document).ready(function($) {
 
	$('.profile_photo').cycle({
			fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			pager:'#slidenav',
			
		});
		$( "#sortable" ).sortable({
			revert:false,
			stop:function(event,ui){
			 var order=new Array();
			 $('#sortable li').each(function(){
			   order.push($(this).attr('id'));
			   });
			 $.ajax({
  				 type: "POST",
  				 url: "<?php echo $html->url(array('controller'=>'slideshows','action'=>'orderedlist'),true);?>",
  				 data:"list="+order ,
   				success: function(msg){
			   }
			 });
			}
		});
});	
   </script>
   <?php //min-height:724px; //min-height:670px; ?>
<div class="test" style="width:735px; height:auto; background:#FFFFFF; float:left;">
<div class="slideshowmain">
	<div class="slide_head">
        <div class="slidetitle">EDIT PHOTOS</div>
    		<a href="#" onclick="parent.$.colorbox.close(); return true;" style="float:right; margin: 10px 2px 0 0;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
    	</div>
    </div>
	<div class="alll">
        <div class="slidetop">
            <div class="slidecontent">
                <span>To change the order of photos, drag a photo to its new position</span>
            </div>
            <a href="<?php echo $html->url(array('controller'=>'slideshows','action'=>'add'),true); ?>"><?php echo $html->image('/images/photo_but.png',array('border'=>0));?></a>
        </div>
        <ul id="sortable">
        	<?php if(!empty($imagelist)){foreach($imagelist as $list): ?>
        		<li id="<?php echo $list['Slideshow']['id'];?>">
                	<div class="pho_cont">
                    <div class="left_buttn"><?php /*?><!--<a href="<?php echo $html->url(array('controller'=>'slideshows','action'=>'delete',$list['Slideshow']['id']),true); ?>" onClick="if(confirm('Are you sure want to delete')){return true}else{ return false};"><?php echo $html->image('/images/close_delete.png',array('border'=>0));?></a>--><?php */?>
                     <?php $time_url = $html->url(array('controller'=>'slideshows','action'=>'delete',$list['Slideshow']['id']),true); ?>
                        <a href="javascript:;" onclick="return sample('<?php echo $time_url; ?>');">
                        	<?php echo $this->Html->image("/images/close_delete.png",array('border'=>0)); ?>
                        </a>
                    </div>
                    <div class="rit_cont">
                        <?php echo $html->image('small/'.$list['Slideshow']['path'],array('border'=>0,'height'=>100,'class'=>'phot_img')); ?>
                        <div class="pho_detail">
                            <div class="capt"><span>CAPTION</span></div>
                            <div class="ph_tex"><?php echo $list['Slideshow']['description']; ?></div>
                        </div>
                </li>
    			<?php endforeach; }?>
    	</ul>
            </div>
        </div>
   </div>
 </div>       
</div>