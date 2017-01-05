<div class="contentcontainer">
	<div class="content">
    	<div class="subcontainer">
        	<div class="subinnercontainer">
                <div class="finddeal">
                    <div class="greenhead">&nbsp;</div>
                    <div class="greencontent">
                        <div class="titledeal">
                            <div class="finddeal1">
                            <a href="<?php echo $html->url(array('controller'=>'homes','action'=>'index'),true);?>"><?php echo $html->image('/images/finddeal.png',array('border'=>0));?></a>
                            </div>
                             <div class="search margin_topp">
                                 <?php echo $form->create('Home'); ?>
								<?php if(isset($res)){
                                 echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','div'=>false,'value'=>$res,'onfocus'=>'javascript:if(this.value=="Search by restaurant name"){ this.value=""}','onblur'=>'javascript:if(this.value==""){ this.value="Search by restaurant name"}'));
								 echo $form->input('page',array('type'=>'hidden','value'=>'help'));
                                } else {
                                         echo $form->input('search',array('type'=>'text','label'=>false,'class'=>'input-text','div'=>false,'value'=>'Search by restaurant name','onfocus'=>'javascript:if(this.value=="Search by restaurant name"){ this.value=""}','onblur'=>'javascript:if(this.value==""){ this.value="Search by restaurant name"}'));
										 echo $form->input('page',array('type'=>'hidden','value'=>'help')); 
										} ?>	
                                <?php echo $ajax->submit('',array('url'=>array('controller'=>'homes','action'=>'search'),'update'=>'select_search')); 
                                      echo $form->end();?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="subinnercontainer" id="select_search">
            	<div class="help_cont">
                	<div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                    <div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                    <div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                    <div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                    <div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                    <div class="help_topic">
                    	<div class="h_hed">Lorem ipsum dolor sit amet, consectetur adipisicing elit</div>
                        <div class="h_cont">
                        	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim 
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id 
                            est laborum.
                        </div>
                    </div>
                </div>
            </div>
        </div>	
    </div>   
</div>