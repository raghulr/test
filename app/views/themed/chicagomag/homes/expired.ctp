<?php 
    echo $javascript->link('jquery.jcarousel', false);
    echo $html->css('home_skin', null, null, false)
?>
<script type="text/javascript">
jQuery(document).ready(function(){
    home_scroll();
});
</script>
<div id="page-body-right">
    <?php echo $this->element('search_form');?>

    <div id="select_search" class="prodcucontainer clearfix">
        <div class="bordersearch" id="noresfound"><?php  echo "All of todays offerings have now expired! Check below for a fresh batch of restaurants for tomorrow!!!"; ?></div>     
    </div>    
</div>    