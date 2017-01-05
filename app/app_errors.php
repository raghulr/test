<?php class AppError extends ErrorHandler {
    function error404($params) {
        // redirect to homepage
		 
      
		
$this->controller->redirect(array(
        'controller' => 'pages', 'action' => 'error', 'city' => 'university-of-illinois'));
	 
    }
}
?>