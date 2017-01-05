<?php
  $user = $session->read( 'Auth.User' );
  $user_amount= Configure::read('user.user_amount');
?>

<div class="ui body container">
<?php
	$javascript->link('jquery.jcarousel', false);
	$javascript->link('jquery.alerts', false);

	echo $html->css('jquery.alerts', null, null, false);
	echo $html->css('skin_new', null, null, false);
?>

  <?php if ($user_amount > 0) { ?>
  <div class="ui icon message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        You have a $<?php echo $user_amount ?> credit in your account
      </div>
      <p>Your next reservation is on us.</p>
    </div>
    <a href="/all_restaurant" class="ui button basic right floated">Book Now</a>
  </div>
  <?php } ?>

<div class="ui grid stackable">
  <div class="four wide column">
		<?php echo $this->element('profile_sidebar', array('active' => 'history')); ?>
	</div>
	<div class="twelve wide column">
    <div id="content" class="clearfix">
        <div class="content">
            <h1>My Reservation History</h1>
            <?php if(!empty($user_history)){ ?>
            <div id="historyChicago">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="historyTable">
                    <tr class="history_head" align="left" valign="top">
                        <td width="360">Date</td>
                        <td width="230">Restaurant</td>
                        <td width="250">Time</td>
                        <td>Party</td>
                    </tr>
                    <?php
                    $total_history = count($user_history);
                    $count = 0;
                    foreach($user_history as $user){ ?>
                    <tr align="left" valign="top" <?php if($count ==$total_history):?> class="borderless"; <?php endif;?> >
                        <td><?php echo date('l, F d, Y',strtotime($user['Offer']['offerDate'])); ?></td>
                        <td><strong><?php
                            $res_id = '';
                            if(!empty($user['Offer']['Restaurant']['id']))
                                $res_id = $user['Offer']['Restaurant']['id'];
                            $url = $html->url(array('controller'=>'homes', 'action'=>'details',$user['Offer']['Restaurant']['slug_name']),true);?>
                            <a class="history_res" href="<?php echo $url;?>"><?php echo !empty($user['Offer']['Restaurant']['name'])?$user['Offer']['Restaurant']['name']:''; ?></a></strong>					</td>
                        <td><?php echo date("g:i a", strtotime($user['Offer']['offerTime']));?></td>
                        <td>
                            <?php
                            if($user['Offer']['seating_custom']!=0)
                                echo $user['Offer']['seating_custom'];
                            else
                                echo $user['Offer']['seating'];
                            ?>
                        </td>
                    </tr>
                    <?php
                    $count++;
                    } ?>
                </table>
                <div class="paginate">
                    <?php if($paginator->numbers()){?>
                    <?php echo $paginator->prev('Prev',null,null,array('class'=>'disabled'));?>&nbsp;&nbsp;
                    <div class="float"> <?php echo $paginator->numbers(array('before'=>'','after'=>'','class' => 'numbers')); ?></div>&nbsp;&nbsp;
                    <?php echo $paginator->next('Next',null,null,array('class'=>'disabled class_ie')); ?>&nbsp;&nbsp;
                    <?php } ?>
                </div>
            </div>
            <?php }else{
                echo 'No reservation found';
            } ?>
        </div>
    </div><!-- /#content -->
	</div>
	</div>
</div>
