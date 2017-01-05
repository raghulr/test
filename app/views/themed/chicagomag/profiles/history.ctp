<?php 
	$javascript->link('jquery.jcarousel', false);
	$javascript->link('jquery.alerts', false);
	
        echo $html->css('jquery.alerts', null, null, false);
        echo $html->css('skin_new', null, null, false);
?>
<div id="page-body-right" class="reservation_details">
   <?php echo $this->element('navigation'); ?>
    <div id="content" class="clearfix">
        <div id="content-header" class="hatched clearfix">
            <ul>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'index'),true); ?>">My Reservation</a></li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'alerts'),true); ?>">Alerts</a></li>
                <li class="on">History</li>
                <li><a href="<?php echo $html->url(array('controller'=>'profiles','action'=>'profile'),true); ?>">Profile</a></li>
            <ul>
        </div>
        <div class="content">							
            <h1>My Reservation History</h1>
            <?php if(!empty($user_history)){ ?>
            <div id="historyChicago">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0" id="historyTable">
                    <tr align="left" valign="top">
                        <th width="360">Date</th>
                        <th width="230">Restaurant</th>
                        <th width="250">Time</th>
                        <th>Party</th>
                    </tr>
                    <?php 
                    $total_history = count($user_history);
                    $count = 0;
                    foreach($user_history as $user){ ?>
                    <tr align="left" valign="top" <?php if($count ==$total_history):?> class="borderless"; <?php endif;?> >
                        <td><?php echo date('l, F D, Y',strtotime($user['Offer']['offerDate'])); ?></td>
                        <td><strong><?php echo $user['Offer']['Restaurant']['name']; ?></strong></td>
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
                    <?php echo $paginator->next('Next',null,null,array('class'=>'disabled')); ?>&nbsp;&nbsp;
                    <?php } ?>  
                </div> 
            </div>
            <?php }else{
                echo 'No reservation found';
            } ?>
        </div>
    </div><!-- /#content -->
</div>