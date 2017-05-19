<?php 
//program write by Mustaque Ahemmed
	session_start();
	if (!isset($_SESSION['user'])) {
		header('location:index.php');
	}
	$todaydate=date('Y-m-d');
	$pfee=$pdiscount=$padvance=$pfinalcost=$totaldue=0;
	$pname='Null';
	$paddress=$pphone=$pdocname=$done="";
	if ($_SERVER["REQUEST_METHOD"]=="POST") {
		$thisdate=$_POST['thisdate'];
		$pdate=$_POST['date'];
		$pname=$_POST['name'];
		$paddress=$_POST['address'];
		$pphone=$_POST['phone'];
		$ptestname=$_POST['testname'];
		$pdocname=$_POST['docname'];
		$pfee=$_POST['fee'];
		$pdiscount=$_POST['discount'];
		$padvance=$_POST['advance'];

		function afterdiscount(){
			$add=($_POST['fee']*$_POST['discount'])/100;
			$value=$_POST['fee']-$add;
			return $value;
		}
		$pfinalcost=afterdiscount();
		$totaldue=$pfinalcost-$padvance;

		$feedevide=$pfee/3;
		$add=($_POST['fee']*$_POST['discount'])/100;
		$feefordoc=$feedevide-$add;

		include 'config.php';
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$sql="INSERT INTO registerMember (thisdate,date,name,address,phone,testname,docname,fee,discount,finalcost,advance,due) VALUES ('$thisdate','$pdate','$pname','$paddress','$pphone','$ptestname','$pdocname','$pfee','$pdiscount','$pfinalcost','$padvance','$totaldue')";
		if (mysqli_query($conn, $sql)) {
                
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        $sqlforgetid=mysqli_query($conn,"SELECT id from registerMember where name='$pname'and phone='$pphone' and address='$paddress' and thisdate = '$thisdate' and testname ='$ptestname' and docname='$pdocname' and fee = '$pfee' and discount ='$pdiscount' and advance = '$padvance'");
        // $rowccc=mysqli_num_rows($sqlforgetid);
        // echo $rowccc;die;
        $getidfforthisinsert=mysqli_fetch_assoc($sqlforgetid);
        $finalid=$getidfforthisinsert['id'];
        $sqlforincome="INSERT INTO income (id,thisdate,name,address,phone,docname,fee,discount,docget,hosget,labget) VALUES ('$finalid','$thisdate','$pname','$paddress','$pphone','$pdocname','$pfee','$pdiscount','$feefordoc','$feedevide','$feedevide')";
		if (mysqli_query($conn, $sqlforincome)) {
           
            } else {
                echo "Error: " . $sqlforincome . "<br>" . mysqli_error($conn);
            }
            $done="Successfully Done!!";
         $conn->close();
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 	<link rel="stylesheet" href="main.css">
 	<style>
 	*{
 		margin: 0;
 		padding: 0;
 	}
 		#entryform{
 			margin: 0 auto;
 		}
 		.formcon{
			width: 100%;
 		}
 		.formconinside{
 			display: flex;
 			width:100%;
 			margin: 0 auto;
 			flex-wrap: wrap;
 		}
 		input[type="Date"] {
    		width: 100%;
		}
		input[type="text"] {
		    min-width: 340px;
		    margin: 5px 0;
		    padding: 4px 0;
		}
		textarea {
		    width: 100%;
		    height: 50px;
		    /* border: 2px solid #03A9F4; */
		}
		input[type="date"] {
		    width: 100%;
		    padding: 4px 0;
		}
		input[type="Phone"] {
		    width: 100%;
		    padding: 5px 0;
		}
		select {
		    width: 100;
		    width: 40%;
		    padding: 5px 0;
		}
		input[type="submit"] {
		    width: 48%;
		    padding: 10px 0;
		    background: #04e894;
		}
		input[type="reset"] {
		    width: 48%;
		    padding: 10px;
		    background: #ff5c5c;
		}
		  input[type="text"]:hover{
	        border: 2px solid #03eaa0;
	      }
	      input[type="Date"]:hover{
	        border: 2px solid #03eaa0;
	      }
	      textarea:hover{
	      	border: 2px solid #03eaa0;
	      }
	      input[type="Phone"]:hover{
	      	border: 2px solid #03eaa0;
	      }
	      select:hover{
			border: 2px solid #03eaa0;
	      }

		/*input[type="Date"], 
		input[type="text"] ,
		textarea ,
		input[type="Phone"] :hover{
			border: 1.5px solid blue;
		}*/
		.showercon{
			width: 100%;
			display: flex;
		}
 		.shower{
 			margin: 0 auto;
 		}
 	</style>
 </head>
	 <body style="background-color: #f1ecb5;">
	 	<nav class="nav">
	 		<div class="navitems">
		 		<ul>
		 			<a href="mainpage.php"><li>Entry</li></a>
		 			<a href="member.php"><li>All patient</li></a>
		 			<a href="onemonthmember.php"><li>Current patient</li></a>
		 			<a href="separatetotal.php"><li>ALL Profit</li></a>
		 			<a href="onemonthseparatetotal.php"><li>Current Profit</li></a>
		 			<a href="logout.php"><li>Logout</li></a>
		 			<a href="specificdoctor.php"><li>OTHER</li></a>

	 			</ul>
	 		</div>
	 	</nav>

	 	
	 	<h1 style="margin: 0;padding: 0;text-align: center;color: red;">HELLO! PROFIT CALCO</h1>
	 	<h3 style="margin: 0;padding: 0;text-align: center;color: red;">Patient Details</h3>
	 	<h2 style="margin: 0;padding: 0;text-align: center;color: green;"><?php echo $done; ?></h2><br>

	<div class="formcon">
		<div class="formconinside">
		 	<form id="entryform" action="" method="post">
		 		<table>
		 			<tr>
			 			<td><input type="hidden" name="thisdate" value="<?php echo $todaydate; ?>"></td>
			 		</tr>
		 			<tr>
			 			<td>Date: </td>
			 			<td><input type="Date" name="date" required></td>
			 		</tr>
			 		<tr>
			 			<td>Name: </td>
			 			<td><input type="text" name="name" required></td>
			 		</tr>
			 		<tr>
			 			<td>Address: </td>
			 			<td><textarea  name="address"  required></textarea></td>
			 		</tr>
			 		<tr>
			 			<td>Phone Number: </td>
			 			<td><input type="Phone"  name="phone" required></td>
			 		</tr>
			 		<tr>
			 			<td>Test name: </td>
			 			<td><input type="text" name="testname" required></td>
			 		</tr>
			 		<tr>
			 			<td>Doctor Name: </td>
			 			<td>
			 				<input type="text" name="docname">
			 			</td>
			 		</tr>
			 		<tr>
			 			<td>FEE: </td>
			 			<td><input type="text" name="fee"></td>
			 		</tr>
			 		<tr>
			 			<td>Discount: </td>
			 			<td><input type="text" name="discount"></td>
			 		</tr>
			 		<tr>
			 			<td>Advance: </td>
			 			<td><input type="text" name="advance"></td>
			 		</tr>
			 		
			 		<tr>
			 			<td></td>
			 			<td><input type="submit" name="submit" value="submit">
			 			<input type="reset" name="reset"></td>
			 		</tr>
		 		</table>
		 	</form>
		 </div><br>
		 <div class="showercon">
			 <div class="shower">
			    <h2 style="color: #5c8fde;">Quick look your most resent entry..</h2>
			 	<table>
			 		<tr>
				 		<td>NAME: </td>
				 		<td><input type="text" name="show" value="<?php echo $pname; ?>"></td>
				 	</tr>
				 	<tr>
				 		<td>TOTAL FEE: </td>
				 		<td><input type="text" name="show" value="<?php echo $pfee; ?>"></td>
				 	</tr>
				 	<tr>
				 		<td>DISCOUNT: </td>
				 		<td><input type="text" name="show" value="<?php echo $pdiscount; ?>"></td>
				 	</tr>
				 	<tr>
				 		<td>FINALCOST: </td>
				 		<td><input type="text" name="show" value="<?php echo $pfinalcost ;?>"</td>
				 	</tr>
			 		<tr>
				 		<td>ADVANCE: </td>
				 		<td><input type="text" name="show" value="<?php echo $padvance; ?>"></td>
				 	</tr>
			 		<tr>
				 		<td>DUE: </td>
				 		<td><input type="text" name="show" value="<?php echo $totaldue; ?>"></td>
				 	</tr><br>
				 	</table>
				 </div>
			 </div>
	</div>
	<br>
    <div class="footer" style="color: black;width: 100%;display: flex;">
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