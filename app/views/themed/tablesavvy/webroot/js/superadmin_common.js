$(document).ready(function($) {
	//window.parent.$('#neighborhood').html(responseText[2]);					   	
	 //$('form.js-ajax-form').fajaxform();
	 //$('a.js-ajax-link').fajaxlink();
	
	 $(".colorbox").colorbox();
	 $(".colorbox-min").colorbox({iframe:true,innerWidth:500,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	 $(".colorbox-add").colorbox({iframe:true,innerWidth:600,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	  $(".colorbox-website-add").colorbox({iframe:true,innerWidth:600,innerHeight:600,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	 $(".colorbox-medimum").colorbox({iframe:true,innerWidth:655,innerHeight:415});
	 $(".colorbox-medimum_chart").colorbox({iframe:true,innerWidth:530,innerHeight:430});
	 $(".colorbox-larger").colorbox({iframe:true,innerWidth:800,innerHeight:600});
	  $(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500,scrolling:false});
	   $(".colorbox-larger_rescity").colorbox({iframe:true,innerWidth:460,innerHeight:720,onClosed:function(){parent.window.location.reload();}});
	   $(".recurring").colorbox({scrolling:false});
	    $(".colorbox-slide-larger").colorbox({iframe:true,innerWidth:700,innerHeight:400,onClosed:function(){parent.window.location.reload();}});
		$(".colorbox-slide-larger-photo").colorbox({iframe:true,innerWidth:760,innerHeight:400,onClosed:function(){parent.window.location.reload();}});
		$(".preview_slide").colorbox({iframe:true,innerWidth:400,innerHeight:330});
		 $(".color_login").colorbox({iframe:true,innerWidth:625,innerHeight:349,scrolling:false});
		 $("#dayweek option[value='Weeks']").hide();
	 funcall();
	 /*$('.profile_photo').cycle({
		fx: 'fade',
		prev:'#prev',
        next:'#next'

	});*/
});

function funcall(){
	$('#successMessage').fadeOut(5000);	
  	$("#errorMessage").fadeOut(5000);
}
function dayorweek(value){
	if(value=='next day'){
		$("#dayweek option[value='Days']").detach();
		var o = new Option("option text", "Days");
		$(o).html("Days");
		$("#dayweek").append(o);
		$("#dayweek").val("Days");
		$("#dayweek option[value='Weeks']").detach();
	}
	else{
		$("#dayweek option[value='Weeks']").detach();
		var o = new Option("option text", "Weeks");
		$(o).html("Weeks");
		$("#dayweek").append(o);
		$("#dayweek").val("Weeks");	
		$("#dayweek option[value='Days']").detach();
	}
}
function complete(responseText){
	redirect = responseText.split('*');	
	window.parent.$('#neighborhood').html(redirect[2]);
	alert('Nieghborhood appended in the profile page');	
}
$.fn.fajaxform = function() {
	$(this).submit(function() {		
		var $that = $(this);
		var $submitButton = $(this, "input[type='submit']");
		$submitButton.attr("disabled", "true");
		jQuery.ajax({
			data: $that.serialize(),
			url: $that.attr("action"),
			type: 'POST',
			error: function() {
				return true;
			},
			success: function(responseText) {
				redirect = responseText.split('*');
				if (redirect[0] == 'redirect') {
					location.href = redirect[1];
				}else if(redirect[0] == 'update') {
					$(redirect[1]).html(redirect[2]);
				}
				else{
					$('.js-responses').html(responseText);
				}
				$('form.js-ajax-form').fajaxform();
			}
		}) 
		return false;
	});
}
$.fn.fajaxlink = function(){
	$(this).click(function(){
		var $that = $(this);				   
		jQuery.ajax({
			data: $(this).serialize(),
			url: $that.attr("href"),
			error: function() {
				return true;
			},
			success: function(responseText) {
				redirect = responseText.split('*');
				if (redirect[0] == 'update') {
					window.parent.$(redirect[1]).html(redirect[2]);
					alert('Neighborhood appended in the profile page');
				}else
				$('.js-responses').html(responseText);
			}
		}) 				   	
		return false;				   
	});
}
function startTime()
{
	var currentTime = new Date ( );
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
 	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;
	var currentTimeString = currentHours + ":" + currentMinutes + " " + timeOfDay;
	document.getElementById('ad_time').innerHTML=currentTimeString;
	t=setTimeout('startTime()',500);
}
function cancel(){
	parent.$.colorbox.close();
	return false;
}
/*function show(time,seat,showid,resid){
	 $('#show_hide_'+showid+'_'+seat).fadeTo('slow',0.75);
	 $('#assign_current_'+seat+'_'+showid).val(time+'_'+seat+'_'+showid+'_'+resid);
}
function hide(seat,showid){
	 $('#show_hide_'+showid+'_'+seat).hide();
	
}
function showtip(showID) {
  	$('#'+showID).show();
   }
   function hidetip(showID) {
     $('#'+showID).hide();
   }
function add(url1,seat,showid){
 var dataa= $('#assign_current_'+seat+'_'+showid).val();
 str=dataa.split('_');
	$.ajax({
		type:'POST',
		url:url1,
		data:'time='+str[0]+'&seat='+str[1]+'&resid='+str[3]+'&showid='+str[2],
		success: function(responseText) {
			$('#int_'+str[2]+'_'+str[1]).html(responseText);
			var total=parseInt($('#total_'+showid).text())+1;
			$('#total_'+showid).text(total);
			$('#show_hide_'+str[2]+'_'+str[1]).css({'display':'block'});
		}	
	});
	return true;
}
function delete1(url1,seat,showid){
 //if(confirm('Are You sure want to delete?')){
 var	dataa=$('#assign_current_'+seat+'_'+showid).val();
 str=dataa.split('_');
	$.ajax({
		type:'POST',
		url:url1,
		data:'time='+str[0]+'&seat='+str[1]+'&resid='+str[3]+'&showid='+str[2],
		success: function(responseText) {
			res=responseText.split('*');
			
			$('#int_'+str[2]+'_'+str[1]).html(res[1]);
			//alert(parseInt($('#total_'+str[2]).text()));
			if(res[0]=='deleted'){
				var total=parseInt($('#total_'+str[2]).text())-1;
				$('#total_'+showid).text(total);
			}else{
				var	total=$('#total_'+str[2]).text();
				$('#total_'+showid).text(total);
			}
			$('#show_hide_'+str[2]+'_'+str[1]).css({'display':'block'});
		}
	});
	return true;
	//}else{
		
	//}
}*/
function show(time,seat,showid,date){
		$(".tooltip").hide();
	 $('#show_hide_'+showid+'_'+seat).fadeTo('slow',0.75);
	  $('#OfferOfferTime').val(time);	
	$('#OfferSeating').val(seat);	
	 $('#OfferOfferDate').val(date);
}
function hide(seat,showid){
	 $('#show_hide_'+showid+'_'+seat).hide();
	
}
function showtip(showID) {
  	$('#'+showID).show();
   }
function hidetip(showID) {
     $('#'+showID).hide();
   }
function add(url1,seat,showid){
 	var data1=$('#RestaurantAdminIndexForm').serialize();
	if(data1==''){
	var data1=$('#RestaurantAdminChangedateForm').serialize();	
	}
	$.ajax({
		type:'POST',
		url:url1,
		data:data1,
		success: function(responseText) {
			res=responseText.split('*');
			$('#int_'+showid+'_'+seat).html(res[1]);
			if(res[0]=='saved'){
				var total=parseInt($('#total_'+showid).text())+1;
				$('#total_'+showid).text(total);
			}else{
				var	total=$('#total_'+showid).text();
				$('#total_'+showid).text(total);
			}
		}
		   });
}
function delete1(url1,seat,showid){
 //if(confirm('Are You sure want to delete?')){
 var data1=$('#RestaurantAdminIndexForm').serialize();
 if(data1==''){
	var data1=$('#RestaurantAdminChangedateForm').serialize();	
	}
	$.ajax({
		type:'POST',
		url:url1,
		data:data1,
		success: function(responseText) {
			res=responseText.split('*');
			$('#int_'+showid+'_'+seat).html(res[1]);
			if(res[0]=='deleted'){
				var total=parseInt($('#total_'+showid).text())-1;
				$('#total_'+showid).text(total);
			}else{
				var	total=$('#total_'+showid).text();
				$('#total_'+showid).text(total);
			}
		}
		   });
}
function changedate(value,url1){
	$.ajax({
		type:'POST',
		url:url1,
		data:'date='+value,
		success: function(responseText) {
			$('#changedate').html(responseText);
			 $('.date-pick').datePicker();
			 $(".colorbox-min").colorbox({iframe:true,innerWidth:500,innerHeight:400,scrolling:false});
				vtip();
		}	
	});	
}
function showalert(classname){
	 $('.'+classname).show();
}
function hidealert(classname){
	 $('.'+classname).hide();
}
/************************************************************** Neighborhood ***********************************************/
function changecity(value,change_url){
	/*alert(value);*/
		$.ajax({
			type:'POST',
			url:change_url, 
			data:'id='+value,
			success: function(responseText) {
				$('#change_city').html(responseText);	
			}
		})
}

function show_city(classname){
		$('.'+classname).show();
}
function hide_city(classname){
		$('.'+classname).hide();
}
function submit_city(city_url){
	/*alert(city_url);*/
	var city=$('#city').val();
	/*alert(city);*/
	$.ajax({
		   	type:'POST',
			url:city_url,
			data:'city_name='+city,
			success:function(responseText){
						/*alert(responseText);*/
						$('#form').html(responseText);
					}
		   });
	return true;
			
}
function show_neighbor(classname){
		$('.'+classname).show();
}
function hide_neighbor(classname){
		$('.'+classname).hide();

}
function submit_neighbor_city(city_url){
	alert(city_url);
	var neighbor=$('#neighbor').val();
	alert(neighbor);
	$.ajax({
		   	type:'POST',
			url:city_url,
			data:'neighbor_name='+neighbor,
			success:function(responseText){
						alert(responseText);
						$('#form1').html(responseText);
					}
		   });
	return true;
}
/************************************************************** Neighborhood ***********************************************/

/************************************************************** Cuisine ***************************************************/
function show_cuisine(classname){
		$('.'+classname).show();
}
function hide_cuisine(classname){
		$('.'+classname).hide();
}
function submit_cuisine(cuisine_url){
	var cuisine=$('#cuisine').val();
	var pathArray = window.location.pathname.split( '/page:' );
	$.ajax({
		   	type:'POST',
			url:cuisine_url+'&page='+pathArray[1],
			data:'cuisine_name='+cuisine,
			success:function(responseText){
					//alert(responseText)
					$('#form').html(responseText);
					$('#cuisine').val('');
					funcall();
				}
		   });
}

function update_cus(id,url){
	var val = $('#cuisine_'+id).val();
	if(val!=''){
		var attr = $('#cuisine_'+id).attr('disabled');
		if (typeof attr !== 'undefined' && attr !== false) {
			$('#cuisine_'+id).removeAttr('disabled');
			$('#cuisine_'+id).css({background: '#ffffff', border: '#999999 1px solid'});
		}else{
			$.ajax({
				type:'POST',
				url:url, 
				data:'id='+id+'&name='+val,
				success:function(responseText){
							$('#form').html(responseText);
							funcall();
						}
		   	});
			$('#cuisine_'+id).attr('disabled');
			$('#cuisine_'+id).css({background: 'none', border: 'none'});
		}
	}
	else{
		alert("Please enter the cuisine name");
		$('#cuisine_'+id).removeAttr('disabled');
		$('#cuisine_'+id).css({background: '#ffffff', border: '#999999 1px solid'});
	}
}

function delete_cuisine(id,url){
	var href = window.location;
	var pathArray = window.location.pathname.split( '/page:' );
	var val = $('#cuisine_'+id).val();
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&name='+val+'&page='+pathArray[1],
		success:function(responseText){
			responseText1=responseText.split('*');
			//alert(responseText);
			$('#form').html(responseText);
			//$('#successMessage').html(responseText1[0]);
			//$('#form').html(responseText1[1]);
			funcall();
			//alert('Nieghborhood appended in the profile page');	
		}
	});
}

function revert_cuisine(id,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success:function(responseText){
			$('#form').html(responseText);
		}
	});
}
function show_delete(classname){
	$('#'+classname).show();
}

function hide_delete(classname){
	$('#'+classname).hide();
}


/************************************************************** Cuisine ***************************************************/

/************************************************************** City ***************************************************/
function rewrite_city(id,city_id,url){
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
				data:'id='+id+'&city_id='+city_id+'&name='+val,
				success:function(responseText){
							$('#change_city1').html(responseText);
							funcall();
						}
		   	});
			$('#neighbor_'+id).attr('disabled');
			$('#neighbor_'+id).css({background: 'none', border: 'none'});
		}
	}
	else{
		alert("Please enter the Neighbor name");
		$('#neighbor_'+id).removeAttr('disabled');
		$('#neighbor_'+id).css({background: '#ffffff', border: '#999999 1px solid'});
	}
}

