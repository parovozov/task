<?php 
class MainController
{
	private $model;
	private $view;
	function __construct()
	{
		$this->model = new MainModel();
		$this->view = new MainView($this->model);
		
		if($this->model->IsAdmin())
			$this->view->logoutlink();
		else $this->view->loginlink();
		
		if(!empty($_POST['checkid'])){
			$this->model->EditConfirm($_POST['checkid']);
		}
		elseif(!empty($_POST)){
			$chekdata = $this->model->ValidErrorField($_POST);
			$flagerror=false;
			foreach($chekdata as $val){
				if(in_array(true, $val, true)) { 
					$flagerror=true;
					break;
				}
			}
			if(!$flagerror) $this->model->AddTask($chekdata);
			$this->view->SetVarError($chekdata, $flagerror);
		}
		
		$sort='';
		if(!empty($_GET['orderasc']) || !empty($_GET['orderdesc'])){
			$sort= $this->model->SortOrder();
		}
		
		//пагинация
		$paginator = $this->model->pagin();
		$this->view->Paginator($paginator);
		$startdb = $this->model->GetStartDb(); // элемент с которого начинается выборка из бд		
		
		$row = $this->model->FetchObj($sort, $startdb);
		$this->view->SetFethDb( $row );
		$this->view->show();

		//$limit — количество записей на страницу
		//$count_all — общее количество записей
		//$page_num — номер страницы на которой находится пользователь
		
	}
	
}

?>