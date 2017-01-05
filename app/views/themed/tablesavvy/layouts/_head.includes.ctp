<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php
	echo $html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));
	$html->css('reset', null, null, false);
	$html->css('admin', null, null, false);
        $html->css('jquery.alerts.css', null, null, false);
	//$html->css('vtip', null, null, false);
	$html->css('colorbox', null, null, false);
	$html->css('datePicker', null, null, false);
	$html->css('demo', null, null, false);	
	if (isset($javascript)):
		$javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));		
		$javascript->link('jquery-1.6.1.min', false);
		
		$javascript->link('jquery.colorbox.js', false);
		$javascript->link('jquery.cycle.all', false);
		//$javascript->link('cufon-yui', false);
		$javascript->link('date', false);
                $javascript->link('jquery.alerts', false);
    endif;
?>	