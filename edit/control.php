<?php
class EditController extends MainController
{
	function __construct()
	{
		$this->model = new EditModel();
		$this->view = new EditView($this->model);		
		
		if(!$this->model->IsAdmin()){
			header("Location: /");
		}
		
		if(!empty($_POST)){
			$chekdata = $this->model->ValidErrorField($_POST);
			$chekdata['id']['dat']=$_POST['id'];
			$chekdata['id']['error']=false;
			$chekdata['old']['dat']=$_POST['old'];
			$chekdata['old']['error']=false;
			$flagerror=false;
			foreach($chekdata as $val){
				if(in_array(true, $val, true)) { 
					$flagerror=true;
					break;
				}
			}
			if(!$flagerror){
				$this->model->EditTask($chekdata);
				header("Location: /");
			} 
			$this->view->SetVarError($chekdata, $flagerror);
			//$row = $this->model->FetchObj($_GET['id']);
			//$this->view->SetFethDb( $row );
			$this->view->show();
		}
		elseif(!empty($_GET['id'])){
			$row = $this->model->FetchObj($_GET['id']);
			$this->view->SetFethDb( $row );
			$this->view->show();
		}
		else "Что пошло не так";
		
		
	}
}

?>