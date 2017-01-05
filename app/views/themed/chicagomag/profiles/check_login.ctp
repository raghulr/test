<?php if($user_id==''){ ?>
<a href="<?php echo $html->url(array('controller'=>'users','action'=>'login',1),true); ?>"  class="color_login">LOGIN</a>
<?php }else {?>
<a href="<?php echo $html->url(array('controller'=>'users','action'=>'logout'),true); ?>">LOGOUT</a>
 <?php }?>