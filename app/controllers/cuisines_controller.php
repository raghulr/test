<?php
class CuisinesController extends AppController{
	var $name = 'Cuisine';
	
	function admin_index(){
		$this->set('title_for_popup','EDIT CUISINE'); 
		$this->layout='adminpopup';
		$this->set('cuisines',$this->Cuisine->find('list',array('order'=>'name')));
		App::import('Model','Table'); 
		$instance = new Table();
		$id=$instance::getRestaurantId();
		$this->Cuisine->bindModel(array('hasMany'=>array('Restaurantcuisine'=>array('foreignKey'=>'cuisine_id'))));
		$this->set('data',$this->Cuisine->Restaurantcuisine->find('list',array('conditions'=>array('Restaurantcuisine.restaurant_id'=>$id),'fields'=>array('cuisine_id'))));
		$this->Cuisine->unBindModel(array('hasMany'=>array('Restaurantcuisine')));
	}
	
	function admin_add(){
		$this->layout='adminpopup';
		$this->set('title_for_popup','ADD CUISINE'); 
		if(!empty($this->data)){
			$this->Cuisine->set($this->data);
			if ($this->Cuisine->validates()) {
				$this->Cuisine->save();
				$this->Session->setFlash(sprintf(__l('"%s" Cuisine has been added') , $this->data['Cuisine']['name']) , 'default', null, 'success');
			}else{
				//$this->Session->setFlash(sprintf(__l('"%s" Neighborhood could not be added. Please, try again.') , $this->data['Neighborhood']['name']) , 'default', null, 'error');
			}
		}
	}
	function super_add(){
           $this->layout='adminpopup'; 
           if(!empty($this->data)){
                $this->Cuisine->set($this->data);
                if ($this->Cuisine->validates()) {
                        $this->Cuisine->save();
                        $this->Session->setFlash(sprintf(__l('"%s" Cuisine has been added') , $this->data['Cuisine']['name']) , 'default', null, 'success');
                }
            }
        }
	function admin_update_cuisines(){
		$this->set('title_for_popup','ADD CUISINE'); 
		$this->layout='adminpopup';
		$this->Cuisine->bindModel(array('hasMany'=>array('Restaurantcuisine'=>array('foreignKey'=>'cuisine_id'))));
		if(!empty($this->data)){
			App::import('Model','Table'); 
			$instance = new Table();
			$id=$instance::getRestaurantId();
			$conditions=array('Restaurantcuisine.restaurant_id'=>$id);
			$this->Cuisine->Restaurantcuisine->deleteAll($conditions,$cascade = true); 
			foreach($this->data['Cuisine']['id'] as $cuisines=>$cuisine):
				$this->data['Restaurantcuisine']['cuisine_id'] = $cuisine;
				$this->data['Restaurantcuisine']['restaurant_id'] = $id;
				$this->Cuisine->Restaurantcuisine->create();
				$this->Cuisine->Restaurantcuisine->save($this->data);
			endforeach;			
		}	
		$this->set('cuisines',$this->Cuisine->find('list'));
		if(!empty($this->data['Cuisine']['id'])){
			$name=$this->Cuisine->find('first',array('conditions'=>array('Cuisine.id'=>$this->data['Cuisine']['id']),'fields'=>array('Cuisine.name')));
			$newname=$name['Cuisine']['name'];
			$this->set('newname',$newname);
			$this->Session->setFlash('Cuisine has been updated successfully' , 'default', null, 'success');
			$url=Router::url(array('controller'=>'restaurants','action'=>'profile','prefix'=>'admin'),true);
			echo '<script type="text/javascript">
				//$(".message").css({display:"block"});
				//$("#successMessage").html("Cuisine has been updated successfully");
				$("#successMessage").fadeTo(500,0.5,function(){
					parent.$("#change_cusine").text("'.$newname.'");
					parent.$.colorbox.close();
				});
				
			</script>';
			//$this->autoRender=false;
			//$this->redirect(array('controller'=>'restaurants','action'=>'profile','prefix'=>'admin'));
		}else{
			$this->Session->setFlash('Please select a Cuisine to update' , 'default', null, 'success');
		}
		$this->Cuisine->unBindModel(array('hasMany'=>array('Restaurantcuisine')));
		//$this->autoRender=false;
	}
	
	function admin_edit(){
		$this->layout='adminpopup';
		if(!empty($this->data)){
			$this->Cuisine->set($this->data);
			if ($this->Cuisine->validates()) {
				$this->Cuisine->save();
				$this->Session->setFlash(sprintf(__l('"%s" Cuisine has been added') , $this->data['Cuisine']['name']) , 'default', null, 'success');
			}else{
				//$this->Session->setFlash(sprintf(__l('"%s" Neighborhood could not be added. Please, try again.') , $this->data['Neighborhood']['name']) , 'default', null, 'error');
			}
		}
	}
	
