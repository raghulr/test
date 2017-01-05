<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
   <?php echo $html->charset(), "\n";?>  
   <title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title>
    <?php
    echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
    echo $html->meta('description', $meta_for_layout['description']), "\n";
    echo $html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=9'));
    ?>
    <meta name="apple-itunes-app" content="app-id=845047265"/>
    <meta name="google-play-app" content="app-id=com.food.tablesavvy" />
    <meta name="google-site-verification" content="ziNLvXNQbZyu4eit7s-j1O9GqeRRHordy-clri0pmfk" />
    <meta property='og:site_name' content='<?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?>'/>
    <meta property='og:title' content='<?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?>'/>
    <meta property='og:description' content='<?php if(isset($og_desc)) echo $og_desc; else echo $meta_for_layout['keywords'];?>'/> 
    <meta name="imageTag"  content="<?php echo Router::url('/', true).'images/tablesavyyfb.png';?>"/>
    <meta property='og:image' content='<?php echo Router::url('/', true).'images/tablesavyyfb.png';?>'/>
    <?php
    require_once('_head.ctp');
    echo $asset->scripts_for_layout();
	//echo $this->Html->meta('icon');
    ?>
</head>
<body class="home-pattern">
<?php
if ($session->check('Message.error')):
	echo $session->flash('error');
endif;
if ($session->check('Message.success')):
	echo $session->flash('success');
endif;
if ($session->check('Message.flash')):
	echo $session->flash();
endif;
?>
    <div class="home-bg <?php echo strtolower($title_for_layout); ?>">
        <div style="width:990px;margin : 0px auto;">
             <div class="home-container">
                <?php echo $this->element('header');?>
                <div class="more-spacer">&nbsp;</div>
                    <div id="content" class="clearfix"> 
                    <?php echo $content_for_layout;?>   
                    </div>    
                <?php echo $this->element('footer');?> 
            </div> 
        </div>  
    </div>  
</body>
</html>
