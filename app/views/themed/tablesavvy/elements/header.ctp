<?php

  $user = $session->read ( 'Auth.User' );
  $rcount=mysql_fetch_array(mysql_query("select count(userId) as ct from reservations where reservations.userId='".$user['id']."' "));
/*   $show_badge = ((isset($rcount['ct'])&&$rcount['ct']==0) || !isset($user)) ? TRUE : FALSE; */
  $user_amount= Configure::read('user.user_amount');
?>
<header>
  <div class="inner">
    <div class="right_nav">
      <a class="ui button inverted my-account signup_trigger" href="/profile" class="my-account" <?php if ($user_amount > 0) {?>data-content="Your $<?php echo $user_amount ?> credit is waiting"<?php } else if (!$user) { ?>data-content="Free $5 Credit for New Users"<?php } ?>>
        <?php if(!$user || $user_amount > 0){?>
          <div class="floating ui red label">1</div>
        <?php } ?>
        My Account
      </a>
      <?php if ($user) {
        echo $html->link('Log Out',array('controller'=>'users','action'=>'logout'),array('class'=>'logout'));
      } ?>
    </div>
    <a href='/home'><h1 id="brand">TableSavvy</h1></a>
    <a href="#" title="Open Menu" class="hamburger"></a>
    <nav class="main">
      <ul>
        <li><a class="how-it-works" href="#">How it works</a></li>
        <li><?php echo $html->link('Restaurants','/all_restaurant'); ?></li>
        <li><?php echo $html->link('Contact',array('controller'=>'contacts','action'=>'contactus')); ?></li>
        <li class="mobile"><a class="signup_trigger" href="/profile" class="my-account" >My Account</a></li>
        <?php if ($user) { ?>
        <li class="mobile">
        <?php echo $html->link('Log Out',array('controller'=>'users','action'=>'logout'),array('class'=>'logout')); ?>
        </li>
        <?php } ?>
      </ul>
    </nav>
</div>
</header>

<script>
	jQuery(function($) {
		$('.my-account').popup();
  });
</script>
