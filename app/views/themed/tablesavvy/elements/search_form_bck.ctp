<!--<div class="home_title">
	<div class="browse1">Find a Table for Tonight</div>
</div>-->
<div class="more-spacer">&nbsp;</div>
<div class="contentcontainer clearfix" id="contentcontainer">
    <div class="header-home">
        <ul class="header-detail">
            <li>
                <div class="content-header">
                    <p class="head_nor">Find <span class="head_bold">a last minute table for tonight</span></p>
                </div>
                <?php echo $html->image('/images/1.png', array('alt'=>'TableSavvy','class'=>'header_image img_header'));?>
                <div class="spacer"></div>
            </li>
            <li>
                <div class="content-header">
                    <p class="head_nor">Reserve <span class="head_bold">your table for $5</span></p>
                </div>
                <?php echo $html->image('/images/2.png', array('alt'=>'TableSavvy','class'=>'header_image img_header'));?>                
                <div class="spacer"></div>
            </li>
            <li class="last">
                <div class="content-header">
                    <p class="head_nor">Save 30% <span class="head_bold">off your meal!</span></p>
                </div>
               <?php echo $html->image('/images/3.png', array('alt'=>'TableSavvy','class'=>'header_image img_header'));?>                
                <div class="spacer"></div>
            </li>
        </ul>
        <div class="spacer"></div>
    </div>
    <div class="content clearfix" id="content_search">
        <div class="selects clearfix">
            <?php 
            echo $form->create('Home',array('action'=>'select_search'));
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
							$setdisable='';
							if(isset($disabled)){
								$setdisable='disabled';
							}
                            echo $form->input('Restaurant.neighborhoodId',array(
                                    'label'=>false, 
                                    'class'=>'select_box',
                                    'type'=>'select',
                                    'options'=>array($neighbor_list),
                                    'empty'=>'Any',
                                    'id'=>'neighborhood_id',
                                    'selected'=>$neighborhood_id,
									'disabled'=>$setdisable
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
                                        'selected'=>$time_select,
										'disabled'=>$setdisable
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
                                    'selected'=>$cuisine_id,
									'disabled'=>$setdisable
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
                                    'selected'=>$party_size,
									'disabled'=>$setdisable
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
        <div class="spacer">&nbsp;</div>
        <div class="search" id="search">
            <span>Search by restaurant name</span>  						
			<?php echo $form->create('Home'); ?>
             <div class="ui-widget">		
                <?php echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','div'=>false,'onkeydown' => 'auto_complete(this.value)','disabled'=>$setdisable));  ?>
              </div>
                <!--<div class="auto_response" id="auto_complete_response"></div>-->
                <div class="search_btn">
                   <?php echo $ajax->submit('',array(
                        'url'=>array('controller'=>'homes','action'=>'search'),
                        'id'=>'ajax_submit',
                        'update'=>'select_search',
                        'complete'=>'searchhome_scroll(request.responseText)'
                        //'indicator' => 'loading'
                        ));                
                    ?>
                </div>
            <?php echo $form->end();?>                    
        </div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'auto_complete'),true);?>
        <div id="auto_complete_url" style="display: none;"><?php echo $url;?></div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'details'),true);?>
        <div id="auto_red_url" style="display: none;"><?php echo $url;?></div>
        <?php $url = $html->url(array('controller'=>'homes', 'action'=>'auto_com_red'),true);?>
        <div id="auto_comp_res_url" style="display: none;"><?php echo $url;?></div>
    </div>
</div>
<div class="more-spacer">&nbsp;</div>
