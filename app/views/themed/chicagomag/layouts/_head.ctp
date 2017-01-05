<?php $browser = $_SERVER['HTTP_USER_AGENT']; ?>
<?php		
	
        $html->css('chi-publication',null,null,false);
	$html->css('chi',null,null,false);
	$html->css('chi-nav',null,null,false);
	echo $html->css('chicagoRevisions',null,null,true);
        $html->css('headersprites',null,null,false);
        $html->css('colorbox',null,null,false);
	echo $html->css('common',null,null,true);
                
	if (isset($javascript)):
            $javascript->codeBlock('var cfg = ' . $javascript->object($js_vars_for_layout) , array('inline' => false));
            $javascript->link('jquery-1.8.1.min', false);
            $javascript->link('jquery.colorbox', false);
            $javascript->link('common', false);
            $javascript->link('popup', false);
        endif;
?>	