/*function delete_city(id,city_id,url){
	alert('hai');
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&city_id='+city_id,
		success:function(responseText){
			$('#change_city').html(responseText);
		}
	});
}*/

function delete_city(id,city_id,url){
	var val = $('#neighbor_'+id).val();
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&city_id='+city_id+'&name='+val,
		success:function(responseText){
			responseText1=responseText.split('*');
			//alert(responseText1[0]);
			$('#form').html(responseText1[1]);
		}
	});
}

function show_delete_city(classname){
	$('#'+classname).show();
}

function hide_city_delete(classname){
	$('#'+classname).hide();
}



function revert_city(id,city_id,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&city_id='+city_id,
		success:function(responseText){
			$('#change_city1').html(responseText);
		}
	});
}

/************************************************************** City ***************************************************/
/************************************************************** Rest ***************************************************/

function change_restaurant(value,rest_url){
		$.ajax({
			type:'POST',
			url:rest_url, 
			data:'id='+value,
			success: function(responseText) {
				$('#change_city').html(responseText);	
			}
		})
}

function change_appropvefield(value,approve_url,rest_id,approve_id){
	$.ajax({
		   	type:'POST',
			url:approve_url,
			data:'id='+value+'&rest_id='+rest_id+'&approve_id='+approve_id,
			success: function(responseText) {
				$('#change_city').html(responseText);
				funcall();
			}
		   })
}

