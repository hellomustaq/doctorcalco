<?php 
	session_start();
	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}
    echo $currentdate=date('d-m-Y');
    echo $firstdate=date('Y-m-01');
     echo $lastdate=date('Y-m-t');

	include 'config.php';
	if (!$conn) {
		die ("connection error" . mysql_connect_error());
	}

	$sqlone="SELECT * FROM registermember where thisdate between '$firstdate' and '$lastdate'";
	$sqlquery=mysqli_query($conn,$sqlone);
	echo $countrow=mysqli_num_rows($sqlquery);

	function calculatetotal($colomn){
		global $conn;
        global $firstdate;
        global $lastdate;
		$sqlfortotalone="SELECT SUM($colomn) as totalsum FROM registermember where thisdate between '$firstdate' and '$lastdate'";
		$sqlquery1=mysqli_query($conn,$sqlfortotalone);
		$onebyonefee=mysqli_fetch_assoc($sqlquery1);
		$sum=$onebyonefee['totalsum'];
		echo $sum;
	}

	?>

<!DOCTYPE html>
<html>
<head>
<style>
 		.nav>ul>a{
 			float: left;
 			padding: 10px;
 		}
 	</style>
</head>
<body>
<nav class="nav">
 		<ul>
 			<a href="mainpage.php"><li>home</li></a>
 			<a href="member.php" active><li>pataint</li></a>
            <a href="separatetotal.php"><li>Balance Survey</li></a>
 			<a href="logout.php"><li>Logout</li></a>
 		</ul>
 	</nav>
 	<div class="clear" style="clear: both;"></div>
<div class="container">
        <div class="admin_area">
            <form action="" method="post">
                <table width="800" border="1" cellpadding="5" cellspacing="0" class="table table-bordered table-hover table-striped table-condensed">
                    <tr>
                        <th colspan="10" scope="col" class="text-center success">TOTAL BALANCE SHEET</th>
                    </tr>
                    <tr>
                        <th class="text-center info">ID</th>
                        <th class="text-center info">NAME</th>
                        <th class="text-center info">ADDRESS</th>
                        <th class="text-center info">PHONE</th>
                        <th class="text-center info">DOCNAME</th>
                        <th class="text-center info">FEE</th>
                        <th class="text-center info">DISCOUNT</th>
                        <th style="background-color: #fff900" class="text-center info">DOC.AMOUNT</th>
                        <th style="background-color: #fff900" class="text-center info">HOS.AMOUNT</th>
                        <th style="background-color: #fff900" class="text-center info">LAB AMOUNT</th>
                    </tr>
                    <tr>
 <?php
    if ($countrow>0) {
		while ($counter=mysqli_fetch_array($sqlquery)) {   
            ?>
            <tr>
                <td><?php echo $counter['id']; ?></td> 
                <td><?php echo $counter['name']; ?></td> 
                <td><?php echo $counter['address']; ?></td> 
                <td><?php echo $counter['phone']; ?></td> 
                <td><?php echo $counter['docname']; ?></td>
                <td><?php echo $counter['fee']; ?></td>
                <td><?php echo $counter['discount']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['docget']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['hosget']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['labget']; ?></td>
            </tr>
            <?php
            }
        }
        
        ?>
                    </tr>
                    <tr><td colspan="10" scope="col"></td></tr>
                    <tr style="background-color: #82ffa2">
		            	<th colspan="5" scope="col">TOTAL</th>
		            	<td><?php //calculatetotal('fee');?></td>
                        <td></td>
		            	<td><?php //calculatetotal('docget') ?></td>
		            	<td><?php //calculatetotal('hosget') ?></td>
		            	<td><?php //calculatetotal('labget') ?></td>
		            </tr>
                </table>
            </form>
        </div>
        <?php mysqli_close($conn); ?>
    </div>
  </body>
</html>
