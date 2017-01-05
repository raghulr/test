<style>
        @charset "utf-8";

* {margin:0; padding:0; outline: none;}
html, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {margin:0; padding:0; border:0; outline:0; font-size:100%; background:transparent;}
li {list-style:none;}
a, a:hover, a:active, a:focus {outline:none; outline-style:none; outline-width:0;}
img {margin:0; padding:0; outline-style:none; outline-width:0; }

body {margin:0; padding:0; font-family:Arial, Helvetica, sans-serif; color:#003056;}

.spacer {font-size:0; height:0; line-height:0; clear:both;}
.left {margin:0; padding:0; width:auto; height:auto; float:left;}
.right {margin:0; padding:0; width:auto; height:auto; float:right;}

h1 a,h2 a,h3 a,h4 a,h5 a,h6 a,h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover{text-decoration:none;}
hr{background:url('https://www.tablesavvy.com/theme/tablesavvy/images/title-striped-bg.png') repeat-x;border:0;clear:both;height:10px;margin-bottom:30px;}
p{font-family:Arial, Helvetica, sans-serif; color:#808080; font-size:13px; line-height:18px;}


/*----------------- General CSS --------------- */

#wrap{width:640px; margin:0 auto; padding:0 0;}
.wrap-common{margin:0 auto; width:100%;}
.hd-admin{padding:0px; margin:0px; text-align:center; background:url('https://www.tablesavvy.com/theme/tablesavvy/images/hd-bg.png') repeat-x;border:0;clear:both; line-height:54px; font-size:24px;
text-transform:uppercase; color:#595959; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif; font-weight:bold;}
.logo-wrap{text-align:center; padding:28px 0 21px; width:640px; margin:0 auto; position:relative;}
.dash-wrap{width:700px; margin:29px 0 auto 100px;padding:0 0 20px;float:left;}
h2.hd-dash{font-size:20px; color:#fff; text-align:center; line-height:57px; border-left:1px solid #4d4d4d; border-right:1px solid #4d4d4d;
border-top:1px solid #4d4d4d; background:url('https://www.tablesavvy.com/theme/tablesavvy/images/grad.jpg') repeat-x #252525; height:57px; font-weight:normal;
  /* Safari 3-4, iOS 1-3.2, Android 1.6- */
  -webkit-border-top-left-radius: 10px;
  -webkit-border-top-right-radius: 10px;
/* Firefox 1-3.6 */
  -moz-border-radius-topleft: 10px;
  -moz-border-radius-topright: 10px;
/* Opera 10.5, IE 9, Safari 5, Chrome, Firefox 4, iOS 4, Android 2.1+ */
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  
  }
.dash-bottom{background-color:#fff; border:1px solid #b5b5b5; }
.button-login {position:absolute; right:180px; top:23px;}
.button-back{position:absolute; left:180px; top:23px;}
.button{position:absolute; right:22px; top:23px;}
.button a, .button-login a{outline:none; border:1px solid #c6c6c6; background:url('https://www.tablesavvy.com/theme/tablesavvy/images/grad-button.jpg') repeat-x #cdcdcd; 
height:37px; text-decoration:none;text-align:center; padding:0 22px; color:#7f7f7f; line-height:37px; font-size:22px; font-weight:100%; font-weight:normal; display:block;
-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;
  background-color: #cdcdcd;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fcfcfc), to(#cdcdcd));
  background: -webkit-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -moz-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -ms-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -o-linear-gradient(top, #fcfcfc, #cdcdcd);
} 
.button-login a, .button-back a{height:58px; line-height:58px;}
.button-back a{background:url('https://www.tablesavvy.com/theme/tablesavvy/images/button-bck.png') no-repeat 0 0; height:58px; line-height:58px; width:89px; display:block;
text-align:center; color:#7f7f7f; font-size:22px; font-weight:100%; font-weight:normal; display:block; padding:0 0 0 10px; text-decoration:none;}
.button a:hover, .button-login a:hover, .button-back a:hover{
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#cdcdcd), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -moz-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -ms-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -o-linear-gradient(top, #cdcdcd, #fcfcfc);
} 
.button-back a:hover{background:url('https://www.tablesavvy.com/theme/tablesavvy/images/button-bck-hov.png') no-repeat 0 0;}

.dash-bottom div{border-bottom:1px solid #b3b3b3; padding:14px 22px 20px; position:relative;}
.dash-bottom div:last-child{border-bottom:0px; }
ul.dash-list, ul.dash-list02{color:#959595; font-size:22px; line-height:36px; font-weight:normal;}
ul.dash-list02{color:#959595; font-size:22px; line-height:40px; font-weight:normal;}
ul.dash-list strong{color:#4a4a4a; font-weight:normal;}
ul.dash-list02 strong{color:#4a4a4a; font-weight:normal; font-size:27px;}
ul.dash-list img, ul.dash-list02 img{line-height:0px; font-size:0px; margin:0 0 0 7px;}
ul.dash-list a, ul.dash-list02 a{color:#2f7fe9; text-decoration:underline;}
ul.dash-list a:hover, ul.dash-list02 a:hover{text-decoration:none;}
ul.dash-list span.dash-button a,a.confirmation_link{-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;
background-color:#2d73e2; border:1px solid #6ea0de; display:inline;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#82bff5), to(#2d73e2));
  background: -webkit-linear-gradient(top, #82bff5, #2d73e2);
  background: -moz-linear-gradient(top, #82bff5, #2d73e2);
  background: -ms-linear-gradient(top, #82bff5, #2d73e2);
  background: -o-linear-gradient(top, #82bff5, #2d73e2); padding:4px 20px; color:#ffffff; text-decoration:none;}
 ul.dash-list span.dash-button a:hover,a.confirmation_link:hover{
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#2d73e2), to(#82bff5));
  background: -webkit-linear-gradient(top, #2d73e2, #82bff5);
  background: -moz-linear-gradient(top, #2d73e2, #82bff5);
  background: -ms-linear-gradient(top, #2d73e2, #82bff5);
  background: -o-linear-gradient(top, #2d73e2, #82bff5);} 
ul.dash-list02 span.dash-left{float:left; margin:0 10px 0 0;}
.confirmation_width{width:44%;}
	
/* -------------------------------------- Responsivee View -------------------------------------- */
@media only screen and (min-width: 120px) and (max-width: 700px) {
#wrap{width:100%; margin:0 auto; padding:0 0;}
.wrap-common{margin:0 auto; width:100%;}
.hd-admin{padding:0px; margin:0px; text-align:center; background:url('https://www.tablesavvy.com/theme/tablesavvy/images/hd-bg.png') repeat-x;border:0;clear:both; line-height:54px; font-size:24px;
text-transform:uppercase; color:#595959; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif; font-weight:bold;}
.logo-wrap{text-align:center; padding:28px 0 21px; width:90%; margin:0 auto; position:relative;}
.logo-wrap .img-thumbnail{display: inline-block;  height: auto;  max-width: 100%;  padding: 0px;  line-height:0px;  font-size:0px;  
border: 0px solid #dddddd;  border-radius: 0px;  -webkit-transition: all 0.2s ease-in-out;transition: all 0.2s ease-in-out;background:transparent;}
.dash-wrap{width:90%; margin:29px 0 auto 150px;padding:0 0 20px;float:left;}

ul.dash-list, ul.dash-list02{color:#959595; font-size:22px; font-size:110%; line-height:36px; line-height:180%; font-weight:normal;}
ul.dash-list02 strong{font-size:27px; font-size:120%;}
}

@media only screen and (min-width: 120px) and (max-width: 560px) {
	.button{position:inherit; right:0; top:0; clear:both; margin:10px 0 0; font-size:20px; font-size:100%;}
	.button a{width:25%; font-size:20px; font-size:100%;}
	.hd-admin{font-size:24px; font-size:115%;}
	.button-login {position:inherit; left:0px; top:0px; margin:10px 0 0 0;clear:both;}
	.button-back{position:inherit; left:0px; top:0px; margin:23px 0 0 0;clear:both;}
.button-login a{height:35px; line-height:35px;  font-size:20px; font-size:120%; padding:0;  width:50%; margin:0 auto;  }
.button-back a{clear:both; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; width:50%; margin:0 auto; 
  background-color: #cdcdcd; height:35px; line-height:35px; font-size:20px; font-size:120%; padding:0px;
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fcfcfc), to(#cdcdcd));
  background: -webkit-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -moz-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -ms-linear-gradient(top, #fcfcfc, #cdcdcd);
  background: -o-linear-gradient(top, #fcfcfc, #cdcdcd); border:1px solid #c6c6c6;}
.button-back a:hover{
  background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#cdcdcd), to(#fcfcfc));
  background: -webkit-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -moz-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -ms-linear-gradient(top, #cdcdcd, #fcfcfc);
  background: -o-linear-gradient(top, #cdcdcd, #fcfcfc);
} 		
}	
@media only screen and (min-width: 120px) and (max-width: 380px) {
	.button-login {position:inherit; right:0; top:0; clear:both; margin:10px 0 0;}
.button-login a, .button-back a{height:35px; line-height:35px;  font-size:18px; font-size:100%; padding:0; width:50%; margin:0 auto; }
.img-thumbnail{clear:both;}
.button-back{position:inherit; right:0; top:0; clear:both; margin:10px 0 0;}
}
</style>
<div class="dash-wrap">
    <h2 class="hd-dash">Dashboard</h2>
    <div class="dash-bottom">
        <?php
        $i = 1;
        $class = 'fist_row';
        if (!empty($rest)) {
            foreach ($rest as $data) {
                $offerTime = date('g:i A', strtotime($data['Offer']['offerTime']));
                $offerDate = $data['Offer']['offerDate'];
                $seating_cus = $data['Offer']['seating_custom'];
                $seating = $data['Offer']['seating'];
                ?>
                <div>
                    <ul class="dash-list">               
                        <li>
                            <!--- User Name----->
                            <strong>
                                <?php
                                $user_fname = $data['User']['firstName'];
                                $user_lname = $data['User']['lastName'];
                                if (!empty($user_fname))
                                    echo $user_fname . ' ';
                                if (!empty($user_lname))
                                    echo $user_lname . ' - ';
                                ?>
                            </strong>
                            <!---- Restaurant Name ---->
                            <?php
                            if (!empty($data['Offer']['restaurantId'])) {
                                $user_id = $data['Offer']['restaurantId'];
                                $row = mysql_fetch_array(mysql_query("select restaurants.name,restaurants.phone from restaurants where restaurants.id='" . $user_id . "' "));
                                if (strlen($row['name']) > 20)
                                    echo substr($row['name'], 0, 18) . '...';
                                else
                                    echo $row['name'];
                            }
                            ?>
                        </li>
                        <!---- Offer Time --->
                        <li>Reservation Time:  
                            <?php 
                            if (!empty($offerTime)) echo '<span class="mobile_seating">'.$offerTime.'</span>';
                            if (!empty($seating)) {
                                if ($seating_cus != 0)
                                    echo '&nbsp;&nbsp;&nbsp;Party Size: <span class="mobile_seating">'.$seating_cus;
                                elseif ($data['Reservation']['cancel_custom'] != 0)
                                    echo '&nbsp;&nbsp;&nbsp;Party Size: <span class="mobile_seating">'.$data['Reservation']['cancel_custom'];
                                else
                                    echo '&nbsp;&nbsp;&nbsp;Party Size: <span class="mobile_seating">'.$seating;
                                echo '</span>';
                            }
                            ?>
                        </li>
                        <!---- Restaurant Number ---->
                        <li>Restaurant Number:
                            <?php
                                if (!empty($row['phone'])) {
                                    $phone = $str = str_replace(array(' ', '<', '>', '&', '+', '{', '}', '*', '-', ')', '('), array(''), $row['phone']);
                                    if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $phone, $matches)){
                                        $result = '(' . $matches[1] . ')' . '-' . $matches[2] . '-' . $matches[3];
                                        $to_call=$matches[1]. $matches[2] .$matches[3]; 
                                    }else                                         
                                        $result='Nil';
                                }
                            ?>
                            <a href="tel:<?php echo $to_call;?>">
                                <?php   echo $result;?>
                            </a>
                        </li>
                        <li>Reservation Confirm:
                                <a href="#" class="confirmation_link" style="color:#fff;text-decoration:none;">
                                    <?php 
                                        if($data['Reservation']['receipt']==1)
                                            echo 'Yes'; 
                                        else
                                            echo 'No'; 
                                    ?>
                                </a>&nbsp;
                                <?php 
                                    if($data['Reservation']['approved']!=0)
                                        echo $html->image('/images/ad_select.png',array('class'=>'approve'));
                                    else
                                        echo $html->image('/images/ad_cancel.png',array('class'=>'reject'));
                                ?>
                        </li>
                    </ul>
                    <p class="button"><?php echo $html->link('More', array('controller' => 'Users', 'action' => 'moredetails', $data['Reservation']['id'])); ?></p>
                </div>  

                <?php $i++;
            }
        }else { ?>
            <div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
                No User Found
            </div>
                <?php } ?>
                <?php if (!empty($rest)) { // class="pagination" ?>   
            <div style="width:850px; margin:38px 10px 20px 0; float:right; font-size:24px;" class="pag_normal">             
                <span style="float:right">  
                    <?php
                    if ($this->Paginator->numbers()) {
                        echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));
                        ?> &nbsp; <?php echo $this->Paginator->numbers(); ?> &nbsp; <?php
                echo $paginator->next(' Next >>', null, null, array('class' => 'disabled'));
            }
            ?> 
                </span>
            </div>
<?php } ?> 
    </div>
</div>