/************************************************************** Rest ***************************************************/
function approved(id,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success:function(responseText){
			alert("Mail send");
		}
	});	
}

function reject(id,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success:function(responseText){
			alert("Mail send");
			$('.navi_content').html(responseText);
		}
	});	
}

function get_date_display(url){
	var date = document.getElementById("date1").value;
	var monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	var d = new Date(date);
	var date = d.getDate();
	var month = monthNames[d.getMonth()];
	var mon = d.getMonth()+1;
	if(mon>=10)
		mon = mon;
	else
		mon = "0"+mon;
	var year = d.getFullYear();
	var changed_date = year+"-"+mon+"-"+date;
	var changed_value = month+" "+date+", "+year;
	document.getElementById("rdate").value=changed_value;
	$.ajax({
		type:'POST',
		url:url,
		data:'date='+changed_date,
		success:function(responseText){
			$('.tabl_cont').html(responseText);
		}
	});	
}
/************************************************** User Statistics ***************************************************/
function previous_date(value,date_url){
	current_date=$('#cur_date').text();
	$.ajax({
		   	type:'POST',
			url:date_url,
			data:'status='+value+'&currentdate='+current_date,
			success: function(responseText) {
				responseText1=responseText.split('*');
				$('#cur_date').html(responseText1[0]);
				$('#userone').html(responseText1[1]);
				
			}
		   })
}