	function super_index(){
		$this->layout = 'superadmin';
		//pr($this->params);
		//$cuisines = $this->Cuisine->find('all');
		$this->paginate = array(
			'order'=>'name ASC',
			'limit'=>10
		);
		$cuisines = $this->paginate('Cuisine');
		$this->set('cuisines',$cuisines);
	}
	
	function add_cuisine(){
		$this->data['Cuisine']['name'] = $this->params['form']['cuisine_name'];
		if(!empty($this->data['url']['page'])) { $page = $this->data['url']['page']; }
		//$this->layout = 'ajax';
		if(!empty($this->data)){
			$cuisine_name = $this->Cuisine->find('count',array(
				'conditions'=>array(
					'name'=>$this->data['Cuisine']['name']
				)
			));
			if($cuisine_name == 0){
				$this->Cuisine->set($this->data);
				unset($this->Cuisine->validate['name']['rule3']);
				if ($this->Cuisine->validates()) {
					$this->Cuisine->save();
					$this->Session->setFlash(sprintf(__l('"%s" Cuisine has been added') , $this->data['Cuisine']['name']) , 'default', null, 'success');
					echo "<script> setTimeout(parent.$.colorbox.close, 500) </script>";
				}else{
					$this->Session->setFlash(sprintf(__l('Cuisine could not be added. Please, try again.')) , 'default', null, 'error');
				}
			}else{
				$this->Session->setFlash(sprintf(__l('"%s" Cuisine name already exist') , $this->data['Cuisine']['name']) , 'default', null, 'error');
			}
		}
		//$cuisines = $this->Cuisine->find('all');
		$this->paginate = array(
			'order'=>'name ASC',
			'limit'=>10
			//'page'=>$page
		);
		$cuisines = $this->paginate('Cuisine');
		$this->set('cuisines',$cuisines);
	}
	
	function super_update_cuisine(){
		   $this->data['Cuisine']['name'] = $this->params['form']['name'];
		   $this->set('id',$this->params['form']['id']);
		   $cuisine_name = $this->Cuisine->find('count',array(
				'conditions'=>array(
					'name'=>$this->data['Cuisine']['name']
				)
			));
			if($cuisine_name == 0){
		  		 $this->Cuisine->updateAll(array('Cuisine.name' =>"'".mysql_escape_string($this->params['form']['name'])."'"),array('Cuisine.id' => $this->params['form']['id']));
				 $this->Session->setFlash(sprintf(__l('"%s" Cuisine has updated successfully') , $this->params['form']['name']) , 'default', null, 'success');
		   }else{
		   		$this->Session->setFlash(sprintf(__l('"%s" Cuisine name already exist') , $this->data['Cuisine']['name']) , 'default', null, 'error');
		   }
		   $this->paginate = array(
				'order'=>'name ASC',
				'limit'=>10
			);
			$cuisines = $this->paginate('Cuisine');
			$this->set('cuisines',$cuisines);
	}
	
	function super_delete_cuisine(){
		$id = $this->params['form']['id'];
		$page = $this->params['form']['page'];
		$this->loadmodel('Restaurantcuisine');
		$count = $this->Restaurantcuisine->find('count',array('conditions'=>array('cuisine_id'=>$id)));
		$count_del = $this->Cuisine->find('first',array('conditions'=>array('id'=>$id)));
		$cus_name = $count_del['Cuisine']['name'];
		if($count==0){
			$this->Cuisine->delete($id);
			$msg_wrd = 'Cusine deleted successfully' ;
			$this->set('msg',$msg_wrd);
			//$this->Session->setFlash('Cusine deleted successfully' , 'default', null, 'success');
			$this->Session->setFlash(sprintf(__l('"%s" Cuisine has been deleted successfully') , $cus_name) , 'default', null, 'success');
		}
		else{
		  //$this->Session->setFlash($cus_name.'is in use. You can not delete this cuisine' , 'default', null, 'success');	
		  //$this->set('msg_disp','$cus_name is in use. You can not delete this cuisine');
		  $this->Session->setFlash(sprintf(__l('"%s" already exist. You can not delete this cuisine') , $cus_name) , 'default', null, 'error');
		}
		$this->paginate = array(
			'order'=>'name ASC',
			'limit'=>10,
			'page'=>$page
		);
		$cuisines = $this->paginate('Cuisine');
		$this->set('cuisines',$cuisines);
	}
	
	function super_revert_cuisine(){
		$this->paginate = array(
			'order'=>'name ASC',
			'limit'=>10
		);
		$cuisines = $this->paginate('Cuisine');
		$this->set('cuisines',$cuisines);
	}
}