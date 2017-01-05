<?php
class WebsitesController extends AppController{
	var $name = 'website';
	var $components=array('Image');
	var $uses=array('Website');
	function super_index(){
		$this->layout = 'superadmin';
		$this->paginate = array(
			'order'=>'created Desc',
			'limit'=>2
		);
		$websites = $this->paginate('Website');
		$this->set('websites',$websites);
	}
	function super_websiteadd(){
		$this->layout = 'adminpopup';
		if(!empty($this->data)){
			$this->Website->set($this->data);
			if($this->Website->validates()){
				$this->data['Website']['city_id']=Configure::read('website.city_id');
				$this->data['Website']['website_slug']=Inflector::slug(strtolower($this->data['Website']['website_name']),'_');
				$this->data['Website']['active'] = 1;
				/***********Website Logo add**************/
				list($width,$height,$type, $attr)=getimagesize($this->data['Website']['website_logo']['tmp_name']);
				if($width>150){
					$website_logo_path = $this->Image->upload_image_and_thumbnail($this->data['Website'],"website_logo",400,126,268,'',true);
					$this->data['Website']['website_logo']=$website_logo_path;
					 /***********Email Logo update**************/
					list($width,$height,$type, $attr)=getimagesize($this->data['Website']['email_logo']['tmp_name']);
					if($width>150){
						$email_logo_path = $this->Image->upload_image_and_thumbnail($this->data['Website'],"email_logo",400,126,268,'',true);
						$this->data['Website']['email_logo']=$email_logo_path;
						$this->Website->save($this->data);
						$this->Session->setFlash(sprintf(__l('Website can be added successfully') , $this->data) , 'default', null, 'success');
						$redirect_url=Router::url(array('controller'=>'websites','action'=>'index','super'=>true),true);
						echo '<script type="text/javascript">parent.window.location.href="'.$redirect_url.'"</script>';
						$this->autoRender=false;
					}else{
						$this->Session->setFlash(sprintf(__l('Email logo image width should be greater than 130 and height also') , $this->data) , 'default', null, 'error');
					}
					
				 }else{
				 	$this->Session->setFlash(sprintf(__l('Website image width should be greater than 130 and height also') , $this->data) , 'default', null, 'error');
				 }
			}
		}
	}
	function super_websiteedit($id){
		$this->layout = 'adminpopup';
		if(!empty($this->data)){
			$this->Website->set($this->data);
			if(empty($this->data['Website']['email_logo']['name'])){
				unset($this->data['Website']['email_logo']);
				unset($this->Website->validate['email_logo']);
			 }
			if(empty($this->data['Website']['website_logo']['name'])){
				unset($this->data['Website']['website_logo']);
				unset($this->Website->validate['website_logo']);
			 }
			if($this->Website->validates()){
				$this->data['Website']['city_id']=Configure::read('website.city_id');
				$image_old=$this->Website->findByid($this->data['Website']['id']);
				$this->data['Website']['website_slug']=$image_old['Website']['website_slug'];
				$this->data['Website']['active'] = 1;
				$error=0;
				
				/***********Website Logo update**************/
				if(!empty($this->data['Website']['website_logo']['name'])){
					list($width,$height,$type, $attr)=getimagesize($this->data['Website']['website_logo']['tmp_name']);
					if($width>150){
						$website_logo_path = $this->Image->upload_image_and_thumbnail($this->data['Website'],"website_logo",400,126,268,'',true);
						$this->data['Website']['website_logo']=$website_logo_path;
					 }else{
						$this->Session->setFlash(sprintf(__l('Image width should be greater than 130 and height also') , $this->data) , 'default', null, 'error');
						$error=1;
					 }
				 }else{
					$this->data['Website']['website_logo']=$image_old['Website']['website_logo'];
				 }
				 /***********Email Logo update**************/
				if(!empty($this->data['Website']['email_logo']['name'])){
					list($width,$height,$type, $attr)=getimagesize($this->data['Website']['email_logo']['tmp_name']);
					if($width>150){
						$email_logo_path = $this->Image->upload_image_and_thumbnail($this->data['Website'],"email_logo",400,126,268,'',true);
						$this->data['Website']['email_logo']=$email_logo_path;
					}else{
						$this->Session->setFlash(sprintf(__l('Image width should be greater than 130 and height also') , $this->data) , 'default', null, 'error');
						$error=1;
					}
				 }else{
				 	$this->data['Website']['email_logo']=$image_old['Website']['email_logo'];
				 }
				 	/***********Error find any logo update**************/
				 	if($error!=1)
				 		$this->Session->setFlash(sprintf(__l('Website can be updated successfully') , $this->data) , 'default', null, 'success');
					$this->Website->save($this->data);
					$redirect_url=Router::url(array('controller'=>'websites','action'=>'index','super'=>true),true);
					echo '<script type="text/javascript">parent.window.location.href="'.$redirect_url.'"</script>';
					$this->autoRender=false;
					
			}
				
			
		}else{
			if(!empty($id)){
				$this->data=$this->Website->findByid($id);
			}
		}
	}
	function super_websitedelete($id){
		if(!empty($id)){
				$unlink_image_old=$this->Website->findByid($id);
				$this->Image->delete_image($unlink_image_old['Website']['website_logo']);
				$this->Image->delete_image($unlink_image_old['Website']['email_logo']);
				$this->Website->delete($id);
				$this->Session->setFlash(sprintf(__l('Website can be deleted successfully') , $this->data) , 'default', null, 'success');
				$redirect_url=Router::url(array('controller'=>'websites','action'=>'index','super'=>true),true);
				$this->redirect($redirect_url);
		}
	}
	function super_websiteapproved(){
		$id=$this->params['form']['id'];
		$approved=$this->params['form']['approved'];
		$this->Website->read(null,$id);
		$this->Website->set('active',$approved);
		$this->Website->save();
		if(!empty($approved))
			echo $message='<div class="message" id="successMessage" style="display: block;">Website can be activated successfully</div>';
		else
			echo $message='<div class="message" id="successMessage" style="display: block;">Website can be deactivated successfully</div>';
		//$this->Session->setFlash(sprintf(__l('Website can be updated successfully') , $this->data) , 'default', null, 'success');
		$this->autoRender=false;
	}
	function super_websitestatus(){
		$this->layout=false;
		$conditions=array();
		$conditions['active']=(!empty($this->params['form']['status'])&&$this->params['form']['status']==2)?array(0,1):$this->params['form']['status'];
		if(!isset($this->params['form']['status']))
			unset($conditions['active']);
			
		$this->paginate = array(
			'conditions'=>$conditions,
			'order'=>'created Desc',
			'limit'=>2
		);
		$websites = $this->paginate('Website');
		$this->set('websites',$websites);
	}
}
?>