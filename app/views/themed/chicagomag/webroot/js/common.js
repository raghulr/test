var ajaxRequest = '';
jQuery(document).ready(function(){
    filter_onchange();      // Function for select the restuarnt based on selected filters
    restuarant_link();      // Set the reservation link with selected party size
    reservation_popup();    // Open the reservation popup in colorbox
    //jQuery('.btn-small, .btns-small,.btn-small-new, .btns-invite, .btn-location').colorbox({iframe:true,innerWidth:640,innerHeight:465});
    //jQuery('.btn-map').colorbox({iframe:true,innerWidth:640,innerHeight:325});
    paginationsearch();
    funcall();
    change_party_size();
    auto_complete();
});
function filter_onchange(){
    var post_data = '';
    jQuery('#neighborhood_id, #cuisine_id, #time_id, #party_id').change(function(){        
        var url                = jQuery('#search_url').html(); 
        get_searchdata(url);
        
    });        
}
function paginationsearch(){
    jQuery('#paginationsearch a.prev, #paginationsearch a.next').click(function(){
        var url               = this.href;
        get_searchdata(url);
        return false;
    });    
}
function get_searchdata(url){
    var neighborhood_id    = jQuery('#neighborhood_id').val();
    var cuisine_id         = jQuery('#cuisine_id').val();
    var time_id            = jQuery('#time_id').val();
    var party_id           = jQuery('#party_id').val();
    var post_data = 'neighborhood='+neighborhood_id+'&cuisine='+cuisine_id+'&time_select='+time_id+'&party='+party_id;
    if(ajaxRequest)
       ajaxRequest.abort();
    ajaxRequest = jQuery.ajax({
        type:'POST',
        url: url,
        data: post_data,
        success: function(responseText) {
            jQuery('#select_search').html(responseText);
            reservation_popup();
            restuarant_link();
            paginationsearch();
            home_scroll();
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
    jQuery('#change_party_size').change(function(){
        var party_size = this.value;
        var sizeUrl = jQuery('#hide').html();
        $.ajax({
            type:'POST',
            url:sizeUrl,
            data:'partysize='+party_size,
            success: function(responseText) {
                jQuery('#change_size').html(responseText);
                if(responseText.indexOf('reservations') == -1){
                    reservation_popup();
                    reservation_size_scroll();
                }
            }
        })
    });
}
function reservation_popup(){
    //jQuery('.reservation_popup').colorbox({iframe:true,innerWidth:950,innerHeight:900});
    return true;
}
function reservation_size_scroll(){
    jQuery('.jcarousel-skin-tango').jcarousel();
}
function reservation_scroll(){
    jQuery('.jcarousel-skin-tangos1').jcarousel({
        start: 1
    });
}
function home_scroll(){
    jQuery('.jcarousel-skin-tango-home').jcarousel();
}
function funcall(){
	/*$('#successMessage').click(function(){
		$(this).remove();
	});*/
	$('#successMessage').fadeOut(4000);
  	/*$("#errorMessage").click(function(){
		$(this).remove();
	});*/
	$('#errorMessage').fadeOut(4000);
	/*$("#error1Message").click(function(){
		$(this).remove();
	});*/
	$('#error1Message').fadeOut(4000);
}
function reservation_details_scroll(){
    jQuery("#mycarousel").jcarousel({	
        scroll:1
    });
}
function change_reservation(url){
    jConfirm('Are you sure you want to change this reservation?', 'Confirmation Box',function(r) {
        if(r==true){
            window.location.href=url;
            //jQuery.colorbox({href:url,iframe:true,innerWidth:640,innerHeight:450});
        }else{
            return false;
        }
    });
    return false;
}
function cancel_reservation(change_url,red_url,size,cus_size){
    jConfirm('Are you sure you want to cancel this reservation?', 'Confirmation Box',function(r) {
        if(r==true){
            $.ajax({
                type:'POST',
                url:change_url,
                data:'size='+size+'cus_size='+cus_size,
                success: function(responseText) {
                    jQuery('#messages').html(responseText);
                    funcall();    
                    window.location.href=red_url;
					//window.location.reload();
                }
            })
        }else{
            return false;
        }
    });
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
		$('.payment_show').show();
		check_val=1;
	}else{
		$('#payment_box').val('');
		$('.payment_show').hide();
		check_val = 2;
	}
	if($('#check_position_css').hasClass('new_set')){
		if($('#check_position_css').hasClass('postion_class') && check_val!=2){
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
    jQuery('#HomeSearch').keyup(function(){
        var url = jQuery('#auto_complete_url').html();
        var name = this.value;
		if(xhr){
           xhr.abort();
       	}
        xhr=$.ajax({
            type: "POST",
            url: url,
            data: "string="+name,
            success: function(response){ 
            responseText = response.split('*'); 
                var length = responseText.length-1;
                var valueR = '';
                for(i=0; i < length; i++)
                    valueR = valueR +'<a>'+responseText[i].trim(" ")+'</a>';
                jQuery("#auto_complete_response").html(valueR);
				if(valueR==''){
					jQuery("#auto_complete_response").css({border:'none'});
				}else{
					jQuery("#auto_complete_response").css({border:'1px solid #CCCCCC'});
					
				}
                jQuery("#auto_complete_response").show();
                auto_complete_selected();
            }
        }); 
    });
}

function auto_complete_selected() {
    jQuery("#auto_complete_response a").click(function(){
        jQuery("#HomeSearch").val($(this).html());
        jQuery("#auto_complete_response").hide();
    });
}