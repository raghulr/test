<?php 
//$redirectUrl = $this->Session->read('Auth.redirectUrl');
if(!empty($url)):
else:
$approved = $this->Auth->user('approved');
if($this->Auth->user('account_type')==3&&$approved==1) {  
	if(isset($string)&&!empty($string)){ 
		$url = $html->url(array(
			'controller' => 'homes',
			'action' => 'index',
			'admin' => false
		));
	}else if($approved==1){
		$chic=explode('/',$this->params['url']['url']);
		if($chic[0]=='chicago'){
			$url = $html->url(array(
				'controller' => 'profiles',
				'action' => 'index',
				'chicago' => true,
				'?' => 'success=success'
			));
		}else{
			$url = $html->url(array(
				'controller' => 'profiles',
				'action' => 'index',
				'admin' => false,
				'?' => 'success=success'
			));
		}	
	}			
}else if($this->Auth->user('account_type')==2) {
	$url = $html->url(array(
		'controller' => 'table',
		'action' => 'index',
		'admin' => true
	));
}else{
	$url = $html->url(array(
		'controller' => 'restaurants',
		'action' => 'index',
		'super' => true,
		'admin' => false
	));
} 
endif;
?>	
<script type="text/javascript">
	window.parent.location.href="<?php echo $url; ?>";
</script>								