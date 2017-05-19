<?php 
//program write by Mustaque Ahemmed
	session_start();
	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}
	$check=$ddname="";
	if ($_SERVER["REQUEST_METHOD"]=="POST") {
		$ddname=$_POST['searchdoc'];
		if (isset($_POST['thismonth'])) {
			$check=$_POST['thismonth'];
		}
		$firstdate=date('Y-m-01');
   		$lastdate=date('Y-m-t');
	
		include 'config.php';

		function docrow($name){
			global $conn;
			$sqlquery=mysqli_query($conn,"SELECT * from income where docname='$name'");
			$countrow=mysqli_num_rows($sqlquery);
			return $countrow;
		}
		function docidentifier($name){
			global $conn;
			$sqlquery=mysqli_query($conn,"SELECT * from income where docname='$name'");
			return $sqlquery;
		}
		$docrowvar=docrow($ddname);
		$docidentifier1=docidentifier($ddname);
		function sumcalco($name){
			global $conn;
			$sqlquery=mysqli_query($conn,"SELECT SUM(docget) as 'totalsum' from income where docname='$name'");
			$sqlfatch=mysqli_fetch_array($sqlquery);
			echo $sqlfatch['totalsum'];
		}
		$sqlforthismonth=mysqli_query($conn,"SELECT * from income where docname='$ddname' and thisdate between '$firstdate' and '$lastdate'");
		$rowcountforthismonth=mysqli_num_rows($sqlforthismonth);
		//echo $rowcountforthismonth;die;
	}
 ?>
 <!DOCTYPE html>
 <html>
	 <head>
	 	<title></title>
	 	<link rel="stylesheet" href="main.css">
	 	<style>
	 		input[type="text"]:hover{
	        border: 3px solid #03eaa0;
	      }
	 	</style>
	 </head>
	 <body>
 		<nav class="nav" style="margin: -8px;padding: 8px;">
	 		<div class="navitems">
		 		<ul>
		 			<a href="mainpage.php"><li>Entry</li></a>
		 			<a href="member.php"><li>All patient</li></a>
		 			<a href="onemonthmember.php"><li>Current patient</li></a>
		 			<a href="separatetotal.php"><li>ALL Profit</li></a>
		 			<a href="onemonthseparatetotal.php"><li>Current Profit</li></a>
		 			<a href="logout.php"><li>Logout</li></a>
	 			</ul>
	 		</div>
	 	</nav><br>
	 	<div class="searchdoc" style="width: 100%;display: flex;">
	 		<form action="" method="post" style="margin: 0 auto;">
	 			<table>
	 				<tr>
	 					<td><input style="width: 300px;margin: 5px 0;padding: 4px 0;" type="text" name="searchdoc" placeholder="Search Doctor"></td>
	 					<td><input type="checkbox" value="thismonth" name="thismonth">Only current month</td>
	 					<td><input style="width: 100px;padding: 4px 0;background: #04e894;" type="submit" name="submit" value="Search"></td>
	 				</tr>
	 			</table>
	 		</form>
	 	</div><br>
	 	<div class="container">
        <div class="admin_area">
            <form action="" method="post">
                <table width="100%" border="1" cellpadding="5" cellspacing="0" class="table table-bordered table-hover table-striped table-condensed">
                    <tr>
                        <th style="background-color: #82ffa2" colspan="12" scope="col" class="text-center success">DOCTOR TOTAL ( <?php echo $ddname; ?> )</th>	
                    </tr>
                    <tr style="background-color: #89f1e2">
                        <th class="text-center info">PATIENT ID</th>
                        <th class="text-center info">PATIENT NAME</th>
                        <th class="text-center info">DOCNAME</th>
                        <th class="text-center info">DISCOUNT</th>
                        <th class="text-center info">DOCTOR GET</th>
                    </tr>
                   
 <?php
	 if(isset($_POST['submit']) and isset($_POST['thismonth'])){
		if ($rowcountforthismonth>=0) {
			while ($counter=mysqli_fetch_array($sqlforthismonth)) {
	            ?>
	            <tr>
	                <td><?php echo $counter['id']; ?></td> 
	                <td><?php echo $counter['name']; ?></td>
	                <td><?php echo $counter['docname']; ?></td>
	                <td><?php echo $counter['discount']; ?></td>
	                <td><?php echo $counter['docget']; ?></td>
	            </tr>
	            <?php
	        }
	    }
	}
	 elseif(isset($_POST['submit'])) {
	    if ($docrowvar>=0) {
			while ($counter=mysqli_fetch_array($docidentifier1)) {
	            ?>
	            <tr>
	                <td><?php echo $counter['id']; ?></td> 
	                <td><?php echo $counter['name']; ?></td>
	                <td><?php echo $counter['docname']; ?></td>
	                <td><?php echo $counter['discount']; ?></td>
	                <td><?php echo $counter['docget']; ?></td>
	            </tr>
	            <?php
	        }
	    }

	}

	
        
?>
        	<tr style="background-color: #82ffa2">
        		<td colspan="4" style="text-align: center;">Total</td>
        		<td><?php if (isset($_POST['submit'])) {sumcalco($ddname);}?></td>
        	</tr>
        	<?php if (isset($_POST['submit'])) {mysqli_close($conn);} ?>
        </table>
        </form>
        </div>
        </div>
        <br>
    <div class="footer" style="background-color:  white;color: black;width: 100%;display: flex;">
        <div class="option" style="margin: 0 auto; top: 50%;">
            <span><address>All right reserve by-</address></span>
            <span>
                <address>Mustaque Ahemmed</address>
                <address>Hellomstq@yahoo.com</address>
            </span>
        </div>
    </div>
	 </body>
 </html>