/************************************************** User Statistics ***************************************************/
/*************************Website Approved*********/
function changeWebsite_status(value,id,url){
	if(!$('#website_check_'+id).is(':checked')){
		value=0;
	}
	var Approve_Post_url=url;
	$.ajax({
		type:'POST',
		url:Approve_Post_url,
		data:'approved='+value+'&id='+id,
		success: function(responseText) {
			$('#message_update').html(responseText);
			funcall();
		}
	});
}
/******************View status ************/
jQuery(document).ready(function(){
	$('#website_status').change(function(){
		var Approve_Post_url=$('#status_url').val();
		var value=$(this).val();
		$.ajax({
			type:'POST',
			url:Approve_Post_url,
			data:'status='+value,
			success: function(responseText) {
				$('#website_list').html(responseText);
				status_pagination();
			}
		});
										 	
	});
								
});
function status_pagination(){
	$('#status_pagination .prev,#status_pagination .next').click(function(){
			var Approve_Post_url=$(this).attr('href');
			var value=$('#website_status').val();
			$.ajax({
				type:'POST',
				url:Approve_Post_url,
				data:'status='+value,
				success: function(responseText) {
					$('#website_list').html(responseText);
					status_pagination();
				}
			});
			return false;
		});
}
/*neighboirhood*/
var mainurl = document.getElementById('site_url').value;
function delete_res(change_url,id){
	jConfirm('Are you sure to delete the user?', 'Confirmation Box',function(r) {
    if(r==true){
		document.getElementById(id).style.display='none';
		//alert(change_url);
		$.ajax({
		   	type:'POST',
			url:change_url,
			success: function(responseText) {
				//alert(responseText);
				$('#change_city').html(responseText);
				$(".pag_normal").show();
				funcall();
				//$(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500});
				window.location.href = window.location.href;
			}
		  })
	}else{
		return false;
	}
	});
}
function delete_ser_res(change_url,id,ser){
	jConfirm('Are you sure to delete the restaurant?', 'Confirmation Box',function(r) {
    if(r==true){
		document.getElementById(id).style.display='none';
		//alert(change_url);
		$.ajax({
		   	type:'POST',
			url:change_url,
			success: function(responseText) {
				//alert(responseText);
				//$('#change_city').html(responseText);
				$(".pag_normal").show();
				funcall();
				
				//$(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500});
				//window.location.reload()
			}
		  })
	}else{
		return false;
	}
	});
}
function change_approvefield(value,approve_url){
	$.ajax({
		   	type:'POST',
			url:approve_url,
			success: function(responseText) {
				$('#change_city').html(responseText);
				$(".pag_normal").show();
				funcall();
				window.location.href = window.location.href;
				//$(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500});
			}
		   })
}
function user_cred(val,id){
	var mainurl = jQuery('#site_url').val();
	var href =mainurl+'super/users/puser_credit/'+val+'/'+id;
	var url = href
	$.ajax({
		url:url,
		type:"POST",
		success: function(responseText) {
			//alert(responseText);
			$('#credit_message').html(responseText);
			funcall();
		}
	});
}
$(document).ready(function(){
/*$(".pagination a").click(function(){
			//this.href=this.href.replace('index', 'user_search');
            $(".tabl_cont").load(this.href);
			$(".pag_normal").hide();
            return false;
        });
		*/
/*$('#usersIndexForm').submit(function(e){
			e.preventDefault();
			var href =mainurl+'super/users/user_search/'+$('.sear_rest').val();
			var url = href
			$.ajax({
				url:url,
				type:"POST",
				success: function(responseText) {
					//alert(responseText);
					$('#change_city').html(responseText);
					$(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500});
				}
		});
	});*/
});
function credit_update(){
	var val=document.getElementById('usersUserCredit').value;
	document.getElementById('credit_update').innerHTML='Remaining credit:'+' :'+val;
}