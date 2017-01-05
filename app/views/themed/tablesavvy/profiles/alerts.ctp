<div class="ui body container">
<?php
	echo $javascript->link('jquery.alerts', true);
        echo $html->css('jquery.alerts', null, null, false);
?>
<div id="post"></div>
<div class="ui grid stackable">
  <div class="four wide column">
		<?php echo $this->element('profile_sidebar', array('active' => 'alerts')); ?>
	</div>
	<div class="twelve wide column">
		<div id="page-body-right" class="reservation_details">
		   <?php echo $this->element('navigation'); ?>
		    <div id="content" class="clearfix">
		        <div class="content">
		            <h1 class="float">My Current Alerts</h1>
		            <div class="alertRight">
		                <?php
		                $checked='checked=0';
		                if(!empty($alerts[0]['Alert']['dayselect']) && $alerts[0]['Alert']['dayselect'] == 1)
		                    $checked='checked=1';
		                $change_day_url = $html->url(array('controller'=>'alerts','action'=>'change_day'));
		                ?>
		                <?php /*?><input type="checkbox" id="check" <?php echo $checked;?>, onchange="change_day('<?php echo $change_day_url;?>')" class="float" value="" name="">
		                <p><a class="popup_link" id="popup_link_1" onmouseover="showalert('popup_1')">Send me Daily <?php echo Configure::read('website.name')?> listings</a></p> <?php */?>
		                <!--tooltip content-->
		                <div class="popup popup_1" id="popup_1" style="display: none;" onmouseover="showalert('popup_1')" onmouseout="hidealert('popup_1')">
		                    <div class="popup-handle02">&nbsp;</div>
		                    <div class="popup-inside">
		                        Receive a daily update of all <?php echo Configure::read('website.name')?> listings. This will not remove your current alerts.
		                        <div class="spacer"></div>
		                    </div>
		                    <div class="spacer"></div>
		                </div>
		                <script type="text/javascript">
		                //&lt;![CDATA[
		                new Popup('popup_1','popup_link_1')
		                //]]&gt;
		                </script>
		            </div>
		            <div class="spacer">&nbsp;</div>
		            <div class="alertChicago">
		                <p class="alert">You will be notified daily if the following restaurants have reservations available.</p>
		                <p class="alert"><a class="popup_link" id="popup_link_2" onclick="showalert('popup_2')">Click here</a> to change how often we send you alerts. </p>
		                <!--Content-->
		                <div class="popup-click popup_draghandle popup_2" id="popup_2" style="display: none;">
		                    <div class="popup-handle">&nbsp;</div>
		                    <div class="popup-inside">
		                        <p><strong>Only send me alerts on</strong></p>
		                        <?php
		                        $sunday     = isset($sunday)?$sunday:0;
		                        $monday     = isset($monday)?$monday:0;
		                        $tuesday    = isset($tuesday)?$tuesday:0;
		                        $wednesday  = isset($wednesday)?$wednesday:0;
		                        $thursday   = isset($thursday)?$thursday:0;
		                        $friday     = isset($friday)?$friday:0;
		                        $saturday   = isset($saturday)?$saturday:0;
		                        ?>
		                        <?php echo $form->create('Alert', array('class' => 'ui form'));?>
		                        <div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
                                    <?php echo $form->input('Alert.sunday',array('checked'=>$sunday,'label'=>false,'class'=>'checkbox','div'=>false));?>
                                    <label>Sunday</label>
                                  </div>
                                  <label></label>
                                </div>
                                <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.monday',array('checked'=>$monday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Monday</label>
                                  </div>
                                  <label></label>
                                </div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.tuesday',array('checked'=>$tuesday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Tuesday</label>
                                  </div>
                                  <label></label>
                                </div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.wednesday',array('checked'=>$wednesday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Wednesday</label>
                                  </div>
                                  <label></label>
                                </div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.thursday',array('checked'=>$thursday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Thursday</label>
                                  </div>
                                  <label></label>
                                </div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.friday',array('checked'=>$friday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Friday</label>
                                  </div>
                                  <label></label>
                                </div>
		                            <div class="inline field">
                                  <div class="ui toggle checkbox">
		                            <?php echo $form->input('Alert.saturday',array('checked'=>$saturday,'label'=>false,'class'=>'checkbox','div'=>false));?>
		                            <label>Saturday</label>
                                  </div>
                                  <label></label>
                                </div>
                                <?php echo $ajax->submit('Update', array(
  		                            'url'=>array('controller'=>'alerts','action'=>'day_select'),
  		                            'class'=>'ui button primary popup_closebox',
  		                            'update'=>'post',
  		                            'complete'=>'funcall()',
  		                            'escape'=>false));
  		                        ?>
		                        <?php echo $form->end(); ?>
		                    </div>
		                </div>
		                <script type="text/javascript">
		                //&lt;![CDATA[
		                new Popup('popup_2','popup_link_2')
		                //]]&gt;
		                </script>
		                <div class="spacer">&nbsp;</div>
		                <div class="booking_wrap">
		                    <ul>
		                    <?php
		                    if(!empty($alert)){
		                        $i=1;
		                        foreach($alert as $alerts){
		                        $flaot = 'float';
		                        if(($i%2)==0)
		                            $flaot = 'floatR';
		                    ?>
		                        <li>
		                            <div class="booking_wrap_indiv <?php echo $flaot;?>">
		                                <?php
		                                 if(strlen($alerts['Restaurant']['name'])<20)
											echo $alerts['Restaurant']['name'];
										 else
											echo substr($alerts['Restaurant']['name'], 0, 20).'....';
		                                $delete_url = $html->url(array('controller'=>'profiles','action'=>'alert_delete',$alerts['Restaurant']['id']),true);
		                                ?>
		                                <a href="javascript:;" id="popup_link_4" onclick="delete_alert('<?php echo $delete_url;?>')">
		                                    <?php echo $html->image('/images/close1.png',array('class'=>'close_bttn','width'=>37,'height'=>38));?>
		                                </a>
		                                <div class="spacer"></div>
		                            </div>
		                        </li>
		                    <?php
		                        $i++;
		                        }
		                    }
		                    ?>
		                    </ul>
		                </div>
		                <div class="spacer"></div>
		            </div>
		        </div>
		    </div><!-- /#content -->
		</div>
	</div>
</div>
</div>

<script>
jQuery(function(){
  $('.ui.checkbox')
  .checkbox();
});
</script>
