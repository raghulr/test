<div class="conta_topp">
    <div class="conta_left_cur"></div>
    <div class="conta_top_mid"></div>
    <div class="conta_right_cur"></div>
</div>
<div class="conta_left"></div>

<div class="contactcontainer">
        <div class="contacthead"></div>
        <div class="contacttext">
            <span>Have a question that isn’t answered on our help page? A suggestion? We'd </span><br />
            <span>love to hear from you!</span>
        </div>
        <?php //echo $form->create(); ?>
        <div class="contacttext">
            <label>Your Name</label>
            <?php echo $form->input('name',array('type'=>'text','label'=>false,'div'=>false));?>
        </div>
        <div class="contacttext">
            <label>Your Email</label>
            <?php echo $form->input('email',array('type'=>'text','label'=>false,'div'=>false));?>
        </div>
        <div class="contacttext">
            <label>Comment</label>
            <?php echo $form->input('comment',array('type'=>'textarea','label'=>false,'div'=>false));?>
        </div>
         <div class="contacttext1">
            <div class="subcontent">
               <?php echo $form->button('cancel',array('type'=>'reset','label'=>false,'div'=>false,'class'=>'cancel_content'));?>
               <?php echo $form->submit('../images/submit.png',array('label'=>false,'div'=>false,'class'=>'submit_content'));?>
           </div>
         </div>
</div>

<div class="conta_right"></div>
<div class="conta_bott">
    <div class="conta_bot_left"></div>
    <div class="conta_bot_mid"></div>
    <div class="conta_bot_right"></div>
</div>
