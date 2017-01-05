var ajaxRequest = '';
//For adding restaurants on scroll
var scrollAjaxCalled = null;
var page_url = '';
var tempurl='';
///////////////////
function noBack(url) {
    window.onload = function () {
        if (typeof history.pushState === "function") {
            history.pushState("jibberish", null, null);
            window.onpopstate = function () {
                history.pushState('newjibberish', null, null);
            //window.location.replace(url);
            };
        }
        else {
            var ignoreHashChange = true;
            window.onhashchange = function () {
                if (!ignoreHashChange) {
                    ignoreHashChange = true;
                    window.location.hash = Math.random();
                }
                else {
                    ignoreHashChange = false;
                }
            };
        }
    }
}
function locationHashChanged() {
    if(prevHash == '#reserved')
        window.location.href = "chicagomag";
    alert(prevHash);
    prevHash= location.hash;
}
//window.onhashchange = locationHashChanged;
var prevHash = '';
jQuery(document).ready(function(){
    $('#neighborhood_id').prop('selectedIndex',0);
    $('#cuisine_id').prop('selectedIndex',0);
    $('#time_id').prop('selectedIndex',0);
    $('#party_id').prop('selectedIndex',0);
    reservation_popup();
    filter_onchange();      // Function for select the restuarnt based on selected filters
    restuarant_link();      // Set the reservation link with selected party size
    reservation_popup();    // Open the reservation popup in colorbox
    //jQuery('.btn-small, .btns-small,.btn-small-new, .btns-invite, .btn-location').colorbox({iframe:true,innerWidth:640,innerHeight:465});
    //jQuery('.btn-map').colorbox({iframe:true,innerWidth:640,innerHeight:325});
    paginationsearch();
    pagination_search();
    funcall();
    change_party_size();
    auto_complete();
    ajaxAutocompletes('s');
    $('#curr_url').val('home');
});
function filter_onchange(){
    var post_data = '';
    jQuery('#neighborhood_id, #cuisine_id, #time_id, #party_id').change(function(){
        var url = jQuery('#search_url').html();
        var neighborhood_id    = jQuery('#neighborhood_id').val();
        var cuisine_id         = jQuery('#cuisine_id').val();
        var time_id            = jQuery('#time_id').val();
        var party_id           = jQuery('#party_id').val();
        var searchrest_id      = jQuery('#HomeSearch').val();
        if(neighborhood_id==''&&cuisine_id==''&&time_id==''&&party_id==''&&searchrest_id==''){
            get_homepagedata();
        }else{
            get_searchdata('/homes/select_search');
        }
    });
}
function paginationsearch(){
    jQuery('#paginationsearch a.prev, #paginationsearch a.next').click(function(){
        var url = this.href;
        get_searchdata(url);
        return false;
    });
}

function get_homepagedata(){
    var search_paginate_url = jQuery('#home_page_url').html();
    jQuery('#paginate_url').html(search_paginate_url);
    if(ajaxRequest)
        ajaxRequest.abort();
    ajaxRequest = jQuery.ajax({
        type:'POST',
        url: search_paginate_url,
        success: function(responseText) {
            jQuery('#select_search').html(responseText);
            $("#browse1").css("display", "block");
            //$("#browse").toggleClass('browse1 browse');
            $(".product").css("minHeight", 0);
            $(".product").css("height", 100);
            $(".party_size").css("display", "none");
            $(".prodcut_time_details").css("display", "none");
            $("#browse2").hide();
            $("#browse").css("display", "block");
            $(".browse").css("display", "block");
            reservation_popup();
            restuarant_link();
            paginationsearch();
            home_scroll();
            loadMoreRes();
        }
    });
}

