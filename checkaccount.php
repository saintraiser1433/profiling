<?php include 'connection.php'?>

<?php

		if(isset($_POST['user_name'])){
			$me = $_POST['user_name'];
			$sql = "SELECT * from account where username ='$me'";
			$result = mysqli_query($conn,$sql);


	    		if(mysqli_num_rows($result)>0){
	    			echo '<span class="text-danger">This username is not available</span>';
	    		} 
	    		else{
	    			echo "<span class='text-success'>Available</span>";
	    		}

		}











 ?>