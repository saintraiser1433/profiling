<?php
	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;
	$document = new Dompdf();

	

	include 'connection.php';

	$output = "

	<center><h1>Evaluation Result</h1></center>














		";
	
	$document->loadHtml($output);

	$document->setPaper('A4','portrait');
	$document->render();
	$document->stream("Evaluation Result",array("Attachment"=>0));
 ?>