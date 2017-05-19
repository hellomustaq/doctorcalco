<?php 
    $ddname="";
	if ($_SERVER["REQUEST_METHOD"]=="POST") {
		$ddname=$_POST['searchdoc'];
	
	include 'config.php';

	function docrow($name){
		global $conn;
		$sqlquery=mysqli_query($conn,"SELECT id,name,docname,discount,docget from income where docname='$name'");
		$countrow=mysqli_num_rows($sqlquery);
		return $countrow;
	}
	echo docrow('D1')."<br>";
	echo docrow('$ddname');
	if (isset(var)) {
		echo "ok";
	}elseif (isset(var)) {
		echo "string";
	}else{
		echo "string";
	}
}
 ?>