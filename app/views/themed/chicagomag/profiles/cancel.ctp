<?php /*?><?php 
if(isset($seating) && isset($offer_time) && isset($phone) && isset($survo_id) ): 
	$url=$html->url(array('controller'=>'profiles','action'=>'ifbyphone',$fname,$lname,$offer_time,$seating,$phone,$survo_id),true);
?>
<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery.ajax({
					url: '<?php echo $url; ?>',
					success: function(data) {
						//alert(data);
					}
				});
			});
</script>
<?php endif; ?><?php */?>