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
 //var check = document.getElementsByClassName("agree_check_new")[0].checked;
		    if($('.agree_check_new').is(':checked')){
				$('.payment_R').show();
				$('.box_new').hide();
				$('#agree').attr('checked',false);
				$('#remove_space').removeClass("reservation_space");
				
			} else {
	   			$('.payment_R').show();
				$('.box_new').hide();
				$('#remove_space').removeClass("reservation_space");
	   	}
}
function agree_check_new(){
	//  var check = document.getElementsByClassName("agree_check_new")[0].checked;
	   if($('.agree_check_new').is(':checked')){
			$('.payment_R').hide();
			$('.box_new').show();
			$('#remove_space').addClass("reservation_space");
                        window.location.href=$('#reserve_url').val();
			//parent.$.colorbox.resize({width:y, height:x});
	   } else {
	   		$('.payment_R').show();
				$('.box_new').hide();
				$('#remove_space').removeClass("reservation_space");
			
			
			//parent.$.colorbox.resize({width:y, height:x});
	   }
}