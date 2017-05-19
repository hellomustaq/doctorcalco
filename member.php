<?php 
//program write by Mustaque Ahemmed
	session_start();
	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}
	include 'config.php';
	if (!$conn) {
		die ("connection error" . mysql_connect_error());
	}
	$sql="SELECT * FROM registerMember";
	$sqlquery=mysqli_query($conn,$sql);
	$countrow=mysqli_num_rows($sqlquery);

	function calculatetotal($colomn){
		global $conn;
		$sqlfortotal="SELECT SUM($colomn) as totalsum FROM registerMember";
		$sqlquery1=mysqli_query($conn,$sqlfortotal);
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
                        <th style="background-color: #82ffa2" colspan="14" scope="col" class="text-center success">ALL PATIENT</th>
                    </tr>
                    <tr style="background-color: #89f1e2">
                        <th class="text-center info">ID</th>
                        <th class="text-center info">DATE</th>
                        <th class="text-center info">NAME</th>
                        <th class="text-center info">ADDRESS</th>
                        <th class="text-center info">PHONE</th>
                        <th class="text-center info">TEST NAME</th>
                        <th class="text-center info">DOCNAME</th>
                        <th class="text-center info">FEE</th>
                        <th class="text-center info">DISCOUNT</th>
                        <th class="text-center info">FINALCOST</th>
                        <th class="text-center info">ADVANCE</th>
                        <th class="text-center info">DUE</th>
                        <th></th>
                    </tr>
                    <tr>
 <?php
    if ($countrow>0) {
		while ($counter=mysqli_fetch_array($sqlquery)) {
            ?>
            <tr>
                <td><?php echo $counter['id']; ?></td> 
                <td><?php echo $counter['date']; ?></td> 
                <td><?php echo $counter['name']; ?></td> 
                <td><?php echo $counter['address']; ?></td> 
                <td><?php echo $counter['phone']; ?></td>
                <td><?php echo $counter['testname']; ?></td> 
                <td><?php echo $counter['docname']; ?></td>
                <td><?php echo $counter['fee']; ?></td>
                <td><?php echo $counter['discount']; ?></td>
                <td style="background-color: #fff900"><?php echo $counter['finalcost']; ?></td>
                <td style="background-color: #5ccad0"><?php echo $counter['advance']; ?></td>
                <td style="background-color: #ff5959;color: white;"><?php echo $counter['due']; ?></td>
                <td style="text-align: center;">
					<form action="<?php 
						if ($counter['due']<=0) {
							echo "#";
						}else{
							echo "update.php";
							} ?>" method="post">

		                <input type="hidden" name="idpass" value="<?php echo $counter['id']; ?>">
		                <input type="hidden" name="advancepass" value="<?php echo $counter['advance']; ?>">
		                <input type="hidden" name="duepass" value="<?php echo $counter['due']; ?>">
		                <?php if ($counter['due']<=0) { ?>
                                       <input style="background-color: #03eaa0;padding: 4px 10px;border:0;" type="submit" name="edit" value="PAID">
                                    <?php }
                                     else{ ?>
                                    <input style="background-color: rgb(0, 55, 255);color: white;padding: 3px 7px;border-width: 3px;" type="submit" name="edit" value="EDIT">
                                    <?php
                                    }
                                    ?>
					</form>
                </td>
            </tr>
            <?php
            }
        }
        //mysqli_close($conn);
        ?>
                    </tr>
                    <tr style="background-color: #82ffa2">
		            	<th colspan="7" scope="col">TOTAL</th>
		            	<td><?php calculatetotal('fee');?></td>
		            	<td></td>
		            	<td><?php calculatetotal('finalcost') ?></td>
		            	<td><?php calculatetotal('advance') ?></td>
		            	<td><?php calculatetotal('due') ?></td>
		            	<td></td>
		            </tr>
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
