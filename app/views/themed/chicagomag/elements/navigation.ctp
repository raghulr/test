 <div id="restNav">
         <ul class="clearfix">
            <?php 
                $user_id = $this->Auth->user('id');
                $Userurl=$Logurl=$html->url(array('controller'=>'users','action'=>'login'),true);
                $logword='Login';
                $class_popup='btn-small-new';
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
            <li><?php echo $html->link('Home',array('controller'=>'homes','action'=>'index'),array('class'=>'btns-small-new')); ?></li>
            <li><?php echo $html->link('How it works',array('controller'=>'homes','action'=>'howitworks'),array('class'=>'btn-small-new')); ?></li>
            <li><?php echo $html->link('My Profile',$Userurl,array('class'=>$class_popup)); ?></li>
            <li><?php echo $html->link('FAQ',array('controller'=>'homes','action'=>'faq'),array('class'=>'btn-small-new us')); ?></li>
            <li><?php echo $html->link('Contact Us',array('controller'=>'contacts','action'=>'add','1'),array('class'=>'btn-small-new us')); ?></li>
         </ul>
 </div>