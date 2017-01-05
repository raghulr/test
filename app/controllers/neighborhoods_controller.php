<?php
class NeighborhoodsController extends AppController{
	var $name = 'Neighborhood';
	
	function admin_add(){
		$this->layout='adminpopup';
		$this->set('title_for_popup','Add Neighborhood'); 
		if(!empty($this->data)){
			$this->Neighborhood->set($this->data);
			if ($this->Neighborhood->validates()) {
				$this->Neighborhood->save();
				$this->Session->setFlash(sprintf(__l('"%s" Neighborhood has been added') , $this->data['Neighborhood']['name']) , 'default', null, 'success');
			}else{
				//$this->Session->setFlash(sprintf(__l('"%s" Neighborhood could not be added. Please, try again.') , $this->data['Neighborhood']['name']) , 'default', null, 'error');
			}
		}	
	}
	function admin_update(){
		$this->autoLayout=false;
		$this->set('neighborhood',$this->Neighborhood->find('list'));
	}
	function super_index(){
		$this->layout = 'superadmin';
		$this->loadmodel('City');
		$city = $this->City->find('list',array('fields'=>array('city_name'),'order'=>'city_name'));
		$this->set('city_name',$city);
		$city_id = $this->City->find('first',array('fields'=>array('id'),'order'=>'city_name'));
		$id = $city_id['City']['id'];
		$this->loadmodel('Neighborhood');
                $this->paginate = array('conditions'=>array('city_id'=>$id), 'order'=>'name','limit'=>10);
		$neighbor = $this->paginate('Neighborhood');
		$this->set('neighbor_name',$neighbor);
	}	
	function super_city(){
                if(!empty($this->params['form']['id']))
                    $city_id = $this->params['form']['id'];
                else
                    $city_id = $this->params['named']['city'];
                //$city_id = ;
		$this->loadmodel('Neighborhood');
                $this->paginate = array('conditions'=>array('city_id'=>$city_id), 'limit'=>10);
		$neighbor = $this->paginate('Neighborhood');
		$this->set('neighbor_name',$neighbor);
	}
	function super_rescity(){
		$this->layout='adminpopup';
		$this->loadmodel('City');
		$city = $this->City->find('all');
		$this->set('city_name',$city);
	}
	function super_add_city(){
                $this->layout = 'adminpopup';                               
		if(!empty($this->data)){
                    $this->loadmodel('City');
                    $city = $this->City->find('count', array('conditions'=>array('City.city_name'=>$this->data['City']['city_name'])));
                    $city_name = trim($this->data['City']['city_name']);
                    if(!empty($city_name)){
                        if($city <=0){
                            $this->City->set($this->data);
                            if ($this->City->validates()) {
                                $this->City->save();
                                $this->Session->setFlash(sprintf(__l('"%s" City has been added') , $this->data['City']['city_name']) , 'default', null, 'success');
                            }                       
                        }else{
                            $this->Session->setFlash(sprintf(__l('"%s" City was already exist') , $this->data['City']['city_name']) , 'default', null, 'error');
                        }  
                    }else{
                        $this->Session->setFlash("City was should not empty" , 'default', null, 'error');
                    }    
                }
	}
	function add_city(){
		$this->layout = 'ajax';
		if(!empty($this->data['Neighborhood']['city_name'])){
			$this->data['City']['city_name'] = $this->data['Neighborhood']['city_name'];
			$this->loadmodel('City');
			$city_name = $this->City->find('count',array(
				'conditions'=>array(
					'city_name'=>$this->data['City']['city_name']
				)
			));
			$this->City->create();		
			if ($this->City->validates()) {	
				if($city_name == 0){		
					$this->City->save($this->data);
					$this->Session->setFlash(sprintf(__l('"%s" City Name has been added') , $this->data['City']['city_name']) , 'default', null, 'success');
				} else  {
					$this->Session->setFlash(sprintf(__l('"%s" City Name already exist') , $this->data['City']['city_name']) , 'default', null, 'success');
				}
			
			}else{
				$this->Session->setFlash(sprintf(__l('"%s" City could not be added. Please, try again.') , $this->data['Neighborhood']['city_name']) , 'default', null, 'error');
			}
		}else{
			$this->Session->setFlash(sprintf(__l('"%s" City could not be added. Please, try again.') , $this->data['Neighborhood']['city_name']) , 'default', null, 'error');
		}
	}
	function super_add(){
		$this->layout = 'adminpopup';
                $this->loadmodel('City');
                $city = $this->City->find('list',array('fields'=>array('city_name'),'order'=>'city_name'));
                $this->set('city',$city);
		if(!empty($this->data)){
			$this->data['Neighborhood']['name'] = $this->data['Neighborhood']['name'];
			$NeighborhoodName = $this->Neighborhood->find('count',array(
				'conditions'=>array(
					'name'=>$this->data['Neighborhood']['name']
				)
			));
			if($NeighborhoodName == 0){
				$this->Neighborhood->set($this->data);
				if ($this->Neighborhood->validates()) {
					$this->Neighborhood->save();
					$this->Session->setFlash(sprintf(__l('"%s" Neighborhood has been added') , $this->data['Neighborhood']['name']) , 'default', null, 'success');
				}else{
					$this->Session->setFlash(sprintf(__l('"%s" Neighborhood could not be added. Please, try again.') , $this->data['Neighborhood']['name']) , 'default', null, 'error');
				}
			}else{
				$this->Session->setFlash(sprintf(__l('"%s" Neighborhood name already exist') , $this->data['Neighborhood']['name']) , 'default', null, 'success');
			}
		}
	}
	function super_update_city(){
		if($this->params){	
		   $this->set('id',$this->params['form']['id']);
			 $NeighborhoodName = $this->Neighborhood->find('count',array(
					'conditions'=>array(
						'name'=>$this->params['form']['name']
					)
				));
			if($NeighborhoodName == 0){
			   $this->Neighborhood->updateAll(array('Neighborhood.name' =>"'".mysql_escape_string($this->params['form']['name'])."'"),array('Neighborhood.id' => $this->params['form']['id']));
			   $this->Session->setFlash(sprintf(__l('"%s" Neighborhood has been Updated') , $this->params['form']['name']) , 'default', null, 'success');
			   }else{
			   		$this->Session->setFlash(sprintf(__l('"%s" Neighborhood name already exist') , $this->params['form']['name']) , 'default', null, 'error');
			   }
		 } else {
		 	$this->Session->setFlash(sprintf(__l('"%s" Neighborhood could not be Updated. Please, try again.') , $this->params['form']['name']) , 'default', null, 'error');
		 }
		 	$this->paginate = array('conditions'=>array('city_id'=>$this->params['form']['city_id']),  'order'=>'name','limit'=>10);
			$neighbor = $this->paginate('Neighborhood');
		  // $neighbor = $this->Neighborhood->find('all',array('conditions'=>array('city_id'=>$this->params['form']['city_id'])));
		   $this->set('neighbor_name',$neighbor);
	}
	function super_update_rescity(){
		$this->loadmodel('City');
		if($this->params){	
		   $this->set('id',$this->params['form']['id']);
		   $city_id=$this->City->find('count',array('conditions'=>array('city_name'=>$this->params['form']['name'])));
			   if($city_id==0){
				   $this->City->updateAll(array('City.city_name' =>"'".mysql_escape_string($this->params['form']['name'])."'"),array('City.id' => $this->params['form']['id']));
				   $this->Session->setFlash(sprintf(__l('"%s" City has been Updated') , $this->params['form']['name']) , $this->params['form']['name'],'default', null, 'success');
			   }else{
			   		 $this->Session->setFlash(sprintf(__l('"%s" City name is already existing') , $this->params['form']['name']) , $this->params['form']['name'],'default', null, 'error');
			   }
		 } else {
		 	$this->Session->setFlash(sprintf(__l('"%s" City could not be Updated. Please, try again.') , $this->params['form']['name']) , 'default', null, 'error');
		 }
		   $neighbor = $this->City->find('all');
		   $this->set('city_name',$neighbor);
	}
	function super_delete_city(){
		$id = $this->params['pass'][0];
                if(!empty($this->data['Neighborhood']['city_id']))
                    $city_id  = $this->data['Neighborhood']['city_id'];
                else
                    $city_id = $this->params['named']['city'];
		$this->loadmodel('Restaurant');
		$count = $this->Restaurant->find('count',array('conditions'=>array('neighborhoodId'=>$id)));
		if($count==0){
			$this->Neighborhood->delete($id);
			$this->Session->setFlash('Neighborhood has been deleted successfully' , 'default', null, 'success');
		}
		else{
		  $this->Session->setFlash('Neighborhood could not be Delete' , 'default', null, 'success');
		}
		$this->loadmodel('Neighborhood');
                $this->paginate = array('conditions'=>array('city_id'=>$city_id), 'order'=>'name', 'limit'=>10);
		$neighbor = $this->paginate('Neighborhood');
		$this->set('neighbor_name',$neighbor);
	}
	function super_delete_rescity(){
		$id = $this->params['form']['id'];
		$this->loadmodel('City');
		$count = $this->Neighborhood->find('count',array('conditions'=>array('city_id'=>$id)));
		if($count<=0):
			if($this->City->delete($id)) {
				$this->Session->setFlash('City has been Deleted' , 'default', null, 'success');
			}
			else{
			  $this->Session->setFlash('City could not be Delete' , 'default', null, 'error');
			}
			else:
				 $this->Session->setFlash('City could not be Delete because neighborhood assigned to selected city.' , 'default', null, 'error');
		endif;	 
		$this->loadmodel('City');
		$neighbor = $this->City->find('all');
		$this->set('city_name',$neighbor);
	}
	function super_cancel_city(){
		$this->loadmodel('Neighborhood');
		$neighbor = $this->Neighborhood->find('all',array('conditions'=>array('city_id'=>$this->data['Neighborhood']['city_id'])));
		$this->set('neighbor_name',$neighbor);
	}
	
	function super_revert_city(){
		$this->paginate = array('conditions'=>array('city_id'=>$this->params['form']['city_id']),  'order'=>'name','limit'=>10);
		$neighbor = $this->paginate('Neighborhood');
		//$neighbor = $this->Neighborhood->find('all',array('conditions'=>array('city_id'=>$this->params['form']['city_id'])));
		$this->set('neighbor_name',$neighbor);
	}
	function super_revert_rescity(){
		$this->loadmodel('City');
		$neighbor = $this->City->find('all');
		$this->set('city_name',$neighbor);
	}
	
}