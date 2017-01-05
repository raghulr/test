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
                        <td align="center" valign="middle" height="95" class="logo"><img src="##SITE_LOGO##" alt="logo"/></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" height="50" style="text-align: center;background: #000;font-family: Verdana;font-size: 17px;color: #FFF;">
                                Reserve a Table for $5 and Save 30%!!!
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"style="border: 1px solid #c6c6c6;padding: 20px;font-family: Verdana;font-size: 15px;color: #000000;">
                             <table width="638" border="0" style=" font-family:Arial; font-size:10px;">
                                <?php 
                                $j=0;
                                $i=1;
                                            // pr($alert_mail);
                                            //	if(!empty($alert_mail))
                    //				{
                                    foreach($alert_mail as $result1){ 
                                                    if($i==1){
                                                    ?>
                                    <tr style="font-family:Arial; font-size:25px; color:#015472;">
                                        <td width="146">&nbsp;                    </td>
                                        <td width="259" align="center"><?php echo $result1['name'];?></td>
                                        <td width="219">&nbsp;</td>
                                    </tr>
                                    <tr style="font-family:Arial; font-size:16px; color:#00a5a3;">
                                        <td width="146">&nbsp;                    </td>
                                        <td height="24" align="center">
                                        Available tables today</td>
                                        <td width="219">&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>&nbsp;
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                        <td>&nbsp;
                                        </td>
                                    </tr>

                                    <tr style="font-family:Arial; font-size:19px; color:#545454; background-color:#f7f2f2;">
                                            <td align="center" width="146" height="60"><?php echo $result1['time_am'];
                                        //pr($result1);
                                        ?></td>
                                        <td align="center" width="259"><?php echo $result1['seat'].' '.'People';?></td>
                                        <td align="center">
                                        <?php 
                                            echo $html->link($html->image("/images/alert_reserve.png",
                                                array('width'=>172,'height'=>56)),
                                                array('controller'=>'homes','action'=>'details',$result1['id'],$result1['seat']),
                                                array('escape'=>false)); 
                                        ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    $j++;
                                    $i++; 
                                    }
                                                    //}
                    //				else
                    //				{
                    //					
                    //				}?>
                                </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding-top: 20px;font-family: Verdana;font-size: 15px;color: #000000;">
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;">Thanks,</p>
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;">The ##SITE_NAME## Team</p>
                            <p style="margin: 0;padding: 5px 0;width: 100%;float: left;"><a href="http://www.chicagomag.com/">www.##SITE_NAME##.com</a></p>
                            <div class="social_icon" style="width: 100%;float: left;padding: 5px 0;">
                                <a href="##FACEBOOK##" style="float: left">##FACEBOOK##</a>
                                <img src="##SITE_LINK##/images/fb.jpg" style="float: left;padding-left: 10px" alt="facebook"/>
                            </div>
                            <div class="social_icon" style="width: 100%;float: left;padding: 5px 0;">
                                <a href="##TWITTER##" style="float: left">##TWITTER##</a>
                                <img src="##SITE_LINK##/images/tw.jpg" style="float: left;padding-left: 28px" alt="twitter"/>
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
                            Copyright 2012. ##SITE_NAME## All Rights reserved
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
