<?php 
$createtable = '
CREATE TABLE `test`.`tasks` ( 
`id` INT NOT NULL AUTO_INCREMENT , 
`task` TEXT NOT NULL , 
`name` VARCHAR(255) NOT NULL , 
`email` VARCHAR(255) NOT NULL , 
`confirm` TINYINT NOT NULL , 
`edit` TINYINT NOT NULL , 
PRIMARY KEY (`id`)) 
ENGINE = InnoDB DEFAULT CHARSET=utf8;';

$createtable2 ="CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `hsh` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

require_once('baseclass.php');
require_once('model.php');
require_once('view.php');
require_once('control.php');

$db= new Database();

//права на код данного роутера принадлежат его владельцу
if(isset($_GET['action']))
{
	require_once('/'.$_GET['action'].'/'.'model.php');
	require_once('/'.$_GET['action'].'/'.'view.php');
	require_once('/'.$_GET['action'].'/'.'control.php');
	$classname=$_GET['action']."Controller";
	$obj=new $classname();
}
else{
	$obj= new MainController();
}




?>