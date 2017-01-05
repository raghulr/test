<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TableSavvy</title>
</head>

<body>
    <table cellpadding="0" cellspacing="0" border="0" width="540" style="width: 620px;background-color: #FFF;padding: 0 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td align="center" valign="middle" height="95" class="logo"><img src="<?php echo Configure::read('website.logo');?>" alt="logo"/></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" height="50" style="text-align: center;background: #000;font-family: Verdana;font-size: 17px;color: #FFF;">
                                Reserve a Table for $5 and Save 30%!!!
                        </td>
                    </tr>
                    <tr>
						<td align="left" valign="middle" height="50" style="text-align: center;font-family: Verdana;font-size: 17px;color: #00a5a3;">
						Available tables today</td>
					  </tr>
                    
                    <tr>
                        <td align="left" valign="middle" style="border: 1px solid #c6c6c6;padding: 0px;font-family: Verdana;font-size: 15px;color: #000000;">
                               <h2 style="color:#000000;font-weight:normal;font-size:12px;"><table style="margin:40px 40px 0px 40px;width: 640px; background-color:#FFFFFF;">

  <tr>
    <td ><table width="100%" cellpadding="0" cellspacing="0">
      <tbody>
          <td>
            <table width="638" border="0" style=" font-family:Arial; font-size:10px;">
              <?php 
              $j=0;
              $result=0;
			 // pr($alert_mail);
			 //	if(!empty($alert_mail))
//				{
                  foreach($alert_mail as $result1){
					  if($result!=$result1['id']||$j==0){
					  ?>
					  <tr style="font-family:Arial; font-size:25px; color:#015472;">
						<td width="201">&nbsp;                    </td>
						<td width="184" align="center"><?php echo $result1['name'];?></td>
						<td width="239">&nbsp;</td>
					  </tr>					  
					  <?php
					  } 
					  ?>
					  <tr>
						  <td>&nbsp;
						  </td>
						  <td>&nbsp;
						  </td>
						  <td>&nbsp;
						  </td>
					  </tr>
					  
					  <tr style="font-family:Arial; font-size:19px; color:#545454; background-color:#f7f2f2;">
							<td align="center" width="201" height="60"><?php echo $result1['time_am'];
						?></td>
						<td align="center" width="184"><?php echo $result1['seat'].' '.'People';?></td>
						<td align="center">
						<a href="<?php echo Router::url('/', true).'details/'.$result1['id'].'/'.$result1['seat'];?>"><img src="<?php echo Router::url('/', true);?>/images/alert_reserve.png" alt="logo"/></a>
						</td>
					  </tr>
					  <?php 
					  $j++;
					  $result = $result1['id'];?> 
					
                <tr style="font-family:Arial; ">
                      <td>
                        <a style="font-size:16px; color:#00a5a3;" href="<?php echo Router::url('/', true).'details/'.$result1['id'].'/'.$result1['seat'];?>">click to the site to see more</a>
                      </td>
				</tr>
                                           
				<?php }?>
                <tr style="font-family:Arial; font-size:16px;">
						  <td>&nbsp;
						  </td>
						  <td>&nbsp;
						  </td>
						  <td>
                          	<a href="<?php echo Router::url('/alerts/subscribe_email/'.$rand_string, true); ?>">Change Alert Settings</a>
						  </td>
					  </tr>
            </table>
          </td>
        </tr>
<!--        <tr>
        <td><br /><p style="color: rgb(9, 129, 190); font-size:12px; margin:0 0 0 0px; font-family:Arial;"><a href="##Unsubscribe_email##">Unsubscribe from <?php //echo Configure::read('website.name');?></a></p></td>
        </tr>-->
      </tbody>
    </table></h2></td></tr>
</table></h2>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding-top: 20px;font-family: Verdana;font-size: 15px;color: #000000;">
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;">Thanks,</p>
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;">The <?php echo Configure::read('website.name');?> Team</p>
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;"><a href="<?php echo Router::url('/', true); ?>"><?php echo Configure::read('website.name');?></a></p>
                            <div class="social_icon" style="float: left;padding: 5px 2px;">
                                <a href="https://itunes.apple.com/us/app/tablesavvy/id845047265?ls=1&mt=8" style="float: left"><img src=" https://www.tablesavvy.com/theme/tablesavvy/images/ts_app_download.png"/></a>
                            </div>    
                            <div class="social_icon" style="float: left;padding: 5px 2px;">
                                <a href="https://play.google.com/store/apps/details?id=com.food.tablesavvy" style="float: left"><img src=" https://www.tablesavvy.com/theme/tablesavvy/images/ts_droid_app_download.png"/></a>
                            </div>   
                            <div class="social_icon" style="width: 10%;float: left;padding: 5px 2px;">
                                <a href="https://www.facebook.com/TableSavvy" style="float: left"><img src="https://www.tablesavvy.com/theme/tablesavvy/images/sn-fb-new_03.png"/></a>
                                <a href="http://twitter.com/#!/TableSavvy" style="float: right"><img width="35" height="35" src="https://www.tablesavvy.com/theme/tablesavvy/images/sn-twt-new_03.png"/></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" height="20">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" height="60" style="border-top: 1px solid #c6c6c6;border-bottom: 1px solid #c6c6c6;font-family: Verdana;font-size: 15px;color: #000000;">
                            Add <a href="mailto:support@tablesavvy.com" style="color: #949494;">support@tablesavvy.com</a> to your address book or safe sender list  so our emails make it to your inbox.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" height="60" style="font-family: Verdana;font-size: 15px;color: #27a8ea;">
                            Copyright 2013. <?php echo Configure::read('website.name');?> All Rights reserved
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