function get_searchdata(url){
    // add loader
    var $loading           = $('.ui.loading.dimmer').addClass('active');

    var neighborhood_id    = jQuery('#neighborhood_id').val();
    var cuisine_id         = jQuery('#cuisine_id').val();
    var time_id            = jQuery('#time_id').val();
    var party_id           = jQuery('#party_id').val();
    // var searchrest_id      = jQuery('#HomeSearch').val();
    var post_data = 'neighborhood='+neighborhood_id+'&cuisine='+cuisine_id+'&time_select='+time_id+'&party='+party_id;
    var search_paginate_url=jQuery('#select_serach_url').html();
    jQuery('#paginate_url').html(search_paginate_url);
    page_url='';
    $('#curr_url').val('select_search');
    tempurl = '/homes/select_search';
    $('#page_url_hidden').val('');
    if(ajaxRequest)
        ajaxRequest.abort();
    ajaxRequest = jQuery.ajax({
        type:'POST',
        url: url,
        /*	beforeSend:function(){
			var height = $(document).height();
			$('#gif').height(450);
			$('#gif').width(980);
		  	$("#gif").css("display", "block");
		},*/
        data: post_data,
        success: function(responseText) {
            $loading.removeClass('active');
            // note: removed &&searchrest_id==''
            if(neighborhood_id==''&&cuisine_id==''&&time_id==''&&party_id==''){
                jQuery('#rest_search').html(responseText);
                $("#browse1").css("display", "block");
                //$("#browse").toggleClass('browse1 browse');
                $(".product").css("minHeight", 0);
                $(".product").css("height", 100);
                $(".party_size").css("display", "none");
                $(".prodcut_time_details").css("display", "none");
                $("#browse2").hide();
                $("#browse").css("display", "block");
                $(".browse").css("display", "block");
            //window.location.reload();
            }else{
                $('#rest_search').html(responseText);
                $("#browse1").css("display", "none");
                $("#browse").css("display", "none");
                $(".browse").css("display", "none");
                //$(".home_title").css("padding-bottom", 10);
                $("#browse2").show();
            //$("#browse").attr('class' , 'browse1');
            }
            reservation_popup();
            restuarant_link();
            paginationsearch();
            home_scroll();
            loadMoreRes();
        }
    });
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
function change_party_size(){
    var $timeAvail = jQuery('#timeAvailability');
    jQuery('#change_party_size').change(function(){
        $dimmer = $(this).parents('.ui.segment').find('.ui.dimmer');
        $dimmer.addClass('active');
        var party_size = this.value;
        var sizeUrl = $(this).data('url');
        $.ajax({
            type:'POST',
            url:sizeUrl,
            data:'partysize='+party_size,
            success: function(responseText) {
                $dimmer.removeClass('active');
                var res = JSON.parse(responseText);
                var html = res.html;
                $timeAvail.html(html); 
                // hacky, but check for error
                if(res.error){
                  $timeAvail.addClass('full');
                  $timeAvail.next('.field').hide();
                } else {
                  $timeAvail.removeClass('full');
                  $timeAvail.next('.field').show();
                }
                reservation_popup();
                reservation_size_scroll();
            //}
            }
        })
    });
    $('.restaurant_time').change(function() {
      var ampm = $(this).find(':selected').html();
      ampm = ampm.slice(-2);
      $('#ampm').val(ampm);
    });
}
function reservation_popup(){
    //jQuery('.reservation_popup').colorbox({iframe:true,innerWidth:950,innerHeight:900});
    return true;
}
function reservation_size_scroll(){
    // jQuery('.jcarousel-skin-tango').jcarousel();
}
function reservation_scroll(){
    // jQuery('.jcarousel-skin-tangos1').jcarousel({
    //     start: 1
    // });
}
function home_scroll(){
    var url=window.location.pathname;
    if(url=='/all_restaurant'){
        $("#browse1").css("display", "block");
        $(".home_title").css("padding-bottom", 36);
    }
    // jQuery('.jcarousel-skin-tango-home').jcarousel({
    //     start: 1
    // });
}
function searchhome_scroll(res){
    var value=$('#auto_ser').val();
    var n=res.split('*');
    if(n[1]=='name'){
        window.location.href=value+'/'+n[2];
    //alert(n[1]);
    }
    var url=window.location.pathname;
    $("#browse1").css("display", "none");
    $("#browse").css("display", "none");
    $(".browse").css("display", "none");
    if(url=='/all_restaurant'){
        $("#browse1").css("display", "block");
        $(".home_title").css("padding-bottom", 26);
    }
    $("#browse2").show();
    jQuery('#select_search').html();
    jQuery('#select_search').html(res);
    pagination_search();
    // jQuery('.jcarousel-skin-tango-home').jcarousel({
    //     start: 1
    // });
}
function pagination_search(){
    jQuery('#paginationsearch a.prev, #paginationsearch a.next').click(function(){
        var url = this.href;
        get_searchdata(url);
        return false;
    });
}
function funcall(){
    /*$('#successMessage').click(function(){
		$(this).remove();
	});*/
    $('#successMessage').parent().delay(5000).fadeOut(1000);
    /*$("#errorMessage").click(function(){
		$(this).remove();
	});*/
    $('#errorMessage').parent().delay(5000).fadeOut(1000);
    /*$("#error1Message").click(function(){
		$(this).remove();
	});*/
    $('#error1Message').parent().delay(5000).fadeOut(1000);
}
function reservation_details_scroll(){
    // jQuery("#mycarousel").jcarousel({
    //     scroll:1
    // });
}
function change_reservation(url){
    /*jConfirm('Are you sure you want to change this reservation?', 'Confirmation Box',function(r) {
        if(r==true){
            window.location.href=url;
            //jQuery.colorbox({href:url,iframe:true,innerWidth:640,innerHeight:450});
        }else{
            return false;
        }
    });*/
    window.location.href=url;
//return false;
}
function cancel_reservation(change_url,red_url,size,cus_size){
//    jConfirm('Are you sure you want to cancel this reservation?', 'Confirmation Box',function(r) {
    var r = confirm('Are you sure you want to cancel this reservation?');
        if(r==true){
            $.ajax({
                type:'POST',
                url:change_url,
                data:'size='+size+'cus_size='+cus_size,
                success: function(responseText) {
                    //alert(responseText);
                    jQuery('#messages').html(responseText);
                    funcall();
                    window.location.href=red_url;
                //window.location.reload();
                }
            })
        }else{
            return false;
        }
//    });
    return false;
}
function validate(email) {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    return reg.test(email);
}
function trim(str){
    var str = str.replace(/^\s\s*/,''),
    ws = /\s/,
    i = str.length;
    while (ws.test(str.charAt(--i)));
    return str.slice(0, i + 1);
}
function checkAll(){
    var i = 0;
    var emails = document.getElementById('mail').value.split(",");
    for(i=0; i<emails.length; i++){
        if(!validate(trim(emails[i]))){
            alert("Please Enter Valid Email: "+emails[i]);
            return false;
            break;
        }
    }
    return true;
}
function view_payment_form(){
    var value=$('#payment_box').val();
    var check_val='';
    if(value==''){
        $('#payment_box').val(1);
        $('.payment_show1').show();
        $('#update1').val(1);
        check_val=1;
    //$('.reservation-wrapper').css("padding-bottom", parseInt(20));
    }else{
        $('#payment_box').val('');
        $('.payment_show1').hide();
        check_val = 2;
        $('#update1').val(0);

    //$('.reservation-wrapper').css("padding-bottom", parseInt(124));
    }
    if($('#check_position_css').hasClass('new_set')){
        if($('#check_position_css').hasClass('postion_class') && check_val!=2 ){
            $('#check_position_css').removeClass('postion_class');
        }else{
            $('#check_position_css').addClass('postion_class');
        }
    }

}
function showalert(classname){
    jQuery('.'+classname).show();
}
function hidealert(classname){
    jQuery('.'+classname).hide();
}
function delete_alert(change_url){
    jConfirm('Are you sure you want to delete this alert?', 'Confirmation Box',function(r) {
        if(r==true){
            jQuery.ajax({
                type:'POST',
                url:change_url,
                success: function(responseText) {
                    $('#post').html(responseText);
                    funcall();
                }
            })
        }else{
            return false;
        }
    });
}
function change_day(change_day_url){
    var check=document.getElementById('check').checked;
    var checkid = 1;
    if(check==true)
        checkid=0;
    $.ajax({
        type:'POST',
        url:change_day_url,
        data:'id='+checkid,
        success: function(responseText) {
            $('#post').html(responseText);
            funcall();
        }
    })
}
var xhr;
function auto_complete() {
    flushCache();
    jQuery('#HomeSearch').keyup(function(e){
        if(e.which == 13){
            res_name();
        }else{
            var name = trim(this.value);
            ajaxAutocompletes(name);
        }
    });
}
function ajaxAutocompletes(name){
    var url = jQuery('#auto_complete_url').html();
    if($("#auto_complete_url").length > 0){
        if(xhr){
            xhr.abort();
        }
        xhr=$.ajax({
            type: "POST",
            url: url,
            data: "string="+name,
            success: function(response){
                var availableTags = $.parseJSON(response);
                jQuery("#HomeSearch").autocomplete({
                    source: availableTags,
                    minChars:1,
                    matchSubset:1,
                    matchContains:1,
                    cacheLength:10,
                    autoFill:true
                });
                auto_complete_selected();
                flushCache();
            }
        });
    }
}
function flushCache(){
    cache = {};
    cache.data = {};
    cache.length = 0;
};
function res_name(){
    var red_url = jQuery('#res_url').html();
    var search_paginate_url=jQuery('#serach_url').html();
    jQuery('#paginate_url').html(search_paginate_url);
    page_url='';
    $('#curr_url').val('search');
    $('#page_url_hidden').val('');
    var auto_text = encodeURIComponent(jQuery('#HomeSearch').val());
    $.ajax({
        type:'POST',
        url:red_url,
        data: "auto_text="+auto_text,
        success: function(responseText) {
            searchhome_scroll(responseText);
            loadMoreRes();
        }
    });
}
function auto_complete_selected() {

    jQuery(".ui-menu-item a").click(function(){
        var name = $(this).html();
        jQuery("#HomeSearch").val($(this).html());
        var red_url = jQuery('#auto_red_url').html();
        var url = jQuery('#auto_comp_res_url').html();
        var change_day_url = url+'/'+name;
        $.ajax({
            type:'POST',
            url:change_day_url,
            success: function(responseText) {
                window.location.href=red_url+'/'+responseText;
            //funcall();
            }
        })
        jQuery("#auto_complete_response").hide();
    });
    auto_complete();
}

function checkAll(){
    var pass = document.getElementById('pass').value;
    var cpass = document.getElementById('cpass').value;
    if(pass==cpass){
        document.forms["register_submit"].submit();
        return true;

    }else{
        alert('Password and Confirm Password must be same')
        return false;
    }
}
function paymenttype(val){
    if(val==''){
        document.getElementById('payment-form-head1').style.display = 'none';

    }else{
        document.getElementById('payment-form-head1').style.display = 'block';
    }
}
jQuery(document).ready(function() {
//    console.log(jQuery(document).scrollTop());
    loadMoreRes();
});
function loadMoreRes(){
    if($(document).height()<=$(window).height()+20){
        if(jQuery('#pages_next').val()==0){
            return false;
        }else{
            if (page_url == '')
                page_url = jQuery('#paginate_url').html() + ':2';
            loadPage(page_url);
        }
    }
}
function loadPage(url) {
    var curr_url=$('#curr_url').val();
     var neighborhood_id    = jQuery('#neighborhood_id').val();
    var cuisine_id         = jQuery('#cuisine_id').val();
    var time_id            = jQuery('#time_id').val();
    var party_id           = jQuery('#party_id').val();
    var searchrest_id      = jQuery('#HomeSearch').val();
//For restaurant search by name
    var auto_text = encodeURIComponent(jQuery('#HomeSearch').val());
    if(auto_text!=''&&curr_url=='search')
        data='scroll=autoscroll&auto_text='+auto_text;
    else if(curr_url=='select_search')
         data = 'scroll=autoscroll&neighborhood='+neighborhood_id+'&cuisine='+cuisine_id+'&time_select='+time_id+'&party='+party_id;
    else
         data='scroll=autoscroll';
    if(url==tempurl){
        return false;
    }
    if (url == '1' || url == '')
        return false;
    scrollAjaxCalled = jQuery.ajax({
        type: 'POST',
        url: url,
        cache: false,
        data:data,
        dataType: "html",
        beforeSend: function() {
            if (scrollAjaxCalled != null)
                scrollAjaxCalled.abort();
        },
        success: function(response) {
            $('.more').remove();
            jQuery('.append_data').append(response);
            // jQuery('.jcarousel-skin-tango-home').jcarousel({
            //     start: 1
            // });
            has_disabled = jQuery('.next').first().hasClass('disabled');
            if (has_disabled == false){
                page_url = jQuery('.next').first().attr('href');
            }
            else
                page_url = '1';
            loadMoreRes();
        }
    });
    tempurl=url;
}
jQuery(window).scroll(function() {
    var client_hieght = document.documentElement.clientHeight;
    var scroll_top = jQuery(document).scrollTop()+100;

    var document_hieght = document.body.offsetHeight;   // console.log(document_hieght);
    if (client_hieght + scroll_top >= 700) {
//        console.log(scroll_top);
        if(jQuery('#pages_next').val()==0){
            return false;
        }else{
            if (page_url == '')
                page_url = jQuery('#paginate_url').html() + ':2';
//            console.log('call get next page');
            getNextpage(page_url);
        }
    }
});
function getNextpage(url) {
    var curr_url=$('#curr_url').val();
     var neighborhood_id    = jQuery('#neighborhood_id').val();
    var cuisine_id         = jQuery('#cuisine_id').val();
    var time_id            = jQuery('#time_id').val();
    var party_id           = jQuery('#party_id').val();
    var searchrest_id      = jQuery('#HomeSearch').val();
//For restaurant search by name
    var auto_text = encodeURIComponent(jQuery('#HomeSearch').val());
    if(auto_text!=''&&curr_url=='search')
        data='scroll=autoscroll&auto_text='+auto_text;
    else if(curr_url=='select_search')
         data = 'scroll=autoscroll&neighborhood='+neighborhood_id+'&cuisine='+cuisine_id+'&time_select='+time_id+'&party='+party_id;
    else
         data='scroll=autoscroll';
    if(url==tempurl){
        return false;
    }
    if (url == '1' || url == '')
        return false;

//    console.log('before ajax call');
    scrollAjaxCalled = jQuery.ajax({
        type: 'POST',
        url: url,
        cache: false,
        data:data,
        dataType: "html",
        beforeSend: function() {
            if (scrollAjaxCalled != null)
                scrollAjaxCalled.abort();
        },
        success: function(response) {
            $('.more').remove();
            jQuery('.append_data').append(response);
            if(curr_url=='select_search'&&neighborhood_id==''&&cuisine_id==''&&time_id==''&&party_id==''&&searchrest_id==''){
                $(".prodcut_time_details").css("display", "none");
                $("#browse1").css("display", "block");
                //$("#browse").toggleClass('browse1 browse');
                $(".product").css("minHeight", 0);
                $(".product").css("height", 100);
                $(".party_size").css("display", "none");
                $("#browse2").hide();
                $("#browse").css("display", "block");
                $(".browse").css("display", "block");
            //window.location.reload();
            }
            // jQuery('.jcarousel-skin-tango-home').jcarousel({
            //     start: 1
            // });
            has_disabled = jQuery('.next').first().hasClass('disabled');
            if (has_disabled == false){
                page_url = jQuery('.next').first().attr('href');
            }
            else
                page_url = '1';
        }
    });
    tempurl=url;
}








// AJAX.js
$(document).ready(function($) {
	 funcall();
	 $("#dayweek option[value='Weeks']").hide();
});
function funcall(){
	$('#successMessage').parent().delay(5000).fadeOut(1000);
  	$("#errorMessage").parent().delay(5000).fadeOut(1000);
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



/// Popup.js


function validate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   return reg.test(email);
}
function trim(str){
    var str = str.replace(/^\s\s*/,''),
    ws = /\s/,
    i = str.length;
    while (ws.test(str.charAt(--i)));
    return str.slice(0, i + 1);
}
function checkAll(){
    var i = 0;
    var emails = document.getElementById('mail').value.split(",");
    for(i=0; i<emails.length; i++){
        if(!validate(trim(emails[i]))){			
            alert("Please Enter Valid Email: "+emails[i]);
            return false;
            break;
        }
    }
    document.getElementById('UserSendForm').submit();
    return true;
}
function getpartysize(){
    document.getElementById('UserChangeReservationForm').submit();
}
function save_reservation(){
    document.getElementById('UserSaveOffer').value=2;
    getpartysize();
}
//function change_reservation(url){
//	parent.window.location = url;
//}
function changeTab(value){
	if(value=='login'){
		$('#log_in').addClass('active-reg');
		$('#sign_up').removeClass('active-reg');
		$('.login_grey').css({'display':'block'});
		$('.signup_grey').css({'display':'none'});
		$('#show_button').hide();
	}else{
		$('#sign_up').addClass('active-reg');
		$('#log_in').removeClass('active-reg');
		$('.login_grey').css({'display':'none'});
		$('.signup_grey').css({'display':'block'});
		$('#show_button').show();
	}
}
function new_card(){
 var check = document.getElementsByClassName("agree_check_new")[0].checked;
		    if(check == true){
				$('.payment_R').show();
				$('.box_new').hide();
				$('#agree').attr('checked',false);
				parent.$.colorbox.resize({height:900});
			}
}
function agree_check_new(){
	  var check = document.getElementsByClassName("agree_check_new")[0].checked;
	   if(check == true){
			$('.payment_R').hide();
			$('.box_new').show();
			parent.$.colorbox.resize({height:350});
			//parent.$.colorbox.resize({width:y, height:x});
	   } else {
	   		$('.payment_R').show();
				$('.box_new').hide();
			parent.$.colorbox.resize({height:900});
			//parent.$.colorbox.resize({width:y, height:x});
	   }
}

