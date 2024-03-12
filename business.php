<?php
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;
	$document = new Dompdf();

	

	include 'connection.php';
	if(isset($_GET['pdf'])){
    $sqls = "SELECT * FROM official where position ='Barangay Captain'";
    $stmt = $conn -> prepare($sqls);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $rows = $result -> fetch_assoc();
    
    $get = $_GET['pdf'];
     $me = "1";
    $queryb = "UPDATE clearance SET status='$me' where id='$get'";
    $stmtb = $conn -> prepare($queryb);
    $stmtb -> execute();
	$querys = "SELECT * from clearance where id='$get'";
    $stmts = $conn -> prepare($querys);
    $stmts -> execute();
    $results = $stmts -> get_result();
    $row = $results -> fetch_assoc();
	}	
	$output = "
	
	<img src='img/logo/polomolok.png' width='100px;' height='100px;'>

	<img src='img/logo/polomolok2.png' width='100px;' height='100px;' style='margin-left: 67%;'>
	<div style='margin-top:-130px; text-align:center; font-family:arial;'>
	<h6>REPUBLIC OF THE PHILIPPINES</h6>
	<h6 style='margin-top:-20px;'>PROVINCE OF SOUTH COTABATO</h6>
	<h6 style='margin-top:-20px;'>MUNICIPALITY OF POLOMOLOK</h6>
	<h6 style='margin-top:-20px;'>BARANGAY POBLACION</h6>
	</div>
	<center><h1 style='font-family:Arial; color:#eb3349;'>BARANGAY BUSINESS CLEARANCE</h1></center>
	<br>
	<center><p>This certifies that</p></center>
	<div style='border:2px solid gray; text-align:center; font-size:24px;'>
	<p><b>".$row['fullname']."</b><p>
	</div>
	<center><p>with registered trade name</p></center>
	<div style='border:2px solid gray; text-align:center; font-size:24px;'>
	<p style='font-size:24px'><b>".$row['bname']."</b><p>
	</div>
	<center><p>with registered address at</p></center>
	<div style='border:2px solid gray; text-align:center; font-size:24px;'>
	<p style='font-size:24px'><b>".$row['address']."</b><p>
	</div>
	<center><p>Date Issued</p></center>
	<div style='border:2px solid gray; text-align:center; font-size:24px;'>
	<p style='font-size:24px'><b>".$row['date_issued']."</b><p>
	</div>
	<center><p>has been granted a Barangay Clearance to operate the above-mentioned business under. The Local Government Code of 1991 and the Ease of Doing Business Act(RA 11032) subject to the provision of other pertinent laws, ordinance and related administrative regulations.</p></center>
	<br><br> <br> <br>
	<div style='margin-left:62%;'>
	<p style='font-family:Arial; margin-left:20px;'><b><u>".$rows['firstname']." ".$rows['middlename']." ".$rows['lastname']."</b></u></p>
	<p style='font-family:Arial; margin-left:65px; margin-top:-10px;'><b>Barangay Captain</b></p>
	</div>




	";	

	$document->loadHtml($output);

	$document->setPaper('A4','portrait');
	$document->render();
	$document->stream("barangay",array("Attachment"=>0));
 ?>