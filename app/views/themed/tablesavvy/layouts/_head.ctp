<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php			
    $html->css('chi-publication',null,null,false);
	if($this->params['controller']!='subscription')
    	$html->css('chi',null,null,false);
    $html->css('chi-nav',null,null,false);   
    $html->css('headersprites',null,null,false);
    $html->css('colorbox',null,null,false); 
    echo $html->css('tableSavvyWidget',null,null,true);
    echo $html->css('chicagoRevisions',null,null,true);
	echo $html->css('jquery-ui',null,null,true);
    echo $html->css('common',null,null,true);
	echo $html->css('fonts',null,null,true);
    
    if (isset($javascript)):
        $javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
		$javascript->link('jquery-1.8.3', false);
        $javascript->link('common', false);
        $javascript->link('popup', false);
		$javascript->link('jquery_auto', false);
    endif;
?>	