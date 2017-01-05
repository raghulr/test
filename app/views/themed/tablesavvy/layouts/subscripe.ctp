<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php			
   $html->css('subscriptionnew',null,null,false);
   if($this->params['controller']!='subscriptions')
   	$html->css('common',null,null,false);
    if (isset($javascript)):
        $javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
        $javascript->link('jquery-1.8.1.min', false);
        $javascript->link('column', false);	
		$javascript->link('common', false);	
    endif;
?>	