<?php 
//program write by Mustaque Ahemmed
	session_start();
	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}
    $currentdate=date('M Y');
    $firstdate=date('Y-m-01');
    $lastdate=date('Y-m-t');

	include 'config.php';
	if (!$conn) {
		die ("connection error" . mysql_connect_error());
	}

	$sqlone="SELECT * FROM income where thisdate between '$firstdate' and '$lastdate'";
	$sqlquery=mysqli_query($conn,$sqlone);
	$countrow=mysqli_num_rows($sqlquery);
    //program write by Mustaque Ahemmed

	function calculatetotal($colomn){
		global $conn;
        global $firstdate;
        global $lastdate;
		$sqlfortotalone="SELECT SUM($colomn) as totalsum FROM income where thisdate between '$firstdate' and '$lastdate'";
		$sqlquery1=mysqli_query($conn,$sqlfortotalone);
		$onebyonefee=mysqli_fetch_assoc($sqlquery1);
		$sum=$onebyonefee['totalsum'];
		echo $sum;
	}

	?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="main.css">
<style>
    tr:hover{
        background-color: lightgray;
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
        </nav>
 	<div class="clear" style="clear: both;"></div><br><br>
<div class="container">
        <div class="admin_area">
            <form action="" method="post">
                <table width="100%" border="1" cellpadding="5" cellspacing="0" class="table table-bordered table-hover table-striped table-condensed">
                    <tr>
                        <th style="background-color: #82ffa2" colspan="10" scope="col" class="text-center success"><?php echo date('M Y')."...BALANCE SHEET" ?></th>
                    </tr>
                    <tr style="background-color: #89f1e2">
                        <th class="text-center info">ID</th>
                        <th class="text-center info">NAME</th>
                        <th class="text-center info">ADDRESS</th>
                        <th class="text-center info">PHONE</th>
                        <th class="text-center info">DOCNAME</th>
                        <th class="text-center info">FEE</th>
                        <th class="text-center info">DISCOUNT</th>
                        <th class="text-center info">DOC.AMOUNT</th>
                        <th class="text-center info">HOS.AMOUNT</th>
                        <th class="text-center info">LAB AMOUNT</th>
                    </tr>
                    <tr>
 <?php
    if ($countrow>0) {
		while ($counter=mysqli_fetch_array($sqlquery)) {   
            ?>
            <tr>
                <td><?php echo $counter['id'];$currentid=$counter['id']; ?></td> 
                <td><?php echo $counter['name']; ?></td> 
                <td><?php echo $counter['address']; ?></td> 
                <td><?php echo $counter['phone']; ?></td>
                <td><?php echo $counter['docname']; ?></td>
                <td><?php echo $counter['fee']; ?></td>
                <td><?php echo $counter['discount']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['docget']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['hosget']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['labget']; ?></td>
                <?php 
                        $duechecker=mysqli_query($conn,"SELECT due from registermember where id='$currentid'");
                        $getdueamount=mysqli_fetch_assoc($duechecker);
                        $getdueamount['due'];
                        if ($getdueamount['due']>0) {
                            echo "<td style='background-color: rgba(255, 89, 89, 0.62)'>"."UNPAID";
                        }
                 ?>
            </tr>
            <?php
            }
        }
        
        ?>
                    </tr>
                    <tr><td colspan="10" scope="col"></td></tr>
                    <tr style="background-color: #82ffa2">
		            	<th colspan="5" scope="col">TOTAL</th>
		            	<td><?php calculatetotal('fee');?></td>
                        <td></td>
		            	<td><?php calculatetotal('docget') ?></td>
		            	<td><?php calculatetotal('hosget') ?></td>
		            	<td><?php calculatetotal('labget') ?></td>
		            </tr>
                </table>
            </form>
        </div>
        <?php mysqli_close($conn); ?>
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
