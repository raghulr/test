<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php			
	 echo $html->css('tableSavvyStructure',null,null,true);
	 echo $html->css('tableSavvyWidget_new',null,null,true);
     echo $html->css('common',null,null,true);
    if (isset($javascript)):
        $javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
        $javascript->link('jquery-1.8.1.min', false);
        $javascript->link('common', false);
        $javascript->link('popup', false);
    endif;
?>	