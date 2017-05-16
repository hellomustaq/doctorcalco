<?php 
	session_start();

	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}else{
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		$_SESSION['tempid']=$_POST['idpass'];
		$_SESSION['tempad']=$_POST['advancepass'];
		//program write by Mustaque Ahemmed
		$_SESSION['tempdue']=$_POST['duepass'];
		header('location:updatebill.php');
	}
}
 ?>