<style type="text/css">
.error-message{
margin-top:10px;
}
</style>
<div class="mainsubscribe">
	<div class="mainsubsubscribe">
        <div class="containersub">
            <div class="titlesavvay"> 
               <?php echo $html->image('/images/headertop.png',array('width'=>352,'height'=>87,'border'=>0)); ?>
            </div>
             <div class="titlesavvay2">
               Redefining fine dining in Chicago
            </div>
            <div class="titlesavvay3">
           We are launching fall 2012.<br/>
        Sign-up and stay in the loop with exclusive updates. 
            </div>
             <?php echo $form->create('Subscription');?>
            <div class="titlesavvay4">
            <div class="success"><?php if(!empty($subscribe)&&$subscribe==1){ echo 'Thanks for Subscription'; }?></div>
                <div class="emaildiv">
                <?php echo $form->input('email',array('label'=>false,'value'=>'type your email','onfocus'=>'javascript:if(this.value=="type your email"){ this.value="";}','onblur'=>'javascript:if(this.value==""){ this.value="type your email";}')); ?>
                </div>
                <div class="imagediv">
                <?php  echo $form->submit('/images/bluesubmit.png');?>
                </div>
               
            </div>
            <?php  echo $form->end();?>	
            <div class="footersub">
                	<div class="stline"></div>
                    <div class="fbimage"><a href="<?php echo Configure::read('website.facebook');?>" target="_blank"><?php echo $html->image('../images/fabb.png',array('border'=>0));?></a></div>
                    <div class="stline1"></div>
                    <div class="blogimage"><a href="<?php echo $html->url('/blog',true);?>" target="_blank"><?php echo $html->image('../images/blog.png',array('border'=>0));?></a></div>
                     <div class="stline1"></div>
                     <div class="fbimage"><a href="<?php echo Configure::read('website.twitter');?>" target="_blank"><?php echo $html->image('../images/twitt.png',array('border'=>0));?></a></div>
                     <div class="stline"></div>
                </div> 
         </div> 
           
        </div> 
</div>