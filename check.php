<?php include 'connection.php'?>

<?php

		if(isset($_POST['user_name'])){
			$me = $_POST['user_name'];
	
			$sql = "SELECT * from blotter where fullname ='$me'";
				$stmt = $conn-> prepare($sql);
			  $stmt -> execute();
   			 $result = $stmt -> get_result();
   			 $rows = $result -> fetch_assoc(); 
             if($me == $rows['fullname']){
               echo '<span class="text-danger">This resident have a record in barangay</span>';
             }else{
               echo '<span class="text-success">No record found</span>';
             }
   			 
}










 ?>