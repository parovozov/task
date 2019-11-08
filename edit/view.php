<?php
class EditView extends MainView
{
	function show()
	{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="edit/style.css" type="text/css" />
<script src="edit/script.js" type="text/javascript"></script>
<title>Таск менеджер</title>
</head>
<body>
<?php $this->showlist(); 
	}
	
	function showlist()
	{
		$id="";
		$name="";
		$email="";
		$task="";
		if(!empty($this->row))
		{
			$id=$this->row['id'];
			$name=$this->row['name'];
			$email=$this->row['email'];
			$task=$this->row['task'];
			$old=$task;
		}
		
		
		$errname='';
		$erremail='';
		$errtask='';
		if($this->error)
		{
			$id=$_POST['id'];
			$name=$_POST['name'];
			$email=$_POST['email'];
			$task=$_POST['task'];
			$old=$_POST['old'];
			
			
			foreach ($this->varerror as $key => $val){
				if(!$val['error']) continue;
				switch ($key){
					case 'name' : $errname='class="error"';  break;
					case 'email' : $erremail='class="error"'; break;
					case 'task' : $errtask='class="error"'; break;
				}
			}
		}
		echo "<h2>Редактировать задачу</h2>
		<form method='POST' name='formadd'>
		<div class='baseadddiv'>
		<div><input type='text' value='{$name}' placeholder='Имя' name='name' {$errname}></div>
		<div><input type='email' value='{$email}' placeholder='email' name='email' {$erremail}></div>
		<div><textarea name='task' placeholder='Задача' $errtask>{$task}</textarea></div>
		<input type='hidden' name='id' value='{$id}'>
		<input type='hidden' name='old' value='{$old}'>
		</div>
		<button type='submit'>Изменить</button>
		</form>";
	}
}
?>
		</body>
</html>