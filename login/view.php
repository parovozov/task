<?php
class LoginView
{
	function logoutlink(){
		echo "<a href='?action=login&logout=true' class='loginbutton'>Выйти</a>";
	}
	function show(){
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="login/style.css" type="text/css" />
<script src="login/script.js" type="text/javascript"></script>
<title>Таск менеджер</title>
</head>
<body>
	<?php $this->showlist();?>
</body>
</html>
	<?php
	}
	function showlist(){
		echo "<h2>Войти в таск менеджер</h2>
		<form method='POST' name='formlogin'>
		<div class='baseadddiv'>
		<div><input type='text' value='' placeholder='Логин' name='login'></div>
		<div><input type='password' value='' placeholder='пароль' name='pass'></div>
		</div>
		<button type='submit'>Войти</button>
		</form>";
	}
}
	?>