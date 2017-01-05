<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php		
    $html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));

    $html->css('skin_widget', null, null, false);
    //$html->css('widget.css', null, null, false);
    //$html->css('tableSavvyWidget', null, null, false);
	 
    if (isset($javascript)):
        $javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
        $javascript->link('jquery-1.6.1.min', false);
        $javascript->link('jquery.jcarousel', false);
        $javascript->link('jquery.jcarousel1', false);
        $javascript->link('widget', false);
    endif;
?>	