<?php 
class LoginModel
{
	protected $db;
	function __construct(){
		$this->db = Database::$pdo;
	}
	function VarifyUser($postdata)
	{
		$login= $postdata['login'];
		$pass= $postdata['pass'];
		$sql = "SELECT * FROM user WHERE login='{$login}' AND pass='{$pass}'";
		$fetch = $this->db->prepare($sql);
		$fetch->execute();
		$res = $fetch->fetch(PDO::FETCH_ASSOC);
		if(empty($res)) return false;
		else return true;
	}
	function LoginUser()
	{
		session_start();
		$_SESSION['authorized']='yes';
		header("Location: /");
	}
	function LogoutUser()
	{
		session_start();
		unset($_SESSION['authorized']);
		header("Location: /");
		//session_unregister('authorized');
	}
	function IsLogin()
	{
		session_start();
		if(isset($_SESSION['authorized']) && $_SESSION['authorized']=='yes')
			return true;
		else return false;
	}

}
?>