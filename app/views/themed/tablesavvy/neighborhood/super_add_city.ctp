<div class="short_back">
    <div class="upload_top">
        <div class="upload_text">
            <h2>Add a new city</h2>
        </div>    
        <div class="pop_up_middle">
            <a href="#" onclick="parent.$.colorbox.close(); return true;"><?php echo $html->image('/images/close.png',array('width'=>20,'height'=>20,'border'=>0)); ?></a>
        </div>
    </div>
    <div class="pop_slideshowmain">
        <div class="test">
            <?php echo $form->create('');?>
            <div class="login_name">
                <label>City</label>
                <?php echo $form->input('City.city_name',array('type'=>'text','label'=>false,'div'=>false));?>
            </div>
            <div class="submit1">    
                <?php 
                echo $form->Submit('/images/add_now_03.png'); 
                echo $form->end(); 
                ?>
                <div class="submit"> 
                    <a href="#" onclick="parent.$.colorbox.close(); return true;" style="margin-left:10px;"><?php echo $html->image('/images/cancel.png',array('border'=>0)); ?></a>
                </div>   
            </div>     
        </div>
     </div>
</div>