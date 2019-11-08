<?php 
class MainModel
{
	protected $db;
	private $fitch;
	protected $checkarray;
	const LIMIT=3; // количество строк на странице
	private $startdb;// элемент с которого начинается выборка из бд
	protected $isadmin;
	function __construct(){
		$this->db = Database::$pdo;
	}
	function FetchObj($order=null, $startdb=null){
		$order = (is_null($order)) ? 'ORDER BY id' : $order;
		$startdb = (is_null($startdb)) ? '' : ' LIMIT '.$startdb.', '.self::LIMIT;
		$fitch = $this->db->prepare('SELECT * FROM tasks '.$order.$startdb);
		$fitch->execute();
		return  $fitch->fetchAll(PDO::FETCH_ASSOC);
	}
	function ValidErrorField(array $posdata){
		$this->checkarray=array();
		$this->checkarray['name']['dat']=htmlspecialchars(trim($posdata['name']));
		$this->checkarray['name']['error']=(empty($this->checkarray['name']['dat'])) ? true : false;
		$this->checkarray['email']['dat'] = trim($posdata['email']);
		$this->checkarray['email']['error'] = (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/', $this->checkarray['email']['dat']))  ? true : false;
		$this->checkarray['task']['dat']=htmlspecialchars(trim($posdata['task']));
		$this->checkarray['task']['error']=(empty($this->checkarray['task']['dat'])) ? true : false;
		//var_dump($this->checkarray);
		return  $this->checkarray;
	}
	function AddTask() {
		try {
			$arr = array(
				$this->checkarray[ 'task' ][ 'dat' ],
				$this->checkarray[ 'name' ][ 'dat' ],
				$this->checkarray[ 'email' ][ 'dat' ] );

			$fitch = $this->db->prepare( "INSERT INTO tasks (task, name, email) VALUES (?,?,?)" );
			$fitch->execute( $arr );
		} catch ( PDOException $e ) {
			echo $e->getMessage();
		}

	}
	function ParceUrl($url=null){
		$url = (!is_null($url)) ? $url : $_SERVER['REQUEST_URI'];
		$pos = strpos($url, '?');
		$parseurl=array();
		if ( $pos !== false ) {
			$url = substr( $url, $pos + 1 );
			if ( strpos($url, '=') !== false ) {
				$urlexplode = explode( '&', $url );
				foreach ( $urlexplode as $val ) {
					if ( strpos($val, '=') !== false ) {
						$urlkeyandval = explode( '=', $val );
						$parseurl[ $urlkeyandval[ 0 ] ] = $urlkeyandval[ 1 ];
					}
				}
			}
		}
		return $parseurl;
	}
	function AddToUrl(array $param, $url=null){
		$parceurlmas = $this->ParceUrl($url);
		foreach($param as $key => $val)
		{
			$parceurlmas[$key] = $val;
		}
		return $this->MakeUrlFromParam($parceurlmas);
	}
	function ExcludeFromUrl(array $param, $url=null){
		$parceurlmas = $this->ParceUrl($url);
		foreach($param as $val)
		{
			if(array_key_exists($val, $parceurlmas))
				unset($parceurlmas[$val]);
		}
		return $this->MakeUrlFromParam($parceurlmas);
	}
	function MakeUrlFromParam(array $param){
		$str="";
		foreach($param as $key => $val)
		{
			$str.= (empty($str)) ? $key.'='.$val : '&'.$key.'='.$val;
		}
		//$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
		if(!empty($str)) $str='?'.$str;
		return $str;
	}
	function pagin() {
		$fitch = $this->db->prepare( 'SELECT COUNT(*) cc FROM tasks' );
		$fitch->execute();
		$row = $fitch->fetch();
		$count_all = ( int )$row[ 'cc' ];
		$limit = self::LIMIT;
		$page_num = ( isset( $_GET[ 'page' ] ) ) ? $_GET[ 'page' ] : 1;
		$navi = new PaginateNavigationBuilder();
		$navi->spread = 4;
		$paginator = $navi->build( $limit, $count_all, $page_num );
		$this->SetStartDb( $navi->startdb ); // элемент с которого начинается выборка из бд
		return $paginator;
	}
	function SetStartDb($startdb){
		$this->startdb = $startdb;
	}
	function GetStartDb(){
		return $this->startdb;
	}
	function SortOrder(){
		$str='';
		if(!empty($_GET['orderasc'])){
			$name=$_GET['orderasc'];
			$str='ORDER BY '.$name.' ASC';
		}
		if(!empty($_GET['orderdesc'])){
			$name=$_GET['orderdesc'];
			$str= 'ORDER BY '.$name.' DESC';
		}
		return $str;
	}
	function EditConfirm($id)
	{
		$fitch = $this->db->prepare("UPDATE tasks SET confirm='1' WHERE id='{$id}'");
		$fitch->execute();
	}
	function IsAdmin()
	{
		session_start();
		if(isset($_SESSION['authorized']) && $_SESSION['authorized']=='yes')
			return $this->isadmin=true;
		else return $this->isadmin=false;
	}
	function IsLogin()
	{
		return $this->isadmin;
	}
}
?>