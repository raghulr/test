$(document).ready(function($) {
	 funcall();
	 $("#dayweek option[value='Weeks']").hide();
});
function funcall(){
	$('#successMessage').fadeOut(5000);
  	$("#errorMessage").fadeOut(5000);
}
function complete(responseText){
	redirect = responseText.split('*');	
	window.parent.$('#neighborhood').html(responseText);
	alert('Nieghborhood appended in the profile page');	
	funcall();
}
function cancel(){
	parent.$.colorbox.close();
	return false;
}
function paymenttype(val){
	//alert(val);
	if(val!=0){
		$('.choose_later').show();
		//$('.paymentuser').css('display','block');
		//$('#show_sign').css('display','none');
		//$('#paymentuser1').css('display','block');
		//$('.confirm').css('enabled','enabled');
	}
	else{
		$('.choose_later').hide();
		/*$('.paymentuser').css('display','none');
		$('#show_sign').css('display','block');
		$('#paymentuser1').css('display','none');
		$('.confirm').css('disabled','disabled');*/
	}
}
function paymenttype_normalsignup(val){
	//alert(val);
	if(val!=0){
		//$('.choose_later').show();
		$('.paymentuser').css('display','block');
		$('#show_sign').css('display','none');
		$('#paymentuser1').css('display','block');
		$('.confirm').css('enabled','enabled');
	}
	else{
		//$('.choose_later').hide();
		$('.paymentuser').css('display','none');
		$('#show_sign').css('display','block');
		$('#paymentuser1').css('display','none');
		$('.confirm').css('disabled','disabled');
	}
}

	
function dayorweek(value){
	if(value=='next day'){
		$("#dayweek").val("Days");
		$("#dayweek option[value='Days']").show();
		$("#dayweek option[value='Weeks']").hide();
	}
	else{
		$("#dayweek").val("Weeks");	
		$("#dayweek option[value='Weeks']").show();
		$("#dayweek option[value='Days']").hide();
	}
}

function rewrite_rescity(id,url){
	var val = $('#neighbor_'+id).val();
	if(val!=''){
		var attr = $('#neighbor_'+id).attr('disabled');
		if (typeof attr !== 'undefined' && attr !== false) {
			$('#neighbor_'+id).removeAttr('disabled');
			$('#neighbor_'+id).css({background: '#ffffff', border: '#999999 1px solid'});
		}else{
			$.ajax({
				type:'POST',
				url:url, 
				data:'id='+id+'&name='+val,
				success:function(responseText){
							$('#change_city').html(responseText);
							funcall();
						}
		   	});
			$('#neighbor_'+id).attr('disabled');
			$('#neighbor_'+id).css({background: 'none', border: 'none'});
		}
	}
	else{
		alert("Please enter the city name");
		$('#neighbor_'+id).removeAttr('disabled');
		$('#neighbor_'+id).css({background: '#ffffff', border: '#999999 1px solid'});
	}
}
function delete_rescity(id,url){
	jConfirm('Are you sure to delete the City?', 'Confirmation Box',function(r) {
		if(r==true){
			$.ajax({
				type:'POST',
				url:url,
				data:'id='+id,
				success:function(responseText){
					//alert(responseText);
					$('#change_city').html(responseText);
					funcall();
				}
			});
		}else{
			return false;
		}
	});
}
function revert_rescity(id,url){
		$.ajax({
			type:'POST',
			url:url,
			data:'id='+id,
			success:function(responseText){
				$('#change_city').html(responseText);
				funcall();
			}
		});
}
function show_neighbor(classname){
		$('.'+classname).show();
}
function hide_neighbor(classname){
		$('.'+classname).hide();

}
