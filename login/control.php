<?php
class LoginController
{
	private $model;
	private $view;
	
	function __construct()
	{
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
		if($this->model->IsLogin())
			$this->view ->logoutlink();
		
		if(isset($_GET['logout'])){
			$this->model->LogoutUser();
		}
		if(!empty($_POST)){
			if($this->model->VarifyUser($_POST)){
				$this->model->LoginUser();
			}
			else{
				echo '<h3>Такого пользоватлея не существует</h3>';
			}
		}
		$this->view->show();
	}

}

?>