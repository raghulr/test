<div class="tabl_head">
    <div class="time"><span id="time">Name</span></div>
    <div class="time" id="rest_no1"><span id="time">City</span></div> 
    <div class="time" id="rest_no5"><span id="time">Edit</span></div> 
    <div class="time" id="rest_no3"><span id="time">Approved</span></div> 
    <div class="time" id="rest_no4"><span id="time">Remove</span></div> 
</div>

<div class="tabl_cont" id="change_city">
	<?php 
    $i = 1;
    $class='fist_row';
    if(!empty($websites)){
    foreach($websites as $data){
    ?>
    <div class="<?php if($class=='fist_row'):echo $class;$class='sec_row';else:echo $class;$class='fist_row';endif;?>">
        <div class="time">
            <span id="neigh_name1"><?php echo $data['Website']['website_name']; ?></span>
        </div>  
    <div class="time" id="rest_no1">
        <span id="neigh_name1">
            <?php 
            $city_id = $data['Website']['city_id'];
            $row=mysql_fetch_array(mysql_query("select * from cities where id='$city_id' "));
            $city_name= $row['city_name']; 
            echo $city_name;
            ?>
        </span>
    </div>
    <div class="time" id="rest_no5">
        <span id="neigh_name2" style="margin:20px 0 0 20px"> 
            <?php $website_id = $data['Website']['id']; ?>
            <a href="<?php echo $html->url(array('controller'=>'websites','action'=>'super_websiteedit',$website_id)); ?>" class="colorbox-website-add cboxElement" style="color:#999999; text-decoration:none; font-size:18px; font-weight:bold;">
            <?php echo $html->image("/images/Edit.gif",array("width"=>20,"height"=>17));?>
            </a>
        </span>
    </div>
    <div class="time" id="rest_no3">
        <span id="neigh_name1">
            <?php 
            
            $approve_id = $data['Website']['active'];
            $checked='';
            if($approve_id == 1)
            $checked='checked';
            $approved_url=$html->url(array('controller'=>'websites','action'=>'super_websiteapproved',$website_id));
            echo $form->input('active', array('label'=>false,'type'=>'checkbox','class'=>'rest_check','checked'=>$checked,'complete'=>'funcall()', 'id'=>'website_check','onchange' =>'changeWebsite_status(this.value,"'.$website_id.'","'.$approved_url.'");'));
            
            ?>
        </span>
    </div> 
    <div class="time" id="rest_no4">
        <span id="neigh_name1">
        <?php echo $html->link('Delete',array('controller'=>'websites','action'=>'super_websitedelete',$website_id),array('onclick'=>'if(confirm("Are you sure want to delete"))return true;else return false;')); ?>
        </span>
    </div>
    </div>

	<?php 
    $i++; } }
    ?> 
</div> 
<div id="nor_page">
<?php if(!empty($websites)){ // class="pagination" ?>   
<div style="width:886px; margin:10px 10px 20px 0; float:right;" id="status_pagination">
<span style="float:right">  
<?php 
if($this->Paginator->numbers())
{
echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled'));  ?> &nbsp; <?php
echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); 
}
?> 
</span>
</div>
<?php }else{ ?>
<div style="width:600px; margin:72px 22px 20px 312px; float:left;">  
No Websites can be Found
</div>
<?php } ?>
</div>