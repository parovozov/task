<?php
class MainView
{
	protected $row;
	protected $varerror;
	protected $error;
	protected $model;
	private $pagin;
	function __construct(MainModel $model=null)
	{
		$this->model = $model;
	}
	function SetFethDb(array $row=null)
	{
		$this->row=$row;
	}
	
	function SetVarError(array $arr,  $error)
	{
		$this->varerror=$arr;
		$this->error=$error;
	}
	function Paginator($paginator)
	{
		$this->pagin=$paginator;
	}
	function loginlink(){
		echo "<a href='?action=login' class='loginbutton'>Войти</a>";
	}
	function logoutlink(){
		echo "<a href='?action=login&logout=true' class='loginbutton'>Выйти</a>";
	}
	function show()
	{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="script.js" type="text/javascript"></script>
<title>Таск менеджер</title>
</head>
<body>
<?php $this->showlist(); 
	}
	
	function showlist()
	{
		if(!empty($this->row))
		{
			//echo $this->model->AddToUrl(array('key'=>'111', 'tatu'=>'222'), "page=2&key=111&tatu=222");
		//echo $this->model->ExcludeFromUrl(array('key'), "page=2&key=111&tatu=222");
			$url = $this->model->ExcludeFromUrl(array('orderdesc', 'orderasc'));
			
			$nameasc = $this->model->AddToUrl(array('orderasc'=>'name'), $url);
			$namedesc = $this->model->AddToUrl(array('orderdesc'=>'name'), $url);
			$emailasc = $this->model->AddToUrl(array('orderasc'=>'email'), $url);
			$emaildesc = $this->model->AddToUrl(array('orderdesc'=>'email'), $url);
			$confirmasc = $this->model->AddToUrl(array('orderasc'=>'confirm'), $url);
			$confirmdesc = $this->model->AddToUrl(array('orderdesc'=>'confirm'), $url);
			echo '<div class="trdiv headerrow">
			<div>Задача</div>
			<div>Имя <a href="'.$namedesc.'"><</a> <a href="'.$nameasc.'">></a></div>
			<div>Email <a href="'.$emaildesc.'"><</a> <a href="'.$emailasc.'">></a></div>
			<div>Подтверждено <a href="'.$confirmdesc.'"><</a> <a href="'.$confirmasc.'">></a></div>
			<div>Правлено</div>
			</div>';
			
			foreach($this->row as $val)
			{
				if($this->model->IsLogin()){
					$editlink="<a href='?action=edit&id={$val['id']}' class='aedit'>править</a>";
					$disable = ($val['confirm']=='1') ? "disabled checked" : "";
				}
				else {
					$editlink="";
					$disable = ($val['confirm']=='1') ? "disabled checked" : "disabled";
					 }
				
				$edit = ($val['edit']=='1') ? 'да' : 'нет';
				echo "<div class='trdiv taskrow'>
				<div>{$val['task']}</div>
				<div>{$val['name']}</div>
				<div>{$val['email']}</div>
				<div><input type='checkbox' {$disable} value='{$val['id']}'></div>
				<div>{$edit}{$editlink}</div>
				</div>";
			}
			echo "<form name='formcheck' method='POST' id='formcheck'><input type='hidden' name='checkid' id='hidechek'><form/>";
		}
		echo $this->pagin;
		$errname='';
		$erremail='';
		$errtask='';
		if($this->error)
		{
			foreach ($this->varerror as $key => $val){
				if(!$val['error']) continue;
				switch ($key){
					case 'name' : $errname='class="error"';  break;
					case 'email' : $erremail='class="error"'; break;
					case 'task' : $errtask='class="error"'; break;
				}
			}
		}
		echo "<h2>Добавить задачу</h2>
		<form method='POST' name='formadd'>
		<div class='baseadddiv'>
		<div><input type='text' value='' placeholder='Имя' name='name' {$errname}></div>
		<div><input type='email' value='' placeholder='email' name='email' {$erremail}></div>
		<div><textarea name='task' placeholder='Задача' $errtask></textarea></div>
		</div>
		<button type='submit'>Добавить</button>
		</form>";
	}
}
?>
	</body>
</html>