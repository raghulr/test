 <div id="restNav">
    <ul class="clearfix">
        <li><?php echo $html->link('Contact us',array('controller'=>'contacts','action'=>'add'),array('class'=>'btns-small-new')); ?></li>
        <li><?php echo $html->link('Privacy Policy',array('controller'=>'homes','action'=>'privacypolicy'),array('class'=>'btn-small-new')); ?></li>
        <li><?php echo $html->link('Return Policy',array('controller'=>'homes','action'=>'returnpolicy'),array('class'=>'btn-small-new')); ?></li>
        <li><?php echo $html->link('Terms & Conditions',array('controller'=>'homes','action'=>'terms'),array('class'=>'btn-small-new us')); ?></li>
        <li><?php echo $html->link('Restaurant Inquiries',array('controller'=>'contacts','action'=>'add','1'),array('class'=>'btn-small-new us')); ?></li>
        <li><?php echo $html->link('FAQ',array('controller'=>'homes','action'=>'faq'),array('class'=>'btn-small-new us')); ?></li>
    </ul>
 </div>