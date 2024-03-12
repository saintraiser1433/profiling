<?php
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;
	$document = new Dompdf();

	

	include 'connection.php';
	if(isset($_GET['pdf'])){
        
    $get = $_GET['pdf'];
     $me = "1";
    $queryb = "UPDATE clearance SET status='$me' where id='$get'";
    $stmtb = $conn -> prepare($queryb);
    $stmtb -> execute();
    $sqls = "SELECT * FROM official where position ='Barangay Captain'";
    $stmt = $conn -> prepare($sqls);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $rows = $result -> fetch_assoc();

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
	<center><h1 style='font-family:Arial;'>CERTIFICATE OF INDIGENCY</h1></center>
	<br>
	<br>
	<p style='font-family:arial;'><b>TO WHOM IT MAY CONCERN:</b></p><br>
	<p style='text-indent:30px'>This is to certify that Mr/Ms: <u><b>".$row['fullname']."</u></b> of legal,single/married/widow/widower.</p>
	<p style='font-family:arial; text-align:justify;'>Filipino is a resident of this Barangay Poblacion, Polomolok South Cotabato is one of the indigents in our</p>
	<p style='font-family:arial; text-align:justify;'>barangay. </p>
	<p style='font-family:arial; text-align:justify;'>This certication is being issued upon the request of the above-named person for whatever legal purpose it may serve him best.</p>
	<p style='font-family:arial; text-align:justify;'>Issued this <b><u>".$row['date_issued']."</b></u> at the Office of Punong Barangay, Barangay Poblacion, Polomolok, South, Cotabato, Philippines. </p>
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