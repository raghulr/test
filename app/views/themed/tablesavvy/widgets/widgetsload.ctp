<script type="text/javascript">
$(document).ready(function(){
$('#Logdate').change(function(){
var logdate=$('#Logdate').val();
$('#AlertLogdate').val(logdate);
$('#AlertWidgetsloadForm').submit();
});
});
</script>
<style>
.dp-choose-date{
float:left!important;
}
input {
    margin: 1px;
    width: 74px;
}
.hide_input{
opacity:0;
}
.checkbox {
    float: left;
    margin: 18px 0 0 40px;
    width: 410px;
}
#rest_no {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 110px;
}

#rest_no_user1 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    line-height: 43px;
    text-align: center;
    width: 144px;
}
#rest_no_user4 {
    float: left;
    height: 100%;
    width: 75px;
}
#rest_no_user {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 234px;
}
#rest_no_user2 {
    border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 128px;
	line-height: 45px;
	text-align:center;
}
#rest_no_user3 {
  	border-right: 2px ridge #FFFFFF;
    float: left;
    height: 100%;
    width: 98px;
}
.sear_rest {
    float: left;
    height: 22px;
    margin: 0px 0 5px 18px;
    width: 145px;
}
.submit{
	float: left;
	margin: 0px 0 5px 8px;
}
.container_cont .navi_content {
	min-height: 450px;
}
.checkbox {
	width: 372px;
}
.user_credit {
  float:left;
  height:16px;
  margin:0 0 5px 18px;
  width:40px;
}

.Uers_pro {
    float: left;
    height: auto;
    margin: 10px 0 10px 10px;
    width: 330px;
}
#neigh_name2 {
	margin: 5px 0 0 0px;
	text-align: center;
	width:100%;
}
.res_tabl {
    float: left;
    margin: 10px 0 0 18px;
    height:auto;
    width: 866px;
}
.user_head{
    width: 100%;
    float: left
}
.user_left{
    width: 34%;
    float: left
}
.user_right{
    width: 65%;
    float: right;
    padding-top: 0px;
}
.user_right label{
    float: left;
    width: 50%;
    font-size: 14px;
}
input.dp-applied {
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    float: left;
    margin-left: 5px;
    width: 72px;
}
</style>
<div id="credit_message"></div>
<div id="changedate">
   
    <div class="navi_content" id="change">
    
        <div class="res_tabl">            
            <div class="user_head">  
          
            </div>
            
             <div class="social-overview-map" style=' clear: both;padding: 16px 0 33px;'>  
            <div class="recurringdata" style="margin:-8px 50px;float:right;">
                <?php 
                    echo $form->create();?>
                <input type="text" id="Logdate" disabled='disabled' class="date-pick dp-applied" value=<?php echo $logdate;?>>
                <?php echo $form->input('logdate',array('type'=>'text', 'class'=>'hide_input','value'=>$logdate,'label'=>false));  
                    echo $form->end();?>
            </div>          
            <div id="container" style="width: 800px; height: 363px;margin:30px 0px 0px 7px;"></div>
            <div class="spacer"></div>
        </div>
        </div> 
        
    
    
    </div>  
    
      <?php echo $form->end(); ?>   
    <div class="navi_botom"></div> 	
</div>
