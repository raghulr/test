
<div id="contentcontainer" class="contentcontainer clearfix">
    <div class="header">
        <div>
            <!--<a class="phone-only" href="http://www.chicagomag.com">
                <img width="248" height="80" alt="Chicago Magazine" src="http://www.chicagomag.com/images/ChicagoLogo_248x40.gif" class="logo phone-only" id="logo">
            </a>	-->
            <a href="http://tablesavvy.tablesavvy.com/home" target="_blank">
                <?php echo $html->image('/images/tablesavvy_logo.png',array('width'=>150,'height'=>39, 'class'=>'logo', 'alt'=>'[ Powered by TableSavvy ]' ));?>
            </a>
        </div>
        <h1>Find a Last Minute Table for Tonight!</h1>
        <div class="intro">Reserve a table for $5 and save 30%!</div>
        <div class="btn-group-wrap">
            <div class="btn-group btn-group-center">
            	<?php 
                $user_id = $this->Auth->user('id');
                $Userurl=$Logurl=$html->url(array('controller'=>'users','action'=>'login'),true);
                $logword='Login';
                $class_popup='btn-small';
                if(isset($user_id)&&!empty($user_id)){
                            $Userurl=$html->url(array('controller'=>'profiles','action'=>'index'),true);
                            $class_popup='';
                            $logword='Logout';
                            if(!empty($fb_logout_url))
                                $Logurl= $fb_logout_url;
                            else
                                $Logurl= $html->url(array('controller'=>'users','action'=>'logout'),true);;

                }
                ?>
                <?php //echo $html->link($logword,$Logurl,array('class'=>'btn '.$class_popup)); ?>
                
                <?php echo $html->link('Home',array('controller'=>'homes','action'=>'index'),array('class'=>'btn-small btn')); ?>
                <?php echo $html->link('How it works',array('controller'=>'homes','action'=>'howitworks'),array('class'=>'btn-small btn')); ?>
                <?php echo $html->link('My Profile',$Userurl,array('class'=>'btn '.$class_popup)); ?>
                <?php echo $html->link('FAQ',array('controller'=>'homes','action'=>'faq'),array('class'=>'btn-small btn')); ?>
                <?php echo $html->link('Contact Us',array('controller'=>'contacts','action'=>'add','1'),array('class'=>'btn-small us btn')); ?>
            </div>
        </div>
        <div class="fb_sign center_align" id='fb_sign'> 
            <?php 
            $user_id = $this->Auth->user('id'); 
            if(!empty($user_id)){
                $row=mysql_fetch_array(mysql_query("select users.Firstname,users.user_amount from users where users.id='".$user_id."' "));
                $user_fname= $row['Firstname'];
                $user_amount= $row['user_amount'];
            ?>
            Welcome <?php echo $user_fname?> | $<?php echo $user_amount;?> Credit 
            <?php
            }else{
            ?>
            <a href="<?php echo $html->url(array('controller'=>'users','action'=>'register'),true); ?>"  class="color_sign">Not a member? Sign up!</a> | 
            <?php  
            if($this->params['controller']=='homes'&&$this->params['action']=='index')
                echo $html->link('Login',array('controller'=>'users','action'=>'login','?f=home'));  		
            else 
                echo $html->link('Login',array('controller'=>'users','action'=>'login',1));
            ?>
            <?php } ?> 
            <?php 
                if(!empty($user_id)){
                    if(empty($fb_logout_url))
                    $fb_logout_url = $html->url(array('controller'=>'users','action'=>'logout'));
            ?>
                <a href="<?php echo $fb_logout_url; ?>"> | Logout</a>
            <?php } ?>
        </div>
    </div><!-- /.header -->
    <div id="content_search" class="content clearfix">
        <div class="selects clearfix">
            <?php 
            echo $form->create('Home',array('controller'=>'homes','action'=>'select_search'));
            $url = $html->url(array('controller'=>'homes', 'action'=>'select_search'),true);
            $neighborhood_id = '';
            $cuisine_id = '';
            $time_select = '';
            $party_size = '';
            $party_sizes = array(2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8')
            ?>
                <div class="row1 clearfix">
                    <div id="search_url" style="display: none;"><?php echo $url;?></div>
                    <div class="neignborhood left">
                        <span>By Neighborhood</span>    
                        <div class="input select">
                            <?php
                            echo $form->input('Restaurant.neighborhoodId',array(
                                    'label'=>false, 
                                    'class'=>'select_box',
                                    'type'=>'select',
                                    'options'=>array($neighbor_list),
                                    'empty'=>'Any',
                                    'id'=>'neighborhood_id',
                                    'selected'=>$neighborhood_id,
                                ));
                            ?>
                        </div> 
                    </div>
                    <div class="time right">
                        <span>By Time</span>
                        <div class="input select">
                            <div class="input select">
                                <?php
                                    echo $form->input('Offer.offerTime',array(
                                        'label'=>false, 
                                        'class'=>'select_box short',
                                        'type'=>'select',
                                        'label'=>false,
                                        'options'=>$options,
                                        'id'=>'time_id',
                                        'empty'=>'Any',
                                        'selected'=>$time_select
                                        )); 
                                ?>
                            </div>
                        </div>                                
                    </div>
                </div>
                <div class="row2 clearfix">
                    <div class="cuisine left ">
                        <span>By Cuisine</span>
                        <div class="input select">
                            <?php
                            echo $form->input('Restaurantcuisine.cuisine_id',array(
                                    'label'=>false, 
                                    'class'=>'select_box',
                                    'type'=>'select',
                                    'options'=>array($cuisine_list),
                                    'id'=>'cuisine_id',
                                    'empty'=>'Any',
                                    'selected'=>$cuisine_id
                                )); 
                            ?>
                        </div>                                
                    </div>

                    <div class="party right ">
                        <span>By Party</span>   
                        <div class="input select">
                            <?php
                                echo $form->input('Offer.seating',array(
                                    'label'=>false,
                                    'id'=>'change',
                                    'class'=>'select_box short',
                                    'type'=>'select',
                                    'label'=>false,
                                    'options'=>$party_sizes,
                                    'empty'=>'Any',
                                    'id'=>'party_id',
                                    'selected'=>$party_size
                                    ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php echo $form->end(); ?>
        </div><!-- /.selects -->

    <div class="or">
        <div>or</div>
    </div>
    <div class="search" id="search">
        <span>Search by restaurant name</span>  						
        <?php echo $form->create('Home'); ?>  
            <?php echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','autocomplete'=>'off','div'=>false));  ?>
            <div class="auto_response" id="auto_complete_response"></div>
            <div class="search_btn">
                <?php echo $ajax->submit('',array(
                    'url'=>array('controller'=>'homes','action'=>'search'),
                    'id'=>'ajax_submit',
                    'update'=>'select_search',
                    'complete'=>'home_scroll()',
                    'indicator' => 'loading'
                    ));
                ?>
            </div>
        <?php echo $form->end();?>                    
    </div>
    <?php $url = $html->url(array('controller'=>'homes', 'action'=>'auto_complete'),true);?>
    <div id="auto_complete_url" style="display: none;"><?php echo $url;?></div>    
    </div><!-- /#content_search -->
</div><!--/#contentcontainer -->
<!-- /#select_search -->