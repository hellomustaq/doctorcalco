<?php 
//program write by Mustaque Ahemmed
	$emptyuser=$emptypass=$error="";
	if ($_SERVER["REQUEST_METHOD"]=="POST") {
		if (empty($_POST['username']) or empty($_POST['password'])) {
			if (empty($_POST['username'])) {
				$emptyuser="username field empty";
			}
			else  {
				$emptypass="password required";
			}
		}else{
			$username=$_POST['username'];
			$password=$_POST['password'];
			include 'config.php';
			if (!$conn) {
           		 die("Connection failed: " . mysqli_connect_error());
        	}
			$sql="SELECT username,password from login where username='$username' and password='$password'";
			$sqlquery=mysqli_query($conn,$sql);
			$rowcount=mysqli_num_rows($sqlquery);
			if ($rowcount>0) {
				session_start();
				$_SESSION['user']=$_POST['username'];
				header('location:mainpage.php');
			}else{
				$error="Username or Password incorrect!";
			}
		}
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
	 	<title></title>
	 	<style>
	 	body {
			    background-color:#187677 ;
			}
	 		.container{
	 			width: 100%;
	 			display: flex;
	 			/*min-height: 570px;*/
	 			background-color: #187677;
	 		}
	 		.maincon{
	 			width:600px;
	 			max-height: 220px;
	 			margin: 0 auto;
	 			margin-top: 120px;
	 			background-color: white;
	 			border-radius: 10px;

	 		}
	 		.frm{

	 			margin-left: 100px;
	 		}
	 		input[type="text"] {
			    width: 250px;
			    padding: 8px 10px;
			    background-color: #2196F3;
			    color: white;
			    border-radius: 5px;
			}
			input[type="Password"] {
			    padding: 8px 10px;
			    background-color: #2196F3;
			    color: white;
			    width: 250px;
			    border-radius: 5px;
			}
			input#btn1 {
			    width: 274px;
			    padding: 5px;
			    font-size: larger;
			    background-color: #39de65;
			    border: 0;
			    border-radius: 5px;
			}
	 	</style>
 </head>
 <body style="min-height: 100%">
 	<div class="container">
		<div class="maincon">
			<div class="intro">
				<h1 style="margin: 0;padding: 0;text-align: center;color: #1ea743;">Welcome to Profit Calco </h1><br>
			</div>
			<div class="frm">
				<form action="" method="post">
					<table id="loginlayout">
						<tr>
							<td id="td1">Username: </td>
							<td id="td2"><input type="text" name="username" placeholder="enter username" > <?php echo $emptyuser; ?></td>
						</tr>
						<tr>
							<td id="td1">Password: </td>
							<td id="td2"><input type="Password" name="password" placeholder="enter password" > <?php echo $emptypass; ?></td>
						</tr>
						<tr>
							<td></td>
							<td><input id="btn1" type="submit" name="submit" value="Login"><br></td>
						</tr>
					</table>
					
				</form>
					<br>
					<?php echo $error; ?>
			</div>
		</div>
	</div>
	<br>
    <div class="footer" style="width: 100%;color: white; display: flex;position: fixed;bottom: 0px;">
        <div class="option" style="margin: 0 auto;">
            <span><address>All right reserve by-</address></span>
            <span>
                <address>Mustaque Ahemmed</address>
                <address>Hellomstq@yahoo.com</address>
            </span>
        </div>
    </div>
 </body>
 </html>