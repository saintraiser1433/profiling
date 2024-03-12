<?php  
	$conn = new mysqli("localhost","root","","profiling");
		if($conn === false )
{
	die("Error! Couldn't connect. ". $conn->connect_error );
}
?>



