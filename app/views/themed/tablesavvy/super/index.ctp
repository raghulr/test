<div id="changedate">
<?php $changedateurl=$html->url(array('controller'=>'table','action'=>'changedate'),true); ?>
<div class="date_set"><span></span><input id="date1" class="date-pick dp-applied" name="date1" onChange="changedate(this.value,'<?php echo $changedateurl; ?>')" value="<?php echo date('m/d/Y'); ?>"></div>
    <div class="cont_navi">
        <ul class="navigation">
            <li class="active_link"><?php echo $html->link('Restaurants',array('controller'=>'table','action'=>'index'),array('class'=>'active')); ?></li>
            <li><?php echo $html->link('Users',array('controller'=>'reservations','action'=>'index')); ?></li>
            <li><?php echo $html->link('Statistics',array('controller'=>'restaurants','action'=>'profile')); ?></li>
            <li><?php echo $html->link('Neighborhoods',array('controller'=>'neighborhoods','action'=>'index')); ?></li>
            <li><?php echo $html->link('Cuisines',array('controller'=>'restaurants','action'=>'profile')); ?></li>
        </ul>
    </div>
    
    <div class="navi_botom"></div>	
</div>