<?php
  // Active Item
  $a = $active;
?>

<div class="ui vertical pointing stackable inverted fluid menu">
  <a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>" class="<?php if ($a == 'index') { echo 'active'; } ?> item">
    My Reservation
  </a>
  <a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>" class="<?php if ($a == 'profile') { echo 'active'; } ?>  item">
    Profile
  </a>
  <a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'history'),true); ?>" class="<?php if ($a == 'history') { echo 'active'; } ?> item">
    History
  </a>
</div>
