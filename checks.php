<?php include 'connection.php'?>

<?php

		if(isset($_POST['user_name'])){
			$me = $_POST['user_name'];
			$sql2 = "SELECT COUNT(position) as totals from official where position='Barangay Kagawad'";
			$stmts = $conn-> prepare($sql2);
			  $stmts -> execute();
   			 $results = $stmts -> get_result();
   			 $row = $results -> fetch_assoc(); 
   			
			$sql = "SELECT * from official where position ='$me'";
				$stmt = $conn-> prepare($sql);
			  $stmt -> execute();
   			 $result = $stmt -> get_result();
   			 $rows = $result -> fetch_assoc(); 
   			 if($rows['position'] == 'Barangay Chairman'){
   			 	echo '<span class="text-danger">Not Available</span>';
   			 }else if($rows['position'] == 'SK Chairman') {
   			 	echo '<span class="text-danger">Not Available</span>';
   			 
   			}else if($rows['position'] == 'Barangay Secretary') {
   			 	echo '<span class="text-danger">Not Available</span>';
   			 
   			 }else if($rows['position'] == 'Barangay Treasurer') {
   			 	echo '<span class="text-danger">Not Available</span>';
   			 }else if($row['totals'] == 7){
   			 	echo '<span class="text-danger">Not Available</span>';
   			 }else{
   			 	echo "<span class='text-success'>Available</span>";
   			 }

	    	}











 ?>