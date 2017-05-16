<?php 
	session_start();
	$getid=$_SESSION['tempid'];
	$getadvance=$_SESSION['tempad'];
	//echo "$getid";
	//program write by Mustaque Ahemmed
	if ($_SERVER['REQUEST_METHOD']=="POST") {
	$updatedAdvance=$_POST['new']+$getadvance;
	$updatedue=$_SESSION['tempdue']-$_POST['new'];
	include 'config.php';
	if (!$conn) {
		echo "connection fail";
	}
	$sql="UPDATE registermember SET advance='$updatedAdvance',due='$updatedue' where id='$getid'";
	echo "$sql";
	$sqlquery=mysqli_query($conn,$sql);
	if (!$sqlquery) {
		echo "error" .$sqlquery. "<br>" . mysqli_error($conn);
	}
	header('location:member.php');
	}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" href="main.css">
 </head>
 <body>
 	<form action="" method="post">
 		<input type="text" name="new" placeholder="<?php echo $getadvance; ?>">
 		<input type="submit" name="submit" value="update bill">
 	</form>
 </body>
 </html>