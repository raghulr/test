//cufon();

$(document).ready(function() {

	//window.parent.$('#neighborhood').html(responseText[2]);					   	
	 //$('form.js-ajax-form').fajaxform();
	 //$('a.js-ajax-link').fajaxlink();
	$(".colorbox").colorbox();
	$(".colorbox-min").colorbox({iframe:true,innerWidth:500,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	$(".colorbox-addrec").colorbox({iframe:true,innerWidth:500,innerHeight:600,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	$(".colorbox-edit").colorbox({iframe:true,innerWidth:500,innerHeight:500,scrolling:false,onClosed:function(){
                //parent.window.location.reload();
         }});
	$(".colorbox-change").colorbox({iframe:true,innerWidth:500,innerHeight:300,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	$(".colorbox-add").colorbox({iframe:true,innerWidth:700,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
	$(".colorbox-reserve").colorbox({iframe:true,innerWidth:470,innerHeight:570,scrolling:false});
	$(".colorbox-medimum").colorbox({iframe:true,innerWidth:655,innerHeight:415});
	$(".colorbox-larger").colorbox({iframe:true,innerWidth:800,innerHeight:600});
	$(".colorbox-larger_user").colorbox({iframe:true,innerWidth:850,innerHeight:500});
	$(".recurring").colorbox({scrolling:false});
	//$(".colorbox-slide-larger").colorbox({iframe:true,innerWidth:700,innerHeight:400,onClosed:function(){parent.window.location.reload();}});
	//$(".colorbox-slide-larger-photo").colorbox({iframe:true,innerWidth:752,innerHeight:400,onClosed:function(){parent.window.location.reload();}});
	$(".preview_slide").colorbox({iframe:true,innerWidth:400,innerHeight:330});
	$(".color_login").colorbox({iframe:true,innerWidth:625,innerHeight:500,scrolling:false});
	$(".color_login1").colorbox({iframe:true,innerWidth:625,innerHeight:500,scrolling:false});
	$(".color_login2").colorbox({iframe:true,innerWidth:625,innerHeight:500,scrolling:false});
	$(".color_location").colorbox({iframe:true,innerWidth:625,innerHeight:550,scrolling:false});
	$(".color_contact").colorbox({iframe:true,innerWidth:625,innerHeight:665,scrolling:false});
	var href1=$('.color_contact1').attr('href');
	$(".color_contact1").colorbox({href:href1,iframe:true,innerWidth:625,innerHeight:650,scrolling:false});
	$(".color_sign").colorbox({iframe:true,innerWidth:625,innerHeight:1400,scrolling:false});
	$(".color_how").colorbox({iframe:true,innerWidth:706,innerHeight:900,scrolling:false});
	$(".color_privacy").colorbox({iframe:true,innerWidth:650,innerHeight:700,scrolling:false});
	$(".color_return").colorbox({iframe:true,innerWidth:650,innerHeight:400,scrolling:false});
	funcall();
        reservation_popup();
		pagination();
		restuarant_link();
	$('.profile_photo').cycle({
		fx: 'fade',
		prev:'#prev',
		next:'#next'	
	});
	var url=$('.color_contact').attr('href');
	$('.color_contact').colorbox({href:url});
	$("#getalert").mouseover(function() {
		 $('.explain_cont1').show();
	  }).mouseout(function(){
		$('.explain_cont1').hide();
	});
});
$.ajaxSetup({
    type: 'POST',
    headers: { "cache-control": "no-cache" }
});
function jcarousel(){
	jQuery('.jcarousel-skin-tango').jcarousel({
		start: 1
	});
}

function timecufon(){
	Cufon.replace('#numbers1',{ fontFamily: 'bebas' });
}

function funcall(){
	$('#successMessage').fadeOut(5000);	
  	$("#errorMessage").fadeOut(5000);
}
function complete(responseText){
	redirect = responseText.split('*');	
	window.parent.$('#neighborhood').html(redirect[2]);
	alert('Neighborhood appended in the profile page');	
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
				//alert(responseText);
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
		},	
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
		},	
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
		if(data1==''){
			var data1=$('#RestaurantAdminCleartableForm').serialize();	
		}
	}
	$.ajax({
		type:'POST',
		url:url1,
		data:data1,
                headers: { "cache-control": "no-cache" },
		success: function(responseText) {
			res=responseText.split('*');
			$('#int_'+showid+'_'+seat).html(res[1]);
			if(res[0]=='saved'){
				var total=parseInt($('#total_'+showid).text())+1;
				var grandtotal = parseInt($('#grandtotal').text())+1;
				$('#total_'+showid).text(total);
				$('#grandtotal').text(grandtotal);
			}else{
				var	total=$('#total_'+showid).text();
				var grandtotal = $('#grandtotal').text();
				$('#total_'+showid).text(total);
				$('#grandtotal').text(grandtotal);
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
                headers: { "cache-control": "no-cache" },
		success: function(responseText) {
			res=responseText.split('*');
			$('#int_'+showid+'_'+seat).html(res[1]);
			if(res[0]=='deleted'){
				var total=parseInt($('#total_'+showid).text())-1;
				var grandtotal = parseInt($('#grandtotal').text())-1;
				$('#total_'+showid).text(total);
				$('#grandtotal').text(grandtotal);
			}else{
				//alert(res[0]);
				jAlert(res[0],'Alert Box');
				var	total=$('#total_'+showid).text();
				var grandtotal = $('#grandtotal').text();
				$('#total_'+showid).text(total);
				$('#grandtotal').text(grandtotal);
			}
		}
		   });
}
var newtimer=null;
function changedate(value,url1){
	$.ajax({
		type:'POST',
		url:url1,
		data:'date='+value,
		success: function(responseText) {
			$('#changedate').html(responseText);
			 $('.date-pick').datePicker();
			 $(".colorbox-min").colorbox({iframe:true,innerWidth:500,innerHeight:600,scrolling:false});
			 var d=new Date();
			 var curr_date = d.getDate();
			 var curr_month = d.getMonth() + 1; //Months are zero based
			 var curr_year = d.getFullYear();
			 var format=curr_month + "/" + curr_date + "/" + curr_year;
			 clearTimeout(newtimer); 
			 clearTimeout(timer); 
			 newtimer=setTimeout(function() { changedate(value,url1); },180000);
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
function tool_tip(){
	 $('.toolTip').hover(
    function() {
    this.tip = this.title;
    $(this).append(
     '<div class="toolTipWrapper">'
        +'<div class="toolTipTop"></div>'
        +'<div class="toolTipMid">'
          +this.tip
        +'</div>'
        +'<div class="toolTipBtm"></div>'
      +'</div>'
    );
    this.title = "";
    this.width = $(this).width();
    $(this).find('.toolTipWrapper').css({left:this.width-120})
    $('.toolTipWrapper').fadeIn(300);
  },
    function() {
     $('.toolTipWrapper').fadeOut(100);
      $(this).children('.toolTipWrapper').remove();
        this.title = this.tip;
      }
  );
}
function submit_neighbor_city(city_url){
	//alert(city_url);
	var neighbor=$('#neighbor').val();
	//alert(neighbor);
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
	$.ajax({
		   	type:'POST',
			url:cuisine_url,
			data:'cuisine_name='+cuisine,
			success:function(responseText){
						$('#form').html(responseText);
					}
		   });
	return true;
}

function remove(id,url){
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
	var val = $('#cuisine_'+id).val();
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id+'&name='+val,
		success:function(responseText){
			responseText1=responseText.split('*');
			alert(responseText1[0]);
			$('#form').html(responseText1[1]);
			funcall();
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
							$('#change_city').html(responseText);
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
			$('#change_city').html(responseText);
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
				$(".colorbox-add").colorbox({iframe:true,innerWidth:600,innerHeight:400,scrolling:false,onClosed:function(){parent.window.location.reload();}});
				//window.location.href = window.location.href;
			}
		   })
}

/************************************************************** Reservation ***************************************************/

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
	document.getElementById("rdate1").value=changed_value;
	$.ajax({
		type:'POST',
		url:url,
		data:'date='+changed_date,
		success:function(responseText){
			$('.tabl_cont').html(responseText);
		}
	});	
}

function changereserve(val,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'val='+val,
		success:function(responseText){
			$('.tabl_cont').html(responseText);
		}
	});	
}

/************************************************************** Reservation ***************************************************/

/************************************************** User Statistics ***************************************************/
function previous_date(value,date_url){
	first_date  = $('#first_date').val();
	last_date = $('#last_date').val();
	current_date=$('#cur_date').text();
	$.ajax({
		   	type:'POST',
			url:date_url,
			data:'status='+value+'&firstdate='+first_date+'&lastdate='+last_date+'&currentdate='+current_date,
			success: function(responseText) {
				responseText1=responseText.split('*');
				$('#cur_date').html(responseText1[0]);
				$('#userone').html(responseText1[1]);
			}
		   })
}


/************************************************** User Statistics ***************************************************/

/************************************************** Neighborhood ***************************************************/

function changeneighboor(val,url){
	$.ajax({
		type:'POST',
		url:url,
		data:'val='+val,
		success:function(responseText){
			$('#neigh').html(responseText);
		}
	});	
}

/************************************************** Neighborhood ***************************************************/

/*************************************************** Home Page ***********************************************************/
function setreservationTime(){
	jQuery(".jcarousel-skin-tango li a").click(function(){
		jQuery(".jcarousel-skin-tango li a").attr("id","");;
		this.id="time_active";
	});
}
function changeparty(value){
	var change = value;
	$('.party_size').text(change);
	change2 = value;
	$('#Select_party').text(change2)
}
function passparty(value,home_url){
	$.ajax({
		type:'POST',
		url:home_url,
		data:'id='+value,
		success:function(responseText){
			$('#contentcontainer').html(responseText);
			cufon();
		}
	});
}
function select_reser(value,time_url,id){	
	var timers = jQuery("#"+value +" #time_active").text();
	reservation_time = timers.split(' ')[0];
	ampm=timers.split(' ')[1];
	var partysize = jQuery("#change").val();
	if(partysize=='')
		partysize=2;
	if(timers != ""){
		time_url = time_url+'?party='+partysize+'&rest_id='+id+'&time='+reservation_time+'&ampm='+ampm;
		$('.changehover').colorbox({href:time_url,iframe:true,innerWidth:550,innerHeight:550});
	} else {
		jAlert('Please Select a Reservation Time', 'Alert Box');
		return false;
	}
}
function select_reserve(value,time_url,id,party){
	var timers = jQuery("#"+value +" #time_active").text();
	reservation_time = timers.split(' ')[0];
	ampm=timers.split(' ')[1];
	var partysize = party;
	if(timers != ""){
		time_url = time_url+'?party='+partysize+'&rest_id='+id+'&time='+reservation_time+'&ampm='+ampm;
		$('.changehover').colorbox({href:time_url,iframe:true,innerWidth:950,innerHeight:900});
	} else {
		jAlert('Please Select a Reservation Time', 'Alert Box');
		return false;
	}
}
function set_reservationTime(){
	jQuery(".jcarousel-skin-tangos li a").click(function(){
		jQuery(".jcarousel-skin-tangos li a").attr("id","");;
		this.id="time_act";
	});
}
function pass_party(value,detail_url){
	$.ajax({
		type:'POST',
		url:detail_url,
		data:'id='+value,
		success:function(responseText){
			$('#contentcontainer').html(responseText);
			$('.imagepic').cycle({
				fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				pager:'#slidenavv'
			});
			cufon();
		}
	});
}

function select_reservation(value,time_url,id,time){
	//var timers = jQuery("#"+value +" #time_active").text();
	reservation_time = time.split(' ')[0];
	ampm=time.split(' ')[1];
	var partysize = document.getElementById('selectparty_'+id).value;
	if(time != ""){
		time_url = time_url+'?party='+partysize+'&rest_id='+id+'&time='+reservation_time+'&ampm='+ampm;
		//alert(time_url);
		$.colorbox({href:time_url,iframe:true,innerWidth:950,innerHeight:900,scrolling:false});
	} else {
		jAlert('Please Select a Reservation Time', 'Alert Box');
		return false;
	}
} 

function select_reservation_widget(value,time_url,id,time){
	//var timers = jQuery("#"+value +" #time_active").text();
	reservation_time = time.split(' ')[0];
	ampm=time.split(' ')[1];
	var partysize = document.getElementById('selectparty_'+id).value;
	if(time != ""){
		time_url = time_url+'?party='+partysize+'&rest_id='+id+'&time='+reservation_time+'&ampm='+ampm;
		//alert(time_url);
		window.open(
		  time_url,
		  '_blank' // <- This is what makes it open in a new window.
		);
		//$.colorbox({href:time_url,iframe:true,innerWidth:470,innerHeight:570});
	} else {
		jAlert('Please Select a Reservation Time', 'Alert Box');
		return false;
	}
}

function select_reservation_det(value,time_url,id,time,party){
	//var timers = jQuery("#"+value +" #time_active").text();
	reservation_time = time.split(' ')[0];
	ampm=time.split(' ')[1];
	var partysize = party;
	if(time != ""){
		time_url = time_url+'?party='+partysize+'&rest_id='+id+'&time='+reservation_time+'&ampm='+ampm;
		//alert(time_url);
		$.colorbox({href:time_url,iframe:true,innerWidth:950,innerHeight:900});
	} else {
		jAlert('Please Select a Reservation Time', 'Alert Box');
		return false;
	}
}

function auto_complete(data) { 
jQuery("#response_result").show();
var url="/homes/auto_complete";
$.ajax({
   type: "POST",
   url: url,
   data: "string="+data,
   success: function(response){ 
   				responseText = response.split('*'); 
				var length = responseText.length-1;
				var valueR = '';
				for(i=0; i < length; i++)
				 valueR = valueR +'<span style=" margin-left:10px;"><a href="javascript:void(0);" style="text-decoration:none; color:#000000; font-family:helvetica;">'+responseText[i]+'</a></span>'+'</br>';
				jQuery("#auto_complete_response").html(valueR);
				auto_complete_selected();
			}
}); 
}

function auto_complete_selected() {
	 jQuery("#auto_complete_response a").click(function(){
	 	jQuery("#HomeSearch").val($(this).html());
	 	jQuery("#response_result").hide();
	 });
}

function cufon(){
		Cufon.replace('.fb_sign',{ fontFamily: 'diavlo light' });
		Cufon.replace('.text1',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.text2',{ fontFamily: 'diavlo light' });
		Cufon.replace('.menu_list ul li a',{ fontFamily: 'diavlo light' });
		Cufon.replace('.greenhead',{ fontFamily: 'diavlo bold' });
		/*Cufon.replace('.product-name',{ fontFamily: 'diavlo bold' });*/
		Cufon.replace('.left_draft',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.dealtext1',{ fontFamily: 'diavlo light' });
		Cufon.replace('.restarunt_header .resheadname',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.dealtext2',{ fontFamily: 'diavlo light' });
		/*Cufon.replace('.resname',{ fontFamily: 'diavlo light' });*/
		/*Cufon.replace('.tabletitle',{ fontFamily: 'diavlo light' });*/
		Cufon.replace('.bordersearch',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.number',{ fontFamily: 'bebas' });
		Cufon.replace('#numbers1',{ fontFamily: 'bebas' });
		Cufon.replace('.expires',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.greendol',{ fontFamily: 'diavlo light' });
		Cufon.replace('.greendol1',{ fontFamily: 'diavlo light' });
		Cufon.replace('.greendollar',{ fontFamily: 'diavlo bold' });
		/*Cufon.replace('.timelist ul li a',{ fontFamily: 'diavlo light' });*/
		Cufon.replace('.my_reservation_cont .leters .your_reserve',{ fontFamily: 'diavalo-book' });
		Cufon.replace('.my_reservation_cont .leters .paris #pclub',{ fontFamily: 'diavalo-book' });
		Cufon.replace('#title',{ fontFamily: 'diavalo-book' });
		Cufon.replace('.profile_area h2',{ fontFamily: 'diavalo-book' });
		Cufon.replace('.mytext',{ fontFamily: 'diavalo-book' });
		/*Cufon.replace('.prodcut_details span',{ fontFamily: 'diavalo-book' });
		Cufon.replace('.prodcut_time_details li a',{ fontFamily: 'diavlo light' });
		Cufon.replace('.chnge',{ color: '#FFFFFF' });
		Cufon.replace('.chnge',{ fontSize: '12px' });
		Cufon.replace('.resname',{ fontSize: '16px' });*/
		/*Cufon.replace('.reshname',{ fontSize: '18px' , fontFamily: 'diavlo'});*/
		Cufon.replace('.reshname',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.res_nam',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.rest_name',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.reshname_bot',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.h_hed',{ fontFamily: 'diavlo bold' });
		Cufon.replace('.emty',{ fontFamily: 'diavlo bold' });
}
/*************************************************** Home Page ***********************************************************/

/* Select search by Shiva */
var xhr;
function search_restaurant(id,url){
	 get_searchdata(url);
	
}
function pagination(){
	 jQuery('#paginationsearch .prev,#paginationsearch .next').click(function(){
        var url  =  this.href; 
        get_searchdata(url);
        return false;
    }); 
}
function get_searchdata(url){
	
	if(xhr){
           xhr.abort();
    }
	var nid = $('#nid').val();  
	var cid = $('#cid').val();  
	var tid = $('#tid').val();
	var pid = $('#party_id').val();
	
	if(pid=='')
		pid='';
	var post_data = 'neighborhood='+nid+'&cuisine='+cid+'&time_select='+tid+'&party='+pid;	
	xhr=$.ajax({
		   	type:'POST',
			url:url,
			data:post_data,
				success: function(responseText) {
					$('#prodcucontainer').html(responseText);
					 pagination();
					cufon();
					jcarousel();
                    reservation_popup();
					restuarant_link();
				}
		  });
	// return false;
}
var xhr1;
function search_restaurant1(url){
	var nid = $('#nid').val();  
	var cid = $('#cid').val();  
	var tid = $('#tid').val();
	var pid = $('#party_id').val();
	if(xhr1){
           xhr1.abort();
       	}
	if(pid=='')
		pid='';
	 xhr1=$.ajax({
		   	type:'POST',
			url:url,
			data:'neighborhood='+nid+'&cuisine='+cid+'&time_select='+tid+'&party='+pid,
				success: function(responseText) {
					$('#prodcucontainer').html(responseText);
					cufon();
					jcarousel();
				}
		  });
	 return false;
}
function restuarant_link(){
    jQuery('.restuarant_image, .res_name').click(function(){
        var restaurant_link = this.href;
        var restuarant_id = this.rel;
        var party_size = jQuery('#party_'+restuarant_id).html().split('-')[1];
        restaurant_link = restaurant_link+'/'+party_size;
        window.location.href = restaurant_link;
    });
}
/***********************************************Profile page *************************************************************/
function payment_form(val,type){
	if(val==1){
		$('.paymentuser').css('display','block');
		$('#payment_box').val(1);
	}
	else{
		$('.paymentuser').css('display','none');
		$('#payment_box').val('');
	}
}
/************************************************** Profile page **********************************************************/

$(document).ready(function(){	
	$('.color_login').click( function() {
		var myHref = "/users/login/1/home";
		$.colorbox({
			height: 625, 
			width: 630, 
			iframe: true,
			scrolling:false,
			href: myHref 
		});  
		return false;
	});
	
	$('.color_login1').click( function() {
		var myHref = "/users/login/1";
		$.colorbox({
			iframe: true, 	   
			height: 625, 
			width:  630,
			scrolling:false,
			href: myHref 
		});  
		return false;
	});
	
	$('.color_login2').click( function() {
		var myHref = "/users/login/1";
		$.colorbox({
			height: 625, 
			width: 630, 
			iframe: true,
			scrolling:false,
			href: myHref 
		});  
		return false;
	});
});
function reservation_popup(){
    $('.reservation_popup').colorbox({iframe:true,innerWidth:950,innerHeight:900});
}
function no_show_click(resid,url){
	var statusNum=$("#ReservationNoShow").prop('checked');
	$.ajax({
		type:'POST',
		url:url,
		data:'resid='+resid+'&statusNum='+statusNum,
		success: function(responseText) {
			//$('#changedate').html(responseText);
		}
	});
}
/*confirmation for clear all*/
function delete_con(change_url){
	jConfirm('Are you sure you want to delete these offers', 'Confirmation Box',function(r) {
    if(r==true){
		$.ajax({
		type:'POST',
		url:change_url,
		success:function(responseText){
			window.location.reload();
		}	
		});	
	}else{
		return false;
	}
	});
}
function sample(change_url){
	jConfirm('By doing this, you will be clearing out all future recurring tables as well', 'Confirmation Box',function(r) {
    if(r==true){
		$.ajax({
		type:'POST',
		url:change_url,
		beforeSend:function(){ 
			var height = $(document).height();
			$('#gif').height(height);
		  	$("#gif").css("display", "block");
		},
		success:function(responseText){
			//alert(responseText);
			//$('#inner_table').html(responseText);
			$('#changedate').html(responseText);
			$('.date-pick').datePicker();
			//vtip();
			$("#gif").css("display", "none");
		}	
	});	
	}else{
		return false;
	}
	});
}

