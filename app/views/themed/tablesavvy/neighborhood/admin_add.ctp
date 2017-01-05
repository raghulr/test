<div class="js-responses" id="js-responses">
    <div class="titlepopup">
        <div class="lefttitlepopup"></div><div class="midtitlepopup"><?php if(!empty($title_for_popup))echo $title_for_popup; ?></div><div class="righttitlepopup"></div>
    </div>
    <div class="neighborhood">
    <?php echo $form->create('Neighborhood',array('action'=>'add', 'class'=>'js-ajax-form'));?>
        <?php echo $form->input('name',array('label'=>'Name : ')); ?>
        <div class="log_button"><?php echo $ajax->submit('Add', array('url'=> array('controller'=>'neighborhoods', 'action'=>'add'), 'update' => 'js-responses', 'complete'=>'funcall()'));?></div>
    <?php echo $form->end();?>
    <?php echo $ajax->link('Update to Profile', array('controller'=>'neighborhoods', 'action'=>'update'), array('complete'=>'complete(request.responseText)'));?>
    </div>    
</div>    
