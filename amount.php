<?php include 'connection.php'; ?>
<?php

		$input = $_GET['in'];
		$query = "SELECT * FROM certificate where certificate='$input'";
        $stmt = $conn-> prepare($query);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc(); 


 ?>

    <?php
    if($input == 'Business Clearance'){
        echo '<div class="form-group">
            <label for="exampleInputPassword1">Business Name</label>
            <input type="text" class="form-control" id="nameb" name="nameb">
            </div>
            <div class="form-group">
            <label for="exampleInputPassword1">Amount</label>
            <input type="text" class="form-control" id="amounts" name="amountsf" readonly="readonly" value='.$row['amount'].'>
          </div>
          
';
    }else{
        echo '<div class="form-group">
            <input type="hidden" class="form-control" id="nameb" name="nameb">
            <label for="exampleInputPassword1">Amount</label>
            <input type="text" class="form-control" id="amounts" name="amountsf" readonly="readonly" value='.$row['amount'].'>
          </div>
        


          ';

    }


     ?>
  


         