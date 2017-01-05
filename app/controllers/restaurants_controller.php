<?php
class RestaurantsController extends AppController{
	var $name = 'Restaurant';
	var $components=array('Image');
	var $uses=array('Restaurant','Offer','City');
	function super_index(){
                if($this->Session->check('mobile_admin')){
                    if($this->Session->read('mobile_admin')=='yes'){
                        $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'dashboard',
                                    'super' => true
                                ));
                    }
                }
		$this->layout = 'superadmin';
		$this->loadmodel('Restaurant');
		$conditions=array();
		if(isset($this->data['Restaurants']['search'])){
			$conditions['Restaurant.name LIKE'] = '%'.$this->data['Restaurants']['search'].'%';
		}
		$this->paginate = array(
			'conditions'=>array(
				'Restaurant.name !='=>'',
				$conditions
			),
			'fields'=>array(
                                'id',
				'name',
				'city',
				'approved',
				'rank',
				'slug_name'
			),
			'order'=>'name ASC',
			'limit'=>10,
                    'recursive'=>-1,
		);
		$count=$this->Restaurant->find('count');
		$this->set('rcount',$count);
		$page = $this->paginate('Restaurant');
		$this->set('rest',$page);
	}
	
	function super_addtable(){
		$this->layout = 'superadmin';
		$this->loadmodel('Restaurant');
		$restaurant_name = $this->Restaurant->find('all',array(
			'recursive'=>-1,
			'conditions'=>array(
				'Restaurant.approved'=>1
			),
			'fields'=>array(
				'Restaurant.name',
				'Restaurant.id'
			)
		));
		$this->set('restaurant_name',$restaurant_name);
	}
	function super_count(){
		$this->layout = 'superadmin';
		$this->loadmodel('Restaurant');
		$restaurant_name = $this->Restaurant->find('all',array(
			'recursive'=>-1,
			'conditions'=>array(
				'Restaurant.approved'=>1
			),
			'fields'=>array(
				'Restaurant.name',
				'Restaurant.id'
			)
		));
		$this->set('restaurant_name',$restaurant_name);
	}
	function super_recurringtable(){
		$this->loadmodel('Restaurant');
		$restaurant_name = $this->Restaurant->find('all',array(
			'recursive'=>-1,
			'conditions'=>array(
				'Restaurant.approved'=>1
			),
			'fields'=>array(
				'Restaurant.name',
				'Restaurant.id'
			)
		));
		$this->set('restaurant_name',$restaurant_name);
		unset($this->Offer->validate['Count']);
		if(!empty($this->data)){
			$current=strtotime(date("Y-m-d H:i:s")); 
			$this->Offer->set($this->data);
			if(!empty($this->data['Offer']['offerDate'])){
				$current_date=date('Y-m-d',strtotime($this->data['Offer']['offerDate']));
			}else{
				$current_date=date('Y-m-d');
			}
			if($this->data['Offer']['offerTime']['meridian']=='am'){
				$off_time = $this->data['Offer']['offerTime']['hour'].':'.$this->data['Offer']['offerTime']['min'].':00';
			}else{
				$hour = $this->data['Offer']['offerTime']['hour']+12;
				$off_time = $hour.':'.$this->data['Offer']['offerTime']['min'].':00';
			}
			if($this->Offer->validates()){
				if(!empty($this->data['Offer']['offerDays'])&&$this->data['Offer']['daysorweek']=='Days')
					$enddate=date('Y-m-d',strtotime($current_date.'+'.$this->data['Offer']['offerDays'].'day'));
				elseif(!empty($this->data['Offer']['offerDays'])&&$this->data['Offer']['daysorweek']=='Weeks')
					$enddate=date('Y-m-d',strtotime($current_date.'+'.$this->data['Offer']['offerDays'].'week'));
				if(!empty($this->data['Restaurant']['checked'])) {		
					$count=0;	
					$i=0;	
					foreach($this->data['Restaurant']['checked'] as $restid){
						$i++;
						$this->data['Offer']['restaurantId']=$restid;
						$restr = $this->Restaurant->find('first',array(
							'conditions' => array(
								'Restaurant.id'=>$restid,
								'and' => array(
								array('Restaurant.startTime <= ' => $off_time,
									  'Restaurant.endTime >= ' => $off_time
                             	))),
							'fields'=>array(
								'id',
								'name'
							),
							'recursive'=>'-1'
						 ));
					if(!empty($restr)){
						$this->data['Offer']['offerDate']=$current_date;
						if(!empty($this->data['Offer']['offerDays']) && $this->data['Offer']['daysorweek']=='Days'){
							if($this->data['Offer']['days']=='next day'){
								$this->data['Offer']['offer_day']='Every Day';
								$this->data['Offer']['content']=$current;
                                                                date_default_timezone_set('America/Chicago');
                                                                $offer_created_time = date('Y-m-d H:i:s');
								$this->data['Offer']['created_time'] = $offer_created_time;
								$this->Offer->create();
								$this->Offer->save($this->data);
								$count=$count+1;
							} else {
								$day=strstr($this->data['Offer']['days'],strtolower(date('l',strtotime($current_date))));
								if(!empty($day)){
									$this->Offer->create();
									$this->data['Offer']['offer_day']='Every Day';
									$this->data['Offer']['content']=$current;
									$this->data['Offer']['created_time'] = DboSource::expression('NOW()');
									$this->Offer->save($this->data);
									$count=$count+1;
								}
							}
						} elseif(!empty($this->data['Offer']['offerDays'])&&$this->data['Offer']['daysorweek']=='Weeks'){
							$day=strstr($this->data['Offer']['days'],strtolower(date('l',strtotime($current_date))));
							if(!empty($day)){
								if($this->data['Offer']['offerDate']>=date('Y-m-d')){
									$this->data['Offer']['offer_day']='Every Day';
									$this->data['Offer']['content']=$current;
									$this->data['Offer']['created_time'] = DboSource::expression('NOW()');
									$this->Offer->create();
									$this->Offer->save($this->data);
									$count=$count+1;
								 }
							}
						}
						$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($this->data['Offer']['days'],strtotime($current_date)));
						while($date<$enddate){
							
							if($this->data['Offer']['offerDate']>=date('Y-m-d')){
								$this->Offer->create();
								$this->data['Offer']['offer_day']=$this->data['Offer']['days'];
								$this->data['Offer']['content']=$current;
								$this->data['Offer']['created_time'] = DboSource::expression('NOW()');
								$this->Offer->save($this->data);
								$count=$count+1;
								$i=$count;
							}
						$date=$this->data['Offer']['offerDate']=date('Y-m-d',strtotime($this->data['Offer']['days'],strtotime($this->data['Offer']['offerDate'])));
						}
						//unset($this->data['Offer']['offerDate']);
						}
						//$count=$count-1;
					}
					if($count==$i)
							$this->Session->setFlash('Recurring table has been added successfully' , 'default', null, 'success');
					elseif($i==1)
						$this->Session->setFlash('Recurring table has not been added for Restaurant' , 'default', null, 'error');
					else
						$this->Session->setFlash('Due to different restaurant start time, only some of the restaurants had recurring tables added. Please add a new recurring reservation for the </br> restaurants that require it' , 'default', null, 'error');
							
				} else {
					$this->Session->setFlash('Field is empty, try again...' , 'default', null, 'error');
				}
			} else {
				$this->Session->setFlash('Field is empty, try again...' , 'default', null, 'error');
			}
		}
	}
	
	
	function super_approvefield($sel_id=NULL,$ser_term=NULL){
		$id = (isset($this->params['form']['rest_id'])) ? $this->params['form']['rest_id'] : '';
		if($this->params['form']['approve_id'] == 0){
			$approved=1;
			$this->Session->setFlash('Restaurant approved successfully' , 'default', null, 'success');
		} else {
			$approved=0;	
			$this->Session->setFlash('Restaurant unapproved successfully ' , 'default', null, 'error');
		}
		if($ser_term!=''&&$sel_id!=''){
			if(is_numeric($ser_term)){
				$condition = array('Restaurant.approved'=>$sel_id);
			}else{
				$condition = array('Restaurant.approved'=>$sel_id,"Restaurant.name LIKE" => '%'.$ser_term.'%');
			}
		}elseif($ser_term==''&&$sel_id!=''){
			$condition = array('Restaurant.approved'=>$sel_id);
		}else{
			$condition = array('Restaurant.name !='=>'');
		}			
		$this->Restaurant->updateAll(array(
					'Restaurant.approved' =>$approved),
					array('Restaurant.id' => $id)
				);
		$this->paginate = array(
			'conditions'=>$condition,
			'fields'=>array(
				'name',
				'city',
				'approved',
				'rank',
				'slug_name'
			),
			'order'=>'name ASC',
			'limit'=>10
		);
		$cities=$this->City->find('list',array('fields'=>array('id','city_name')));
		$this->set(compact('cities'));
		$page = $this->paginate('Restaurant');
		$this->set('rest',$page);
		$this->set('sel_id',$sel_id);
		$this->set('ser_term',$ser_term);
	}
	function super_restaurant_change($sel_id=NULL,$ser_term=NULL){
	//pr($this->params);
	 $this->layout = NULL; 
	if($ser_term!=''){
		$condition = array('Restaurant.approved'=>$sel_id,"Restaurant.name LIKE" => '%'.$ser_term.'%');
	}
	else{
		$condition = array('Restaurant.approved'=>$sel_id,'Restaurant.name !='=>'');
	}
	if($sel_id == 2)
			$condition= array('Restaurant.name !='=>'');
	if($sel_id == 2 && $ser_term!='')
		    $condition = array("Restaurant.name LIKE" => '%'.$ser_term.'%');
			
	$this->paginate = array(
			'conditions'=>$condition,
			'fields'=>array(
				'name',
				'city',
				'approved',
				'rank',
				'slug_name'
			),
			'order'=>'name ASC',
			'limit'=>10
		);
		$page = $this->paginate('Restaurant');
		$this->set('rest',$page);
		$this->set('count',count($page));
		$this->set('sel_id',$sel_id);
		$this->set('ser_term',$ser_term);
	}
	
	function admin_profile(){
		App::import('Model','Cuisine');
		$start =  '05:00:00';
		$end = '23:30:00';
		$starttime=strtotime($start); 
		$endtime=strtotime($end); 
		$diff=abs(ceil(($endtime-$starttime)/1800));
		$options=array();
		for($i=0;$i<=$diff;$i++){
		$optionsval=date('H:i:s',$starttime);
		$options[$optionsval]=date('h:i A',$starttime);
		$starttime=$starttime+1800; 
		} 
		$this->set('options',$options);
		$this->loadmodel('City');
		$city = $this->City->find('list',array('fields'=>array('city_name')));
		$cityDetail = $this->City->find('first',array('fields'=>array('id','city_name'),'order'=>'city_name'));
		$city_id=$cityDetail['City']['id'];
		$this->set('city_name',$city);
		$this->Cuisine=new Cuisine();
		$id = $this->get_res_id();
		if(empty($id)){$id=$this->Restaurant->getLastInsertID();}
		$this->set(compact('id'));
		$rest_detail = $this->Restaurant->find('all',array(
                    'recursive'=>1,
                    'conditions'=>array(
                        'Restaurant.id'=>$id
                    ),
                    'fields'=>array(
                        'Restaurant.menu',
                        'Restaurant.startTime',
                        'Restaurant.endTime',
						'Restaurant.neighborhoodId'
                    )
		));
		if(!empty($rest_detail)){
                    if(!empty($rest_detail[0]['Restaurant']['menu']))
						$this->set('menu',$rest_detail[0]['Restaurant']['menu']);
					$this->loadmodel('Table');                    
                    if(!empty($this->data)){
                        $stime = $this->data['Restaurant']['startTime'];
                        $etime = $this->data['Restaurant']['endTime'];
                        $this->Table->delete_offer_time($stime,$etime,$id);
                    }
		}
		$this->Restaurant->bindModel(array('hasMany'=>array('Restaurantcuisine'=>array('foreignKey'=>'restaurant_id'))));
		$cusine_ids=$this->Restaurant->Restaurantcuisine->find('list',array('conditions'=>array('Restaurantcuisine.restaurant_id'=>$id),'fields'=>array('cuisine_id')));
		$neigh_id = $this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id),'fields'=>array('neighborhoodId'),'recursive'=>-1));
		$this->loadmodel('Neighborhood');
		$neigh_name_list = $this->Neighborhood->find('list',array('conditions'=>array('Neighborhood.city_id'=>$city_id),'fields'=>array('Neighborhood.name')));
		$neigh_name = $this->Neighborhood->find('list',array('conditions'=>array('Neighborhood.id'=>$neigh_id['Restaurant']['neighborhoodId']),'fields'=>array('Neighborhood.name')));
		$this->set('neigh_name_list',$neigh_name_list);
		$this->set('neighboor_name',$neigh_name);
		$this->set('cuisines',$this->Cuisine->find('list',array('conditions'=>array('Cuisine.id'=>$cusine_ids),'order'=>'name')));
		$this->Restaurant->unBindModel(array('hasMany'=>array('Restaurantcuisine')));
		$imagelist=$this->Restaurant->Slideshow->find('all',array('conditions'=>array('Slideshow.restaurant_id'=>$id),'order'=>'Slideshow.order_list'));	
		$this->set(compact('imagelist'));	
		$lastendtime = $this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$id)));
		$let = $lastendtime['Restaurant']['endTime'];
		if(!empty($this->data)){
                        $neighborhood_id = $this->data['Restaurant']['city'];
                        $this->loadmodel('Neighborhood');
                        $neighborhood = $this->Neighborhood->find('list',array('conditions'=>array('Neighborhood.city_id'=>$neighborhood_id)));
                        $this->set('neighboor_name',$neighborhood);
                        
			$this->data['Restaurant']['user_id'] = $this->Auth->user('id');
			$startTime = strtotime($this->data['Restaurant']['startTime']);
			$endTime = strtotime($this->data['Restaurant']['endTime']);
			$diff = $startTime - $endTime;
			$this->Restaurant->set($this->data['Restaurant']);
			if(empty($this->data['Restaurant']['logo']['name'])){
				$imagepathh=$restautant = $this->Restaurant->findByid($id);;
				$image_path=$imagepathh['Restaurant']['logo'];
			} 
			if($startTime!=$endTime && $diff<0){
				if(!empty($this->data['Restaurant']['neighborhoodId'])){
					if(!empty($this->data['Restaurant']['menu_link']))
						$this->data['Restaurant']['menu']='';
						$data=str_replace(" -","-",$this->data['Restaurant']['name']);
						$data=str_replace("&","",$data);
						$data=str_replace("'","",$data);
						$output = preg_replace("/[^[pace:]a-zA-Z0-9]/e", "", $data);
						$output = trim($output);
						$output = preg_replace('/\s/', '-', $output);
						$name = $output;
						$this->data['Restaurant']['slug_name']=$name;
                                                $id_city = $this->data['Restaurant']['city'];						
						$cityDetail = $this->City->find('first',array('conditions' => array('City.id' => $id_city),'fields'=>array('city_name'),'order'=>'city_name'));						
						$get_address = $this->data['Restaurant']['address'].' '.$cityDetail['City']['city_name'].' '.$this->data['Restaurant']['state'];
						$fget_address = str_replace(',', '', $get_address);
						$f2get_address = str_replace('.','', $fget_address);
						$address = str_replace(" ", "+", $f2get_address);
						$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
						$json = json_decode($json);
						if(!empty($json->{'results'}[0])){
						$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
						$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};        
						}else{
							$lat = '';
							$long = '';
						}
						$this->data['Restaurant']['latitude']=$lat;
						$this->data['Restaurant']['longitude']=$long;
					if($this->Restaurant->save($this->data)){
						$this->Session->setFlash(sprintf(__l('"%s" restaurant profile is updated successfully') , $this->data['Restaurant']['name']) , 'default', null, 'success');
						$this->redirect($this->referer());
					}	
				}else{
					$this->Session->setFlash('Neighborhood should not be empty' , 'default', null, 'error');
				}
			}
			else if($diff>0){
				$this->Session->setFlash('Start time cannot be more than End time' , 'default', null, 'error');
			}	
			else{
				$this->Session->setFlash('Start and End time cannot be equal' , 'default', null, 'error');
			}
                          
			if ($this->Restaurant->validates()) {
				if(!empty($this->data['Restaurant']['logo']['name'])){
					$image_path=$this->Image->upload_image_and_thumbnail($this->data['Restaurant'],'logo',300,126,'',true);
					unset($this->data['Restaurant']['logo']);
				}
				$this->Restaurant->set('logo',$image_path);
					$this->set('image_path',$image_path);
				}else{
					//$errors = $this->Restaurant->invalidFields(); 
				}
			//echo 'hai';
			$this->set('flag', 1); 
		}else{
			$this->data = $this->Restaurant->read(null,$id);
			$image_path=$this->data['Restaurant']['logo'];
			$this->set('image_path',$image_path);
			$neighborhood_id = $this->data['Restaurant']['city'];
			$this->loadmodel('Neighborhood');
			$neighborhood = $this->Neighborhood->find('list',array('conditions'=>array('Neighborhood.city_id'=>$neighborhood_id)));
			$this->set('neighboor_name',$neighborhood);
		}
	}
	
	function admin_shortdescription($id=null){
		$this->layout='adminpopup';
		if(!empty($this->data)){
			$this->Restaurant->id =$this->data['Restaurant']['id'];
			$this->Restaurant->save($this->data);
		}else{
			$this->data = $this->Restaurant->read(null,$id);
		}
	}
	function admin_longdescription($id=null){
		$this->layout='adminpopup';
		if(!empty($this->data)){
			$this->Restaurant->id =$this->data['Restaurant']['id'];
			$this->Restaurant->save($this->data);
		}else{
			$this->data = $this->Restaurant->read(null,$id);
		}
	}
	function admin_slideshow($id=null){
		$this->layout='adminpopup';
		$imagelist=$this->Restaurant->Slideshow->find('all',array('conditions'=>array('Slideshow.restaurant_id'=>$id),'order'=>'Slideshow.order_list'));
		$this->set(compact('imagelist'));	
	}
	
	function admin_upload_logo(){
		$this->layout='adminpopup';
		$id = $this->get_res_id(); 
		$this->set(compact('id'));
                App::import('Component','Images');
                $Images_thumb = new ImagesComponent;
                $Images_thumb->set_paths(WWW_ROOT . 'img/original/', WWW_ROOT . 'img/medium/'); 
                $Images_thumb->width=150;
                $Images_thumb->height=107;
		if(!empty($this->data)){
			$this->Restaurant->set($this->data);
			$error = $this->data['Restaurant']['path']['error'];
			if(empty($this->data['Restaurant']['path']['name'])){
				$image_path=$this->data['Restaurant']['path']['name'];
			}
			if ($this->Restaurant->validates()) {
			
				if(!empty($this->data['Restaurant']['path']['name'])){
					list($width,$height,$type, $attr)=getimagesize($this->data['Restaurant']['path']['tmp_name']);
					if($width>130 && $height >130){
						$image_path=$this->Image->upload_image_and_thumbnail($this->data['Restaurant'],'path',300,134,160,'',true);
						unset($this->data['Restaurant']['path']);
                                                $image_des=Router::url('/img/original/'.$image_path,true);
                                                $thump= $Images_thumb->thumb_file($image_des,$image_path);
						$this->Restaurant->set('logo',$thump);                                                
						$this->Restaurant->id=$id;
						$this->Restaurant->save();
						$this->set('image_path',$image_path);
						$this->Session->setFlash(sprintf(__l('Restaurant logo updated successfully') , $this->data) , 'default', null, 'success');
						$this->set('image_path1',$image_path);
					}else{
						$this->Session->setFlash(sprintf(__l('Image width should be greater than 130 and height also') , $this->data) , 'default', null, 'error');
					}
				}
				else{
					$this->Session->setFlash(sprintf(__l('Select logo') , $this->data) , 'default', null, 'error');
				}
				
			}
		}
		else{
			$this->data = $this->Restaurant->read(null,$id);
			if(!empty($this->data['Restaurant']['logo']['name'])){
				$image_path=$this->data['Restaurant']['logo']['name'];
			}
			else{
				$image_path = '';
			}
			$this->set('image_path',$image_path);
		}
	}
	
	function admin_edit_email(){
		$this->layout='adminpopup';
		$id = $this->get_res_id(); 
		$this->set('id',$id);
		$this->loadModel('User');
		if(empty($this->data)){
			$receive_res = $this->Restaurant->find('first',array('fields'=>array('user_id'),'conditions' => array('Restaurant.id' => $id)));
			$res_id = $receive_res['Restaurant']['user_id'];
			$receive_user = $this->User->find('first',array('fields'=>array('email','id'),'conditions' => array('User.id' => $res_id)));
			$this->set('user_id',$receive_user['User']['id']);
			$this->set('user_email',$receive_user['User']['email']);
			$this->Session->write('user_id',$receive_user['User']['id']);
		}
		if(!empty($this->data)){
			 $password = trim($this->data['User']['passwd']);
			 $fields=array('email');
			if(!empty($password)){
				$this->data['User']['password'] = $this->Auth->password($password);
				 $fields=array('email','password');
			 }else{
			 	unset($this->data['User']['password']);
				unset($this->data['User']['passwd']);
			 }
			 $this->User->set($this->data);
			if($this->User->validates(array('fieldList' =>$fields))){
				$name_sus = $this->User->Save($this->data);
				if($name_sus)
					$this->Session->setFlash(sprintf(__l('Your account updated successfully') , $this->data) , 'default', null, 'success');
				else
					$this->Session->setFlash(sprintf(__l('Your account doesn\'t updated successfully. please try agian') , $this->data) , 'default', null, 'error');
			}else{
				$this->Session->setFlash(sprintf(__l('Your account doesn\'t updated successfully. please try agian') , $this->data) , 'default', null, 'error');
			}
		}
	}
	function admin_add_email(){
		$this->layout='adminpopup';
		$id = $this->get_res_id(); 
		$this->set('id',$id);
		$this->loadModel('Recipient');
                 $rec=$this->Recipient->find('all',array('conditions'=>array('resId'=>$id)));
		$this->set('recipient',$rec);
                $rec_count=$this->Recipient->find('count',array('conditions'=>array('resId'=>$id)));
                 $this->set('rec_count',$rec_count);
		if(!empty($this->data)){
			 $this->Recipient->set($this->data);
			if($this->Recipient->validates()){
                            $this->data['Recipient']['resId']=$id;
                            $name_sus = $this->Recipient->Save($this->data);
                            if($name_sus)
					$this->Session->setFlash(sprintf(__l('Recipient email added successfully') , $this->data) , 'default', null, 'success');
				else
					$this->Session->setFlash(sprintf(__l('Recipient email doesn\'t added successfully. please try agian') , $this->data) , 'default', null, 'error');
			$rec_count=$this->Recipient->find('count',array('conditions'=>array('resId'=>$id)));
                        $this->set('rec_count',$rec_count);
                        $rec=$this->Recipient->find('all',array('conditions'=>array('resId'=>$id)));
                        $this->set('recipient',$rec);
                        }else{
                            $errors = $this->Recipient->validationErrors['email'];
                            $this->Session->setFlash(sprintf(__l($errors) , $this->data) , 'default', null, 'error');
			}
		}
	}
        function admin_remove_email($recid=null){ 
                $this->loadModel('Recipient');
                if($recid!=null){
                    $this->Recipient->deleteAll(array('Recipient.id'=>$recid));                    
                    $this->Session->setFlash(sprintf(__l('Recipient email deleted successfully') , $this->data) , 'default', null, 'success');
                    $this->redirect('add_email');
                }
	}
	function admin_changeneighboor(){
		$this->layout = false;
		$val = $this->params['form']['val'];
		$this->loadmodel('Neighborhood');
		$neighborhood = $this->Neighborhood->find('list',array('conditions'=>array('Neighborhood.city_id'=>$val)));
		$this->set('neighborhood',$neighborhood);
	}
	function admin_uploadmenu(){
		$this->layout='adminpopup';
		$id = $this->get_res_id(); 
		$this->set(compact('id'));
		//print_r($this->data);
//		exit;
		if(!empty($this->data)){	
			$this->Restaurant->set($this->data);
			$error = $this->data['Restaurant']['pdfpath']['error'];
			if(empty($this->data['Restaurant']['pdfpath']['name'])){
				$image_path=$this->data['Restaurant']['pdfpath']['name'];
			}
			if ($this->Restaurant->validates()) {
				if(!empty($this->data['Restaurant']['pdfpath']['name'])){
						 $tempuploaddir = "img/profilemenu";
						 $id_unic = str_replace(".", "", strtotime ("now"));
                    	 $filename = $id_unic;
						 $filename.= ".";
						 $check=0;
					if($this->data['Restaurant']['pdfpath']['type']=='application/pdf'){
						 $filename.="pdf";
						  $check=1;
					  }else if($this->data['Restaurant']['pdfpath']['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
					  	 $filename.="docx";
						  $check=1;
					  }else if($this->data['Restaurant']['pdfpath']['type']=='application/vnd.ms-word'){
					  	  $filename.="doc";
						  $check=1;
					  }else if($this->data['Restaurant']['pdfpath']['type']=='text/plain'){
					  	 $filename.="txt";
						 $check=1;
					  }
						
                   		if(!empty($check)&&$check==1){
							 $tempfile = $tempuploaddir . "/$filename";
							if (is_uploaded_file($this->data['Restaurant']['pdfpath']['tmp_name']))
								{
										if (!copy($this->data['Restaurant']['pdfpath']['tmp_name'],"$tempfile"))
										{
											$this->Session->setFlash(sprintf(__l('Error Uploading File!.') , $this->data) , 'default', null, 'error');
											exit();
										}
									unset($this->data['Restaurant']['pdfpath']);
									$this->Restaurant->set('menu',$filename);
									$this->Restaurant->id=$id;
									$this->Restaurant->save();
									//$this->set('image_path',$tempfile);
									$this->set('filename',$filename);
									$this->Session->setFlash(sprintf(__l('Restaurant menu updated successfully') , $this->data) , 'default', null, 'success');}
						}else{
							$this->Session->setFlash(sprintf(__l('Please Upload pdf,docx,doc,txt only') , $this->data) , 'default', null, 'error');
						}
				}
				else{
					$this->Session->setFlash(sprintf(__l('Please Select pdf file') , $this->data) , 'default', null, 'error');
				}
				
			}
		}
		else{
			$this->data = $this->Restaurant->read(null,$id);
			if(!empty($this->data['Restaurant']['logo']['name'])){
				$image_path=$this->data['Restaurant']['logo']['name'];
			}
			else{
				$image_path = '';
			}
			$this->set('image_path',$image_path);
		}
	}
	function super_res_del($id=null,$sel_id=null,$ser_term=null){
		$this->loadmodel('Alert');
		$this->loadmodel('User');
		$this->loadmodel('Userlocation');
		$user_id=$this->Restaurant->find('list', array(
				'conditions' => array(
					'Restaurant.id' => $id
               	 ) ,
                'fields' => array(
                        'Restaurant.user_id'
					)
				,'recursive'=>-1
				));
		$Userloc=$this->Userlocation->find('list', array(
				'conditions' => array(
					'Userlocation.userId' => $user_id
               	 ) ,
                'fields' => array(
                        'Userlocation.id'
					)
				,'recursive'=>-1
				));
		if(!empty($user_id)){
			$this->Userlocation->deleteAll($Userloc,true);
			$this->User->delete($user_id,true);
			$this->Alert->deleteAll($id,true);
			$this->Restaurant->delete($id,true);
			$this->Session->setFlash(sprintf(__l('Restaurant deleted successfully')) , 'default', null, 'success');
		}
		if($ser_term!=''&&$sel_id!=''){
			if(is_numeric($ser_term)){
				$condition = array('Restaurant.approved'=>$sel_id);
			}else{
				$condition = array('Restaurant.approved'=>$sel_id,"Restaurant.name LIKE" => '%'.$ser_term.'%');
			}
		}elseif($ser_term==''&&$sel_id!=''){
			$condition = array('Restaurant.approved'=>$sel_id);
		}else{
			$condition = array('Restaurant.name !='=>'');
		}	
		$this->paginate = array(
			'conditions'=>$condition,
			'fields'=>array(
				'name',
				'city',
				'approved',
				'rank'
			),
			'order'=>'name ASC',
			'limit'=>10
		);
		$cities=$this->City->find('list',array('fields'=>array('id','city_name')));
		$this->set(compact('cities'));
		$page = $this->paginate('Restaurant');
		$this->set('rest',$page);
		$this->set('sel_id',$sel_id);
		$this->set('ser_term',$ser_term);
	}
	function super_restaurant_rank(){
		$this->layout = 'ajax';
		$restaurant_id=$this->params['form']['restId'];
		$rank=$this->params['form']['rank_value'];
		$this->Restaurant->id = $restaurant_id;
		$this->data['Restaurant']['rank']=$rank;
		$this->Restaurant->save($this->data);
		
		$this->Session->setFlash('Restaurant rank updated successfully' , 'default', null, 'success');
		//$this->autorender=false;
	//echo 'hai';
		
		//exit;
	}
}